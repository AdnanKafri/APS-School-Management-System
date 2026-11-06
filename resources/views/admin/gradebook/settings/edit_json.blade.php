@extends('admin.gradebook.layout')
@section('page_title', __('gradebook_ui.edit_distribution'))
@section('page_subtitle', __('gradebook_ui.shared_distribution'))
@section('breadcrumbs')
@include('admin.gradebook.partials.breadcrumbs', ['items'=>[['label'=>__('gradebook_ui.settings'), 'url'=>route('admin.gradebook.settings')], ['label'=>__('gradebook_ui.edit_distribution')]]])
@endsection
@section('gradebook-content')
@php
    $reservedSources = ['legacy_oral'=>'LEGACY_ORAL', 'legacy_homework'=>'LEGACY_HOMEWORK', 'legacy_exam'=>'LEGACY_EXAM'];
    $unitConversionBlocked = $components->contains(function ($component) use ($reservedSources) {
        $id = $component->id ?? null;
        return !$id || !isset($component->weight, $component->data_source) || property_exists($component, 'max_mark')
            || (isset($reservedSources[$id]) && (string)$component->data_source !== $reservedSources[$id]);
    });
    $formComponents = collect(old('components', old('_components_present') ? [] : $components->all()))->values()->map(function ($row) { return (object) $row; });
@endphp
<section class="card">
    <div class="card-header">
        <h3>{{ __('gradebook_ui.edit_distribution') }}: {{ $subject->name }}</h3>
        <span class="badge badge-primary">{{ $year->name }} / {{ __('gradebook_distribution.maximum') }}: {{ $subject->max_mark }}</span>
    </div>
    <div class="card-body">
        @if($configurationInfo['state'] === 'missing')
            <p class="alert alert-info">{{ __('gradebook_ux.defaults') }}</p>
        @elseif($configurationInfo['state'] !== 'valid')
            <p class="alert alert-warning">{{ __('gradebook_ux.invalid_config') }}</p>
        @endif
        <p class="text-muted small">{{ __('gradebook_ux.summary_help') }}</p>
        <p class="text-muted small">{{ __('gradebook_ux.bounds_help') }}</p>
        <p class="small">{{ __('gradebook_ux.stored_minimum') }}: {{ $subject->min_mark ?? '-' }}</p>
        @if($errors->any())<div class="alert alert-danger" role="alert"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        @if(session('success'))<p class="alert alert-success">{{ session('success') }}</p>@endif
        <form action="{{ route('admin.gradebook.settings.update', $subject->id) }}" method="POST" id="configForm" autocomplete="off"
            data-subject-total="{{ $subject->max_mark }}" data-units-blocked="{{ $unitConversionBlocked ? '1' : '0' }}"
            data-inexact="{{ __('gradebook_distribution.inexact') }}" data-unsupported="{{ __('gradebook_distribution.unsupported') }}"
            data-invalid-total="{{ __('gradebook_distribution.invalid_total') }}" data-incomplete="{{ __('gradebook_distribution.incomplete') }}"
            data-excess="{{ __('gradebook_distribution.excess') }}" data-complete="{{ __('gradebook_distribution.complete') }}"
            data-manual="{{ __('gradebook_ux.manual') }}" data-impact="{{ __('gradebook_editor.impact') }}" data-limit="{{ __('gradebook_editor.limit') }}">
            @csrf
            <input type="hidden" name="_components_present" value="1">
            <input type="hidden" name="_configuration_year" value="{{ old('_configuration_year', $year->id) }}">
            <input type="hidden" name="_configuration_revision" value="{{ old('_configuration_revision', $configurationInfo['sha256'] ?? 'missing') }}">
            <input type="hidden" id="allocation-subject-total" name="_allocation_subject_total" value="{{ $subject->max_mark }}" disabled>
            <div class="gb-toolbar mb-3">
                <p class="text-muted mb-0">{{ __('gradebook_editor.draft_help') }}</p>
                <button type="button" class="btn btn-primary" id="addRowBtn">{{ __('gradebook_editor.add') }}</button>
            </div>
            <div id="distribution-units" class="mb-3" hidden>
                <div class="gb-toolbar mb-2">
                    <span>{{ __('gradebook_editor.view_mode') }}</span>
                    <div role="group" aria-label="{{ __('gradebook_editor.view_mode') }}">
                        <button type="button" class="btn btn-outline-primary" data-allocation-mode="percent" aria-pressed="true">{{ __('gradebook_distribution.percentage') }}</button>
                        <button type="button" class="btn btn-outline-primary" data-allocation-mode="marks" aria-pressed="false" disabled>{{ __('gradebook_distribution.marks') }}</button>
                    </div>
                </div>
                <div class="gb-allocation-summary">
                    <span>{{ __('gradebook_distribution.allocation') }}: <output id="allocation-percent">-</output></span>
                    <span>{{ __('gradebook_distribution.allocated_marks') }}: <output id="allocation-marks">-</output></span>
                    <span>{{ __('gradebook_distribution.remaining') }}: <output id="allocation-remaining">-</output></span>
                </div>
                <p id="allocation-feedback" class="small mt-2 mb-0" role="status" aria-live="polite"></p>
            </div>
            <div class="table-responsive" tabindex="0" role="region" aria-label="{{ __('gradebook_ui.edit_distribution') }}">
                <table class="table table-bordered gb-table" id="componentsTable">
                    <thead><tr><th>#</th><th>{{ __('gradebook_editor.name') }}</th><th>{{ __('gradebook_distribution.percentage') }}</th><th>{{ __('gradebook_ui.actions') }}</th></tr></thead>
                    <tbody id="componentsBody">
                    @foreach($formComponents as $index=>$comp)
                        @include('admin.gradebook.partials.component_row')
                    @endforeach
                    </tbody>
                </table>
            </div>
            <p id="components-empty" class="alert alert-light" @if($formComponents->isNotEmpty()) hidden @endif>{{ __('gradebook_editor.empty') }}</p>
            <div class="gb-config-actions mt-3">
                <a href="{{ route('admin.gradebook.settings') }}" class="btn btn-light">{{ __('assessment_entry.cancel') }}</a>
                <button type="submit" class="btn btn-success" id="saveBtn">{{ __('assessment_entry.save') }}</button>
            </div>
        </form>
        <template id="component-row-template">
            @include('admin.gradebook.partials.component_row', ['index'=>'new', 'comp'=>(object)['name'=>'','weight'=>0]])
        </template>
    </div>
