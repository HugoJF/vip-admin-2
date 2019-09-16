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
	public function storeProduct(array $values)
	{
		$product = Product::create($values);

		return $product;
	}
	
	public function updateProduct(Product $product, array $values)
	{
		$product->fill($values);

		$product->save();

		return $product;
	}
}