<?php
/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 8/25/2019
 * Time: 9:46 AM
 */

namespace App\Services;

use App\Product;

class ProductService
{
    public function store(array $values)
    {
        ($product = new Product)->fill($values);

        $product->save();

        return $product;
    }

    public function update(Product $product, array $values)
    {
        $product->fill($values);

        $product->save();

        return $product;
    }

    public function getHomeProducts()
    {
        $products = Product::all();
        $selected = [];

        /** @var Product $product */
        foreach ($products as $product) {
            if ($product->filtered()) {
                continue;
            }

            $duration = $product->duration;

            /** @var Product $actual */
            $actual = $selected[ $duration ] ?? false;
            if (!$actual || $actual->cost > $product->cost) {
                $selected[ $duration ] = $product;
            }
        }

        ksort($selected);

        return $selected;
    }
}
