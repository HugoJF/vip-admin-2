@component('mail::message')
# Novo pedido gerado!

Detalhes do pedido:

@component('mail::panel')
**Código:** `{{ $order->id }}`

**Duração:** {{ $order->duration }} dias

**Auto-ativação:** {{ $order->auto_activates ? 'Sim' : 'Não' }}
@endcomponent

@component('vendor.mail.html.button-group')
@component('vendor.mail.html.basic-button', ['url' => route('orders.show', $order)])
Detalhes
@endcomponent

@component('vendor.mail.html.basic-button', ['color' => 'success', 'url' => $order->init_point])
Pagar
@endcomponent
@endcomponent

**Obrigado!** Equipe de_nerdTV.
@endcomponent
