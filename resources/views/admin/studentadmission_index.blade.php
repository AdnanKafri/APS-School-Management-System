@extends('admin.layouts.v2')

@section('page_title', 'قسم القبول')
@section('page_subtitle', 'بوابة إدارة إعدادات التسجيل وطلبات القبول')

@section('style')
<style>
    .admission-home {
        direction: rtl;
    }

    .admission-home .v2-card.main-shell {
        padding: 1.35rem;
    }

    .admission-home .page-intro {
        margin-bottom: 1rem;
    }

    .admission-home .page-intro h3 {
        margin: 0 0 .35rem;
        font-size: 1.2rem;
        color: #2f2b3a;
        font-weight: 800;
    }

    .admission-home .page-intro p {
        margin: 0;
        color: #7a748e;
        font-size: .92rem;
        line-height: 1.7;
    }

    .admission-home .entry-card {
        height: 100%;
        border: 1px solid #e9e5f4;
        border-radius: 18px;
        padding: 1.1rem;
        background: linear-gradient(180deg, #fff 0%, #fcfbff 100%);
    }

    .admission-home .entry-card h4 {
        margin: 0 0 .45rem;
        font-size: 1.05rem;
        font-weight: 800;
        color: #2f2b3a;
    }

    .admission-home .entry-card p {
        margin: 0 0 .95rem;
        color: #766f89;
        line-height: 1.7;
        min-height: 52px;
    }

    .admission-home .entry-meta {
        font-size: .78rem;
        color: #8a84a0;
        margin-bottom: .85rem;
    }
</style>
@endsection

@section('breadcrumbs')
<nav class="breadcrumbs">
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item">الرئيسية</a>
    <a class="breadcrumbs__item is-active">قسم القبول</a>
</nav>
@endsection

@section('content')
<div class="admission-home">
    <div class="v2-card main-shell">
        <div class="page-intro">
            <h3>لوحة إدارة القبول</h3>
            <p>اختر المسار المطلوب: ضبط إعدادات التسجيل أو متابعة طلبات الطلاب. تم الحفاظ على سير العمل الإداري مع تحسين تجربة العرض والتنظيم.</p>
        </div>

        <div class="row">
            <div class="col-12 col-lg-6 mb-3 mb-lg-0">
                <div class="entry-card">
                    <div class="entry-meta">التهيئة والتحكم</div>
                    <h4>إعدادات القبول والتسجيل</h4>
                    <p>ضبط الرسوم حسب المرحلة، شروط المدرسة والنقل (عربي/إنكليزي)، وحالة فتح التسجيل من الموقع.</p>
                    <a href="{{ route('studentadmission_setup') }}" class="btn btn-primary">الدخول إلى الإعدادات</a>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="entry-card">
                    <div class="entry-meta">مراجعة وتشغيل</div>
                    <h4>طلبات القبول</h4>
                    <p>عرض الطلبات الواردة، فتح تفاصيل كل طالب، التحقق من الوثائق، ثم الاعتماد ضمن سير العمل المعتاد.</p>
                    <a href="{{ route('studentadmission_requests') }}" class="btn btn-primary">الدخول إلى الطلبات</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
