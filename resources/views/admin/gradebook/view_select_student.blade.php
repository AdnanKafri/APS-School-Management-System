@extends('admin.master')

@section('breadcrumbs')
    <nav class="breadcrumbs">
        <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item">الرئيسية</a>
        <a href="{{ route('admin.gradebook.index') }}" class="breadcrumbs__item">دفتر العلامات</a>
        <a href="{{ route('admin.gradebook.view_options') }}" class="breadcrumbs__item">خيارات العرض</a>
        <a class="breadcrumbs__item is-active">عرض حسب الطالب</a>
    </nav>
@endsection

@section('content')
<div class="container-fluid mt-5">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-gradient-4 text-white">
            <h4 class="mb-0 text-white">استعراض دفتر علامات طالب</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.gradebook.view_student_card') }}" method="GET">
                <div class="form-row">
                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">الصف (Grade)</label>
                        <select class="form-control select2" id="selectClass">
                            <option value="">اختر الصف...</option>
                            @foreach($classes as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">الشعبة (Section)</label>
                        <select class="form-control select2" id="selectRoom" disabled>
                            <option value="">اختر الصف أولاً...</option>
                        </select>
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">الطالب (Student)</label>
                        <select class="form-control select2" name="student_id" id="selectStudent" disabled>
                            <option value="">اختر الشعبة أولاً...</option>
                        </select>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-info" id="btnView" disabled><i class="fas fa-id-card"></i> عرض بطاقة الطالب</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        var baseUrl = "{{ url('SMT/admin/gradebook/api') }}";

        $('#selectClass').change(function() {
            var classId = $(this).val();
            if(classId) {
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
                // Reset Student
                $('#selectStudent').empty().prop('disabled', true);
            } else {
                $('#selectRoom').empty().prop('disabled', true);
                $('#selectStudent').empty().prop('disabled', true);
            }
             $('#btnView').prop('disabled', true);
        });

        $('#selectRoom').change(function() {
            var roomId = $(this).val();
            if(roomId) {
                $.ajax({
                    url: baseUrl + '/get-students/' + roomId,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('#selectStudent').empty().append('<option value="">اختر الطالب...</option>');
                        $.each(data, function(key, value) {
                            $('#selectStudent').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                        });
                        $('#selectStudent').prop('disabled', false);
                    }
                });
            } else {
                $('#selectStudent').empty().prop('disabled', true);
            }
            $('#btnView').prop('disabled', true);
        });

        $('#selectStudent').change(function() {
            if($(this).val()) {
                $('#btnView').prop('disabled', false);
            } else {
                $('#btnView').prop('disabled', true);
            }
        });
    });
</script>
@endsection
