@if($order->canceled)
    <span class="px-2 py-1 bg-red-500 text-sm text-white font-medium rounded">Cancelado</span>
@elseif($order->expired)
    <span class="px-2 py-1 bg-red-500 text-sm text-white font-medium rounded">Expirado</span>
@elseif($order->paid && $order->activated && $order->starts_at->isFuture())
    <span class="px-2 py-1 bg-purple-500 text-sm text-white font-medium rounded" data-toggle="tooltip" data-placement="top" title="O pedido está ativo, porém seu período de início ainda não começou pois identificamos que já existe um pedido ativo no momento. Se você acha que isso é um erro, comunique nosso suporte!">Inativo</span>
@elseif($order->paid && $order->activated)
    <span class="px-2 py-1 bg-green-500 text-sm text-white font-medium rounded">Ativo</span>
@elseif($order->paid)
    <span class="px-2 py-1 bg-blue-500 text-sm text-white font-medium rounded">Pago</span>
@else
    <span class="px-2 py-1 bg-yellow-600 text-sm text-white font-medium rounded">Pendente</span>
@endif
