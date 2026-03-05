@extends('admin.master')

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
              <h1 class="mb-0" style="text-align: center">جدول المواد</h1>

                    <a href=".createLessonModal" class=" btn btn-success" id="primary" data-toggle="modal" style="background: #6ABAA3;border-color: #6ABAA3"
                    data-id=""><i class="material-icons" data-toggle="tooltip">إنشاء مادة جديدة</i></a>


                    <a href=".createLessonModal" class=" btn btn-success" id="one" data-toggle="modal" style="background: #6ABAA3;border-color: #6ABAA3"
                    data-id=""><i class="material-icons" data-toggle="tooltip">إنشاء لغة فرنسية او روسية</i></a>

                    <a href=".createLessonModal" class=" btn btn-success" id="two" data-toggle="modal" style="background: #6ABAA3;border-color: #6ABAA3"
                    data-id=""><i class="material-icons" data-toggle="tooltip">إنشاء مادة الديانة</i></a>



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
                    <th scope="col" class="sort" data-sort="budget"> الاسم بالعربي</th>
                    <th scope="col" class="sort" data-sort="budget">الاسم بالإنكليزي</th>

                    <th scope="col" class="sort" data-sort="completion">الصف</th>

                    <th scope="col" class="sort" data-sort="completion">العمليات</th>

                  </tr>
                </thead>
                <tbody class="list" id="mydiv">
                @foreach ($lessons as $item)

               <tr  id="lesson_{{$item->id}}">

                    <td class="budget">
                        {{$item->name}}
                    </td>

                    <td class="budget">

                        {{$item->name_en}}
                    </td>



                    <td class="budget">

                    {{$item->classes->name}}

                    </td>

                    <td>
                        <a href=".editlessonModal" class="edit" data-is_english="{{ $item->is_english }}" data-type="{{ $item->type }}" data-name_en="{{ $item->name_en }}" data-name="{{ $item->name }}" data-class1="{{ $item->classes->id }}" data-id="{{ $item->id }}"  data-toggle="modal" >
                            <i class="fa fa-edit" style="font-size: 30px;color: #0083FF"></i>
                        </a>


                        <a data-id="{{ $item->id }}" data-books="{{ $item->books }}" class="bookmodal2"  data-toggle="modal" data-target=".bookmodal" title="الكتب">
                            <i style="font-size: 30px; color: #008CC4" class="fa fa-book"></i>
                        </a>
                    </td>

                  </tr>


               @endforeach


                </tbody>
              </table>

            </div>


<div class="col-md-4" class="delete_modal">
    {{-- <button type="button" class="btn btn-block btn-warning mb-3" data-toggle="modal" data-target="#modal-notification">Notification</button> --}}
    <div class="modal fade active_result" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
  <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
      <div class="modal-content bg-gradient-danger">
        <form id="form_delete" method="POST">
            @csrf
            @method('delete')
          <div class="modal-header">
              <h6 class="modal-title" id="modal-title-notification">Your attention is required</h6>
              <a type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true" class="close">×</span>
              </a>
          </div>

          <div class="modal-body">

              <div class="py-3 text-center">
                  <i class="ni ni-bell-55 ni-3x"></i>
                  <h4 class="heading mt-4">You should read this!</h4>
                  <p>Are you sure you want to delete the item ?</p>
              </div>

          </div>

          <div class="modal-footer" style="justify-content: right;">
              <a  class="btn btn-white delete_event" id="delete_event" data-id="" href="">Ok, Got it</a>
              <a class="btn btn-link text-white ml-auto" data-dismiss="modal">Close</a>
          </div>
        </form>
      </div>
  </div>
</div>

