@component('mail::message')
# Bem-vindo aos servidores de_nerdTV!

### Obrigado por se registrar em nossa plataforma!

Para consultar nossas regras ou lista completa e atualizada de servidores:

@component('vendor.mail.html.button-group')
    @component('vendor.mail.html.basic-button', ['url' => 'https://denerdtv.com/regras'])
        Regras
    @endcomponent
    @component('vendor.mail.html.basic-button', ['url' => 'https://denerdtv.com/servidores'])
        Lista de Servidores
    @endcomponent
@endcomponent
Caso tenha alguma dúvida a respeito da plataforma ou de nossos servidores, sinta-se à vontade para nos contatar em um de nossos canais:

@component('mail::panel')
**Discord:** https://denerdtv.com/discord

**Steam:** https://steamcommunity.com/id/de_nerd

**Twitter:** https://twitter.com
@endcomponent

**Obrigado**, equipe de_nerdTV.
@endcomponent
