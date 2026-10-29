@extends('admin.master')
@section('content')
<section class="card m-3" dir="rtl">
    <div class="card-header"><h3>{{ __('gradebook.equivalence') }}</h3></div>
    <div class="card-body">
        <p>{{ __('gradebook.equivalence_help') }}</p>
        @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if($errors->any()) <div class="alert alert-danger" role="alert">{{ $errors->first() }}</div> @endif
        @if(!$available)
            <p class="alert alert-warning">{{ __('gradebook.equivalence_unavailable') }}</p>
        @else
            <form method="get" action="{{ route('admin.gradebook.equivalence') }}" class="row mb-3">
                <div class="col-md-4"><label for="mapping-year">{{ __('gradebook.year') }}</label>
                    <select name="year_id" id="mapping-year" class="form-control" required>
                        <option value="">-</option>
                        @foreach($years as $year)<option value="{{ $year->id }}" {{ (string)request('year_id') === (string)$year->id ? 'selected' : '' }}>{{ $year->name }}</option>@endforeach
                    </select>
                </div>
                <div class="col-md-6"><label for="mapping-subject">{{ __('gradebook.subject') }}</label>
                    <select name="lesson_id" id="mapping-subject" class="form-control" required>
                        <option value="">-</option>
                        @foreach($subjects as $subject)<option value="{{ $subject->id }}" {{ (string)request('lesson_id') === (string)$subject->id ? 'selected' : '' }}>{{ optional($subject->classes)->name }} / {{ $subject->name }}</option>@endforeach
                    </select>
                </div>
                <div class="col-md-2 align-self-end"><button class="btn btn-secondary mt-2">{{ __('gradebook.load') }}</button></div>
            </form>
            @if($assessments->isNotEmpty())
                <form method="post" action="{{ route('admin.gradebook.equivalence.store') }}">
                    @csrf
                    <div class="table-responsive">
                        <table class="table table-bordered"><tbody>
                        @foreach($assessments as $assessment)
                            <tr><td><input type="checkbox" name="exam_ids[]" value="{{ $assessment->id }}" id="mapping-{{ $assessment->id }}"></td>
                                <td><label for="mapping-{{ $assessment->id }}">#{{ $assessment->id }} {{ $assessment->name }} / {{ $assessment->room_name }}</label></td>
                                <td>{{ $assessment->term }}</td><td>{{ __('gradebook.'.((int)$assessment->type === 1 ? 'exam' : 'quiz')) }} / {{ $assessment->mark }}</td></tr>
                        @endforeach
                        </tbody></table>
                    </div>
                    <label for="mapping-evidence">{{ __('gradebook.equivalence_evidence') }}</label>
                    <textarea class="form-control mb-3" id="mapping-evidence" name="evidence" required maxlength="2000">{{ old('evidence') }}</textarea>
                    <label><input type="checkbox" name="confirmed" value="1" required> {{ __('gradebook.equivalence_confirm') }}</label>
                    <button class="btn btn-primary d-block mt-3">{{ __('gradebook.save_mapping') }}</button>
                </form>
            @else <p>{{ __('gradebook.empty') }}</p> @endif
        @endif
    </div>
</section>
@endsection
