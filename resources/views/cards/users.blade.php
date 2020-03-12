@component('partials.card')
    @slot('title')
        <div class="d-flex items-center justify-between">
            <span>Usuários</span>
            <div class="btn-group" role="group">
                @if($viewRoute ?? false)
                    <a class="btn btn-outline-dark btn-sm" href="{{ route('users.index') }}">Ver usuários</a>
                @endif
            </div>
        </div>
    @endslot
    <table class="table">
        <thead>
        <tr>
            <th>Nome</th>
            <th>Tradelink</th>
            <th>Email</th>
            <th>VIP</th>
            <th>Pedidos <small>(pagos/total)</small></th>
            <th>Cargo</th>
            <th>Created at</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($users ?? [] as $user)
            <tr>
                <!-- Nome -->
                <td>
                    <a href="https://steamcommunity.com/profiles/{{ $user->steamid }}">
                        <code>{{ $user->name ?? $user->username }}</code>
                    </a>
                </td>

                <!-- Tradelink -->
                <td title="Tradelink">
                    @if($user->tradelink)
                        <a class="badge badge-dark" href="{{ $user->tradelink }}">Tradelink</a>
                    @else
                        <span class="badge badge-danger">N/A</span>
                    @endif
                </td>

                <!-- Email -->
                <td title="Email">
                    @if($user->email)
                        <span>✔</span>
                    @else
                        <span class="badge badge-danger">N/A</span>
                    @endif
                </td>

                <!-- VIP -->
                @php
                    $currentVip =$user->currentVip();
                @endphp
                <td title="VIP">
                    @if(!$currentVip)
                        <span class="badge badge-danger">N/A</span>
                    @else
                        <span class="badge badge-success">{{ $currentVip }} dias</span>
                    @endif
                </td>

                <!-- Pedidos -->
                <td>
                    <span class="badge badge-primary">{{ $user->orders()->paid()->count() }} / {{ $user->orders()->count() }}</span>
                </td>

                <!-- Cargo -->
                <td>
                    @if($user->admin)
                        <span class="badge badge-primary">Admin</span>
                    @else
                        <span class="badge badge-dark">Usuário</span>
                    @endif
                </td>

                <!-- Created at -->
                <td><span title="{{ $user->created_at }}">{{ $user->created_at->diffForHumans() }}</span></td>

                <!-- Actions -->
                <td>
                    <a class="btn btn-outline-primary btn-sm" href="{{ route('users.show', $user) }}">View</a>
                    {!! Form::open(['url' => route('users.admin', $user), 'method' => 'PATCH', 'style' => 'display: inline-block']) !!}
                    <div class="btn-group" role="group">
                        <button class="btn btn-primary btn-sm">Toggle admin</button>
                    </div>
                    {!! Form::close() !!}
                    {!! Form::open(['url' => route('users.affiliate', $user), 'method' => 'PATCH', 'style' => 'display: inline-block']) !!}
                    <div class="btn-group" role="group">
                        <button class="btn btn-primary btn-sm">Toggle affiliate</button>
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100"><h5 class="text-center">No users!</h5></td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endcomponent
