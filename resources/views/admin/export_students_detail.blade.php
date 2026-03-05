@extends('admin.master')
@section('style')

<style>
.content-body{
        min-height: 0px !important;
}
.text-white{
    margin: 0px !important;
}
.card{
    height: 200px;
    text-align: center !important
}
*{
    text-align: center !important;
    direction: rtl !important;
    font
}
select {
    width:75% !important;
    display:inline-block !important;
}
label{
    font-size: 20px;
    margin: 10px;
    color: black;
    font-weight: 600;
}
</style>
       @endsection


@section('breadcrumbs')

<nav class="breadcrumbs">
    <a  class="breadcrumbs__item  is-active">تصدير بيانات الطلاب   </a>

    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>

@endsection

@section('content')
<h1 class="mt-5 mb-5" >     </h1>
<div class="row" >
    <div class="col-2"></div>
    <div class="col-8" >
        <form action="{{ route('export_student_detail_page') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1">   المرحلة </label>
                <select class="form-control "   name="stage" id="stage_id_filter1">
                    <option value="0">  جميع المراحل </option>
                    @foreach ($stages as $stage)
                    <option value="{{ $stage->id }}">{{ $stage->name }}</option>
                    @endforeach
                </select>
              </div>
  

            <div class="form-group">
              <label for="exampleInputEmail1">  الصف </label>
              <select  name="classes" id="classes_select" class="form-control" >
                <option value="0"> جميع الصفوف </option>
                @foreach ($classes as $item)
                    <option value="{{ $item->id }}"> {{ $item->name }} </option>
                @endforeach
            </select>
            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">  الشعبة </label>
              <select  name="rooms" id="rooms_classes" class="form-control" >
                <option value="0"> جميع الشعب </option>
            </select>
            </div>

            

            <div class="form-group">
              <label for="">   تحديد الحقول  </label>
              <div class="form-group">
                @can('export_id')
                <input type="checkbox" id="id" name="fields[]"  value= 'id'>
                <label for="id">     رقم التسجيل    </label>
                @endcan
                @can('export_first_name')
                <input type="checkbox" id="first_name"  name="fields[]" value= 'first_name'>
                <label for="first_name">      الاسم الاول    </label>
                @endcan
                @can('export_last_name')
                <input type="checkbox" id="last_name" name="fields[]" value= 'last_name'>
                <label for="last_name">      الكنية    </label>
                @endcan
                @can('export_father_name')
                <input type="checkbox" id="father_name"  name="fields[]" value= 'father_name'>
                <label for="father_name">    اسم الاب   </label>
                @endcan
                @can('export_mother_name')
                <input type="checkbox" id="mother_name" name="fields[]"  value= 'mother_name'>
                <label for="mother_name">    اسم الام    </label>
                @endcan
                @can('export_date_birth')
                <input type="checkbox" id="date_birth" name="fields[]" value= 'date_birth'>
                <label for="date_birth">     تاريخ الولادة   </label>
                @endcan
                @can('export_address')
                <input type="checkbox" id="address"  name="fields[]"  value= 'address'>
                <label for="address">    العنوان   </label>
                @endcan
                @can('export_country')
                <input type="checkbox" id="country" name="fields[]"  value= 'country'>
                <label for="country">     الدولة   </label>
                @endcan
                @can('export_phone')
                <input type="checkbox" id="phone"  name="fields[]"  value= 'phone'>
                <label for="phone">    الهاتف   </label>
                @endcan
                @can('export_religion')
                <input type="checkbox" id="religion"  name="fields[]" value= 'religion'>
                <label for="religion">    الديانة   </label>
                @endcan
                @can('export_lang')
                <input type="checkbox" id="lang" name="fields[]"  value= 'lang'>  
                <label for="lang">    اللغة   </label>             
                @endcan
                @can('export_email')
                <input type="checkbox" id="email" name="fields[]"  value= 'email'>
                <label for="email">    الايميل   </label>
                @endcan
                @can('export_password')
                <input type="checkbox" id="password"  name="fields[]"  value= 'password'>
                <label for="password">    كلمة السر   </label>
                @endcan
                @can('export_class')
                <input type="checkbox" id="class"  name="fields[]"  value= 'class'>
                <label for="class">    الصف    </label>
                @endcan
                @can('export_room')
                <input type="checkbox" id="room" name="fields[]"  value= 'room'>
                <label for="room">    الشعبة    </label>
                @endcan
                
              </div>
           
            </div>

            <button  id="export"  class="btn btn-success"> تصدير </button>

          </form>
    </div>
</div>

@endsection

@section('js')
<script>

$(document).ready(function () {


    // $(document).on('click','#export', function () {
    //     class_id = $('#class_id').val();
    //     room_id = $('#room_id').val();
    //     console.log(room_id) ;
    //     if (class_id != '' && room_id) {
    //         window.open(`{{ url('SMT/admin/show/report/student') }}/${class_id}/${$('#room_id').val()}/${$('#lesson_id').val()}/${$('#term_id').val()}`, '_blank');
    //     }
    // })



});
$(document).on('change', '#stage_id_filter1', function () {

// var year_id = $('#years').val();
var stage_id = $(this).val();
var url = "{{ URL::to('SMT/admin/stages_class') }}/" + stage_id ;
$.ajax({
    url: url,
    type: "get",
    contentType: 'application/json',
    success: function (data) {
        $('#rooms_classes').empty();
       $('#rooms_classes').append(`<option value="0">جميع الشعب</option>`);
        $('#classes_select').empty();
        $('#classes_select').append(`<option value="">اختر  الصف  </option>`);
        $.each(data, function (key, value) {
            $('#classes_select').append(
                `<option value="${value.id}">${value.name}</option>`);
        });
    },


});
});
$(document).on('change', '#classes_select', function () {

var year_id=$('#years').val();
var class_id=$(this).val();
var url = "{{ URL::to('SMT/admin/classes/rooms2') }}/" + class_id +"/"+ year_id;
$('#rooms_classes').empty();
$('#rooms_classes').append(`<option value="0">جميع الشعب</option>`);
$.ajax({
    url: url,
    type: "get",
    contentType: 'application/json',
    success: function (data) {
        $.each(data, function (key, value) {
            $('#rooms_classes').append(`<option value="${value.id}">${value.name}</option>`);
        });
    },


});
});
</script>
@endsection

