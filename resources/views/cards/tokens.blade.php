@component('partials.card')
    @slot('title')
        <div class="d-flex items-center justify-between">
            <span>Tokens</span>
            <div class="btn-group" role="group">
                <a class="btn btn-primary btn-sm" href="{{ route('tokens.create') }}">Criar token</a>
                @if($viewRoute ?? false)
                    <a class="btn btn-outline-dark btn-sm" href="{{ route('tokens.index') }}">View tokens</a>
                @endif
            </div>
        </div>
    @endslot
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Duration</th>
            <th>Note</th>
            <th>Status</th>
            <th>Admin</th>
            <th>Created at</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($tokens ?? [] as $token)
            <tr>
                <!-- ID -->
                <td>
                    <code><a href="{{ route('tokens.show', $token) }}">{{ $token->id }}</a></code>
                </td>
                
                <!-- Duration -->
                <td>
                    <span class="badge badge-primary">{{ $token->duration }} dias</span>
                </td>
                
                <!-- Note -->
                <td>
                    <pre>{{ $token->note }}</pre>
                </td>
                
                <!-- Status -->
                <td>
                    @if($token->order)
                        <span class="badge badge-dark">Usado</span>
                    @else
                        <span class="badge badge-primary">Pendente</span>
                    @endif
                </td>
                
                <!-- Admin -->
                <td>{{ $token->user->username ?? 'Sistema'}}</td>
                
                <!-- Expires at -->
                <td>{{ $token->expires_at ? $token->expires_at->diffForHumans() : 'N/A' }}</td>
                
                <!-- Actions -->
                <td>
                    <div class="btn-group" role="group">
                        @if(!$token->order)
                            <a class="btn btn-primary btn-sm" href="#">Edit</a>
                        @endif
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100"><h5 class="text-center">No tokens!</h5></td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endcomponent