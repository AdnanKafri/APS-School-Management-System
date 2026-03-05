@section('content')

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
                @foreach ($permissions as $item)
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



<script>


var room  =[];

    $(document).ready(function(){
          room=$('.room_check').val()
        //   console.log(room);
         $.each($('.special_department'), function (key, value) {
       let text= $(this).data('text') ;
          if ( text.includes("مالية") ||    text.includes('شؤون' )    ||   text.includes('بالمدرسين')
             ||   text.includes('بالمنهاج')
             ||   text.includes('بالنسخ')
             ||   text.includes('والاختبارات')
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


});
$(document).on('change', '.room_check', function () {
     room  =[];
      room=$('.room_check').val()
        //   console.log(room);
    
})
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
                   if(class_id.includes(`${value.classes.id}`) && room.includes(`${value.id}`)){
                       select = true;  
                   }
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

// $(document).on('change', '#classes_select2', function () {
//     var class_id = $(this).val();
// if(jQuery.inArray('0',class_id) !== -1){
//   $('#rooms_classes2').empty();
// $('#rooms_classes2').append(`<option value="0">جميع الشعب</option>`);   
//      }
//  else{
//     var url = "{{ URL::to('SMT/admin/classes/rooms23') }}/" ;
// $('#dvContainer2').empty();
// $.ajax({
//     data:{
//         class_id:class_id,
//     },
//     url: url,
//     type: "get",
//     contentType: 'application/json',
//     success: function (data) {
//         var t = `<select  name="rooms[]" id="rooms_classes2"  class="form-control rooms1 room_check " placeholder="" multiple>`;
//               t+= `<option value="0">جميع الشعب</option`;
//         $.each(data, function (key, value) {
//              select = false;
//               if(jQuery.inArray( value.classes.id,class_id) !== -1 &&  jQuery.inArray( value.id,room) !== -1){
//               select = true;  
//             }
       
//         t+= `<option ${select ? "selected" : ""}  data-class="${value.classes.id}" value="${ value.id }"> ${ value.name } </option>`;
        
//     });
//     t+= `</select>`;
//     $('.rooms_classes2').remove();
//     // $('.select2 ').remove();
//     $('#dvContainer2').append(t);
//     $('.rooms_classes2').select2();
     
//     },


// }); 
// // room=[];
// //  room=$('.room_check').val()
// }
// });



$.each($('.roles_check1'), function (key, value) {
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

})
</script>


@endsection
