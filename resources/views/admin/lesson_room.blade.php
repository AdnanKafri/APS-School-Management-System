@extends('admin.layouts.v2')

@section('page_title', 'مواد الشعبة')
@section('page_subtitle', 'إدارة مواد الشعبة وروابط علامات الطلاب')

@section('style')
<style>
    .lesson-room-v2 { direction: rtl; text-align: right; }
    /* ── Breadcrumbs ── */
    .v2-bc { display:flex; align-items:center; gap:.4rem; font-size:.9rem; flex-wrap:wrap; direction:rtl; }
    .v2-bc a { color:#8a869a; font-weight:700; text-decoration:none; }
    .v2-bc a:hover { color:#5B4B8A; }
    .v2-bc .sep { color:#b2aec0; font-weight:700; }
    .v2-bc .active { color:#2f2b3a; font-weight:700; }

    /* ── Card ── */
    .v2-section-card {
        border-radius: 18px;
        border: 1px solid rgba(91,75,138,0.12);
        box-shadow: 0 12px 32px rgba(36,30,62,0.08);
        background: #fff;
        overflow: hidden;
    }
    .v2-section-card .card-header {
        padding: 1.25rem 1.5rem !important;
        border-bottom: 1px solid rgba(91,75,138,0.1) !important;
        background: #fff !important;
    }
    .v2-section-card .card-header h3,
    .v2-section-card .card-header h2 {
        margin: 0 !important;
        font-weight: 800 !important;
        color: #2f2b3a !important;
        font-size: 1.1rem !important;
        text-align: right !important;
    }
    .lesson-room-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        padding: 1rem 1.5rem 0;
        flex-wrap: wrap;
    }
    .lesson-room-toolbar__meta {
        color: #7a748f;
        font-size: .92rem;
        font-weight: 700;
    }

    /* ── Table ── */
    .v2-table th {
        background: #f8f7fc !important;
        color: #2f2b3a !important;
        font-weight: 800 !important;
        font-size: .88rem !important;
        border-bottom: 2px solid rgba(91,75,138,0.1) !important;
        padding: .85rem !important;
        text-align: right !important;
        white-space: nowrap;
    }
    .v2-table td {
        vertical-align: middle !important;
        color: #3a3550 !important;
        font-size: .9rem !important;
        padding: .85rem !important;
        border-bottom: 1px solid rgba(91,75,138,0.06) !important;
        text-align: right !important;
    }
    .v2-table > tbody > tr:last-child > td { border-bottom: 0 !important; }
    .lesson-room-actions {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 110px;
        min-height: 42px;
    }
    .lesson-room-pagination {
        padding: 1rem 1.5rem 1.4rem;
    }
    .lesson-room-pagination .hint-text {
        color: #7a748f;
        font-size: .9rem;
        margin-bottom: .65rem;
    }

    /* ── Action buttons ── */
    .v2-section-card .btn { border-radius: 12px !important; font-weight: 700 !important; font-size: .85rem !important; }

    /* ── Modals ── */
    .modal .modal-content { border-radius:16px; overflow:hidden; direction:rtl; text-align:right; box-shadow:0 20px 60px rgba(0,0,0,.18); }
    .modal .modal-header { padding:1rem 1.5rem; border-bottom:1px solid #e9ecef; align-items:center; }
    .modal .modal-header h4, .modal .modal-title { font-size:1rem; font-weight:700; color:#2f2b3a; margin:0; }
    .modal .modal-body { padding:1.5rem; }
    .modal .form-group { margin-bottom:1rem; }
    .modal .form-group label { font-weight:600; color:#3a3550; margin-bottom:.4rem; display:block; }
    .modal .form-control { border-radius:8px; border-color:#d0d5dd; padding:.45rem .75rem; font-size:.9rem; }
    .modal .form-control:focus { border-color:#7B67B2; box-shadow:0 0 0 3px rgba(91,75,138,.15); }
    .modal .modal-footer {
        padding:1rem 1.5rem;
        border-top:1px solid #e9ecef;
        gap:.6rem;
        display:flex;
        flex-wrap:wrap;
        align-items:center;
        justify-content:flex-start;
    }
    .modal .modal-footer .btn { min-height:40px; min-width:100px; font-weight:600; border-radius:10px; padding:.45rem 1.1rem; }

    /* ── Misc ── */
    .pagination { justify-content:center !important; }
    button.close { margin:0 !important; padding:0 !important; }
</style>
@endsection


@section('breadcrumbs')
<nav class="v2-bc" aria-label="Breadcrumb">
    <a href="{{ route('dashboard.index') }}">لوحة التحكم</a>
    <span class="sep">/</span>
    <a href="{{ route('classes') }}">قسم الصفوف</a>
    <span class="sep">/</span>
    <a href="{{ route('classroom',$room->class_id) }}">الشعب</a>
    <span class="sep">/</span>
    <span class="active">جدول مواد الشعبة</span>
</nav>
@endsection


@section('content')
<div class="lesson-room-v2">
    <div class="v2-section-card" style="margin: 1.25rem;">
        <div class="card-header border-0">
          <h3 class="mb-0">جدول مواد الشعبة</h3>
        </div>
        <div class="lesson-room-toolbar">
            <div class="lesson-room-toolbar__meta">اختر المادة المطلوبة للانتقال مباشرة إلى علامات الطلاب داخل هذه الشعبة.</div>
        </div>
<div class="table-responsive">
              <table class="table v2-table">
                <thead>
                  <tr>
                    <th scope="col">الاسم</th>
                    <th scope="col">العمليات</th>
                  </tr>
                </thead>
                <tbody class="list">

                   @foreach ($lessons as $lesson)

                   <tr>
                    <td style="font-weight:700;">
                    {{$lesson->name}}
                    </td>

                    <td>
                        @can('student_marks')
                        <a class="btn btn-success btn-sm lesson-room-actions"
                           href="{{ url('SMT/admin/classroom/StudentsRoomLesson', ['room_id' =>$room_id ,'lesson_id' => $lesson->id]) }}">
                           العلامات
                        </a>
                       @endcan
                      </td>

                    </tr>
                   @endforeach

                </tbody>
              </table>

</div>


            <div class="clearfix lesson-room-pagination">
                    <div class="hint-text">عرض الصفحة
                        <b>{{ !request('page')? "1" : request('page') }}</b>
                        من أصل <b>{{ ceil($count/paginate_num) }}</b>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            {{ $lessons->links() }}
                        </div>
                    </div>
                </div>
    </div>
</div>

{{-- Delete modal — placed outside table for valid HTML --}}
<div class="modal fade" id="deleteEmployeeModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="form_delete" method="POST">
                @csrf
                @method('delete')
                <div class="modal-header">
                    <h5 class="modal-title">تأكيد الحذف</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <p>هل أنت متأكد من حذف هذا العنصر؟</p>
                    <p class="text-warning"><small>لا يمكن التراجع عن هذا الإجراء.</small></p>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-light text-dark" data-dismiss="modal" value="إلغاء">
                    <button class="btn btn-danger">حذف</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    $('.delete').on('click', function () {
        var id = $(this).data('id');
        var url = "{{URL::to('SMARMANger/admin/students')}}";
        $('#form_delete').attr("action", url);
    });
});
</script>

@endsection

