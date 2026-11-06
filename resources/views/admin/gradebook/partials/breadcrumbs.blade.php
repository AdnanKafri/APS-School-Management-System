<nav class="gb-breadcrumbs" aria-label="{{ __('gradebook_ui.navigation') }}">
    <a href="{{ route('dashboard.index') }}">{{ __('gradebook_ui.home') }}</a>
    <span aria-hidden="true">/</span>
    <a href="{{ route('admin.gradebook.index') }}">{{ __('gradebook_ui.gradebook') }}</a>
    @foreach($items ?? [] as $item)
        <span aria-hidden="true">/</span>
        @if(!empty($item['url']))
            <a href="{{ $item['url'] }}">{{ $item['label'] }}</a>
        @else
            <span aria-current="page">{{ $item['label'] }}</span>
        @endif
    @endforeach
</nav>
