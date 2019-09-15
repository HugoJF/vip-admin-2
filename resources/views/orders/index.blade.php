@extends('layouts.app')

@section('content')
    @include('cards.orders')
    
    <div class="mt-4 flex justify-center">{{ $orders->links() }}</div>
@endsection