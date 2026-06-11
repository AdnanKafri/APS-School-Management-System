@extends('admin.layouts.v2')

@section('page_title', 'الشعب المرتبطة بالاختبارات')
@section('page_subtitle', 'إدارة الشعب والانتقال إلى صفحات المذاكرات والامتحانات الخاصة بكل شعبة')

@section('style')
<style>
    .exam-rooms-v2 { direction: rtl; }
    .exam-breadcrumbs { display:inline-flex; align-items:center; gap:.45rem; font-size:.88rem; }
    .exam-breadcrumbs__link { color:#8a869a; text-decoration:none; font-weight:700; }
    .exam-breadcrumbs__link:hover { color:#5b4b8a; text-decoration:none; }
    .exam-breadcrumbs__sep { color:#b8b2c6; font-weight:700; }
    .exam-breadcrumbs__current { color:#2f2b3a; font-weight:800; }
    .exam-room-card { overflow:hidden; }
    .exam-room-card__header { padding:1.1rem 1.25rem 0; }
    .exam-room-card__title { margin:0; font-size:1.05rem; font-weight:800; color:#2f2b3a; }
    .exam-room-card__subtitle { margin:.25rem 0 0; color:#8a869a; font-size:.88rem; }
    .exam-room-card__body { padding:1rem 1.25rem 1.25rem; }
    .exam-room-table-wrap { border:1px solid #ece9f4; border-radius:18px; overflow:hidden; background:#fff; }
    .exam-room-table { width:100%; margin:0; direction:rtl; }
    .exam-room-table thead th { background:#f8f7fc; color:#5e5873; font-size:.85rem; font-weight:800; padding:1rem .85rem; border:0; text-align:center; }
    .exam-room-table tbody td { color:#2f2b3a; font-size:.92rem; font-weight:700; padding:1rem .85rem; border:0; border-top:1px solid #f0edf6; text-align:center; vertical-align:middle; }
    .exam-room-table tbody tr:hover { background:#fbfaff; }
    .exam-room-actions { display:grid; grid-template-columns:repeat(2,minmax(48px,1fr)); gap:8px; width:min(100%,220px); margin-inline:auto; }
    .exam-room-actions .btn, .exam-room-actions a.edit { min-height:42px; border-radius:12px; display:inline-flex; align-items:center; justify-content:center; padding:.55rem .8rem; font-weight:800; text-decoration:none; }
    .exam-room-actions a.edit { background:rgba(91,75,138,.08); color:#5b4b8a; }
    .exam-room-actions a.edit:hover { text-decoration:none; background:rgba(91,75,138,.14); }
    .exam-room-pagination { padding-top:1rem; text-align:center; }
    .exam-room-pagination .hint-text { color:#8a869a; font-weight:700; margin-bottom:.65rem; }
    .exam-rooms-v2 .modal { z-index:2000; }
    .exam-rooms-v2 .modal-backdrop { z-index:1990; }
    .exam-modal__dialog { max-width:640px; }
    .exam-rooms-v2 .modal-dialog { margin:1.5rem auto; }
    .exam-rooms-v2 .modal-content { border:0; border-radius:20px; overflow:hidden; box-shadow:0 28px 60px rgba(31,24,55,.22); }
    .exam-rooms-v2 .modal-header { padding:1.1rem 1.25rem; border-bottom:1px solid #efeaf8; align-items:center; background:linear-gradient(180deg,#fcfbff 0%,#f6f3fc 100%); }
    .exam-rooms-v2 .modal-title { margin:0; font-size:1.02rem; font-weight:800; color:#2f2b3a; }
    .exam-rooms-v2 .modal-body { padding:1.25rem; display:grid; gap:1rem; }
    .exam-rooms-v2 .modal-body .form-group { margin:0; text-align:right; }
    .exam-rooms-v2 .modal-body label { margin-bottom:.45rem; font-size:.9rem; font-weight:800; color:#4d4762; }
    .exam-rooms-v2 .form-control { min-height:46px; border-radius:12px; border:1px solid #dcd6eb; box-shadow:none; }
    .exam-rooms-v2 .modal-footer { padding:1rem 1.25rem 1.25rem; border-top:1px solid #efeaf8; display:flex; align-items:center; justify-content:flex-start; gap:.75rem; }
    .exam-rooms-v2 .modal-footer .btn { min-width:112px; min-height:44px; border-radius:12px; font-weight:800; }
    .exam-rooms-v2 button.close { margin:0 !important; padding:0 !important; color:#8a869a; opacity:1; }
</style>
@endsection

@section('breadcrumbs')
<nav class="exam-breadcrumbs" aria-label="Breadcrumb">
    <a href="{{ route('dashboard.index') }}" class="exam-breadcrumbs__link">لوحة التحكم</a>
    <span class="exam-breadcrumbs__sep">/</span>
    <a href="{{ route('classes.view.exams') }}" class="exam-breadcrumbs__link">قسم الاختبارات</a>
    <span class="exam-breadcrumbs__sep">/</span>
    <span class="exam-breadcrumbs__current">الشعب</span>
</nav>
@endsection

@section('content')
<div class="exam-rooms-v2">
    <div class="v2-card exam-room-card">
        <div class="exam-room-card__header">
            <h3 class="exam-room-card__title">الشعب المرتبطة بالصف</h3>
            <p class="exam-room-card__subtitle">اختر الشعبة للانتقال مباشرة إلى صفحات المذاكرات أو الامتحانات الخاصة بها.</p>
        </div>
        <div class="exam-room-card__body">
            <div class="exam-room-table-wrap table-responsive">
                <table class="table exam-room-table">
                    <thead>
                        <tr>
                            <th>اسم الشعبة</th>
                            <th>الصف</th>
                            <th>العام الدراسي</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rooms as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->classes->name }}</td>
                                <td>{{ $item->year->name }}</td>
                                <td>
                                    <div class="exam-room-actions">
                                        <a class="btn btn-primary" href="{{ route('room_quizes', $item->id) }}">المذاكرات</a>
                                        <a class="btn btn-info" href="{{ route('room_exams', $item->id) }}">الامتحانات</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="exam-room-pagination">
                <div class="hint-text">
                    عرض <b>{{ !request('page') ? '1' : request('page') }}</b>
                    من أصل <b>{{ ceil($count / paginate_num) }}</b>
                </div>
                <div>{{ $rooms->links() }}</div>
            </div>
        </div>
    </div>

    <div class="modal fade deleteEmployeeModal">
        <div class="modal-dialog modal-dialog-centered exam-modal__dialog">
            <div class="modal-content">
                <form id="form_delete" method="POST">
                    @csrf
                    @method('delete')
                    <div class="modal-header">
                        <h4 class="modal-title">حذف العنصر</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>هل أنت متأكد من حذف هذا السجل؟</p>
                        <p class="text-warning"><small>لا يمكن التراجع عن هذا الإجراء.</small></p>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-light" data-dismiss="modal" value="إلغاء">
                        <button class="btn btn-danger">حذف</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade editroomModal">
        <div class="modal-dialog modal-dialog-centered exam-modal__dialog">
            <div class="modal-content">
                <form id="form_update" action="{{ route('room_update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="room_id" id="room_id">
                    <div class="modal-header">
                        <h4 class="modal-title">تعديل الشعبة</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>الاسم بالعربية</label>
                            <input type="text" id="name" name="name" class="form-control" value="" placeholder="ضع اسماً هنا" maxlength="30" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-light" data-dismiss="modal">إلغاء</a>
                        <button class="btn btn-primary">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade createRoomModal">
        <div class="modal-dialog modal-dialog-centered exam-modal__dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('room_store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="class_id" value="{{ $id }}">
                    <div class="modal-header">
                        <h4 class="modal-title">إنشاء شعبة</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>اسم الشعبة</label>
                            <input type="text" name="room_name" class="form-control" value="" placeholder="مثال: الشعبة الأولى" required>
                        </div>
                        <div class="form-group">
                            <label>العام الدراسي</label>
                            <select name="year_id" class="form-control" required>
                                <option value="">اختر العام الدراسي</option>
                                @foreach ($years as $year)
                                    <option value="{{ $year->id }}">{{ $year->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-light" data-dismiss="modal">إلغاء</a>
                        <button class="btn btn-primary">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).on('click', '.edit', function () {
        var id = $(this).data('id');
        var name = $(this).data('name');
        $('#name').val(name);
        $('#room_id').val(id);
    });
</script>
@endsection
