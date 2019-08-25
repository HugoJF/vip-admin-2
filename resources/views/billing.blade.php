<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Laravel</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="trans bg-grey-light font-sans">
<div class="flex flex-col items-center justify-center p-6 md:p-12 my-32">
    <div class="relative flex justify-center w-full m-auto">
        <div style="top: 0" class="absolute hidden -translate-50 self-center p-4 justify-center items-center bg-white rounded-full shadow sm:flex">
            <img class="h-32 w-32 rounded-full" src="https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/45/45be9bd313395f74762c1a5118aee58eb99b4688_full.jpg"/>
        </div>
    </div>
    <div class="flex flex-col lg:w-1/2 xl:w-1/3 w-full justify-center bg-grey-lightest border border-blue-dark rounded-lg shadow-lg overflow-hidden">
        <div class="flex flex-col p-4 justify-center items-center sm:p-6">
            <div class="flex flex-col self-stretch items-center justify-between sm:flex-row sm:items-start">
                <h2 class="text-grey-dark text-lg font-mono font-medium">#23858283</h2>
                <span class="uppercase mt-2 py-2 px-3 text-sm text-blue-lightest font-bold bg-blue-dark rounded-lg sm:mt-0">Aguardando</span>
            </div>
            <p class="mt-12 text-grey-dark text-sm ">30 dias de VIP nos servidores de CS:GO</p>
            
            <h2 class="mt-12 uppercase text-grey-dark text-center text-2xl font-normal tracking-wide">Valor total</h2>
            <p class="flex mt-8 pb-4 justify-center items-baseline text-center text-5xl">
                <span class="mr-1 text-3xl text-grey font-normal">R$</span>
                <span class="text-grey-darkest font-semibold">8,00</span>
            </p>
            
            <a href="#" class="mt-4 py-4 px-12 bg-blue no-underline text-grey-lighter text-xl font-bold rounded-lg shadow shadow-3d-blue-sm hover:bg-blue-dark">Pagar</a>
        </div>
        
        <div class="h-4 w-full">
            <div class="h-full w-full bg-blue-dark w-64"></div>
        </div>
    </div>
    
    <div class="flex flex-col mt-32 lg:w-1/2 xl:w-1/3 w-full justify-center bg-grey-lightest border border-yellow-dark rounded-lg shadow-lg overflow-hidden">
        <div class="absolute hidden -translate-50 self-center p-4 justify-center items-center bg-white rounded-full shadow sm:flex" style="margin-top: -64px">
            <img class="h-32 w-32 rounded-full" src="https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/45/45be9bd313395f74762c1a5118aee58eb99b4688_full.jpg"/>
        </div>
        <div class="flex flex-col p-4 justify-center items-center sm:p-6">
            <div class="flex flex-col self-stretch items-center justify-between sm:flex-row sm:items-start">
                <h2 class="text-grey-dark text-lg font-mono font-medium">#23858283</h2>
                <span class="uppercase mt-2 py-2 px-3 text-sm text-yellow-darkest font-bold bg-yellow-dark rounded-lg sm:mt-0">Pendente</span>
            </div>
            
            <h2 class="mt-16 uppercase text-grey-dark text-center text-2xl font-normal tracking-wide">Aguardando tradeoffer</h2>
            
            <img class="mt-4 w-20 h-20" src="https://www.advisory.com/assets/responsive/images/loading1.gif">
        
        
        </div>
        
        <div class="h-4 w-full">
            <div class="h-full w-full bg-yellow-dark w-64"></div>
        </div>
    </div>
    
    
    <div class="flex flex-col mt-32 lg:w-1/2 xl:w-1/3 w-full justify-center bg-grey-lightest border border-green-dark rounded-lg shadow-lg overflow-hidden">
        <div class="absolute hidden -translate-50 self-center p-4 justify-center items-center bg-white rounded-full shadow sm:flex" style="margin-top: -128px">
            <img class="h-32 w-32 rounded-full" src="https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/45/45be9bd313395f74762c1a5118aee58eb99b4688_full.jpg"/>
        </div>
        <div class="flex flex-col p-4 justify-center items-center sm:p-6">
            <div class="flex flex-col self-stretch items-center justify-between sm:flex-row sm:items-start">
                <h2 class="text-grey-dark text-lg font-mono font-medium">#23858283</h2>
                <span class="mt-2 py-2 px-3 text-sm text-green-darkest font-bold bg-green rounded-lg sm:mt-0">PAGO</span>
            </div>
            
            <h2 class="mt-16 uppercase text-grey-dark text-center text-2xl font-normal tracking-wide">Valor total</h2>
            <p class="flex mt-8 mb-4 justify-center items-baseline text-center text-5xl">
                <span class="mr-1 text-3xl text-grey font-normal">R$</span>
                <span class="text-grey-darkest font-semibold">8,00</span>
            </p>
            
            <svg class="my-2 w-16 h-16 fill-current text-green-dark" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                 viewBox="0 0 426.667 426.667" xml:space="preserve">
                <path d="M213.333,0C95.518,0,0,95.514,0,213.333s95.518,213.333,213.333,213.333c117.828,0,213.333-95.514,213.333-213.333S331.157,0,213.333,0z M174.199,322.918l-93.935-93.931l31.309-31.309l62.626,62.622l140.894-140.898l31.309,31.309L174.199,322.918z"/>
            </svg>
            
            
            <a href="#" class="py-4 px-12 text-grey-darker text-xl font-normal no-underline hover:text-grey-darkest hover:underline">‹ Voltar ao VIP-Admin</a>
        </div>
        
        <div class="h-4 w-full">
            <div class="h-full w-full bg-green-dark w-64"></div>
        </div>
    </div>
    
    
    <div class="flex flex-col mt-32 lg:w-1/2 xl:w-1/3 w-full justify-center border border-red-dark bg-grey-lightest rounded-lg shadow-lg overflow-hidden">
        <div class="absolute hidden -translate-50 self-center p-4 justify-center items-center bg-white rounded-full shadow sm:flex" style="margin-top: -128px">
            <img class="h-32 w-32 rounded-full" src="https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/45/45be9bd313395f74762c1a5118aee58eb99b4688_full.jpg"/>
        </div>
        <div class="flex flex-col p-4 justify-center items-center sm:p-6">
            <div class="flex flex-col self-stretch items-center justify-between sm:flex-row sm:items-start">
                <h2 class="text-grey-dark text-lg font-mono font-medium">#23858283</h2>
                <span class="mt-2 py-2 px-3 text-sm text-red-lightest font-bold bg-red rounded-lg sm:mt-0">RECUSADO</span>
            </div>
            
            <h2 class="mt-16 uppercase text-grey-dark text-center text-2xl font-normal tracking-wide">Valor total</h2>
            <p class="flex mt-8 pb-4 justify-center items-baseline text-center text-5xl">
                <span class="mr-1 text-3xl text-grey font-normal">R$</span>
                <span class="text-grey-darkest font-semibold">8,00</span>
            </p>
            
            <svg class="my-2 w-16 h-16 fill-current text-red-dark" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                 viewBox="0 0 426.667 426.667" xml:space="preserve">
                <path d="M213.333,0C95.514,0,0,95.514,0,213.333s95.514,213.333,213.333,213.333s213.333-95.514,213.333-213.333S331.153,0,213.333,0z M330.995,276.689l-54.302,54.306l-63.36-63.356l-63.36,63.36l-54.302-54.31l63.356-63.356l-63.356-63.36l54.302-54.302l63.36,63.356l63.36-63.356l54.302,54.302l-63.356,63.36L330.995,276.689z"/>
            </svg>
            
            
            <a href="#" class="mt-4 py-4 px-12 text-grey-darker text-xl font-normal no-underline hover:text-grey-darkest hover:underline">‹ Voltar ao VIP-Admin</a>
        </div>
        
        <div class="h-4 w-full">
            <div class="h-full w-full bg-red-dark w-64"></div>
        </div>
    </div>
    
    
    <div class="mt-32 lg:w-1/2 xl:w-1/3 w-full">
        <div class="bg-grey-lightest rounded-lg shadow-lg overflow-hidden border border-blue-dark">
            <div class="flex flex-wrap justify-center items-stretch p-4">
                <p class="mb-2 p-4 w-full text-center text-2xl text-grey-darkest">Escolha seu método de pagamento:</p>
                <div class="w-full sm:w-1/2 p-4 text-4xl">
                    <a href="#" class="trans h-32 flex py-3 px-10 sm:px-5 justify-center items-center text-grey-darkest rounded-lg bg-grey-lightest no-underline hover:shadow hover:bg-white">
                        <img class="max-w-full" src="https://logodownload.org/wp-content/uploads/2014/10/paypal-logo.png"/>
                    </a>
                </div>
                <div class="w-full sm:w-1/2 p-4 text-4xl">
                    <a href="#" class="trans h-32 flex py-3 px-10 sm:px-5 justify-center items-center text-grey-darkest rounded-lg bg-grey-lightest no-underline hover:shadow hover:bg-white">
                        <img class="max-w-full" src="http://www.freelogovectors.net/wp-content/uploads/2019/02/Mercadopago-logo.png"/>
                    </a>
                </div>
                <div class="w-full sm:w-1/2 p-4 text-4xl">
                    <a class="opacity-50 trans h-32 flex py-3 px-10 sm:px-5 justify-center items-center text-grey-darkest rounded-lg bg-grey-lightest no-underline">
                        <img class="max-w-full" src="https://cdn-images-1.medium.com/max/1200/1*NarjT54CL02HHKsSiw68zQ.png"/>
                    </a>
                </div>
                <div class="w-full sm:w-1/2 p-4 text-4xl">
                    <a href="#" class="trans h-32 flex py-3 px-10 sm:px-5 justify-center items-center text-grey-darkest rounded-lg bg-grey-lightest no-underline hover:shadow hover:bg-white">
                        <img class="max-w-full" src="https://logodownload.org/wp-content/uploads/2014/09/counter-strike-global-offensive-cs-go-logo.png"/>
                    </a>
                </div>
            </div>
            <div class="h-4 w-full">
                <div class="h-full w-full bg-blue-dark w-64"></div>
            </div>
        </div>
    </div>
</div>
</body>
</html>