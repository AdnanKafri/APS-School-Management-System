@extends('admin.master')
@section('style')
<style>
    * {
        direction: rtl !important;
    }

    .form-group {
        direction: rtl !important;
        text-align: right;
    }

    .heading-small {
        text-align: center !important;
        color: #001586 !important;
        font-size: 20px
    }
</style>
<style>
    .custom-file-label {
        display: none;
    }

    .pl-lg-4 label {
        font-size: 20px;
        font-weight: 600;
        color: black !important;
    }
</style>
@endsection


@section('breadcrumbs')

<nav class="breadcrumbs">
    <a class="breadcrumbs__item is-active ">اضافة معلومات الوثيقة </a>
    {{-- <a href="{{ route('basic_document') }}" class="breadcrumbs__item "> الطلاب </a> --}}
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>

@endsection

@section('content')

@if(session()->has('success'))

<div class="alert alert-success alert-dismissible" role="alert" style="text-align: right; font-size: 30px">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
    {{ session()->get('success') }}
</div>
@endif



<div class="row">





    <div class="col-xl-1 col-lg-1 col-12"></div>
    <div class="col-xl-10 col-lg-10 col-12">
        <div class="card" style="margin: 30px">
            <div class="card-header">
                <div class="row align-items-center">
                    {{-- <div class="col-7">
                        <h2 class="mb-0" style="color: #001586"> تعديل طالب </h2>
                    </div> --}}
                    <!--<div class="col-6 text-right">-->
                    <!--  <span  class="btn btn-lg btn-primary">-->

                    <!--      @if ($student->place=='inside')-->
                    <!--      داخلي-->
                    <!--      @else-->
                    <!--      خارجي-->
                    <!--      @endif-->
                    <!--  </span>-->

                    <!--  <span  class="btn btn-lg btn-warning">-->

                    <!--      @if ($student->transparent=='new')-->
                    <!--      قديم-->
                    <!--      @else-->
                    <!--      منقول-->
                    <!--      @endif-->
                    <!--  </span>-->
                    <!--</div>-->
                </div>
            </div>






            <div class="card-body" style="text-align:right">
                <form method="post" action="{{ route('student_update_secoundry_transfer_document',$student->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('post')
                    <h5 class="heading-small text-muted mb-4" style="font-size: 30px">اضافة معلومات وثيقة انتقال {{ $student->first_name }} {{ $student->last_name }}</h5>
                    <div class="pl-lg-4">

                      <input type="text" name="room_id" value="{{ $rooms->id }}" hidden>
                      <input type="text" name="first_name" value="{{ $student->first_name }}" hidden>
                      <input type="text" name="last_name" value="{{ $student->last_name }}" hidden>
                      <input type="text" name="last_name_en" value="{{ $student->last_name_en }}" hidden>
                      <input type="text" name="first_name_en" value="{{ $student->first_name_en }}" hidden>
                      <input type="text" name="email" value="{{ $student->user->email }}" hidden>

                      <input type="text" name="public_record_number" value="{{ $student->public_record_number }}" hidden>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                <label>الرقم</label>
                                <input type="number" name="number_document"  id="number_document"  class="form-control a" style="direction:rtl"
                                value="{{ $student_detail->number_document}}"
                                    maxlength="20" placeholder=" " >
                            </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                <label>رقم الوثيقة</label>
                                <input type="text" name="number_file"  id="number_file"  class="form-control a" style="direction:rtl"
                                value="{{ $student_detail->number_file}}"
                                    maxlength="20" placeholder=" " >
                            </div>
                            </div>

                             <div class="col-lg-12">
                                <div class="form-group">
                                <label>  وضعه بالنسبة للتعاون</label>
                                <input type="text" name="status_cooperation"  id="status_cooperation"
                                class="form-control a" style="direction:rtl" value="{{ $student_detail->status_cooperation}}"
                                 placeholder="" >
                            </div>
                             </div>



                             <div class="col-lg-12">
                                <div class="form-group">
                                <label>المحافظة التي النتقل اليها</label>
                                <input type="text" name="transfer_country"  id="transfer_country"
                                 class="form-control a" style="direction:rtl" value="{{$student_detail->transfer_country}}"
                                     placeholder=" " >
                            </div>
                             </div>
                             <div class="col-lg-12">
                                <div class="form-group">
                                <label>المدرسة التي انتقل إليها</label>
                                <input type="text" name="transfer_school"  id="transfer_school" class="form-control a"
                                style="direction:rtl" value="{{$student_detail->transfer_school}}"
                                placeholder=" " >
                            </div>
                             </div>
                             <div class="col-lg-12">
                                <div class="form-group">
                                <label> مدير المدرسة</label>
                                <input type="text" name="head_teacher" id="head_teacher"   class="form-control a"
                                style="direction:rtl" value="{{$student_detail->head_teacher}}"
                                     >
                            </div>
                             </div>
                             <div class="col-lg-12">
                                <div class="form-group">
                                <label> تاريخ ارسال الاستمارة</label>
                                <input type="date" name="date_seend"  id="date_seend"  class="form-control a"
                                style="direction:rtl" value="{{$student_detail->date_seend}}"
                                   >
                            </div>
                             </div>

                             <div class="col-lg-12">
                                <div class="form-group">
                                <label>أمين السر</label>
                                <input type="text" name="secret_keeper"  id="secret_keeper" class="form-control a"
                                 style="direction:rtl" value="{{$student_detail->secret_keeper}}"
                                     >
                            </div>
                             </div>

                             <div class="col-lg-12">
                                <div class="form-group">
                                <label>الفرع</label>
                                <input type="text" name="branch"  id="branch" class="form-control a"
                                 style="direction:rtl" value="{{$student_detail->branch}}"
                                   >
                            </div>
                             </div>

                             <div class="col-lg-12">
                                <div class="form-group">
                                <label>السلوك</label>
                                <input type="text" name="behavior"  id="behavior" class="form-control a"
                                 style="direction:rtl" value="{{$student_detail->behavior}}"
                                  placeholder=" " >
                            </div>
                             </div>
                             <div class="col-lg-12">
                                <div class="form-group">
                                <label>أيام الغياب المبررة</label>
                                <input type="text" name="days_absence"  id="days_absence" class="form-control a"
                                style="direction:rtl" value="{{$student_detail->days_absence}}"
                                placeholder=" " >
                            </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                <label>أيام الغياب الغير مبررة</label>
                                <input type="text" name="days_unabsence"  id="days_unabsence" class="form-control a"
                                style="direction:rtl" value="{{$student_detail->days_unabsence}}"
                                placeholder=" " >
                            </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                <label>تاريخ تركه للمدرسة</label>
                                <input type="date" name="leaving_school"  id="leaving_school" class="form-control a"
                                style="direction:rtl" value="{{$student_detail->leaving_school}}"
                                placeholder=" " >
                            </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                <label>أيام الدوام</label>
                                <input type="number" name="working_days"  id="working_days" class="form-control a"
                                style="direction:rtl" value="{{$student_detail->working_days}}"
                                placeholder=" " >
                            </div>
                            </div>


                </div>
                    <button class="btn btn-success btn-block "
                        style="background: #6ABAA3;border-color: #6ABAA3;color: white">تحديث </button>
                </form>
            </div>





        </div>
    </div>
    <div class="col-xl-1 col-lg-1 col-12"></div>


</div>

<script src="{{ asset('students/js/jquery-3.2.1.min.js') }}"></script>

@endsection
