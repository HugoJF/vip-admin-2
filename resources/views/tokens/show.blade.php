@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        {!! Form::open(['url' => route('tokens.use', $token), 'method' => 'POST']) !!}
        
        <div class="px-20 py-10 bg-gray-100 shadow-lg rounded-lg">
            <h1 class="">Token de {{ $token->duration }} dias</h1>
            <div class="py-6 text-center">{{ $token->note }}</div>
            @if($token->expires_at->isPast())
                <a href="#" class="btn btn-outline-danger btn-lg btn-block disabled">Expirado</a>
            @else
                <button class="btn btn-outline-primary btn-lg btn-block">Usar token</button>
            @endif
            <small class="text-gray-500 font-thin">Expira em {{ $token->expires_at->longAbsoluteDiffForHumans() }}</small>
        </div>
        {!! Form::close() !!}
    
    </div>
@endsection