@extends('website.layouts.app')

@section('css')
<style>
    .school-apps-heading.sch-page-hero { padding-block: clamp(1.5rem, 4vw, 2.75rem) 1rem; }
    .school-apps-heading .sch-section-head { margin-bottom: 0; }
    .school-apps-heading h1 { margin: 0; font-size: clamp(1.5rem, 4vw, 2.25rem); line-height: 1.5; font-weight: 800; color: var(--sch-text); }
    .school-apps { padding-block: 1rem clamp(2rem, 5vw, 3.5rem); }
    .school-apps__grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 1.5rem; max-width: 960px; margin-inline: auto; }
    .school-apps__grid.is-parent { grid-template-columns: minmax(0, 1fr); max-width: 620px; }
    .school-apps__card { display: flex; flex-direction: column; align-items: center; border: 1px solid var(--sch-border); border-radius: 20px; background: var(--sch-surface); box-shadow: var(--sch-shadow); padding: clamp(1.25rem, 4vw, 2.5rem); text-align: center; min-width: 0; overflow-wrap: anywhere; }
    .school-apps__icon { display: inline-flex; align-items: center; justify-content: center; width: 76px; height: 76px; flex: 0 0 76px; border: 1px solid var(--sch-border); border-radius: 18px; background: var(--sch-bg); color: var(--sch-primary); margin-bottom: 1.25rem; }
    .school-apps__icon img { width: 100%; height: 100%; object-fit: contain; border-radius: inherit; }
    .school-apps__card h2 { font-size: clamp(1.25rem, 3vw, 1.6rem); line-height: 1.6; margin-bottom: .75rem; }
    .school-apps__card p { line-height: 1.9; max-width: 44ch; color: var(--sch-muted); margin-bottom: 1.5rem; }
    .school-apps__card .pbmit-btn { display: inline-flex; align-items: center; justify-content: center; min-height: 48px; width: 100%; max-width: 320px; padding: .85rem 1.25rem; white-space: normal; margin-top: auto; }
    .school-apps__card .pbmit-btn:focus-visible { outline: 3px solid var(--sch-primary); outline-offset: 4px; }
    .school-apps__meta { display: flex; justify-content: center; flex-wrap: wrap; gap: .5rem 1rem; width: 100%; margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid var(--sch-border); font-size: .875rem; color: var(--sch-muted); }
    .school-apps__meta bdi { font-weight: 700; color: var(--sch-text); }
    .school-apps__card .school-apps__empty { background: var(--sch-bg); border-radius: 12px; padding: .85rem 1rem; margin: auto 0 0; width: 100%; }
    @media (max-width: 991px) { .school-apps__grid { grid-template-columns: minmax(0, 1fr); max-width: 620px; } }
</style>
@endsection

@section('content')
<section class="sch-section sch-page-hero school-apps-heading">
    <div class="container"><div class="sch-section-head">
        <h1>{{ __('app_downloads.'.($staff ? 'staff_title' : 'parent_title')) }}</h1>
    </div></div>
</section>
<section class="sch-section school-apps" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <div class="container">
        <div class="school-apps__grid {{ $staff ? '' : 'is-parent' }}">
            @foreach($releases as $key => $release)
            @php($iconPath = 'assets/images/apps/'.str_replace('_', '-', $key).'.png')
            <article class="school-apps__card">
                <span class="school-apps__icon" aria-hidden="true">
                    @if(is_file(public_path($iconPath)))
                    <img src="{{ asset($iconPath) }}" alt="" width="76" height="76">
                    @else
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="6" y="2" width="12" height="20" rx="3"/><path d="M10 5h4M11 19h2"/></svg>
                    @endif
                </span>
                @if($staff)<h2>{{ __('app_downloads.'.$key.'_title') }}</h2>@endif
                <p>{{ __('app_downloads.'.$key.'_description') }}</p>
                @if($release)
                    <a class="pbmit-btn" href="{{ route('mobile-applications.download', ['slug' => str_replace('_', '-', $key)]) }}">{{ __('app_downloads.download') }}</a>
                    <div class="school-apps__meta">
                        <span>{{ __('app_downloads.version') }}: <bdi>{{ $release->version }}</bdi></span>
                        <span>{{ __('app_downloads.updated') }}: <bdi>{{ $release->published_at->format('Y-m-d') }}</bdi></span>
                    </div>
                @else
                    <p class="school-apps__empty" role="status">{{ __('app_downloads.unavailable') }}</p>
                @endif
            </article>
            @endforeach
        </div>
    </div>
</section>
@endsection
