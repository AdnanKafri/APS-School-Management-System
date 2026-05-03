@extends('admin.layouts.v2')

@section('page_title', 'إدارة المستخدمين')
@section('page_subtitle', 'إضافة وتعديل وحذف المستخدمين مع إدارة الصلاحيات بطريقة موحدة')

@section('style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<style>
    .users-v2,
    .users-v2 * { box-sizing: border-box; }
    .users-v2 { direction: rtl; }
    .users-breadcrumbs { display:inline-flex; align-items:center; gap:.45rem; font-size:.88rem; }
    .users-breadcrumbs__link { color:#8a869a; text-decoration:none; font-weight:700; }
    .users-breadcrumbs__link:hover { color:#5b4b8a; text-decoration:none; }
    .users-breadcrumbs__sep { color:#b8b2c6; font-weight:700; }
    .users-breadcrumbs__current { color:#2f2b3a; font-weight:800; }
    .users-shell { display:grid; gap:1rem; }
    .users-card { overflow:hidden; }
    .users-card__header { padding:1.1rem 1.25rem 0; }
    .users-card__title { margin:0; font-size:1.05rem; font-weight:800; color:#2f2b3a; }
    .users-card__subtitle { margin:.25rem 0 0; color:#8a869a; font-size:.88rem; }
    .users-card__body { padding:1rem 1.25rem 1.25rem; }
    .users-toolbar { display:flex; align-items:center; justify-content:space-between; gap:1rem; flex-wrap:wrap; margin-bottom:1rem; }
    .users-toolbar__left { display:flex; align-items:center; gap:.75rem; flex-wrap:wrap; }
    .users-create-btn { min-height:44px; border-radius:12px; font-weight:800; }
    .users-table-wrap { border:1px solid #ece9f4; border-radius:18px; overflow:hidden; background:#fff; }
    .users-table { width:100%; margin:0; }
    .users-table thead th { background:#f8f7fc; color:#5e5873; font-size:.85rem; font-weight:800; padding:1rem .8rem; border:0 !important; text-align:center !important; white-space:nowrap; }
    .users-table tbody td { color:#2f2b3a; font-size:.92rem; font-weight:700; padding:1rem .8rem; border:0 !important; border-top:1px solid #f0edf6 !important; text-align:center !important; vertical-align:middle; }
    .users-table tbody tr:hover { background:#fbfaff; }
    .users-v2 .dataTables_wrapper { padding-top:1rem; }
    .users-v2 .dataTables_filter, .users-v2 .dataTables_length { margin-bottom:1rem; }
    .users-v2 .pagination { justify-content:center !important; }
    .users-action { width:40px; height:40px; display:inline-flex; align-items:center; justify-content:center; border-radius:10px; border:1px solid rgba(59,130,246,.18); background:rgba(59,130,246,.08); color:#3b82f6 !important; text-decoration:none; margin-inline:.12rem; }
    .users-action:hover { background:rgba(59,130,246,.15); color:#2563eb !important; text-decoration:none; }
    .users-action.users-action--danger { border-color:rgba(239,68,68,.25); background:rgba(239,68,68,.08); color:#ef4444 !important; }
    .users-action.users-action--danger:hover { background:rgba(239,68,68,.16); color:#dc2626 !important; }

    .users-v2 .modal-backdrop { z-index:2000 !important; }
    .users-v2 .modal { z-index:2010 !important; }
    .users-v2 .modal-dialog { margin:1.75rem auto; }
    .users-v2 .modal.show .modal-dialog.modal-dialog-centered { transform: translateY(22px); }
    .users-v2 .modal-dialog.modal-lg { max-width:760px; }
    .users-v2 .modal-dialog.modal-md { max-width:640px; }
    .users-v2 .modal-content { border:0; border-radius:20px; overflow:hidden; box-shadow:0 24px 60px rgba(36,30,62,.16); }
    .users-v2 .modal-header, .users-v2 .modal-footer { border-color:rgba(91,75,138,.12); }
    .users-v2 .modal-header { padding:1.1rem 1.25rem; align-items:flex-start; background:linear-gradient(180deg,#fcfbff 0%,#f6f3fc 100%); }
    .users-v2 .modal-title { font-size:1.02rem; font-weight:800; color:#2f2b3a; margin:0; }
    .users-v2 .modal-body { padding:1.25rem 1.35rem; }
    .users-v2 .modal-footer { padding:1rem 1.35rem 1.25rem; display:flex; gap:.75rem; justify-content:flex-start; direction:rtl; }
    .users-v2 .modal-footer .btn { min-width:112px; min-height:44px; border-radius:12px; font-weight:800; }
    .users-v2 .users-modal__close { width:38px; height:38px; padding:0; display:inline-flex; align-items:center; justify-content:center; border:0; border-radius:10px; background:rgba(47,43,58,.06); color:#5e5873; font-size:1.4rem; line-height:1; opacity:1; cursor:pointer; }
    .users-v2 .users-modal__close:hover { background:rgba(47,43,58,.12); color:#2f2b3a; }
    .users-v2 .users-form-group { display:grid; gap:.45rem; margin-bottom:.9rem; text-align:right; }
    .users-v2 .users-form-group label { margin:0; font-size:.9rem; font-weight:800; color:#4d4762; }
    .users-v2 .form-control { min-height:46px; border-radius:12px; border:1px solid #dcd6eb; box-shadow:none; font-size:.9rem !important; }
    .users-v2 .input-group-text { border-radius:12px; border:1px solid #dcd6eb; background:#f8f7fc; color:#5e5873; }
    .users-v2 .users-share-wrap { text-align:center; }
    .users-v2 .users-share-logo { width:120px; height:120px; object-fit:contain; margin:0 auto 1rem; display:block; }
    .users-v2 .users-share-item { margin-bottom:.75rem; }
    .users-v2 .users-share-label { display:block; color:#4d4762; font-size:1rem; font-weight:800; margin-bottom:.15rem; }
    .users-v2 .users-share-value { display:block; color:#111827; font-size:1rem; font-weight:700; word-break:break-word; }
    .users-v2 #table_xx_wrapper { overflow:auto; }

    @media (max-width: 767px) {
        .users-card__header, .users-card__body { padding-inline:.9rem; }
        .users-toolbar { align-items:stretch; }
        .users-toolbar__left { width:100%; justify-content:flex-start; }
    }
</style>
<link href="{{ asset('assets/admin/plugins/toastr/css/toastr.min.css') }}" rel="stylesheet">
@endsection

@php
    $school_data = \App\School_data::first();
@endphp

@section('breadcrumbs')
<nav class="users-breadcrumbs" aria-label="Breadcrumb">
    <a href="{{ route('dashboard.index') }}" class="users-breadcrumbs__link">لوحة التحكم</a>
    <span class="users-breadcrumbs__sep">/</span>
    <span class="users-breadcrumbs__current">الموظفون</span>
</nav>
@endsection

@section('content')
<div class="users-v2">
    <div class="users-shell">
        <div class="v2-card users-card">
            <div class="users-card__header">
                <h3 class="users-card__title">جدول المستخدمين</h3>
                <p class="users-card__subtitle">إدارة حسابات الموظفين وصلاحياتهم ومشاركة بيانات الدخول عند الحاجة.</p>
            </div>
            <div class="users-card__body">
                <div class="users-toolbar">
                    <div class="users-toolbar__left">
                        @can('create_user')
                            <button type="button" class="btn btn-primary users-create-btn" data-toggle="modal" data-target="#create_user">إنشاء مستخدم</button>
                        @endcan
                    </div>
                </div>

                <div class="users-table-wrap table-responsive">
                    <table class="table users-table" id="table_xx">
                        <thead>
                            <tr>
                                <th>الاسم</th>
                                <th>نوع المستخدم</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody id="mydiv"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="user_name_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">بيانات مشاركة المستخدم</h4>
                    <button type="button" class="users-modal__close" data-dismiss="modal" aria-label="إغلاق"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" id="dvContainer">
                    <div class="users-share-wrap">
                        <img src="{{ asset('storage/'. $school_data->logo) }}" class="users-share-logo" alt="logo">
                        <div class="users-share-item">
                            <span class="users-share-label">الموظف</span>
                            <span class="users-share-value" id="name_share"></span>
                        </div>
                        <div class="users-share-item">
                            <span class="users-share-label">اسم المستخدم</span>
                            <span class="users-share-value" id="username_share"></span>
                        </div>
                        <div class="users-share-item">
                            <span class="users-share-label">كلمة المرور</span>
                            <span class="users-share-value" id="pass_share"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-light" data-dismiss="modal">إغلاق</a>
                    <a class="btn btn-primary" id="screenshot">تنزيل</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="update_user" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('admin.user_update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="user_id" id="edit_user_id" hidden>
                    <div class="modal-header">
                        <h4 class="modal-title">تعديل معلومات الموظف</h4>
                        <button type="button" class="users-modal__close" data-dismiss="modal" aria-label="إغلاق"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="users-form-group">
                            <label>الاسم</label>
                            <input type="text" name="name" id="edit_name" class="form-control a" maxlength="30" required>
                        </div>
                        <div class="users-form-group">
                            <label>الهاتف</label>
                            <input type="text" name="phone" id="edit_phone" class="form-control b" maxlength="20" required>
                        </div>
                        <div class="users-form-group">
                            <label>البريد الإلكتروني</label>
                            <input type="email" name="email" id="edit_email" class="form-control b email" maxlength="50">
                            <span class="text-danger error validate_email"></span>
                        </div>

                        <div class="users-form-group">
                            <label>كلمة المرور</label>
                            <small id="alert" style="color:#f00;"></small>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-lock"></i></span></div>
                                <input name="password" id="edit_password" type="password" class="input form-control" placeholder="اكتب كلمة المرور">
                                <span class="input-group-text" onclick="ppassword_show_hide3();">
                                    <i class="fas fa-eye" id="sshow_eye3"></i>
                                    <i class="fas fa-eye-slash d-none" id="hhide_eye3"></i>
                                </span>
                            </div>
                        </div>

                        <div class="users-form-group">
                            <label>تأكيد كلمة المرور</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-lock"></i></span></div>
                                <input name="password_confirmation" id="edit_password_confirmation" type="password" class="input form-control" placeholder="أعد كتابة كلمة المرور">
                                <span class="input-group-text" onclick="ppassword_show_hide4();">
                                    <i class="fas fa-eye" id="sshow_eye4"></i>
                                    <i class="fas fa-eye-slash d-none" id="hhide_eye4"></i>
                                </span>
                            </div>
                        </div>

                        <div class="users-form-group">
                            <label>الصلاحيات</label>
                            <select name="role_id" class="form-control" id="edit_role" required>
                                <option value="">اختر الصلاحية المناسبة</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-light" data-dismiss="modal">إغلاق</a>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="create_user" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('admin.user_store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">إنشاء مستخدم</h4>
                        <button type="button" class="users-modal__close" data-dismiss="modal" aria-label="إغلاق"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="users-form-group">
                            <label>الاسم باللغة العربية</label>
                            <input type="text" name="name" class="form-control a" maxlength="30" required>
                        </div>
                        <div class="users-form-group">
                            <label>الاسم باللغة الإنجليزية</label>
                            <input type="text" name="name_en" class="form-control a english_name" maxlength="30" required>
                        </div>
                        <div class="users-form-group">
                            <label>الهاتف</label>
                            <input type="text" name="phone" class="form-control b" maxlength="20" required>
                        </div>
                        <div class="users-form-group">
                            <label>الصلاحيات</label>
                            <select name="role_id" class="form-control" required>
                                <option value="">اختر الصلاحية المناسبة</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-light" data-dismiss="modal">إغلاق</a>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete_user" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('admin.user_delete') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="user_id" id="delete_user_id">
                    <div class="modal-header">
                        <h4 class="modal-title">حذف الموظف</h4>
                        <button type="button" class="users-modal__close" data-dismiss="modal" aria-label="إغلاق"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="users-form-group">
                            <label>الاسم</label>
                            <input type="text" name="name" id="delete_name" class="form-control a" maxlength="30" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-light" data-dismiss="modal">إغلاق</a>
                        <button type="submit" class="btn btn-danger">تأكيد</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script>
$(function () {
    if (!$.fn.DataTable) {
        console.error('DataTables plugin is not loaded.');
        return;
    }

    if (!$('#table_xx').length) {
        console.error('Users table #table_xx was not found.');
        return;
    }

    if ($.fn.DataTable.isDataTable('#table_xx')) {
        $('#table_xx').DataTable().destroy();
    }

    $('#table_xx tbody').empty();

    var table_test = $('#table_xx').DataTable({
        processing: true,
        oLanguage: { sProcessing: "<h1>Proccessing</h1>" },
        serverSide: true,
        pageLength: 25,
        ajax: {
            type: "GET",
            url: "{{ route('getusers') }}",
            dataSrc: function (json) {
                return json.aaData || json.data || [];
            },
            error: function (xhr, textStatus, errorThrown) {
                console.error('Users DataTable AJAX error:', textStatus, errorThrown, xhr && xhr.responseText);
            }
        },
        columns: [
        {
            data: 'id',
            render: function (data, type, full) { return `${full.name}`; }
        },
        {
            data: 'id',
            render: function (data, type, full) { return `${full.role && full.role.name ? full.role.name : ""}`; },
            orderable: false
        },
        {
            data: 'id',
            render: function (data, type, full) {
                return `
                    @can('update_user')
                    <a data-id="${ full.id }" data-data='${ JSON.stringify(full) }' class="edit_user users-action" data-toggle="modal" data-target="#update_user" title="تعديل معلومات المستخدم">
                        <i class="fa fa-eye"></i>
                    </a>
                    @endcan
                    <a class="share_user users-action" data-toggle="modal" data-target="#user_name_modal" data-username="${ full.email ? full.email : 'غير متوفر' }" data-name="${ full.name ? full.name : '' }" data-pass="${ full.view_password ? full.view_password : 'غير متوفر' }" title="معلومات الحساب">
                        <i class="fa fa-send"></i>
                    </a>
                    @can('delete_user')
                    <a class="delete_user users-action users-action--danger" data-name="${ full.name }" data-id="${ full.id }" data-toggle="modal" data-target="#delete_user" title="حذف الموظف">
                        <i class="fa fa-trash"></i>
                    </a>
                    @endcan
                `;
            },
            orderable: false
        }
        ]
    });
});

$(document).on("click", ".share_user", function () {
    $('#pass_share').text($(this).data("pass") || 'غير متوفر');
    $('#username_share').text($(this).data("username") || 'غير متوفر');
    $('#name_share').text($(this).data("name") || '');
});

$(document).on("click", "#screenshot", function () {
    html2canvas(document.querySelector("#dvContainer")).then(canvas => {
        var a = document.createElement('a');
        document.body.appendChild(a);
        a.download = $('#name_share').text() + ".png";
        a.href = canvas.toDataURL();
        a.click();
    });
});

$(document).on('click', '.edit_user', function () {
    var data = $(this).data('data');
    $('#edit_user_id').val(data.id);
    $('#edit_name').val(data.name);
    $('#edit_phone').val(data.mobile);
    $('#edit_role').val(data.role_id);
    $('#edit_email').val(data.email);
});

$(document).on('click', '.delete_user', function () {
    var id = $(this).data('id');
    var name = $(this).data('name');
    $('#delete_user_id').val(id);
    $('#delete_name').val(name);
});

function ppassword_show_hide3() {
    var x = document.getElementById("edit_password");
    var show_eye = document.getElementById("sshow_eye3");
    var hide_eye = document.getElementById("hhide_eye3");
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

function ppassword_show_hide4() {
    var x = document.getElementById("edit_password_confirmation");
    var show_eye = document.getElementById("sshow_eye4");
    var hide_eye = document.getElementById("hhide_eye4");
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

$(".english_name").keypress(function(event){
    var ew = event.which;
    if (ew == 32) return true;
    if (48 <= ew && ew <= 57) return true;
    if (65 <= ew && ew <= 90) return true;
    if (97 <= ew && ew <= 122) return true;
    return false;
});
</script>
@endsection

