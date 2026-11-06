@foreach($studentMarks as $item)
    @php($termData = $item[$termKey] ?? [])
    <section class="card gb-subject-summary" data-summary-subject="{{ $item['subject_id'] }}" data-summary-term="{{ $termData['term_id'] ?? '' }}">
        <div class="card-header"><h5>{{ $item['name'] }}</h5></div>
        <div class="table-responsive" tabindex="0" role="region" aria-label="{{ $item['name'] }}">
            <table class="table table-bordered">
                <thead><tr><th scope="col">{{ __('gradebook_distribution.component') }}</th><th scope="col">{{ __('gradebook_distribution.configured_maximum') }}</th><th scope="col">{{ __('gradebook_distribution.earned') }}</th></tr></thead>
                <tbody>
                @forelse($termData['components'] ?? [] as $component)
                    <tr data-component="{{ $component['id'] }}">
                        <th scope="row">{{ $component['name'] }}</th>
                        <td>{{ $component['maximum'] ?? '-' }}</td>
                        <td>{{ $component['value'] ?? '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3">{{ __('gradebook_distribution.no_components') }}</td></tr>
                @endforelse
                </tbody>
                <tfoot><tr><th scope="row" colspan="2">{{ __('gradebook_distribution.total') }}</th><td>{{ $termData['total'] ?? '-' }}</td></tr></tfoot>
            </table>
        </div>
    </section>
@endforeach
