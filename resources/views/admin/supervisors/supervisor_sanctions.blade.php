@extends('admin.supervisors.layouts.new_app')

@section('css')
<link rel="stylesheet" href="{{ asset('student/assets/css/demo_1/style.css') }}" />
<link rel="stylesheet" href="{{ asset('student/assets/css/demo_1/prizes.css') }}">
     <style>

/*end style cards*/
.checkbox:checked + label,
      .checkbox:not(:checked) + label{

        position: relative;
        background-color: white !important;
        cursor: pointer;
        margin: 0 auto;
        text-align: center;
        margin-right: 6px;
        margin-left: 6px;
        display: inline-block;
        width: 50px;
        height: 50px;
        border: 3px solid #bdc3c7;
        background-size: cover;
        background-position: center;
        box-sizing: border-box;
        -webkit-transition: all 0.2s ease;
        transition: all 0.2s ease;
        background-image: url("{{  asset('student/demo/icons/p-1.png') }}");
        animation: border-transform 6s linear infinite alternate forwards;
          -webkit-animation-play-state: paused;
          -moz-animation-play-state: paused;
          animation-play-state: paused;
      }
      .checkbox.scnd + label{
        background-image: url("{{  asset('student/demo/icons/p-2.png') }}");
      }
      .checkbox.thrd + label{
        background-image: url("{{  asset('student/demo/icons/p-3.png') }}");
      }
     @media(min-width:1100px) and (max-width:2000px){
        .medalcontent{
            width:87% !important;
            right: 5% !important;
        }
     }
     .select2-selection__rendered{
    padding-top: 16px;
}
.select2-container--default .select2-selection--single {
    height: 43px;
}
	 </style>

	@endsection
    @section('content')
    <div class="main-panel" style="background: #f8f9fb;">

        <div class="content-wrapper pb-0">
          <!--tablist -->
          <div class="row" style="justify-content: center;">
            <div class="col-sm-5">
                <div class="form-group newselect">
                    <select class="js-example-basic-single room_select" style="width: 100%;direction: rtl;">
                        <option value="">اختر الشعبة</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="form-group newselect">
                    <select class="js-example-basic-single class_select" style="width: 100%;direction: rtl;">
                        <option value="">اختر الصف </option>
                        @foreach ($classes as $item)
                            <option value="{{ $item->id }}"> {{ $item->name }} </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

<div class="warpper">
<input class="radio" id="one" name="group" type="radio" checked>
<input class="radio" id="two" name="group" type="radio">
<input class="radio" id="three" name="group" type="radio">

<div class="tabs">
  <label class="tab" id="one-tab" for="one">   العقابات  </label>

</div>

<div class="panels">
  <div class="panel" id="one-panel">
    <div class="panel-title"></div>
      <!--table-->
      <div class="table-responsive">
        <table class="table table-hover " id="table">
          <thead>
            <tr>
              <th>اسم   الطالب </th>
              <th>  الصف </th>
              <th>   الشعبة </th>
              <th>اسم المادة</th>
              <th>اسم  الاستاذ </th>
              <th>اسم   العقاب </th>
              <th>تاريخ المنح</th>
              <th> الصورة</th>

            </tr>
          </thead>
          <tbody>
            @foreach($rewads as $rewad)
            <tr>
                {{-- <td>اسم الاستاذ الأول </td> --}}
                <td  data-label="اسم    الطالب ">{{ $rewad->student->first_name }} {{ $rewad->student->last_name }} </td>
                <td  data-label="اسم  الصف">{{ $rewad->room->classes->name }} </td>
                <td  data-label="اسم  الشعبة">{{ $rewad->room->name }} </td>
                <td  data-label="اسم المادة">{{ $rewad->lesson->name }} </td>
                <td  data-label="اسم  الاستاذ">{{ $rewad->teacher->first_name }} {{ $rewad->teacher->last_name }} </td>
                <td data-label="  اسم  العقاب"> {{ $rewad->rewad_and_sanction->name }}  </td>
                <td data-label="تاريخ المنح"> {{ $rewad->created_at }}  </td>
            
                <td data-label=" الصورة"><img src="{{ asset('storage/'.$rewad->rewad_and_sanction->image) }}"
                    id="image6" alt="Not found" width="50" alt=""> </td>
               
            </tr>
            @endforeach

          </tbody>
        </table>
      </div>
      <!--end tabel-->
  </div>

</div>
</div>
<br>
<br>
          <!-- end tablist -->
 

	@endsection
  @section('js')
  <script>
     $(document).ready(function(){
      $('.medal11').addClass('active') ;
    })
  
    $(".class_select").on("change", function(e) {
        $('.room_select').val(null);
            var year_id = "{{ $year->id }}";
            var class_id = $(this).val();
            var url = "{{ URL::to('SMARMANger/admin/classes/rooms2/') }}/" + class_id + "/" +
            year_id;
          
            $('.room_select').empty();
            $('.room_select').append(`<option value="">جميع الشعب</option>`);
            $.ajax({
                url: url,
                type: "get",
                contentType: 'application/json',
                success: function(data) {
                    $('.room_select').select2('destroy')
                    $('.room_select').empty()
                    $('.room_select').append(`<option value="">اختر الشعبة</option>`);
                    $.each(data, function(key, value) {
                        $('.room_select').append(
                            `<option value="${value.id}">${value.name}</option>`);
                    });
                    $('.room_select').select2()
                },


            });
            $('.room_select').val(null)
        });

        $(".room_select,.class_select").on("change", function(e) {
            
           
            console.log($('.room_select').val());
            $('#table tbody').empty();
            var url = "{{ route('filter_rewads') }}";
            $.ajax({
                url: url,
                data: {
                    'class': $('.class_select').val(),
                    'room': $('.room_select').val(),
                    'type': 2,
                },
                type: "get",
                contentType: 'application/json',
                success: function(data) {
                   
                    console.log(data);
                    $.each(data, function(index, value) {
                        var value1 = new Date(value.created_at);
            var formattedDate = value1.toLocaleString();
            $('#table tbody').append(` 
                <tr>
                    <td  data-label="اسم الطالب ">${ value.student.first_name } ${value.student.last_name } </td>
                    <td  data-label="اسم  الصف">${ value.room.classes.name } </td>
                    <td  data-label="اسم  الشعبة">${ value.room.name } </td>
                    <td  data-label="اسم المادة">${ value.lesson.name }</td>
                    <td  data-label="اسم  الاستاذ">${ value.teacher.first_name }  ${ value.teacher.last_name }  </td>
                    <td data-label="  اسم  العقاب">${ value.rewad_and_sanction.name } </td>
                    <td data-label="تاريخ   المنح"> ${ formattedDate }  </td>
                    <td data-label=" الصورة"><img src="{{ asset('storage/') }}/${value.rewad_and_sanction.image}" id="image6" alt="Not found" width="50" alt=""> </td>
                </tr>
            `);
        });
                }
            })
        })
      
  </script>

  	@endsection
