@component('mail::message')
# Seu pedido `{{ $order->id }}` foi ativado!

Detalhes do pedido:

@component('mail::panel')
**Período de início:** {{ $order->starts_at }}

**Período de término:** {{ $order->ends_at }}
@endcomponent

Seu pedido já foi sincronizado em nossos servidores e já está pronto para uso!

@component('mail::button', ['url' => route('orders.show', $order)])
Detalhes
@endcomponent

**Obrigado!** Equipe de_nerdTV.
@endcomponent
