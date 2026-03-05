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
    <a  class="breadcrumbs__item ">طلاب  الشعبة </a>
  
    <a href="{{  route('classroom_exams',$class_id)}}"  class="breadcrumbs__item ">قسم الشعب </a>
    <a href="{{ route('classes.view.exams') }}" class="breadcrumbs__item ">قسم جدول الدوام والاختبارات</a>
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
    <h2 class="mb-0" style="color: #001586;text-align: center">جدول  الطلاب  /الصف {{ $class_name }} /الشعبة{{ $room_name }} </h2>
    {{-- <input type="text" name="search_student" placeholder="&#xF002; Search" class="form-control"
    style="color: #000;display: inline; font-family:Arial, FontAwesome;" id="search_student1"> --}}
  </div>
<div class="table-responsive">




        <table class="table align-items-center table-flush" style="direction:rtl;text-align:right">
                <thead class="">
                  <tr>
                    <!--<th scope="col" class="sort" data-sort="name">Id</th>-->
                    <th scope="col" class="sort" data-sort="budget">الاسم </th>
                    {{-- <th scope="col" class="sort" data-sort="completion"> الشعبة</th> --}}

                    <th scope="col" class="sort" data-sort="completion">العمليات</th>

                  </tr>
                </thead>
                <tbody class="list" id="mydiv">

                    @if ($count!=0)
                    @foreach ($students as $item)


                    <tr>
                        <td class="budget">
                            {{$item->first_name .' '.$item->last_name}}
                        </td>
                        <td class="text-center">
                            <a  class="graduateStudent btn" href=".exam_reactivate"
                                data-toggle="modal"
                                data-id="{{ $item->id }}" data-first_name="{{ $item->first_name }}" data-last_name="{{ $item->last_name }}"
                                style="color: white !important;background: #0f9ad1 !important;border-color: #0e8dbe !important">
                                إعادة تفعيل
                            </a>
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







            <div class="modal fade exam_reactivate">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="" action="{{ route('exam_reactivate') }}" method="POST">
                            @csrf
                            <input type="hidden" name="student_id" class="form-control student_id" >
                            <input type="hidden" name="exam_id" class="form-control exam_id" value="{{ $exam_id }}" >

                            <div class="modal-header">
                                <h4 class="modal-title"> إعادة تفعيل الامتحان  للطالب:   </h4>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group" style="text-align:right">
                                    <label> سيتم إعادة الامتحان  للطالب  التالي </label>
                                    <input type="text" name="" class="form-control student_name"
                                        value="" style="direction: rtl"
                                      readonly> <br>
                                      <label>يرجى الانتباه.. عند إعادة الامتحان  سيتم حذف أي نتائج سابقة        </label>

                            </div>

                            </div>
                            <div class="modal-footer">
                                <a class="btn btn-dark" style="color: #fff" data-dismiss="modal">الغاء</a>
                                <button class="btn btn-primary">حفظ</button>
                            </div>
                        </form>
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
});

</script>


@endsection
