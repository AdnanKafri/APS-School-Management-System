@extends('admin.layouts.app')

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



@media only screen and (max-width: 750px) {
    .wrapper{

        width: 220px !important;
    }

}

    </style>
</head>


<div class="col" style="direction:rtl;text-align:right">
    <div class="card">
            <!-- Card header -->
            
<!--            @if(session()->has('success'))-->


<!--  <div class="alert alert-success alert-dismissible" id="success" role="alert" style="text-align: right; font-size: 30px">-->
<!--    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
<!--     {{ session()->get('success') }}-->
<!--    </div>-->
<!--@endif-->

<!--<div class="alert alert-success alert-dismissible" id="success2" role="alert" style="text-align: right;  display: none; font-size: 30px">-->
<!--    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
<!--     {{ session()->get('success') }}-->
<!--    </div>-->

            <div class="card-header border-0">
              <h3 class="mb-0">جدول المواد</h3>

                    <a href=".createLessonModal" class=" btn btn-success" id="primary" data-toggle="modal"
                    data-id=""><i class="material-icons" data-toggle="tooltip">إنشاء مادة جديدة</i></a>

                    
                    <a href=".createLessonModal" class=" btn btn-success" id="one" data-toggle="modal"
                    data-id=""><i class="material-icons" data-toggle="tooltip">إنشاء لغة فرنسية او روسية</i></a>

                    <a href=".createLessonModal" class=" btn btn-success" id="two" data-toggle="modal"
                    data-id=""><i class="material-icons" data-toggle="tooltip">إنشاء مادة الديانة</i></a>



                <label style="margin-left: 350px" for=""></label>
                <select style="display: inline; width: 40%; direction:rtl" class="dropdown-product selectpicker form-control aaa" id="myInputclass" title="Choose Your Class">
                                       <option value="">اختر الصف الدراسي...</option>

                    @foreach ($classes as $class)

                    <option value="{{$class->id}}">{{$class->name}}</option>

                    @endforeach
                  </select>

               </div>

<div class="table-responsive">




              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <!--<th scope="col" class="sort" data-sort="name">Id</th>-->
                    <th scope="col" class="sort" data-sort="budget"> الاسم بالعربي</th>
                    <th scope="col" class="sort" data-sort="budget">الاسم بالإنكليزي</th>

                    <th scope="col" class="sort" data-sort="completion">الصورة 1</th>
                    <th scope="col" class="sort" data-sort="completion">الصورة 2</th>
                    <th scope="col" class="sort" data-sort="completion">الصف</th>

                    <th scope="col" class="sort" data-sort="completion">العمليات</th>

                  </tr>
                </thead>
                <tbody class="list" id="mydiv">
                @foreach ($lessons as $item)

               <tr  id="lesson_{{$item->id}}">
                    <!--<th scope="row">-->
                    <!--{{$item->id}}-->
                    <!--</th>-->

                    <td class="budget">

                    {{$item->name}}
                    </td>

                    <td class="budget">

                        {{$item->name_en}}
                        </td>

                    <td class="budget">

                        @if ($item->image1 !=null)
                        <img src="{{ asset('storage/'.$item->image1) }}" width="50px" height="50px" alt="">

                        @endif
                    </td>
                    <td>
                        @if ($item->image2 !=null)
                        <img src="{{ asset('storage/'.$item->image2) }}" width="50px" height="50px" alt="">

                        @endif
                        </td>

                    <td class="budget">

                    {{$item->classes->name}}

                    </td>


                    <!--<td>-->
                    <!--  <div class="avatar-group">-->
                    <!--    <a href="#" class="avatar avatar-sm rounded-circle" data-toggle="tooltip" data-original-title="Ryan Tompson">-->
                    <!--      <img alt="Image placeholder" src="{{asset('assets/img/theme/team-1.jpg')}}">-->
                    <!--    </a>-->

                    <!--  </div>-->
                    <!--</td>-->

                    <td>
                 <a href=".editlessonModal" class="edit" data-type="{{ $item->type }}" data-class1="{{ $item->classes->id }}"
                     data-name="{{ $item->name }}"      data-image1="{{ $item->image1 }}"
                    data-image2="{{ $item->image2 }}"
                    data-image3="{{ $item->image3 }}"
                    data-image4="{{ $item->image4 }}"
                    data-book1="{{ $item->book1}}" 
                    data-book2="{{ $item->book2 }}" 
                    data-book3="{{ $item->book3}}" 
                    data-book4="{{ $item->book4 }}" 
                
                data-name_book1_ar="{{ $item->name_book1_ar}}" 
                data-name_book1_en="{{ $item->name_book1_en}}" 
                data-name_book2_ar="{{ $item->name_book2_ar}}" 
                data-name_book2_en="{{ $item->name_book2_en}}" 
                data-name_book3_ar="{{ $item->name_book3_ar}}" 
                data-name_book3_en="{{ $item->name_book3_en}}" 
                data-name_book4_ar="{{ $item->name_book4_ar}}" 
                data-name_book4_en="{{ $item->name_book4_en}}" 
                

                    
                    data-type_file1="{{$item->type_file1}}"
                    data-type_file2="{{$item->type_file2}}"
                    data-type_file3="{{$item->type_file3}}"
                    data-type_file4="{{$item->type_file4}}"

                    data-name_en="{{ $item->name_en }}" data-id="{{ $item->id }}"  data-toggle="modal" >
                    <i class="ni ni-settings"></i>


                </a>
