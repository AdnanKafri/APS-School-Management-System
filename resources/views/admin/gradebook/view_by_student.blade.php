@extends('admin.master')

@section('breadcrumbs')
    <nav class="breadcrumbs">
        <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item">الرئيسية</a>
        <a href="{{ route('admin.gradebook.index') }}" class="breadcrumbs__item">دفتر العلامات</a>
        <a href="{{ route('admin.gradebook.view_options') }}" class="breadcrumbs__item">خيارات العرض</a>
        <a class="breadcrumbs__item is-active">جلاء الطالب</a>
    </nav>
@endsection

@section('content')
<div class="container-fluid mt-5">
    <div class="card">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0 text-white"><i class="fas fa-user-graduate"></i> بطاقة الطالب: <span class="text-warning">{{ $student->first_name }} {{ $student->last_name }}</span></h4>
            <div>
                <span class="badge badge-light ml-2">{{ $student->classe ? $student->classe->name : '' }}</span>
                <span class="badge badge-secondary">{{ $room->name ?? '' }}</span>
            </div>
        </div>
        <div class="card-body">
            
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
                    
                    @php
                        // Helper render function
                        $renderSubjectTable = function($termKey) use ($studentMarks) {
                            $html = '<div class="table-responsive"><table class="table table-bordered table-hover text-center table-striped">';
                            $html .= '<thead class="thead-light"><tr>
                                        <th class="text-right" style="width:300px;">المادة</th>
                                        <th>شفهي (Oral)</th>
                                        <th>وظائف/مذاكرات (H.W/Quiz)</th>
                                        <th>امتحان (Exam)</th>
                                        <th class="bg-light text-primary font-weight-bold">المجموع</th>
                                      </tr></thead><tbody>';
                            
                            foreach($studentMarks as $item) {
                                $tData = $item[$termKey] ?? []; // ['total'=>, 'details'=>] or null
                                $details = $tData['details'] ?? [];
                                $total = $tData['total'] ?? null;
                                
                                $oral = $details['oral'] ?? '-';
                                $quiz = $details['quize'] ?? '-';
                                $exam = $details['exam'] ?? '-';
                                $totalStr = ($total !== null) ? $total : '-';

                                $html .= '<tr>';
                                $html .= '<td class="text-right font-weight-bold">'.$item['name'].'</td>';
                                $html .= "<td>{$oral}</td>";
                                $html .= "<td>{$quiz}</td>";
                                $html .= "<td>{$exam}</td>";
                                $html .= "<td class='font-weight-bold text-primary'>{$totalStr}</td>";
                                $html .= '</tr>';
                            }
                            $html .= '</tbody></table></div>';
                            return $html;
                        };
                    @endphp

                    <!-- Term 1 -->
                    <div class="tab-pane fade show active" id="nav-term1" role="tabpanel">
                        {!! $renderSubjectTable('term1') !!}
                    </div>

                    <!-- Term 2 -->
                    <div class="tab-pane fade" id="nav-term2" role="tabpanel">
                        {!! $renderSubjectTable('term2') !!}
                    </div>

                    <!-- Final -->
                    <div class="tab-pane fade" id="nav-final" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover text-center">
                                <thead class="bg-success text-white">
                                    <tr>
                                        <th class="text-right" style="width:300px;">المادة</th>
                                        <th>الفصل الأول</th>
                                        <th>الفصل الثاني</th>
                                        <th>المحصلة</th>
                                        <th>الحالة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($studentMarks as $item)
                                        @php
                                            $t1Total = $item['term1']['total'] ?? null;
                                            $t2Total = $item['term2']['total'] ?? null;
                                            $final = $item['total']; // logic handled in controller sum
                                            
                                            $status = ($final >= 50) ? 'ناجح' : 'راسب'; // simple logic
                                        @endphp
                                        <tr>
                                            <td class="text-right font-weight-bold">{{ $item['name'] }}</td>
                                            <td>{{ $t1Total !== null ? $t1Total : '-' }}</td>
                                            <td>{{ $t2Total !== null ? $t2Total : '-' }}</td>
                                            <td class="font-weight-bold border-left border-right">{{ $final > 0 ? $final : '-' }}</td>
                                            <td>
                                                 @if($final > 0)
                                                    <span class="badge badge-{{ $final >= 50 ? 'success' : 'danger' }}">{{ $status }}</span>
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

            @endif
        </div>
        <div class="card-footer text-muted text-center">
            بطاقة إلكترونية - تحديث فوري
        </div>
    </div>
</div>
@endsection
