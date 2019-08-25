@php
    $color = $color ?? 'blue';
    $mod = $color === 'yellow' ? '-dark' : '';
    $text = $text ?? '';
    $pulse = $pulse ?? false;
@endphp

<div class="inline-block py-0 px-2 bg-{{ $color }}{{ $mod }} {{ $pulse ? 'pulse-' . $color : '' }} font-semibold text-{{ $color }}-lightest text-sm rounded-lg">{{ $text }}</div>