<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Product;
use App\Services\Forms\ProductForms;
use App\Services\ProductService;

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

    public function store(ProductService $service, ProductStoreRequest $request)
    {
        $product = $service->storeProduct($request->validated());

        eflash()->success("Produto <strong>%s</strong> criado com sucesso!", $product->title);

        return redirect()->route('products.index');
    }

    public function update(ProductService $service, ProductUpdateRequest $request, Product $product)
    {
        $service->updateProduct($product, $request->validated());

        eflash()->success("Produto <strong>%s</strong> atualizado com sucesso!", $product->title);

        return redirect()->route('products.index');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        eflash()->success("<strong>%s</strong> removido com sucesso!", $product->title);

        return back();
    }
}
