<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Admin extends Model
{

    use SearchableTrait;

    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'admins.id'       => 5,
            'admins.username' => 20,
            'admins.steamid'  => 40,
            'admins.note'     => 10,
        ],
    ];

    protected $fillable = ['username', 'steamid', 'flags', 'note'];
}
