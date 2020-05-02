@component('partials.card')
    @slot('title')
        <div class="d-flex items-center justify-between">
            <span>Pedidos</span>
            <div class="btn-group" role="group">
                <a class="btn btn-primary btn-sm" href="{{ route('home') }}">Novo pedido</a>
                @admin
                @if($viewRoute ?? false)
                    <a class="btn btn-outline-dark btn-sm" href="{{ route('orders.store') }}">View orders</a>
                @endif
                @endadmin
            </div>
        </div>
    @endslot
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Duration</th>
                <th>Remaining</th>
                <th>Status</th>
                <th>Transferred</th>
                @admin
                <th>User</th>
                @endadmin
                <th>Created at</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($orders ?? [] as $order)
                <tr>
                    <!-- ID -->
                    <td>
                        <a href="{{ route('orders.show', $order) }}">
                            <code class="break-normal">#{{ $order->id }}</code>
                        </a>
                    </td>

                    <!-- Duration -->
                    <td>
                        <span class="badge badge-primary">{{ $order->duration }} dias</span>
                    </td>

                    <!-- Remaining -->
                    <td>
                        @if(
	                        $order->starts_at &&
	                        $order->ends_at &&
	                        $order->ends_at->isFuture() &&
	                        $remaining = $order->remaining
	                        )
                            <span class="badge badge-primary">
                                {{ $remaining }} {{ $remaining === 1 ? 'dia' : 'dias' }}
                            </span>
                        @else
                            <span class="badge badge-secondary">
                                N/A
                            </span>
                        @endif
                    </td>

                    <!-- Status -->
                    <td>
                        @include('orders.status-badge')
                    </td>

                    <!-- Transferred -->
                    <td>
                        @if($order->steamid)
                            <span title="Pedido transferido para outro usuário">📩</span>
                            <span class="badge badge-primary">{{ $order->steamid }}</span>
                        @else
                            <span class="badge badge-dark">Não</span>
                        @endif
                    </td>

                    <!-- User -->
                    @admin
                    <td>
                        <a href="{{ route('users.show', $order->user) }}">{{ $order->user->name ?? $order->user->username }}</a>
                    </td>
                    @endadmin

                    <!-- Created at -->
                    <td>{{ $order->created_at->diffForHumans() }}</td>

                    <!-- Actions -->
                    <td>
                        {!! Form::open(['url' => route('orders.activate', $order), 'method' => 'PATCH', 'classs' => 'flex items-stretch w-100']) !!}
                        <div class="btn-group" role="group">
                            @if(!$order->activated && $order->paid)
                                <button class="btn btn-success btn-sm">Ativar</button>
                            @endif
                            <a class="btn btn-outline-primary btn-sm" href="{{ route('orders.show', $order) }}">Detalhe</a>
                            @admin
                            <a class="btn btn-outline-secondary btn-sm" href="{{ route('orders.edit', $order) }}">Editar</a>
                            @endadmin
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="100"><h5 class="text-center">No orders!</h5></td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endcomponent
