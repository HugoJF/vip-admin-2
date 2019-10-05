@extends('layouts.app')

@section('content')
    <div class="flex flex-col items-center">
        <div class="px-32">
            <h1>Informações de afiliado</h1>
            
            <h3 class="my-8 text-center font-light">Até o momento, <span class="badge badge-primary">{{ auth()->user()->referees()->count() }}</span> usuários registraram utilizando seu link de afiliado!</h3>
            
            
            <ul class="list-disc">
                <li>Seu link de afiliado: <a class="badge badge-dark" href="{{ route('affiliate', auth()->user()->affiliate_code) }}">{{ route('affiliate', auth()->user()->affiliate_code) }}</a></li>
                <li>Você recebe tokens de <span class="badge badge-primary">{{ auth()->user()->affiliate_register_duration }} dias</span> para cada usuário que registra com o seu link.</li>
                <li>Você recebe tokens de <span class="badge badge-primary">{{ number_format(auth()->user()->affiliate_order_ratio * 100) }}%</span> da duração de cada pedido pago por usuários registrados com o seu link.</li>
            </ul>
        </div>
    </div>
@endsection