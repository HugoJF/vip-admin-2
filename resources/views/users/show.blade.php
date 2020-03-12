@extends('layouts.app')

@section('content')
    <h1 class="text-center">Usuário <code>{{ $user->name ?? $user->username }}</code></h1>
    <br/>
    @component('partials.card')
        @slot('title')
            <div class="d-flex items-center justify-between">
                <span>Detalhes</span>
                <div class="btn-group"></div>
            </div>
        @endslot
        <table class="table">
            <tbody>
            <tr>
                <td>Name</td>
                <td>
                    @if($user->name)
                        {{ $user->name }}
                    @else
                        <span class="badge badge-danger">N/A</span>
                    @endif
                </td>
            </tr>

            <tr>
                <td>Username</td>
                <td>{{ $user->username }}</td>
            </tr>

            <tr>
                <td>Tradelink</td>
                <td>
                    <a href="{{ $user->tradelink }}">
                        <span class="badge badge-dark">Tradelink</span>
                    </a>
                </td>
            </tr>

            <tr>
                <td>Pedidos</td>
                <td>
                    <span class="badge badge-primary">
                        {{ $user->orders()->paid()->count() }} / {{ $user->orders()->count() }}
                    </span>
                </td>
            </tr>

            @php
                $currentVip = $user->currentVip();
            @endphp
            <tr>
                <td>VIP</td>
                <td>
                    @if(!$currentVip)
                        <span class="badge badge-danger">N/A</span>
                    @else
                        <span class="badge badge-success">{{ $currentVip }} dias</span>
                    @endif
                </td>
            </tr>
            </tbody>
        </table>
    @endcomponent

    <br/>

    @include('cards.orders', ['orders' => $user->orders])
@endsection
