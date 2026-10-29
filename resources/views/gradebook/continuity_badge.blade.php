@if(($resolved['state'] ?? null) === 'carried')
    <small class="d-block text-info" data-continuity="carried">{{ __('gradebook.carried') }}</small>
    <small class="d-block text-muted">{{ $resolved['room_name'] }} / {{ $resolved['assessment_name'] }}
        <span dir="ltr">#{{ $resolved['exam_id'] }} / #{{ $resolved['result_id'] }}</span>
    </small>
@elseif(($resolved['state'] ?? null) === 'conflict')
    <small class="d-block text-warning" data-continuity="conflict">{{ __('gradebook.ambiguous_result') }}</small>
@endif
