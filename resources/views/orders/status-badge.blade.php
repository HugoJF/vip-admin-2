@if($order->canceled)
    <span class="badge badge-danger">Cancelado</span>
@elseif($order->expired)
    <span class="badge badge-danger">Expirado</span>
@elseif($order->paid && $order->activated && $order->starts_at->isFuture())
    <span class="badge badge-info" data-toggle="tooltip" data-placement="top" title="O pedido está ativo, porém seu período de início ainda não começou pois identificamos que já existe um pedido ativo no momento. Se você acha que isso é um erro, comunique nosso suporte!">Inativo</span>
@elseif($order->paid && $order->activated)
    <span class="badge badge-success">Ativo</span>
@elseif($order->paid)
    <span class="badge badge-primary">Pago</span>
@else
    <span class="badge badge-warning">Pendente</span>
@endif
