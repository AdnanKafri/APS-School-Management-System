<section class="card">
    <div class="card-header"><h3>{{ __('gradebook_ui.choose_class') }}</h3><span class="badge badge-primary">{{ $year->name }}</span></div>
    <div class="table-responsive" tabindex="0" role="region" aria-label="{{ __('gradebook_ui.classes') }}">
        <table class="table table-hover gb-table">
            <thead><tr><th scope="col">{{ __('gradebook_ui.class') }}</th><th scope="col">{{ __('gradebook_ui.year') }}</th><th scope="col">{{ __('gradebook_ui.actions') }}</th></tr></thead>
            <tbody>
            @forelse($classes as $item)
                <tr><th scope="row">{{ $item->name }}</th><td>{{ $year->name }}</td><td><a class="btn btn-outline-primary" href="{{ route($sectionRoute, $item->id) }}">{{ __('gradebook_ui.sections') }}</a></td></tr>
            @empty
                <tr><td colspan="3">{{ __('gradebook_ui.empty') }}</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body pt-0">{{ $classes->links() }}</div>
</section>
