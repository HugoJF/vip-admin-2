@extends('layouts.app')

@section('content')
    <h1 class="font-thin text-center text-5xl text-grey-darkest tracking-wide">VIPs por MercadoPago, PayPal ou skins</h1>
    
    <div class="flex flex-wrap justify-center p-8">
        @foreach ($products as $product)
            
            <div class="w-full lg:w-1/3 p-4">
                <div class="flex flex-col text-grey-darkest border border-grey justify-between items-center shadow border-grey-darkest">
                    <!-- Title -->
                    <div class="self-stretch py-3 border-b border-grey bg-grey-lighter">
                        <h2 class="font-normal text-center text-grey-darkest">{{ $product->title }}</h2>
                    </div>
                    
                    <!-- Body -->
                    <div class="flex flex-col items-center w-100 p-8">
                        <!-- Price -->
                        <div>
                            <h4 class="flex items-baseline text-5xl">
                                <span class="mr-1 font-light">R$</span>
                                <span class="font-semibold text-grey-darkest">{{ number_format($product->cost / 100, 2) }}</span>
                                @if($product->original_cost !==  $product->cost)
                                    <span class="ml-2 font-normal text-red-700 line-through">{{ number_format($product->original_cost / 100, 2) }}</span>
                                @endif
                                {{--<span class="mr-1 font-normal text-xl text-grey-dark">{suffix}</span>--}}
                            </h4>
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
        @endforeach
    </div>
    
    {{--<h1 class="font-thin text-center text-5xl text-grey-darkest tracking-wide">VIPs por Skins</h1>--}}
@endsection