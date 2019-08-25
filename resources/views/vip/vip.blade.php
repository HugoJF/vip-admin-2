@extends('layouts.app')

@section('content')
    <h1 class="font-thin text-center text-5xl text-grey-darkest tracking-wide">Preços</h1>
    
    <!-- Card deck -->
    <div class="flex flex-wrap p-8">
        @include('vip.card', [
            'title' => '14 dias de VIP',
            'class' => '',
            'price' => '4,00'
        ])
        @include('vip.card', [
            'title' => '30 dias de VIP',
            'class' => 'scale-110',
            'highlight' => true,
            'price' => '8,00'
        ])
        @include('vip.card', [
            'title' => '60 dias de VIP',
            'class' => '',
            'price' => '16,00'
        ])
    </div>
    
    <!-- Column steps -->
    <div class="py-4 px-12 flex">
        <div class="w-1/3 flex items-center justify-center">
            <div class="h-4 -m-1 z-0 flex-grow bg-green-light rounded-l-full"></div>
            <div class="flex h-12 w-12 z-10 justify-center items-center bg-white bg-grey-lightest border-4 border-grey-darkest rounded-full">
                <span class="text-grey-darkest text-2xl font-mono font-bold">1</span>
            </div>
            <div class="h-4 -m-1 z-0 flex-grow bg-green-light"></div>
        </div>
        <div class="w-1/3 flex items-center justify-center">
            <div class="h-4 -m-1 z-0 flex-grow bg-grey-light"></div>
            <div class="flex h-12 w-12 z-10 justify-center items-center bg-white bg-grey-lightest border-4 border-grey-darkest rounded-full">
                <span class="text-grey-darkest text-2xl font-mono font-bold">2</span>
            </div>
            <div class="h-4 -m-1 z-0 flex-grow bg-grey-light"></div>
        </div>
        <div class="w-1/3 flex items-center justify-center">
            <div class="h-4 -m-1 z-0 flex-grow bg-grey-light"></div>
            <div class="flex h-12 w-12 z-10 justify-center items-center bg-white bg-grey-lightest border-4 border-grey-darkest rounded-full">
                <span class="text-grey-darkest text-2xl font-mono font-bold">3</span>
            </div>
            <div class="h-4 -m-1 z-0 flex-grow bg-grey-light rounded-r-full"></div>
        </div>
    </div>
    
    <!-- Absolute steps -->
    <div class="py-4 px-12 flex">
        <div class="relative flex h-4 w-full">
            <div class="trans absolute pin-t pin-l pin-b pin-r bg-grey-light overflow-hidden rounded-full">
                <div class="trans h-full bg-green w-32"></div>
            </div>
            <div class="w-1/3 flex items-center justify-center">
                <div class="flex h-12 w-12 z-10 justify-center items-center bg-white bg-grey-lightest border-4 border-grey-darkest rounded-full">
                    <span class="text-grey-darkest text-2xl font-mono font-bold">1</span>
                </div>
            </div>
            <div class="w-1/3 flex items-center justify-center">
                <div class="flex h-12 w-12 z-10 justify-center items-center bg-white bg-grey-lightest border-4 border-grey-darkest rounded-full">
                    <span class="text-grey-darkest text-2xl font-mono font-bold">2</span>
                </div>
            </div>
            <div class="w-1/3 flex items-center justify-center">
                <div class="flex h-12 w-12 z-10 justify-center items-center bg-white bg-grey-lightest border-4 border-grey-darkest rounded-full">
                    <span class="text-grey-darkest text-2xl font-mono font-bold">3</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- My step -->
    <div class="my-2 py-4 px-12 flex">
        <div class="relative flex justify-around h-1 w-full">
            <div class="trans absolute pin-t pin-l pin-b pin-r bg-grey-dark shadow overflow-hidden rounded-full">
                <div style="width: 33%" class="trans h-full bg-green"></div>
            </div>
            <div class="flex flex-col justify-center">
                <div class="flex flex-no-shrink h-10 shadow w-10 z-10 justify-center items-center bg-white bg-grey-lightest border-2 border-green rounded-full">
                    <span class="text-grey-darkest text-2xl font-mono font-bold">1</span>
                </div>
                <div class="relative flex justify-center pin-l pin-t pin-r">
                    <p class="text-center absolute h-8 whitespace-no-wrap text-grey-darkest">Gerar o pedido</p>
                </div>
            </div>
            <div class="flex flex-col justify-center">
                <div class="flex flex-no-shrink h-10 shadow w-10 z-10 justify-center items-center bg-white bg-grey-lightest border-2 border-grey-dark rounded-full">
                    <span class="text-grey-darkest text-2xl font-mono font-bold">2</span>
                </div>
                <div class="relative flex justify-center pin-l pin-t pin-r">
                    <p class="text-center absolute h-8 whitespace-no-wrap text-grey-darkest">Pagar o pedido</p>
                </div>
            </div>
            <div class="flex flex-col justify-center">
                <div class="flex flex-no-shrink h-10 shadow w-10 z-10 justify-center items-center bg-white bg-grey-lightest border-2 border-grey-dark rounded-full">
                    <span class="text-grey-darkest text-2xl font-mono font-bold">2</span>
                </div>
                <div class="relative flex justify-center pin-l pin-t pin-r">
                    <p class="text-center absolute h-8 whitespace-no-wrap text-grey-darkest">Esperar sincronização</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="my-2 py-4 px-12 flex">
        <table class="table-fixed w-full text-grey-darkest">
            <tbody>
            <tr class="border-t border-b border-grey-light">
                <td class="p-2 text-lg text-grey-darkest font-normal">Duração:</td>
                <td class="px-2">
                    @include('vip.tag', [
                        'text' => '30 dias',
                        'color' => 'green',
                    ])
                </td>
            </tr>
            <tr class="border-t border-b border-grey-light">
                <td class="p-2 text-lg text-grey-darkest font-normal">Inicia em:</td>
                <td class="px-2">
                    @include('vip.tag', [
                        'text' => 'Sun Apr 21 2019 11:21:42 GMT-0400',
                        'color' => 'green',
                    ])
                </td>
            </tr>
            <tr class="border-t border-b border-grey-light">
                <td class="p-2 text-lg text-grey-darkest font-normal">Finaliza em:</td>
                <td class="px-2">
                    @include('vip.tag', [
                        'text' => 'Sun Apr 21 2019 11:21:42 GMT-0400',
                        'color' => 'green',
                    ])
                </td>
            </tr>
            <tr class="border-t border-b border-grey-light">
                <td class="p-2 text-lg text-grey-darkest font-normal">Valor total:</td>
                <td class="px-2">
                    @include('vip.tag', [
                        'text' => 'R$ 8,00',
                        'color' => 'green',
                    ])
                </td>
            </tr>
            <tr class="border-t border-b border-grey-light">
                <td class="p-2 text-lg text-grey-darkest font-normal">Valor pago:</td>
                <td class="px-2">
                    @include('vip.tag', [
                        'text' => 'R$ 0,00',
                        'color' => 'red',
                    ])
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    
    <h1 class="mt-8 font-thin text-center text-5xl text-grey-darkest tracking-wide">Meus pedidos</h1>
    
    <div class="py-4 px-12">
        <table class="w-full text-grey-darkest">
            <thead class="bg-grey-lighter border-t border-b border-grey-light">
            <tr>
                <th class="py-2 px-3">ID do pedido</th>
                <th class="py-2 px-3">Usuário</th>
                <th class="py-2 px-3">Duração</th>
                <th class="py-2 px-3">Criado em</th>
                <th class="py-2 px-3">
                    <span>Estado</span>
                    <a href="#"><span class="text-grey-darker" data-feather="help-circle"></span></a>
                </th>
                <th class="py-2 px-3">Ações</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="py-2 px-3 font-mono font-medium">#3c377c9e</td>
                <td class="py-2 px-3">
                    <a href="#" class="text-blue font-semibold">Itachi</a>
                    <a class="group" href="#">
                        <span class="ml-2 h-4 w-4 text-grey-darkest group-hover:text-black" data-feather="zoom-in"></span>
                    </a>
                </td>
                <td class="py-2 px-3">30 dias</td>
                <td class="py-2 px-3">
                    29 <span class="text-grey-darkest font-light text-sm">minutos atrás</span>
                </td>
                <td class="py-2 px-3">
                    @include('vip.tag', [
                        'text' => 'Cancelado',
                        'color' => 'red',
                    ])
                </td>
                <td class="py-2 px-3">
                    <div class="flex">
                        <a class="px-2 py-1 bg-grey-lightest border-t border-l border-grey shadow-3d-white-sm font-medium text-sm">
                            <div class="flex w-full h-full justify-center items-center"><span class="m-0 p-0 h-4 w-4 text-grey-darker" data-feather="refresh-cw"></span></div>
                        </a>
                        <a class="inline-block px-3 py-1 bg-blue shadow-3d-blue-sm font-medium text-sm text-blue-lightest text">Detalhes</a>
                        <a class="inline-block px-3 py-1 bg-red shadow-3d-red-sm font-medium text-sm text-red-lightest text">Deletar</a>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    
    
    <h1 class="mt-8 font-thin text-center text-5xl text-grey-darkest tracking-wide">Minhas ativações</h1>
    
    <div class="py-4 px-12">
        <table class="w-full text-grey-darkest">
            <thead class="bg-grey-lighter border-t border-b border-grey-light">
            <tr>
                <th class="py-2 px-3">ID do pedido</th>
                <th class="py-2 px-3">Usuário</th>
                <th class="py-2 px-3">Total</th>
                <th class="py-2 px-3">Tempo restante</th>
                <th class="py-2 px-3">
                    <span>Estado</span>
                    <a href="#"><span class="text-grey-darker" data-feather="help-circle"></span></a>
                </th>
                <th class="py-2 px-3">Ações</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="py-2 px-3 font-mono font-medium">#3c377c9e</td>
                <td class="py-2 px-3">
                    <a href="#" class="text-blue font-semibold">Itachi</a>
                    <a class="group" href="#">
                        <span class="h-4 w-4 ml-2 text-grey-darkest group-hover:text-grey-darkest" data-feather="edit"></span>
                    </a>
                </td>
                <td class="py-2 px-3">
                    30 <span class="text-grey-darkest font-light text-sm">dias</span>
                </td>
                <td class="py-2 px-3">
                    22 <span class="text-grey-darkest font-light text-sm">dias</span>
                </td>
                <td class="py-2 px-3">
                    @include('vip.tag', [
                        'text' => 'Válido',
                        'color' => 'green',
                    ])
                </td>
                <td class="py-2 px-3">
                    <div class="flex">
                        <a class="px-2 py-1 bg-grey-lightest border-t border-l border-grey shadow-3d-white-sm font-medium text-sm">
                            <div class="flex w-full h-full justify-center items-center"><span class="m-0 p-0 h-4 w-4 text-grey-darker" data-feather="edit"></span></div>
                        </a>
                        <a class="inline-block px-3 py-1 bg-blue shadow-3d-blue-sm font-medium text-sm text-blue-lightest text">Detalhes</a>
                        <a class="inline-block px-3 py-1 bg-red shadow-3d-red-sm font-medium text-sm text-red-lightest text">Desativar</a>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    
    <h1 class="mt-8 font-thin text-center text-5xl text-grey-darkest tracking-wide">Meus tokens</h1>
    
    <div class="py-4 px-12">
        <table class="w-full text-grey-darkest">
            <thead class="bg-grey-lighter border-t border-b border-grey-light">
            <tr>
                <th class="py-2 px-3">Token</th>
                <th class="py-2 px-3">Dono</th>
                <th class="py-2 px-3">Usuário</th>
                <th class="py-2 px-3">Duração</th>
                <th class="py-2 px-3">Tempo restante</th>
                <th class="py-2 px-3">
                    <span>Estado</span>
                    <a href="#"><span class="text-grey-darker" data-feather="help-circle"></span></a>
                </th>
                <th class="py-2 px-3">Ações</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="py-2 px-3 font-mono font-medium">#3c377c9e</td>
                <td class="py-2 px-3">
                    <a href="#" class="text-blue font-semibold">Itachi</a>
                    <a class="group" href="#">
                        <span class="h-4 w-4 ml-2 text-grey-darkest group-hover:text-grey-darkest" data-feather="zoom-in"></span>
                    </a>
                </td>
                <td class="py-2 px-3">
                    <a href="#" class="text-blue font-semibold">de_nerd</a>
                    <a class="group" href="#">
                        <span class="h-4 w-4 ml-2 text-grey-darkest group-hover:text-grey-darkest" data-feather="zoom-in"></span>
                    </a>
                </td>
                <td class="py-2 px-3">
                    30 <span class="text-grey-darkest font-light text-sm">dias</span>
                </td>
                <td class="py-2 px-3">
                    22 <span class="text-grey-darkest font-light text-sm">dias</span>
                </td>
                <td class="py-2 px-3">
                    @include('vip.tag', [
                        'text' => 'Usado',
                        'color' => 'blue',
                    ])
                </td>
                <td class="py-2 px-3">
                    <div class="flex">
                        <a class="px-2 py-1 bg-grey-lightest border-t border-l border-grey shadow-3d-white-sm font-medium text-sm">
                            <div class="flex w-full h-full justify-center items-center"><span class="m-0 p-0 h-4 w-4 text-grey-darker" data-feather="edit"></span></div>
                        </a>
                        <a class="inline-block px-3 py-1 bg-blue shadow-3d-blue-sm font-medium text-sm text-blue-lightest text">Copiar URL</a>
                        <a class="inline-block px-3 py-1 bg-red shadow-3d-red-sm font-medium text-sm text-red-lightest text">Desativar</a>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection
