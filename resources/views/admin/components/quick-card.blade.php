<a href="{{ route($route) }}" class="text-decoration-none d-block h-100">
    <div class="card h-100 border-0 quick-action-card" style="border-radius:16px;box-shadow:0 10px 24px rgba(57,35,114,.08);border:1px solid rgba(59,130,246,0.15);transition:all .25s ease;">
        <div class="card-body">
            <div class="d-flex align-items-center mb-2" style="text-align:right;">
                <span class="{{ $icon }} quick-card-icon" style="font-size:1.05rem;background:rgba(59,130,246,0.1);color:#3B82F6;width:38px;height:38px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;margin-inline-end:.6rem;transition:all .25s ease;"></span>
                <h5 class="mb-0" style="font-size:1.05rem;font-weight:700;color:#2f2b3a;">{{ $title }}</h5>
            </div>
            <p class="mb-0" style="font-size:.9rem;color:#8a869a;line-height:1.5;text-align:right;">{{ $desc }}</p>
        </div>
    </div>
</a>
