@component('partials.card')
    @slot('title')
        <div class="d-flex items-center justify-between">
            <span>Cupons</span>
            <div class="btn-group" role="group">
                @admin
                <a class="btn btn-primary btn-sm" href="{{ route('coupons.create') }}">Criar cupom</a>
                @endadmin
            </div>
        </div>
    @endslot
    <table class="table">
        <thead>
        <tr>
            <th>Código</th>
            <th>Desconto</th>
            <th>Inicia em</th>
            <th>Expira em</th>
            <th>Estado</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($coupons ?? [] as $coupon)
            <tr>
                <!-- Code -->
                <td>
                    <code>{{ $coupon->code }}</code>
                </td>
                
                <!-- Discount -->
                <td>
                    <span class="badge badge-primary">{{ number_format($coupon->discount * 100, 2) }}%</span>
                </td>
                
                <!-- Starts at -->
                <td title="{{ $coupon->starts_at }}">{{ $coupon->starts_at->diffForHumans() }}</td>
                
                <!-- Ends at -->
                <td title="{{ $coupon->ends_at }}">{{ $coupon->ends_at->diffForHumans() }}</td>
                
                <!-- Status -->
                <td>
                    @if($coupon->expired)
                        <span class="badge badge-danger">Expirado</span>
                    @elseif(!$coupon->started)
                        <span class="badge badge-warning">Não iniciado</span>
                    @elseif($coupon->order)
                        <span class="badge badge-dark">Usado</span>
                    @else
                        <span class="badge badge-primary">Válido</span>
                    @endif
                </td>
                
                <td>
                    {!! Form::open(['url' => route('coupons.destroy', $coupon), 'method' => 'DELETE']) !!}
                    <div class="btn-group" role="group">
                        <a class="btn btn-sm btn-primary" href="{{ route('coupons.edit', $coupon) }}">Editar</a>
                        <button class="btn btn-sm btn-outline-danger">Deletar</button>
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100"><h5 class="text-center">No coupons!</h5></td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endcomponent