@extends('admin.layouts.v2')
@section('body_class', 'website-mgmt-v2')

@section('page_title', 'التحكم بالموقع')
@section('page_subtitle', 'بوابة إدارة صفحات الموقع العام والإعدادات الأساسية من لوحة حديثة ومتناسقة')

@section('style')
<style>
    .website-control-v2 {
        direction: rtl;
        text-align: right;
    }

    .website-control-v2 .control-shell {
        display: grid;
        gap: 1rem;
    }

    .website-control-v2 .control-hero,
    .website-control-v2 .control-card {
        border: 1px solid #ebe7f5;
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 12px 30px rgba(36, 30, 62, 0.06);
    }

    .website-control-v2 .control-hero {
        padding: 1.15rem 1.2rem;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 1rem;
        align-items: center;
    }

    .website-control-v2 .control-hero__copy {
        min-width: 0;
    }

    .website-control-v2 .control-hero h3 {
        margin: 0 0 .35rem;
        font-size: 1.15rem;
        font-weight: 800;
        color: #2f2b3a;
        line-height: 1.45;
    }

    .website-control-v2 .control-hero p {
        margin: 0;
        color: #746f84;
        line-height: 1.85;
        font-size: .92rem;
        max-width: 58rem;
    }

    .website-control-v2 .control-toolbar {
        display: flex;
        gap: .65rem;
        flex-wrap: wrap;
    }

    .website-control-v2 .control-toolbar .btn {
        border-radius: 12px;
        font-weight: 800;
        white-space: nowrap;
        padding-inline: 1rem;
        min-height: 44px;
        display: inline-flex;
        align-items: center;
    }

    .website-control-v2 .control-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
    }

    .website-control-v2 .control-card {
        padding: 1.1rem 1.1rem 1rem;
        text-decoration: none;
        color: inherit;
        display: block;
        transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
        min-height: 148px;
    }

    .website-control-v2 .control-card:hover {
        text-decoration: none;
        transform: translateY(-2px);
        border-color: rgba(59,130,246,.22);
        box-shadow: 0 16px 36px rgba(36, 30, 62, 0.08);
    }

    .website-control-v2 .control-card__top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: .9rem;
        margin-bottom: .8rem;
    }

    .website-control-v2 .control-card__icon {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        background: linear-gradient(135deg, rgba(91, 75, 138, .12), rgba(59,130,246,.12));
        color: #5b4b8a;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.45rem;
        flex: 0 0 52px;
    }

    .website-control-v2 .control-card__badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: .32rem .65rem;
        border-radius: 999px;
        background: #f4f2f8;
        color: #6f6787;
        font-size: .76rem;
        font-weight: 800;
        white-space: nowrap;
    }

    .website-control-v2 .control-card h4 {
        margin: 0 0 .35rem;
        font-size: 1.02rem;
        font-weight: 800;
        color: #2f2b3a;
    }

    .website-control-v2 .control-card p {
        margin: 0;
        color: #7b7590;
        line-height: 1.8;
        font-size: .9rem;
    }

    @media (max-width: 768px) {
        .website-control-v2 .control-hero {
            padding: 1rem;
        }

        .website-control-v2 .control-card {
            padding: 1rem;
        }

        .website-control-v2 .control-toolbar .btn {
            width: 100%;
        }
    }
</style>
@endsection

@section('breadcrumbs')
<nav class="breadcrumbs">
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item">الرئيسية</a>
    <a class="breadcrumbs__item is-active">التحكم بالموقع</a>
</nav>
@endsection

@section('content')
<div class="website-control-v2">
    <div class="control-shell">
        <div class="control-hero">
            <div class="control-hero__copy">
                <h3>قسم التحكم الكامل بالموقع</h3>
                <p>من هنا ندخل إلى إعدادات الصفحة الرئيسية، بيانات المدرسة، وباقي الأقسام العامة التي تشكل واجهة الموقع العام. الواجهة الجديدة تبقي التنقل سريعاً وواضحاً ومتناسقاً مع لوحة التحكم الحديثة.</p>
            </div>

            <div class="control-toolbar">
                <a href="{{ route('websitehome') }}" class="btn btn-primary">
                    الصفحة الأساسية
                </a>
                <a href="{{ route('school_data') }}" class="btn btn-outline-primary">
                    بيانات المدرسة
                </a>
            </div>
        </div>

        <div class="control-grid">
            <a href="{{ route('websitehome') }}" class="control-card">
                <div class="control-card__top">
                    <span class="control-card__icon"><i class="fas fa-home"></i></span>
                    <span class="control-card__badge">واجهة الموقع</span>
                </div>
                <h4>الصفحة الأساسية</h4>
                <p>إدارة أقسام الصفحة الرئيسية وروابطها ومحتواها من خلال بطاقات واضحة وسريعة الوصول.</p>
            </a>

            <a href="{{ route('school_data') }}" class="control-card">
                <div class="control-card__top">
                    <span class="control-card__icon"><i class="fas fa-school"></i></span>
                    <span class="control-card__badge">إعدادات المدرسة</span>
                </div>
                <h4>بيانات المدرسة</h4>
                <p>تحديث اسم المدرسة والشعار والفيديو العام واللوحة التعريفية من خلال واجهة موحدة وآمنة.</p>
            </a>
        </div>
    </div>
</div>
@endsection
