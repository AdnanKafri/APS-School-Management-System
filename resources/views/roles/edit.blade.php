@extends('admin.master')
<head>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
    <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>

    <style>
    .custom-file-label{
    display:none !important;
    }
        .custom-file-label{
            display:none;
        }

        .section2_btn {
    border-radius: 35px;
    padding: 10px 12px;
    width: 100%;
    height: 52px;
    color: #fff;
    font-size: 16px;
    margin-bottom: 42px;
    -webkit-transition: all 0.5s;
    -o-transition: all 0.5s;
    -ms-transition: all 0.5s;
    -moz-transition: all 0.5s;
    transition: all 0.5s
}
        .btn22 {
    background: transparent;
    border: 2px solid #4285f4;
    color: #4285f4
}

.btn22:hover {
    background: #4285f4;
    color: #fff
}
.select2-selection__choice{
    background: #0d376a !important;
    color: #ddd !important;
}
.select2-container {
    width: -webkit-fill-available !important;
}
/* .choices .choices__inner{
    display: none;
} */
  hr{
        border-top: 2px solid rgb(0 0 0) !important;
}
    </style>
</head>

@section('breadcrumbs')

<nav class="breadcrumbs">
    <a  class="breadcrumbs__item is-active"> تعديل صلاحية </a>
      <a href="{{ route('admin.roles.index') }}" class="breadcrumbs__item "> قسم الصلاحيات </a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>

@endsection

@section('content')


<div class="col" style="direction:rtl;text-align:right;margin-top: 33px;">
    <div class="card" style="    text-align: center; font-size: medium;
    font-weight: bold;">

        <form id="form_update" method="POST" action="{{ route('admin.roles.update') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="role_id" id="role_id" value="{{$role->id}}">



                <div class="modal-body">
                     <h4 class="modal-title"style="text-align:center;padding-top:20px">تعديل دور</h4>


                    <div class="form-group" style="text-align:right">
                        <label>اسم الصلاحية</label>
                        <input type="text" id="name" value="{{$role->name}}" name="name" class="form-control"
                            value="" style="direction: rtl"
                            maxlength="30" required>
                    </div>



                            <div id="mydiv">
