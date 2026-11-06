<section class="card mt-3 gb-occurrences" aria-labelledby="gradebook-occurrences-title" dir="rtl"
    data-occurrence-url="{{ route('teacher.gradebook.assessment.save') }}" data-token="{{ csrf_token() }}"
    data-room="{{ $room->id }}" data-subject="{{ $subject->id }}"
    data-saving="{{ __('gradebook.saving') }}" data-saved="{{ __('gradebook.saved') }}"
    data-failed="{{ __('gradebook.save_failed') }}" data-pending="{{ __('gradebook.leave_pending') }}">
    <div class="card-header">
        <h4 id="gradebook-occurrences-title" class="mb-2">{{ __('gradebook_occurrences.title') }}</h4>
        <p class="mb-1">{{ $year->name }} / {{ $term->term }} / {{ $subject->name }} / {{ $room->name }}</p>
        <p class="text-muted mb-0">{{ __('assessment_entry.entry_help') }}</p>
    </div>
    <div class="card-body">
        @if(count($gradebook['issues']))
            <p class="alert alert-warning" role="status">{{ __('gradebook.review_notice') }}</p>
        @endif
        @if($assessmentColumns->isEmpty())
            <p class="text-muted mb-0">{{ __('gradebook.empty') }}</p>
        @else
            <div class="table-responsive" tabindex="0" role="region" aria-labelledby="gradebook-occurrences-title">
                <table class="table table-bordered text-center mb-0">
                    <thead>
                    <tr>
                        <th scope="col">{{ __('gradebook.student') }}</th>
                        @foreach($assessmentColumns as $assessment)
                            <th scope="col" data-assessment="{{ $assessment['key'] }}" data-window="{{ $assessment['window'] }}"
                                data-room="{{ $assessment['room_id'] }}" data-term="{{ $assessment['term_id'] }}">
                                <span class="d-block">{{ $assessment['name'] }}</span>
                                <small class="d-block">{{ __('gradebook.'.$assessment['type']) }}</small>
                                <small class="d-block">{{ __('gradebook_occurrences.original_maximum') }}: {{ $assessment['maximum'] ?? '-' }}</small>
                                <span class="badge badge-light my-1">{{ __('gradebook_occurrences.'.$assessment['window']) }}</span>
                                @unless($assessment['entry_allowed'])<small class="d-block text-muted">{{ __('assessment_entry.'.$assessment['entry_reason']) }}</small>@endunless
                                <small class="d-block">{{ __('gradebook_occurrences.start') }}: <bdi dir="ltr">{{ $assessment['start'] ?: '-' }}</bdi></small>
                                <small class="d-block">{{ __('gradebook_occurrences.end') }}: <bdi dir="ltr">{{ $assessment['end'] ?: '-' }}</bdi></small>
                                @if($assessment['duration'] !== null)
                                    <small class="d-block">{{ __('gradebook_occurrences.duration') }}: {{ $assessment['duration'] }}</small>
                                @endif
                                <a class="btn btn-sm btn-outline-primary mt-2" href="{{ route($assessment['type'] === 'quiz' ? 'teacher_quize_students' : 'teacher_exam_students', [$room->id, $teacher->id, $subject->id, $assessment['id']]) }}">{{ __('gradebook_occurrences.original_page') }}</a>
                            </th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($students as $resultStudent)
                        <tr data-student="{{ $resultStudent->id }}">
                            <th scope="row">{{ $resultStudent->first_name }} {{ $resultStudent->last_name }}</th>
                            @foreach($assessmentColumns as $assessment)
                                @php($resolved = $assessment['results'][$resultStudent->id] ?? [])
                                <td data-assessment="{{ $assessment['key'] }}" data-result="{{ $resolved['result_id'] ?? '' }}">@if($assessment['entry_allowed'] && !in_array($resolved['state'] ?? '', ['carried','conflict'], true))<input type="number" class="form-control text-center occurrence-input" min="0" step="any" inputmode="decimal"
                                        max="{{ $assessment['maximum'] }}" value="{{ $resolved['value'] ?? '' }}"
                                        data-student="{{ $resultStudent->id }}" data-exam="{{ $assessment['id'] }}" data-accepted="{{ $resolved['value'] ?? '' }}"
                                        aria-label="{{ $resultStudent->first_name }} {{ $resultStudent->last_name }} - {{ $assessment['name'] }}">
                                    <small class="occurrence-state d-block" role="status" aria-live="polite"></small>
                                    <button type="button" class="btn btn-sm btn-outline-danger occurrence-retry" hidden>{{ __('gradebook.retry') }}</button>
                                @else{{ $resolved['value'] ?? '-' }}@endif
                                @include('gradebook.continuity_badge', ['resolved' => $resolved])</td>
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</section>
