@extends('students.layouts.app4')

@section('title', 'الشهادات')

@section('content')
@if (session()->has('success') || session()->has('otherday') || session()->has('othertime') || $errors->any())
    <script>
        window.addEventListener('load', function () {
            @if (session()->has('success')) notif({ msg: @json(session('success')), type: 'success' }); @endif
            @if (session()->has('otherday')) notif({ msg: @json(session('otherday')), type: 'warning' }); @endif
            @if (session()->has('othertime')) notif({ msg: @json(session('othertime')), type: 'warning' }); @endif
            @foreach ($errors->all() as $error) notif({ msg: @json($error), type: 'error' }); @endforeach
        });
    </script>
@endif

<main class="main-panel">
    <div class="content-wrapper">
        <div class="sp-page">
            <section class="sp-page-header">
                <div class="sp-page-header__content">
                    <span class="sp-page-header__eyebrow">إنجازاتك</span>
                    <h1>الشهادات</h1>
                    <p>الشهادات والتكريمات الممنوحة لك من معلمي المواد.</p>
                </div>
                <div class="sp-page-header__aside"><div class="sp-header-stat"><span>عدد الشهادات</span><strong>{{ $certificates->count() }}</strong></div></div>
            </section>

            <section class="sp-card sp-section">
                <div class="sp-card__header sp-section-header"><div><h2>سجل الشهادات</h2><p>يمكن اختيار قالب الشهادة ثم عرضها.</p></div></div>
                <div class="sp-card__body">
                    @if ($certificates->isEmpty())
                        <div class="sp-empty sp-empty--compact"><span class="sp-empty__icon"><i class="mdi mdi-certificate-outline"></i></span><h3>لا توجد شهادات حالياً</h3></div>
                    @else
                        @php
                            $certificateRoutes = [
                                1 => 'edit_2', 2 => 'newcertificate', 3 => 'new441', 4 => 'ncertificate12',
                                5 => 'newcerti12', 6 => 'certificate_22', 7 => 'new22',
                            ];
                        @endphp
                        <div class="sp-table-wrap">
                            <table class="sp-table">
                                <thead><tr><th>المعلم</th><th>تاريخ المنح</th><th>المادة</th><th>الشهادة</th></tr></thead>
                                <tbody>
                                @foreach ($certificates as $item)
                                    <tr>
                                        <td data-label="المعلم">{{ optional($item->teacher)->first_name }} {{ optional($item->teacher)->last_name }}</td>
                                        <td data-label="تاريخ المنح">{{ optional($item->created_at)->format('Y-m-d') }}</td>
                                        <td data-label="المادة"><strong>{{ optional($item->lesson)->name ?: 'غير محددة' }}</strong></td>
                                        <td data-label="الشهادة">
                                            @if ($item->certificate === null)
                                                <button type="button" class="sp-btn sp-btn--primary js-choose-certificate" data-toggle="modal" data-target="#certificateTemplateModal" data-id="{{ $item->id }}"><i class="mdi mdi-palette-outline"></i> اختر قالباً</button>
                                            @elseif (isset($certificateRoutes[(int) $item->certificate]))
                                                <a class="sp-btn sp-btn--soft" href="{{ route($certificateRoutes[(int) $item->certificate], $item->id) }}" target="_blank" rel="noopener"><i class="mdi mdi-eye-outline"></i> عرض الشهادة</a>
                                            @else
                                                <span class="sp-badge sp-badge--warning">قالب غير متاح للعرض</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </section>
        </div>
    </div>
</main>

<div class="modal fade" id="certificateTemplateModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="certificateTemplateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('certificates_stor') }}" method="post" autocomplete="off">
                @csrf
                <input type="hidden" id="certificateId" name="id">
                <div class="modal-header"><h5 class="modal-title" id="certificateTemplateModalLabel">اختيار قالب الشهادة</h5><button type="button" class="close" data-dismiss="modal" aria-label="إغلاق"><span aria-hidden="true">&times;</span></button></div>
                <div class="modal-body">
                    <div class="sp-certificate-grid">
                        @for ($template = 1; $template <= 8; $template++)
                            <label class="sp-certificate-option"><input type="radio" value="{{ $template }}" name="certi" required><span><img src="{{ asset('teachers/img' . $template . '.png') }}" alt="قالب الشهادة {{ $template }}"><strong>القالب {{ $template }}</strong></span></label>
                        @endfor
                    </div>
                </div>
                <div class="modal-footer"><button type="button" class="sp-btn sp-btn--soft" data-dismiss="modal">إلغاء</button><button type="submit" class="sp-btn sp-btn--primary">حفظ القالب</button></div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).on('click', '.js-choose-certificate', function () {
        $('#certificateId').val($(this).data('id'));
        $('#certificateTemplateModal input[name="certi"]').prop('checked', false);
    });
</script>
@endsection
