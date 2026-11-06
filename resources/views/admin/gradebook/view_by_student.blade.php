@extends('admin.gradebook.layout')
@section('page_title', __('gradebook_ui.student_card'))
@section('page_subtitle', __('gradebook_ui.review_help'))

@section('breadcrumbs')
    @include('admin.gradebook.partials.breadcrumbs', ['items'=>array_merge([['label'=>__('gradebook_ui.review'), 'url'=>route('admin.gradebook.view_options')], ['label'=>__('gradebook_ui.classes'), 'url'=>route('admin.gradebook.view_classes_student')]], $room ? [['label'=>$room->name, 'url'=>route('admin.gradebook.view_students', $room->id)]] : [], [['label'=>__('gradebook_ui.student_card')]])])
@endsection

@section('gradebook-content')
<div class="container-fluid mt-5">
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0"><i class="fas fa-user-graduate" aria-hidden="true"></i> بطاقة الطالب: <span>{{ $student->first_name }} {{ $student->last_name }}</span></h4>
            <div>
                <span class="badge badge-light ml-2">{{ $room ? optional($room->classes)->name : '' }}</span>
                <span class="badge badge-secondary">{{ $room->name ?? '' }}</span>
                <span class="badge badge-light">{{ $year->name }}</span>
            </div>
        </div>
        <div class="card-body">
            <p class="text-muted">{{ __('gradebook.summary_notice') }}</p>
            
            @if(empty($studentMarks))
                <div class="alert alert-warning text-center">لا توجد سجلات علامات لهذا الطالب.</div>
            @else
                
                <!-- Tabs -->
                <nav>
                    <div class="nav nav-tabs nav-justified" id="studentTabs" role="tablist">
                        <a class="nav-item nav-link active font-weight-bold" id="nav-term1-tab" data-toggle="tab" href="#nav-term1" role="tab"><i class="fas fa-calendar-check ml-2"></i>الفصل الأول</a>
                        <a class="nav-item nav-link font-weight-bold" id="nav-term2-tab" data-toggle="tab" href="#nav-term2" role="tab"><i class="fas fa-calendar-check ml-2"></i>الفصل الثاني</a>
                        <a class="nav-item nav-link font-weight-bold text-success" id="nav-final-tab" data-toggle="tab" href="#nav-final" role="tab"><i class="fas fa-award ml-2"></i>المحصلة النهائية</a>
                    </div>
                </nav>

                <div class="tab-content py-3" id="nav-tabContent">

                    <!-- Term 1 -->
                    <div class="tab-pane fade show active" id="nav-term1" role="tabpanel" aria-labelledby="nav-term1-tab" aria-label="{{ __('gradebook.term_one') }}">
                        @include('admin.gradebook.partials.student_components', ['termKey'=>'term1'])
                    </div>

                    <!-- Term 2 -->
                    <div class="tab-pane fade" id="nav-term2" role="tabpanel" aria-labelledby="nav-term2-tab" aria-label="{{ __('gradebook.term_two') }}">
                        @include('admin.gradebook.partials.student_components', ['termKey'=>'term2'])
                    </div>

                    <!-- Final -->
                    <div class="tab-pane fade" id="nav-final" role="tabpanel" aria-labelledby="nav-final-tab">
                        <p class="text-muted small">{{ __('gradebook_ux.result_notice') }}</p>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover text-center">
                                <thead class="bg-success text-white">
                                    <tr>
                                        <th class="text-right" style="width:300px;">المادة</th>
                                        <th>الفصل الأول</th>
                                        <th>الفصل الثاني</th>
                                        <th>المحصلة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($studentMarks as $item)
                                        @php
                                            $t1Total = $item['term1']['total'] ?? null;
                                            $t2Total = $item['term2']['total'] ?? null;
                                            $final = $item['total']; // logic handled in controller sum
                                            
                                        @endphp
                                        <tr>
                                            <td class="text-right font-weight-bold">{{ $item['name'] }}</td>
                                            <td>{{ $t1Total !== null ? $t1Total : '-' }}</td>
                                            <td>{{ $t2Total !== null ? $t2Total : '-' }}</td>
                                            <td class="font-weight-bold border-left border-right">{{ $final !== null ? $final : '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            @endif
        </div>
        <div class="card-footer text-muted text-center">
            بطاقة إلكترونية - تحديث فوري
        </div>
    </div>
</div>
@foreach($subjectGradebooks as $subjectGradebook)
    <h4>{{ $subjectGradebook['subject']->name }}</h4>
    @include('gradebook.assessment_results', ['gradebook' => $subjectGradebook['gradebook'], 'students' => collect([$student]), 'gradebookDirection'=>strpos(app()->getLocale(), 'ar') === 0 ? 'rtl' : 'ltr'])
@endforeach
@endsection
