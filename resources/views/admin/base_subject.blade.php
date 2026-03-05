@extends('admin.master')



@section('breadcrumbs')

<nav class="breadcrumbs">
     <a  class="breadcrumbs__item is-active">الأقسام الأساسية </a>
    <a  href="{{ route('lessons',$class_id) }}" class="breadcrumbs__item is-active">قسم مواد الصف</a>
    <a href="{{ route('lessons2') }}" class="breadcrumbs__item ">قسم المناهج</a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>

@endsection
@section('content')


<head>



    <style>
    .custom-file-label{
    display:none !important;
    }
        .custom-file-label{
            display:none;
        }


.wrapper{
  display: inline-flex;
  background: #fff;
  height: 100px;
  width: 400px;
  align-items: center;
  justify-content: space-evenly;
  border-radius: 5px;
  padding: 20px 15px;
  margin-left: 25px;
  box-shadow: 5px 5px 30px rgba(0,0,0,0.2);
}
.wrapper .option{
  background: #fff;
  height: 100%;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-evenly;
  margin: 0 10px;
  border-radius: 5px;
  cursor: pointer;
  padding: 0 10px;
  border: 2px solid lightgrey;
  transition: all 0.3s ease;
}
.wrapper .option .dot{
  height: 20px;
  width: 20px;
  background: #d9d9d9;
  border-radius: 50%;
  position: relative;
}
.wrapper .option .dot::before{
  position: absolute;
  content: "";
  top: 4px;
  left: 4px;
  width: 12px;
  height: 12px;
  background: #0069d9;
  border-radius: 50%;
  opacity: 0;
  transform: scale(1.5);
  transition: all 0.3s ease;
}
.wrapper input[type="radio"]{
  display: none;
}
#option-1:checked:checked ~ .option-1,
#option-2:checked:checked ~ .option-2{
  border-color: #0069d9;
  background: #0069d9;
}
#option-1:checked:checked ~ .option-1 .dot,
#option-2:checked:checked ~ .option-2 .dot{
  background: #fff;
}
#option-1:checked:checked ~ .option-1 .dot::before,
#option-2:checked:checked ~ .option-2 .dot::before{
  opacity: 1;
  transform: scale(1);
}
.wrapper .option span{
  font-size: 20px;
  color: #808080;
}
#option-1:checked:checked ~ .option-1 span,
#option-2:checked:checked ~ .option-2 span{
  color: #fff;
}




.wrapper2{
  display: inline-flex;
  background: #fff;
  height: 100px;
  width: 400px;
  align-items: center;
  justify-content: space-evenly;
  border-radius: 5px;
  padding: 20px 15px;
  margin-left: 25px;
  box-shadow: 5px 5px 30px rgba(0,0,0,0.2);
}
.wrapper2 .option{
  background: #fff;
  height: 100%;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-evenly;
  margin: 0 10px;
  border-radius: 5px;
  cursor: pointer;
  padding: 0 10px;
  border: 2px solid lightgrey;
  transition: all 0.3s ease;
}
.wrapper2 .option .dot{
  height: 20px;
  width: 20px;
  background: #d9d9d9;
  border-radius: 50%;
  position: relative;
}
.wrapper2 .option .dot::before{
  position: absolute;
  content: "";
  top: 4px;
  left: 4px;
  width: 12px;
  height: 12px;
  background: #0069d9;
  border-radius: 50%;
  opacity: 0;
  transform: scale(1.5);
  transition: all 0.3s ease;
}
.wrapper2 input[type="radio"]{
  display: none;
}
#option-3:checked:checked ~ .option-3,
#option-4:checked:checked ~ .option-4{
  border-color: #0069d9;
  background: #0069d9;
}
#option-3:checked:checked ~ .option-3 .dot,
#option-4:checked:checked ~ .option-4 .dot{
  background: #fff;
}
#option-3:checked:checked ~ .option-3 .dot::before,
#option-4:checked:checked ~ .option-4 .dot::before{
  opacity: 1;
  transform: scale(1);
}
.wrapper2 .option span{
  font-size: 20px;
  color: #808080;
}
#option-3:checked:checked ~ .option-3 span,
#option-4:checked:checked ~ .option-4 span{
  color: #fff;
}


