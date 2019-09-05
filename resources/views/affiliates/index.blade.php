@extends('layouts.app')

@section('content')
    <div class="flex flex-col items-center">
        <div class="px-32">
            <h1>Afiliados</h1>
            
            <h3 class="my-8 text-center font-light">Até o momento, <span class="badge badge-primary">{{ auth()->user()->referees()->count() }}</span> usuários registraram utilizando seu link de afiliado!</h3>
            
            <h5>Seu link de afiliado: <a class="badge badge-dark" href="{{ route('affiliate', auth()->user()->affiliate_code) }}">{{ route('affiliate', auth()->user()->affiliate_code) }}</a></h5>
        </div>
    </div>
@endsection