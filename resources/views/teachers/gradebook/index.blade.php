@extends('teachers2.layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('teachers_2/assets/css/newteacher.css')}}">
<style>
    .grade-input:focus {
        background-color: #fff !important;
        box-shadow: 0 0 5px rgba(94, 114, 228, 0.5);
    }
    .table thead th {
        font-weight: 600;
        font-size: 0.85rem;
    }
    .total-cell {
        background-color: #f6f9fc;
    }
</style>
@endsection

@section('content')
<div class="main-panel" style="background: #f8f9fb;">
    
    <!-- Top Bar with Breadcrumbs -->
    <div class="w-100" style="background: transparent; padding: 10px 20px;">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb" style="background: transparent; padding: 0; margin-bottom: 0; direction: rtl; text-align: right;">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.teacher') }}" style="color: #5e72e4;">الرئيسية</a></li>
            <li class="breadcrumb-item active" aria-current="page" style="color: #8898aa;">دفتر العلامات</li>
          </ol>
        </nav>
    </div>

    <div class="content-wrapper pb-0" style="padding-top: 10px;">
        <div class="container-fluid">
            <div class="row" style="direction: rtl;">
                <div class="col-md-12">
                    
                    {{-- Minimalist Header --}}
                    <div class="row align-items-center mb-4">
                        <div class="col-8 text-right">
                            <h3 class="mb-0 font-weight-bold" style="color: #32325d;">
                                {{ $subject->name }} - {{ $room->name }} <span class="text-muted small">({{ $term->name }})</span>
                            </h3>
                        </div>
                        <div class="col-6 text-left">
                            @if(isset($gradebookStatus) && $gradebookStatus !== 'OPEN')
                                <span class="badge badge-lg badge-danger text-white">
                                    <i class="fa fa-lock ml-1"></i> مغلق
                                </span>
                            @else
                                <span class="badge badge-lg badge-success text-white">
                                    <i class="fa fa-pen ml-1"></i> مفتوح
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="card shadow border-0">
                        <div class="table-responsive">
                            <table class="table align-items-center table-hover text-right" id="gradebookTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" style="font-size: 14px; color: #000; font-weight: bold;">الطالب</th>
                                        @foreach($components as $comp)
                                            @php
                                                $isLegacy = is_string($comp->data_source) && strpos($comp->data_source, 'LEGACY_') === 0;
                                            @endphp
                                            <th scope="col" class="text-center" style="font-size: 13px; color: #000; font-weight: bold; {{ $isLegacy ? 'background-color: #e9ecef;' : '' }}">
                                                {{ $comp->name }}
                                                <span class="d-block text-muted" style="font-size: 11px;">({{ $comp->weight }}%)</span>
                                            </th>
                                        @endforeach
                                        <th scope="col" class="text-center font-weight-bold" style="font-size: 14px; color: #001586;">المجموع</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @foreach($students as $student)
                                    <tr>
                                        <td class="font-weight-bold text-dark">
                                            {{ $student->first_name }} {{ $student->last_name }}
                                        </td>

                                        @foreach($components as $comp)
                                            @php
                                                $val = $existingMarks[$student->id][$comp->id] ?? '';
                                                $isLegacy = is_string($comp->data_source) && strpos($comp->data_source, 'LEGACY_') === 0;
                                                $isLockedByAdmin = isset($gradebookStatus) && $gradebookStatus !== 'OPEN';
                                                $isEditable = !$isLegacy && !$isLockedByAdmin;
                                                $bgClass = $isLegacy ? 'bg-light' : ''; 
                                            @endphp
                                            <td class="text-center p-0 {{ $bgClass }}" style="vertical-align: middle;">
                                                @if($isEditable)
                                                    <input type="number" 
                                                           step="0.1" 
                                                           class="form-control border-0 text-center grade-input"
                                                           style="height: 45px; background: transparent; font-weight: bold; color: #000;"
                                                           value="{{ $val }}"
                                                           data-student="{{ $student->id }}"
                                                           data-comp="{{ $comp->id }}"
                                                           data-weight="{{ $comp->weight }}"
                                                    >
                                                @else
                                                    <span class="d-block py-2 text-muted" style="font-weight: 600;">
                                                        {{ $val !== '' ? $val : '-' }}
                                                    </span>
                                                @endif
                                            </td>
                                        @endforeach

                                        <td class="text-center font-weight-bold total-cell" style="color: #001586; font-size: 15px;">
                                            {{ $student->gradebook_total ?? 0 }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Notification Helper (using existing NotifIt if available or fallback)
        function notify(msg, type) {
            if (window.notif) {
                window.notif({msg: msg, type: type});
            } else {
                console.log(type + ": " + msg);
            }
        }

        const inputs = document.querySelectorAll('.grade-input');
        
        inputs.forEach(input => {
            input.addEventListener('change', function() {
                saveMark(this);
                updateRowTotal(this);
            });
        });

        function updateRowTotal(input) {
            const row = input.closest('tr');
            let total = 0;
            row.querySelectorAll('.grade-input').forEach(inp => {
                if(inp.value !== '') {
                    total += parseFloat(inp.value);
                }
            });
            row.querySelector('.total-cell').textContent = total.toFixed(1);
        }

        function saveMark(input) {
            const studentId = input.getAttribute('data-student');
            const compId = input.getAttribute('data-comp');
            const value = input.value;
            
            // Visual Indicator
            input.style.backgroundColor = '#fff3cd'; // Pending Yellow

            $.ajax({
                url: "{{ route('teacher.gradebook.save') }}", 
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    student_id: studentId,
                    component_id: compId,
                    value: value,
                    room_id: "{{ $room->id }}",
                    subject_id: "{{ $subject->id }}"
                },
                success: function(response) {
                    input.style.backgroundColor = '#d4edda'; // Success Green
                    setTimeout(() => input.style.backgroundColor = 'transparent', 1500);
                    // notify('تم الحفظ بنجاح', 'success');
                },
                error: function(xhr) {
                    input.style.backgroundColor = '#f8d7da'; // Error Red
                    notify('خطأ في الحفظ', 'error');
                    console.error(xhr);
                }
            });
        }
    });
</script>
@endsection
