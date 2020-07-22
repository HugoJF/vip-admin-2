<?php
/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 9/5/2019
 * Time: 12:37 AM
 */

namespace App\Services;

use App\Order;
use App\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Spatie\Searchable\Search;

class SearchService
{
    public function search(string $term)
	{
        $search = (new Search)
            ->registerModel(Order::class, 'id', 'steamid', 'starts_at', 'ends_at', 'synced_at', 'reference');

        if (auth()->user()->admin) {
            $search->registerModel(User::class, 'name', 'username', 'tradelink', 'steamid', 'email');
        }

        $result = $search->search($term);

        // Pluck Models from each type group
        $result = $result->groupByType()->mapWithKeys(function (Collection $items, $type) {
            return [$type => $items->pluck('searchable')];
        });

        // Filter Models that user should not be able to see
        $result = $result->mapWithKeys(function (Collection $items, $type) {
            return [$type => $items->filter(function ($model) use ($type) {
                return Gate::allows('search', $model);
            })];
        });

        return $result;
	}
}
