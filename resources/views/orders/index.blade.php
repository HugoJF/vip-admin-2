@extends('layouts.app')

@section('content')
    @include('cards.orders-v2')

    <div class="mt-4 flex justify-center">{{ $orders->links() }}</div>
@endsection
