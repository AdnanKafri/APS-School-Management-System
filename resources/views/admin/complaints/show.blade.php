@extends('admin.layouts.v2')

@section('page_title', 'تفاصيل الشكوى')
@section('page_subtitle', 'عرض الشكوى ومراجعة سجل حالتها مع إمكانية الوسم كمراجعة أو الأرشفة')

@section('style')
<style>
    .complaint-show {
        direction: rtl;
        text-align: right;
    }

    .complaint-show .review-shell {
        display: grid;
        gap: 1.2rem;
    }

    .complaint-show .review-hero,
    .complaint-show .review-card {
        border: 1px solid #ebe7f5;
        border-radius: 20px;
        background: #fff;
        box-shadow: 0 14px 32px rgba(47, 34, 80, 0.06);
    }

    .complaint-show .review-hero {
        padding: 1.4rem 1.45rem;
        background:
            radial-gradient(circle at top right, rgba(91, 75, 138, 0.12), transparent 33%),
            linear-gradient(135deg, #ffffff 0%, #fbfaff 100%);
    }

    .complaint-show .review-card {
        padding: 1.15rem 1.2rem;
    }

    .complaint-show .review-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1.2rem;
        flex-wrap: wrap;
    }

    .complaint-show .review-title {
        margin: 0 0 .25rem;
        font-size: 1.3rem;
        font-weight: 800;
        color: #2f2b3a;
        line-height: 1.5;
    }

    .complaint-show .review-subtitle {
        margin: 0;
        color: #746f84;
        line-height: 1.8;
        font-size: .92rem;
    }

    .complaint-show .pill-row {
        display: flex;
        flex-wrap: wrap;
        gap: .55rem;
        margin-top: 1.05rem;
    }

    .complaint-show .pill {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .42rem .72rem;
        border-radius: 999px;
        font-size: .78rem;
        font-weight: 800;
        background: #f0edf8;
        color: #5a4a80;
    }

    .complaint-show .pill.is-success {
        background: #eefaf3;
        color: #1f8f5f;
    }

    .complaint-show .pill.is-info {
        background: #eef6ff;
        color: #2f6fc8;
    }

    .complaint-show .pill.is-muted {
        background: #f3f1f8;
        color: #6d6781;
    }

    .complaint-show .review-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1rem;
    }

    .complaint-show .info-card {
        border: 1px solid #ebe7f5;
        border-radius: 16px;
        background: #fcfbff;
        padding: 1.05rem 1.05rem 1rem;
    }

    .complaint-show .info-card__label {
        display: block;
        margin-bottom: .35rem;
        color: #7d7692;
        font-size: .8rem;
        font-weight: 700;
        line-height: 1.6;
    }

    .complaint-show .info-card__value {
        color: #2f2b3a;
        font-size: .95rem;
        font-weight: 800;
        line-height: 1.85;
        word-break: break-word;
        white-space: pre-line;
    }

    .complaint-show .text-box {
        border: 1px solid #ebe7f5;
        border-radius: 16px;
        background: #fcfbff;
        padding: 1.25rem 1.2rem 1.15rem;
        line-height: 2.05;
        color: #2f2b3a;
        white-space: pre-line;
    }

    .complaint-show .timeline {
        display: grid;
        gap: .85rem;
    }

    .complaint-show .timeline-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        padding: .95rem 1.05rem;
        border-radius: 14px;
        border: 1px solid #ebe7f5;
        background: #fff;
        color: #4d4762;
        line-height: 1.7;
    }

    .complaint-show .timeline-row strong {
        color: #2f2b3a;
    }

    .complaint-show .review-actions {
        display: flex;
        gap: .7rem;
        flex-wrap: wrap;
        justify-content: flex-end;
        margin-top: .35rem;
    }

    @media (max-width: 768px) {
        .complaint-show .review-hero {
            padding: 1.05rem 1rem;
        }

        .complaint-show .review-card {
            padding: 1rem;
        }

        .complaint-show .review-grid {
            gap: .75rem;
        }

        .complaint-show .info-card,
        .complaint-show .text-box {
            padding: .95rem;
        }

        .complaint-show .timeline-row {
            padding: .9rem .95rem;
            gap: .65rem;
        }

        .complaint-show .review-top {
            gap: .9rem;
        }

        .complaint-show .review-actions .btn {
            width: 100%;
        }
    }
</style>
@endsection

