@extends('students.layouts.app4')

@section('title', __('student_follow_up_student.title'))

@section('css')
    @include('students.student_follow_ups.partials.styles')
@endsection

@section('content')
<main class="main-panel student-followup-view">
    <div class="content-wrapper">
        <div class="sfu-student-page">
            <header class="sfu-student-header">
                <div class="sfu-student-header__copy">
                    <span class="sfu-student-eyebrow">{{ __('student_follow_up_student.title') }}</span>
                    <h1>{{ __('student_follow_up_student.title') }}</h1>
                    <p>{{ __('student_follow_up_student.subtitle') }}</p>
                </div>
                <div class="sfu-student-year" aria-label="{{ __('student_follow_up_student.academic_year') }}">
                    <span>{{ __('student_follow_up_student.academic_year') }}</span>
                    <strong>{{ optional($year)->name ?: __('student_follow_up_student.unknown') }}</strong>
                </div>
            </header>

            @if (!$year)
                <section class="sfu-student-empty" role="status">
                    <i class="mdi mdi-calendar-alert-outline" aria-hidden="true"></i>
                    <h2>{{ __('student_follow_up_student.no_active_year_title') }}</h2>
                    <p>{{ __('student_follow_up_student.no_active_year') }}</p>
                </section>
            @else
                <form class="sfu-student-toolbar" method="get" action="{{ route('dashboard.student.follow_ups') }}">
                    <div class="sfu-student-field">
                        <label for="sfu-month">{{ __('student_follow_up_student.month') }}</label>
                        <select id="sfu-month" name="month">
                            @php $monthChoices = (clone $availableMonths)->push($selectedMonth)->unique()->sortDesc(); @endphp
                            @foreach ($monthChoices as $month)
                                @php $monthNumber = (int) substr($month, 5, 2); @endphp
                                <option value="{{ $month }}" {{ $selectedMonth === $month ? 'selected' : '' }}>
                                    {{ __('student_follow_up_student.months.' . $monthNumber) }} {{ substr($month, 0, 4) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="sfu-student-field">
                        <label for="sfu-subject">{{ __('student_follow_up_student.subject') }}</label>
                        <select id="sfu-subject" name="lesson_id">
                            <option value="">{{ __('student_follow_up_student.all_subjects') }}</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ (int) $selectedLessonId === (int) $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="sfu-student-filter" type="submit">{{ __('student_follow_up_student.show') }}</button>
                </form>

                @if ($availableMonths->isEmpty())
                    <section class="sfu-student-empty" role="status">
                        <i class="mdi mdi-notebook-outline" aria-hidden="true"></i>
                        <h2>{{ __('student_follow_up_student.no_year_records_title') }}</h2>
                        <p>{{ __('student_follow_up_student.no_year_records') }}</p>
                    </section>
                @elseif (!$pagination || $pagination->total() === 0)
                    <section class="sfu-student-empty" role="status">
                        <i class="mdi mdi-notebook-outline" aria-hidden="true"></i>
                        <h2>{{ $selectedLessonId ? __('student_follow_up_student.no_subject_records_title') : __('student_follow_up_student.no_month_records_title') }}</h2>
                        <p>{{ $selectedLessonId ? __('student_follow_up_student.no_subject_records') : __('student_follow_up_student.no_month_records') }}</p>
                    </section>
                @else
                    <section class="sfu-student-month" aria-labelledby="sfu-month-title">
                        <div class="sfu-student-month__heading">
                            <div>
                                <span class="sfu-student-eyebrow">{{ __('student_follow_up_student.month') }}</span>
                                <h2 id="sfu-month-title">{{ __('student_follow_up_student.months.' . ((int) substr($selectedMonth, 5, 2))) }} {{ substr($selectedMonth, 0, 4) }}</h2>
                            </div>
                            <span class="sfu-student-count">{{ $pagination->total() }}</span>
                        </div>

                        <div class="sfu-student-subject-list">
                            @foreach ($followUps as $records)
                                @php $subject = optional($records->first())->lesson; @endphp
                                <section class="sfu-student-subject" aria-labelledby="sfu-subject-{{ optional($subject)->id ?: 'unknown' }}">
                                    <header class="sfu-student-subject__heading">
                                        <i class="mdi mdi-book-open-page-variant-outline" aria-hidden="true"></i>
                                        <h3 id="sfu-subject-{{ optional($subject)->id ?: 'unknown' }}">{{ optional($subject)->name ?: __('student_follow_up_student.unknown') }}</h3>
                                    </header>
                                    <div class="sfu-student-entry-list">
                                        @foreach ($records as $followUp)
                                            @php
                                                $teacher = optional($followUp->teacher);
                                                $teacherName = trim($teacher->first_name . ' ' . $teacher->last_name);
                                                $recordedClass = optional($followUp->classRoom)->name ?: optional(optional($followUp->room)->classes)->name;
                                            @endphp
                                            <article class="sfu-student-entry">
                                                <div class="sfu-student-entry__meta">
                                                    <div class="sfu-student-entry__teacher">
                                                        <span>{{ __('student_follow_up_student.teacher') }}</span>
                                                        <strong>{{ $teacherName ?: __('student_follow_up_student.unknown') }}</strong>
                                                    </div>
                                                    @php $levelKey = in_array($followUp->level, ['weak', 'average', 'good', 'excellent'], true) ? $followUp->level : null; @endphp
                                                    @if ($levelKey)
                                                        <span class="sfu-student-level">
                                                            <span>{{ __('student_follow_up_student.level') }}</span>
                                                            <strong>{{ __('student_follow_up_student.levels.' . $levelKey) }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="sfu-student-entry__context">
                                                    @if ($recordedClass)<span>{{ __('student_follow_up_student.class') }}: {{ $recordedClass }}</span>@endif
                                                    @if ($followUp->room)<span>{{ __('student_follow_up_student.section') }}: {{ $followUp->room->name }}</span>@endif
                                                    @if ($followUp->observed_at)<time datetime="{{ $followUp->observed_at->toIso8601String() }}" dir="ltr">{{ $followUp->observed_at->timezone('Asia/Damascus')->format('Y/m/d - h:i A') }}</time>@endif
                                                    @if ($followUp->edited_at)<span class="sfu-student-edited">{{ __('student_follow_up_student.edited') }}</span>@endif
                                                </div>
                                                @if ($followUp->note)
                                                    <div class="sfu-student-note"><span>{{ __('student_follow_up_student.note') }}</span><p>{{ $followUp->note }}</p></div>
                                                @endif
                                            </article>
                                        @endforeach
                                    </div>
                                </section>
                            @endforeach
                        </div>
                    </section>
                    @if ($pagination->hasPages())
                        <nav class="sfu-student-pagination" aria-label="{{ __('student_follow_up_student.pagination') }}">{{ $pagination->links() }}</nav>
                    @endif
                @endif
            @endif
        </div>
    </div>
</main>
@endsection
