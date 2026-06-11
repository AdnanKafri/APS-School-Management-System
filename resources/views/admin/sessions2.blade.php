@extends('admin.layouts.v2')

@section('page_title', 'حصص الصف')
@section('page_subtitle', 'إدارة الحصص الدراسية والاستراحات المرتبطة بالصف والشعب')

@section('style')
<style>
    .session-detail-v2 {
        direction: rtl;
    }

    .session-breadcrumbs {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        font-size: .88rem;
    }

    .session-breadcrumbs__link {
        color: #8a869a;
        text-decoration: none;
        font-weight: 700;
    }

    .session-breadcrumbs__link:hover {
        color: #5b4b8a;
        text-decoration: none;
    }

    .session-breadcrumbs__sep {
        color: #b2adbf;
        font-weight: 700;
    }

    .session-breadcrumbs__current {
        color: #2f2b3a;
        font-weight: 800;
    }

    .session-detail-card {
        overflow: hidden;
    }

    .session-detail-card__header {
        padding: 1.1rem 1.25rem 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .session-detail-card__title {
        margin: 0;
        font-size: 1.05rem;
        font-weight: 800;
        color: #2f2b3a;
    }

    .session-detail-card__subtitle {
        margin: .25rem 0 0;
        color: #8a869a;
        font-size: .88rem;
    }

    .session-detail-card__toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: .85rem;
        flex-wrap: wrap;
        padding: 1rem 1.25rem 0;
    }

    .session-detail-card__actions {
        display: flex;
        align-items: center;
        gap: .65rem;
        flex-wrap: wrap;
    }

    .session-detail-card__body {
        padding: 1rem 1.25rem 1.25rem;
    }

    .session-pill {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        border-radius: 999px;
        background: rgba(91, 75, 138, .08);
        color: #5b4b8a;
        padding: .45rem .9rem;
        font-weight: 800;
        font-size: .84rem;
    }

    .session-btn {
        min-height: 42px;
        border-radius: 12px;
        font-weight: 800;
        padding: .6rem 1rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .35rem;
    }

    .session-actions {
        display: grid;
        grid-template-columns: repeat(2, minmax(48px, 1fr));
        gap: 6px;
        width: 116px;
        margin-inline: auto;
    }

    .session-actions .btn {
        min-height: 40px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: .4rem;
    }

    .session-table-wrap {
        border: 1px solid #ece9f4;
        border-radius: 18px;
        overflow: hidden;
        background: #fff;
    }

    .session-table {
        width: 100%;
        margin: 0;
        direction: rtl;
    }

    .session-table thead th {
        background: #f8f7fc;
        color: #5e5873;
        font-size: .85rem;
        font-weight: 800;
        padding: 1rem .8rem;
        border: 0;
        text-align: center;
        white-space: nowrap;
    }

    .session-table tbody td {
        color: #2f2b3a;
        font-size: .92rem;
        font-weight: 700;
        padding: 1rem .8rem;
        border: 0;
        border-top: 1px solid #f0edf6;
        text-align: center;
        vertical-align: middle;
    }

    .session-type-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 92px;
        border-radius: 999px;
        padding: .35rem .75rem;
        font-weight: 800;
        font-size: .82rem;
    }

    .session-type-badge--lesson {
        color: #155e75;
        background: rgba(6, 182, 212, .12);
    }

    .session-type-badge--break {
        color: #9a3412;
        background: rgba(249, 115, 22, .14);
    }

    .session-empty {
        padding: 2rem 1rem;
        text-align: center;
        color: #8a869a;
        font-weight: 700;
    }

    .session-detail-v2 .modal {
        z-index: 2000;
    }

    .session-detail-v2 .modal-backdrop {
        z-index: 1990;
    }

    .session-modal__dialog {
        max-width: 660px;
    }

    .session-modal__content {
        border: 0;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 28px 60px rgba(31, 24, 55, .22);
    }

    .session-modal__header {
        padding: 1.1rem 1.25rem;
        border-bottom: 1px solid #efeaf8;
        align-items: center;
        background: linear-gradient(180deg, #fcfbff 0%, #f6f3fc 100%);
    }

    .session-modal__title {
        margin: 0;
        font-size: 1.02rem;
        font-weight: 800;
        color: #2f2b3a;
    }

    .session-modal__body {
        padding: 1.25rem;
        display: grid;
        gap: 1rem;
    }

    .session-field {
        display: grid;
        gap: .45rem;
        text-align: right;
    }

    .session-field label {
        margin: 0;
        font-size: .9rem;
        font-weight: 800;
        color: #4d4762;
    }

    .session-field .form-control,
    .session-field .select2-container--default .select2-selection--multiple,
    .session-field .select2-container--default .select2-selection--single {
        min-height: 46px;
        border-radius: 12px;
        border: 1px solid #dcd6eb;
        box-shadow: none;
    }

    .session-field .form-control:focus {
        border-color: #5b4b8a;
        box-shadow: 0 0 0 3px rgba(91, 75, 138, .12);
    }

    .session-field .select2-container {
        width: 100% !important;
    }

    .session-field .select2-container--default .select2-selection--multiple {
        padding: .35rem .45rem;
    }

    .session-modal__footer {
        padding: 1rem 1.25rem 1.25rem;
        border-top: 1px solid #efeaf8;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: .75rem;
    }

    .session-modal__footer .btn {
        min-width: 112px;
        min-height: 44px;
        border-radius: 12px;
        font-weight: 800;
    }

    .session-modal__close {
        margin: 0 !important;
        padding: 0 !important;
        color: #8a869a;
        opacity: 1;
    }

    @media (max-width: 767px) {
        .session-detail-card__header,
        .session-detail-card__toolbar,
        .session-detail-card__body {
            padding-inline: .9rem;
        }

        .session-table thead th,
        .session-table tbody td {
            padding: .85rem .65rem;
            font-size: .84rem;
        }

        .session-actions {
            width: 100px;
        }

        .session-modal__dialog {
            margin: 1rem auto;
            max-width: calc(100vw - 1.5rem);
        }
    }
</style>
@endsection

@section('breadcrumbs')
<nav class="session-breadcrumbs" aria-label="Breadcrumb">
    <a href="{{ route('dashboard.index') }}" class="session-breadcrumbs__link">لوحة التحكم</a>
    <span class="session-breadcrumbs__sep">/</span>
    <a href="{{ route('sessions') }}" class="session-breadcrumbs__link">قسم الحصص</a>
    <span class="session-breadcrumbs__sep">/</span>
    <span class="session-breadcrumbs__current">حصص الصف</span>
</nav>
@endsection

@section('content')
<div class="session-detail-v2">
    <div class="v2-card session-detail-card">
        <div class="session-detail-card__header">
            <div>
                <h3 class="session-detail-card__title">جدول الحصص</h3>
                <p class="session-detail-card__subtitle">تنظيم الحصص الدراسية والاستراحات الخاصة بالصف والشعب المرتبطة به.</p>
            </div>
            <div class="session-pill">إدارة زمن الحصص</div>
        </div>

        <div class="session-detail-card__toolbar">
            <div class="session-detail-card__actions">
                @can('create_workschedule')
                    <a class="btn btn-primary session-btn" data-toggle="modal" data-target="#store_session">
                        <i class="fas fa-plus"></i>
                        <span>إضافة حصة</span>
                    </a>
                @endcan

                @if(count($classes) > 0)
                    <a class="btn btn-danger session-btn" data-toggle="modal" data-target=".deleteall_session">
                        <i class="fas fa-trash"></i>
                        <span>حذف الكل</span>
                    </a>
                @endif
            </div>
        </div>

        <div class="session-detail-card__body">
            <div class="session-table-wrap table-responsive">
                <table class="table session-table">
                    <thead>
                        <tr>
                            <th>الشعبة</th>
                            <th>اسم الحصة</th>
                            <th>بداية الحصة</th>
                            <th>نهاية الحصة</th>
                            <th>النوع</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($classes as $item)
                            <tr>
                                <td>{{ $item->room->name }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->start_time }}</td>
                                <td>{{ $item->end_time }}</td>
                                <td>
                                    @if ($item->type == 1)
                                        <span class="session-type-badge session-type-badge--lesson">حصة درسية</span>
                                    @else
                                        <span class="session-type-badge session-type-badge--break">استراحة</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="session-actions">
                                        @can('edit_workschedule')
                                            <a data-toggle="modal" data-target="#edit_session" class="btn btn-info edit_see" data-data="{{ $item }}" title="تعديل">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                        @endcan
                                        @can('delete_workschedule')
                                            <a class="btn btn-danger delete_session" data-toggle="modal" data-target="#delete_session" data-data="{{ $item }}" title="حذف">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="session-empty">لا توجد حصص مسجلة لهذا الصف حالياً.</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade deleteall_session" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered session-modal__dialog">
            <div class="modal-content session-modal__content">
                <form id="form_delete" action="{{ route('allsession_delete') }}" method="POST" autocomplete="off">
                    @csrf
                    <input type="hidden" name="class_id" id="class_idfor" required value="{{ count($classes) > 0 ? $classes[0]->class_id : 0 }}">
                    <div class="modal-header session-modal__header">
                        <h4 class="session-modal__title">حذف جميع الحصص</h4>
                        <button type="button" class="close session-modal__close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body session-modal__body">
                        <div class="session-field">
                            <label>أدخل كود الحذف للتأكيد</label>
                            <input type="password" id="delete_code" name="delete_code" class="form-control" placeholder="أدخل كود الحذف" required>
                        </div>
                    </div>
                    <div class="modal-footer session-modal__footer">
                        <a class="btn btn-light" data-dismiss="modal">إلغاء</a>
                        <button class="btn btn-danger">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="store_session" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered session-modal__dialog">
            <div class="modal-content session-modal__content">
                <form id="form_update" method="POST" action="{{ route('session_store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="class_id" id="class_id">
                    <div class="modal-header session-modal__header">
                        <h4 class="session-modal__title">إضافة حصة</h4>
                        <button type="button" class="close session-modal__close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body session-modal__body">
                        <div class="session-field">
                            <label>اسم الحصة</label>
                            <input type="text" name="session_name" class="form-control" maxlength="20" required>
                        </div>

                        <div class="session-field">
                            <label>بداية الحصة</label>
                            <input type="time" name="start_time" class="form-control" required>
                        </div>

                        <div class="session-field">
                            <label>نهاية الحصة</label>
                            <input type="time" name="end_time" class="form-control" required>
                        </div>

                        <div class="session-field" hidden>
                            <label>الصفوف</label>
                            <select name="class[]" class="js-example-basic-multiple" multiple="multiple">
                                <option value="{{ $id }}" selected></option>
                            </select>
                        </div>

                        <div class="session-field">
                            <label>النوع</label>
                            <select name="type" class="form-control" required>
                                <option value="1">حصة درسية</option>
                                <option value="2">استراحة</option>
                            </select>
                        </div>

                        <div class="session-field">
                            <label>الشعب</label>
                            <select name="room[]" class="js-example-basic-multiple" multiple="multiple">
                                @foreach ($room as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer session-modal__footer">
                        <a class="btn btn-light" data-dismiss="modal">إلغاء</a>
                        <button class="btn btn-primary">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit_session" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered session-modal__dialog">
            <div class="modal-content session-modal__content">
                <form id="form_update" method="POST" action="{{ route('session_update') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="text" hidden name="id" id="edit_id">
                    <input type="hidden" name="class_id" id="class_id">
                    <div class="modal-header session-modal__header">
                        <h4 class="session-modal__title">تعديل الحصة</h4>
                        <button type="button" class="close session-modal__close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body session-modal__body">
                        <div class="session-field">
                            <label>اسم الحصة</label>
                            <input type="text" name="session_name" class="form-control" id="session_name" maxlength="20" required>
                        </div>

                        <div class="session-field">
                            <label>بداية الحصة</label>
                            <input type="time" name="start_time" id="start_time" class="form-control" required>
                        </div>

                        <div class="session-field">
                            <label>نهاية الحصة</label>
                            <input type="time" name="end_time" id="end_time" class="form-control" required>
                        </div>

                        <div class="session-field">
                            <label>النوع</label>
                            <select name="type" id="edit_type" class="form-control" required>
                                <option value="1">حصة درسية</option>
                                <option value="2">استراحة</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer session-modal__footer">
                        <a class="btn btn-light" data-dismiss="modal">إلغاء</a>
                        <button class="btn btn-primary">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete_session" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered session-modal__dialog">
            <div class="modal-content session-modal__content">
                <form id="form_update" method="POST" action="{{ route('session_delete') }}">
                    @csrf
                    <input type="text" hidden name="id" id="delete_id">
                    <div class="modal-header session-modal__header">
                        <h4 class="session-modal__title">حذف الحصة</h4>
                        <button type="button" class="close session-modal__close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body session-modal__body">
                        <div class="session-field">
                            <label>اسم الحصة</label>
                            <input type="text" name="session_name_delete" class="form-control" id="session_name_delete" readonly>
                        </div>
                    </div>
                    <div class="modal-footer session-modal__footer">
                        <a class="btn btn-light" data-dismiss="modal">إلغاء</a>
                        <button class="btn btn-danger">تأكيد</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$('.alert-success').hide(5000);

$(document).ready(function () {
    $('.js-example-basic-multiple').select2();

    $('.delete').on('click', function () {
        var id = $(this).data('id');
        var url = "{{URL::to('SMARMANger/admin/students')}}";
        $('#form_delete').attr("action", url);
    });

    $(document).on('click', ".edit_see", function () {
        var data = $(this).data('data');
        $('#end_time').val(data.end_time);
        $('#edit_type').val(data.type);
        $('#edit_id').val(data.id);
        $('#start_time').val(data.start_time);
        $('#session_name').val(data.name);
    });

    $(document).on('click', ".delete_session", function () {
        var data = $(this).data('data');
        $('#delete_id').val(data.id);
        $('#session_name_delete').val(data.name);
    });

    $('.edit').on('click', function () {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var name_en = $(this).data('name_en');
        var image = $(this).data('image');
        var cost = $(this).data('cost');
        $('#class_id').val(id);
        $('#name').val(name);
        $('#name_en').val(name_en);
        $('#image').attr('src', `{{asset('storage/${image}')}}`);
        $('#cost').val(cost);
    });
});

var loadFile = function(event) {
   var id = event.target.id;
    var input_image = document.getElementById(id);
        var output = input_image.nextElementSibling.nextElementSibling.nextElementSibling;
        var del_img = input_image.nextElementSibling.nextElementSibling;
        output.setAttribute('src', URL.createObjectURL(event.target.files[0]));
        output.onload = function() {
          output.setAttribute('style', 'display:inline');
          del_img.setAttribute('style', 'display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointer');
        };
};

var loadFile_edit = function(event) {
   var id = event.target.id;
    var input_image = document.getElementById(id);
        var output = input_image.nextElementSibling.nextElementSibling.nextElementSibling;
        var del_img = input_image.nextElementSibling.nextElementSibling;
        input_image.previousElementSibling.setAttribute('style', 'display:none');
        input_image.previousElementSibling.previousElementSibling.setAttribute('style', 'display:none');

        output.setAttribute('src', URL.createObjectURL(event.target.files[0]));
        output.onload = function() {
          output.setAttribute('style', 'display:inline');
          del_img.setAttribute('style', 'display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointer');
        };
};

$(document).on('click', '.del_img', function () {
    $(this).nextAll('.output').attr('style', 'display:none;');
    $(this).prevAll('.input_image:first').val('');
    $(this).hide();
});

$(document).on('click', '.del_icon', function () {
    $(this).prevAll('.del:first').attr('disabled', false);
    $(this).prevAll('.del_edit_img:first').hide();
    $(this).hide();
});
</script>
@endsection
