@component('mail::message')
# Seu período de VIP acabou 😭

Caso tenha interesse em continuar com o período VIP, clique no botão *Painel VIP* abaixo.

@component('mail::button', ['color' => 'success', 'url' => route('home')])
    Painel VIP
@endcomponent

Se não pretende renovar o VIP, agradecemos todo o apoio para manter nosso servidores ❤

**Obrigado!** Equipe de_nerdTV.
@endcomponent
