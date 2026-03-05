@php
    $tone = $tone ?? 'violet';
    $toneMap = [
        'violet' => ['text' => '#2f2b3a'],
        'emerald' => ['text' => '#145c42'],
    ];
    $palette = $toneMap[$tone] ?? $toneMap['violet'];
@endphp

<div class="card h-100 border-0 kpi-card" style="border-radius:16px;border-top:4px solid #3B82F6;box-shadow:0 6px 18px rgba(59,130,246,0.08);transition:all .25s ease;">
    <div class="card-body d-flex align-items-center justify-content-between" style="flex-direction:row-reverse;text-align:right;gap:.85rem;">
        <div style="flex:1;">
            <div style="font-size:.9rem;color:#8a869a;">{{ $label }}</div>
            <div style="font-size:1.45rem;font-weight:800;color:{{ $palette['text'] }};">{{ $value }}</div>
        </div>
        <span class="{{ $icon }} kpi-icon" style="font-size:1.15rem;background:rgba(59,130,246,0.1);color:#3B82F6;width:42px;height:42px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;transition:all .25s ease;"></span>
    </div>
</div>
