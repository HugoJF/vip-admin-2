<?php

namespace App\Http\Controllers;

use App\Product;
use App\Services\Forms\ProductForms;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
	public function index()
	{
		$products = Product::all();

		return view('products.index', compact('products'));
	}

	public function create(ProductForms $forms)
	{
		$form = $forms->create();

		return view('form', [
			'title'       => 'Criando novo produto',
			'form'        => $form,
			'submit_text' => 'Criar',
		]);
	}

	public function edit(ProductForms $forms, Product $product)
	{
		$form = $forms->edit($product);

		return view('form', [
			'title'       => 'Editando produto',
			'form'        => $form,
			'submit_text' => 'Atualizar',
		]);
	}

	public function store(ProductService $service, Request $request)
	{
		$product = $service->storeProduct($request->all());

		flash()->success("Produto <strong>$product->title</strong> criado com sucesso!");

		return redirect()->route('products.index');
	}

	public function update(ProductService $service, Request $request, Product $product)
	{
		$service->updateProduct($product, $request->all());

		flash()->success('Produto atualizado com sucesso!');

		return redirect()->route('products.index');
	}

	public function destroy(Product $product)
	{
		$product->delete();

		flash()->success("<strong>$product->title</strong> removido com sucesso!");

		return back();
	}
}
