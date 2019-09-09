@component('mail::message')
# Você recebeu um novo token

Recebemos um novo pedido de um usuário cadastrado com seu código de afiliado, com isso, registramos um novo *token* em sua conta:

@component('mail::panel')
**Código:** {{ $token->id }}

**Duração:** {{ $token->duration }} dias
@endcomponent

@component('mail::button', ['url' => route('tokens.show', $token)])
Ver token
@endcomponent

**Obrigado!** Equipe de_nerdTV.
@endcomponent
