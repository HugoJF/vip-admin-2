@component('partials.card')
    @slot('title')
        <div class="d-flex items-center justify-between">
            <span>Admins</span>
            <div class="btn-group" role="group">
                <a class="btn btn-outline-primary btn-sm" href="{{ route('admins.create') }}">Criar novo admin</a>
            </div>
        </div>
    @endslot
    <table class="table">
        <thead>
        <tr>
            <th>Username</th>
            <th>SteamID</th>
            <th>Note</th>
            <th>Flags</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($admins ?? [] as $admin)
            <tr>
                <!-- Username -->
                <td>{{ $admin->username }}</td>
                
                <!-- Tradelink -->
                <td><code>{{ $admin->steamid }}</code></td>
                
                <!-- Note -->
                <td>{{ $admin->note }}</td>
                
                <!-- Flags -->
                <td><code>{{ $admin->flags }}</code></td>
                
                <!-- Actions -->
                <td>
                    {!! Form::open(['url' => route('admins.destroy', $admin), 'method' => 'DELETE']) !!}
                    <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100"><h5 class="text-center">Sem admins!</h5></td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endcomponent