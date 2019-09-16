@component('partials.card')
    @slot('title')
        <div class="d-flex items-center justify-between">
            <span>Produtos</span>
            <div class="btn-group" role="group">
                <a class="btn btn-primary btn-sm" href="{{ route('products.create') }}">Novo produto</a>
            </div>
        </div>
    @endslot
    <table class="table">
        <thead>
        <tr>
            <th>Title</th>
            <th>Duration</th>
            <th>Cost</th>
            <th>Original Cost</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($products ?? [] as $product)
            <tr>
                <!-- Title -->
                <td>{{ $product->title }}</td>
                
                <!-- Duration -->
                <td>
                    <span class="badge badge-primary">{{ $product->duration }} dias</span>
                </td>
                
                <!-- Cost-->
                <td>
                    <span class="badge badge-primary">R$ {{ number_format($product->cost / 100, 2) }}</span>
                </td>
                
                <!-- Original Cost -->
                <td>
                    <span class="badge badge-primary">R$ {{ number_format($product->original_cost / 100, 2) }}</span>
                </td>
                
                <!-- Actions -->
                <td>
                    {!! Form::open(['url' => route('products.destroy', $product), 'method' => 'DELETE']) !!}
                    <div class="btn-group" role="group">
                        <a class="btn btn-outline-secondary btn-sm" href="{{ route('products.edit', $product) }}">Editar</a>
                        <button class="btn btn-danger btn-sm">Deletar</button>
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100"><h5 class="text-center">No products!</h5></td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endcomponent