.wrapper3{
  display: inline-flex;
  background: #fff;
  height: 100px;
  width: 400px;
  align-items: center;
  justify-content: space-evenly;
  border-radius: 5px;
  padding: 20px 15px;
  margin-left: 25px;
  box-shadow: 5px 5px 30px rgba(0,0,0,0.2);
}
.wrapper3 .option{
  background: #fff;
  height: 100%;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-evenly;
  margin: 0 10px;
  border-radius: 5px;
  cursor: pointer;
  padding: 0 10px;
  border: 2px solid lightgrey;
  transition: all 0.3s ease;
}
.wrapper3 .option .dot{
  height: 20px;
  width: 20px;
  background: #d9d9d9;
  border-radius: 50%;
  position: relative;
}
.wrapper3 .option .dot::before{
  position: absolute;
  content: "";
  top: 4px;
  left: 4px;
  width: 12px;
  height: 12px;
  background: #0069d9;
  border-radius: 50%;
  opacity: 0;
  transform: scale(1.5);
  transition: all 0.3s ease;
}
.wrapper3 input[type="radio"]{
  display: none;
}
#option-5:checked:checked ~ .option-5,
#option-6:checked:checked ~ .option-6{
  border-color: #0069d9;
  background: #0069d9;
}
#option-5:checked:checked ~ .option-5 .dot,
#option-6:checked:checked ~ .option-6 .dot{
  background: #fff;
}
#option-5:checked:checked ~ .option-5 .dot::before,
#option-6:checked:checked ~ .option-6 .dot::before{
  opacity: 1;
  transform: scale(1);
}
.wrapper2 .option span{
  font-size: 20px;
  color: #808080;
}
#option-5:checked:checked ~ .option-5 span,
#option-6:checked:checked ~ .option-6 span{
  color: #fff;
}







.wrapper4{
  display: inline-flex;
  background: #fff;
  height: 100px;
  width: 400px;
  align-items: center;
  justify-content: space-evenly;
  border-radius: 5px;
  padding: 20px 15px;
  margin-left: 25px;
  box-shadow: 5px 5px 30px rgba(0,0,0,0.2);
}
.wrapper4 .option{
  background: #fff;
  height: 100%;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-evenly;
  margin: 0 10px;
  border-radius: 5px;
  cursor: pointer;
  padding: 0 10px;
  border: 2px solid lightgrey;
  transition: all 0.3s ease;
}
.wrapper4 .option .dot{
  height: 20px;
  width: 20px;
  background: #d9d9d9;
  border-radius: 50%;
  position: relative;
}
.wrapper4 .option .dot::before{
  position: absolute;
  content: "";
  top: 4px;
  left: 4px;
  width: 12px;
  height: 12px;
  background: #0069d9;
  border-radius: 50%;
  opacity: 0;
  transform: scale(1.5);
  transition: all 0.3s ease;
}
.wrapper4 input[type="radio"]{
  display: none;
}
#option-7:checked:checked ~ .option-7,
#option-8:checked:checked ~ .option-8{
  border-color: #0069d9;
  background: #0069d9;
}
#option-7:checked:checked ~ .option-7 .dot,
#option-8:checked:checked ~ .option-8 .dot{
  background: #fff;
}
#option-7:checked:checked ~ .option-7 .dot::before,
#option-8:checked:checked ~ .option-8 .dot::before{
  opacity: 1;
  transform: scale(1);
}
.wrapper4 .option span{
  font-size: 20px;
  color: #808080;
}
#option-7:checked:checked ~ .option-7 span,
#option-8:checked:checked ~ .option-8 span{
  color: #fff;
}









