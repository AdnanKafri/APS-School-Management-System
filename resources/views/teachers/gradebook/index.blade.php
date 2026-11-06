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
    .gb-occurrences { min-width: 0; text-align: right; }
    .gb-occurrences th { min-width: 12rem; overflow-wrap: anywhere; white-space: normal; }
    .gb-occurrences .btn { white-space: normal; }
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
                                {{ $subject->name }} - {{ $room->name }} <span class="text-muted small">({{ $term->term }})</span>
                            </h3>
                        </div>
                        <div class="col-4 text-left">
                            @if(isset($gradebookStatus) && $gradebookStatus !== 'OPEN')
                                <span class="badge badge-lg badge-danger text-white">
                                    <i class="fa fa-lock ml-1"></i> {{ __('gradebook_ux.entry_control') }}: {{ __('gradebook_ux.locked') }}
                                </span>
                            @else
                                <span class="badge badge-lg badge-success text-white">
                                    <i class="fa fa-pen ml-1"></i> {{ __('gradebook_ux.entry_control') }}: {{ __('gradebook_ux.open') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <h4>{{ __('gradebook_occurrences.components') }}</h4>
                    <p class="text-muted mb-1">{{ __('gradebook_occurrences.components_help') }}</p>
                    <p class="text-muted small">{{ __('gradebook_ux.summary_help') }}</p>
                    <p class="text-muted">{{ __('gradebook.summary_notice') }}</p>
                    <div id="gradebook-feedback" role="status" aria-live="polite" class="mb-2"></div>
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
                                                <span class="d-block text-muted" style="font-size: 11px;">({{ $comp->weight ?? 0 }}%)</span>
                                                <small class="d-block">{{ __('gradebook_ux.'.(\App\Services\GradebookComponentEntry::manual($comp) ? 'manual' : 'summary')) }}</small>
                                                <small class="d-block text-muted">{{ __('gradebook_occurrences.maximum') }}: {{ $comp->calculated_max }}</small>
                                            </th>
                                        @endforeach
                                        <th scope="col" class="text-center font-weight-bold" style="font-size: 14px; color: #001586;">المجموع</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @foreach($students as $student)
                                    <tr data-student="{{ $student->id }}">
                                        <td class="font-weight-bold text-dark">
                                            {{ $student->first_name }} {{ $student->last_name }}
                                        </td>

                                        @foreach($components as $comp)
                                            @php
                                                $val = $existingMarks[$student->id][$comp->id] ?? '';
                                                $isLegacy = is_string($comp->data_source) && strpos($comp->data_source, 'LEGACY_') === 0;
                                                $isLockedByAdmin = isset($gradebookStatus) && $gradebookStatus !== 'OPEN';
                                                $manual = \App\Services\GradebookComponentEntry::manual($comp);
                                                $supported = \App\Services\GradebookComponentEntry::supportedMaximum($comp->calculated_max);
                                                $isEditable = $manual && $supported && !$isLockedByAdmin;
                                                $bgClass = $isLegacy ? 'bg-light' : ''; 
                                            @endphp
                                            <td class="text-center p-0 {{ $bgClass }}" data-component-value="{{ $comp->id }}" style="vertical-align: middle;">
                                                @if($isEditable)
                                                    <input type="number" 
                                                           step="0.1" min="0" max="{{ $comp->calculated_max }}" inputmode="decimal"
                                                           aria-label="{{ $student->first_name }} {{ $student->last_name }} - {{ $comp->name }}"
                                                           class="form-control border-0 text-center grade-input"
                                                           style="height: 45px; background: transparent; font-weight: bold; color: #000;"
                                                           value="{{ $val }}"
                                                           data-student="{{ $student->id }}"
                                                           data-comp="{{ $comp->id }}"
                                                           data-accepted="{{ $val }}"
                                                    >
                                                    <small class="save-state d-block" aria-live="polite"></small>
                                                    <button type="button" class="btn btn-sm btn-outline-danger grade-retry" hidden>{{ __('gradebook.retry') }}</button>
                                                @else
                                                    <span class="d-block py-2 text-muted" style="font-weight: 600;">
                                                        {{ $val !== '' ? $val : '-' }}
                                                    </span>
                                                    @if($manual)<small>{{ __('gradebook_ux.'.(!$supported ? 'manual_bound' : 'manual_locked')) }}</small>@endif
                                                @endif
                                            </td>
                                        @endforeach

                                        <td class="text-center font-weight-bold total-cell" style="color: #001586; font-size: 15px;">
                                            {{ $student->gradebook_total ?? '-' }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @include('teachers.gradebook.assessment_columns')
                    @if($sourceGradebook['assessments']->isNotEmpty() || $sourceGradebook['historical']->isNotEmpty())
                        <details class="mt-3">
                            <summary>{{ __('gradebook_occurrences.other_sources') }}</summary>
                            @include('gradebook.assessment_results', ['gradebook' => $sourceGradebook])
                        </details>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var feedback = document.getElementById('gradebook-feedback');
    var busy = window.gradebookSavingStudents = window.gradebookSavingStudents || {};
    var text = {
        saving: @json(__('gradebook.saving')),
        saved: @json(__('gradebook.saved')),
        failed: @json(__('gradebook.save_failed')),
        pending: @json(__('gradebook.leave_pending'))
    };
    function save(input) {
        var row = input.closest('tr');
        if (input.readOnly || input.disabled) return;
        var cell = input.closest('td');
        var status = cell.querySelector('.save-state');
        var retry = cell.querySelector('.grade-retry');
        if (busy[input.dataset.student]) {
            input.dataset.unsaved = '1'; status.textContent = text.pending; retry.hidden = false; return;
        }
        if (!input.checkValidity()) {
            input.reportValidity();
            return;
        }
        row.dataset.saving = '1';
        busy[input.dataset.student] = true;
        row.querySelectorAll('.grade-input').forEach(function (field) { field.readOnly = true; });
        input.dataset.unsaved = '1';
        retry.hidden = true;
        status.textContent = text.saving;
        $.ajax({
            url: @json(route('teacher.gradebook.save')),
            type: 'POST',
            data: {
                _token: @json(csrf_token()), student_id: input.dataset.student,
                component_id: input.dataset.comp, value: input.value,
                room_id: @json($room->id), subject_id: @json($subject->id)
            }
        }).done(function (response) {
            if (!response.success) { failed(response.message); return; }
            input.value = response.value === null ? '' : response.value;
            input.dataset.accepted = input.value;
            delete input.dataset.unsaved;
            input.removeAttribute('aria-invalid');
            row.querySelector('.total-cell').textContent = response.total === null ? '-' : response.total;
            status.textContent = text.saved;
            feedback.textContent = text.saved;
            feedback.className = 'mb-2 text-success';
        }).fail(function (xhr) {
            var response = xhr.responseJSON || {};
            var errors = response.errors ? Object.keys(response.errors).map(function (key) { return response.errors[key].join(' '); }).join(' ') : response.message;
            failed(errors);
            if (xhr.status === 403) { input.dataset.closed = '1'; input.disabled = true; retry.hidden = true; }
        }).always(function () {
            row.dataset.saving = '0';
            busy[input.dataset.student] = false;
            row.querySelectorAll('.grade-input').forEach(function (field) { field.readOnly = false; });
        });
        function failed(message) {
            input.setAttribute('aria-invalid', 'true');
            status.textContent = text.failed;
            feedback.textContent = message || text.failed;
            feedback.className = 'mb-2 text-danger';
            retry.hidden = false;
        }
    }
    document.querySelectorAll('.grade-input').forEach(function (input) {
        input.addEventListener('change', function () { save(input); });
        input.addEventListener('keydown', function (event) {
            if (event.key === 'Enter') { event.preventDefault(); save(input); }
        });
        input.addEventListener('input', function () {
            if (input.value !== input.dataset.accepted) input.dataset.unsaved = '1';
            else delete input.dataset.unsaved;
        });
    });
    document.querySelectorAll('.grade-retry').forEach(function (button) {
        button.addEventListener('click', function () { save(button.closest('td').querySelector('.grade-input')); });
    });
    window.addEventListener('beforeunload', function (event) {
        if (document.querySelector('.grade-input[data-unsaved="1"]')) {
            event.preventDefault();
            event.returnValue = text.pending;
        }
    });
});
</script>
<script src="{{ asset('teachers_2/assets/js/gradebook-occurrences.js') }}"></script>
@endsection
