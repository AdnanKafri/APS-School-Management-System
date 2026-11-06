<h3 class="h5">{{ $payload['definition']['name_ar'] }}</h3>
@if($payload['definition']['name_en'])<p>{{ $payload['definition']['name_en'] }}</p>@endif
<p>{{ $payload['scope']['year_name'] }} / {{ $payload['scope']['class_name'] }} / {{ $payload['scope']['lesson_name'] }}</p>
<div class="table-responsive"><table class="table table-bordered">
    <thead><tr><th>#</th><th>{{ __('gradebook_templates.component') }}</th><th>{{ __('gradebook_templates.name_en') }}</th><th>{{ __('gradebook_templates.maximum') }}</th></tr></thead>
    <tbody>@foreach($payload['definition']['components'] as $component)<tr><td>{{ $component['order'] }}</td><td>{{ $component['name_ar'] }}</td><td>{{ $component['name_en'] ?: '—' }}</td><td>{{ $component['maximum'] }}</td></tr>@endforeach</tbody>
    <tfoot><tr><th colspan="3">{{ __('gradebook_templates.total') }}</th><td>{{ array_sum(array_column($payload['definition']['components'], 'maximum')) }}</td></tr></tfoot>
</table></div>