.wrapper_lang{
  display: inline-flex;
  background: #fff;
  height: 100px;
  width: 400px;
  align-items: center;
  justify-content: space-evenly;
  border-radius: 5px;
  padding: 20px 15px;
  margin-left: 25px;
  box-shadow: 5px 5px 30px rgba(0,0,0,0.2);
}
.wrapper_lang .option{
  background: #fff;
  height: 100%;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-evenly;
  margin: 0 10px;
  border-radius: 5px;
  cursor: pointer;
  padding: 0 10px;
  border: 2px solid lightgrey;
  transition: all 0.3s ease;
}
.wrapper_lang .option .dot{
  height: 20px;
  width: 20px;
  background: #d9d9d9;
  border-radius: 50%;
  position: relative;
}
.wrapper_lang .option .dot::before{
  position: absolute;
  content: "";
  top: 4px;
  left: 4px;
  width: 12px;
  height: 12px;
  background: #0069d9;
  border-radius: 50%;
  opacity: 0;
  transform: scale(1.5);
  transition: all 0.3s ease;
}
.wrapper_lang input[type="radio"]{
  display: none;
}
#option-lang1:checked:checked ~ .option-lang1,
#option-lang2:checked:checked ~ .option-lang2{
  border-color: #0069d9;
  background: #0069d9;
}
#option-lang1:checked:checked ~ .option-lang1 .dot,
#option-lang2:checked:checked ~ .option-lang2 .dot{
  background: #fff;
}
#option-lang1:checked:checked ~ .option-lang1 .dot::before,
#option-lang2:checked:checked ~ .option-lang2 .dot::before{
  opacity: 1;
  transform: scale(1);
}
.wrapper_lang .option span{
  font-size: 20px;
  color: #808080;
}
#option-lang1:checked:checked ~ .option-lang1 span,
#option-lang2:checked:checked ~ .option-lang2 span{
  color: #fff;
}










.wrapper_religion{
  display: inline-flex;
  background: #fff;
  height: 100px;
  width: 400px;
  align-items: center;
  justify-content: space-evenly;
  border-radius: 5px;
  padding: 20px 15px;
  margin-left: 25px;
  box-shadow: 5px 5px 30px rgba(0,0,0,0.2);
}
.wrapper_religion .option{
  background: #fff;
  height: 100%;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-evenly;
  margin: 0 10px;
  border-radius: 5px;
  cursor: pointer;
  padding: 0 10px;
  border: 2px solid lightgrey;
  transition: all 0.3s ease;
}
.wrapper_religion .option .dot{
  height: 20px;
  width: 20px;
  background: #d9d9d9;
  border-radius: 50%;
  position: relative;
}
.wrapper_religion .option .dot::before{
  position: absolute;
  content: "";
  top: 4px;
  left: 4px;
  width: 12px;
  height: 12px;
  background: #0069d9;
  border-radius: 50%;
  opacity: 0;
  transform: scale(1.5);
  transition: all 0.3s ease;
}
.wrapper_religion input[type="radio"]{
  display: none;
}
#option-religion1:checked:checked ~ .option-religion1,
#option-religion2:checked:checked ~ .option-religion2{
  border-color: #0069d9;
  background: #0069d9;
}
#option-religion1:checked:checked ~ .option-religion1 .dot,
#option-religion2:checked:checked ~ .option-religion2 .dot{
  background: #fff;
}
#option-religion1:checked:checked ~ .option-religion1 .dot::before,
#option-religion2:checked:checked ~ .option-religion2 .dot::before{
  opacity: 1;
  transform: scale(1);
}
.wrapper_religion .option span{
  font-size: 20px;
  color: #808080;
}
#option-religion1:checked:checked ~ .option-religion1 span,
#option-religion2:checked:checked ~ .option-religion2 span{
  color: #fff;
}
a.btn{
    color: white !important;
}



