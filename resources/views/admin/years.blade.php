@extends('admin.layouts.v2')

@section('page_title', 'السنوات الدراسية')
@section('page_subtitle', 'عرض العام الدراسي الحالي وتغيير العام النشط من خلال واجهة حديثة ومتناسقة')

@section('style')
<style>
    .years-admin {
        direction: rtl;
        text-align: right;
    }

    .years-admin .years-shell {
        display: grid;
        gap: 1rem;
    }

    .years-admin .years-hero,
    .years-admin .years-card {
        border: 1px solid #ebe7f5;
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 12px 30px rgba(36, 30, 62, 0.06);
    }

    .years-admin .years-hero {
        display: grid;
        grid-template-columns: minmax(0, 1.1fr) minmax(280px, .9fr);
        gap: 1rem;
    }

    .years-admin .years-hero__block {
        padding: 1.1rem 1.15rem;
    }

    .years-admin .years-hero h3,
    .years-admin .years-card__title {
        margin: 0 0 .35rem;
        font-size: 1.12rem;
        font-weight: 800;
        color: #2f2b3a;
        line-height: 1.45;
    }

    .years-admin .years-hero p,
    .years-admin .years-card__subtitle {
        margin: 0;
        color: #746f84;
        line-height: 1.85;
        font-size: .92rem;
    }

    .years-admin .years-summary {
        display: grid;
        gap: .8rem;
    }

    .years-admin .years-summary__item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: .8rem;
        padding: .85rem .95rem;
        border-radius: 14px;
        background: #faf9fe;
        border: 1px solid #ece8f5;
    }

    .years-admin .years-summary__label {
        color: #7b7590;
        font-size: .84rem;
        font-weight: 700;
    }

    .years-admin .years-summary__value {
        color: #2f2b3a;
        font-size: .95rem;
        font-weight: 800;
    }

    .years-admin .years-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: .7rem;
        flex-wrap: wrap;
    }

    .years-admin .years-toolbar .btn {
        border-radius: 12px;
        font-weight: 800;
        white-space: nowrap;
        padding-inline: 1rem;
    }

    .years-admin .years-table-card {
        border: 1px solid #ebe7f5;
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 12px 30px rgba(36, 30, 62, 0.06);
        overflow: hidden;
    }

    .years-admin .years-table-wrap {
        overflow-x: auto;
    }

    .years-admin .years-table {
        margin: 0;
        width: 100%;
    }

    .years-admin .years-table thead th {
        background: #f7f5fb;
        color: #4d4762;
        font-size: .84rem;
        font-weight: 800;
        border-bottom: 1px solid #ebe7f5;
        white-space: nowrap;
    }

    .years-admin .years-table tbody td {
        vertical-align: middle;
        color: #2f2b3a;
        font-size: .92rem;
        white-space: nowrap;
    }

    .years-admin .years-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: .32rem .68rem;
        border-radius: 999px;
        font-size: .76rem;
        font-weight: 800;
        line-height: 1;
    }

    .years-admin .years-badge.is-active {
        background: #eefaf3;
        color: #1f8f5f;
    }

    .years-admin .years-badge.is-muted {
        background: #f4f2f8;
        color: #6f6787;
    }

    .years-admin .form-group {
        margin-bottom: .95rem !important;
    }

    .years-admin label {
        font-size: .95rem;
        font-weight: 700;
        color: #2f2b3a;
        margin-bottom: .35rem;
    }

    .years-admin .form-control {
        min-height: 44px;
        border-radius: 12px;
        border-color: #d8d2e6;
        box-shadow: none;
    }

    .years-admin .form-control:focus {
        border-color: #5b4b8a;
        box-shadow: 0 0 0 4px rgba(91, 75, 138, 0.12);
    }

    @media (max-width: 992px) {
        .years-admin .years-hero {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .years-admin .years-hero__block {
            padding: 1rem;
        }

        .years-admin .years-toolbar {
            align-items: stretch;
        }

        .years-admin .years-toolbar .btn {
            width: 100%;
        }

    }
</style>
@endsection

@section('breadcrumbs')
<nav class="breadcrumbs">
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item">الرئيسية</a>
    <a class="breadcrumbs__item is-active">السنوات الدراسية</a>
</nav>
@endsection

@section('content')
<div class="years-admin">
    <div class="years-shell">
        <div class="years-hero">
            <div class="years-hero__block years-card">
                <h3>العام الدراسي الحالي</h3>
                <p>إدارة العام النشط تتم من هنا، مع عرض واضح للحالة الحالية وتغييرها عند الحاجة.</p>

                <div class="years-summary mt-3">
                    <div class="years-summary__item">
                        <span class="years-summary__label">العام الحالي</span>
                        <span class="years-summary__value">{{ optional($current_year)->name ?? '-' }}</span>
                    </div>
                    <div class="years-summary__item">
                        <span class="years-summary__label">عدد السنوات المسجلة</span>
                        <span class="years-summary__value">{{ number_format(count($years ?? [])) }}</span>
                    </div>
                </div>
            </div>

            <div class="years-hero__block years-card">
                <h3>تغيير العام الدراسي</h3>
                <p>افتح نافذة التعديل واضبط العام الحالي من دون كسر تنسيق لوحة التحكم الجديدة.</p>

                <div class="years-toolbar mt-3">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#currentYearModal">
                        تغيير العام الدراسي
                    </button>
                </div>
            </div>
        </div>

        <div class="years-table-card">
            <div class="card-header border-0 bg-white px-4 pt-4 pb-0">
                <h3 class="mb-1" style="font-size:1.05rem;font-weight:800;color:#2f2b3a;">السنوات المسجلة</h3>
                <p class="mb-0" style="color:#7b7590;font-size:.9rem;">مراجعة سريعة لجميع السنوات الموجودة مع تمييز العام الحالي.</p>
            </div>
            <div class="years-table-wrap px-4 pb-4 pt-3">
                <table class="table years-table">
                    <thead>
                        <tr>
                            <th scope="col">الاسم</th>
                            <th scope="col">الحالة</th>
                            <th scope="col">العام التالي</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($years as $year)
                            <tr>
                                <td>{{ $year->name }}</td>
                                <td>
                                    @if($year->current_year == 1)
                                        <span class="years-badge is-active">العام الحالي</span>
                                    @else
                                        <span class="years-badge is-muted">غير نشط</span>
                                    @endif
                                </td>
                                <td>{{ optional(\App\Year::find($year->next_year))->name ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4" style="color:#7b7590;">لا توجد سنوات مسجلة حالياً.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade v2-dashboard-modal" id="currentYearModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('current_year') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">تغيير العام الدراسي</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="years2">اختر العام الدراسي</label>
                        <select name="year_id" id="years2" class="form-control" required>
                            <option value="">اختر العام الدراسي</option>
                            @foreach ($years as $year)
                                <option value="{{ $year->id }}" {{ optional($current_year)->id == $year->id ? 'selected' : '' }}>{{ $year->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
