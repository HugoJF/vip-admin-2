<?php

namespace App\Http\Controllers;

use App\Coupon;
use App\Http\Requests\CouponStoreRequest;
use App\Http\Requests\CouponUpdateRequest;
use App\Services\CouponService;
use App\Services\Forms\CouponForms;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::valid()->paginate(25);

        return view('coupons.index', compact('coupons'));
    }

    public function create(CouponForms $forms)
    {
        $form = $forms->create();

        return view('form', [
            'title'       => 'Criando novo cupom',
            'form'        => $form,
            'submit_text' => 'Criar',
        ]);
    }

    public function store(CouponService $service, CouponStoreRequest $request)
    {
        $service->createCoupon($request->validated());

        flash()->success('Cupom criado com sucesso!');

        return redirect()->route('coupons.index');
    }

    public function edit(CouponForms $forms, Coupon $coupon)
    {
        $form = $forms->edit($coupon);

        return view('form', [
            'title'       => 'Atualizando cupom',
            'form'        => $form,
            'submit_text' => 'Atualizar',
        ]);
    }

    public function update(CouponService $service, CouponUpdateRequest $request, Coupon $coupon)
    {
        $service->updateCoupon($coupon, $request->validated());

        flash()->success('Cupom atualizado com sucesso!');

        return redirect()->route('coupons.index');
    }

    public function destroy(Coupon $coupon)
    {
        // TODO: Check if it's used
        $coupon->delete();

        flash()->success('Cupom deletado com sucesso!');

        return redirect()->route('coupons.index');
    }
}
