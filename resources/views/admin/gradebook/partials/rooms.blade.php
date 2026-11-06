<section class="card">
    <div class="card-header"><h3>{{ __('gradebook_ui.choose_section') }}</h3></div>
    <div class="table-responsive" tabindex="0" role="region" aria-label="{{ __('gradebook_ui.sections') }}">
        <table class="table table-hover gb-table">
            <thead><tr><th scope="col">{{ __('gradebook_ui.section') }}</th><th scope="col">{{ __('gradebook_ui.class') }}</th><th scope="col">{{ __('gradebook_ui.year') }}</th><th scope="col">{{ __('gradebook_ui.actions') }}</th></tr></thead>
            <tbody>
            @forelse($rooms as $item)
                <tr><th scope="row">{{ $item->name }}</th><td>{{ $item->classes->name }}</td><td>{{ $item->year->name }}</td><td><a class="btn btn-outline-primary" href="{{ route($destinationRoute, $item->id) }}">{{ $destinationLabel }}</a></td></tr>
            @empty
                <tr><td colspan="4">{{ __('gradebook_ui.empty') }}</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body pt-0">{{ $rooms->links() }}</div>
</section>
