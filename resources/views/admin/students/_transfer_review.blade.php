@can('edit_student')
<section class="alert alert-warning text-right" dir="rtl" aria-labelledby="transfer-review-title">
    <h5 id="transfer-review-title">{{ __('student_transfer.reconciliation.title') }}</h5>
    <p>{{ __('student_transfer.reconciliation.review_hint') }}</p>
    <p>{{ html_entity_decode(__('student_transfer.ui.current_section')) }}: {{ $enrollmentRoom->classes->name }} / {{ $enrollmentRoom->name }}<br>
        {{ html_entity_decode(__('student_transfer.ui.target_section')) }}: {{ $targetRoom->classes->name }} / {{ $targetRoom->name }}</p>
    <form method="POST" action="{{ route('student_change') }}">
        @csrf
        <input type="hidden" name="student_id" value="{{ $student->id }}">
        <input type="hidden" name="class_change_id" value="{{ $targetRoom->class_id }}">
        <input type="hidden" name="room_change_id" value="{{ $targetRoom->id }}">
        <input type="hidden" name="reconcile_confirmed" value="1">
        <input type="hidden" name="observed_room_id" value="{{ $enrollmentRoom->id }}">
        <input type="hidden" name="observed_placement_ids" value="{{ $placements->pluck('id')->sort()->implode(',') }}">
        <button type="submit" class="btn btn-warning">{{ __('student_transfer.reconciliation.approve_transfer') }}</button>
    </form>
</section>
@endcan
