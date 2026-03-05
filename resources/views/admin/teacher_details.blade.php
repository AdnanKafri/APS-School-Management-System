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
    <a class="breadcrumbs__item is-active "> تعديل مدرس  </a>
    <a href="{{ route('teachers') }}" class="breadcrumbs__item ">    المدرسين    </a>
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
                    <div class="col-7">
                        <h2 class="mb-0" style="color: #001586"> تعديل مدرس  </h2>
                    </div>
                    <!--<div class="col-6 text-right">-->
                    <!--  <span  class="btn btn-lg btn-primary">-->

                    <!--      @if ($teacher->place=='inside')-->
                    <!--      داخلي-->
                    <!--      @else-->
                    <!--      خارجي-->
                    <!--      @endif-->
                    <!--  </span>-->

                    <!--  <span  class="btn btn-lg btn-warning">-->

                    <!--      @if ($teacher->transparent=='new')-->
                    <!--      قديم-->
                    <!--      @else-->
                    <!--      منقول-->
                    <!--      @endif-->
                    <!--  </span>-->
                    <!--</div>-->
                </div>
            </div>






            <div class="card-body" style="text-align:right">
              <form action="{{ route('teacher_update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="text" name="teacher_id" id="edit_teacher_id" hidden value='{{$teacher->id}}'>
                <div class="modal-header">
                    <h2 class="modal-title" id="exampleModalLabel">تعديل معلومات مدرس</h2>

                </div>
                <div class="modal-body">
                        <div class="form-group">
                            <label>الاسم الأول</label>
                            <input type="text" name="first_name"   value="{{$teacher->first_name}}"  id="edit_first_name" class="form-control a" placeholder="اكتب اسمك الأول" maxlength="30" style="direction:rtl" required="">
                        </div>

                        <div class="form-group">
                            <label>الكنية</label>
                            <input type="text" name="last_name" id="edit_last_name" class="form-control b" value="{{$teacher->last_name}}" placeholder="اكتب الكنية" maxlength="30" style="direction:rtl" required="">
                        </div>


                        <div class="form-group">
                            <label>تاريخ الولادة</label>
                            <input type="date" name="date_birth" id="edit_date_birth" class="form-control b" value="{{$teacher->date_birth}}" style="direction:rtl" placeholder="Type last name">
                        </div>

                        <div class="form-group">
                            <label>العنوان</label>
                            <input type="text" name="address" id="edit_address" class="form-control b" value="{{$teacher->address}}" maxlength="100" placeholder="اكتب العنوان" style="direction:rtl">
                        </div>

                        <div class="form-group">
                            <label>الهاتف</label>
                            <input type="text" name="phone" id="edit_phone" class="form-control b" value="{{$teacher->phone}}" placeholder="اكتب رقم الهاتف" style="direction:rtl" maxlength="20" >
                        </div>
                        <div class="form-group">
                            <label>الراتب</label>
                            <input type="number" name="salary" id="edit_salary" class="form-control b" value="{{$teacher->salary}}" placeholder="ادخل الراتب "  style="direction:rtl">
                        </div>

                        <div class="form-group">
                            <label>اسم المادة</label>
                            <input type="text" name="lesson_name" id="edit_lesson_name" class="form-control b" value="{{$teacher->lesson_name}}" placeholder="اكتب اسم المادة " style="direction:rtl" maxlength="20" required="">
                        </div>
                           <div class="form-group" style="text-align:right">
                                        <label>عقد العمل</label>
                                         <select name="contract" id="edit_contract" class="form-control"
                                            style="min-height: 36px;direction: rtl" >
                                            <option value="{{$teacher->contract}}" hidden>          @if ($teacher->contract == 'annual')
                                             عقد سنوي
                                            @else
                                                عقد شهري
                                            @endif     </option>

                                                <option value="monthly">شهري</option>
                                                <option value="annual"> سنوي</option>

                                        </select>
                                    </div>
                        <div class="form-group">
                            <label> عدد أيام الأجازات</label>
                            <input type="number" name="vcation_days" id="edit_lesson_name" class="form-control b" value="{{$teacher->vcation_days}}" min="0" placeholder="اكتب عدد أيام الإجازة " style="direction:rtl" maxlength="20" required="">
                        </div>

                        <div class="form-group">
                            <label>البريد الإلكتروني</label>
                            <input type="email" name="email" id="edit_email" class="form-control b email" value="{{$teacher->email}}" maxlength="50" placeholder="اكتب البريد الالكتروني " >
                            <span class="text-danger error validate_email"></span>
                        </div>
   <label for="" style="float: right;">كلمة المرور الجديدة</label>
                        <br>
                        <small id="alert" style="color: #f00;"></small>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                            </div>
                            <input name="password" id="password" type="password" class="input form-control" placeholder="اكتب كلمة المرور" aria-label="password" aria-describedby="basic-addon1">
                        </div>

                        <label style="float: right;">تأكيد كلمة المرور</label>
                        <br>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                            </div>
                            <input name="password_confirmation" id="password_confirmation" type="password" class="input form-control" placeholder="أعد كتابة كلمة المرور" aria-label="password_confirmation" aria-describedby="basic-addon1">
                        </div>

                        <div class="form-group">

                                <label for="edit_image">صورة المدرس</label>
                                @if (isset($teacher->image))
                                <a href="{{ asset('storage/'.$teacher->image)}}" download="{{ $teacher->first_name }} {{ $teacher->last_name }}.jpg">
                                 <img src="{{ asset('storage/'.$teacher->image) }}"
                                       class="del_edit_img rounded-circle" id="image6" alt="Not found" width="100" alt="">
                                   </a>


                                 @endif
                                <input type="file" name="image" id="edit_image" class="form-control" lang="ar">
                        </div>


                        @foreach ( $teacher_details_departments as  $teacher_details_department)
                        <hr class="my-4">
                        <!-- Address -->
                        <h6 class="heading-small text-muted mb-4"> {{ $teacher_details_department->name}}</h6>
                        <div class="pl-lg-4">
                            <div class="row">

                                @foreach ( $teacher_details_department->teacher_details_department_field as  $teacher_details_department_field)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        @if($teacher_details_department_field->type ==1)

                                        <label class="form-control-label" for="input-country"> {{$teacher_details_department_field->name}}   </label>
                                        @if (count($teacher_details_department_field->teacher_details_field_value)>0)
                                        <input type="text" id="" name="val[{{$teacher_details_department_field->id}}]" class="form-control"
                                            value="{{$teacher_details_department_field->teacher_details_field_value[0]->value}}">
                                            @else
                                            <input type="text" id="" name="val[{{$teacher_details_department_field->id}}]" class="form-control"
                                            value="">
                                            @endif
                                        @elseif ($teacher_details_department_field->type ==2)
                                        <label class="form-control-label" for="input-country"> {{$teacher_details_department_field->name}}   </label>
                                        @if (count($teacher_details_department_field->teacher_details_field_value)>0)
                                        <input type="date" id="input-phone" name="val[{{$teacher_details_department_field->id}}]" class="form-control"
                                            value="{{$teacher_details_department_field->teacher_details_field_value[0]->value}}">
                                            @else
                                            <input type="date" id="input-phone" name="val[{{$teacher_details_department_field->id}}]" class="form-control"
                                            value="">
                                            @endif
                                            @elseif ($teacher_details_department_field->type ==3)

                                        <label class="form-control-label" for="input-country"> {{$teacher_details_department_field->name}}   </label>
                                        <br>
                                        @foreach ( json_decode($teacher_details_department_field->type_radio) as  $type_radio)


                                        <label class="form-control-label" for="{{$type_radio}}"> {{$type_radio}}   </label>
                                        @if (count($teacher_details_department_field->teacher_details_field_value)>0)
                                        @if($teacher_details_department_field->teacher_details_field_value[0]->value == $type_radio)
                                        <input type="radio" id="{{$type_radio}}" checked  name="val[{{$teacher_details_department_field->id}}]" class=""
                                            value="{{$type_radio}}">
                                            @else
                                            <input type="radio" id="{{$type_radio}}"  name="val[{{$teacher_details_department_field->id}}]" class=""
                                            value="{{$type_radio}}">
                                            @endif

                                            @else
                                            <input type="radio" id="{{$type_radio}}"  name="val[{{$teacher_details_department_field->id}}]" class=""
                                            value="{{$type_radio}}">
                                            @endif
                                        @endforeach
                                            @elseif ($teacher_details_department_field->type ==4)
                                            @if (isset($teacher_details_department_field->teacher_details_field_value[0]->value))
                                            <a href="{{ asset('storage/'.$teacher_details_department_field->teacher_details_field_value[0]->value) }}" download="{{ $teacher->first_name }} {{ $teacher->last_name }}.jpg">
                                             <img src="{{ asset('storage/'.$teacher_details_department_field->teacher_details_field_value[0]->value) }}"
                                                   class="del_edit_img rounded-circle" id="image6" alt="Not found" width="100" alt="">
                                               </a>


                                             @endif
                                            <label class="form-control-label" for="input-country"> {{$teacher_details_department_field->name}}   </label>
                                        <input type="file" id="input-phone" name="val[{{$teacher_details_department_field->id}}]" class="form-control"
                                            value="">
                                        @endif


                                    </div>



                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                </div>
                <div class="modal-footer" style="text-align: right;direction: rtl;display: block;">
                    <a type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</a>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </form>
            </div>





        </div>
    </div>
    <div class="col-xl-1 col-lg-1 col-12"></div>


</div>



<script src="{{ asset('teachers/js/jquery-3.2.1.min.js') }}"></script>








@endsection
