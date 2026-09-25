@php
    $color = $color ?? '#2563eb';
    $soft = $soft ?? '#eff6ff';
@endphp

<article class="rsd-stat" style="--stat-color: {{ $color }}; --stat-soft: {{ $soft }};">
    <span class="rsd-stat__icon"><i class="{{ $icon ?? 'fa fa-chart-bar' }}"></i></span>
    <div class="rsd-stat__label">{{ $label ?? 'Metric' }}</div>
    <div class="rsd-stat__value">{{ $value ?? '0' }}</div>
    <div class="rsd-stat__desc">{{ $desc ?? '' }}</div>
</article>
