@extends('admin.layouts.v2')
@section('body_class', 'website-mgmt-v2')

@section('page_title', 'بيانات المدرسة')
@section('page_subtitle', 'تحديث الاسم والشعار والفيديو والهوية البصرية من خلال واجهة حديثة وآمنة')

@section('style')
<style>
    .school-data-v2 {
        direction: rtl;
        text-align: right;
    }

    .school-data-v2 .data-shell {
        display: grid;
        gap: 1rem;
    }

    .school-data-v2 .data-hero,
    .school-data-v2 .data-card,
    .school-data-v2 .data-panel {
        border: 1px solid #ebe7f5;
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 12px 30px rgba(36, 30, 62, 0.06);
    }

    .school-data-v2 .data-hero {
        padding: 1.15rem 1.2rem;
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        align-items: center;
    }

    .school-data-v2 .data-hero h3 {
        margin: 0 0 .35rem;
        font-size: 1.15rem;
        font-weight: 800;
        color: #2f2b3a;
        line-height: 1.45;
    }

    .school-data-v2 .data-hero p {
        margin: 0;
        color: #746f84;
        line-height: 1.85;
        font-size: .92rem;
        max-width: 58rem;
    }

    .school-data-v2 .data-actions {
        display: flex;
        gap: .65rem;
        flex-wrap: wrap;
    }

    .school-data-v2 .data-actions .btn {
        border-radius: 12px;
        font-weight: 800;
        white-space: nowrap;
        min-height: 44px;
        display: inline-flex;
        align-items: center;
        padding-inline: 1rem;
    }

    .school-data-v2 .data-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1rem;
    }

    .school-data-v2 .data-card {
        padding: 1rem 1rem .95rem;
        min-height: 148px;
    }

    .school-data-v2 .data-card__label {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .3rem .6rem;
        border-radius: 999px;
        background: #f4f2f8;
        color: #6f6787;
        font-size: .76rem;
        font-weight: 800;
        margin-bottom: .8rem;
    }

    .school-data-v2 .data-card__value {
        color: #2f2b3a;
        font-size: .98rem;
        font-weight: 800;
        line-height: 1.8;
        word-break: break-word;
    }

    .school-data-v2 .data-card__media {
        margin-top: .85rem;
        border-radius: 14px;
        background: #fbfafe;
        border: 1px solid #ece8f5;
        overflow: hidden;
        min-height: 160px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .school-data-v2 .data-card__media img,
    .school-data-v2 .data-card__media video {
        display: block;
        max-width: 100%;
        height: auto;
    }

    .school-data-v2 .data-card__media img {
        max-height: 180px;
        object-fit: contain;
    }

    .school-data-v2 .data-card__media video {
        width: 100%;
        max-height: 220px;
    }

    .school-data-v2 .data-panel {
        padding: 1rem 1.1rem;
    }

    .school-data-v2 .data-table {
        width: 100%;
        margin: 0;
    }

    .school-data-v2 .data-table thead th {
        background: #f7f5fb;
        color: #4d4762;
        font-size: .84rem;
        font-weight: 800;
        border-bottom: 1px solid #ebe7f5;
        white-space: nowrap;
        text-align: center;
    }

    .school-data-v2 .data-table tbody td {
        vertical-align: top;
        color: #2f2b3a;
        font-size: .92rem;
        text-align: center;
    }

    .school-data-v2 .data-table tbody td:first-child {
        min-width: 180px;
    }

    .school-data-v2 .modal .form-group {
        margin-bottom: .95rem;
    }

    .school-data-v2 .modal label {
        font-size: .95rem;
        font-weight: 700;
        color: #2f2b3a;
        margin-bottom: .35rem;
    }

    .school-data-v2 .modal .form-control {
        min-height: 44px;
        border-radius: 12px;
        border-color: #d8d2e6;
        box-shadow: none;
    }

    .school-data-v2 .modal .form-control:focus {
        border-color: #5b4b8a;
        box-shadow: 0 0 0 4px rgba(91, 75, 138, 0.12);
    }

    .school-data-v2 .modal-footer .btn {
        min-width: 110px;
    }

    @media (max-width: 768px) {
        .school-data-v2 .data-hero {
            padding: 1rem;
        }

        .school-data-v2 .data-card,
        .school-data-v2 .data-panel {
            padding: 1rem;
        }

        .school-data-v2 .data-actions .btn {
            width: 100%;
        }

        .school-data-v2 .data-table tbody td {
            white-space: normal;
        }
    }
</style>
@endsection

@section('breadcrumbs')
<nav class="breadcrumbs">
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item">الرئيسية</a>
    <a href="{{ route('websitecontroller') }}" class="breadcrumbs__item">قسم التحكم الكامل بالموقع</a>
    <a class="breadcrumbs__item is-active">بيانات المدرسة</a>
</nav>
@endsection

@section('content')
@php
    $school = $school_data ?? \App\School_data::first();
@endphp

<div class="school-data-v2">
    <div class="data-shell">
        <div class="data-hero">
            <div>
                <h3>بيانات المدرسة</h3>
                <p>من هنا يتم تحديث الاسم الرسمي، الاسم الإنجليزي، الشعار، الشعار الخاص بالحسابات، والفيديو التعريفي للموقع العام من خلال نافذة تحرير حديثة وواضحة.</p>
            </div>

            <div class="data-actions">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#schoolDataModal">
                    تعديل البيانات
                </button>
                <a href="{{ route('websitecontroller') }}" class="btn btn-outline-primary">
                    الرجوع للقسم
                </a>
            </div>
        </div>

        <div class="data-grid">
            <div class="data-card">
                <span class="data-card__label"><i class="fas fa-signature"></i> الاسم العربي</span>
                <div class="data-card__value">{{ optional($school)->name ?? '-' }}</div>
            </div>

            <div class="data-card">
                <span class="data-card__label"><i class="fas fa-language"></i> الاسم الإنجليزي</span>
                <div class="data-card__value">{{ optional($school)->name_en ?? '-' }}</div>
            </div>

            <div class="data-card">
                <span class="data-card__label"><i class="fas fa-video"></i> الفيديو التعريفي</span>
                <div class="data-card__media">
                    @if(!empty(optional($school)->video))
                        <video controls autoplay loop muted playsinline>
                            <source src="{{ asset('storage/' . $school->video) }}">
                        </video>
                    @else
                        <div class="text-center text-muted py-4">لا يوجد فيديو مرفوع حالياً.</div>
                    @endif
                </div>
            </div>

            <div class="data-card">
                <span class="data-card__label"><i class="fas fa-image"></i> الشعار</span>
                <div class="data-card__media">
                    @if(!empty(optional($school)->logo))
                        <img src="{{ asset('storage/' . $school->logo) }}" alt="Logo">
                    @else
                        <div class="text-center text-muted py-4">لا يوجد شعار مرفوع حالياً.</div>
                    @endif
                </div>
            </div>

            <div class="data-card">
                <span class="data-card__label"><i class="fas fa-id-card"></i> شعار الحسابات</span>
                <div class="data-card__media">
                    @if(!empty(optional($school)->logo_account))
                        <img src="{{ asset('storage/' . $school->logo_account) }}" alt="Account Logo">
                    @else
                        <div class="text-center text-muted py-4">لا يوجد شعار للحسابات حالياً.</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="data-panel">
            <div class="d-flex align-items-center justify-content-between flex-wrap mb-3" style="gap:.75rem;">
                <div>
                    <h3 class="mb-1" style="font-size:1.02rem;font-weight:800;color:#2f2b3a;">معاينة المعلومات الحالية</h3>
                    <p class="mb-0" style="color:#7b7590;font-size:.9rem;">عرض سريع للقيم الحالية قبل فتح نافذة التعديل.</p>
                </div>
            </div>

            <table class="table data-table">
                <thead>
                    <tr>
                        <th>العنصر</th>
                        <th>القيمة</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>اسم المدرسة</td>
                        <td>{{ optional($school)->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>اسم المدرسة بالإنكليزي</td>
                        <td>{{ optional($school)->name_en ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>الفيديو</td>
                        <td>{{ !empty(optional($school)->video) ? 'مرفوع' : 'غير مرفوع' }}</td>
                    </tr>
                    <tr>
                        <td>الشعار</td>
                        <td>{{ !empty(optional($school)->logo) ? 'مرفوع' : 'غير مرفوع' }}</td>
                    </tr>
                    <tr>
                        <td>شعار الحسابات</td>
                        <td>{{ !empty(optional($school)->logo_account) ? 'مرفوع' : 'غير مرفوع' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade v2-dashboard-modal" id="schoolDataModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('school_data_update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">تعديل بيانات المدرسة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="school_name">اسم المدرسة</label>
                                <input id="school_name" type="text" name="name" class="form-control" value="{{ optional($school)->name }}" style="direction: rtl">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="school_name_en">اسم المدرسة بالإنكليزي</label>
                                <input id="school_name_en" type="text" name="name_en" class="form-control" value="{{ optional($school)->name_en }}">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="school_video">الفيديو</label>
                                <input id="school_video" type="file" name="video" class="form-control" accept="video/*">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="school_logo">الشعار</label>
                                <input id="school_logo" type="file" name="logo" class="form-control" accept="image/*">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="school_logo_account">شعار الحسابات</label>
                                <input id="school_logo_account" type="file" name="logo_account" class="form-control" accept="image/*">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
