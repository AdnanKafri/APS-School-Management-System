<div id="legacy-mark-feedback" class="small px-3 mb-2" role="status" aria-live="polite"
    data-legacy-mark-url="{{ route('dashboard.teacher.student_save_mark3') }}"
    data-token="{{ csrf_token() }}" data-room="{{ $room_id }}" data-lesson="{{ $lesson_id }}" data-exam="{{ $exam_id }}"
    data-saving="{{ __('gradebook.saving') }}" data-saved="{{ __('gradebook.saved') }}" data-failed="{{ __('gradebook.save_failed') }}"
    data-empty="{{ __('teacher_portal.grading.empty_marks') }}" data-pending="{{ __('gradebook.leave_pending') }}"></div>
<script src="{{ asset('teachers_2/assets/js/legacy-grade-entry.js') }}"></script>