@media only screen and (max-width: 750px) {
    .wrapper{

        width: 220px !important;
    }

}

input[type=file]{
  max-width: 200px;
  display: inline-block;
}
input[type=file]{
  max-width: 200px;
  display: inline-block;
}
th{
    font-size: 20px;
    border-bottom: 1px solid #008991 !important;
    text-align: center !important;
    color: black;
}
td{
    font-size: 17px;
    border-bottom: 1px solid #008991 !important;
    color: black;
    text-align: center;
}
button.close{
    margin: 0px !important;
    padding: 0px !important;
    float: left !important;
}
.modal-header{
    direction: rtl;
}


    </style>
</head>


    <div class="card" style="direction:rtl;text-align:right;margin: 20px">
            <!-- Card header -->

            <div class="card-header border-0">
              <h1 class="mb-0" style="text-align: center">جدول الأقسام الأساسية</h1>
                @can('create_base_subject') 
                    <a href=".createLessonModal" class=" btn btn-success" id="primary" data-toggle="modal" style="background: #6ABAA3;border-color: #6ABAA3"
                    data-id=""><i class="material-icons" data-toggle="tooltip">إنشاء قسم جديد</i></a>
                @endcan 

                <label style="margin-left: 350px" for=""></label>
                {{-- <select style="display: inline; width: 40%; direction:rtl" class="dropdown-product selectpicker form-control aaa" id="myInputclass" title="Choose Your Class">
                                       <option value="">اختر الصف الدراسي...</option>

                    @foreach ($classes as $class)

                    <option value="{{$class->id}}">{{$class->name}}</option>

                    @endforeach
                  </select> --}}

               </div>