</section>
<div class="modal fade gb-component-dialog" id="componentDialog" tabindex="-1" role="dialog" aria-labelledby="componentDialogTitle" aria-hidden="true" dir="{{ strpos(app()->getLocale(), 'ar') === 0 ? 'rtl' : 'ltr' }}">
    <div class="modal-dialog modal-dialog-centered" role="document"><div class="modal-content">
        <form id="componentDialogForm">
            <div class="modal-header"><h4 id="componentDialogTitle" class="modal-title">{{ __('gradebook_ui.edit_distribution') }}</h4><button type="button" class="close" data-dismiss="modal" aria-label="{{ __('assessment_entry.close') }}">&times;</button></div>
            <div class="modal-body">
                <p id="componentKind" class="text-primary font-weight-bold"></p>
                <p class="small text-muted">{{ __('gradebook_ux.manual_help') }}</p>
                <p id="componentProtection" class="alert alert-info" hidden>{{ __('gradebook_editor.used') }}</p>
                <div class="form-group"><label for="componentName">{{ __('gradebook_editor.name') }}</label><input id="componentName" class="form-control" maxlength="191" required></div>
                <div class="form-group"><label for="componentMode">{{ __('gradebook_distribution.input_mode') }}</label><select id="componentMode" class="form-control"><option value="percent">{{ __('gradebook_distribution.percentage') }}</option><option value="marks">{{ __('gradebook_distribution.marks') }}</option></select></div>
                <div class="form-group"><label for="componentPercent">{{ __('gradebook_distribution.percentage') }}</label><input id="componentPercent" type="number" class="form-control" min="0" max="100" step="1" inputmode="numeric" required></div>
                <div class="form-group" hidden><label for="componentMarks">{{ __('gradebook_distribution.maximum') }}</label><input id="componentMarks" type="number" class="form-control" min="0" step="1" inputmode="numeric"></div>
                <p class="small text-muted">{{ __('gradebook_distribution.exact_help') }}</p>
                <p id="componentFeedback" class="text-danger small" role="status" aria-live="polite"></p>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-light" data-dismiss="modal">{{ __('assessment_entry.cancel') }}</button><button type="submit" class="btn btn-primary">{{ __('gradebook_editor.apply') }}</button></div>
        </form>
    </div></div>
</div>
@endsection
@section('js')
<script src="{{ asset('assets/admin/js/gradebook-distribution-units.js') }}"></script>
<script src="{{ asset('assets/admin/js/gradebook-component-editor.js') }}"></script>
@endsection