<div class="row d-flex justify-content-center mt-100">
    <div class="col-md-12">
        <div class="col-md-12" style="direction: ltr;
        text-align: right;">
            @foreach(config('global.permessions') as $name=>$value)
            @php
            $a='0';
        @endphp
        <div data-text="{{$value}}" class="special_department">
        @foreach ($permissions as $item)
            @if ($item==$name)

            <label>{{$value}}</label>
            <input type="checkbox" class="roles_check1" checked name="permissions[]" value="{{$name}}">
                @if ($item=="exams")
                <div id="select_class_exam">
            <label>اختر الصف     </label>
            <select  required  name="classes_exam[]" id="classes_select3"   class="form-control classes " placeholder="" multiple>
                    <option value="0" > جميع الصفوف</option>
                    @foreach($class as $key=>$item)

                          @if(in_array($item->id, $class_exam))

                    <option value="{{$item->id}}" selected> {{$item->name}}</option>
                    @else
                    <option value="{{$item->id}}"> {{$item->name}}</option>
                    @endif


                @endforeach



                </select>
                <label>اختر الشعبة     </label>
                 </div>
                  <div id="dvContainer4">
                    <select  name="rooms_exam[]" id="rooms_classes4" class="form-control rooms room_check1 " placeholder="" multiple>
                                        <option value="0"> جميع الشعب</option>
                @foreach($room_exam10 as $key=>$item)

                    @if(in_array($item->id, $rooms_exam))

                    <option   data-class ="{{$item->classes->id}}" value="{{$item->id}}"  selected> {{$item->name}}</option>
                    @else
                    <option data-class ="{{$item->classes->id}}" value="{{$item->id}}"> {{$item->name}}</option>
                    @endif


                @endforeach
                      </select>
                 </div>
                @endif
                 @if ($item=="quizes")
                 <div id="select_class_quize">
            <label>اختر الصف     </label>
            <select  required  name="classes_quize[]" id="classes_select_quize"   class="form-control classes " placeholder="" multiple>
                                            <option value="0"> جميع الصفوف</option>
                                            @foreach($class as $key=>$item)

                                                  @if(in_array($item->id, $class_quize))

                    <option value="{{$item->id}}" selected> {{$item->name}}</option>
                    @else
                    <option value="{{$item->id}}"> {{$item->name}}</option>
                    @endif

                                            @endforeach

                                        </select>


                                        <label>اختر الشعبة     </label>
                                         </div>
                                          <div id="dvContainer_quize">
                                            <select  name="rooms_quize[]" id="rooms_classes_quize" class="form-control rooms room_check1 " placeholder="" multiple>

                <option value="0"> جميع الشعب</option>
                @foreach($rooms_quize10 as $key=>$item)

                    @if(in_array($item->id, $rooms_quize))

                    <option   data-class ="{{$item->classes->id}}" value="{{$item->id}}"  selected> {{$item->name}}</option>
                    @else
                    <option data-class ="{{$item->classes->id}}" value="{{$item->id}}"> {{$item->name}}</option>
                    @endif


                @endforeach
                                                </select>
                                         </div>
                @endif
                   @if ($item=="secret_keeper")
                    <div id="select_class_secret_keeper">
            <label>اختر الصف     </label>
            <select  required  name="classes_secret_keeper[]" id="classes_select_secret_keeper"   class="form-control classes " placeholder="" multiple>
                                            <option value="0"> جميع الصفوف</option>
                                            @foreach($class as $key=>$item)

                                                  @if(in_array($item->id, $class_secret_keeper))

                    <option value="{{$item->id}}" selected> {{$item->name}}</option>
                    @else
                    <option value="{{$item->id}}"> {{$item->name}}</option>
                    @endif

                                            @endforeach

                                        </select>
                                         </div>
                    @endif
                @php
                    $a='1';
                @endphp
            @endif
        @endforeach

        @if ($a=='0')
        <label>{{$value}}</label>
            <input type="checkbox" class="roles_check1"   name="permissions[]" value="{{$name}}">

        @endif


            <br>
            </div>
            @endforeach
            <div  id="classes_check1" style="display:none">
                <label>اختر الصف لرد على رسائل الطلاب </label>
              <select  name="classes[]" id="classes_select2" class="form-control classes1 " placeholder="" multiple>
              <option value="0"> جميع الصفوف</option>
                @foreach($class as $key=>$item)

                @if(in_array($item->id, $class1))

                    <option value="{{$item->id}}" selected> {{$item->name}}</option>
                    @else
                    <option value="{{$item->id}}"> {{$item->name}}</option>
                    @endif


                @endforeach

            </select>
            <label>اختر الشعبة لرد على رسائل الطلاب </label>
            <div id="dvContainer2">
            <select  name="rooms[]" id="rooms_classes2"  class="form-control rooms1 room_check " placeholder="" multiple>
                <option value="0"> جميع الشعب</option>
                @foreach($rooms as $key=>$item)

                    @if(in_array($item->id, $rooms1))

                    <option   data-class ="{{$item->classes->id}}" value="{{$item->id}}"  selected> {{$item->name}}</option>
                    @else
                    <option data-class ="{{$item->classes->id}}" value="{{$item->id}}"> {{$item->name}}</option>
                    @endif


                @endforeach

            </select>
            </div>
        </div>



         {{-- <select  name="permissions[]" id="choices-multiple-remove-button1" class="form-control permissions2" placeholder="Select up to 3 tags" multiple>

            @foreach(config('global.permessions') as $name=>$value)
                @php
                    $a='0';
                @endphp
                @foreach ($data as $item)
                    @if ($item==$name)
                    <option value=" {{$name}}" selected> {{$value}}</option>
                        @php
                            $a='1';
                        @endphp
                    @endif
                @endforeach

                @if ($a=='0')
                 <option value=" {{$name}}"> {{$value}}</option>

                @endif

            @endforeach

        </select> --}}
  </div>
</div>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
                            </div>



                </div>
                <div class="modal-footer">

                    <button class="btn btn-info" id="save1">حفظ</button>
                </div>
            </form>
    </div>
