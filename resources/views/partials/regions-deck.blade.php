<div class="region-deck">
    @foreach ($regions as $region)
        <a href="{{ route('servers.select', $region) }}" class="region">
            <div class="flag">@include("flags." . ($region->flag ?? 'brazil'))</div>
            <div class="info">
                <h2 class="country">{{ $region->country }}</h2>
                <h4 class="name">{{ $region->name }}</h4>
            </div>
        </a>
    @endforeach
</div>