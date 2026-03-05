@extends('admin.master')
@section('style')

<style>
.custom-file-label{
display:none !important;
}
    .custom-file-label{
        display:none;
    }
    .pagination{
        justify-content: center !important;
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

@endsection


@section('breadcrumbs')

<nav class="breadcrumbs">
    <a  class="breadcrumbs__item is-active">قسم الجلاءات</a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>

@endsection

@section('content')
{{-- <div class="col" > --}}
   {{-- @if($jobcount>0)
           <div class="alert alert-danger" style="text-align: center;">
                    هناك عملية تتم حاليا
        </div>

        @endif --}}

    <div class="card" style="direction:rtl; text-align:right;margin: 20px;">

        <!--@if(session()->has('success'))-->


        <!--<div class="alert alert-success alert-dismissible" role="alert" style="text-align: right; font-size: 30px">-->
        <!--    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
        <!--    {{ session()->get('success') }}-->
        <!--    </div>-->

        <!--@endif -->



            <div class="card-header border-0">
              <h3 class="mb-0">جدول الصفوف</h3>
            </div>

    <div class="table-responsive">
       @can('add_certificate_details')
        <a href=".set_actual_attendance" class=" btn btn-success" data-toggle="modal"
        data-id="" style="background: #78cab2 !important"><i class="material-icons" data-toggle="tooltip"
        >تفاصيل الجلاء </i></a>
         @endcan
           @can('issuance_of_a_certificate')

     <a href=".allClassGraduate" class=" btn btn-success" data-toggle="modal"
    data-id=""><i class="material-icons" data-toggle="tooltip"> استصدار الجلاء  لجميع الصفوف </i></a>

    @endcan
     @can('install_tags')
    <a href=".AllClassesfreezeMarks" class=" btn btn-success"
    style="color: white !important;background: #4e90aa  !important;border-color: #008CC4 !important;
        margin-right: 10px"
    data-toggle="modal" data-id="">
    <i class="material-icons" data-toggle="tooltip">  تثبيت العلامات لجميع الصفوف </i></a>
    @endcan
     @can('closing_an_academi_year')

     <a href=".endSchoolYear"     class=" btn btn-success"
    style="color: white !important;background: #0a775f  !important;border-color: #008CC4 !important;
        margin-right: 10px;float: left;"
    data-toggle="modal" data-id="">
    <i class="material-icons" data-toggle="tooltip">  إغلاق العام الدراسي الحالي </i> </a>

     @endcan


              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <!--<th scope="col" class="sort" data-sort="name">Id</th>-->
                    <th scope="col" class="sort" data-sort="budget"> الاسم بالعربية</th>
            <th scope="col" class="sort" data-sort="budget"> الاسم بالانكليزية</th>
            <th scope="col" class="sort" data-sort="budget"> دوام الفصل1 </th>
            <th scope="col" class="sort" data-sort="budget"> دوام الفصل2 </th>
            <th scope="col" class="sort" data-sort="budget"> حالة الجلاء  </th>


                    <th scope="col" class="sort " data-sort="budget"> العمليات</th>

                  </tr>
                </thead>
                <tbody class="list">
                @foreach ($classes as $item)

               <tr>
                <!--    <th scope="row">-->
                <!--    {{$item->id}}-->
                <!--</th>-->


                <td class="budget" style="font-weight:bold;font-size:15px">
                    {{$item->name}}
                  </td>

                  <td class="budget"style="font-weight:bold;font-size:15px">
                    {{$item->name_en}}
                  </td>
                  <td class="budget"style="font-weight:bold;font-size:15px">
                    {{ isset($item->report_card_details[0]) ? json_decode($item->report_card_details[0]->actual_attendance)->{'term1'} :  ''  }}
                    {{-- {{isset($item->actual_attendance) ? json_decode($item->actual_attendance)->{'term1'} : ''}} --}}
                  </td>
                  <td class="budget"style="font-weight:bold;font-size:15px">
                    {{ isset($item->report_card_details[0]) ? json_decode($item->report_card_details[0]->actual_attendance)->{'term2'} :  ''  }}
                    {{-- {{isset($item->actual_attendance) ? json_decode($item->actual_attendance)->{'term2'} : ''}} --}}
                  </td>

                   <td class="text-right">
                     <span  class="btn btn-success "style="color: white" >
                        @php
                            $report_card_status = isset($item->report_card_details[0]) ? $item->report_card_details[0]->report_card_status :  '';
                            // dd($report_card_status) ;
                        @endphp
                        @if($report_card_status == 0)
                            لم يستصدر
                        @elseif ($report_card_status == 1)
                            تم استصدار الفصل 1
                        @elseif ($report_card_status == 2)
                            تم استصدار الفصل 2
                        @else
                          غير معروف
                        @endif
                    </span>
                  </td>

                  <td class="text-right">
                      <a href="{{route('classroom_graduate',$item->id)}}" class="btn btn-secondary " style="margin-left: 10px;color:#fff">الشعب</a>
                        @can('issuance_of_a_certificate')

                         <a href=".singleClassGraduate" class="btn btn-success graduate" data-name="{{ $item->name }}"
                      data-id="{{ $item->id }}"data-toggle="modal" style="color: white" > استصدار الجلاء </a>
                


                        @endcan
                        @can('install_tags')
                     <a href=".singleClassesfreezeMarks" class="btn  freeze" data-name="{{ $item->name }}"
                      data-id="{{ $item->id }}"data-toggle="modal"
                      style="color: white !important;background: #4e90aa  !important;border-color: #008CC4 !important;"
                      >  تثبيت العلامات </a>
                      @endcan

                  </td>

                  </tr>


               @endforeach


                </tbody>
              </table>

            </div>

            <div class="clearfix" style="padding-left:10px;text-align: center">
                    <div class="hint-text">Showing
                        <b>{{ !request('page')? "1" : request('page') }}</b>
                        out of <b>{{ ceil($count/paginate_num) }}</b> entries</div>
                    <div class="row">
                        <div class="col-md-12" >
                            {{ $classes->links() }}
                        </div>
                    </div>
            </div>


    </div>
{{-- </div> --}}


<div class="modal fade set_actual_attendance">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="" action="{{ route('set_actual_attendance') }}" method="POST" >
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">تحديد تفاصيل الجلاء           </h4>
                    <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group" style="text-align:right">
                        <label>    تحديد عدد أيام الدوام الفعلي  للفصل الأول   </label>
                        <input type="number" name="actual_attendance1" class="form-control"
                            value="" style="direction: rtl"
                            placeholder=" يرجى الإدخال" >
                    </div>
                    <div class="form-group" style="text-align:right">
                        <label>  تحديد عدد أيام الدوام الفعلي للفصل الثاني</label>
                        <input type="number" name="actual_attendance2" class="form-control"
                            value="" style="direction: rtl"
                            placeholder=" يرجى الإدخال" >
                    </div>
                    {{-- <div class="form-group" style="text-align:right">
                        <label>  حدد الفصل</label>

                        <select name="lesson_id" id="" class="form-control lesson_id"
                            style="min-height: 36px;direction: rtl" required>
                            <option value="">اختر  الفصل</option>

                        @foreach ($lessons as $lesson)

                        <option value="{{ $lesson->id }}">{{ $lesson->name }}</option>
                        @endforeach

                        </select>

                    </div> --}}
                    <div class="form-group" style="text-align:right">
                        <label> اسم المدير</label>
                        <input type="texy" name="manager_name" class="form-control"
                            value="" style="direction: rtl"
                            placeholder=" يرجى الإدخال" >
                    </div>
                     <div class="form-group" style="text-align:right">
                        <label> اسم الموجه</label>
                        <input type="texy" name="instructor_name" class="form-control"
                            value="" style="direction: rtl"
                            placeholder=" يرجى الإدخال" >
                    </div>
                   <div class="form-group" style="text-align:right">
                        <label> تاريخ استصدار الجلاء للفصل الأول </label>
                        <input type="date" name="report_card_date_term1" class="form-control"
                            value="" style="direction: rtl"
                            placeholder=" التاريخ الذي سيظهر ضمن الجلاء " >
                    </div>
                    <div class="form-group" style="text-align:right">
                        <label> تاريخ استصدار الجلاء للفصل الثاني </label>
                        <input type="date" name="report_card_date_term2" class="form-control"
                            value="" style="direction: rtl"
                            placeholder=" التاريخ الذي سيظهر ضمن الجلاء " >
                    </div>
                    <div class="form-group" style="text-align:right">
                        <label>  اختر الصف  </label>
                        <select name="class_id[]" id="" class="form-control wide class_choosing"
                        style="min-height: 36px;direction: rtl;
                        width:100%;" required multiple>
                        <option value="">اختر  الصف</option>
                        <option value="0">كل الصفوف  </option>
                    @foreach ($all_classes as $class)

                        <option value="{{ $class->id }}">

                            {{ $class->name }}
                        </option>
                    @endforeach

                    </select>
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






            <div class="modal fade allClassGraduate">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="" action="{{ route('all_class_graduate') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="modal-header">
                                <h4 class="modal-title">تحديد حالة الجلاء  لجميع الصفوف </h4>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                            </div>

                            <div class="modal-body">
                                <div class="form-group" style="text-align:right">
                                    <label>   حالة الجلاء  </label>
                                     <select name="adjustable" id="" class="form-control is_passed"
                                        style="min-height: 36px;direction: rtl" required>
                                        <option  hidden>حدد حالة الجلاء         </option>

                                            <option value="1">استصدار الجلاء</option>
                                            <option value="0">  إلغاء الاستصدار</option>

                                    </select>
                                </div>
                                <div class="form-group" style="text-align:right">
                                    <label>   حدد الفصل  </label>
                                     <select name="term" id="" class="form-control is_passed"
                                        style="min-height: 36px;direction: rtl" required>
                                        <option value=""  hidden>حدد  الفصل         </option>

                                        <option value="1">    الفصل الأول</option>
                                        <option value="2">الفصل الثاني </option>

                                    </select>
                                </div>
                                <div class="form-group" style="text-align:right">
                                    <label> سيتم استصدار الجلاء لكل الصفوف </label>
                                    <input type="text" name="class_name" class="form-control"
                                        value="" style="direction: rtl"
                                        placeholder=" يرجى الانتباه ..  عند تصدير الجلاء لا يمكن التعديل على العلامات " maxlength="20" readonly>
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


            <div class="modal fade singleClassGraduate">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="" action="{{ route('single_class_graduate') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="modal-header">
                                <h4 class="modal-title">استصدار الجلاء المدرسي   </h4>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group" style="text-align:right">
                                    <label>   حالة الجلاء  </label>
                                     <select name="adjustable" id="" class="form-control is_passed"
                                        style="min-height: 36px;direction: rtl" required>
                                        <option value="" hidden >حدد حالة الجلاء         </option>

                                            <option value="1">استصدار الجلاء</option>
                                            <option value="0">  إلغاء الاستصدار</option>

                                    </select>
                                </div>
                                <div class="form-group" style="text-align:right">
                                    <label>   حدد الفصل  </label>
                                     <select name="term" id="" class="form-control is_passed"
                                        style="min-height: 36px;direction: rtl" required>
                                        <option value=""  hidden>حدد  الفصل         </option>

                                        <option value="1">    الفصل الأول</option>
                                        <option value="2">الفصل الثاني </option>

                                    </select>
                                </div>
                                <div class="form-group" style="text-align:right">
                                    <label> سيتم استصدار الجلاء  للصف التالي </label>
                                    <input type="text" name="class_name" class="form-control class_name"
                                        value="" style="direction: rtl"
                                      readonly> <br>
                                      <label>يرجى الانتباه.. عند تصدير الجلاء لا يمكن التعديل على العلامات        </label>
                                    {{-- <input type="text" name="information" class="form-control"
                                    value="" style="direction: rtl;color: #c44800"
                                    placeholder="عند تصدير الجلاء لا يمكن التعديل على العلامات" readonly> --}}
                                    <input type="hidden" name="class_id" class="form-control class_id" value="" readonly>
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







                <div class="modal fade singleClassesfreezeMarks">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="form_delete" action="{{ route('single_Class_freeze_Marks') }}" method="POST" autocomplete="off">

                                @csrf
                                <input type="hidden" name="class_id" class="form-control class_id" value="" required>


                                <div class="modal-header" >
                                    <h4 class="modal-title" style="color: rgb(17, 16, 16)"> تثبيت العلامات لجميع الصفوف</h4>
                                    <button type="button" class="close"
                                    style="color: rgb(22, 21, 21)" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group" style="text-align:right">
                                        <label>   حالة العلامات  </label>
                                         <select name="adjustable" id="" class="form-control is_passed"
                                            style="min-height: 36px;direction: rtl" required>
                                            <option value="" hidden>حدد حالة العلامات         </option>

                                            <option value="0">  إلغاء تثبيت العلامات</option>
                                            <option value="1">تثبيت العلامات</option>

                                        </select>
                                    </div>
                                    <div class="form-group" style="text-align:right">
                                        <label>   حدد الفصل  </label>
                                         <select name="term" id="" class="form-control is_passed"
                                            style="min-height: 36px;direction: rtl" required>
                                            <option value=""  hidden>حدد  الفصل         </option>

                                            <option value="1">    الفصل الأول</option>
                                            <option value="2">الفصل الثاني </option>

                                        </select>
                                    </div>
                                    <div class="form-group" style="text-align:right">
                                        <label> سيتم  تحديد حالة العلامات  للصف التالي </label>
                                        <input type="text" name="class_name" class="form-control class_name"
                                            value="" style="direction: rtl"
                                          readonly> <br>
                                          <label>يرجى الانتباه.. عند تثبيت العلامات لا يمكن التعديل عليها من قبل الاستاذ        </label>

                                    </div>
                                    {{-- <div class="form-group" style="text-align:right">
                                        <label style="font-size: 18px; font-weight:bold"> أدخل كود الإلغاء للتأكيد  </label>
                                        <input type="password" style="direction:rtl" id="delete_code" name="delete_code" class="form-control a"
                                            value=""
                                            placeholder="أدخل كود التأكيد  "  required>
                                    </div> --}}

                                </div>
                                <div class="modal-footer" style="justify-content: right;">
                                    <button class="btn btn-success btn-block ml-1">حفظ</button>
                                    <a class="btn btn-dark  btn-block m-0" data-dismiss="modal" style="color: #fff !important;">الغاء </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="modal fade AllClassesfreezeMarks">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="form_delete" action="{{ route('all_Classes_freeze_Marks') }}" method="POST" autocomplete="off">

                                @csrf
                                <div class="modal-header" >
                                    <h4 class="modal-title" style="color: rgb(17, 16, 16)"> تثبيت العلامات لجميع الصفوف</h4>
                                    <button type="button" class="close"
                                    style="color: rgb(15, 15, 15)" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group" style="text-align:right">
                                        <label>   حالة العلامات  </label>
                                         <select name="adjustable" id="" class="form-control is_passed"
                                            style="min-height: 36px;direction: rtl" required>
                                            <option  hidden>حدد حالة العلامات         </option>

                                            <option value="0">  إلغاء تثبيت العلامات</option>
                                            <option value="1">تثبيت العلامات</option>

                                        </select>
                                    </div>
                                    <div class="form-group" style="text-align:right">
                                        <label>   حدد الفصل  </label>
                                         <select name="term" id="" class="form-control is_passed"
                                            style="min-height: 36px;direction: rtl" required>
                                            <option  hidden>حدد  الفصل         </option>

                                            <option value="1">    الفصل الأول</option>
                                            <option value="2">الفصل الثاني </option>

                                        </select>
                                    </div>
                                    {{-- <div class="form-group" style="text-align:right">
                                        <label style="font-size: 18px; font-weight:bold"> أدخل كود الإلغاء للتأكيد  </label>


                                        <input type="password" style="direction:rtl" id="delete_code" name="delete_code" class="form-control a"
                                            value=""
                                            placeholder="أدخل كود التأكيد  "  required>
                                    </div> --}}

                                    <div class="form-group" style="text-align:right">
                                       <br>
                                          <label>يرجى الانتباه.. عند تثبيت العلامات لا يمكن التعديل عليها من قبل الاستاذ         </label>
                                    </div>

                                </div>
                                <div class="modal-footer" style="justify-content: right;">
                                    <button class="btn btn-success btn-block ml-1">حفظ</button>
                                    <a class="btn btn-dark  btn-block m-0" data-dismiss="modal" style="color: #fff !important;">الغاء </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- end   --}}


                {{-- end School Year  --}}

                <div class="modal fade endSchoolYear">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="form_delete" action="{{ route('end_school_year') }}" method="POST" autocomplete="off">

                                @csrf

                                <div class="modal-header" >
                                    <h4 class="modal-title" style="color: rgb(226, 27, 27)">إغلاق العام الدراسي الحالي</h4>
                                    <button type="button" class="close"
                                    style="color: rgb(241, 30, 47)" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <br>

                                    <div class="form-group" style="text-align:right">
                                        <label>    العام الدراسي التالي</label>
                                        <select name="next_year_id" id="" class="form-control lesson_id"
                                            style="min-height: 36px;direction: rtl">
                                            <option value="{{ $next_year->id }}">{{ $next_year->name }} </option>
                                        </select>

                                    </div>

                                    <div class="form-group" style="text-align:right">
                                        <label style="font-size: 18px; font-weight:bold"> أدخل كود  التأكيد  </label>


                                        <input type="password" style="direction:rtl" id="delete_code" name="confirm_code" class="form-control a"
                                            value=""
                                            placeholder="أدخل كود التأكيد  "  required>
                                    </div>

                                </div>
                                <div class="modal-footer" style="justify-content: right;">
                                    <button class="btn btn-success btn-block ml-1">حفظ</button>
                                    <a class="btn btn-dark  btn-block m-0" data-dismiss="modal" style="color: #fff !important;">الغاء </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- end School Year  --}}


