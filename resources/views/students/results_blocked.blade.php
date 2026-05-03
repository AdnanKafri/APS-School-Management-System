@extends('students.layouts.app4')

@section('title')
النتائج غير متاحة
@endsection

@section('css')
<style>
    .results-blocked-page {
        min-height: calc(100vh - 140px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 32px 16px;
        direction: rtl;
    }

    .results-blocked-card {
        width: min(720px, 100%);
        background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
        border: 1px solid #d9e4f2;
        border-radius: 24px;
        padding: 40px 32px;
        text-align: center;
        box-shadow: 0 18px 50px rgba(31, 45, 61, 0.08);
    }

    .results-blocked-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px 16px;
        margin-bottom: 18px;
        border-radius: 999px;
        background: #e8f1ff;
        color: #1d4ed8;
        font-size: 14px;
        font-weight: 700;
    }

    .results-blocked-title {
        margin: 0 0 12px;
        color: #122033;
        font-size: 32px;
        font-weight: 800;
        line-height: 1.35;
    }

    .results-blocked-copy {
        margin: 0 auto;
        max-width: 520px;
        color: #526277;
        font-size: 17px;
        line-height: 1.9;
    }

    .results-blocked-note {
        margin-top: 22px;
        color: #7a8799;
        font-size: 14px;
        line-height: 1.8;
    }

    .results-blocked-actions {
        display: flex;
        justify-content: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 28px;
    }

    .results-blocked-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 170px;
        padding: 12px 18px;
        border-radius: 14px;
        text-decoration: none;
        font-size: 15px;
        font-weight: 700;
        transition: transform .2s ease, box-shadow .2s ease, background-color .2s ease;
    }

    .results-blocked-btn:hover {
        text-decoration: none;
        transform: translateY(-1px);
    }

    .results-blocked-btn--primary {
        background: #0f6cbd;
        color: #ffffff;
        box-shadow: 0 10px 24px rgba(15, 108, 189, 0.22);
    }

    .results-blocked-btn--primary:hover {
        color: #ffffff;
        background: #0c5ea5;
    }

    .results-blocked-btn--ghost {
        background: #ffffff;
        color: #1f3552;
        border: 1px solid #d9e4f2;
    }

    .results-blocked-btn--ghost:hover {
        color: #1f3552;
        background: #f8fbff;
    }

    @media (max-width: 767px) {
        .results-blocked-card {
            padding: 28px 20px;
            border-radius: 18px;
        }

        .results-blocked-title {
            font-size: 26px;
        }

        .results-blocked-copy {
            font-size: 15px;
        }

        .results-blocked-btn {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="results-blocked-page">
    <div class="results-blocked-card">
        <div class="results-blocked-badge">{{ $pageLabel }}</div>
        <h1 class="results-blocked-title">{{ $blockedTitle }}</h1>
        <p class="results-blocked-copy">{{ $blockedMessage }}</p>
        <p class="results-blocked-note">سيتم إتاحة هذه الصفحة للطلاب بعد الانتهاء من مراجعة الدرجات واعتمادها بشكل نهائي.</p>

        <div class="results-blocked-actions">
            <a href="{{ route('dashboard.student.lessons', $student->id) }}" class="results-blocked-btn results-blocked-btn--primary">العودة إلى المواد</a>
            <a href="{{ route('dashboard.student.profile', [$student->id, $room_id]) }}" class="results-blocked-btn results-blocked-btn--ghost">العودة إلى الملف الشخصي</a>
        </div>
    </div>
</div>
@endsection
