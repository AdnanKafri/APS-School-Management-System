@extends('admin.layouts.v2')

@section('page_title', 'الأقساط المالية - النقل')
@section('page_subtitle', 'متابعة اشتراكات النقل للطلاب مع بحث سريع والوصول إلى فواتير كل طالب')

@section('style')
<style>
    .transport-financial-v2,
    .transport-financial-v2 * { box-sizing: border-box; }
    .transport-financial-v2 { direction: rtl; }
    .transport-breadcrumbs { display:inline-flex; align-items:center; gap:.45rem; font-size:.88rem; }
    .transport-breadcrumbs__link { color:#8a869a; text-decoration:none; font-weight:700; }
    .transport-breadcrumbs__link:hover { color:#5b4b8a; text-decoration:none; }
    .transport-breadcrumbs__sep { color:#b8b2c6; font-weight:700; }
    .transport-breadcrumbs__current { color:#2f2b3a; font-weight:800; }
    .transport-shell { display:grid; gap:1rem; }
    .transport-card { overflow:hidden; }
    .transport-card__header { padding:1.1rem 1.25rem 0; }
    .transport-card__title { margin:0; font-size:1.05rem; font-weight:800; color:#2f2b3a; }
    .transport-card__subtitle { margin:.25rem 0 0; color:#8a869a; font-size:.88rem; }
    .transport-card__body { padding:1rem 1.25rem 1.25rem; }
    .transport-toolbar { display:flex; align-items:center; justify-content:space-between; gap:1rem; flex-wrap:wrap; margin-bottom:1rem; }
    .transport-toolbar__search { width:min(360px,100%); }
    .transport-toolbar__search .form-control { min-height:44px; border-radius:12px; border:1px solid #dcd6eb; }
    .transport-table-wrap { border:1px solid #ece9f4; border-radius:18px; overflow:hidden; background:#fff; }
    .transport-table { width:100%; margin:0; }
    .transport-table thead th { background:#f8f7fc; color:#5e5873; font-size:.85rem; font-weight:800; padding:1rem .8rem; border:0 !important; text-align:center !important; white-space:nowrap; }
    .transport-table tbody td { color:#2f2b3a; font-size:.92rem; font-weight:700; padding:1rem .8rem; border:0 !important; border-top:1px solid #f0edf6 !important; text-align:center !important; vertical-align:middle; }
    .transport-table tbody tr:hover { background:#fbfaff; }
    .transport-action { display:inline-flex; align-items:center; justify-content:center; min-height:40px; padding:.55rem .95rem; border-radius:11px; border:1px solid rgba(59,130,246,.18); background:rgba(59,130,246,.08); color:#3b82f6 !important; text-decoration:none; font-weight:800; }
    .transport-action:hover { background:rgba(59,130,246,.15); color:#2563eb !important; text-decoration:none; }
    .transport-pager { padding:1rem .5rem 0; text-align:center; color:#8a869a; font-size:.88rem; font-weight:700; }
    .transport-pagination { margin-top:.65rem; }
    .transport-pagination .pagination { justify-content:center !important; margin-bottom:0; }
    @media (max-width: 767px) {
        .transport-card__header,
        .transport-card__body { padding-inline:.9rem; }
        .transport-toolbar__search { width:100%; }
    }
</style>
@endsection

@section('breadcrumbs')
<nav class="transport-breadcrumbs" aria-label="Breadcrumb">
    <a href="{{ route('dashboard.index') }}" class="transport-breadcrumbs__link">لوحة التحكم</a>
    <span class="transport-breadcrumbs__sep">/</span>
    <span class="transport-breadcrumbs__current">الأقساط المالية - النقل</span>
</nav>
@endsection

@section('content')
<div class="transport-financial-v2">
    <div class="transport-shell">
        <div class="v2-card transport-card">
            <div class="transport-card__header">
                <h3 class="transport-card__title">الطلاب المشتركون بالنقل</h3>
                <p class="transport-card__subtitle">ابحث عن الطالب ثم افتح صفحة الفواتير الخاصة به.</p>
            </div>
            <div class="transport-card__body">
                <div class="transport-toolbar">
                    <div class="transport-toolbar__search">
                        <input type="text" class="form-control" id="search_input" placeholder="ابحث بالاسم الأول أو الكنية">
                    </div>
                </div>

                <div class="transport-table-wrap table-responsive">
                    <table class="table transport-table">
                        <thead>
                            <tr>
                                <th>الاسم</th>
                                <th>الكنية</th>
                                <th>الهاتف</th>
                                <th>العنوان</th>
                                <th>الخط</th>
                                <th>الباص</th>
                                <th>التكلفة الكاملة</th>
                                <th>المدفوعات</th>
                                <th>الصف</th>
                                <th>الشعبة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody id="student-table-body">
                            @foreach ($students as $item)
                                <tr>
                                    <td>{{ $item->first_name }}</td>
                                    <td>{{ $item->last_name }}</td>
                                    <td>{{ optional($item->details)->phone }}</td>
                                    <td>{{ optional($item->details)->address }}</td>
                                    <td>{{ optional(optional($item->bus)->bus_lines)->name }}</td>
                                    <td>{{ optional($item->bus)->name }}</td>
                                    <td>{{ optional(optional($item->bus)->bus_lines)->annual_cost }}</td>
                                    <td>{{ optional(optional($item->bus)->bus_lines)->annual_cost }}</td>
                                    <td>@if(count($item->room)>0) {{ $item->room[0]->classes->name }} @endif</td>
                                    <td>@if(count($item->room)>0) {{ $item->room[0]->name }} @endif</td>
                                    <td>
                                        <a href="{{ route('transport_invoices', $item->id) }}" class="transport-action">الفواتير</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="transport-pager">
                    عرض الصفحة <b>{{ !request('page') ? '1' : request('page') }}</b> من أصل <b>{{ ceil($count / paginate_num) }}</b>
                    <div class="transport-pagination">{{ $students->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
function fetchStudents() {
    let name = $('#search_input').val();
    $.ajax({
        url: "{{ route('financial_transport_student_filter') }}",
        type: "GET",
        data: { name: name },
        success: function(data) {
            $('#student-table-body').html(data);
        }
    });
}

$(document).on('keyup', '#search_input', function() {
    fetchStudents();
});
</script>
@endsection
