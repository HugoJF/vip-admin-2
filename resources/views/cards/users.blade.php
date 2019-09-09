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
            <th>Pedidos</th>
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
                    <code>{{ $user->name ?? $user->username }}</code>
                </td>
                
                <!-- Tradelink -->
                <td>
                    @if($user->tradelink)
                        <a class="badge badge-dark" href="{{ $user->tradelink }}">Tradelink</a>
                    @else
                        <span class="badge badge-danger">N/A</span>
                    @endif
                </td>
                
                <!-- Pedidos -->
                <td><span class="badge badge-primary">{{ $user->orders()->count() }}</span></td>
                
                <!-- Cargo -->
                <td>
                    @if($user->admin)
                        <span class="badge badge-primary">Admin</span>
                    @else
                        <span class="badge badge-dark">Usuário</span>
                    @endif
                </td>
                
                <!-- Created at -->
                <td>{{ $user->created_at->diffForHumans() }}</td>
                
                <!-- Actions -->
                <td>
                    {!! Form::open(['url' => route('users.admin', $user), 'method' => 'PATCH']) !!}
                    <div class="btn-group" role="group">
                        <button class="btn btn-primary btn-sm">Toggle admin</button>
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