<?php
/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 9/5/2019
 * Time: 12:19 AM
 */

namespace App\Services\Forms;

use App\Forms\ProductForm;
use App\Product;

class ProductForms extends ServiceForms
{
	public function create()
	{
		return $this->builder->create(ProductForm::class, [
			'method' => 'POST',
			'url'    => route('products.store'),
		]);
	}

	public function edit(Product $product)
	{
		return $this->builder->create(ProductForm::class, [
			'method' => 'PATCH',
			'url'    => route('products.update', $product),
			'model'  => $product,
		]);
	}
}