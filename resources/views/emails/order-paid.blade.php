@component('mail::message')
# Seu pedido `{{ $order->id }}` foi pago!

Detalhes do pedido:

@component('mail::panel')
**Código:** `{{ $order->id }}`
    
**Duração:** {{ $order->duration }} dias
@endcomponent

@if(!$order->auto_activates)
Para ativar seu pedido, clique no botão abaixo para ser redirecionado para nossa plataforma.
@endif

@component('vendor.mail.html.button-group')
@if(!$order->auto_activates)
@component('vendor.mail.html.basic-button', ['color' => 'success', 'url' => route('orders.show', $order)])
Ativar
@endcomponent
@endif

@component('vendor.mail.html.basic-button', ['url' => route('orders.show', $order)])
Detalhes
@endcomponent
@endcomponent

**Obrigado!** Equipe de_nerdTV.
@endcomponent
