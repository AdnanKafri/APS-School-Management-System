@extends('admin.master')


@section('style')
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
@endsection



@section('breadcrumbs')

<nav class="breadcrumbs">
    <a  class="breadcrumbs__item is-active">الجلاءات -  طلاب الشعبة- </a>
    <a  href="{{ route('classroom_graduate',$room->class_id) }}" class="breadcrumbs__item " >قسم الجلاءات - الشعب - </a>
    <a href="{{ route('classes.graduation') }}" class="breadcrumbs__item "> قسم الجلاءات - الصفوف </a>

    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>

@endsection



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
    <h2 class="mb-0" style="color: #001586;text-align: center">جدول جلاءات طلاب الشعبة /{{ $class_name }} /{{ $room_name }}</h2>
    {{-- <input type="text" name="search_student" placeholder="&#xF002; Search" class="form-control"
    style="color: #000;display: inline; font-family:Arial, FontAwesome;" id="search_student1"> --}}
  </div>
<div class="table-responsive">





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
                    {{-- <th scope="col" class="sort" data-sort="completion">الصف</th>
                    <th scope="col" class="sort" data-sort="completion">الشعبة</th> --}}
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
                    <img alt="Image placeholder" src="{{asset('storage/'.$item->image)}}" style="width75px;height:100px">
                    </a>

                </div>
                @endif
                </td>

                {{-- <td class="budget">
            @if(isset($item->room[0]))

            {{$item->room[0]->classes->name}}
            <input type="hidden" id="old_class_id" value="{{$item->room[0]->classes->id}}">
            @endif

            </td>
            <td class="budget">
            @if(isset($item->room[0]))
            {{$item->room[0]->name}}
            @endif

            </td> --}}

        <td class="text-right">



{{-- <a href=".changeStudentModal"  class="change_student btn btn-success" data-toggle="modal" data-id="{{ $item->id }}"
data-name="{{ $item->first_name }} {{ $item->last_name }} "><i class="material-icons" data-toggle="tooltip">Change Student</i></a> --}}

{{-- <div class="dropdown">
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
</div> --}}






            <a  class="graduateStudent" href="{{ route('view_single_student_graduate',$item->id) }}"
                title="استعراض الجلاء">
                <i class="fa fa-graduation-cap fa-2x super_{{ $item->id }}" style="color: #0fc08b" id="super_{{ $item->id }}"></i>
            </a>

            <a  class="graduateStudent btn" href=".singleStudentGraduate"
                 data-toggle="modal"
                 data-id="{{ $item->id }}" data-first_name="{{ $item->first_name }}" data-last_name="{{ $item->last_name }}"
                 style="color: white !important;background: #0f9ad1 !important;border-color: #0e8dbe !important">
                استصدار الجلاء
            </a>
            <a href=".cancelStudentGraduate" style="color: white !important;background: #0f739b !important;border-color: #0e8dbe !important"
                class="cancelGraduate btn btn-success"
                data-name="{{ $item->name }}"  data-id="{{ $item->id }}"  data-toggle="modal" >
                {{-- <i class="ni ni-settings"></i> --}}
                     إلغاء استصدار الجلاء
            </a>




                {{-- <a href="{{ route('student_details',$item->id) }}" target="_blank">
                <i class="fa fa-eye fa-2x" style="color: #0083FF"></i>
                </a> --}}



                {{-- <a href="{{ route('student_archive',$item->id) }}" target="_blank">

                <i class="ni ni-archive-2 fa-2x" style="color: #0083FF"></i>
                </a> --}}



                </td>


            </tr>


        @endforeach


                </tbody>
              </table>



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



                @endif








    </div>
</div>





            <div class="modal fade singleStudentGraduate">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="" action="{{ route('single_student_graduate') }}" method="POST">
                            @csrf

                            <div class="modal-header">
                                <h4 class="modal-title">استصدار الجلاء المدرسي للطالب:   </h4>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group" style="text-align:right">
                                    <label> سيتم استصدار الجلاء  للطالب  التالي </label>
                                    <input type="text" name="student_name" class="form-control student_name"
                                        value="" style="direction: rtl"
                                      readonly> <br>
                                      <label>يرجى الانتباه.. عند تصدير الجلاء لا يمكن التعديل على العلامات        </label>
                                    {{-- <input type="text" name="information" class="form-control"
                                    value="" style="direction: rtl;color: #c44800"
                                    placeholder="عند تصدير الجلاء لا يمكن التعديل على العلامات" readonly> --}}
                                    <input type="hidden" name="student_id" class="form-control student_id" >
                            </div>

                            </div>
                            <div class="modal-footer">
                                <a class="btn btn-dark" style="color: #fff" data-dismiss="modal">الغاء</a>
                                <button class="btn btn-primary">متابعة</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <div class="modal fade cancelStudentGraduate">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="" action="{{ route('class_store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="modal-header">
                                <h4 class="modal-title">إلغاء استصدار الجلاء المدرسي للطالب:   </h4>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group" style="text-align:right">
                                    <label> سيتم إلغاء استصدار الجلاء  للطالب  التالي </label>
                                    <input type="text" name="student_name" class="form-control student_name"
                                        value="" style="direction: rtl"
                                      readonly> <br>
                                      <label>يرجى الانتباه.. عند إلغاء تصدير الجلاء سيكون بالإمكان التعديل على العلامات        </label>
                                    {{-- <input type="text" name="information" class="form-control"
                                    value="" style="direction: rtl;color: #c44800"
                                    placeholder="عند تصدير الجلاء لا يمكن التعديل على العلامات" readonly> --}}
                                    <input type="hidden" name="student_id" class="form-control student_id" value="" readonly>
                            </div>

                            </div>
                            <div class="modal-footer">
                                <a class="btn btn-dark" style="color: #fff" data-dismiss="modal">الغاء</a>
                                <button class="btn btn-primary">متابعة</button>
                            </div>
                        </form>
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






                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>

                <script>

$(document).ready(function () {


$(document).on('click', '.graduateStudent', function () {
var id = $(this).data('id');
var first_name = $(this).data('first_name');
var last_name = $(this).data('last_name');
var full_name = first_name +' '+ last_name;
$('.student_name').val(full_name);
$('.student_id').val(id);

});


    $('.change_student').on('click', function () {

        $('.student_name').text($(this).data('name'));

        $('#student_id').val($(this).data('id'));


    });





//     $('.delete').on('click', function () {
//     var id = $(this).data('id');
//     var url = "{{URL::to('SMARMANger/admin/students/destroy')}}/"+id;
//     $('#form_delete').attr("action", url);


// });






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




$(document).on('click','.student_super111',function(e){
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