</div>
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>


    $(document).ready(function(){
        var room_exam  =[];
        var room_quize  =[];
        var room  =[];
          room=$('.room_check').val();
          room_exam = $('#rooms_classes4').val();
          room_quize = $('#rooms_classes_quize').val();
        //   console.log(room);
         $.each($('.special_department'), function (key, value) {
       let text= $(this).data('text') ;
          if ( text.includes("مالية") ||    text.includes('شؤون' )    ||   text.includes('بالمدرسين')
             ||   text.includes('بالمنهاج')
             ||   text.includes('بالنسخ')
             ||   text.includes('الاختبارات')
             ||   text.includes('مباشرة')
             ||   text.includes('التقارير ')
             ||   text.includes('الجلاءات')
             ||   text.includes('بالصلاحيات')
             ||   text.includes('التوظيف')
             ||   text.includes('بالموقع')
             ||   text.includes('بالصفوف')
             ||   text.includes('بالمراحل')
             ||   text.includes('بالحصص ')
             ||   text.includes('بالفصول ')
             ||   text.includes('المستخدمين ')
             ||   text.includes('المكتبة ')
             ||   text.includes('الدول ')
             ||   text.includes('بالأقسام الأساسية ')
             ||   text.includes('الحلات الخاصة ')
             ||   text.includes('المشرف الوزراي')
             ||   text.includes('المكافآت والعقوبات')
             ||   text.includes('رسائل')
             ||   text.includes('البناء ')
             ||   text.includes('موظفي')
             ||   text.includes('بمشرفي')
             ||   text.includes('السر')
             ||   text.includes('لارشفة ')
             ||   text.includes('تصدير بيانات الطلاب  ')
             ||   text.includes('قسّم جدول الدوام  ')
             ||   text.includes('المدفوعات')){
                $(this).prepend(`<hr>`) ;
            }
  })

var multipleCancelButton = new Choices('#choices-multiple-remove-button1', {
removeItemButton: true,
maxItemCount:200,
searchResultLimit:50,
renderChoiceLimit:50
});
// var multipleCancelButton = new Choices('.classes1', {
// removeItemButton: true,
// maxItemCount:200,
// searchResultLimit:50,
// renderChoiceLimit:50
// });
$('.classes1').select2();
$('.rooms1').select2();
$('#classes_select_secret_keeper').select2();

$(document).on('change', '.room_check', function () {
     room  =[];
      room=$('.room_check').val()
        //   console.log(room);

})

$(document).on('change', '#rooms_classes4', function () {
     room_exam=[];
     room_exam = $(this).val();

});
$(document).on('change', '#rooms_classes_quize', function () {
     room_quize=[];
     room_quize = $(this).val();

});


$(document).on('change', '#classes_select2', function () {
    var class_id = $(this).val();
    if(class_id.includes('0')){
        $('#rooms_classes2').empty();
        $('#rooms_classes2').append(`<option value="0">جميع الشعب</option>`);
    } else {
        var url = "{{ URL::to('SMT/admin/classes/rooms23') }}/";
        $('#dvContainer2').empty();

        $.ajax({
            data: {
                class_id: class_id,
            },
            url: url,
            type: "get",
            contentType: 'application/json',
            success: function (data) {
            //     console.log(room);
            //   console.log(class_id);
                var t = `<select name="rooms[]" id="rooms_classes2" class="form-control rooms1 room_check" placeholder="" multiple>`;
                t += `<option value="0">جميع الشعب</option>`;
                $.each(data, function (key, value) {
                    select = false;
                       if(typeof(room) != "undefined" && room !== null){
                   if(class_id.includes(`${value.classes.id}`) && room.includes(`${value.id}`)){
                       select = true;
                   }}
                    t += `<option ${select ? "selected" : ""} data-class="${value.classes.id}" value="${value.id}">${value.name}</option>`;
                });
                t += `</select>`;
                $('.room_check').remove();
                $('#dvContainer2').append(t);
                $('.room_check').select2();
            },
        });
    }
});
  $(document).on('change', '#classes_select3', function () {
    var class_id = $(this).val();

    if(class_id.includes('0')){
        $('#rooms_classes4').empty();
        $('#rooms_classes4').append(`<option value="0">جميع الشعب</option>`);
    }
    else {
        var url = "{{ URL::to('SMT/admin/classes/rooms23') }}/" ;
         $('#dvContainer4').empty();

        $.ajax({
            data: {
                class_id: class_id,
            },
            url: url,
            type: "get",
            contentType: 'application/json',
            success: function (data) {

                var t = ` <select  required name="rooms_exam[]" id="rooms_classes4"
                class="form-control rooms" placeholder="" multiple>`;
                t += `<option value="0">جميع الشعب</option>`;
                $.each(data, function (key, value) {
                    select = false;
                      if(typeof(room_exam) != "undefined" && room_exam !== null){
                  if(class_id.includes(`${value.classes.id}`) && room_exam.includes(`${value.id}`)){
                      select = true;
                  }

                      }
                    t += `<option ${select ? "selected" : ""} data-class="${value.classes.id}" value="${value.id}">${value.name}</option>`;
                });
                t += `</select>`;
                 $('#dvContainer4').empty();
                $('#dvContainer4').append(t);
                $('#rooms_classes4').select2();
            },
        });

    }

});
$(document).on('change', '#classes_select_quize', function () {
    var class_id = $(this).val();

    if(class_id.includes('0')){
        $('#rooms_classes_quize').empty();
        $('#rooms_classes_quize').append(`<option value="0">جميع الشعب</option>`);
    }
    else {
        var url = "{{ URL::to('SMT/admin/classes/rooms23') }}/" ;
         $('#dvContainer_quize').empty();

        $.ajax({
            data: {
                class_id: class_id,
            },
            url: url,
            type: "get",
            contentType: 'application/json',
            success: function (data) {

                var t = ` <select required  name="rooms_quize[]" id="rooms_classes_quize"
                class="form-control rooms" placeholder="" multiple>`;
                t += `<option value="0">جميع الشعب</option>`;
                $.each(data, function (key, value) {
                    select = false;
                     if(typeof(room_quize) != "undefined" && room_quize !== null){
                  if(class_id.includes(`${value.classes.id}`) && room_quize.includes(`${value.id}`)){
                      select = true;
                  }}
                    t += `<option ${select ? "selected" : ""} data-class="${value.classes.id}" value="${value.id}">${value.name}</option>`;
                });
                t += `</select>`;
                $('#dvContainer_quize').empty();
                $('#dvContainer_quize').append(t);
                $('#rooms_classes_quize').select2();
            },
        });

    }

});


// $('#classes_select3').on('change', function () {
//     var class_id = $(this).val();

//     if(class_id.includes('0')){
//         $('#rooms_classes4').empty();
//         $('#rooms_classes4').append(`<option value="0">جميع الشعب</option>`);
//     }
//     else {
//         var url = "{{ URL::to('SMT/admin/classes/rooms23') }}/" ;
//          $('#dvContainer4').empty();

//         $.ajax({
//             data: {
//                 class_id: class_id,
//             },
//             url: url,
//             type: "get",
//             contentType: 'application/json',
//             success: function (data) {

//                 var t = ` <select  required name="rooms_exam[]" id="rooms_classes4"
//                 class="form-control rooms" placeholder="" multiple>`;
//                 t += `<option value="0">جميع الشعب</option>`;
//                 $.each(data, function (key, value) {
//                     select = false;
//                   if(class_id.includes(`${value.classes.id}`) && room_exam.includes(`${value.id}`)){
//                       select = true;
//                   }
//                     t += `<option ${select ? "selected" : ""} data-class="${value.classes.id}" value="${value.id}">${value.name}</option>`;
//                 });
//                 t += `</select>`;
//                  $('#dvContainer4').empty();
//                 $('#dvContainer4').append(t);
//                 $('#rooms_classes4').select2();
//             },
//         });

//     }

// });
//  $('#classes_select_quize').on('change', function () {
//     var class_id = $(this).val();

//     if(class_id.includes('0')){
//         $('#rooms_classes_quize').empty();
//         $('#rooms_classes_quize').append(`<option value="0">جميع الشعب</option>`);
//     }
//     else {
//         var url = "{{ URL::to('SMT/admin/classes/rooms23') }}/" ;
//          $('#dvContainer_quize').empty();

//         $.ajax({
//             data: {
//                 class_id: class_id,
//             },
//             url: url,
//             type: "get",
//             contentType: 'application/json',
//             success: function (data) {

//                 var t = ` <select required  name="rooms_quize[]" id="rooms_classes_quize"
//                 class="form-control rooms" placeholder="" multiple>`;
//                 t += `<option value="0">جميع الشعب</option>`;
//                 $.each(data, function (key, value) {
//                     select = false;
//                   if(class_id.includes(`${value.classes.id}`) && room_quize.includes(`${value.id}`)){
//                       select = true;
//                   }
//                     t += `<option ${select ? "selected" : ""} data-class="${value.classes.id}" value="${value.id}">${value.name}</option>`;
//                 });
//                 t += `</select>`;
//                 $('#dvContainer_quize').empty();
//                 $('#dvContainer_quize').append(t);
//                 $('#rooms_classes_quize').select2();
//             },
//         });

//     }

// });



$.each($('.roles_check1'), function (key, value) {
         if($(this).val() == "exams"){
        if ($(this).is(':checked')){
                 $.each($('.special_department'), function (key, value) {
       let text= $(this).data('text') ;
       if(text.includes('الامتحانات')){
           ;
                 }

                 })
                  $('#classes_select3').select2();
                   $('#rooms_classes4').select2();

        }
        else{



             $('#select_class_exam').remove();
             $('#dvContainer4').remove();


        }



    }
     if($(this).val() == "quizes"){
        if ($(this).is(':checked')){
                 $.each($('.special_department'), function (key, value) {
       let text= $(this).data('text') ;
       if(text.includes('مذاكرات')){

                 }

                 })
                  $('#classes_select_quize').select2();
                   $('#rooms_classes_quize').select2();

        }
        else{



             $('#select_class_quize').remove();
             $('#dvContainer_quize').remove();


        }



    }

    if($(this).val() == "message_student"){
    if ($(this).is(':checked')){
        $('#classes_check1').show();
        $('#classes_select2').prop('required',true);
    }
    else{

        $('#classes_check1').hide();
        $('#classes_select2').removeAttr('required');

    }

}

})
$(document).on('change','.roles_check1', function (e) {

if($(this).val() == "message_student"){
    if ($(this).is(':checked')){
        $('#classes_select2').empty();
            $('#classes_check1').show();
            $('#classes_select2').prop('required',true);
            $('#classes_select2').append(` <option value="0"> جميع الصفوف</option>
                                            @foreach($class as $key=>$item)

                                                 <option value="{{$item->id}}"> {{$item->name}}</option>

                                            @endforeach `);
    }
    else{
        $('#rooms_classes2').empty();
        $('#classes_select2').empty()
        $('#classes_check1').hide();
        $('#classes_select2').removeAttr('required');
    }

}
       if($(this).val() == "exams"){
        if ($(this).is(':checked')){
                 $.each($('.special_department'), function (key, value) {
       let text= $(this).data('text') ;
       if(text.includes('الامتحانات')){
            $(this).append(`<div id="select_class_exam">
            <label>اختر الصف     </label>
            <select  required  name="classes_exam[]" id="classes_select3"   class="form-control classes " placeholder="" multiple>
                                            <option value="0"> جميع الصفوف</option>
                                            @foreach($class as $key=>$item)

                                                 <option value="{{$item->id}}"> {{$item->name}}</option>

                                            @endforeach

                                        </select>


                                        <label>اختر الشعبة     </label>
                                         </div>
                                          <div id="dvContainer4">
                                            <select  name="" id="rooms_classes4" class="form-control rooms room_check1 " placeholder="" multiple>
                                         </div>`);
                 }

                 })
                  $('#classes_select3').select2();
                   $('#rooms_classes4').select2();

        }
        else{



             $('#select_class_exam').remove();
             $('#dvContainer4').remove();


        }



    }
     if($(this).val() == "quizes"){
        if ($(this).is(':checked')){
                 $.each($('.special_department'), function (key, value) {
       let text= $(this).data('text') ;
       if(text.includes('مذاكرات')){
            $(this).append(`<div id="select_class_quize">
            <label>اختر الصف     </label>
            <select  required  name="classes_quize[]" id="classes_select_quize"   class="form-control classes " placeholder="" multiple>
                                            <option value="0"> جميع الصفوف</option>
                                            @foreach($class as $key=>$item)

                                                 <option value="{{$item->id}}"> {{$item->name}}</option>

                                            @endforeach

                                        </select>


                                        <label>اختر الشعبة     </label>
                                         </div>
                                          <div id="dvContainer_quize">
                                            <select  name="" id="rooms_classes_quize" class="form-control rooms room_check1 " placeholder="" multiple>
                                         </div>`);
                 }

                 })
                  $('#classes_select_quize').select2();
                   $('#rooms_classes_quize').select2();

        }
        else{



             $('#select_class_quize').remove();
             $('#dvContainer_quize').remove();


        }



    }
         if($(this).val() == "secret_keeper"){
        if ($(this).is(':checked')){
                 $.each($('.special_department'), function (key, value) {
       let text= $(this).data('text') ;
       if(text.includes('سر')){
            $(this).append(`<div id="select_class_secret_keeper">
            <label>اختر الصف     </label>
            <select  required  name="classes_secret_keeper[]" id="classes_select_secret_keeper"   class="form-control classes " placeholder="" multiple>
                                            <option value="0"> جميع الصفوف</option>
                                            @foreach($class as $key=>$item)

                                                 <option value="{{$item->id}}"> {{$item->name}}</option>

                                            @endforeach

                                        </select>`);
                 }

                 })
                  $('#classes_select_secret_keeper').select2();


        }
        else{



             $('#select_class_secret_keeper').remove();



        }



    }

})
});
</script>

@endsection
