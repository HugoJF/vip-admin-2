<?php

namespace Tests\Unit;

use App\Product;
use App\Services\ProductService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductServiceTest extends TestCase
{
	protected $original = [
		'title'       => 'my product',
		'duration'    => 30,
		'cost'        => 1000,
		'original_cost'    => 1200,
		'description' => 'product description',
	];
	protected $updated = [
		'title'       => 'my new product',
		'duration'    => 60,
		'cost'        => 1500,
		'discount'    => 1700,
		'description' => 'new product description',
	];

	public function testProductService()
	{
		/** @var ProductService $service */
		$service = app(ProductService::class);

		$product = $service->storeProduct($this->original);

		$this->assertInstanceOf(Product::class, $product);
		$this->assertTrue(array_diff($this->original, $product->toArray()) === []);
		$this->assertDatabaseHas('products', $this->original);

		$product = $service->updateProduct($product, $this->updated);

		$this->assertInstanceOf(Product::class, $product);
		$this->assertTrue(array_diff($this->updated, $product->toArray()) === []);
		$this->assertDatabaseHas('products', $this->updated);
	}
}