</div>










            <div class="clearfix" style="padding-left:10px;text-align: center;">
                    <div class="hint-text">Showing
                        <b>{{ !request('page')? "1" : request('page') }}</b>
                        out of <b>{{ ceil($count/paginate_num) }}</b> entries</div>
                    <div class="row">
                        <div class="col-md-12" style="display: flex;justify-content: center">
                            {{ $lessons->links() }}
                        </div>
                    </div>
                </div>





    </div>









                <div class="modal fade createLessonModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="" action="{{ route('lesson_store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="modal-header">
                                    <h4 class="modal-title">إنشاء مادة</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>

                                  <div class="type_div">

                                  </div>




                                <div class="modal-body">

                                    <div class="form-group" style="text-align:right;direction:rtl">
                                        <label> مادة انكليزي : </label>
                                        <select name="is_english" class="form-control w-25" style="display: inline-block;height: 30px;font-size: 23px;width: 67px !important;">
                                            <option value="0">لا</option>
                                            <option value="1">نعم</option>
                                        </select>
                                    </div>


                                    <div class="form-group" style="text-align:right">
                                        <label>الاسم بالعربية</label>
                                        <input type="text" name="name" class="form-control a"
                                            value="" style="direction:rtl"
                                            placeholder="اكتب الاسم" maxlength="30" required>
                                    </div>


                                    <div class="form-group" style="text-align:right">
                                        <label> الاسم بالانكليزية</label>
                                        <input type="text" name="name_en" class="form-control a"
                                            value=""
                                            placeholder="اكتب الاسم" maxlength="30" required>
                                    </div>




                                    <div class="form-group" style="text-align:right">
                                        <label>الصف</label>

                                        <select name="class_id" id="classes" class="form-control dep"
                                            style="min-height: 36px;direction: rtl" required>
                                            <option value="">اختر الصف الدراسي</option>

                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer" style="justify-content: right;">
                                    <a class="btn btn-default" data-dismiss="modal">الغاء</a>
                                    <button class="btn btn-primary">حفظ</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>



                <div class="modal fade bookmodal">
                    <div class="modal-dialog modal-lg" style="min-width: 80%">
                        <div class="modal-content" style="direction: rtl">
                            <form id="form_update" action="{{ route('book_update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="text" hidden name="lesson_id" id="lesson_id2">
                                <div style="justify-content: center" class="modal-header">
                                    <h3 >الكتب</h3>
                                </div>
                              <div class="modal-body">
                                  <table class="table">
                                      <thead>
                                          <th>النوع</th>
                                          <th>اسم الكتاب بالعربية</th>
                                          <th>اسم الكتاب بالانكليزية</th>
                                          <th>الكتاب</th>
                                          <th>صورة الكتاب</th>
                                          <th>حذف</th>
                                      </thead>
                                      <tbody id="book_body">

                                      </tbody>
                                  </table>
                                  <div style="text-align: right">
                                    <a class="btn btn-success" id="add_book">اضافة كتاب <i class="fa fa-plus" style="color: white"></i></a>
                                  </div>
                              </div>

                                <div class="modal-footer" style="justify-content: right;">
                                    <a class="btn btn-default" data-dismiss="modal">الغاء </a>
                                    <button type="submit" id="submit_book" class="btn btn-primary" hidden>حفظ</button>
                                    <a  id="a_submit_book" class="btn btn-primary" >حفظ</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>



                <div class="modal fade editlessonModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="form_update" action="{{ route('lesson_update') }}" method="POST" enctype="multipart/form-data">

                                @csrf
                                <input type="hidden" name="lesson_id" id="lesson_id">

                                <div class="modal-header">
                                    <h4 class="modal-title">تعديل المادة</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">

                                    <div class="form-group" style="text-align:right;direction:rtl">
                                        <label> مادة انكليزي : </label>
                                        <select name="is_english" class="form-control w-25" id="is_english" style="display: inline-block;height: 30px;font-size: 23px;width: 67px !important;">
                                            <option value="0">لا</option>
                                            <option value="1">نعم</option>
                                        </select>
                                    </div>

                                    <div class="form-group" style="text-align:right">
                                        <label> الاسم بالعربية</label>
                                        <input type="text" style="direction:rtl" id="name" name="name" class="form-control a"
                                            value=""
                                            placeholder="ضع اسما هنا" maxlength="30" required>
                                    </div>


                                    <div class="form-group" style="text-align:right">
                                        <label>الاسم بالانكليزية</label>
                                        <input type="text" id="name_en" name="name_en" class="form-control a"
                                            value=""
                                            placeholder="ضع اسما هنا" maxlength="30" required>
                                    </div>





                                    <div class="form-group" style="text-align:right">
                                        <label>الصف</label>

                                        <select name="class_id" id="class" class="form-control dep"
                                            style="min-height: 36px;direction: rtl" required>
                                            <option value="">اختر الصف الدراسي</option>

                                        @foreach ($classes as $class)

                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                        @endforeach

                                        </select>

                                    </div>

                                </div>
                                <div class="modal-footer" style="justify-content: right;">
                                    <a class="btn btn-default" data-dismiss="modal">الغاء </a>
                                    <button class="btn btn-primary">حفظ</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

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


                $(document).on('click','.bookmodal2',function(e){
                    index_append = 0;
                    var le_id = $(this).data('id');
                    var books = $(this).data('books');
                    $('#lesson_id2').val(le_id);
                    $('#book_body').empty();
                    $.each(books, function (index, value) {
                        console.log(value);
                        $('#book_body').append(`
                                <tr>
                                    <td>
                                        <input name="book[${index_append}][id]" class="ididid" data-type="${value.type}" value="${value.id}" hidden >
                                        <select name="book[${index_append}][typebook]" class="form-control change_type">
                                            <option ${value.type == "book" ? "selected" : ""} value="book">تحميل كتاب</option>
                                            <option ${value.type == "link" ? "selected" : ""} value="link">رابط خارجي</option>
                                        </select>
                                    </td>
                                    <td><input type="text" name="book[${index_append}][name_ar]" value="${value.name_ar}" class="form-control"></td>
                                    <td><input type="text" name="book[${index_append}][name_en]" value="${value.name_en}" class="form-control"></td>
                                    <td class="book_td" style="max-width: 200px"><input type="file" name="book[${index_append}][file_book]" class="form-control"></td>
                                    <td class="link_td" style="display: none"><input type="text" name="book[${index_append}][link_book]" value="${value.value}" class="form-control"></td>
                                    <td style="max-width: 200px"><input type="file" name="book[${index_append++}][img_book]" class="form-control"></td>
                                    <td>
                                        <div class="dropdown">
                                        <a class="btn btn-danger dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">حذف</a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <a class="dropdown-item" href="">لا</a>
                                            <a class="dropdown-item" href="{{ url("SMT/admin/delete_books") }}/${le_id}/${value.id}">نعم</a>
                                        </div>
                                        </div>
                                    </td>
                                </tr>
                        `);
                    });
                });


                $(document).on('click','#add_book',function(e){
                  $('#book_body').append(`
                        <tr>
                            <td>
                                <input name="book[${index_append}][id]" class="ididid" value="0" hidden >
                                <select name="book[${index_append}][typebook]" class="form-control change_type">
                                    <option value="book">تحميل كتاب</option>
                                    <option value="link">رابط خارجي</option>
                                </select>
                            </td>
                            <td><input type="text" name="book[${index_append}][name_ar]" class="form-control"></td>
                            <td><input type="text" name="book[${index_append}][name_en]" class="form-control"></td>
                            <td class="book_td" style="max-width: 200px"><input type="file" name="book[${index_append}][file_book]" class="form-control"></td>
                            <td class="link_td" style="display: none"><input type="text" name="book[${index_append}][link_book]" class="form-control"></td>
                            <td style="max-width: 200px"><input type="file" name="book[${index_append++}][img_book]" class="form-control"></td>
                            <td>
                                <i class="fa fa-remove fa-2x remove_new" style="color:red"><i>
                            </td>
                        </tr>
                  `);

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




                $(document).on('click','#two',function(e){

var type=`
<div class="wrapper_religion">
            <input type="radio"  class="select_religion" name="select_religion" id="option-religion1" value="0" required>
            <input type="radio" class="select_religion" name="select_religion" id="option-religion2" value="1" required>

            <label for="option-religion2" class="option option-religion2">
            <div class="dot"></div>
            <span>  ديانة مسيحية</span>

            </label>

            <label for="option-religion1" class="option option-religion1">
            <div class="dot"></div>
            <span>ديانة اسلامية </span>

            </label>

            </div>
`;

$('.type_div').empty();

$('.type_div').append(type);
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
    url:"{{ route('lesson.delete') }}",
    enctype:'multipart/form-data',
    data:{
        '_token':"{{ csrf_token() }}",
        'id':id,

    },

    success:function(data){
$(`#lesson_${id}`).remove();
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
    $('#lesson_id').val(id);


    $('#is_english').val(is_english);


    $('#class').val(class1).change();
    $('#type').val(type).change();


});



$('#myInputclass').change(function(){
var class_id=$(this).val();
var url = "{{ URL::to('SMARMANger/admin/lessons/class_lessons') }}/" + class_id;
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
                    <tr id="lesson_${value.id}">


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



                                 <a href=".editlessonModal" class="edit" data-type="${value.type}" data-class1="${value.classes.id}"
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
