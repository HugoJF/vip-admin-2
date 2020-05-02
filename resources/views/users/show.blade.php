@extends('layouts.app')

@push('modals')
    <div id="userRefactor" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Refatoração de pedidos de usuário</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                    {!! Form::open(['method' => 'PATCH', 'url' => route('users.refactor', $user)]) !!}
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Refatorar</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endpush

@section('content')
    <h1 class="text-center">Usuário <code>{{ $user->name ?? $user->username }}</code></h1>
    <br/>
    @component('partials.card')
        @slot('title')
            <div class="d-flex items-center justify-between">
                <span>Detalhes</span>
                <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#userRefactor">Refatorar</a>
                    </div>
                </div>
            </div>
        @endslot
        <table class="table">
            <tbody>

            <!-- Name -->
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

            <!-- Email -->
            <tr>
                <td>Email</td>
                <td>
                    @if($user->email)
                        <span>✔</span>
                    @else
                        <span class="badge badge-danger">N/A</span>
                    @endif
                </td>
            </tr>

            <!-- Username -->
            <tr>
                <td>Username</td>
                <td>{{ $user->username }}</td>
            </tr>

            <!-- Steam -->
            <tr>
                <td>Steam</td>
                <td>
                    <a href="https://steamcommunity.com/profiles/{{ steamid64($user->steamid) }}">
                        <span class="badge badge-dark">Steam</span>
                    </a>
                </td>
            </tr>

            <!-- Tradelink -->
            <tr>
                <td>Tradelink</td>
                <td>
                    <a href="{{ $user->tradelink }}">
                        <span class="badge badge-dark">Tradelink</span>
                    </a>
                </td>
            </tr>

            <!-- Pedidos -->
            <tr>
                <td>Pedidos</td>
                <td>
                    <span class="badge badge-primary">
                        {{ $user->orders()->paid()->count() }} / {{ $user->orders()->count() }}
                    </span>
                </td>
            </tr>

            <!-- VIP -->
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

            <!-- SteamID64 -->
            <tr>
                <td>SteamID64</td>
                <td>
                    <span class="badge badge-secondary">{{ steamid64($user->steamid) }}</span>
                </td>
            </tr>

            <!-- SteamID2 -->
            <tr>
                <td>SteamID2</td>
                <td>
                    <span class="badge badge-secondary">{{ steamid2($user->steamid) }}</span>
                </td>
            </tr>

            <!-- SteamID3 -->
            <tr>
                <td>SteamID3</td>
                <td>
                    <span class="badge badge-secondary">{{ steamid3($user->steamid) }}</span>
                </td>
            </tr>
            </tbody>
        </table>
    @endcomponent

    <br/>

    @include('cards.orders', ['orders' => $user->orders])
@endsection
