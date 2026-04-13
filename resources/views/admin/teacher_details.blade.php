@extends('admin.layouts.v2')

@section('page_title', 'تفاصيل المدرس')
@section('page_subtitle', 'تعديل البيانات والملفات المرتبطة بالمدرس')

@section('style')
<style>
    .v2-shell .v2-sidebar .v2-menu-title,
    .v2-shell .v2-sidebar .v2-menu-link,
    .v2-shell .v2-sidebar .v2-menu-link span,
    .v2-shell .v2-sidebar .v2-sub-link,
    .v2-shell .v2-sidebar .v2-sidebar-brand div,
    .v2-shell .v2-navbar .v2-navbar-brand-ar,
    .v2-shell .v2-navbar .v2-navbar-brand-en,
    .v2-shell .v2-navbar .v2-navbar-page span,
    .v2-shell .v2-navbar .v2-user-btn,
    .v2-shell .v2-navbar .v2-user-name,
    .v2-shell .v2-navbar .dropdown-item,
    .v2-shell .v2-navbar .v2-nav-icon-btn,
    .v2-shell .v2-navbar .v2-dropdown-item {
        color: inherit !important;
    }

    .v2-content-wrap > .v2-card .breadcrumbs__item,
    .v2-content-wrap > .v2-card .breadcrumbs__item.is-active {
        color: #2f2b3a !important;
    }

    .v2-content-wrap > .v2-card:first-of-type {
        margin-bottom: 1.5rem !important;
    }

    .v2-content-wrap > .v2-card:first-of-type > div {
        padding: 1rem 1.25rem !important;
        gap: 1rem;
        align-items: flex-start !important;
    }

    .v2-content-wrap > .v2-card:first-of-type .breadcrumbs {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start;
        gap: .45rem;
    }

    .teacher-details-breadcrumbs {
        font-size: .9rem;
        align-items: center;
        gap: .35rem;
    }

    .teacher-details-breadcrumbs .breadcrumbs__item {
        font-weight: 700;
    }

    .teacher-details-breadcrumbs a.breadcrumbs__item {
        color: #8a869a !important;
    }

    .teacher-details-breadcrumbs .breadcrumbs__item.is-active {
        color: #2f2b3a !important;
    }

    .teacher-details-breadcrumbs__sep {
        color: #b2aec0;
        font-weight: 700;
    }

    .v2-navbar #v2-sidebar-toggle {
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
    }

    .teacher-details-v2,
    .teacher-details-v2 * {
        direction: rtl;
    }

    .teacher-details-v2 {
        text-align: right;
    }

    html[dir="ltr"] .teacher-details-v2,
    html[dir="ltr"] .teacher-details-v2 * {
        direction: ltr;
        text-align: left;
    }

    .teacher-details-v2 .alert {
        border-radius: 18px;
        font-size: 1rem;
        margin-bottom: 1rem;
    }

    .teacher-details-v2 > .row {
        margin: 0;
    }

    .teacher-details-v2 > .row > .col-xl-1,
    .teacher-details-v2 > .row > .col-lg-1 {
        display: none;
    }

    .teacher-details-v2 > .row > .col-xl-10,
    .teacher-details-v2 > .row > .col-lg-10 {
        flex: 0 0 100%;
        max-width: 100%;
        padding: 0;
    }

    .teacher-details-v2 .card {
        margin: 0;
        border-radius: 22px;
        border: 1px solid rgba(91, 75, 138, 0.12);
        box-shadow: 0 18px 40px rgba(36, 30, 62, 0.08);
        overflow: hidden;
        background: #fff;
    }

    .teacher-details-v2 .card-header {
        display: none;
    }

    .teacher-details-v2 .card-body {
        padding: 0 !important;
        text-align: inherit !important;
        background: linear-gradient(180deg, rgba(91, 75, 138, 0.04), rgba(91, 75, 138, 0));
    }

    .teacher-details-v2 .modal-header {
        border: 0;
        padding: 1.5rem 1.5rem .5rem;
        align-items: center;
    }

    .teacher-details-v2 .modal-title {
        font-size: 1.3rem;
        font-weight: 800;
        color: #2f2b3a;
    }

    .teacher-details-v2 .modal-body {
        padding: 1rem 1.5rem 1.5rem;
        text-align: inherit;
    }

    .teacher-details-v2 .modal-footer {
        border: 0;
        padding: 1rem 1.5rem 1.5rem;
        display: flex;
        justify-content: flex-start;
        gap: .75rem;
        flex-wrap: wrap;
    }

    .teacher-details-v2 .form-group {
        direction: inherit !important;
        text-align: inherit !important;
        margin-bottom: 1rem;
    }

    .teacher-details-v2 label,
    .teacher-details-v2 .pl-lg-4 label {
        font-size: 1rem;
        font-weight: 700;
        color: #2f2b3a !important;
    }

    .teacher-details-v2 .form-control,
    .teacher-details-v2 .input-group-text {
        min-height: 44px;
        border-radius: 12px;
    }

    .teacher-details-v2 .form-control {
        border-color: rgba(91, 75, 138, 0.18);
        box-shadow: none;
    }

    .teacher-details-v2 .form-control:focus {
        border-color: #5B4B8A;
        box-shadow: 0 0 0 .2rem rgba(91, 75, 138, 0.14);
    }

    .teacher-details-v2 .input-group-text {
        background: #f7f5fc;
        border-color: rgba(91, 75, 138, 0.18);
    }

    .teacher-details-v2 .heading-small {
        text-align: right !important;
        color: #5B4B8A !important;
        font-size: 1rem;
        font-weight: 800;
        margin-bottom: 1rem !important;
    }

    html[dir="ltr"] .teacher-details-v2 .heading-small {
        text-align: left !important;
    }

    .teacher-details-v2 .pl-lg-4 {
        padding-inline-start: 0 !important;
    }

    .teacher-details-v2 .del_edit_img {
        width: 110px;
        height: 110px;
        object-fit: cover;
        border: 4px solid rgba(91, 75, 138, 0.12);
        margin-bottom: .75rem;
    }

    .teacher-details-v2 .btn {
        border-radius: 12px;
        min-width: 124px;
        font-weight: 700;
    }

    .teacher-details-v2 .btn-primary {
        background: #5B4B8A;
        border-color: #5B4B8A;
    }

    .teacher-details-v2 .btn-primary:hover {
        background: #4d3f77;
        border-color: #4d3f77;
    }

    .teacher-details-v2 .custom-file-label {
        display: none;
    }

    #v2-shell.teacher-sidebar-collapsed .v2-sidebar {
        width: 88px;
    }

    html[dir="ltr"] #v2-shell.teacher-sidebar-collapsed .v2-main {
        margin-left: 88px;
    }

    html[dir="rtl"] #v2-shell.teacher-sidebar-collapsed .v2-main {
        margin-right: 88px;
    }

    #v2-shell.teacher-sidebar-collapsed .v2-sidebar-brand {
        justify-content: center !important;
        padding-inline: .75rem;
    }

    #v2-shell.teacher-sidebar-collapsed .v2-sidebar-brand .d-flex.align-items-center > div:last-child,
    #v2-shell.teacher-sidebar-collapsed .v2-menu-title,
    #v2-shell.teacher-sidebar-collapsed .v2-menu-link span,
    #v2-shell.teacher-sidebar-collapsed .v2-submenu,
    #v2-shell.teacher-sidebar-collapsed .v2-menu-toggle .fa-chevron-down {
        display: none !important;
    }

    #v2-shell.teacher-sidebar-collapsed .v2-sidebar-menu {
        padding-inline: .4rem;
    }

    #v2-shell.teacher-sidebar-collapsed .v2-menu-link {
        justify-content: center;
        padding-inline: .5rem;
        min-height: 48px;
    }

    #v2-shell.teacher-sidebar-collapsed .v2-menu-link i:first-child {
        margin-inline: 0;
    }

    #v2-shell.teacher-sidebar-collapsed .v2-menu-link.active {
        border-inline-start: 0;
        box-shadow: inset 0 0 0 1px rgba(59,130,246,0.15);
    }

    @media (max-width: 991.98px) {
        .teacher-details-v2 .modal-body,
        .teacher-details-v2 .modal-footer,
        .teacher-details-v2 .modal-header {
            padding-inline: 1rem;
        }

        .teacher-details-v2 .btn {
            width: 100%;
        }
    }
