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
    <a  class="breadcrumbs__item is-active">قسم الصلاحيات</a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>

@endsection

@section('content')
<div class="col" style="direction:rtl; text-align:right">
    <div class="card">

        <!--@if(session()->has('success'))-->


        <!--<div class="alert alert-success alert-dismissible" role="alert" style="text-align: right; font-size: 30px">-->
        <!--    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
        <!--    {{ session()->get('success') }}-->
        <!--    </div>-->

        <!--@endif-->



            <div class="card-header border-0">
              <h3 class="mb-0">جدول الادوار</h3>
            </div>

    <div class="table-responsive">

    <a href="{{route('admin.roles.add')}}" class=" btn btn-success" 
    data-id=""><i class="material-icons" data-toggle="tooltip">إنشاء دور جديد</i></a>


              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <!--<th scope="col" class="sort" data-sort="name">Id</th>-->
                    <th scope="col" class="sort" data-sort="budget"> الاسم</th>

                    {{-- <th scope="col" class="sort" data-sort="budget"> الاذونات</th> --}}

                    <th scope="col" class="sort" data-sort="budget"> العمليات</th>

                  </tr>
                </thead>
                <tbody class="list">
                @foreach ($roles as $item)

               <tr>


                <td class="budget" style="font-weight:bold;font-size:15px">
                    {{$item->name}}
                  </td>

                  {{-- <td class="budget" style="font-weight:bold;font-size:15px">
                  @foreach ($item->permissions as $permission)
                    {{$permission}} ,

                  @endforeach

                </td> --}}

                    <td class="text-right">

                 <!--<a class="section2_btn btn22 edit " type="button" href=".editClassModal" class="edit" data-name="{{ $item->name }}"  data-id="{{ $item->id }}"data-toggle="modal" >تعديل الأذونات</a>-->
                   <a class="section2_btn btn22  " type="button" href="{{route('admin.roles.edit',$item->id)}}" class="edit"  data-id="{{ $item->id }}" >تعديل الأذونات</a>

                </td>


                  </tr>


               @endforeach


                </tbody>
              </table>

            </div>












    </div>
</div>



