@extends('admin.layouts.v2')

@section('page_title', 'المدرسين')
@section('page_subtitle', 'إدارة بيانات المدرسين والجداول')

@section('style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">

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

    .v2-content-wrap > .v2-card:first-of-type h5 {
        margin-bottom: .35rem !important;
        font-size: 1.35rem;
    }

    .v2-content-wrap > .v2-card:first-of-type small {
        display: inline-block;
        max-width: 40rem;
        color: #7b768f !important;
        line-height: 1.7;
    }

    .v2-content-wrap > .v2-card:first-of-type .breadcrumbs {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start;
        gap: .45rem;
    }

    .teacher-breadcrumbs {
        font-size: .9rem;
        align-items: center;
        gap: .35rem;
    }

    .teacher-breadcrumbs .breadcrumbs__item {
        font-weight: 700;
    }

    .teacher-breadcrumbs a.breadcrumbs__item {
        color: #8a869a !important;
    }

    .teacher-breadcrumbs .breadcrumbs__item.is-active {
        color: #2f2b3a !important;
    }

    .teacher-breadcrumbs__sep {
        color: #b2aec0;
        font-weight: 700;
    }

    .v2-navbar #v2-sidebar-toggle {
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
    }

    body .modal-backdrop {
        z-index: 2000 !important;
    }

    body .modal {
        z-index: 2010 !important;
    }

    body .modal-dialog {
        margin: 1.75rem auto;
    }

    .v2-main,
    .v2-content-wrap,
    .teacher-index-v2 {
        overflow: visible !important;
    }

    .teacher-index-v2 {
        direction: rtl;
        text-align: right;
    }

    html[dir="ltr"] .teacher-index-v2 {
        direction: ltr;
        text-align: left;
    }

    .teacher-index-v2 .btn,
    .teacher-index-v2 .btn:hover,
    .teacher-index-v2 .btn:focus {
        color: #fff !important;
    }

    .teacher-index-v2 .form-group {
        text-align: right;
        margin: 0 !important;
    }

    .teacher-index-v2 label {
        font-size: 18px;
        color: #2f2b3a;
    }

    .teacher-index-v2 input {
        font-size: 16px !important;
    }

    .teacher-index-v2 a.page-link {
        color: #7571f9 !important;
    }

    .teacher-index-v2 .pagination {
        justify-content: center;
    }

    .teacher-index-v2 .dropdown-item {
        color: #2f2b3a !important;
        width: auto !important;
        border-radius: 10px;
        padding: .55rem .75rem;
    }

    .teacher-index-v2 .dropdown-item:hover {
        background: rgba(91, 75, 138, 0.08);
    }

    .teacher-index-v2 img {
        border-radius: 50%;
    }

    .teacher-index-v2 .teacher-panel {
        margin: 0;
        border-radius: 22px;
        border: 1px solid rgba(91, 75, 138, 0.12);
        box-shadow: 0 18px 40px rgba(36, 30, 62, 0.08);
        overflow: hidden;
    }

    .teacher-index-v2 .teacher-panel .card-body {
        padding: 1.5rem;
        text-align: right !important;
        background: linear-gradient(180deg, rgba(91, 75, 138, 0.04), rgba(91, 75, 138, 0));
    }

    .teacher-index-v2 .teacher-panel__toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
        margin-bottom: .75rem;
    }

    .teacher-index-v2 .teacher-panel__controls {
        display: flex;
        align-items: center;
        gap: 12px;
        flex: 1 1 720px;
        flex-wrap: wrap;
        min-width: 0;
        justify-content: flex-start;
    }

    .teacher-index-v2 .teacher-panel__filters {
        margin-bottom: 0;
        display: flex;
        align-items: center;
        gap: 12px;
        flex: 1 1 420px;
        flex-wrap: wrap;
        min-width: 0;
    }

    .teacher-index-v2 .teacher-panel__filters .form-control {
        flex: 0 1 220px;
    }

    .teacher-index-v2 .teacher-panel__actions {
        display: flex;
        align-items: center;
        gap: .75rem;
        flex: 0 0 auto;
        justify-content: flex-start;
    }

    .teacher-index-v2 .teacher-panel__actions .btn {
        min-height: 44px;
        white-space: nowrap;
        border-radius: 12px;
        font-weight: 700;
        padding: .72rem 1.15rem;
    }

    .teacher-index-v2 .teacher-panel__search {
        flex: 1 1 260px;
        min-width: 220px;
        max-width: 360px;
    }

    .teacher-index-v2 .teacher-panel__search .dataTables_filter {
        margin: 0;
    }

    .teacher-index-v2 .teacher-panel__search .dataTables_filter label {
        display: block;
        margin: 0;
        font-size: 0;
    }

    .teacher-index-v2 .teacher-panel__search .dataTables_filter input {
        width: min(340px, 100%);
        min-height: 44px;
        margin: 0;
        border-radius: 10px;
        border: 1px solid rgba(91, 75, 138, 0.16);
        padding: .35rem .65rem;
    }

    .teacher-index-v2 .form-control {
        min-height: 44px;
        border-radius: 12px;
        border-color: rgba(91, 75, 138, 0.18);
        box-shadow: none;
    }

    .teacher-index-v2 .form-control:focus {
        border-color: #5B4B8A;
        box-shadow: 0 0 0 .2rem rgba(91, 75, 138, 0.14);
    }

    .teacher-index-v2 .table-responsive {
        margin-top: 1rem;
        overflow-x: auto !important;
        overflow-y: visible !important;
        border-radius: 18px;
        border: 1px solid rgba(91, 75, 138, 0.12);
        background: #fff;
    }

    .teacher-index-v2 .table {
        width: 100% !important;
        margin-bottom: 0;
    }

    .teacher-index-v2 th {
        font-size: 1rem;
        font-weight: 800;
        text-align: center !important;
        border-bottom: 1px solid rgba(91, 75, 138, 0.14) !important;
        padding: 1rem .75rem !important;
        color: #2f2b3a;
        background: #f9f7fe;
    }

    .teacher-index-v2 td {
        font-size: 16px;
        color: #3f3a52;
        text-align: center;
        border-bottom: 1px solid rgba(91, 75, 138, 0.1) !important;
        padding: 1rem .75rem !important;
        vertical-align: middle;
    }
    .teacher-index-v2 #table_xx td:last-child,
    .teacher-index-v2 #table_xx th:last-child {
        min-width: 132px;
    }

    .teacher-index-v2 .teacher-actions-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(48px, 1fr));
        gap: 6px;
        min-width: 108px;
        max-width: 132px;
        margin-inline: auto;
    }

    .teacher-index-v2 .teacher-action-btn {
        min-height: 42px;
        min-width: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        padding: .5rem;
        font-size: 16px !important;
        text-decoration: none !important;
        transition: transform .2s ease, box-shadow .2s ease, background-color .2s ease;
    }

    .teacher-index-v2 .teacher-action-btn.btn {
        color: #fff !important;
    }

    .teacher-index-v2 .teacher-action-btn.delete {
        background: rgba(175, 104, 110, 0.12);
        border: 1px solid rgba(175, 104, 110, 0.18);
    }

    .teacher-index-v2 .teacher-action-btn.delete i {
        color: #af686e !important;
        font-size: 18px;
    }

    .teacher-index-v2 .teacher-action-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 18px rgba(36, 30, 62, 0.12);
    }

    .teacher-index-v2 #table_xx_wrapper {
        overflow: visible;
    }

    .teacher-index-v2 .dataTables_wrapper {
        padding: .5rem 1rem .75rem;
    }

    .teacher-index-v2 .dataTables_wrapper .dataTables_length,
    .teacher-index-v2 .dataTables_wrapper .dataTables_filter,
    .teacher-index-v2 .dataTables_wrapper .dataTables_info,
    .teacher-index-v2 .dataTables_wrapper .dataTables_paginate {
        margin-bottom: .75rem;
    }

    .teacher-index-v2 .dataTables_wrapper .dataTables_filter {
        display: none;
    }

    .teacher-index-v2 .dataTables_wrapper .dataTables_paginate {
        padding-top: .5rem;
    }

    .teacher-index-v2 .modal-content {
        border: 0;
        border-radius: 18px;
        box-shadow: 0 24px 60px rgba(36, 30, 62, 0.16);
    }

    .teacher-index-v2 .modal-header,
    .teacher-index-v2 .modal-footer {
        border-color: rgba(91, 75, 138, 0.12);
    }

    .teacher-index-v2 .class_table th,
    .teacher-index-v2 .class_table td {
        padding: .9rem .75rem !important;
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
        .v2-content-wrap > .v2-card:first-of-type > div {
            padding: .95rem 1rem !important;
        }

        .teacher-index-v2 .teacher-panel .card-body {
            padding: 1rem;
        }

        .teacher-index-v2 .teacher-panel__toolbar {
            flex-direction: column;
            align-items: stretch;
        }

        .teacher-index-v2 .teacher-panel__controls,
        .teacher-index-v2 .teacher-panel__filters {
            flex: 1 1 auto;
            width: 100%;
        }

        .teacher-index-v2 .teacher-panel__actions {
            width: 100%;
            justify-content: stretch;
        }

        .teacher-index-v2 .teacher-panel__actions .btn {
            width: 100%;
        }

        .teacher-index-v2 .teacher-panel__search {
            width: 100%;
            max-width: none;
        }

        .teacher-index-v2 .teacher-panel__search .dataTables_filter input,
        .teacher-index-v2 .teacher-panel__filters .form-control {
            width: 100%;
            flex: 1 1 100%;
        }

        .teacher-index-v2 .teacher-actions-grid {
            grid-template-columns: repeat(2, minmax(44px, 1fr));
            max-width: 112px;
        }
    }
</style>
@endsection

@section('breadcrumbs')
<nav class="breadcrumbs teacher-breadcrumbs" aria-label="Breadcrumb">
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item">لوحة التحكم</a>
    <span class="teacher-breadcrumbs__sep" aria-hidden="true">/</span>
    <span class="breadcrumbs__item is-active">المدرسين</span>
</nav>
@endsection

@section('content')
<div class="teacher-index-v2">
@php
$about = \App\Other::find(1);
@endphp
  @php
        $school_data = \App\School_data::first();
        @endphp
    <div class="modal fade archiveModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="form_delete" action="{{ route('teacher_archive') }}" method="POST"  autocomplete="off">

                                @csrf
                                <input type="hidden" name="archive_id" id="archive_id" required>

                                <div class="modal-header" >
                                    <h4 class="modal-title" style="color: #f00"> ارشفة استاذ</h4>
                                    <button type="button" class="close"
                                    style="color: #f00" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">

                                    <div class="form-group" style="text-align:right">
                                           <label style="font-size: 18px; font-weight:bold">      هل انت متاكد من الارشفة  </label>


                                        <!--<input type="date" style="direction:rtl" id="date_archive" name="date_archive" class="form-control a"-->

                                        <!--      required>-->

                                    </div>

                                </div>
                                <div class="modal-footer" style="justify-content: right;">
                                    <a class="btn btn-dark" data-dismiss="modal">الغاء </a>
                                    <button class="btn btn-danger">حفظ</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

<div class="modal fade" id="user_name_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none; padding-right: 17px;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body" id="dvContainer">
                <div class="row">
                    <div class="col-lg-4 col-12" >
                        <img src="{{asset("storage/")}}/{{$school_data->logo}}" style="width: inherit;height: inherit;">
                    </div>
                    <div class="col-lg-8 col-12">
                        <div style="height: 5%"></div>
                        <div class="form-group" style="height: 30%">
                            <label for="" style="font-size: 30px;font-weight: 600;text-align: center;display: block;color: #001586">اسم المدرس </label>
                            <p style="color: black;font-size: 20px;display: block;text-align: center" id="name_share"></p>
                        </div>
                        <div class="form-group" style="height: 30%">
                            <label for="" style="font-size: 30px;font-weight: 600;text-align: center;display: block;color: #001586">اسم المستخدم </label>
                            <p style="color: black;font-size: 20px;display: block;text-align: center" id="username_share"></p>
                        </div>
                        <div class="form-group" style="height: 30%">
                            <label for="" style="font-size: 30px;font-weight: 600;text-align: center;display: block;color: #001586">كلمة المرور  </label>
                            <p style="color: black;font-size: 20px;display: block;text-align: center" id="pass_share"></p>
                        </div>
                        <div style="height: 5%"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="direction: rtl;justify-content: right;">
                <a class="btn btn-info ml-2" data-dismiss="modal">اغلاق</a>
                <a class="btn btn-success ml-2" id="screenshot">تنزيل</a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="classModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none; padding-right: 17px;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body" id="dvContainer">
                <div class="row">
                    <div class="col-lg-12 col-12" >
                        <table class="table align-items-center class_table " id="">
                            <thead style="color: black">
                                <tr>
                                    <th>
                                         الصف
                                    </th>
                                    <th>
                                         الشعبة
                                    </th>

                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
            <div class="modal-footer" style="direction: rtl;justify-content: right;">
                <a class="btn btn-info ml-2" data-dismiss="modal">اغلاق</a>

            </div>
        </div>
    </div>
</div>

  <div class="modal fade deletelessonModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="form_delete" action="{{ route('teacher_delete') }}" method="POST"  autocomplete="off">

                                @csrf
                                <input type="hidden" name="teacher_id_delete" id="lesson_id_delete" required>

                                <div class="modal-header" >
                                    <h4 class="modal-title" style="color: #f00">حذف استاذ</h4>
                                    <button type="button" class="close"
                                    style="color: #f00" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">

                                    <div class="form-group" style="text-align:right">
                                        <label style="font-size: 18px; font-weight:bold"> أدخل كود الحذف للتأكيد </label>


                                        <input type="password" style="direction:rtl" id="delete_code" name="delete_code" class="form-control a"

                                            placeholder="أدخل كود الحذف  "  required>
                                    </div>

                                </div>
                                <div class="modal-footer" style="justify-content: right;">
                                    <a class="btn btn-dark" data-dismiss="modal">الغاء </a>
                                    <button class="btn btn-danger">حفظ</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
<div class="modal fade" id="update_teacher" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none; padding-right: 17px;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('teacher_update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="text" name="teacher_id" id="edit_teacher_id" hidden>
                <div class="modal-header">
                    <h2 class="modal-title" id="exampleModalLabel">تعديل معلومات مدرس</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                        <div class="form-group">
                            <label>الاسم الأول</label>
                            <input type="text" name="first_name" id="edit_first_name" class="form-control a" value="" placeholder="اكتب اسمك الأول" maxlength="30" style="direction:rtl" required="">
                        </div>

                        <div class="form-group">
                            <label>الكنية</label>
                            <input type="text" name="last_name" id="edit_last_name" class="form-control b" value="" placeholder="اكتب الكنية" maxlength="30" style="direction:rtl" required="">
                        </div>


                        <div class="form-group">
                            <label>تاريخ الولادة</label>
                            <input type="date" name="date_birth" id="edit_date_birth" class="form-control b" value="" style="direction:rtl" placeholder="Type last name">
                        </div>

                        <div class="form-group">
                            <label>العنوان</label>
                            <input type="text" name="address" id="edit_address" class="form-control b" value="" maxlength="100" placeholder="اكتب العنوان" style="direction:rtl">
                        </div>

                        <div class="form-group">
                            <label>الهاتف</label>
                            <input type="text" name="phone" id="edit_phone" class="form-control b" value="" placeholder="اكتب رقم الهاتف" style="direction:rtl" maxlength="20" required="">
                        </div>
                        <div class="form-group">
                            <label>اسم المادة</label>
                            <input type="text" name="lesson_name" id="edit_lesson_name" class="form-control b" value="" placeholder="اكتب اسم المادة " style="direction:rtl" maxlength="20" required="">
                        </div>
                           <div class="form-group" style="text-align:right">
                                        <label>عقد العمل</label>
                                         <select name="contract" id="edit_contract" class="form-control"
                                            style="min-height: 36px;direction: rtl" >
                                            <option value="2" hidden> حدد  هل العقد شهري او سنوي     </option>

                                                <option value="1">شهري</option>
                                                <option value="2"> سنوي</option>

                                        </select>
                                    </div>
                        <div class="form-group">
                            <label> عدد أيام الأجازات</label>
                            <input type="number" name="vcation_days" id="edit_vcation_days" class="form-control b" value="" min="0" placeholder="اكتب عدد أيام الإجازة " style="direction:rtl" maxlength="20" required="">
                        </div>

                        <div class="form-group">
                            <label>البريد الإلكتروني</label>
                            <input type="email" name="email" id="edit_email" class="form-control b email" value="" maxlength="50" placeholder="اكتب البريد الالكتروني " >
                            <span class="text-danger error validate_email"></span>
                        </div>

                        <label for="" style="float: right;">كلمة المرور القديمة</label>
                        <br>
                        <small id="alert" style="color: #f00;"></small>


                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                            </div>
                            <input name="password" id="edit_password" type="password" value="" size="15" class="input form-control" id="password" placeholder="اكتب كلمة المرور"  aria-label="password" aria-describedby="basic-addon1">
                        </div>

                        <label  style="float: right;">تأكيد كلمة المرور</label>
                        <br>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                            </div>
                            <input name="password_confirmation" id="edit_password_confirmation" type="password" value="" size="15"  class="input form-control" id="password-confirm" placeholder="أعد كتابة كلمة المرور" aria-label="password" aria-describedby="basic-addon1">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                            </div>
                            <input name="password_confirmation" id="edit_password_confirmation" type="password" value="" size="15"  class="input form-control" id="password-confirm" placeholder="أعد كتابة كلمة المرور" aria-label="password" aria-describedby="basic-addon1">
                        </div>


                        <div class="form-group">
                            <label>الراتب</label>
                            <input type="number" name="salary" id="edit_salary" class="form-control b" value="" placeholder="ادخل الراتب "  style="direction:rtl">
                        </div>



                        <div class="form-group">
                                <label for="edit_image">صورة المدرس</label>
                                <input type="file" name="image" id="edit_image" class="form-control" lang="ar">
                        </div>
                </div>
                <div class="modal-footer" style="text-align: right;direction: rtl;display: block;">
                    <a type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</a>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="modal fade" id="create_teacher" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none; padding-right: 17px;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('teacher_store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h2 class="modal-title" id="exampleModalLabel">إنشاء مدرس</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>الإسم الأول بالعربية</label>
                        <input type="text" name="first_name" class="form-control a" style="direction:rtl"
                            value="" maxlength="20"
                            placeholder="الإسم الأول" required>
                    </div>

                    <div class="form-group">
                        <label>الكنية بالعربية</label>
                        <input type="text" name="last_name" class="form-control b"
                            value="" maxlength="20"style="direction:rtl"
                            placeholder="الكنية" required>
                    </div>
                    <div class="form-group">
                        <label>الإسم الأول بالانكليزية</label>
                        <input type="text" name="first_name_en" class="form-control a english_name" style="direction:rtl"
                            value="" maxlength="20"
                            placeholder="الإسم الأول" required>
                    </div>

                    <div class="form-group">
                        <label> الكنية بالانكليزية</label>
                        <input type="text" name="last_name_en" class="form-control b english_name"
                            value="" maxlength="20"style="direction:rtl"
                            placeholder="الكنية" required>
                    </div>
                        <div class="form-group">
                            <label>تاريخ الولادة</label>
                            <input type="date" lang="ar" name="date_birth" class="form-control b" value="" style="direction:rtl" placeholder="Type last name">
                        </div>

                        <div class="form-group">
                            <label>العنوان</label>
                            <input type="text" name="address" class="form-control b" value="" maxlength="100" placeholder="اكتب العنوان" style="direction:rtl">
                        </div>

                        <div class="form-group">
                            <label>الهاتف</label>
                            <input type="text" name="phone" class="form-control b" value="" placeholder="اكتب رقم الهاتف" style="direction:rtl" maxlength="20" required="">
                        </div>
                        <div class="form-group">
                            <label>اسم المادة</label>
                            <input type="text" name="lesson_name" class="form-control b" value="" placeholder="اكتب اسم المادة " style="direction:rtl" maxlength="20" required="">
                        </div>
                           <div class="form-group" style="text-align:right">
                                        <label>عقد العمل</label>
                                         <select name="contract" id="" class="form-control"
                                            style="min-height: 36px;direction: rtl" >
                                            <option value="annual" hidden> حدد  هل العقد شهري او سنوي     </option>

                                                <option value="monthly">شهري</option>
                                                <option value="annual"> سنوي</option>

                                        </select>
                                    </div>
                        <div class="form-group">
                            <label> عدد أيام الأجازات</label>
                            <input type="number" name="vcation_days" class="form-control b" value="" min="0" placeholder="اكتب عدد أيام الإجازة " style="direction:rtl" maxlength="20" required="">
                        </div>

                            <div class="form-group">
                            <label>الراتب</label>
                            <input type="number" name="salary"  class="form-control b" value="" min="0" placeholder="ادخل الراتب "  style="direction:rtl">
                        </div>



                </div>
                <div class="modal-footer" style="text-align: right;direction: rtl;display: block;">
                    <a type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</a>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>





<div class="card v2-card teacher-panel">
    <div class="card-body teacher-panel__body" style="text-align: right;">
        <div class="teacher-panel__toolbar">
            <div class="teacher-panel__controls">
                <div class="teacher-panel__filters">
                    <select name="classes" id="classes_select" class="form-control">
                        <option value="">جميع الصفوف</option>
                        @foreach ($classes as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="teacher-panel__search"></div>
            </div>

            <div class="teacher-panel__actions">
                @can('create_teacher')
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#create_teacher">إضافة مدرس</button>
                @endcan
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-items-center" id="table_xx">
                <thead style="color: black">
                    <tr>
                        <th scope="col" class="sort" data-sort="budget">الاسم الأول</th>
                        <th scope="col" class="sort" data-sort="status">الكنية</th>
                        <th scope="col" class="sort" data-sort="status">تاريخ الميلاد</th>
                        <th scope="col" class="sort" data-sort="completion">العنوان</th>
                        <th scope="col" class="sort" data-sort="completion">الهاتف</th>
                        <th scope="col" class="sort" data-sort="completion">الراتب</th>
                        <th scope="col" class="sort" data-sort="completion">الصورة</th>
                        <th scope="col" class="sort" data-sort="completion">العمليات</th>
                    </tr>
                </thead>
                <tbody class="list" id="mydiv"></tbody>
            </table>
        </div>
    </div>
</div>

@php
    $year2 = \App\Year::where('current_year',1)->first();
@endphp
<input type="hidden" name="year_id" id="years" value={{$year2->id}}>

</div>
@endsection

@section('js')
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.esm.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.esm.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.js"></script>
<script >
function mountTeacherToolbar() {
    var wrapper = $('#table_xx_wrapper');
    var search = wrapper.find('.dataTables_filter');
    var searchHost = $('.teacher-panel__search');

    if (search.length && searchHost.length) {
        search.appendTo(searchHost.empty()).css('display', 'block');
        search.find('label').contents().filter(function () {
            return this.nodeType === 3;
        }).remove();
        search.find('input').attr('placeholder', 'بحث سريع في السجلات');
    }
}

function enableTeacherSidebarToggle() {
    var shell = document.getElementById('v2-shell');
    var toggle = document.getElementById('v2-sidebar-toggle');
    if (!shell || !toggle) {
        return;
    }

    toggle.classList.remove('d-lg-none');
    toggle.classList.add('v2-teacher-toggle');

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

    toggle.addEventListener('click', function (e) {
        if (!media.matches) {
            return;
        }

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
}




$(document).on('change', '#classes_select', function () {

var year_id=$('#years').val();
var class_id=$(this).val();
var url = "{{ URL::to('SMT/admin/classes/rooms2') }}/" + class_id +"/"+ year_id;
$('#rooms_classes').empty();
$('#rooms_classes').append(`<option value="">جميع الشعب</option>`);
$.ajax({
    url: url,
    type: "get",
    contentType: 'application/json',
    success: function (data) {
        $.each(data, function (key, value) {
            $('#rooms_classes').append(`<option value="${value.id}">${value.name}</option>`);
        });
        table_test.draw();
    },


});
});
$(document).on('click', '.class_teacher', function () {

var teacher_id=$(this).data('id');

var url = "{{ URL::to('SMT/admin/class_teacher') }}/" + teacher_id ;

$.ajax({
    url: url,
    type: "get",
    contentType: 'application/json',
    success: function (data) {
          $('.class_table tbody').empty();
        console.log(data);
        $.each(data, function (key, value) {
           $('.class_table tbody').append(`<tr>
            <td>${value.classes.name}</td><td>${value.name}</td></tr>`)
        });
    },


});
});


        $('#rooms_classes').change(function () {
                table_test.draw();
        })

var table_test = $('#table_xx').DataTable({
        processing: true,
        oLanguage: {
            sProcessing: "<h1>Proccessing</h1>"
        },
        serverSide: true,
        "pageLength": 10,
        "ajax": {
            "type": "GET",
            "url": "{{ route('getteachers') }}",
            data : function (d) {
                d.classes = $('#classes_select').val();
                d.rooms= $('#rooms_classes').val();
            },
            "type": "GET",
            "dataSrc": function (json) {
                console.log(json.aaData);
                return json.aaData;
            }
        },
        columns: [
            {

                data: 'id',
                render: function (data, type, full) {
                    return `${full.first_name}`;
                }
            },
            {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.last_name}`;
                }
            },
            {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.date_birth}`;
                }, orderable : false
            },
            {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.address}`;
                },orderable : false
            },

            {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.phone != null ? full.phone : ''}`;
                }, orderable : false
            },

                   {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.salary != null ? full.salary : ''}`;
                }, orderable : false
            },



            {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.image != null ? `<img width="80" height="80" src="{!! asset('storage') !!}/${full.image}" >` : ""}`;
                },orderable : false
            },
            {
                data: 'id',
                render: function (data, type, full) {
                    return `
                        <div class="teacher-actions-grid">
                            <a href="{{ url('SMT/admin/teacher_schedule') }}/${full.id}" class="teacher-action-btn btn btn-info btn-sm" title="جدول الحصص">
                                <i class="fa fa-table fa-x"></i>
                            </a>

                            @can('update_teacher')
                            <a data-id="${ full.id }" data-data='${ JSON.stringify(full) }' class="edit_teacher teacher-action-btn btn btn-info btn-sm" href="{{ url('SMT/admin/teacher_details') }}/${full.id}" title="تعديل معلومات المدرس">
                                <i class="fa fa-eye fa-x"></i>
                            </a>
                            @endcan

                            @can('Account_Information_teacher')
                            <a class="share_teacher teacher-action-btn btn btn-info btn-sm" data-toggle="modal" data-target="#user_name_modal" data-username="${ full.user && full.user.email ? full.user.email : '' }" data-name="${ full.first_name+" "+full.last_name }" data-pass="${ full.user && full.user.view_password ? full.user.view_password : 'غير متوفر' }" title="معلومات الأيميل">
                                <i class="fa fa-send fa-x"></i>
                            </a>
                            @endcan

                            @can('delete_teacher')
                            <a href=".deletelessonModal" class="delete teacher-action-btn" data-id="${ full.id }" data-toggle="modal" title="حذف">
                                <i class="fa fa-trash"></i>
                            </a>
                            @endcan
                        </div>
                    `;
                }, orderable : false
            },

        ]
    });

