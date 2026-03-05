@extends('admin.master')

@section('style')
<style>
.custom-file-label{
    display:none !important;
}
.pagination{
    justify-content: center !important;
}
th{
    font-size: 20px;
    border-bottom: 1px solid #008991 !important;
    text-align: center !important;
    color: black
}
td{
    font-size: 17px;
    border-bottom: 1px solid #008991 !important;
    color: black;
    text-align: center !important;
    vertical-align: middle !important;
}
/* Toggle Switch Adjustment */
.custom-toggle-slider {
    border: 1px solid #008991;
}
.custom-toggle-slider:before {
    bottom: 2px;
    left: 2px;
}
.custom-toggle-input:checked + .custom-toggle-slider {
    border-color: #008991;
}
.custom-toggle-input:checked + .custom-toggle-slider:before {
    background: #008991;
}
</style>
@endsection

@section('js')
<script>
    function toggleGradebookStatus(classId, termId, newStatus) {
        if(!confirm('هل أنت متأكد من تغيير حالة دفتر العلامات؟')) return;

        $.ajax({
            url: "{{ route('admin.gradebook.status') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                class_id: classId,
                term_id: termId,
                status: newStatus
            },
            success: function(response) {
                if(response.success) {
                    location.reload();
                }
            },
            error: function(xhr) {
                alert('Error updating status');
            }
        });
    }
</script>
@endsection

@section('breadcrumbs')
<nav class="breadcrumbs">
    <a href="{{ route('admin.gradebook.view_rooms', $room->class_id) }}" class="breadcrumbs__item">الشعب الصفية</a>
    <a href="{{ route('admin.gradebook.view_classes_subject') }}" class="breadcrumbs__item">دفتر العلامات</a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item">الرئيسية</a>
</nav>
@endsection

@section('content')
<div class="card" style="direction:rtl; text-align:right; margin: 20px;">
    
    <div class="card-header border-0 d-flex justify-content-between align-items-center">
        <h3 class="mb-0" style="color: #001586">
             علامات: {{ $room->name }}
             <span class="text-muted small mr-2" style="font-size: 14px;">( {{ $room->classes->name }} )</span>
        </h3>

        {{-- Status Toggle --}}
        <div class="d-flex align-items-center">
             @php
                  // Determine current status
                  $year = \App\Year::where('current_year', '1')->first();
                  $term = \App\Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
                  $status = \App\Services\GradebookStatusService::getStatus($room->class_id, $term->id);
                  $isLocked = $status !== 'OPEN';
             @endphp
            
            <span class="badge {{ $isLocked ? 'badge-danger' : 'badge-success' }} ml-2" style="font-size: 12px;">
                {{ $isLocked ? 'مغلق' : 'مفتوح' }}
            </span>

            <label class="custom-toggle custom-toggle-default ml-3 mb-0" style="vertical-align: middle;">
                <input type="checkbox" id="statusToggle" {{ !$isLocked ? 'checked' : '' }} 
                       class="custom-toggle-input"
                       onchange="toggleGradebookStatus({{ $room->class_id }}, {{ $term->id }}, this.checked ? 'OPEN' : 'LOCKED')">
                <span class="custom-toggle-slider rounded-circle"></span>
            </label>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table align-items-center table-flush">
            <thead class="thead-light">
                <tr>
                    <th scope="col" class="sort">اسم المادة</th>
                    <th scope="col" class="sort">الصف</th>
                    <th scope="col" class="sort">العمليات</th>
                </tr>
            </thead>
            <tbody class="list">
                @foreach ($subjects as $item)
                <tr>
                    <td class="budget font-weight-bold">
                        {{$item->name}}
                    </td>
                    <td class="budget">
                        {{$room->classes->name}}
                    </td>
                    <td>
                        <a class="btn btn-success btn-sm" href="{{ route('admin.gradebook.view_grid_simple', ['room_id' => $room->id, 'subject_id' => $item->id])}}" 
                           style="color: white; background: #28a745; border-color: #28a745;">
                           عرض العلامات
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection
