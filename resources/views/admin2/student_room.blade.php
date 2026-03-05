@extends('admin.master')


<head>
    <style>
@import url('https://fonts.googleapis.com/css?family=Lato:400,500,600,700&display=swap');

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


@media only screen and (max-width: 750px) {
    .wrapper{

        width: 220px !important;
    }
}
th{
    font-size: 20px;
    border-bottom: 1px solid #008991 !important;
    text-align: center !important;
    color: black
    }
    td{
        font-size: 17px;
        border-bottom: 1px solid #008991 !important;
        color: black;
        text-align: center !important;
    }
    button.close{
    margin: 0px !important;
    padding: 0px !important;
    float: left !important;
}
.modal-header{
    direction: rtl;
}
.pagination{
    justify-content: center;
}
.dropdown{
    display: inline-block;
}


    </style>
</head>






@section('name')
{{ auth()->user()->name }}
@endsection
@section('image')

@endsection
@section('search')
<form class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main">
    <div class="form-group mb-0">
      <div class="input-group input-group-alternative input-group-merge">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-search"></i></span>
        </div>
        <input class="form-control" name="search_student" id="search_student" placeholder="Search" type="text">
      </div>
    </div>
    <button type="button" class="close" data-action="search-close" data-target="#navbar-search-main" aria-label="Close">
      <span aria-hidden="true">×</span>
    </button>
  </form>
@endsection
@section('content')

<div class="alert alert-success alert-dismissible" role="alert" id="success2" style="text-align: right; display: none; font-size: 30px">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  Updated Successfully !
    </div>

<div class="col" style="direction:rtl;text-align:right">
    <div class="card" style="margin: 30px">
  <!-- Card header -->
  <div class="card-header border-0">
    <h2 class="mb-0" style="color: #001586;text-align: center">جدول طلاب الشعبة</h2>
    {{-- <input type="text" name="search_student" placeholder="&#xF002; Search" class="form-control"
    style="color: #000;display: inline; font-family:Arial, FontAwesome;" id="search_student1"> --}}
  </div>
<div class="table-responsive">

    @if (count($students)!=0)

    {{-- @if ($students[0]->status!='1')

    <a href=".active_result" data-toggle="modal"
    class=" btn btn-success"
    data-id=""><i class="material-icons" data-toggle="tooltip">اصدار النتائج</i></a>

    @else

    <a href=".disable_result" class=" btn btn-danger"  data-toggle="modal"
    data-id=""><i class="material-icons" data-toggle="tooltip">اخفاء النتائج</i></a>

    @endif --}}
@endif
{{-- ---------------------------------------------- --}}




        <table class="table align-items-center table-flush" style="direction:rtl;text-align:right">
                <thead class="">
                  <tr>
                    <!--<th scope="col" class="sort" data-sort="name">Id</th>-->
                    <th scope="col" class="sort" data-sort="budget">الاسم الاول</th>
                    <th scope="col" class="sort" data-sort="status">الكنية</th>
                    <!--<th scope="col" class="sort" data-sort="status">Age</th>-->
                    <th scope="col" class="sort" data-sort="completion">العنوان</th>
                    <th scope="col" class="sort" data-sort="completion">الهاتف</th>
                    <th scope="col" class="sort" data-sort="completion">الصورة</th>
                    <th scope="col" class="sort" data-sort="completion">الصف</th>
                    <th scope="col" class="sort" data-sort="completion">الشعبة</th>
                    <th scope="col" class="sort" data-sort="completion">العمليات</th>

                  </tr>
                </thead>
                <tbody class="list" id="mydiv">

                    @if ($count!=0)
                    @foreach ($students as $item)

                    <tr>
                         <!--<th scope="row">-->
                         <!--{{$item->id}}-->

                         <!--</th>-->
                         <td class="budget">
                         {{$item->first_name}}

                       </td>

                       <td class="budget">
                         {{$item->last_name}}


                       </td>


                       <!--<td class="budget">-->
                       <!--  {{$item->age}}-->

                       <!--</td>-->

                       <td class="budget">
                         {{$item->address}}

                       </td>

                       <td class="budget">
                         {{$item->phone}}

                       </td>



                <td>
                    @if($item->image != null)
                <div class="avatar-group">
                    <a href="#" class="avatar avatar-sm rounded-circle" data-toggle="tooltip" data-original-title="Ryan Tompson">
                    <img alt="Image placeholder" src="{{asset('storage/'.$item->image)}}">
                    </a>

                </div>
                @endif
                </td>

                <td class="budget">
            @if(isset($item->room[0]))

            {{$item->room[0]->classes->name}}
            <input type="hidden" id="old_class_id" value="{{$item->room[0]->classes->id}}">
            @endif

            </td>
            <td class="budget">
            @if(isset($item->room[0]))
            {{$item->room[0]->name}}
            @endif

            </td>

                <td class="text-right">



