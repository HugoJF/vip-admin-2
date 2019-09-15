@extends('layouts.app')

@section('content')
    <h1 class="font-thin text-center text-5xl text-grey-darkest tracking-wide">FAQ - Perguntas Frequentes</h1>
    <h3 class="pt-8">Como posso pagar um pedido com skins?</h3>
    <div>
        <p class="pt-1">
            <strong>Todos os pedidos de VIP podem ser pagos com skins</strong> de CS:GO da Steam.
        </p>
        <p class="pt-1">
            Isso quer dizer que mesmo se o pedido seja inicialmente criado para 60 dias, <strong>a opção de pagar com skins ainda estará disponível</strong>.
        </p>
        <p class="pt-1">
            Caso a opção de skins seja selecionada, você poderá pagar um valor que for conveniente (não é necessário pagar exatamente os 60 dias), <strong>o sistema irá calcular a duração do seu pedido de acordo com o valor da troca</strong>.
        </p>
    </div>
    
    <h3 class="pt-8">É possível pagar períodos maiores que os disponíveis na página inicial?</h3>
    <p class="pt-1">Não. Caso tenha interesse em períodos maiores, <strong><a href="{{ route('settings') }}"><u>preencha seu email nas configurações de usuário</u></a></strong> para receber notificação de nossas promoções!</p>
    
    <h3 class="pt-8">O que receberei no meu email?</h3>
    <p>Utilizaremos seu email para:</p>
    <ul class="pl-8 pt-2 list-disc">
        <li>Notificação de <strong>criação de pedidos</strong>;</li>
        <li>Notificação de <strong>pagamento de pedidos</strong>;</li>
        <li>Notificação de <strong>ativação de pedidos</strong>;</li>
        <li>Notificação de <strong>expiração de pedidos</strong>;</li>
        <li>Notificação de quando seu <strong>código de afiliado for utilizado</strong> (registros e novos pedidos);</li>
        <li><strong>Ofertas</strong> de tempo limitado;</li>
        <li><strong>Descontos exclusivos</strong>;</li>
    </ul>
@endsection