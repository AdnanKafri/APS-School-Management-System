<section class="card mt-3" aria-label="{{ __('gradebook.assessment_results') }}" dir="rtl">
    <div class="card-header">
        <h4 class="mb-1">{{ __('gradebook.assessment_results') }}</h4>
        <p class="text-muted mb-0">{{ __('gradebook.read_only') }}</p>
    </div>
    <div class="card-body">
        @if(count($gradebook['issues']))
            <p class="alert alert-warning" role="status">{{ __('gradebook.review_notice') }}</p>
        @endif
        @forelse($gradebook['assessments']->groupBy('term_id') as $termAssessments)
            <h5>{{ $termAssessments->first()['term_name'] }}</h5>
            <div class="table-responsive mb-3" tabindex="0">
                <table class="table table-bordered text-center">
                    <thead>
                    <tr>
                        <th scope="col">{{ __('gradebook.student') }}</th>
                        @foreach($termAssessments as $assessment)
                            <th scope="col" data-assessment="{{ $assessment['key'] }}">
                                {{ $assessment['name'] }}
                                <small class="d-block">{{ __('gradebook.'.$assessment['type']) }}
                                    @if($assessment['maximum'] !== null) / {{ $assessment['maximum'] }} @endif
                                </small>
                                @if($assessment['start'])
                                    <small class="d-block" dir="ltr">{{ $assessment['start'] }}</small>
                                @endif
                            </th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($students as $resultStudent)
                        <tr>
                            <th scope="row">{{ $resultStudent->first_name }} {{ $resultStudent->last_name }}</th>
                            @foreach($termAssessments as $assessment)
                                <td>{{ $assessment['results'][$resultStudent->id]['value'] ?? '-' }}@include('gradebook.continuity_badge', ['resolved' => $assessment['results'][$resultStudent->id] ?? []])</td>
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @empty
            <p class="text-muted mb-0">{{ __('gradebook.empty') }}</p>
        @endforelse
        @if(!empty($gradebook['historical']) && $gradebook['historical']->isNotEmpty())
            <details class="mt-3">
                <summary>{{ __('gradebook.unmapped_history') }}</summary>
                <p class="text-muted">{{ __('gradebook.unmapped_notice') }}</p>
                <ul>
                @foreach($gradebook['historical'] as $historical)
                    @php($historyStudent = $students->firstWhere('id', $historical['student_id']))
                    @if($historyStudent)
                        <li>{{ $historyStudent->first_name }} {{ $historyStudent->last_name }}:
                            {{ $historical['name'] }} / {{ $historical['term'] }}: {{ $historical['value'] }}
                            <small dir="ltr">#{{ $historical['exam_id'] }} / #{{ $historical['result_id'] }}</small>
                        </li>
                    @endif
                @endforeach
                </ul>
            </details>
        @endif
    </div>
</section>