{{-- <a href=".changeStudentModal"  class="change_student btn btn-success" data-toggle="modal" data-id="{{ $item->id }}"
data-name="{{ $item->first_name }} {{ $item->last_name }} "><i class="material-icons" data-toggle="tooltip">Change Student</i></a> --}}

<div class="dropdown">
    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="fas fa-ellipsis-v"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow ">
    <!--<a href=".deleteEmployeeModal" class=" dropdown-item" data-toggle="modal"-->
    <!--            data-id="{{$item->id}}"><i class="material-iconsni ni ni-fat-remove" data-toggle="tooltip"-->
    <!--title="Delete">&#xE872; حذف</i></a>-->


    <a href=".changeStudentModal"  class="dropdown-item change_student " data-toggle="modal" data-id="{{ $item->id }}"
    data-name="{{ $item->first_name }} {{ $item->last_name }} " style="
direction: ltr;"><i class="ni ni-folder-17"></i>تعديل صف او شعبة الطالب</a>


    @if (isset($item->room[0]->classes->id))
    <a href=".financialaccountModal"  class="dropdown-item financial_account" data-toggle="modal" data-id="{{ $item->id }}"
        data-name="{{ $item->first_name }} {{ $item->last_name }} " data-class="{{$item->room[0]->classes->id}}" style="
direction: ltr;"><i class="ni ni-folder-17"></i>الحساب المالي</a>



    @endif



    <a href=".sendMessageModal"  class="dropdown-item send_message" data-toggle="modal" data-id="{{ $item->id }}" style="
direction: ltr;"
  ><i class="ni ni-folder-17" ></i>ارسال رسالة</a>



  <a href=".changeLangModal"  class="dropdown-item change_lang" data-toggle="modal" data-id="{{ $item->id }}" data-lang="{{ $item->lang }}" style="
direction: ltr;"
  ><i class="ni ni-folder-17" ></i> تغيير لغة الطالب</a>


