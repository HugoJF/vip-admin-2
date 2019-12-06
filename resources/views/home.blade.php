@extends('layouts.app')

@section('content')
    <h1 class="font-thin text-center text-5xl text-grey-darkest tracking-wide">VIPs por MercadoPago, PayPal ou skins</h1>
    
    <div class="flex flex-wrap justify-center p-8">
        @forelse ($products as $product)
            
            @if($product->filtered())
                @continue
            @endif
            
            <div class="w-full lg:w-1/3 p-4">
                <div class="flex flex-col bg-gray-100 text-grey-darkest border border-grey justify-between items-center shadow-lg border-grey-darkest">
                    <!-- Title -->
                    <div class="self-stretch py-3 border-b border-grey">
                        <h2 class="font-normal text-center text-gray-900">{{ $product->title }}</h2>
                    </div>
                    
                    <!-- Body -->
                    <div class="flex flex-col items-center w-100 p-8">
                        <!-- Price -->
                        <div>
                            <div class="flex flex-col items-center flex-wrap text-5xl leading-tight">
                                <div class="flex">
                                    <span class="mr-1 font-light">R$</span>
                                    <span class="font-semibold text-grey-darkest">{{ number_format($product->cost / 100, 2) }}</span>
                                </div>
                                @if($product->original_cost >  $product->cost)
                                    <div class="flex">
                                        <span class="mr-1 font-light text-3xl text-red-700 opacity-50 line-through">R${{ number_format($product->original_cost / 100, 2) }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Details -->
                        <ul class="my-8 list-reset text-center text-sm">
                            {{ Markdown::parse($product->description) }}
                            {{--<li>Acesso aos comandos <strong>!ws</strong>, <strong>!gloves</strong>, <strong>!knife</strong>;</li>--}}
                            {{--<li><strong>Vaga garantida</strong> em todos os servidores;</li>--}}
                            {{--<li><strong>Report prioritário</strong>;</li>--}}
                            {{--<li>Tag <strong>[VIP]</strong> no chat e scoreboard.</li>--}}
                        </ul>
                        
                        <!-- CTA -->
                        <a href="{{ route('orders.create', $product) }}" class="btn btn-lg btn-block btn-primary">Comprar</a>
                    </div>
                </div>
            </div>
        @empty
            <h2>Atualmente não temos nenhum período para venda! <strong>Isso bem provavelmente é um erro!</strong></h2>
        @endforelse
    </div>
    
    {{--<h1 class="font-thin text-center text-5xl text-grey-darkest tracking-wide">VIPs por Skins</h1>--}}
@endsection
