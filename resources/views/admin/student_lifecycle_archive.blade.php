@extends('admin.layouts.v2')

@section('page_title', __('student_lifecycle.ui.archive_title'))
@section('page_subtitle', __('student_lifecycle.ui.archive_subtitle'))

@section('style')
<style>
    .lifecycle-archive { direction: rtl; }
    .lifecycle-archive .lifecycle-card { border: 1px solid #e8eaf1; border-radius: 14px; background: #fff; }
    .lifecycle-archive .lifecycle-actions { display: inline-flex; gap: .5rem; align-items: center; }
    .lifecycle-archive .modal-content { border: 0; border-radius: 14px; overflow: hidden; }
    .lifecycle-archive .modal-header, .lifecycle-archive .modal-footer { padding: 1rem 1.25rem; }
    .lifecycle-archive .modal-body { padding: 1.25rem; }
    .lifecycle-archive .form-control { min-height: 42px; border-radius: 8px; }
</style>
@endsection

@section('content')
<div class="container-fluid py-3 lifecycle-archive">
    <div class="lifecycle-card shadow-sm">
        <div class="card-header border-0 d-flex justify-content-between align-items-center flex-wrap">
            <h3 class="mb-2 mb-md-0">{{ __('student_lifecycle.ui.archive_title') }}</h3>
            <form method="get" class="d-flex align-items-center" role="search">
                <input class="form-control ml-2" name="search" value="{{ request('search') }}" placeholder="{{ __('student_lifecycle.ui.search_archive') }}">
                <button class="btn btn-outline-primary" type="submit">{{ __('student_lifecycle.ui.search') }}</button>
            </form>
        </div>
        <div class="card-body">
            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
            @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
            @forelse($students as $student)
                @php($last = $student->academicPlacements->sortByDesc('id')->first())
                <div class="lifecycle-card p-3 mb-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div><strong>{{ trim($student->first_name.' '.$student->last_name) }}</strong><small class="text-muted d-block">{{ $student->public_record_number }}</small></div>
                        <div class="text-muted">{{ optional(optional($last)->year)->name }} / {{ optional(optional($last)->room)->name }}</div>
                        <button class="btn btn-sm btn-outline-success" type="button" data-toggle="modal" data-target="#restore-{{ $student->id }}">{{ __('student_lifecycle.ui.restore') }}</button>
                    </div>
                    @foreach(($events->get($student->id) ?: collect()) as $event)<small class="text-muted d-block mt-2">{{ $event->event_type }}: {{ $event->reason }}</small>@endforeach
                </div>
                <div class="modal fade" id="restore-{{ $student->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered"><form method="post" action="{{ route('admin.students.lifecycle_restore') }}" class="modal-content">@csrf
                        <input type="hidden" name="student_id" value="{{ $student->id }}">
                        <div class="modal-header"><h5 class="modal-title">{{ __('student_lifecycle.ui.restore') }}</h5><button type="button" class="close" data-dismiss="modal" aria-label="{{ __('student_lifecycle.ui.cancel') }}">&times;</button></div>
                        <div class="modal-body">
                            <select name="year_id" class="form-control mb-2 restore-year" required><option value="">{{ __('student_lifecycle.ui.choose_year') }}</option>@foreach($years as $year)<option value="{{ $year->id }}">{{ $year->name }}</option>@endforeach</select>
                            <select name="class_id" class="form-control mb-2 restore-class" required><option value="">{{ __('student_lifecycle.ui.choose_class') }}</option>@foreach($classes as $class)<option value="{{ $class->id }}">{{ $class->name }}</option>@endforeach</select>
                            <select name="room_id" class="form-control mb-2 restore-room" required disabled><option value="">{{ __('student_lifecycle.ui.choose_section') }}</option></select>
                            <textarea name="reason" class="form-control" rows="3" required placeholder="{{ __('student_lifecycle.ui.restore_reason') }}"></textarea>
                        </div>
                        <div class="modal-footer lifecycle-actions"><button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('student_lifecycle.ui.cancel') }}</button><button class="btn btn-success" type="submit">{{ __('student_lifecycle.ui.restore') }}</button></div>
                    </form></div>
                </div>
            @empty
                <p class="text-muted text-center py-4">{{ __('student_lifecycle.ui.empty') }}</p>
            @endforelse
            {{ $students->links() }}
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(document).on('change', '.restore-class, .restore-year', function () {
    var form = $(this).closest('form'), year = form.find('.restore-year').val(), cls = form.find('.restore-class').val(), room = form.find('.restore-room');
    room.prop('disabled', true).html('<option value="">...</option>');
    if (!year || !cls) return;
    $.get('{{ url('SMT/admin/students/lifecycle-archive/rooms') }}/' + cls, {year_id: year}).done(function (rows) {
        room.empty().append($('<option>', {value: '', text: @json(__('student_lifecycle.ui.choose_section'))}));
        $.each(rows, function (_, item) { room.append($('<option>', {value: item.id, text: item.name})); });
        room.prop('disabled', rows.length === 0);
    });
});
</script>
@endsection
