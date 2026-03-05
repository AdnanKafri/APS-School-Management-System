@extends('admin.master')

@section('breadcrumbs')
    <nav class="breadcrumbs">
        <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item">الرئيسية</a>
        <a href="{{ route('admin.gradebook.index') }}" class="breadcrumbs__item">دفتر العلامات</a>
        <a href="{{ route('admin.gradebook.view_options') }}" class="breadcrumbs__item">خيارات العرض</a>
        <a class="breadcrumbs__item is-active">عرض حسب المادة</a>
    </nav>
@endsection

@section('content')
<div class="container-fluid mt-5">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-gradient-2 text-white">
            <h4 class="mb-0 text-white">استعراض العلامات حسب المادة</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.gradebook.view_grid') }}" method="GET">
                <div class="form-row">
                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">الصف (Grade)</label>
                        <select class="form-control select2" name="class_id" id="selectClass">
                            <option value="">اختر الصف...</option>
                            @foreach($classes as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">الشعبة (Section)</label>
                        <select class="form-control select2" name="room_id" id="selectRoom" disabled>
                            <option value="">اختر الصف أولاً...</option>
                        </select>
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">المادة (Subject)</label>
                        <select class="form-control select2" name="subject_id" id="selectSubject" disabled>
                            <option value="">اختر الصف أولاً...</option>
                        </select>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success" id="btnView" disabled><i class="fas fa-eye"></i> عرض الجدول</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Base URL for API
        var baseUrl = "{{ url('SMT/admin/gradebook/api') }}";

        $('#selectClass').change(function() {
            var classId = $(this).val();
            if(classId) {
                // Enable and populate Rooms (Sections)
                $.ajax({
                    url: baseUrl + '/get-rooms/' + classId,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('#selectRoom').empty().append('<option value="">اختر الشعبة...</option>');
                        $.each(data, function(key, value) {
                            $('#selectRoom').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                        });
                        $('#selectRoom').prop('disabled', false);
                    }
                });

                // Enable and populate Subjects
                $.ajax({
                    url: baseUrl + '/get-subjects/' + classId,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('#selectSubject').empty().append('<option value="">اختر المادة...</option>');
                        $.each(data, function(key, value) {
                            $('#selectSubject').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                        });
                        $('#selectSubject').prop('disabled', false);
                    }
                });
            } else {
                $('#selectRoom').empty().prop('disabled', true);
                $('#selectSubject').empty().prop('disabled', true);
            }
             $('#btnView').prop('disabled', true);
        });

        // Enable view button only when all selected
        $('#selectRoom, #selectSubject').change(function() {
            if($('#selectClass').val() && $('#selectRoom').val() && $('#selectSubject').val()) {
                $('#btnView').prop('disabled', false);
            } else {
                $('#btnView').prop('disabled', true);
            }
        });
    });
</script>
@endsection