<!--<form action="{{route('admin.lesson.delete')}}" method="post">-->
<!--    @csrf-->
    
<!--    <input type="hidden" name="id" value="{{$item->id}}">-->
<!--    <button>del</button>-->
<!--</form>-->

                    <!--<a class="delete_lesson1" data-id="{{ $item->id }}" href="{{route('admin.lesson.delete')}}"> <i style="font-size: 30px; color: red" class="ni ni-fat-remove"></i></a>-->
  <a  data-id="{{ $item->id }}" class="one"
                    href=".active_result" data-toggle="modal">
                         <i style="font-size: 30px; color: red" class="ni ni-fat-remove"></i>
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

          <div class="modal-footer">
              <a  class="btn btn-white delete_event" id="delete_event" data-id="" href="">Ok, Got it</a>
              <a class="btn btn-link text-white ml-auto" data-dismiss="modal">Close</a>
          </div>
        </form>
      </div>
  </div>
</div>

</div>



   






            <div class="clearfix" style="padding-left:10px">
                    <div class="hint-text">Showing
                        <b>{{ !request('page')? "1" : request('page') }}</b>
                        out of <b>{{ ceil($count/paginate_num) }}</b> entries</div>
                    <div class="row">
                        <div class="col-md-10">
                            {{ $lessons->links() }}
                        </div>
                    </div>
                </div>





    </div>