mountTeacherToolbar();
enableTeacherSidebarToggle();

 $(document).on('click', '.archive', function () {
    var id = $(this).data('id');
    var name=$(this).data('name');


    $('#archive_id').val(id);
});
$(document).on('click', '.delete', function () {
    var id = $(this).data('id');
    var name=$(this).data('name');

    $('#name_delete').val(name);
    $('#lesson_id_delete').val(id);
});
$(document).on("click",".share_teacher",function () {
    $('#pass_share').text($(this).data("pass") || 'غير متوفر');
    $('#username_share').text($(this).data("username") || 'غير متوفر');
    $('#name_share').text($(this).data("name"));
});

$(document).on("click","#screenshot",function () {
    html2canvas(document.querySelector("#dvContainer")).then(canvas => {
		a = document.createElement('a');
		document.body.appendChild(a);
		a.download = $('#name_share').text()+".png";
		a.href =  canvas.toDataURL();
		a.click();
	});
 });


$(document).on('click','.edit_teacher',function (e) {
    var data = $(this).data('data');

    $('#edit_teacher_id').val(data.id);
    $('#edit_first_name').val(data.first_name);
    $('#edit_last_name').val(data.last_name);
    $('#edit_date_birth').val(data.date_birth);
    $('#edit_address').val(data.address);
    $('#edit_vcation_days').val(data.vcation_days);
    $('#edit_contract').val(data.contract);
    $('#edit_lesson_name').val(data.lesson_name);
    $('#edit_phone').val(data.phone);
    $('#edit_email').val(data.email);
    $('#edit_salary').val(data.salary);





    console.log(data.id);
});
 $(".english_name").keypress(function(event){
    var ew = event.which;
    if(ew == 32)
        return true;
    if(48 <= ew && ew <= 57)
        return true;
    if(65 <= ew && ew <= 90)
        return true;
    if(97 <= ew && ew <= 122)
        return true;
    return false;
});

$(document).on('click', '#disabled1', function () {
        $('#disabled button').prop('disabled', true); // Disable the button
    $('#disabled1').closest('form').submit();
    $('#disabled').empty();
    $('#disabled').append(`<button type="submit" class="btn btn-success "  style="margin-right: 4px;"   id="disabled1" >تصدير مدرسين</button>`);
    $('#disabled button').prop('disabled', false); // Re-enable the button

});

</script>

@endsection
