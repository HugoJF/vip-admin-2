@extends('layouts.app')

@section('content')
    <h1>Resultados da busca por <code>{{ $term }}</code></h1>
    
    @if(isset($users))
        <br/>
        @include('cards.users')
    @endif
    
    @if(isset($tokens))
        <br/>
        @include('cards.tokens')
    @endif
    
    @if(isset($orders))
        <br/>
        @include('cards.orders')
    @endif
@endsection