<div class="px-8">
    <header class="mb-12 px-4">
        <h1 class="text-5xl">Pedidos</h1>
        <small class="text-xl text-gray-600 font-thin">Todos os pedidos gerados por você</small>
    </header>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 w-full">
        @foreach ($orders ?? [] as $order)
            <a
                class="
                group transition duration-150 slow
                w-full flex flex-col
                bg-white border rounded overflow-hidden cursor-pointer hover:shadow"
                href="{{ route('orders.show', $order) }}"
            >
                <!-- Body -->
                <div class="flex-grow p-6 pb-3">
                    <!-- Header -->
                    <div class="mb-5 flex justify-between">
                    <span class="text-gray-800 text-lg font-mono font-medium tracking-tighter select-all">
                        #{{ $order->id }}
                    </span>
                        @include('orders.status-badge-v2')
                    </div>

                    <!-- Duration -->
                    <div class="flex justify-between">
                        <!-- Left -->
                        <div class="flex items-center">
                            <span class="m-0 mr-2 text-gray-700" data-feather="credit-card"></span>
                            <span class="text-gray-800 text-sm">Duração</span>
                        </div>
                        <!-- Right -->
                        <div class="text-sm text-gray-600 tracking-tight">{{ $order->duration }} dia{{ $order->duration === 1 ? '' : 's'  }}</div>
                    </div>

                    <!-- HR -->
                    <div class="my-2 border-b border-gray-200"></div>

                    <!-- Remaining -->
                    <div class="flex justify-between">
                        <!-- Left -->
                        <div class="flex items-center">
                            <span class="m-0 mr-2 text-gray-700" data-feather="clock"></span>
                            <span class="text-gray-800 text-sm">Restante</span>
                        </div>
                        <!-- Right -->
                        <div class="text-sm text-gray-600 tracking-tight">
                            @if($remaining = $order->remaining)
                                {{ $remaining }} dia{{ $remaining === 1 ? '' : 's'  }}
                            @else
                                N/A
                            @endif
                        </div>
                    </div>

                    <!-- HR -->
                    <div class="my-2 border-b border-gray-200"></div>

                    <!-- Created at -->
                    <div class="flex justify-between">
                        <!-- Left -->
                        <div class="flex items-center">
                            <span class="m-0 mr-2 text-gray-700" data-feather="plus-square"></span>
                            <span class="text-gray-800 text-sm">Criado em</span>
                        </div>
                        <!-- Right -->
                        <div class="text-sm text-gray-600 tracking-tight">{{ $order->created_at->diffForHumans() }}</div>
                    </div>

                    <!-- Activate -->
                    @if(!$order->activated && $order->paid)
                        <div class="transition-colors duration-150
                            mt-4 py-2 w-full text-lg text-white text-center
                            bg-green-500 hover:bg-green-600 rounded"
                        >
                            Ativar
                        </div>
                    @endif
                </div>

            @if($order->activated || !$order->paid)
                <!-- More information -->
                    <div class="transition duration-150 opacity-0 group-hover:opacity-100 text-gray-400 text-xs font-thin text-center cursor-pointer">
                        Mais informações
                    </div>
            @endif

            @if($order->duration && $order->activated)
                <!-- Progress bar -->
                    <div
                        class="flex items-end justify-end h-4"
                        data-toggle="tooltip"
                        data-placement="bottom"
                        title="{{ round($remaining / $order->duration * 100) }}% restante"
                    >
                        <div class="h-1 bg-gray-200" style="width: {{ $remaining / $order->duration * 100 }}%"></div>
                    </div>
                @else
                    <div class="flex items-end justify-end h-4"></div>
                @endif
            </a>
        @endforeach
    </div>

</div>