@section('breadcrumbs')
<nav class="breadcrumbs">
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item">الرئيسية</a>
    <a href="{{ route('admin.complaints.index') }}" class="breadcrumbs__item">إدارة الشكاوى</a>
    <a class="breadcrumbs__item is-active">تفاصيل الشكوى</a>
</nav>
@endsection

@section('content')
@php
    $statusClass = $complaint->status === 'viewed' ? 'is-info' : ($complaint->status === 'archived' ? 'is-muted' : 'is-success');
    $statusText = [
        'new' => 'جديدة',
        'viewed' => 'تمت المراجعة',
        'archived' => 'مؤرشفة',
    ][$complaint->status] ?? 'جديدة';
    $typeText = $complaint->type === 'transport' ? 'شكوى نقل' : 'شكوى دراسية';
@endphp

<div class="complaint-show">
    <div class="review-shell">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="review-hero">
            <div class="review-top">
                <div>
                    <h1 class="review-title">#{{ $complaint->id }} - {{ $typeText }}</h1>
                    <p class="review-subtitle">تفاصيل الشكوى محفوظة بالكامل ويمكن الرجوع إليها لاحقاً مع الحفاظ على سجل الحالة.</p>
                </div>
                <div class="review-actions">
                    @if($complaint->status !== 'archived')
                        <form method="POST" action="{{ route('admin.complaints.viewed', $complaint->id) }}" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary">تمييز كمراجعة</button>
                        </form>
                        <form method="POST" action="{{ route('admin.complaints.archive', $complaint->id) }}" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-primary">أرشفة الشكوى</button>
                        </form>
                    @endif
                    <a href="{{ route('admin.complaints.index') }}" class="btn btn-light">العودة للقائمة</a>
                </div>
            </div>

            <div class="pill-row">
                <span class="pill {{ $statusClass }}">{{ $statusText }}</span>
                <span class="pill is-info">{{ $typeText }}</span>
                <span class="pill is-muted">#{{ $complaint->id }}</span>
            </div>
        </div>

        <div class="review-card">
            <div class="review-grid">
                <div class="info-card">
                    <span class="info-card__label">اسم الطالب</span>
                    <div class="info-card__value">{{ $complaint->student_name }}</div>
                </div>
                <div class="info-card">
                    <span class="info-card__label">اسم ولي الأمر / المشتكي</span>
                    <div class="info-card__value">{{ $complaint->applicant_name }}</div>
                </div>
                <div class="info-card">
                    <span class="info-card__label">رقم الهاتف</span>
                    <div class="info-card__value">{{ $complaint->phone }}</div>
                </div>
                <div class="info-card">
                    <span class="info-card__label">الصف / المرحلة</span>
                    <div class="info-card__value">{{ $complaint->class_name }}</div>
                </div>
                <div class="info-card">
                    <span class="info-card__label">الشعبة / الغرفة</span>
                    <div class="info-card__value">{{ $complaint->section_name }}</div>
                </div>
                @if($complaint->type === 'transport')
                    <div class="info-card">
                        <span class="info-card__label">رقم الباص</span>
                        <div class="info-card__value">{{ $complaint->bus_number ?: '-' }}</div>
                    </div>
                @endif
            </div>
        </div>

        <div class="review-card">
            <div class="review-grid" style="grid-template-columns: 1fr;">
                <div>
                    <h3 style="margin:0 0 .6rem;font-size:1rem;font-weight:800;color:#2f2b3a;">نص الشكوى</h3>
                    <div class="text-box">{{ $complaint->complaint_text }}</div>
                </div>
            </div>
        </div>

        <div class="review-card">
            <div class="review-grid" style="grid-template-columns: 1fr;">
                <div>
                    <h3 style="margin:0 0 .6rem;font-size:1rem;font-weight:800;color:#2f2b3a;">سجل الحالة</h3>
                    <div class="timeline">
                        <div class="timeline-row">
                            <strong>تاريخ الإرسال</strong>
                            <span>{{ optional($complaint->created_at)->format('Y-m-d H:i') }}</span>
                        </div>
                        <div class="timeline-row">
                            <strong>تاريخ المراجعة</strong>
                            <span>{{ optional($complaint->viewed_at)->format('Y-m-d H:i') ?: '-' }}</span>
                        </div>
                        <div class="timeline-row">
                            <strong>تاريخ الأرشفة</strong>
                            <span>{{ optional($complaint->archived_at)->format('Y-m-d H:i') ?: '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
