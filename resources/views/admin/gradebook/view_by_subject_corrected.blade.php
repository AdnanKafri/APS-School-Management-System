@extends('admin.gradebook.layout')
@section('page_title', __('gradebook_ui.results'))
@section('page_subtitle', __('gradebook_ui.review_help'))

@section('breadcrumbs')
    @include('admin.gradebook.partials.breadcrumbs', ['items'=>[['label'=>__('gradebook_ui.review'), 'url'=>route('admin.gradebook.view_options')], ['label'=>__('gradebook_ui.sections'), 'url'=>route('admin.gradebook.view_rooms', $room->class_id)], ['label'=>$room->name, 'url'=>route('admin.gradebook.view_subjects', $room->id)], ['label'=>$subject->name]]])
@endsection

@section('gradebook-content')
<div class="container-fluid mt-3">
    <div class="card">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h4 class="mb-0 text-primary">
                <i class="fas fa-table"></i> دفتر العلامات: {{ $subject->name }} <span class="text-muted">({{ $room->name }})</span>
            </h4>
            <button class="btn btn-outline-primary btn-sm" onclick="window.print()"><i class="fas fa-print"></i> طباعة</button>
        </div>

        <div class="card-body p-3">
            <p class="text-muted">{{ __('gradebook.summary_notice') }}</p>
            @if($components->isEmpty())<p class="alert alert-info">{{ __('gradebook_distribution.no_components') }}</p>@endif
            <!-- Tabs -->
            <ul class="nav nav-tabs nav-justified mb-3" id="gradebookTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active font-weight-bold" id="t1-tab" data-toggle="tab" href="#term1" role="tab">
                        <i class="fas fa-calendar-check ml-2"></i>الفصل الأول
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-weight-bold" id="t2-tab" data-toggle="tab" href="#term2" role="tab">
                        <i class="fas fa-calendar-check ml-2"></i>الفصل الثاني
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-weight-bold text-success" id="final-tab" data-toggle="tab" href="#final" role="tab">
                        <i class="fas fa-clipboard-check ml-2"></i>المحصلة النهائية
                    </a>
                </li>
            </ul>

            <div class="tab-content" id="gradebookTabsContent">
                
                @php
                    // Helper to render a term table
                    // Now uses $components for dynamic columns
                    $renderTermTable = function($termKey) use ($students, $calculatedMarks, $components) {
                        $html = '<div class="table-responsive">';
                        $html .= '<table class="table table-bordered table-hover text-center table-striped">';
                        $html .= '<thead class="thead-light"><tr>
                            <th style="width: 250px;">الطالب</th>';
                        
                        // Dynamic Headers
                        if (isset($components) && $components->count() > 0) {
                            foreach($components as $comp) {
                                // Display Name + Calculated Max
                                $maxDisplay = isset($comp->calculated_max) ? " ({$comp->calculated_max})" : "";
                                $html .= "<th>".e($comp->name).e($maxDisplay)."</th>";
                            }
                        }

                        $html .= '<th class="bg-light text-primary font-weight-bold">المجموع (Total)</th>
                        </tr></thead><tbody>';

                        foreach($students as $student) {
                            $data = $calculatedMarks[$student->id][$termKey] ?? [];
                            
                            $html .= '<tr>';
                            $html .= '<td class="text-right font-weight-bold">'.e($student->first_name.' '.$student->last_name).'</td>';
                            
                            // Dynamic Data
                            if (isset($components) && $components->count() > 0) {
                                foreach($components as $comp) {
                                    $val = $data[$comp->id] ?? '-';
                                    $html .= "<td>{$val}</td>";
                                }
                            }

                            $totalDisplay = isset($data['total']) ? $data['total'] : '-';
                            $html .= "<td class='font-weight-bold text-primary'>{$totalDisplay}</td>";
                            $html .= '</tr>';
                        }
                        $html .= '</tbody></table></div>';
                        return $html;
                    };
                @endphp

                <!-- Term 1 Tab -->
                <div class="tab-pane fade show active" id="term1" role="tabpanel" aria-labelledby="t1-tab" aria-label="{{ __('gradebook.term_one') }}">
                    {!! $renderTermTable('term1') !!}
                </div>

                <!-- Term 2 Tab -->
                <div class="tab-pane fade" id="term2" role="tabpanel" aria-labelledby="t2-tab" aria-label="{{ __('gradebook.term_two') }}">
                    {!! $renderTermTable('term2') !!}
                </div>

                <!-- Final Tab -->
                <div class="tab-pane fade" id="final" role="tabpanel" aria-labelledby="final-tab">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center">
                            <thead class="bg-success text-white">
                                <tr>
                                    <th style="width: 250px;">الطالب</th>
                                    <th>مجموع الفصل الأول</th>
                                    <th>مجموع الفصل الثاني</th>
                                    <th>المحصلة النهائية</th>
                                    <th>النتيجة</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                    @php
                                        // Calculate Term 1 Total
                                        $t1 = $calculatedMarks[$student->id]['term1'] ?? [];
                                        $sum1 = $t1['total'] ?? null;

                                        // Calculate Term 2 Total
                                        $t2 = $calculatedMarks[$student->id]['term2'] ?? [];
                                        $sum2 = $t2['total'] ?? null;

                                        $final = $sum1 === null && $sum2 === null ? null : ($sum1 ?? 0) + ($sum2 ?? 0);
                                        $status = ($final >= 50) ? 'ناجح' : 'راسب';
                                    @endphp
                                    <tr>
                                        <td class="text-right font-weight-bold">{{ $student->first_name }} {{ $student->last_name }}</td>
                                        <td>{{ $sum1 !== null ? $sum1 : '-' }}</td>
                                        <td>{{ $sum2 !== null ? $sum2 : '-' }}</td>
                                        <td class="font-weight-bold border-left border-right">{{ $final !== null ? $final : '-' }}</td>
                                        <td>
                                            @if($final !== null)
                                                <span class="badge badge-{{ $final >= 50 ? 'success' : 'danger' }} p-2">{{ $status }}</span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        <div class="card-footer text-center">
            <p class="text-muted mb-0">نظام العلامات الإلكتروني - التحديث فوري</p>
        </div>
    </div>
</div>
@include('gradebook.assessment_results', ['gradebookDirection'=>strpos(app()->getLocale(), 'ar') === 0 ? 'rtl' : 'ltr'])
@endsection