</div>
</div>



                @if ($item->super == '1')


                <a data-id="{{ $item->id }}" href="" class="student_less" >
                <i class="fa fa-graduation-cap fa-2x super_{{ $item->id }}" id="super_{{ $item->id }}" style="color: green"></i>

                </a>

                @else


                <a data-id="{{ $item->id }}" class="student_super" >
                <i class="fa fa-graduation-cap fa-2x super_{{ $item->id }}" style="color: #0083FF" id="super_{{ $item->id }}"></i>
                </a>



                @endif


                <a href="{{ route('student_details',$item->id) }}" target="_blank">
                <i class="fa fa-eye fa-2x" style="color: #0083FF"></i>
                </a>



                <a href="{{ route('student_archive',$item->id) }}" target="_blank">

                <i class="ni ni-archive-2 fa-2x" style="color: #0083FF"></i>
                </a>



                </td>


            </tr>


        @endforeach


                </tbody>
              </table>

            <!-- Card footer -->
            <!-- <div class="card-footer py-4">
              <nav aria-label="...">
                <ul class="pagination justify-content-end mb-0">
                  <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">
                      <i class="fas fa-angle-left"></i>
                      <span class="sr-only">Previous</span>
                    </a>
                  </li>
                  <li class="page-item active">
                    <a class="page-link" href="#">1</a>
                  </li>
                  <li class="page-item">
                    <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                  </li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item">
                    <a class="page-link" href="#">
                      <i class="fas fa-angle-right"></i>
                      <span class="sr-only">Next</span>
                    </a>
                  </li>
                </ul>
              </nav>
            </div> -->


            </div>



            <div class="clearfix" style="padding-left:10px">
                    <div class="hint-text" style="text-align: center">Showing
                        <b>{{ !request('page')? "1" : request('page') }}</b>
                        out of <b>{{ ceil($count/paginate_num) }}</b> entries</div>
                    <div class="row">
                        <div class="col-md-12" style="text-align: center">
                            {{ $students->links() }}
                        </div>
                    </div>
                </div>








                <div class="col-md-4">
                    {{-- <button type="button" class="btn btn-block btn-warning mb-3" data-toggle="modal" data-target="#modal-notification">Notification</button> --}}
                    <div class="modal fade deleteEmployeeModal" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
                  <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                      <div class="modal-content bg-gradient-danger">
                        <form id="form_delete" method="POST">
                            @csrf
                            @method('delete')
                          <div class="modal-header">
                              <h6 class="modal-title" id="modal-title-notification">Your attention is required</h6>
                              <a type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">×</span>
                              </a>
                          </div>

                          <div class="modal-body">

                              <div class="py-3 text-center">
                                  <i class="ni ni-bell-55 ni-3x"></i>
                                  <h4 class="heading mt-4">You should read this!</h4>
                                  <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Minus, dolor.</p>
                              </div>

                          </div>

                          <div class="modal-footer">
                              <button data-id="{{ $item->id }}" class="btn btn-white delete">Ok, Got it</button>
                              <a class="btn btn-link text-white ml-auto" data-dismiss="modal">Close</a>
                          </div>
                        </form>
                      </div>
                  </div>
              </div>

                </div>








                @endif








                <div class="modal fade createStudentModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="{{ route('student_store') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="modal-header">
                                    <h4 class="modal-title">Create Student</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input type="text" name="first_name" class="form-control a"
                                            value="" maxlength="20"
                                            placeholder="Type first name" required>
                                    </div>

                                    <div class="form-group">
                                        <label>last Name</label>
                                        <input type="text" name="last_name" class="form-control b"
                                            value="" maxlength="20"
                                            placeholder="Type last name" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Father Name</label>
                                        <input type="text" name="father_name" class="form-control b"
                                            value="" maxlength="20"
                                            placeholder="Type Father Name" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Mother Name</label>
                                        <input type="text" name="mother_name" class="form-control b"
                                            value="" maxlength="20"
                                            placeholder="Type Mother Name" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Place Of Birth</label>
                                        <input type="text" name="place_birth" class="form-control b"
                                            value="" maxlength="100"
                                            placeholder="Type last name" required>
                                    </div>



                                    <div class="form-group">
                                        <label>Date Of Birth</label>
                                        <input type="date" name="date_birth" class="form-control b"
                                            value=""
                                            placeholder="Type last name" required>
                                    </div>


                                    <div class="form-group">
                                        <label>Box Birth</label>
                                        <input type="text" name="box_birth" class="form-control b"
                                            value="" maxlength="50"
                                            placeholder="Type Box Birth" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Nationality</label>
                                        <input type="text" name="nationality" class="form-control b"
                                            value="" maxlength="30"
                                            placeholder="مثال: عربي سوري" required>
                                    </div>


                                    <div class="form-group">
                                        <label>Army Room</label>
                                        <input type="text" name="army_room" class="form-control b"
                                            value="" maxlength="30"
                                            placeholder="Type Army Room" required>
                                    </div>



                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control b"
                                            value=""
                                            placeholder="Type email" required>
                                    </div>


                                    {{-- <div class="input-group-prepend">
                                        <label>password</label>
                                        <br>
                                        <small id="alert" style="color: #f00;"> </small>

                                        <input type="password"  id=" show_hide_password" type="text" size="15"
                                        maxlength="100" onkeyup="return passwordChanged();"
                                         title="Password must contain uppercase and lowercase letters, numbers and symbols"
                                            placeholder="Type password" minlength="8" class="form-control" required>
                                            <div class="input-group-addon">
                                                <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                              </div>

                                            <span id="strength"> </span>

                                        </div> --}}
                                        <label for="">Password</label>
<br>
                                        <small id="alert" style="color: #f00;"> </small>


                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                    </div>
                    <input name="password" type="password" value="" size="15" onkeyup="return passwordChanged();"
                    class="input form-control" id="password" placeholder="password"
                    required="true" aria-label="password" aria-describedby="basic-addon1" />
                    <div class="input-group-append">
                    <span class="input-group-text" onclick="password_show_hide();">
                        <i class="fas fa-eye" id="show_eye"></i>
                        <i class="fas fa-eye-slash d-none" id="hide_eye"></i>
                    </span>
                    </div>
                </div>
                <div id="strength" style="margin-top: -18px"> </div>




                <label for="">Confirm Password</label>
                <br>


                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                    </div>
                    <input name="password_confirmation" type="password" value="" size="15" onkeyup="return passwordChanged();"
                    class="input form-control" id="password-confirm" placeholder="password"
                    required="true" aria-label="password" aria-describedby="basic-addon1" />
                    <div class="input-group-append">
                    <span class="input-group-text" onclick="password_show_hide2();">
                        <i class="fas fa-eye" id="show_eye2"></i>
                        <i class="fas fa-eye-slash d-none" id="hide_eye2"></i>
                    </span>
                    </div>
                </div>







                                    <div class="form-group">
                                        <label>Age</label>
                                        <input type="number" name="age" class="form-control b"
                                            value=""
                                            placeholder="Type age" required>
                                    </div>


                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" name="address" class="form-control b"
                                            value="" maxlength="100"
                                            placeholder="Type address" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="text" name="phone" class="form-control b"
                                            value="" maxlength="20"
                                            placeholder="Type phone" required>
                                    </div>


                                    <div class="form-group" style="text-align: center">
                                        <label>من داخل سوريا</label>
                                        <input type="radio" name="place" class="form-control place"
                                            value="inside"
                                            placeholder="Type phone" required>

                                            <label>من خارج سوريا</label>

                                            <input type="radio" name="place" class="form-control place"
                                            value="outside"
                                            placeholder="Type phone" required>
                                    </div>


                                    <hr>


                                    <div class="form-group" style="text-align: center">
                                        <label>صف أول ابتدائي</label>
                                        <input type="radio" name="status" class="form-control status"
                                            value="new"
                                            placeholder="Type phone" required>

                                            <label>غير ذلك (طالب منقول من مدرسة أخرى)</label>

                                            <input type="radio" name="status" class="form-control status"
                                            value="transported"
                                            placeholder="Type phone" required>
                                    </div>



                                    <div id="mydiv1">

                                    </div>





                                    <div class="form-group">
                                        <label>الصورة الشخصية </label>

                                        <div class="custom-file">
                                            <input type="file" name="image" class="custom-file-input" id="customFileLang" lang="en" required>
                                            <label class="custom-file-label" for="customFileLang" >Select file</label>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label>From Class</label>

                                        <select name="class_id" id="classes" class="form-control dep"
                                            style="min-height: 36px;direction: rtl" required>
                                            <option value="">اختر الصف الدراسي</option>

                                        @foreach ($classes as $class)

                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                        @endforeach

                                        </select>

                                    </div>

                                    <div class="form-group" id="">
                                        <label>From Room</label>

                                        <select name="room_id" id="class_room" class="form-control dep"
                                            style="min-height: 36px;direction: rtl" required>
                                            <option value="">اختر الصف الدراسي</option>



                                        </select>


                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <a class="btn btn-default" data-dismiss="modal">Cancel</a>
                                    <button class="btn btn-info" id="save" disabled>Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

    </div>
</div>




                <div class="col-md-4">
                    {{-- <button type="button" class="btn btn-block btn-warning mb-3" data-toggle="modal" data-target="#modal-notification">Notification</button> --}}
                    <div class="modal fade active_result" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
                  <div class="modal-dialog modal-success modal-dialog-centered modal-" role="document">
                      <div class="modal-content bg-gradient-success">

                          <div class="modal-header">
                              <h6 class="modal-title" id="modal-title-notification">انتباهك مطلوب</h6>
                              <a type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">×</span>
                              </a>
                          </div>

                          <div class="modal-body">

                              <div class="py-3 text-center">
                                  <i class="ni ni-bell-55 ni-3x"></i>
                                  <h4 class="heading mt-4">! يجب ان تقرأ هذا</h4>
                                  <p>عند الموافقة سيتم عرض النتائج على حساب كل طالب</p>
                              </div>

                          </div>

                          <div class="modal-footer">
                              <a href="{{ route('students.result_active') }}" class="btn btn-white delete">نعم , موافق</a>
                              <a class="btn btn-link text-white ml-auto" data-dismiss="modal">اغلاق</a>
                          </div>
                      </div>
                  </div>
              </div>

                </div>





                <div class="col-md-4">
                    {{-- <button type="button" class="btn btn-block btn-warning mb-3" data-toggle="modal" data-target="#modal-notification">Notification</button> --}}
                    <div class="modal fade disable_result" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
                  <div class="modal-dialog modal-warning modal-dialog-centered modal-" role="document">
                      <div class="modal-content bg-gradient-warning">

                          <div class="modal-header">
                              <h6 class="modal-title" id="modal-title-notification">انتباهك مطلوب</h6>
                              <a type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">×</span>
                              </a>
                          </div>

                          <div class="modal-body">

                              <div class="py-3 text-center">
                                  <i class="ni ni-bell-55 ni-3x"></i>
                                  <h4 class="heading mt-4">! يجب ان تقرأ هذا</h4>
                                  <p>عند الموافقة سيتم اخفاء النتائج على حساب كل طالب</p>
                              </div>

                          </div>

                          <div class="modal-footer">
                              <a href="{{ route('students.result_disable') }}" class="btn btn-white delete">نعم , موافق</a>
                              <a class="btn btn-link text-white ml-auto" data-dismiss="modal">اغلاق</a>
                          </div>
                      </div>
                  </div>
              </div>

                </div>












                <div class="modal fade financialaccountModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="{{ route('invoice_store') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="modal-header">
                                    <h4 class="modal-title">Financial Account &nbsp; <span class="student_name" style="font-weight: bold; font-size: 20px">Mazen Khatib</span></h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">


                                    <input type="hidden" name="student_id" id="student_financial_id">
                                    <input type="hidden" name="class_id" id="class_id">


                                    <div class="row">
                                        <div class="col-md-4">
                                            <label style="font-weight: bold; font-size: 18px; " class="text-primary">كامل</label>

                                        </div>

                                        <div class="col-md-4">
                                            <label style="font-weight: bold; font-size: 18px; " class="text-success">المبلغ المدفوع</label>

                                        </div>

                                        <div class="col-md-4">
                                            <label style="font-weight: bold; font-size: 16px; " class="text-warning">المبلغ المتبقي</label>

                                        </div>
                                    </div>



                                    <div class="row">
                                        <div class="col-md-4">
                                            <label  style="padding: 20px;font-size: 20px" id="full_account" class="badge badge-primary"></label>

                                        </div>

                                        <div class="col-md-4">
                                            <label for="" style="padding: 20px;font-size: 20px" class="badge badge-success" id="amount_paid"></label>

                                        </div>

                                        <div class="col-md-4">
                                            <label for="" style="padding: 20px;font-size: 20px" class="badge badge-warning" id="remaining_account"></label>

                                        </div>
                                    </div>


                                    <br>

                                    <button type="button" class="btn btn-primary btn-block" data-toggle="collapse" data-target="#demo"> اضافة فاتورة</button>



                                    <div id="demo" class="collapse">

                                        <br>
                                        <div class="form-group" style="text-align:right">
                                            <label>العام الدراسي</label>

                                            <select name="year_id" id="years2" class="form-control dep"
                                                style="min-height: 36px;direction: rtl" required>
                                                <option value="">اختر العام الدراسي</option>

                                            @foreach ($years as $year)

                                            <option value="{{ $year->id }}">{{ $year->name }}</option>
                                            @endforeach

                                            </select>

                                        </div>

                                        <div class="form-group">
                                            <label>رقم الفاتورة</label>
                                            <input type="text" name="invoice_number" class="form-control b"
                                                value="" maxlength="20"
                                                placeholder="ضع رقم الفاتورة هنا" >
                                        </div>



                                        <div class="form-group">
                                            <label> المبلغ المدفوع</label>
                                            <input type="number" name="invoice_amount" class="form-control" id="invoice_amount"
                                                value=""
                                                placeholder="ضع قيمة المبلغ هنا "   >
                                        </div>

                                        <div class="modal-footer">
                                            <a class="btn btn-default" data-dismiss="modal">الغاء </a>
                                            <button class="btn btn-info" >حفظ</button>
                                        </div>


                                    </div>


                                </div>



                            </form>


                        </div>
                    </div>
                </div>









                <div class="modal fade sendMessageModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="{{ route('send_message') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="modal-header" style="direction:rtl">
                                    <h4 class="modal-title">إرسال رسالة  &nbsp; <span class="student_name" style="font-weight: bold; font-size: 20px"></span></h4>



                                    <button type="button" class="close" style=" margin: -1rem -1rem auto;" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>


                                </div>
                                <div class="modal-body">


                                    <input type="hidden" name="student_id" id="student_send_message_id">






                                        <div class="form-group">

                                            <textarea name="message" style="direction:rtl; text-alighn:right" class="form-control" autofocus id=""
                                             cols="30" rows="6">

                                            </textarea>

                                        </div>





                                        <div class="modal-footer">
                                            <a class="btn btn-default" data-dismiss="modal">إالغاء</a>
                                            <button class="btn btn-info" >إرسال</button>
                                        </div>




                                </div>



                            </form>


                        </div>
                    </div>
                </div>


                <div class="modal fade changeLangModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="{{route('change_lang')}}" enctype="multipart/form-data">
                                @csrf

                                <div class="modal-header" style="direction:rtl">
                                    <h4 class="modal-title"> تغيير لغة الطالب  &nbsp; <span class="student_name" style="font-weight: bold; font-size: 20px"></span></h4>

                                    <button type="button" class="close" style=" margin: -1rem -1rem auto;" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>

                                </div>
                                <div class="modal-body">

                                    <input type="hidden" name="student_id" id="student_change_lang_id">

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








                                        <div class="modal-footer">
                                            <a class="btn btn-default" data-dismiss="modal">إالغاء</a>
                                            <button class="btn btn-info" >إرسال</button>
                                        </div>




                                </div>



                            </form>


                        </div>
                    </div>
                </div>








                <div class="modal fade changeStudentModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="{{ route('student_change') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="modal-header">
                                    <h4 class="modal-title">تغيير شعبة او صف الطالب &nbsp; <span class="student_name" style="font-weight: bold; font-size: 20px"> </span></h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">



                                    <input type="hidden" name="student_id" id="student_id">
                                    <input type="hidden" name="old_class_id" class="">


                                    <div class="form-group" style="text-align:right">
                                        <label>العام الدراسي</label>

                                        <select name="year_id" id="years" class="form-control dep"
                                            style="min-height: 36px;direction: rtl" required>
                                            <option value="">اختر العام الدراسي</option>

                                        @foreach ($years as $year)

                                        <option value="{{ $year->id }}">{{ $year->name }}</option>
                                        @endforeach

                                        </select>

                                    </div>



                                    <div class="wrapper">
                                        <input type="radio" name="select" id="option-1" value="0" checked>
                                        <input type="radio" name="select" id="option-2" value="1">
                                          <label for="option-1" class="option option-1">
                                            <div class="dot"></div>
                                             <span>راسب</span>
                                             </label>
                                          <label for="option-2" class="option option-2">
                                            <div class="dot"></div>
                                             <span>ناجح</span>
                                          </label>
                                       </div>



                                       <div id="mydivclass" style="direction:rtl; text-align:right">

                                       </div>






                                    <div class="form-group" id="mydivroom" style="direction:rtl; text-align:right">



                                    </div>



                                </div>


                                <div class="modal-footer">
                                    <a class="btn btn-default" data-dismiss="modal">الغاء</a>
                                    <button class="btn btn-info" >حفظ</button>
                                </div>

                            </form>


                        </div>
                    </div>
                </div>



                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>

                <script>

$(document).ready(function () {


    $(document).on('click','.change_lang',function(){

$('#student_change_lang_id').val($(this).data('id'));

if($(this).data('lang')=='0') {
$('#option-lang1').prop("checked", true);

}else if($(this).data('lang')=='1'){
    $('#option-lang2').prop("checked", true);


}

    });

    $(document).on('click', '.financial_account', function () {
var student_id = $(this).data('id');
var class_id = $(this).data('class');
var student_name = $(this).data('name');

$('#student_financial_id').val($(this).data('id'));
$('#class_id').val($(this).data('class'));
$('.student_name').text($(this).data('name'));

var url ="{{ URL::to('SMARMANger/admin/students/invoices_details')}}/"+student_id;
$('.details').attr('href',url);
var url = "{{ URL::to('SMARMANger/admin/students/remain_account') }}/" + student_id +"/"+ class_id;
$.ajax({
url: url,
type: "get",
contentType: 'application/json',
success: function (data) {

$('#full_account').text(data.full_amount);
$('#remaining_account').text(data.remain_amount);
$('#amount_paid').text(data.amount_paid);

$('#invoice_amount').attr('max',data.remain_amount);

if(data.remain_amount==0){

    $('.add_reciept').hide();

}else{
    $('.add_reciept').show();

}

       },
error: function (xhr) {

}

});



});





    $('.change_student').on('click', function () {

        $('.student_name').text($(this).data('name'));

        $('#student_id').val($(this).data('id'));


    });


    $('input:radio[name=select]').on('click', function () {

$('#mydivclass').empty();

var val=$(this).val();
var type="";
if (val=='1') {

type+=`
        <br>
        <div class="form-group" style="direction:rtl; text-align:right">
        <label>الصف</label>

        <select name="class_change_id" id="classes_change" class="form-control dep"
            style="min-height: 36px;direction: rtl" required>
            <option value="">اختر الصف الدراسي</option>

        @foreach ($classes as $class)

        <option value="{{ $class->id }}">{{ $class->name }}</option>
        @endforeach

        </select>

    </div>

`;
$('#mydivclass').append(type);


}
else {

    $('#mydivclass').empty();
    $('#mydivroom').empty();
var year_id=$('#years').val();
var class_id=$('#old_class_id').val();
console.log(year_id);

$('.old_class_id').val(class_id);



var type="";


var url = "{{ URL::to('SMARMANger/admin/classes/rooms2') }}/" + class_id +"/"+ year_id;
        $.ajax({
            url: url,
            type: "get",
            contentType: 'application/json',
            success: function (data) {

                var type = `
                <br>
                <label>الشعبة</label>

                <select name="room_change_id" id="" class="form-control dep"
                    style="min-height: 36px;direction:rtl" required>
                    <option value="">اختر الشعبة الدراسية</option>

                    `;

                $.each(data, function (key, value) {


                    type += `
<option value="${value.id}">${value.name}</option>

                      `;

                });

            type+=`
                    </select>
                          `;
                $('#mydivroom').append(type);

            },
            error: function (xhr) {

            }

        });




}




        });


$(document).on('change', '#classes_change', function () {

    $('#mydivroom').empty();

var year_id=$('#years').val();
var class_id=$(this).val();

var type="";


var url = "{{ URL::to('SMARMANger/admin/classes/rooms2') }}/" + class_id +"/"+ year_id;
        $.ajax({
            url: url,
            type: "get",
            contentType: 'application/json',
            success: function (data) {

                var type = `
                <label>الشعبة</label>

                <select name="room_change_id" id="" class="form-control dep"
                    style="min-height: 36px;direction:rtl" required>
                    <option value="">اختر الشعبة الدراسية</option>

                    `;

                $.each(data, function (key, value) {


                    type += `
<option value="${value.id}">${value.name}</option>

                      `;

                });

            type+=`
                    </select>
                          `;
                $('#mydivroom').append(type);

            },
            error: function (xhr) {

            }

        });




        });








    $('.delete').on('click', function () {
    var id = $(this).data('id');
    var url = "{{URL::to('SMARMANger/admin/students/destroy')}}/"+id;
    $('#form_delete').attr("action", url);


});



    $(document).on('change', '#classes', function () {
        var class_id = $(this).val();

        var url = "{{ URL::to('SMARMANger/admin/classes/rooms') }}/" + class_id ;
        $.ajax({
            url: url,
            type: "get",
            contentType: 'application/json',
            success: function (data) {

                $('#class_room').empty();
                var type = `

                    <option value="">اختر الشعبة الدراسية</option>

                    `;

                $.each(data, function (key, value) {


                    type += `
<option value="${value.id}">${value.name}</option>

                      `;

                });


                $('#class_room').append(type);

            },
            error: function (xhr) {

            }

        });
    });





    $('#search_student').on('keyup',function(){
        var search_student = $(this).val();

        var url = "{{ URL::to('SMARMANger/admin/students/student_filter') }}";
        $.ajax({
            url: url,
            type: "get",
            contentType: 'application/json',
            data:{

student_now:search_student,

},
            success: function (data) {

                $('#mydiv').empty();
var type="";

                $.each(data, function (key, value) {
console.log(data);
                    type += `

                    <tr>

                    <td class="budget">
                    ${value.first_name}

                  </td>

                  <td class="budget">
                    ${value.last_name}

                  </td>




                  <td class="budget">
                    ${value.address}

                  </td>

                  <td class="budget">
                    ${value.phone}

                  </td>

                  <td>
                      <div class="avatar-group">
                        <a href="#" class="avatar avatar-sm rounded-circle" data-toggle="tooltip" data-original-title="Ryan Tompson">
                          <img alt="Image placeholder" src="{{ asset('storage/${value.image}') }}">
                        </a>

                      </div>
                    </td>


                    <td class="budget">`;
if (value.room[0]) {
type+=`${value.room[0].classes.name}

</td>
<td>
    ${value.room[0].name}

</td>

`;
}

type+=`




                    <td class="text-right">

                        <div class="dropdown">
                    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow " style="
    direction: ltr;">

                    <a href=".changeStudentModal"  class="dropdown-item change_student " data-toggle="modal" data-id="${value.id}"
                    data-name="${value.first_name} ${value.last_name} " style="
    direction: ltr;"><i class="ni ni-folder-17"></i>تغيير صف او شعبة الطالب</a>
`;


                  if (value.room[0].classes.id){

                      type+=`

                                <a href=".financialaccountModal" style="
    direction: ltr;"  class="dropdown-item financial_account" data-toggle="modal" data-id="${value.id}"
                        data-name="${value.first_name} ${value.last_name} " data-class="${value.room[0].classes.id}"><i class="ni ni-folder-17"></i>الحساب المالي</a>

                      `;
                  }


type+=`

                    <a href=".sendMessageModal"  style="
    direction: ltr;" class="dropdown-item send_message" data-toggle="modal" data-id="${value.id}"
                  ><i class="ni ni-folder-17"></i>ارسال رسالة</a>



                  <a href=".changeLangModal"  class="dropdown-item change_lang" data-toggle="modal" data-id="${value.id}" data-lang="${value.lang}" style="
    direction: ltr;"
                  ><i class="ni ni-folder-17" ></i> تغيير لغة الطالب</a>

                </div>
                </div>`;





                           if ( value.super =='1'){
                               type+=`


                               <a data-id="${value.id}" href="" class="student_less" >
                            <i class="fa fa-graduation-cap fa-2x super_${value.id}" id="super_${value.id}" style="color: green"></i>

                           </a>

                               `;
                           }
                           else{

                            type+=`


                            <a data-id="${value.id}" class="student_super" >
                            <i class="fa fa-graduation-cap fa-2x super_${value.id}" style="color: blue" id="super_${value.id}"></i>

                           </a>


                               `;
                           }




                        type+=`


                        <a href="{{ url('SMARMANger/admin/students/student_details/${value.id}') }}" target="_blank">
                        <i class="fa fa-eye fa-2x" style="color: blue"></i>

                        </a>


                        </td>
                        </tr>


                        `;








                });


                $('#mydiv').append(type);

            },
            error: function (xhr) {

            }

        });
    });



    $('.status').on('change',function(){

        var status=$(this).val();
        $('#mydiv1').empty();

        var type="";
        if (status=="new") {

            type+=`



                    <div class="form-group">
                    <label> (صفحة الطالب)صورة السجل المدني او دفتر العائلة</label>

                    <div class="custom-file">
                        <input type="file" name="family_book_image" class="custom-file-input" id="customFileLang" lang="en">
                        <label class="custom-file-label" for="customFileLang">Select file</label>
                    </div>
                </div>


                <div class="form-group">
                    <label>صورة شهادة صحية </label>

                    <div class="custom-file">
                        <input type="file" name="health_certificate_image" class="custom-file-input" id="customFileLang" lang="en">
                        <label class="custom-file-label" for="customFileLang">Select file</label>
                    </div>
                </div>



            `;


        }else if(status=="transported"){

            type+=`


            <div class="form-group" >
                    <label> (صفحة الطالب)صورة السجل المدني او دفتر العائلة</label>

                    <div class="custom-file">
                        <input type="file" name="family_book_image" class="custom-file-input" id="customFileLang" lang="en">
                        <label class="custom-file-label" for="customFileLang">Select file</label>
                    </div>
                </div>


                <div class="form-group" >
                    <label>صورة شهادة صحية </label>

                    <div class="custom-file">
                        <input type="file" name="health_certificate_image" class="custom-file-input" id="customFileLang" lang="en">
                        <label class="custom-file-label" for="customFileLang">Select file</label>
                    </div>
                </div>




            <div class="form-group">
            <label>

                صورة التسلسل الدراسي لعامين سابقين
            </label>

            <div class="custom-file">
                <input type="file" name="school_seq_image[]" multiple class="custom-file-input" id="customFileLang" lang="en">
                <label class="custom-file-label" for="customFileLang">Select file</label>
            </div>
        </div>



        <div class="form-group">
            <label style="text-align:right; direction:rtl">صورة الشهادة الأخيرة  </label>

            <div class="custom-file">
                <input type="file" name="last_certificate_image" class="custom-file-input" id="customFileLang" lang="en">
                <label class="custom-file-label" for="customFileLang">Select file</label>
            </div>
        </div>




            `;


        }
        console.log(type);
        $('#mydiv1').append(type);



    });




$(document).on('click','.student_super',function(e){
    var student_id=$(this).data('id');

e.preventDefault();

$.ajax({

    type:'post',
    url:"{{ route('student.super') }}",
    enctype:'multipart/form-data',
    data:{
        '_token':"{{ csrf_token() }}",
        'id':student_id,
    },


    success:function(data){


       $(`#super_${student_id}`).attr('style','color:green');

       $(`#super_${student_id}`).parent().attr('class','student_less');

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






$(document).on('click','.student_less',function(e){
    var student_id=$(this).data('id');

e.preventDefault();

$.ajax({

    type:'post',
    url:"{{ route('student.less') }}",
    enctype:'multipart/form-data',
    data:{
        '_token':"{{ csrf_token() }}",
        'id':student_id,
    },


    success:function(data){


       $(`#super_${student_id}`).attr('style','color:blue');

       $(`#super_${student_id}`).parent().attr('class','student_super')

           },
    error: function (xhr) {

}

});


});





});

</script>

<script language="javascript">
            var pwd = document.getElementById("password");
pwd.onclick=function(){
document.getElementById('alert').innerText=
"This is must contain uppercase and lowercase and symbols";
}
    function passwordChanged() {
        var strength = document.getElementById('strength');
        var strongRegex = new RegExp("^(?=.{14,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
        var mediumRegex = new RegExp("^(?=.{10,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
        var enoughRegex = new RegExp("(?=.{8,}).*", "g");
        var pwd = document.getElementById("password");
        if (pwd.value.length == 0) {
            strength.innerHTML = 'Type Password';
            document.getElementById('alert').innerText=
"This is must contain uppercase and lowercase and symbols";
            document.getElementById('save').disabled = true;
        } else if (false == enoughRegex.test(pwd.value)) {

            strength.innerHTML = 'More Characters';

            document.getElementById('alert').innerText=
"This is must contain uppercase and lowercase and symbols";
            document.getElementById('save').disabled = true;
        } else if (strongRegex.test(pwd.value)) {
            strength.innerHTML = '<span style="color:green">Strong!</span>';
            document.getElementById('alert').innerText="";
            document.getElementById('save').disabled = false;
        } else if (mediumRegex.test(pwd.value)) {
            strength.innerHTML = '<span style="color:orange">Medium!</span>';
            document.getElementById('alert').innerText=
"";
            document.getElementById('save').disabled = false;

        } else {

            document.getElementById('alert').innerText=
"This is must contain uppercase and lowercase and symbols";
            document.getElementById('save').disabled = true;
            strength.innerHTML = '<span style="color:red">Weak!</span>';
        }
    }
</script>

<script>
function password_show_hide() {
  var x = document.getElementById("password");
  var show_eye = document.getElementById("show_eye");
  var hide_eye = document.getElementById("hide_eye");
  hide_eye.classList.remove("d-none");
  if (x.type === "password") {
    x.type = "text";
    show_eye.style.display = "none";
    hide_eye.style.display = "block";
  } else {
    x.type = "password";
    show_eye.style.display = "block";
    hide_eye.style.display = "none";
  }
}


function password_show_hide2() {
  var x = document.getElementById("password-confirm");
  var show_eye = document.getElementById("show_eye2");
  var hide_eye = document.getElementById("hide_eye2");
  hide_eye.classList.remove("d-none");
  if (x.type === "password") {
    x.type = "text";
    show_eye.style.display = "none";
    hide_eye.style.display = "block";
  } else {
    x.type = "password";
    show_eye.style.display = "block";
    hide_eye.style.display = "none";
  }
}
</script>
@endsection
