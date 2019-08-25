@php
    $highlight  = $highlight ?? false;
@endphp

<div class="w-1/3 p-4 {{ $class }}">
    
    <!-- Card -->
    <div class="flex flex-col text-grey-darkest border border-grey justify-between items-center shadow {{ $highlight ? 'shadow-lg' : 'shadow' }} border-grey-darkest">
        <!-- Card Header -->
        <div class="self-stretch py-3 border-b border-grey bg-grey-lighter">
            <h2 class="font-normal text-center text-grey-darkest">{{ $title }}</h2>
        </div>
        
        <!-- Card Body -->
        <div class="flex flex-col items-center p-8">
            <!-- Cost -->
            <div>
                <h4 class="flex items-baseline text-5xl">
                    <span class="mr-1 font-light text-grey-dark">R$</span>
                    <span class="font-semibold text-grey-darkest">{{ $price }}</span>
                </h4>
            </div>
            
            <!-- Features -->
            <ul class="my-8 list-reset text-center text-sm">
                <li>Acesso aos comandos <strong>!ws</strong>, <strong>!gloves</strong>, <strong>!knife</strong>;</li>
                <li><strong>Vaga garantida</strong> em todos os servidores;</li>
                <li><strong>Report prioritário</strong>;</li>
                <li>Tag <strong>[VIP]</strong> no chat e scoreboard.</li>
            </ul>
            
            <!-- CTA -->
            @if($highlight)
                <a href="#" class="trans block shadow-3d-blue-sm border px-10 py-2 text-center text-blue-lightest text-3xl font-semibold border-blue bg-blue no-underline hover:bg-blue-dark hover:border-blue-dark">
                    Comprar
                </a>
            @else
                <a href="#" class="trans block border px-10 py-2 text-center text-blue text-3xl font-semibold border-blue bg-transparent no-underline hover:bg-blue hover:border-blue-dark hover:text-blue-lightest">
                    Comprar
                </a>
            @endif
        </div>
    </div>
</div>