<div class="modal fade editClassModal" style="padding-top: 100px">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form_update" method="POST" action="{{ route('admin.roles.update') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="role_id" id="role_id">
                <div class="modal-header">
                   
                    <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">&times;</button>
                </div>


                <div class="modal-body">
                     <h4 class="modal-title"style="text-align:center;padding-top:20px">تعديل الأذونات</h4>


                    <div class="form-group" style="text-align:right">
                        <label>اسم الصلاحية</label>
                        <input type="text" id="name" name="name" class="form-control"
                            value="" style="direction: rtl"
                            maxlength="30" required>
                    </div>



                            <div id="mydiv">

                            </div>



                </div>
                <div class="modal-footer">
                    <a class="btn btn-default" data-dismiss="modal">اغلاق</a>
                    <button class="btn btn-info" id="save1">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>





            <div class="modal fade createClassModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="" action="{{ route('admin.roles.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="modal-header">
                                <h4 class="modal-title">اضافة اذن</h4>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">



                            <div class="form-group" style="text-align:right">
                                    <label>اسم الصلاحية</label>
                                    <input type="text" name="name" class="form-control"
                                        value="" style="direction: rtl"
                                        placeholder="" maxlength="30" required>
                                </div>

                                <div class="row d-flex justify-content-center mt-100">
                                    <label>اختيار الأذونات</label>

                                    <div class="col-md-12" style="direction: ltr;
                                    text-align: right;">
                                        @foreach(config('global.permessions') as $name=>$value)
                                        <div data-text="{{$value}}" class="special_departmentt">
                                            
                                   
                                        <label>{{$value}}</label>
                                        <input   class="roles_check" type="checkbox" name="permissions[]" value="{{$name}}">
                                        <br>
                                       </div>
                                        @endforeach
                                         {{-- <select  name="permissions[]" id="choices-multiple-remove-button" class="form-control permissions" placeholder="Select up to 3 tags" multiple>

                                            @foreach(config('global.permessions') as $name=>$value)
    
                                                 <option value=" {{$name}}"> {{$value}}</option>
    
                                            @endforeach

                                        </select> --}}
                                        <div  id="classes_check" style="display:none">
                                            <label>اختر الصف لرد على رسائل الطلاب </label>
                                          <select  name="classes[]" id="classes_select1"   class="form-control classes " placeholder="" multiple>
                                            <option value="0"> جميع الصفوف</option>
                                            @foreach($class as $key=>$item)
    
                                                 <option value="{{$item->id}}"> {{$item->name}}</option>
    
                                            @endforeach

                                        </select>
                                        <label>اختر الشعبة لرد على رسائل الطلاب </label>
                                          <div id="dvContainer3">
                                            <select  name="rooms[]" id="rooms_classes1" class="form-control rooms room_check1 " placeholder="" multiple>
                                         </div>
                                            
                                         

                                        </select>
                                    </div>
                                  </div>
                                </div>





                            </div>
                            <div class="modal-footer">
                                <a class="btn btn-default" data-dismiss="modal">الغاء</a>
                                <button class="btn btn-info" id="save">حفظ</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade deleteEmployeeModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form id="form_delete" method="POST">
                                        @csrf
                                        @method('delete')
                                        <div class="modal-header">
                                            <h4 class="modal-title">Delete element</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-hidden="true">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete these Records?</p>
                                            <p class="text-warning"><small>This action cannot be undone.</small></p>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn btn-default" data-dismiss="modal"
                                                value="Cancel">

                                            <button class="btn btn-danger">Delete</button>


                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
var room1  =[];


  $.each($('.special_departmentt'), function (key, value) {
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
    $(document).ready(function(){
$(document).on('change', '.room_che', function () {
     room1=[];
     room1 = $(this).val();
    console.log(room1);
});

var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
removeItemButton: true,
maxItemCount:200,
searchResultLimit:50,
renderChoiceLimit:50
});

// var multipleCancelButton = new Choices('.classes', {
// removeItemButton: true,
// maxItemCount:200,
// searchResultLimit:50,
// renderChoiceLimit:50
// });



});
$('.classes').select2();
$('.rooms').select2();

  


$(document).on('change', '#classes_select1', function () {
    var class_id = $(this).val();
    
   

    if(class_id.includes('0')){
        $('#rooms_classes1').empty();
        $('#rooms_classes1').append(`<option value="0">جميع الشعب</option>`);   
    } 
    else {
        var url = "{{ URL::to('SMT/admin/classes/rooms23') }}/" ;
         $('#dvContainer3').empty();

        $.ajax({
            data: {
                class_id: class_id,
            },
            url: url,   
            type: "get",
            contentType: 'application/json',
            success: function (data) {
             
                var t = ` <select  name="rooms[]" id="rooms_classes1" 
                class="form-control rooms room_che" placeholder="" multiple>`;
                t += `<option value="0">جميع الشعب</option>`;
                $.each(data, function (key, value) {
                    select = false;  
                   if(class_id.includes(`${value.classes.id}`) && room1.includes(`${value.id}`)){
                       select = true;  
                   }
                    t += `<option ${select ? "selected" : ""} data-class="${value.classes.id}" value="${value.id}">${value.name}</option>`;
                });
                t += `</select>`;
              
                $('#dvContainer3').append(t);
                $('.room_che').select2();
            },
        });
        
    }
  
});

$(document).on('change','.roles_check', function (e) {

    if($(this).val() == "message_student"){
        if ($(this).is(':checked')){
            $('#classes_select1').empty();
            $('#classes_check').show();   
            $('#classes_select1').prop('required',true);
            $('#classes_select1').append(` <option value="0"> جميع الصفوف</option>
                                            @foreach($class as $key=>$item)
    
                                                 <option value="{{$item->id}}"> {{$item->name}}</option>
    
                                            @endforeach `);    
        }
        else{
            $('#rooms_classes1').empty();
           $('#classes_select1').empty()
            $('#classes_check').hide();  
             $('#classes_select1').removeAttr('required');
        }

      

    }

})
$(document).on('click','#save1', function (e) {
    check1=0;
    $.each($('.roles_check1'), function (key, value) {
   
    if ($(this).is(':checked')){
        check1=1; 
    }
    
   
})
if(check1>=1){
    return true; 
    }
    else{
        alert('يجب اختيار صلاحية واحدة على الاقل ');
        return false;
       
    }
})


$(document).on('click','#save', function (e) {
    check=0;
    $.each($('.roles_check'), function (key, value) {
   
    if ($(this).is(':checked')){
        check=1; 
    }
   
})
if(check>=1){
    return true; 
    }
    else{
        alert('يجب اختيار صلاحية واحدة على الاقل ');
        return false;
       
    }
})



$(document).on('click','.edit', function (e) {
    
    var id = $(this).data('id');
    $('#role_id').val(id);
$('#name').val($(this).data('name'));
    e.preventDefault();
$.ajax({
    type:'get',
    url:"roles/edit/"+id,
    enctype:'multipart/form-data',

    success:function(data){

 $('#mydiv').empty();
$('#mydiv').html(data.data);
    },
    error: function (xhr) {

}

})



});

</script>


@endsection
