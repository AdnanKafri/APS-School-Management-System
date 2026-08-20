@extends('students.layouts.app4')

@section('title', 'الرسائل مع الإدارة')

@section('content')
<main class="main-panel">
    <div class="content-wrapper">
        <div class="sp-page">
            <section class="sp-page-header">
                <div class="sp-page-header__content">
                    <span class="sp-page-header__eyebrow">التواصل المدرسي</span>
                    <h1>الرسائل مع الإدارة</h1>
                    <p>تابع رسائل الإدارة وأرسل استفسارك من خلال المحادثة.</p>
                </div>
                <div class="sp-page-header__aside"><div class="sp-header-stat"><span>الرسائل</span><strong>{{ $messages->count() }}</strong></div></div>
            </section>

            <section class="sp-card sp-admin-chat">
                <div class="sp-chat__conversation-header"><span class="sp-icon-box sp-icon-box--blue"><i class="mdi mdi-office-building-outline"></i></span><span><strong>إدارة المدرسة</strong><small>قناة التواصل الرسمية</small></span></div>
                <div class="sp-admin-chat__messages" id="adminMessages">
                    @forelse ($messages as $item)
                        <article class="sp-message {{ $item->type == 0 ? 'is-remote' : 'is-self' }}">
                            <img src="{{ $item->type == 0 ? asset('student/adminvvv-01.png') : ($student->image ? asset('storage/' . $student->image) : asset('student/avatar.png')) }}" alt="{{ $item->type == 0 ? 'الإدارة' : 'الطالب' }}">
                            <div>
                                <strong>{{ $item->type == 0 ? 'الإدارة' : $student->first_name . ' ' . $student->last_name }}</strong>
                                <p>{{ $item->message }}</p>
                                <time>{{ $item->created_at }}</time>
                            </div>
                        </article>
                    @empty
                        <div class="sp-empty sp-empty--compact"><span class="sp-empty__icon"><i class="mdi mdi-message-outline"></i></span><h3>لا توجد رسائل بعد</h3></div>
                    @endforelse
                </div>
                <form class="sp-chat__composer" action="{{ route('add_mes') }}" method="POST">
                    @csrf
                    <input type="text" name="message" class="form-control" autocomplete="off" placeholder="اكتب رسالتك" required>
                    <button type="submit" class="sp-btn sp-btn--primary"><i class="mdi mdi-send"></i> إرسال</button>
                </form>
            </section>
        </div>
    </div>
</main>
@endsection

@section('js')
<script>
    window.addEventListener('load', function () {
        var messages = document.getElementById('adminMessages');
        if (messages) {
            messages.scrollTop = messages.scrollHeight;
        }
    });
</script>
@endsection