</div>














                <div class="modal fade createLessonModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="" action="{{ route('admin.lesson_store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="modal-header">
                                    <h4 class="modal-title">إنشاء مادة</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>


                                  <div class="type_div">


                                  </div>



                                <div class="modal-body">
                                    <div class="form-group" style="text-align:right">
                                        <label>الاسم بالعربية</label>
                                        <input type="text" name="name" class="form-control a"
                                            value="" style="direction:rtl"
                                            placeholder="اكتب الاسم" maxlength="30" required>
                                    </div>


                                    <div class="form-group" style="text-align:right">
                                        <label> Name En</label>
                                        <input type="text" name="name_en" class="form-control a"
                                            value=""
                                            placeholder="اكتب الاسم" maxlength="30" required>
                                    </div>


                                    <!--<div class="form-group">-->
                                    <!--    <label>Type</label>-->

                                    <!--    <select name="type" id="type" style="direction: rtl" required  class="form-control">-->
                                    <!--        <option value="yearly">yearly</option>-->
                                    <!--        <option value="termly">termly</option>-->

                                    <!--    </select>-->

                                    <!--</div>-->


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
                                
                                
                                <div class="wrapper">
                                <input type="radio"  class="select1" name="select" id="option-1" value="0" checked>
                                <input type="radio" class="select1" name="select" id="option-2" value="1">
                                <label for="option-1" class="option option-1">
                                <div class="dot"></div>
                                <span>رابط خارجي</span>
                                
                                </label>
                                <label for="option-2" class="option option-2">
                                <div class="dot"></div>
                                <span>تحميل كتاب</span>
                                
                                </label>
                                </div>
                                
                                         <div class="form-group" style="text-align:right">
                                        <label>اسم الكتاب1 بالعربي</label>
                                        <input type="text" name="name_book1_ar" class="form-control a"
                                            value="" style="direction:rtl"
                                            placeholder="Type name" maxlength="30" >
                                    </div>


                                    <div class="form-group" style="text-align:right">
                                        <label>اسم الكتاب1 بالانكليزية</label>
                                        <input type="text" name="name_book1_en" class="form-control a"
                                            value=""
                                            placeholder="Type name En" maxlength="30" >
                                    </div>
                                <div id="mydivbook1">
                                <br>

                                <div class="form-group" style="text-align:right">
                                <label> رابط الكتاب الأول</label>
                                <input type="text" name="book1_link" class="form-control a"
                                value=""
                                placeholder="اكتب رابط الكتاب">
                                </div>
<input type="hidden" name="type_file1" value="0">


                                <div class="form-group" style="text-align:right">
                                <label>image1</label>
                                
                                <input type="file" name="image1" onchange="loadFile(event)" id="input_image1"  class="input_image form-control" >
                                <label class="custom-file-label" for="customFileLang">Select file</label>
                                
                                <span class="close-btn del_img" title="الغاء" id="del_img" style="display: none; font-weight:bold">&times;</span>
                                <img id="output" style=" display: none"src="" class="output"  width="200px" alt="">
                                
                                </div>


                                </div>
                                
                                
                                
                                
                                <!--<div class="form-group">-->
                                <!--<label>Book1</label>-->
                                
                                <!--<input type="file" name="book1" onchange="loadFile_book(event)" id="input_book1"  class="input_image form-control" required>-->
                                <!--<label class="custom-file-label" for="customFileLang">Select file</label>-->
                                
                                <!--<span class="close-btn del_img" title="الغاء" id="del_img" style="display: none; font-weight:bold">&times;</span>-->
                                <!--<img id="output" style=" display: none"src="" class="output"  width="200px" alt="">-->
                                
                                <!--</div>-->
                                
                                
                            
                                
                                <!--<div class="form-group">-->
                                <!--<label>image1</label>-->
                                
                                <!--<input type="file" name="image1" onchange="loadFile(event)" id="input_image1"  class="input_image form-control" required>-->
                                <!--<label class="custom-file-label" for="customFileLang">Select file</label>-->
                                
                                <!--<span class="close-btn del_img" title="الغاء" id="del_img" style="display: none; font-weight:bold">&times;</span>-->
                                <!--<img id="output" style=" display: none"src="" class="output"  width="200px" alt="">-->
                                
                                <!--</div>-->
                                
                                
                                
                                
                                <div class="wrapper2">
                                <input type="radio"  class="select2" name="select2" id="option-3" value="0" checked>
                                <input type="radio" class="select2" name="select2" id="option-4" value="1">
                                <label for="option-3" class="option option-3">
                                <div class="dot"></div>
                                <span>رابط خارجي</span>
                                
                                </label>
                                <label for="option-4" class="option option-4">
                                <div class="dot"></div>
                                <span>تحميل كتاب</span>
                                
                                </label>
                                </div>
                                
                            
                            <div class="form-group" style="text-align:right">
                            <label>اسم الكتاب 2 بالعربية</label>
                            <input type="text" name="name_book2_ar" class="form-control a"
                            value="" style="direction:rtl"
                            placeholder="Type name" maxlength="30" >
                            </div>
                            
                            
                            <div class="form-group" style="text-align:right">
                            <label>اسم الكتاب 2 بالانكليزية</label>
                            <input type="text" name="name_book2_en" class="form-control a"
                            value=""
                            placeholder="Type name En" maxlength="30">
                            </div>

                                    
                            <div id="mydivbook2">
                            <br>
                            <div class="form-group" style="text-align:right">
                            <label> رابط الكتاب الثاني</label>
                            <input type="text" name="book2_link" class="form-control a"
                            value=""
                            placeholder="اكتب رابط الكتاب الثاني">
                            </div>
                            
                            <input type="hidden" name="type_file2" value="0">

                            <div class="form-group" style="text-align:right">
                            <label>صورة الكتاب الثاني</label>
                            
                            <input type="file" name="image2" onchange="loadFile(event)" id="input_image2"  class="input_image form-control">
                            <label class="custom-file-label" for="customFileLang">Select file</label>
                            
                            <span class="close-btn del_img" title="الغاء" id="del_img" style="display: none; font-weight:bold">&times;</span>
                            <img id="output" style=" display: none"src="" class="output"  width="200px" alt="">
                            </div>
                            
                            
                            </div>
                                
                                
                                
                                
                                
                                      
                                <div class="wrapper3">
                                <input type="radio"  class="select3" name="select3" id="option-5" value="0" checked>
                                <input type="radio" class="select3" name="select3" id="option-6" value="1">
                                <label for="option-5" class="option option-5">
                                <div class="dot"></div>
                                <span>رابط خارجي</span>
                                
                                </label>
                                <label for="option-6" class="option option-6">
                                <div class="dot"></div>
                                <span>تحميل كتاب</span>
                                
                                </label>
                                </div>
                                
                                
                            
                            <div class="form-group" style="text-align:right">
                            <label>اسم الكتاب الثالث بالعربية</label>
                            <input type="text" name="name_book3_ar" class="form-control a"
                            value="" style="direction:rtl"
                            placeholder="اكتب اسم الكتاب " maxlength="30" >
                            </div>
                            
                            
                            <div class="form-group" style="text-align:right">
                            <label>اسم الكتاب الثالث بالانكليزية</label>
                            <input type="text" name="name_book3_en" class="form-control a"
                            value=""
                            placeholder="اكتب اسم الكتاب" maxlength="30" >
                            </div>
                                    
                                    
                            <div id="mydivbook3">
                            <br>
                            <div class="form-group" style="text-align:right">
                            <label> رابط الكتاب الثالث</label>
                            <input type="text" name="book3_link" class="form-control a"
                            value=""
                            placeholder="ضع رابط الكتاب هنا">
                            </div>
                            
                                                                    <input type="hidden" name="type_file3" value="0">

                            <div class="form-group" style="text-align:right">
                            <label>صورة الكتاب الثالث</label>
                            
                            <input type="file" name="image3" onchange="loadFile(event)" id="input_image3"  class="input_image form-control">
                            <label class="custom-file-label" for="customFileLang">Select file</label>
                            
                            <span class="close-btn del_img" title="الغاء" id="del_img" style="display: none; font-weight:bold">&times;</span>
                            <img id="output" style=" display: none"src="" class="output"  width="200px" alt="">
                            </div>
                            
                            
                            </div>
                            
                            
                            
                            
                                                
                                <div class="wrapper4">
                                <input type="radio"  class="select4" name="select4" id="option-7" value="0" checked>
                                <input type="radio" class="select4" name="select4" id="option-8" value="1">
                                <label for="option-7" class="option option-7">
                                <div class="dot"></div>
                                <span>رابط خارجي</span>
                                
                                </label>
                                <label for="option-8" class="option option-8">
                                <div class="dot"></div>
                                <span>تحميل كتاب</span>
                                
                                </label>
                                </div>
                                
                                
                                
                                <div class="form-group" style="text-align:right">
                                <label>اسم الكتاب الرابع بالعربية</label>
                                <input type="text" name="name_book4_ar" class="form-control a"
                                value="" style="direction:rtl"
                                placeholder="ضع اسم الكتاب هنا" maxlength="30" >
                                </div>
                                
                                
                                <div class="form-group" style="text-align:right">
                                <label>اسم الكتاب الرابع بالانكليزية</label>
                                <input type="text" name="name_book4_en" class="form-control a"
                                value=""
                                placeholder="ضع اسم الكتاب هنا" maxlength="30" >
                                </div>
                                    
                            <div id="mydivbook4">
                            <br>
                            <div class="form-group" style="text-align:right">
                            <label>رابط الكتاب الرابع</label>
                            <input type="text" name="book4_link" class="form-control a"
                            value=""
                            placeholder="ضع رابط الكتاب الرابع هنا">
                            </div>
                            
                        <input type="hidden" name="type_file4" value="0">

                            <div class="form-group"  style="text-align:right">
                            <label>صورة الكتاب الرابع</label>
                            
                            <input type="file" name="image4" onchange="loadFile(event)" id="input_image4"  class="input_image form-control">
                            <label class="custom-file-label" for="customFileLang">Select file</label>
                            
                            <span class="close-btn del_img" title="الغاء" id="del_img" style="display: none; font-weight:bold">&times;</span>
                            <img id="output" style=" display: none"src="" class="output"  width="200px" alt="">
                            </div>
                            
                            
                            </div>
                                <!--<div class="form-group">-->
                                <!--<label> Book2</label>-->
                                
                                <!--<input type="file" name="book2" onchange="loadFile_book(event)" id="input_book2"  class="input_image form-control" required>-->
                                <!--<label class="custom-file-label" for="customFileLang">Select file</label>-->
                                
                                <!--<span class="close-btn del_img" title="الغاء" id="del_img" style="display: none; font-weight:bold">&times;</span>-->
                                <!--<img id="output" style=" display: none"src="" class="output"  width="200px" alt="">-->
                                
                                <!--</div>-->
                                
                                
                                
                                
                                <!--<div class="form-group">-->
                                <!--<label>image2</label>-->
                                
                                <!--<input type="file" name="image2" onchange="loadFile(event)" id="input_image2"  class="input_image form-control">-->
                                <!--<label class="custom-file-label" for="customFileLang">Select file</label>-->
                                
                                <!--<span class="close-btn del_img" title="الغاء" id="del_img" style="display: none; font-weight:bold">&times;</span>-->
                                <!--<img id="output" style=" display: none"src="" class="output"  width="200px" alt="">-->
                                <!--</div>-->
                                
                                
                                
                                
                                </div>
                                <div class="modal-footer">
                                    <a class="btn btn-default" data-dismiss="modal">الغاء</a>
                                    <button class="btn btn-info">حفظ</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>







                <div class="modal fade editlessonModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="form_update" action="{{ route('admin.lesson_update') }}" method="POST" enctype="multipart/form-data">

                                @csrf
                                <input type="hidden" name="lesson_id" id="lesson_id">

                                <div class="modal-header">
                                    <h4 class="modal-title">تعديل المادة</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
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


                                    <!--<div class="form-group">-->
                                    <!--    <label>Type</label>-->

                                    <!--    <select name="type" style="direction: rtl" required  class="form-control">-->
                                    <!--        <option value="yearly">yearly</option>-->
                                    <!--        <option value="termly">termly</option>-->

                                    <!--    </select>-->

                                    <!--</div>-->


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

                                   <div class="form-group" style="text-align:right">
                                        <label>اسم الكتاب بالعربية</label>
                                        <input type="text" id="name_book1_ar" name="name_book1_ar" class="form-control a"
                                            value="" style="direction:rtl"
                                            placeholder="ضع اسم الكتاب هنا" maxlength="30">
                                    </div>


                                    <div class="form-group" style="text-align:right">
                                        <label>اسم الكتاب بالانكليزية</label>
                                        <input type="text" id="name_book1_en" name="name_book1_en" class="form-control a"
                                            value=""
                                            placeholder="ضع اسم الكتاب هنا" maxlength="30" >
                                    </div>
                                    
                                <div class="form-group" style="text-align:right">
                                <label> رابط الكتاب</label>
                                <input type="text" name="book1_link" id="book1_link" class="form-control a"
                                value=""
                                placeholder="ضع رابط الكتاب هنا">
                                </div>



                                    <div class="form-group" style="text-align:right">
                                        <label> الكتاب الاول</label>
<input type="hidden" class="del" name="del_book1" value="del_book1" disabled="disabled">

<img src="" width="50px" height="50px" class="del_edit_img" id="book1" alt="Not found" >
<span class="close-btn del_icon" title="الغاء" id="del_icon1" style ="display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointerld">&times;</span>


<input type="file" name="book1" onchange="loadFile_book_edit(event)"  class="form-control input_image" id="input_edit_book1" lang="en">
<label class="custom-file-label" for="customFileLang">Select file</label>


<span class="close-btn del_img" title="الغاء" id="" style="display: none; font-weight:bold">&times;</span>
<img id="output" class="output" style=" display: none"src=""  width="200px" alt="">
                                    </div>

                                    <div class="form-group" style="text-align:right">
                        <label> صورة الكتاب الاول</label>
                        <br>
<input type="hidden" class="del" name="del_img1" value="del_img1" disabled="disabled">

<img src="" width="50px" height="50px" class="del_edit_img" id="image1" alt="Not found" >
<span class="close-btn del_icon" id="del_img1" title="الغاء " style ="display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointerld">&times;</span>


<input type="file" name="image1" onchange="loadFile_edit(event)"  class="form-control input_image" id="input_edit_image1" lang="en">
<label class="custom-file-label" for="customFileLang">Select file</label>


<span class="close-btn del_img"  title="الغاء" style="display: none; font-weight:bold">&times;</span>
<img id="output" class="output" style=" display: none"src=""  width="200px" alt="">

                                    </div>


                                <div class="form-group" style="text-align:right">
                                <label>اسم الكتاب الثاني بالعربية</label>
                                <input type="text" id="name_book2_ar" name="name_book2_ar" class="form-control a"
                                value="" style="direction:rtl"
                                placeholder="ضع اسم الكتاب الثاني هنا" maxlength="30" >
                                </div>
                                
                                
                                <div class="form-group" style="text-align:right">
                                <label>اسم الكتاب الثاني بالانكليزية</label>
                                <input type="text" id="name_book2_en" name="name_book2_en" class="form-control a"
                                value=""
                                placeholder="ضع اسم الكتاب الثاني هنا " maxlength="30" >
                                </div>



                                <div class="form-group" style="text-align:right">
                                    
                                <label> رابط الكتاب الثاني</label>
                                <input type="text" name="book2_link" id="book2_link" class="form-control a"
                                value=""
                                placeholder="ضع رابط الكتاب الثاني هنا">
                                </div>
                                

                                    <div class="form-group" style="text-align:right">
                                        <label> الكتاب الثاني</label>
<input type="hidden" class="del" name="del_book2" value="del_book2" disabled="disabled">

<img src="" width="50px" height="50px" class="del_edit_img" id="book2" alt="Not found" >
<span class="close-btn del_icon" title="الغاء" id="del_icon2" style ="display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointerld">&times;</span>


<input type="file" name="book2" onchange="loadFile_book_edit(event)"  class="form-control input_image" id="input_edit_book2" lang="en">
<label class="custom-file-label" for="customFileLang">Select file</label>


<span class="close-btn del_img" title="الغاء" id="" style="display: none; font-weight:bold">&times;</span>
<img id="output" class="output" style=" display: none"src=""  width="200px" alt="">
                                    </div>

                                    <div class="form-group" style="text-align:right">
                       <label>صورة الكتاب الثاني</label>
                        <br>
                <input type="hidden" name="del_img2" class="del" value="del_img2" disabled="disabled">

       <img src="" width="50px" height="50px" class="del_edit_img" id="image2" alt="Not found" >
                        <span class="close-btn del_icon" id="del_img2" title="الغاء"  style ="display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointerld">&times;</span>


                        <input type="file" name="image2" onchange="loadFile_edit(event)"  class="form-control input_image" id="input_edit_image2" lang="en">
                        <label class="custom-file-label" for="customFileLang">Select file</label>


                            <span class="close-btn del_img" title="الغاء " style="display: none; font-weight:bold">&times;</span>
                            <img id="output" class="output" style=" display: none"src=""  width="200px" alt="">

                                    </div>



                                <div class="form-group" style="text-align:right">
                                <label>اسم الكتاب الثالث بالعربية</label>
                                <input type="text" id="name_book3_ar" name="name_book3_ar" class="form-control a"
                                value="" style="direction:rtl"
                                placeholder="ضع اسما هنا" maxlength="30" >
                                </div>
                                
                                
                                <div class="form-group" style="text-align:right">
                                <label>اسم الكتاب الثالث بالانكليزية</label>
                                <input type="text" id="name_book3_en" name="name_book3_en" class="form-control a"
                                value=""
                                placeholder="ضع اسما هنا" maxlength="30" >
                                </div>


                                <div class="form-group" style="text-align:right">
                                <label> رابط الكتاب الثالث</label>
                                <input type="text" name="book3_link" id="book3_link" class="form-control a"
                                value=""
                                placeholder="ضع رابط الكتاب الثالث هنا">
                                </div>
                                

                                    <div class="form-group" style="text-align:right">
                                        <label> الكتاب الثالث</label>
<input type="hidden" class="del" name="del_book3" value="del_book3" disabled="disabled">

<img src="" width="50px" height="50px" class="del_edit_img" id="book3" alt="Not found" >
<span class="close-btn del_icon" title="الغاء" id="del_icon3" style ="display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointerld">&times;</span>


<input type="file" name="book3" onchange="loadFile_book_edit(event)"  class="form-control input_image" id="input_edit_book3" lang="en">
<label class="custom-file-label" for="customFileLang">Select file</label>


<span class="close-btn del_img" title="الغاء" id="" style="display: none; font-weight:bold">&times;</span>
<img id="output" class="output" style=" display: none"src=""  width="200px" alt="">
                                    </div>

                                    <div class="form-group" style="text-align:right">
                       <label>صورة الكتاب الثالث</label>
                        <br>
                <input type="hidden" name="del_img3" class="del" value="del_img3" disabled="disabled">

       <img src="" width="50px" height="50px" class="del_edit_img" id="image3" alt="Not found" >
                        <span class="close-btn del_icon" id="del_img3" title="الغاء"  style ="display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointerld">&times;</span>


                        <input type="file" name="image3" onchange="loadFile_edit(event)"  class="form-control input_image" id="input_edit_image3" lang="en">
                        <label class="custom-file-label" for="customFileLang">Select file</label>


                            <span class="close-btn del_img" title="الغاء " style="display: none; font-weight:bold">&times;</span>
                            <img id="output" class="output" style=" display: none"src=""  width="200px" alt="">

                                    </div>
                                    
                                    
                                <div class="form-group" style="text-align:right">
                                <label>اسم الكتاب الرابع بالعربية</label>
                                <input type="text" style="direction:rtl" id="name_book4_ar" name="name_book4_ar" class="form-control a"
                                value=""
                                placeholder="ضع اسما هنا" maxlength="30" >
                                </div>
                                
                                
                                <div class="form-group" style="text-align:right">
                                <label>اسم الكتاب الرابع بالانكليزية</label>
                                <input type="text" id="name_book4_en" name="name_book4_en" class="form-control a"
                                value=""
                                placeholder="ضع اسما هنا" maxlength="30" >
                                </div>

                                    
                                    
                                <div class="form-group" style="text-align:right">
                                <label>رابط الكتاب الرابع</label>
                                <input type="text" name="book4_link" id="book4_link" class="form-control a"
                                value=""
                                placeholder="ضع رابط الكتاب الرابع هنا ">
                                </div>
                                

                                    <div class="form-group" style="text-align:right">
                                        <label> الكتاب الرابع</label>
<input type="hidden" class="del" name="del_book4" value="del_book4" disabled="disabled">

<img src="" width="50px" height="50px" class="del_edit_img" id="book4" alt="Not found" >
<span class="close-btn del_icon" title="الغاء" id="del_icon4" style ="display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointerld">&times;</span>


<input type="file" name="book4" onchange="loadFile_book_edit(event)"  class="form-control input_image" id="input_edit_book4" lang="en">
<label class="custom-file-label" for="customFileLang">Select file</label>


<span class="close-btn del_img" title="الغاء" id="" style="display: none; font-weight:bold">&times;</span>
<img id="output" class="output" style=" display: none"src=""  width="200px" alt="">
                                    </div>

                                    <div class="form-group" style="text-align:right">
                       <label>صورة الكتاب الرابع</label>
                        <br>
                <input type="hidden" name="del_img4" class="del" value="del_img4" disabled="disabled">

       <img src="" width="50px" height="50px" class="del_edit_img" id="image4" alt="Not found" >
                        <span class="close-btn del_icon" id="del_img4" title="الغاء"  style ="display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointerld">&times;</span>


                        <input type="file" name="image4" onchange="loadFile_edit(event)"  class="form-control input_image" id="input_edit_image4" lang="en">
                        <label class="custom-file-label" for="customFileLang">Select file</label>


                            <span class="close-btn del_img" title="الغاء " style="display: none; font-weight:bold">&times;</span>
                            <img id="output" class="output" style=" display: none"src=""  width="200px" alt="">

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <a class="btn btn-default" data-dismiss="modal">الغاء </a>
                                    <button class="btn btn-info">حفظ</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>

                <script>
                $('.alert-success').hide(5000);

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

       $(document).on('click','.select1',function(e){
$('#mydivbook1').empty();
var val1=$(this).val();

var type="";
if (val1=='1') {

type+=`
<br>

<div class="form-group" style="text-align:right">
<label>الكتاب الاول</label>

<input type="file" name="book1" onchange="loadFile_book(event)" id="input_book1"  class="input_image form-control">
<label class="custom-file-label" for="customFileLang">Select file</label>

<span class="close-btn del_img" title="الغاء" id="del_img" style="display: none; font-weight:bold">&times;</span>
<img id="output" style=" display: none"src="" class="output"  width="200px" alt="">

</div>



<input type="hidden" name="type_file1" value="1">


<div class="form-group" style="text-align:right">
<label>صورة الكتاب الاول</label>

<input type="file" name="image1" onchange="loadFile(event)" id="input_image1"  class="input_image form-control" >
<label class="custom-file-label" for="customFileLang">Select file</label>

<span class="close-btn del_img" title="الغاء" id="del_img" style="display: none; font-weight:bold">&times;</span>
<img id="output" style=" display: none"src="" class="output"  width="200px" alt="">

</div>
`;


}
else {

type=`
<br>
<div class="form-group">
<label> رابط الكتاب الاول</label>
<input type="text" name="book1_link" class="form-control a"
value=""
placeholder="ضع رابط الكتاب الاول هنا">
</div>


<input type="hidden" name="type_file1" value="0">


<div class="form-group" style="text-align:right">
<label>صورة الكتاب الاول</label>

<input type="file" name="image1" onchange="loadFile(event)" id="input_image1"  class="input_image form-control" >
<label class="custom-file-label" for="customFileLang">Select file</label>

<span class="close-btn del_img" title="الغاء" id="del_img" style="display: none; font-weight:bold">&times;</span>
<img id="output" style=" display: none"src="" class="output"  width="200px" alt="">

</div>
`;




}
$('#mydivbook1').append(type);


        });



        $(document).on('click','.select2',function(e){

$('#mydivbook2').empty();
var val1=$(this).val();

var type="";
if (val1=='1') {

type+=`
<br>
                   <div class="form-group">
                                <label> الكتاب الثاني</label>
                                
                                <input type="file" name="book2" onchange="loadFile_book(event)" id="input_book2"  class="input_image form-control" >
                                <label class="custom-file-label" for="customFileLang">Select file</label>
                                
                                <span class="close-btn del_img" title="الغاء" id="del_img" style="display: none; font-weight:bold">&times;</span>
                                <img id="output" style=" display: none"src="" class="output"  width="200px" alt="">
                                
                                </div>
                                
                                
                                <input type="hidden" name="type_file2" value="1">

                                
                                <div class="form-group">
                                <label>صورة الكتاب الثاني</label>
                                
                                <input type="file" name="image2" onchange="loadFile(event)" id="input_image2"  class="input_image form-control">
                                <label class="custom-file-label" for="customFileLang">Select file</label>
                                
                                <span class="close-btn del_img" title="الغاء" id="del_img" style="display: none; font-weight:bold">&times;</span>
                                <img id="output" style=" display: none"src="" class="output"  width="200px" alt="">
                                </div>
                                
                                
`;


}
else {

type=`
<br>
<div class="form-group">
<label>رابط الكتاب الثاني</label>
<input type="text" name="book2_link" class="form-control a"
value=""
placeholder="ضع رابط الكتاب الثاني هنا">
</div>

<input type="hidden" name="type_file2" value="0">

                   <div class="form-group" style="text-align:right">
                                <label>صورة الكتاب الثاني </label>
                                
                                <input type="file" name="image2" onchange="loadFile(event)" id="input_image2"  class="input_image form-control">
                                <label class="custom-file-label" for="customFileLang">Select file</label>
                                
                                <span class="close-btn del_img" title="الغاء" id="del_img" style="display: none; font-weight:bold">&times;</span>
                                <img id="output" style=" display: none"src="" class="output"  width="200px" alt="">
                                </div>
`;




}
$('#mydivbook2').append(type);


        });





        $(document).on('click','.select3',function(e){

$('#mydivbook3').empty();
var val1=$(this).val();

var type="";
if (val1=='1') {

type+=`
<br>
                   <div class="form-group">
                                <label> الكتاب الثالث</label>
                                
                                <input type="file" name="book3" onchange="loadFile_book(event)" id="input_book3"  class="input_image form-control">
                                <label class="custom-file-label" for="customFileLang">Select file</label>
                                
                                <span class="close-btn del_img" title="الغاء" id="del_img" style="display: none; font-weight:bold">&times;</span>
                                <img id="output" style=" display: none"src="" class="output"  width="200px" alt="">
                                
                                </div>
                                
                                
                                <input type="hidden" name="type_file3" value="1">

                                
                                <div class="form-group">
                                <label>صورة الكتاب الثالث</label>
                                
                                <input type="file" name="image3" onchange="loadFile(event)" id="input_image3"  class="input_image form-control">
                                <label class="custom-file-label" for="customFileLang">Select file</label>
                                
                                <span class="close-btn del_img" title="الغاء" id="del_img" style="display: none; font-weight:bold">&times;</span>
                                <img id="output" style=" display: none"src="" class="output"  width="200px" alt="">
                                </div>
                                
                                
`;


}
else {

type=`
<br>
<div class="form-group">
<label> رابط الكتاب الثالث</label>
<input type="text" name="book3_link" class="form-control a"
value=""
placeholder="ضع رابط الكتاب الثالث هنا">
</div>

<input type="hidden" name="type_file3" value="0">

                   <div class="form-group">
                                <label>صورة الكتاب الثالث</label>
                                
                                <input type="file" name="image3" onchange="loadFile(event)" id="input_image3"  class="input_image form-control">
                                <label class="custom-file-label" for="customFileLang">Select file</label>
                                
                                <span class="close-btn del_img" title="الغاء" id="del_img" style="display: none; font-weight:bold">&times;</span>
                                <img id="output" style=" display: none"src="" class="output"  width="200px" alt="">
                                </div>
`;




}
$('#mydivbook3').append(type);


        });








        $(document).on('click','.select4',function(e){

$('#mydivbook4').empty();
var val1=$(this).val();

var type="";
if (val1=='1') {

type+=`
<br>
                   <div class="form-group" style="text-align:right">
                                <label> الكتاب الرابع</label>
                                
                                <input type="file" name="book4" onchange="loadFile_book(event)" id="input_book4"  class="input_image form-control">
                                <label class="custom-file-label" for="customFileLang">Select file</label>
                                
                                <span class="close-btn del_img" title="الغاء" id="del_img" style="display: none; font-weight:bold">&times;</span>
                                <img id="output" style=" display: none"src="" class="output"  width="200px" alt="">
                                
                                </div>
                                
                                
                                <input type="hidden" name="type_file4" value="1">

                                
                                <div class="form-group">
                                <label>الصورة الرابعة</label>
                                
                                <input type="file" name="image4" onchange="loadFile(event)" id="input_image4"  class="input_image form-control">
                                <label class="custom-file-label" for="customFileLang">Select file</label>
                                
                                <span class="close-btn del_img" title="الغاء" id="del_img" style="display: none; font-weight:bold">&times;</span>
                                <img id="output" style=" display: none"src="" class="output"  width="200px" alt="">
                                </div>
                                
                                
`;


}
else {

type=`
<br>
<div class="form-group">
<label> رابط الكتاب الرابع</label>
<input type="text" name="book4_link" class="form-control a"
value=""
placeholder="ضع رابط الكتاب الرابع هنا ">
</div>

<input type="hidden" name="type_file4" value="0">

                   <div class="form-group">
                                <label>image4</label>
                                
                                <input type="file" name="image4" onchange="loadFile(event)" id="input_image4"  class="input_image form-control">
                                <label class="custom-file-label" for="customFileLang">Select file</label>
                                
                                <span class="close-btn del_img" title="الغاء" id="del_img" style="display: none; font-weight:bold">&times;</span>
                                <img id="output" style=" display: none"src="" class="output"  width="200px" alt="">
                                </div>
`;




}
$('#mydivbook4').append(type);


        });




$(document).on('click' , '.one' , function () {

var id=$(this).data('id');
$('.delete_event').attr('href',`{{ route('admin.event.delete') }}`);

$('.delete_event').data('id',id);

});

$(document).on('click','.delete_event',function(e){
    e.preventDefault();

    var id=$(this).data('id');

$.ajax({

    type:'post',
    url:"{{ route('admin.lesson.delete') }}",
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

// $(document).on('click','.delete_lesson1',function(e){
//     e.preventDefault();

//     var id=$(this).data('id');

// $.ajax({

//     type:'post',
//     url:"{{ route('admin.lesson.delete') }}",
//     enctype:'multipart/form-data',
//     data:{
//         '_token':"{{ csrf_token() }}",
//         'id':id,

//     },

//     success:function(data){
// $(`#lesson_${id}`).remove();
// $('#success2').show();
// document.getElementById('success2').innerText="Deleted Successfully !";
// $('#success2').hide(5000);

//     },
//     error: function (xhr) {

// }

// });


// });


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
var image1=$(this).data('image1');
var image2=$(this).data('image2');
var image3=$(this).data('image3');
var image4=$(this).data('image4');
var book1=$(this).data('book1');
var book2=$(this).data('book2');
var book3=$(this).data('book3');
var book4=$(this).data('book4');

var name_book1_ar=$(this).data('name_book1_ar');
var name_book2_ar=$(this).data('name_book2_ar');
var name_book3_ar=$(this).data('name_book3_ar');
var name_book4_ar=$(this).data('name_book4_ar');


var name_book1_en=$(this).data('name_book1_en');
var name_book2_en=$(this).data('name_book2_en');
var name_book3_en=$(this).data('name_book3_en');
var name_book4_en=$(this).data('name_book4_en');

var type_file1=$(this).data('type_file1');
var type_file2=$(this).data('type_file2');
var type_file3=$(this).data('type_file3');
var type_file4=$(this).data('type_file4');

    var class1=$(this).data('class1');
    var type=$(this).data('type');
    $('#name').val(name);
    $('#name_en').val(name_en);
    $('#lesson_id').val(id);





    $('#name_book1_ar').val(name_book1_ar);
    $('#name_book2_ar').val(name_book2_ar);
    $('#name_book3_ar').val(name_book3_ar);
    $('#name_book4_ar').val(name_book4_ar);
    $('#name_book1_en').val(name_book1_en);
    $('#name_book2_en').val(name_book2_en);
    $('#name_book3_en').val(name_book3_en);
    $('#name_book4_en').val(name_book4_en);




    $('#class').val(class1).change();
    $('#type').val(type).change();
if (image1!="" && image1!=null) {
          $('#image1').show();
         $('#del_img1').show();

    $('#image1').attr('src',`{{ asset('storage/${image1}') }}`);
}else{
    
         $('#image1').hide();
         $('#del_img1').hide();

}

if (image2!="" && image2!=null) {
         $('#image2').show();
         $('#del_img2').show();

    $('#image2').attr('src',`{{ asset('storage/${image2}') }}`);

}else{

     $('#image2').hide();
              $('#del_img2').hide();

}


if (image3!="" && image3!=null) {
         $('#image3').show();
         $('#del_img3').show();

    $('#image3').attr('src',`{{ asset('storage/${image3}') }}`);

}else{

     $('#image3').hide();
              $('#del_img3').hide();

}



if (image4!="" && image4!=null) {
         $('#image4').show();
         $('#del_img4').show();
         

    $('#image4').attr('src',`{{ asset('storage/${image4}') }}`);

}else{

     $('#image4').hide();
              $('#del_img4').hide();

}


if (book1!="") {
    
    if(type_file1!='1'){
        $('#del_icon1').hide();
                $('#book1').hide();

           $('#book1_link').val(book1);

    
}else{
                    $('#del_icon1').show();
                    $('#book1').show();

       $('#book1').attr('src',`{{asset('students/images/book.jpg')}}`);
 
}

    
}else{
    
            $('#del_icon1').hide();
                $('#book1').hide();

}


if (book2!="") {
    
        if(type_file2!='1'){
            $('#del_icon2').hide();
            $('#book2').hide();

           $('#book2_link').val(book2);

    
}else{
                $('#del_icon2').show();
            $('#book2').show();

    $('#book2').attr('src',`{{asset('students/images/book.jpg')}}`);

}
}
else{
           $('#del_icon2').hide();
            $('#book2').hide();

}




if (book3!="") {
    
        if(type_file3!='1'){
            $('#del_icon3').hide();
            $('#book3').hide();

           $('#book3_link').val(book3);

    
}else{
                $('#del_icon3').show();
            $('#book3').show();

    $('#book3').attr('src',`{{asset('students/images/book.jpg')}}`);

}
}
else{
           $('#del_icon3').hide();
            $('#book3').hide();

}





if (book4!="") {
    
        if(type_file4!='1'){
            $('#del_icon4').hide();
            $('#book4').hide();

           $('#book4_link').val(book4);

    
}else{
                $('#del_icon4').show();
            $('#book4').show();

    $('#book4').attr('src',`{{asset('students/images/book.jpg')}}`);

}
}
else{
           $('#del_icon4').hide();
            $('#book4').hide();

}




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
                        </td>

                    <td class="budget">`;
                    if (value.image1 != null) {
                        type+=`
                    <img src="{{ asset('storage/${value.image1}') }}" width="50px" height="50px" alt="">

                    `;
                    }





                    type+=`
                    </td>
                      <td class="budget">`;
                        if (value.image2 != null) {
                        type+=`
                    <img src="{{ asset('storage/${value.image2}') }}" width="50px" height="50px" alt="">

                    `;
                    }


                  type+=`  </td>

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
