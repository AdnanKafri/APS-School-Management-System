@extends('admin.layouts.v2')
@section('body_class', 'website-mgmt-v2')

@section('page_title', __('mobile_apps.title'))
@section('page_subtitle', __('mobile_apps.subtitle'))

@section('style')
<style>
    .mobile-apps-page { text-align: start; }
    .mobile-apps-grid { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:1rem; }
    .mobile-app-card { display:flex; flex-direction:column; min-height:290px; padding:1.25rem; border:1px solid #ebe7f5; border-radius:18px; background:#fff; box-shadow:0 12px 30px rgba(36,30,62,.06); }
    .mobile-app-card__head { display:flex; align-items:flex-start; justify-content:space-between; gap:1rem; }
    .mobile-app-card__icon { width:58px; height:58px; flex:0 0 58px; display:inline-flex; align-items:center; justify-content:center; border-radius:17px; background:linear-gradient(135deg,rgba(91,75,138,.13),rgba(59,130,246,.12)); color:#5b4b8a; font-size:1.5rem; }
    .mobile-app-card__status { padding:.35rem .7rem; border-radius:999px; font-size:.78rem; font-weight:800; white-space:nowrap; background:#f2f1f6; color:#756f83; }
    .mobile-app-card__status.is-ready { background:#e9f8f0; color:#178553; }
    .mobile-app-card h3 { margin:1rem 0 .35rem; color:#2f2b3a; font-size:1.08rem; font-weight:800; }
    .mobile-app-card p { margin:0; color:#7b7590; line-height:1.8; font-size:.9rem; }
    .mobile-app-card__meta { margin:1rem 0; padding:.8rem 0; display:grid; gap:.65rem; border-top:1px solid #f0edf6; border-bottom:1px solid #f0edf6; }
    .mobile-app-card__meta-row { display:flex; justify-content:space-between; align-items:center; gap:.75rem; }
    .mobile-app-card__meta-label { color:#898397; font-size:.82rem; }
    .mobile-app-card__meta-value { color:#3c3749; font-weight:800; font-size:.86rem; text-align:left; }
    .mobile-app-card .btn { margin-top:auto; min-height:44px; border-radius:12px; display:inline-flex; align-items:center; justify-content:center; gap:.5rem; font-weight:800; }
    .mobile-app-modal .form-control { min-height:46px; border-radius:11px; border:1px solid #dcd7e8; }
    .mobile-app-modal textarea.form-control { min-height:95px; resize:vertical; }
    .mobile-app-modal label { color:#3b3648; font-weight:800; }
    .mobile-app-modal .form-text { color:#817b8f; }
    .mobile-app-modal form { display:flex; flex-direction:column; min-height:0; max-height:inherit; }
    @media (max-width:991.98px) { .mobile-apps-grid { grid-template-columns:1fr; } .mobile-app-card { min-height:0; } }
    @media (max-width:575.98px) { .mobile-app-card { padding:1rem; } .mobile-app-card__head { align-items:center; } }
</style>
@endsection

@section('breadcrumbs')
<nav class="breadcrumbs">
    <a href="{{ route('websitecontroller') }}" class="breadcrumbs__item">{{ __('mobile_apps.website_management') }}</a>
    <span class="breadcrumbs__item is-active">{{ __('mobile_apps.title') }}</span>
</nav>
@endsection

@section('content')
<div class="mobile-apps-page">
    <div class="mobile-apps-grid">
        @foreach(config('mobile_applications.applications') as $key => $metadata)
            @php
                $application = $applications->get($key);
                $release = optional($application)->currentRelease;
            @endphp
            <article class="mobile-app-card">
                <div class="mobile-app-card__head">
                    <span class="mobile-app-card__icon"><i class="{{ $metadata['icon'] }}"></i></span>
                    <span class="mobile-app-card__status {{ $available[$key] ? 'is-ready' : '' }}">
                        {{ $available[$key] ? __('mobile_apps.available') : __('mobile_apps.not_available') }}
                    </span>
                </div>
                <h3>{{ __('mobile_apps.applications.'.$key.'.name') }}</h3>
                <p>{{ __('mobile_apps.applications.'.$key.'.description') }}</p>
                <div class="mobile-app-card__meta">
                    <div class="mobile-app-card__meta-row">
                        <span class="mobile-app-card__meta-label">{{ __('mobile_apps.current_version') }}</span>
                        <span class="mobile-app-card__meta-value">{{ $release ? $release->version : __('mobile_apps.no_version') }}</span>
                    </div>
                    <div class="mobile-app-card__meta-row">
                        <span class="mobile-app-card__meta-label">{{ __('mobile_apps.last_update') }}</span>
                        <span class="mobile-app-card__meta-value">{{ $release ? $release->published_at->format('Y-m-d H:i') : '-' }}</span>
                    </div>
                </div>
                <button type="button" class="btn btn-primary js-open-app-modal"
                        data-key="{{ $key }}" data-name="{{ __('mobile_apps.applications.'.$key.'.name') }}">
                    <i class="fas fa-upload"></i>
                    {{ $release ? __('mobile_apps.update') : __('mobile_apps.upload') }}
                </button>
            </article>
        @endforeach
    </div>
</div>

<div class="modal fade v2-dashboard-modal mobile-app-modal" id="mobileApplicationModal" tabindex="-1" role="dialog" aria-labelledby="mobileApplicationTitle" aria-describedby="mobileApplicationName" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.mobile-applications.publish') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="application_key" id="mobileApplicationKey" value="{{ old('application_key') }}">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title mb-1" id="mobileApplicationTitle">{{ __('mobile_apps.update') }}</h5>
                        <small class="text-muted" id="mobileApplicationName"></small>
                    </div>
                    <button type="button" class="close ml-0" data-dismiss="modal" aria-label="{{ __('mobile_apps.cancel') }}"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="mobileApplicationApk">{{ __('mobile_apps.file') }} <span class="text-danger">*</span></label>
                        <input type="file" class="form-control-file @error('apk') is-invalid @enderror" id="mobileApplicationApk" name="apk" accept=".apk,application/vnd.android.package-archive,application/zip,application/octet-stream" required>
                        <small class="form-text">{{ __('mobile_apps.file_help') }} {{ __('mobile_apps.max_size_help', ['size' => config('mobile_applications.max_upload_kb', 102400) / 1024]) }}</small>
                        @error('apk')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label for="mobileApplicationVersion">{{ __('mobile_apps.version') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('version') is-invalid @enderror" id="mobileApplicationVersion" name="version" value="{{ old('version') }}" maxlength="50" autocomplete="off" required>
                        @error('version')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group mb-0">
                        <label for="mobileApplicationNotes">{{ __('mobile_apps.notes') }} <small class="text-muted">({{ __('mobile_apps.notes_optional') }})</small></label>
                        <textarea class="form-control @error('release_notes') is-invalid @enderror" id="mobileApplicationNotes" name="release_notes" maxlength="500">{{ old('release_notes') }}</textarea>
                        @error('release_notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    @error('application_key')<div class="alert alert-danger mt-3 mb-0">{{ $message }}</div>@enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">{{ __('mobile_apps.cancel') }}</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save ml-1"></i>{{ __('mobile_apps.save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    (function ($) {
        'use strict';
        var modal = $('#mobileApplicationModal');
        var names = @json(collect(config('mobile_applications.applications'))->keys()->mapWithKeys(function ($key) { return [$key => __('mobile_apps.applications.'.$key.'.name')]; }));

        $(document).on('click', '.js-open-app-modal', function () {
            if ($('#mobileApplicationKey').val() !== $(this).data('key')) {
                modal.find('form')[0].reset();
                $('#mobileApplicationApk, #mobileApplicationVersion, #mobileApplicationNotes').val('');
                modal.find('.invalid-feedback, .alert-danger').remove();
                modal.find('.is-invalid').removeClass('is-invalid');
            }
            $('#mobileApplicationKey').val($(this).data('key'));
            $('#mobileApplicationName').text($(this).data('name'));
            modal.modal('show');
        });

        @if($errors->any() && old('application_key'))
            $('#mobileApplicationName').text(names[@json(old('application_key'))] || '');
            modal.modal('show');
        @endif
    })(jQuery);
</script>
@endsection
