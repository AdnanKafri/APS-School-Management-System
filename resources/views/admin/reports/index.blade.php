@extends('admin.layouts.v2')

@section('page_title', 'التقارير')
@section('page_subtitle', 'الوصول السريع إلى تقارير الحضور والأداء الدراسي')

@section('style')
<style>
    .reports-v2 { direction: rtl; }
    .reports-breadcrumbs { display:inline-flex; align-items:center; gap:.45rem; font-size:.88rem; }
    .reports-breadcrumbs__link { color:#8a869a; text-decoration:none; font-weight:700; }
    .reports-breadcrumbs__link:hover { color:#5b4b8a; text-decoration:none; }
    .reports-breadcrumbs__sep { color:#b8b2c6; font-weight:700; }
    .reports-breadcrumbs__current { color:#2f2b3a; font-weight:800; }

    .reports-grid { display:grid; gap:1rem; grid-template-columns:repeat(auto-fit,minmax(240px,1fr)); }
    .report-shortcut {
        display:flex; align-items:center; justify-content:space-between; gap:1rem;
        border:1px solid #ece9f4; border-radius:18px; padding:1.2rem 1rem;
        background:linear-gradient(180deg,#ffffff 0%,#f8f7fc 100%);
        text-decoration:none; color:#2f2b3a;
    }
    .report-shortcut:hover { text-decoration:none; color:#2f2b3a; border-color:#d8d0eb; }
    .report-shortcut__title { margin:0; font-size:1rem; font-weight:800; }
    .report-shortcut__desc { margin:.3rem 0 0; color:#8a869a; font-size:.85rem; }
    .report-shortcut__icon {
        width:48px; height:48px; border-radius:14px; display:inline-flex;
        align-items:center; justify-content:center; font-size:1.25rem;
        color:#4f46e5; background:rgba(79,70,229,.1);
    }
</style>
@endsection

@section('breadcrumbs')
<nav class="reports-breadcrumbs" aria-label="Breadcrumb">
    <a href="{{ route('dashboard.index') }}" class="reports-breadcrumbs__link">لوحة التحكم</a>
    <span class="reports-breadcrumbs__sep">/</span>
    <span class="reports-breadcrumbs__current">قسم التقارير</span>
</nav>
@endsection

@section('content')
<div class="reports-v2">
    <div class="v2-card" style="padding:1.2rem;">
        <div class="reports-grid">
            @can('teacher_report')
                <a href="{{ route('teacher_sch') }}" class="report-shortcut">
                    <div>
                        <h3 class="report-shortcut__title">حضور المعلمين</h3>
                        <p class="report-shortcut__desc">متابعة الحضور اليومي للكوادر التعليمية</p>
                    </div>
                    <span class="report-shortcut__icon"><i class="far fa-calendar"></i></span>
                </a>
            @endcan

            @can('student_report')
                <a href="{{ route('student_sch') }}" class="report-shortcut">
                    <div>
                        <h3 class="report-shortcut__title">حضور الطلاب</h3>
                        <p class="report-shortcut__desc">تقارير الغياب والحضور للطلاب</p>
                    </div>
                    <span class="report-shortcut__icon"><i class="far fa-calendar-check"></i></span>
                </a>
            @endcan

            @can('student_report_chart')
                <a href="{{ route('student_report_chart') }}" class="report-shortcut">
                    <div>
                        <h3 class="report-shortcut__title">مستوى الطالب</h3>
                        <p class="report-shortcut__desc">تحليل التقدم الأكاديمي عبر الرسوم البيانية</p>
                    </div>
                    <span class="report-shortcut__icon"><i class="far fa-chart-bar"></i></span>
                </a>
            @endcan
        </div>
    </div>
</div>
@endsection
