@extends('layouts.app')

@section('content')
    <div class="flex flex-col items-center">
        <div class="px-32">
            <h1 class="text-center">Continuar com auto-ativação?</h1>

            <h3 class="my-8 text-center font-light">A auto-ativação permite que nosso sistema automáticamente ative e sincronize seu pedido assim que detectado como pago. </h3>
            <p class="my-8 text-center"><strong>Recomendamos que desative a auto-ativação no caso de pagamentos por Boleto Bancário ou com contas da Steam sem SteamGuard</strong>, desta forma você pode manualmente ativar o pedido em outro momento e <strong>evitar perder dias que você não pode jogar</strong>.</p>

            {!! Form::open(['url' => route('orders.store', $product), 'method' => 'POST']) !!}

            <div class="flex justify-center">
            </div>

            <div class="flex justify-center">
                <div>
                    <input class="form-control" name="coupon" placeholder="Digite aqui seu cupom de desconto" type="text">
                    <br/>
                    <div class="btn-group btn-group-lg">
                        <button name="auto-activates" value="1" class="btn btn-primary">Sim, manter ativado</button>
                        <button name="auto-activates" value="0" class="btn btn-outline-secondary">Não, desativar</button>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection
