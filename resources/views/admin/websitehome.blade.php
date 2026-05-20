@extends('admin.layouts.v2')
@section('body_class', 'website-mgmt-v2')

@section('page_title', 'الصفحة الأساسية للموقع')
@section('page_subtitle', 'إدارة أقسام الواجهة العامة للموقع من خلال بطاقات حديثة وتجربة تنظيمية موحدة')

@section('style')
<style>
    .website-home-v2 {
        direction: rtl;
        text-align: right;
    }

    .website-home-v2 .home-shell {
        display: grid;
        gap: 1rem;
    }

    .website-home-v2 .home-hero,
    .website-home-v2 .home-card {
        border: 1px solid #ebe7f5;
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 12px 30px rgba(36, 30, 62, 0.06);
    }

    .website-home-v2 .home-hero {
        padding: 1.15rem 1.2rem;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 1rem;
        align-items: center;
    }

    .website-home-v2 .home-hero h3 {
        margin: 0 0 .35rem;
        font-size: 1.15rem;
        font-weight: 800;
        color: #2f2b3a;
        line-height: 1.45;
    }

    .website-home-v2 .home-hero p {
        margin: 0;
        color: #746f84;
        line-height: 1.85;
        font-size: .92rem;
        max-width: 60rem;
    }

    .website-home-v2 .home-actions {
        display: flex;
        gap: .65rem;
        flex-wrap: wrap;
    }

    .website-home-v2 .home-actions .btn {
        border-radius: 12px;
        font-weight: 800;
        white-space: nowrap;
        min-height: 44px;
        display: inline-flex;
        align-items: center;
        padding-inline: 1rem;
    }

    .website-home-v2 .home-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(225px, 1fr));
        gap: 1rem;
    }

    .website-home-v2 .home-card {
        text-decoration: none;
        color: inherit;
        padding: 1rem 1rem .95rem;
        min-height: 158px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
    }

    .website-home-v2 .home-card:hover {
        text-decoration: none;
        transform: translateY(-2px);
        border-color: rgba(59,130,246,.22);
        box-shadow: 0 16px 36px rgba(36, 30, 62, 0.08);
    }

    .website-home-v2 .home-card__top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: .85rem;
        margin-bottom: .8rem;
    }

    .website-home-v2 .home-card__icon {
        width: 50px;
        height: 50px;
        border-radius: 16px;
        background: linear-gradient(135deg, rgba(91, 75, 138, .12), rgba(59,130,246,.12));
        color: #5b4b8a;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        flex: 0 0 50px;
    }

    .website-home-v2 .home-card__badge {
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

    .website-home-v2 .home-card h4 {
        margin: 0 0 .35rem;
        font-size: 1.01rem;
        font-weight: 800;
        color: #2f2b3a;
    }

    .website-home-v2 .home-card p {
        margin: 0;
        color: #7b7590;
        line-height: 1.8;
        font-size: .89rem;
    }

    .website-home-v2 .home-card__meta {
        margin-top: .9rem;
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        color: #5b4b8a;
        font-size: .83rem;
        font-weight: 800;
    }

    @media (max-width: 768px) {
        .website-home-v2 .home-hero {
            padding: 1rem;
        }

        .website-home-v2 .home-card {
            padding: 1rem;
        }

        .website-home-v2 .home-actions .btn {
            width: 100%;
        }
    }
</style>
@endsection

@section('breadcrumbs')
<nav class="breadcrumbs">
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item">الرئيسية</a>
    <a href="{{ route('websitecontroller') }}" class="breadcrumbs__item">قسم التحكم الكامل بالموقع</a>
    <a class="breadcrumbs__item is-active">الصفحة الأساسية</a>
</nav>
@endsection

@section('content')
<div class="website-home-v2">
    <div class="home-shell">
        <div class="home-hero">
            <div>
                <h3>الصفحة الأساسية للموقع</h3>
                <p>هذه الواجهة تجمع أقسام الموقع العام الأساسية في لوحة واحدة، مع بطاقات مرتبة ومسارات واضحة لتعديل كل قسم بسرعة دون مغادرة لوحة التحكم الحديثة.</p>
            </div>

            <div class="home-actions">
                <a href="{{ route('websitecontroller') }}" class="btn btn-primary">قسم التحكم الكامل بالموقع</a>
                <a href="{{ route('school_data') }}" class="btn btn-outline-primary">بيانات المدرسة</a>
            </div>
        </div>

        <div class="home-grid">
            <a href="{{ route('slider') }}" class="home-card">
                <div>
                    <div class="home-card__top">
                        <span class="home-card__icon"><i class="far fa-image"></i></span>
                        <span class="home-card__badge">الواجهة المرئية</span>
                    </div>
                    <h4>السلايدر</h4>
                    <p>إدارة صور العرض الرئيسية التي تظهر في الصفحة الأولى للموقع.</p>
                </div>
                <span class="home-card__meta"><i class="fas fa-arrow-left"></i> فتح القسم</span>
            </a>

            <a href="{{ route('vision_mission_website') }}" class="home-card">
                <div>
                    <div class="home-card__top">
                        <span class="home-card__icon"><i class="fas fa-bullseye"></i></span>
                        <span class="home-card__badge">المحتوى التعريفي</span>
                    </div>
                    <h4>الرسالة والرؤية</h4>
                    <p>تعديل نص الرسالة والرؤية بما يتوافق مع هوية المدرسة ورسالتها التربوية.</p>
                </div>
                <span class="home-card__meta"><i class="fas fa-arrow-left"></i> فتح القسم</span>
            </a>

            <a href="{{ route('about') }}" class="home-card">
                <div>
                    <div class="home-card__top">
                        <span class="home-card__icon"><i class="fas fa-star"></i></span>
                        <span class="home-card__badge">التعريف</span>
                    </div>
                    <h4>من نحن</h4>
                    <p>صفحة نبذة المدرسة ومحتواها التعريفي الأساسي.</p>
                </div>
                <span class="home-card__meta"><i class="fas fa-arrow-left"></i> فتح القسم</span>
            </a>

            <a href="{{ route('service_website') }}" class="home-card">
                <div>
                    <div class="home-card__top">
                        <span class="home-card__icon"><i class="fas fa-layer-group"></i></span>
                        <span class="home-card__badge">الخدمات</span>
                    </div>
                    <h4>خدماتنا</h4>
                    <p>إدارة الخدمات التي يراها الزائر في الصفحة الرئيسية.</p>
                </div>
                <span class="home-card__meta"><i class="fas fa-arrow-left"></i> فتح القسم</span>
            </a>

            <a href="{{ route('our_services_feature_website') }}" class="home-card">
                <div>
                    <div class="home-card__top">
                        <span class="home-card__icon"><i class="fas fa-gem"></i></span>
                        <span class="home-card__badge">الميزات</span>
                    </div>
                    <h4>الخدمات والميزات</h4>
                    <p>تعديل النقاط البارزة التي تشرح ما يميز المدرسة وموقعها.</p>
                </div>
                <span class="home-card__meta"><i class="fas fa-arrow-left"></i> فتح القسم</span>
            </a>

            <a href="{{ route('how_it_works_website') }}" class="home-card">
                <div>
                    <div class="home-card__top">
                        <span class="home-card__icon"><i class="fas fa-cogs"></i></span>
                        <span class="home-card__badge">الشرح</span>
                    </div>
                    <h4>كيف نعمل</h4>
                    <p>صفحة توضيح خطوات العمل أو طريقة تقديم الخدمات للزائر.</p>
                </div>
                <span class="home-card__meta"><i class="fas fa-arrow-left"></i> فتح القسم</span>
            </a>

            <a href="{{ route('gallery') }}" class="home-card">
                <div>
                    <div class="home-card__top">
                        <span class="home-card__icon"><i class="far fa-images"></i></span>
                        <span class="home-card__badge">الصور</span>
                    </div>
                    <h4>معرض الصور</h4>
                    <p>إدارة ألبوم الصور المعروض في الواجهة العامة.</p>
                </div>
                <span class="home-card__meta"><i class="fas fa-arrow-left"></i> فتح القسم</span>
            </a>

            <a href="{{ route('counter_website') }}" class="home-card">
                <div>
                    <div class="home-card__top">
                        <span class="home-card__icon"><i class="fas fa-chart-line"></i></span>
                        <span class="home-card__badge">الإحصاءات</span>
                    </div>
                    <h4>عداد الموقع</h4>
                    <p>تعديل أرقام المؤشرات والإحصاءات الظاهرة في الصفحة الرئيسية.</p>
                </div>
                <span class="home-card__meta"><i class="fas fa-arrow-left"></i> فتح القسم</span>
            </a>

            <a href="{{ route('testimonials_website') }}" class="home-card">
                <div>
                    <div class="home-card__top">
                        <span class="home-card__icon"><i class="fas fa-comment-dots"></i></span>
                        <span class="home-card__badge">آراء</span>
                    </div>
                    <h4>التوصيات</h4>
                    <p>إدارة شهادات وآراء أولياء الأمور أو الزوار.</p>
                </div>
                <span class="home-card__meta"><i class="fas fa-arrow-left"></i> فتح القسم</span>
            </a>

            <a href="{{ route('blogs_website') }}" class="home-card">
                <div>
                    <div class="home-card__top">
                        <span class="home-card__icon"><i class="fas fa-newspaper"></i></span>
                        <span class="home-card__badge">المدونة</span>
                    </div>
                    <h4>المدونات</h4>
                    <p>التحكم بمحتوى الأخبار والمقالات المنشورة على الموقع.</p>
                </div>
                <span class="home-card__meta"><i class="fas fa-arrow-left"></i> فتح القسم</span>
            </a>

            <a href="{{ route('footer_website') }}" class="home-card">
                <div>
                    <div class="home-card__top">
                        <span class="home-card__icon"><i class="fas fa-address-card"></i></span>
                        <span class="home-card__badge">التواصل</span>
                    </div>
                    <h4>معلومات التواصل</h4>
                    <p>تحديث بيانات التواصل والروابط الظاهرة في التذييل.</p>
                </div>
                <span class="home-card__meta"><i class="fas fa-arrow-left"></i> فتح القسم</span>
            </a>

            <a href="{{ route('faqs_website') }}" class="home-card">
                <div>
                    <div class="home-card__top">
                        <span class="home-card__icon"><i class="fas fa-question-circle"></i></span>
                        <span class="home-card__badge">المساعدة</span>
                    </div>
                    <h4>الأسئلة الشائعة</h4>
                    <p>إدارة الأسئلة المتكررة التي تساعد الزائر على فهم الخدمات.</p>
                </div>
                <span class="home-card__meta"><i class="fas fa-arrow-left"></i> فتح القسم</span>
            </a>

            <a href="{{ route('contact_website') }}" class="home-card">
                <div>
                    <div class="home-card__top">
                        <span class="home-card__icon"><i class="fas fa-envelope-open-text"></i></span>
                        <span class="home-card__badge">الرسائل</span>
                    </div>
                    <h4>رسائل العملاء</h4>
                    <p>قراءة الرسائل الواردة من نموذج التواصل العام.</p>
                </div>
                <span class="home-card__meta"><i class="fas fa-arrow-left"></i> فتح القسم</span>
            </a>
        </div>
    </div>
</div>
@endsection
