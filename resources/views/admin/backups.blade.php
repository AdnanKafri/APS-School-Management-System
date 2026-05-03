@extends('admin.layouts.v2')

@section('page_title', 'النسخ الاحتياطي')
@section('page_subtitle', 'إدارة نسخ قاعدة البيانات واستعادتها بأمان')

@section('style')
<style>
    .backups-v2 { direction: rtl; }
    .backups-breadcrumbs { display: inline-flex; align-items: center; gap: .45rem; font-size: .88rem; }
    .backups-breadcrumbs__link { color: #8a869a; text-decoration: none; font-weight: 700; }
    .backups-breadcrumbs__link:hover { color: #5b4b8a; text-decoration: none; }
    .backups-breadcrumbs__sep { color: #b8b2c6; font-weight: 700; }
    .backups-breadcrumbs__current { color: #2f2b3a; font-weight: 800; }

    .backups-shell { display: grid; gap: 1rem; }
    .backups-card { overflow: hidden; }
    .backups-card__header { padding: 1.1rem 1.25rem 0; }
    .backups-card__title { margin: 0; font-size: 1.05rem; font-weight: 800; color: #2f2b3a; }
    .backups-card__subtitle { margin: .25rem 0 0; color: #8a869a; font-size: .88rem; }
    .backups-card__body { padding: 1rem 1.25rem 1.25rem; }

    .backups-toolbar { display: flex; align-items: center; justify-content: space-between; gap: .75rem; flex-wrap: wrap; margin-bottom: 1rem; }
    .backups-toolbar__actions { display: flex; align-items: center; gap: .6rem; flex-wrap: wrap; }

    .backups-table-wrap { border: 1px solid #ece9f4; border-radius: 18px; overflow: hidden; background: #fff; }
    .backups-table { width: 100%; margin: 0; }
    .backups-table thead th {
        background: #f8f7fc;
        color: #5e5873;
        font-size: .85rem;
        font-weight: 800;
        padding: .95rem .8rem;
        border: 0 !important;
        text-align: center !important;
        white-space: nowrap;
    }
    .backups-table tbody td {
        color: #2f2b3a;
        font-size: .92rem;
        font-weight: 700;
        padding: .95rem .8rem;
        border: 0 !important;
        border-top: 1px solid #f0edf6 !important;
        text-align: center !important;
        vertical-align: middle;
    }

    .backups-action {
        width: 40px;
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        text-decoration: none;
        border: 1px solid rgba(59, 130, 246, .2);
        background: rgba(59, 130, 246, .08);
        color: #3b82f6;
    }
    .backups-action:hover { background: rgba(59, 130, 246, .15); color: #2563eb; text-decoration: none; }

    .backups-empty { padding: 1rem; color: #8a869a; text-align: center; font-weight: 700; }

    .backups-v2 .modal-backdrop { z-index: 1040 !important; }
    .backups-v2 .modal { z-index: 1055 !important; }
    .backups-v2 .modal-content { border-radius: 16px; border: 0; }
    .backups-v2 .modal-header,
    .backups-v2 .modal-footer { border-color: rgba(91, 75, 138, .12); }

    @media (max-width: 767px) {
        .backups-card__header,
        .backups-card__body { padding-inline: .9rem; }
    }
</style>
@endsection

@section('breadcrumbs')
<nav class="backups-breadcrumbs" aria-label="Breadcrumb">
    <a href="{{ route('dashboard.index') }}" class="backups-breadcrumbs__link">لوحة التحكم</a>
    <span class="backups-breadcrumbs__sep">/</span>
    <span class="backups-breadcrumbs__current">النسخ الاحتياطي</span>
</nav>
@endsection

@section('content')
<div class="backups-v2">
    <div class="backups-shell">
        <div class="v2-card backups-card">
            <div class="backups-card__header">
                <h3 class="backups-card__title">جدول النسخ الاحتياطية</h3>
                <p class="backups-card__subtitle">إجمالي النسخ المتوفرة: {{ $count ?? 0 }}</p>
            </div>

            <div class="backups-card__body">
                <div class="backups-toolbar">
                    <div class="backups-toolbar__actions">
                        <a href="{{ route('get-backup') }}" class="btn btn-primary">إنشاء نسخة جديدة</a>
                    </div>
                </div>

                <div class="backups-table-wrap table-responsive">
                    <table class="table backups-table">
                        <thead>
                            <tr>
                                <th>الملف</th>
                                <th>تاريخ الإنشاء</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($backups as $item)
                                <tr id="backup_{{ $item->id }}">
                                    <td>{{ $item->item }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>
                                        <a href="{{ route('zip', $item->id) }}" class="backups-action" title="تنزيل">
                                            <i class="fa fa-download"></i>
                                        </a>

                                        <form action="{{ route('backup_del') }}" method="POST" style="display:inline-block" onsubmit="return confirm('هل أنت متأكد من حذف هذه النسخة؟');">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $item->id }}">
                                            <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="backups-empty">لا توجد نسخ احتياطية حالياً.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_import" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('importedatabase') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">استبدال قاعدة البيانات</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="إغلاق">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="text-align:right;">
                        <p class="mb-3 text-danger font-weight-bold">تنبيه: سيؤدي الاستبدال إلى فقدان البيانات الحالية.</p>
                        <div class="form-group">
                            <label>ملف قاعدة البيانات الجديدة</label>
                            <input type="file" name="sql" class="form-control">
                        </div>
                        <div class="form-group mb-0">
                            <label>كلمة المرور</label>
                            <input type="text" name="password" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">تأكيد</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