<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>

@endsection

@section('js')

<script>
$('.class_choosing').select2();


$('.alert-success').hide(5000);


$(document).ready(function () {

$('.delete').on('click', function () {

    var id = $(this).data('id');
    var url = "{{URL::to('SMARMANger/admin/students')}}";
    $('#form_delete').attr("action", url);

});



$('.graduate').on('click', function () {
    var id = $(this).data('id');
    var name=$(this).data('name');

    $('.class_id').val(id);
    $('.class_name').val(name);

});
$('.freeze').on('click', function () {
    var id = $(this).data('id');
    var name=$(this).data('name');

    $('.class_id').val(id);
    $('.class_name').val(name);

});
$(document).on('click', '.delete2', function () {
    var id = $(this).data('id');
    var name=$(this).data('name');

    $('#name_delete').val(name);
    $('#class_id_delete').val(id);
});


});
</script>

<script>


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


        $(document).on('click' , '.del_img' , function () {
            $(this).nextAll('.output').attr('style','display:none;');
            $(this).prevAll('.input_image:first').val('');
            $(this).hide();

        });

        $(document).on('click' , '.del_icon' , function () {
            $(this).prevAll('.del:first').attr('disabled',false );
            $(this).prevAll('.del_edit_img:first').hide();
            $(this).hide();

        });


  </script>

@endsection
