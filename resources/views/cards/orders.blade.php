@component('partials.card')
    @slot('title')
        <div class="d-flex items-center justify-between">
            <span>Pedidos</span>
            <div class="btn-group" role="group">
                <a class="btn btn-primary btn-sm" href="{{ route('home') }}">Novo pedido</a>
                @if($viewRoute ?? false)
                    <a class="btn btn-outline-dark btn-sm" href="{{ route('orders.store') }}">View orders</a>
                @endif
            </div>
        </div>
    @endslot
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Duration</th>
            <th>Status</th>
            <th>Created at</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($orders ?? [] as $order)
            <tr>
                <!-- ID -->
                <td>
                    <code>#{{ $order->id }}</code>
                </td>
                
                <!-- Duration -->
                <td>
                    <span class="badge badge-primary">{{ $order->duration }} dias</span>
                </td>
                
                <!-- Status -->
                <td>
                    @if($order->canceled)
                        <span class="badge badge-danger">Cancelado</span>
                    @elseif($order->paid && $order->activated)
                        <span class="badge badge-success">Ativo</span>
                    @elseif($order->paid)
                        <span class="badge badge-primary">Pago</span>
                    @else
                        <span class="badge badge-warning">Pendente</span>
                    @endif
                </td>
                
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
                        <a class="btn btn-outline-secondary btn-sm" href="{{ route('orders.edit', $order) }}">Editar</a>
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
@endcomponent