<div class="table-responsive">




              <table class="table align-items-center table-flush">
                <thead class="">
                  <tr>
                    <!--<th scope="col" class="sort" data-sort="name">Id</th>-->
                    <th scope="col" class="sort" data-sort="budget"> الاسم </th>



                    <th scope="col" class="sort" data-sort="completion">العمليات</th>

                  </tr>
                </thead>
                <tbody class="list" id="mydiv">
                @foreach ($base_subjects as $item)

               <tr  id="base_subject_{{$item->id}}">

                    <td class="budget">
                        {{$item->name}}
                    </td>







                    <td>
                        @can('update_base_subject') 
                            <a href=".editbase_subjectModal" class="edit btn btn-info"  data-name_en="{{ $item->name_en }}"
                            data-name="{{ $item->name }}"  data-id="{{ $item->id }}"  data-type="{{ $item->type }}" 
                            data-toggle="modal" >
                                {{-- <i class="fa fa-edit" style="font-size: 30px;color: #0083FF"></i> --}}
                                تعديل القسم
                            </a>
                        @endcan 
                        @can('delete_base_subject') 
                        <a   class="delete_modal btn btn-danger"
                        data-id="{{ $item->id }}" data-name="{{ $item->name }}"
                        data-toggle="modal" data-target="#delete_modal" title="الحذف">
                            {{-- <i style="font-size: 30px; color: #f0415e" class="fa fa-trash"></i> --}}
                            حذف القسم
                        </a>
                        @endcan 
                    </td>

                  </tr>


               @endforeach


                </tbody>
              </table>

            </div>










            <div class="clearfix" style="padding-left:10px;text-align: center;">
                    <div class="hint-text">Showing
                        <b>{{ !request('page')? "1" : request('page') }}</b>
                        out of <b>{{ ceil($count/paginate_num) }}</b> entries</div>
                    <div class="row">
                        <div class="col-md-12" style="display: flex;justify-content: center">
                            {{ $base_subjects->links() }}
                        </div>
                    </div>
                </div>





    </div>









                <div class="modal fade createLessonModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="" action="{{ route('admin.base_subject_store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="modal-header">
                                    <h4 class="modal-title">إنشاء قسم</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>

                                  <div class="type_div">

                                  </div>




                                <div class="modal-body">

                                    <div class="form-group" style="text-align:right">
                                        <label>اسم القسم </label>
                                        <input type="text" name="name" class="form-control a"
                                            value="" style="direction:rtl"
                                            placeholder="اكتب الاسم" maxlength="30" required>
                                    </div>
                                    
                                    <div class="form-group" style="text-align:right">
                                        <label>  نوع القسم من حيث العلامة في الجلاء</label>

                                        <select name="type" id="" class="form-control "
                                            style="min-height: 36px;direction: rtl" required>
                                            <option value="" hidden>حدد  نوع القسم</option>
                                            <option value="1">مادة عادية </option>
                                            <option value="2">مادة متفرعة مثال: */ الاجتماعيات /*  </option>


                                        </select>

                                    </div>

                                </div>
                                <div class="modal-footer" style="justify-content: right;">
                                    <a class="btn btn-dark" data-dismiss="modal">الغاء</a>
                                    <button class="btn btn-primary">حفظ</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>






                {{-- start edit modal --}}
                <div class="modal fade editbase_subjectModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="form_update" action="{{ route('admin.base_subject_update') }}" method="POST" enctype="multipart/form-data">

                                @csrf
                                <input type="hidden" name="base_subject_id" id="base_subject_id">

                                <div class="modal-header">
                                    <h4 class="modal-title">تعديل القسم</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group" style="text-align:right">
                                        <label> اسم القسم </label>
                                        <input type="text" style="direction:rtl" id="name" name="name" class="form-control a"
                                            value=""
                                            placeholder="ضع اسما هنا" maxlength="30" required>
                                    </div>
                                     <div class="form-group" style="text-align:right">
                                        <label>  نوع القسم</label>

                                        <select name="type" id="" class="form-control type"
                                            style="min-height: 36px;direction: rtl" required>
                                            <option value="" hidden>حدد  نوع القسم من حيث الجلاء</option>
                                            <option value="1">مادة عادية </option>
                                            <option value="2">مادة متفرعة مثال: */ الاجتماعيات /*  </option>


                                        </select>

                                    </div>

                                </div>
                                <div class="modal-footer" style="justify-content: right;">
                                    <a class="btn btn-dark" data-dismiss="modal">الغاء </a>
                                    <button class="btn btn-primary">حفظ</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- end edti modal --}}

                {{-- start delete modal --}}
                <div class="modal fade " id="delete_modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="form_update" action="{{ route('admin.base_subject_delete') }}" method="POST" enctype="multipart/form-data">

                                @csrf
                                <input type="hidden" name="base_subject_id" id="base_subject_id_delete" class="base_subject_id_delete">

                                <div class="modal-header">
                                    <h4 class="modal-title">حذف القسم</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">



                                    <div class="form-group" style="text-align:right">
                                        <label> اسم القسم </label>
                                        <input type="text" style="direction:rtl" id="name" name="name" class="form-control base_subject_name_delete"
                                            value="" readonly >
                                    </div>








                                </div>
                                <div class="modal-footer" style="justify-content: right;">
                                    <a class="btn btn-dark" data-dismiss="modal">الغاء </a>
                                    <button class="btn btn-primary">حفظ</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- end modal  --}}

                <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
                <script>
                var index_append = 0;
                $('.alert-success').hide(5000);

                $(document).on('change','.change_type',function(e){
                  if ($(this).val() == "book") {
                    $(this).closest('tr').find('.book_td').css('display',"table-cell");
                    $(this).closest('tr').find('.link_td').css('display',"none");
                  }else{
                    $(this).closest('tr').find('.link_td').css('display',"table-cell");
                    $(this).closest('tr').find('.book_td').css('display',"none");
                  }
                });


                $(document).on('click','.remove_new',function(e){
                  $(this).closest('tr').remove();
                });

                $(document).on('click','input',function(e){
                    $(this).css('background',"#fff");
                });


                $(document).on('click','#a_submit_book',function(){
                    var ok = 0;
                    $.each($('.change_type'), function (index, value) {
                        if ($(value).val() == "book" && $(value).siblings('.ididid').val() == "0" ) {
                            if ($(value).closest('tr').find('.book_td').children('input').val() == "") {
                                $(value).closest('tr').find('.book_td').children('input').css('background',"#ffb9b9");
                                ok = 1;
                            }
                        }else if($(value).val() == "book" && $(value).siblings('.ididid').data("type") == "link" ){
                            if ($(value).closest('tr').find('.book_td').children('input').val() == "") {
                                $(value).closest('tr').find('.book_td').children('input').css('background',"#ffb9b9");
                                ok = 1;
                            }
                        }
                    });
                    if (ok == 0) {
                        $('#submit_book').click();
                    }
                });









                $(document).on('click','#one',function(e){

                  var type=`
                  <div class="wrapper_lang">
                                <input type="radio"  class="select_lang" name="select_lang" id="option-lang1" value="0" required>
                                <input type="radio" class="select_lang" name="select_lang" id="option-lang2" value="1" required>

                                <label for="option-lang2" class="option option-lang2">
                                <div class="dot"></div>
                                <span>روسي </span>

                                </label>

                                <label for="option-lang1" class="option option-lang1">
                                <div class="dot"></div>
                                <span>  فرنسي</span>

                                </label>

                                </div>
`;

$('.type_div').empty();

$('.type_div').append(type);
                });




$(document).on('click','.delete_modal',function(e){
    let base_subject_name = $(this).data('name');
    let base_subject_id = $(this).data('id');
    $('.base_subject_name_delete').val(base_subject_name);
    $('.base_subject_id_delete').val(base_subject_id);
                });


    $(document).on('click','#primary',function(e){

        $('.type_div').empty();

    });



$(document).on('click' , '.one' , function () {

var id=$(this).data('id');
$('.delete_event').attr('href',`{{ route('event.delete') }}`);

$('.delete_event').data('id',id);

});

$(document).on('click','.delete_event',function(e){
    e.preventDefault();

    var id=$(this).data('id');

$.ajax({

    type:'post',
    url:"{{ route('admin.base_subject_delete') }}",
    enctype:'multipart/form-data',
    data:{
        '_token':"{{ csrf_token() }}",
        'id':id,

    },

    success:function(data){
$(`#base_subject_${id}`).remove();
        $(".modal").modal('hide');

swal({
  title: "حسناً",
  text: "! تمت العملية بنجاح",
  icon: "success",
  button: "OK",
  timer: 2000

});
    },
    error: function (xhr) {

}

});


});



    var loadFile = function(event) {
       var id=event.target.id;
        var input_image=document.getElementById(id);
            var output=input_image.nextElementSibling.nextElementSibling.nextElementSibling;
            var del_img=input_image.nextElementSibling.nextElementSibling;
            output.setAttribute('src',URL.createObjectURL(event.target.files[0]));
            output.onload = function() {

              output.setAttribute('style','display:inline');
              del_img.setAttribute('style','display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointer');
            };

    };

    var loadFile_book = function(event) {
       var id=event.target.id;
        var input_image=document.getElementById(id);
            var output=input_image.nextElementSibling.nextElementSibling.nextElementSibling;
            var del_img=input_image.nextElementSibling.nextElementSibling;
            output.setAttribute('src',`{{asset('students/images/book.jpg')}}`);
            output.onload = function() {

              output.setAttribute('style','display:inline');
              del_img.setAttribute('style','display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointer');
            };

    };

    var loadFile_edit = function(event) {
       var id=event.target.id;
        var input_image=document.getElementById(id);
            var output=input_image.nextElementSibling.nextElementSibling.nextElementSibling;
            var del_img=input_image.nextElementSibling.nextElementSibling;
            input_image.previousElementSibling.setAttribute('style','display:none');
            input_image.previousElementSibling.previousElementSibling.setAttribute('style','display:none');

            output.setAttribute('src',URL.createObjectURL(event.target.files[0]));
            output.onload = function() {

              output.setAttribute('style','display:inline');
              del_img.setAttribute('style','display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointer');
            };

    };

    var loadFile_book_edit = function(event) {
       var id=event.target.id;
        var input_image=document.getElementById(id);
            var output=input_image.nextElementSibling.nextElementSibling.nextElementSibling;
            var del_img=input_image.nextElementSibling.nextElementSibling;
            input_image.previousElementSibling.setAttribute('style','display:none');
            input_image.previousElementSibling.previousElementSibling.setAttribute('style','display:none');

            output.setAttribute('src',`{{asset('students/images/book.jpg')}}`);
            output.onload = function() {

              output.setAttribute('style','display:inline');
              del_img.setAttribute('style','display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointer');
            };

    };

        $(document).on('click' , '.del_icon' , function () {
            $(this).prevAll('.del:first').attr('disabled',false );
            $(this).prevAll('.del_edit_img:first').hide();
            $(this).hide();

        });


        $(document).on('click' , '.del_img' , function () {
            $(this).nextAll('.output').attr('style','display:none;');
            $(this).prevAll('.input_image:first').val('');
            $(this).hide();

        });

</script>

<script>
$(document).ready(function () {




$(document).on('click', '.edit', function () {
    var id = $(this).data('id');
    var name=$(this).data('name');
    var name_en=$(this).data('name_en');
    var is_english=$(this).data('is_english');


    var class1=$(this).data('class1');
    var type=$(this).data('type');
    $('#name').val(name);
    $('#name_en').val(name_en);
    $('#base_subject_id').val(id);


    $('#is_english').val(is_english);


    $('#class').val(class1).change();
    $('.type').val(type).change();


});



$('#myInputclass').change(function(){
var class_id=$(this).val();
var url = "{{ URL::to('SMARMANger/admin/base_subjects/class_base_subjects') }}/" + class_id;
      $.ajax({
                  url: url,
                  type: "get",
                  contentType: 'application/json',

                  success: function (data) {
                    $('#mydiv').empty();
                    var type = `



                    `;

                $.each(data, function (key, value) {

console.log(value);
                    type += `
                    <tr id="base_subject_${value.id}">


                    <td class="budget">

                        ${value.name}
                    </td>
                    <td class="budget">

                        ${value.name_en}
                        </td>`;



                  type+=`

                    <td class="budget">

                    ${value.classes.name}
                    </td>

                    <td class="budget">



                                 <a href=".editbase_subjectModal" class="edit" data-type="${value.type}" data-class1="${value.classes.id}"
                     data-name="${value.name}" data-image1="${value.image1}"
                    data-image2="${value.image2}"
                     data-image3="${value.image3}"
                    data-image4="${value.image4}"
                    data-book1="${value.book1}"
                    data-book2="${value.book2}"
                         data-book3="${value.book3}"
                    data-book4="${value.book4}"
                    data-type_file1="${value.type_file1}"
                    data-type_file2="${value.type_file2}"
                    data-type_file3="${value.type_file3}"
                    data-type_file4="${value.type_file4}"
                    data-name_en="${value.name_en}" data-id="${value.id}"  data-toggle="modal" >
                    <i class="ni ni-settings"></i>


                </a>



  <a  data-id="${value.id}" class="one"
                    href=".active_result" data-toggle="modal">
                         <i style="font-size: 30px; color: red" class="ni ni-fat-remove"></i>

            </td>

                  </tr>

                      `;

                });

            type+=`
                    </select>
                          `;
                $('#mydiv').append(type);

                  },
                  error: function (xhr) {

                   }

              });


      });



});
</script>

                @endsection
