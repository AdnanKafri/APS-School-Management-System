@php
    $deleteRestore = session()->has('assessment_delete_id') && $errors->any();
    $deleteTarget = $deleteRestore ? $contents->firstWhere('id', (int) session('assessment_delete_id')) : null;
@endphp
<div class="modal fade deleteContentModal assessment-editor" id="assessment-delete" tabindex="-1" role="dialog"
    aria-labelledby="assessment-delete-title" aria-hidden="true" dir="rtl" data-restore="{{ $deleteRestore ? '1' : '0' }}">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="post" action="{{ route('exam_quize.delete') }}" data-assessment-delete>
                @csrf
                <input type="hidden" name="content_id" value="{{ $deleteTarget ? $deleteTarget->id : '' }}">
                <div class="modal-header">
                    <h4 class="modal-title text-danger" id="assessment-delete-title">{{ __('assessment_entry.delete_'.($assessmentKind === 'quize' ? 'quiz' : 'exam')) }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('assessment_entry.close') }}">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" data-assessment-errors role="alert" @unless($deleteRestore) hidden @endunless>
                        @if($deleteRestore) @foreach($errors->all() as $error)<p class="mb-1">{{ $error }}</p>@endforeach @endif
                    </div>
                    <div class="form-group">
                        <label for="assessment-delete-name">{{ __('assessment_entry.name') }}</label>
                        <input id="assessment-delete-name" class="form-control content_name" value="{{ $deleteTarget ? $deleteTarget->name : '' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="assessment-delete-code">{{ __('assessment_entry.delete_code') }}</label>
                        <input type="password" id="assessment-delete-code" name="delete_code" class="form-control" required autocomplete="off"
                            aria-describedby="assessment-delete-help">
                        <small id="assessment-delete-help" class="text-muted d-block mt-2">{{ __('assessment_entry.delete_help') }}</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">{{ __('assessment_entry.cancel') }}</button>
                    <button type="submit" class="btn btn-danger">{{ __('assessment_entry.confirm_delete') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
