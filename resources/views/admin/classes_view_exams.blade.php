@extends('admin.layouts.v2')

@section('page_title', 'قسم الاختبارات')
@section('page_subtitle', 'اختيار الصف للانتقال إلى الشعب والامتحانات والمذاكرات المرتبطة به')

@section('style')
<style>
    .exams-index-v2 { direction: rtl; }
    .exam-breadcrumbs { display:inline-flex; align-items:center; gap:.45rem; font-size:.88rem; }
    .exam-breadcrumbs__link { color:#8a869a; text-decoration:none; font-weight:700; }
    .exam-breadcrumbs__link:hover { color:#5b4b8a; text-decoration:none; }
    .exam-breadcrumbs__sep { color:#b8b2c6; font-weight:700; }
    .exam-breadcrumbs__current { color:#2f2b3a; font-weight:800; }
    .exam-card { overflow:hidden; }
    .exam-card__header { padding:1.1rem 1.25rem 0; }
    .exam-card__title { margin:0; font-size:1.05rem; font-weight:800; color:#2f2b3a; }
    .exam-card__subtitle { margin:.25rem 0 0; color:#8a869a; font-size:.88rem; }
    .exam-card__body { padding:1rem 1.25rem 1.25rem; }
    .exam-table-wrap { border:1px solid #ece9f4; border-radius:18px; overflow:hidden; background:#fff; }
    .exam-table { width:100%; margin:0; direction:rtl; }
    .exam-table thead th { background:#f8f7fc; color:#5e5873; font-size:.85rem; font-weight:800; padding:1rem .9rem; border:0; text-align:center; }
    .exam-table tbody td { color:#2f2b3a; font-size:.94rem; font-weight:700; padding:1rem .9rem; border:0; border-top:1px solid #f0edf6; text-align:center; vertical-align:middle; }
    .exam-table tbody tr:hover { background:#fbfaff; }
    .exam-action { min-height:42px; min-width:116px; border-radius:12px; display:inline-flex; align-items:center; justify-content:center; font-weight:800; padding:.6rem 1rem; }
    .exam-pagination { padding-top:1rem; text-align:center; }
    .exam-pagination .hint-text { color:#8a869a; font-weight:700; margin-bottom:.65rem; }
    .exam-empty { padding:2rem 1rem; text-align:center; color:#8a869a; font-weight:700; }
</style>
@endsection

@section('breadcrumbs')
<nav class="exam-breadcrumbs" aria-label="Breadcrumb">
    <a href="{{ route('dashboard.index') }}" class="exam-breadcrumbs__link">لوحة التحكم</a>
    <span class="exam-breadcrumbs__sep">/</span>
    <span class="exam-breadcrumbs__current">قسم الاختبارات</span>
</nav>
@endsection

@section('content')
<div class="exams-index-v2">
    <div class="v2-card exam-card">
        <div class="exam-card__header">
            <h3 class="exam-card__title">الصفوف الدراسية</h3>
            <p class="exam-card__subtitle">اختر الصف للانتقال إلى الشعب الخاصة به ثم إدارة الامتحانات أو المذاكرات.</p>
        </div>
        <div class="exam-card__body">
            <div class="exam-table-wrap table-responsive">
                <table class="table exam-table">
                    <thead>
                        <tr>
                            <th>اسم الصف</th>
                            <th>العام الدراسي</th>
                            <th>الشعب</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($classes as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $year->name }}</td>
                                <td>
                                    <a href="{{ route('classroom_exams', $item->id) }}" class="btn btn-primary exam-action">عرض الشعب</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3"><div class="exam-empty">لا توجد صفوف متاحة حالياً.</div></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="exam-pagination">
                <div class="hint-text">
                    عرض <b>{{ !request('page') ? '1' : request('page') }}</b>
                    من أصل <b>{{ ceil($count / paginate_num) }}</b>
                </div>
                <div>{{ $classes->links() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