</style>
@endsection

@section('breadcrumbs')
<nav class="breadcrumbs teacher-details-breadcrumbs" aria-label="Breadcrumb">
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item">لوحة التحكم</a>
    <span class="teacher-details-breadcrumbs__sep" aria-hidden="true">/</span>
    <a href="{{ route('teachers') }}" class="breadcrumbs__item">المدرسين</a>
    <span class="teacher-details-breadcrumbs__sep" aria-hidden="true">/</span>
    <span class="breadcrumbs__item is-active">تفاصيل المدرس</span>
</nav>
@endsection

@section('content')
<div class="teacher-details-v2">
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








</div>
@endsection

@section('js')
<script>
(function() {
    var shell = document.getElementById('v2-shell');
    var toggle = document.getElementById('v2-sidebar-toggle');
    if (!shell || !toggle) return;

    toggle.classList.remove('d-lg-none');

    var media = window.matchMedia('(min-width: 993px)');
    var storageKey = 'teachersSidebarCollapsed';

    function syncSidebarState() {
        if (media.matches) {
            if (window.localStorage.getItem(storageKey) === '1') {
                shell.classList.add('teacher-sidebar-collapsed');
            } else {
                shell.classList.remove('teacher-sidebar-collapsed');
            }
            shell.classList.remove('sidebar-open');
        } else {
            shell.classList.remove('teacher-sidebar-collapsed');
        }
    }

    toggle.addEventListener('click', function(e) {
        if (!media.matches) return;
        e.preventDefault();
        e.stopImmediatePropagation();
        shell.classList.toggle('teacher-sidebar-collapsed');
        window.localStorage.setItem(storageKey, shell.classList.contains('teacher-sidebar-collapsed') ? '1' : '0');
    }, true);

    if (media.addEventListener) {
        media.addEventListener('change', syncSidebarState);
    } else if (media.addListener) {
        media.addListener(syncSidebarState);
    }

    syncSidebarState();
})();
</script>
@endsection
