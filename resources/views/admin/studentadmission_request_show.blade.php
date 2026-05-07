@extends('admin.layouts.v2')

@section('page_title', 'تفاصيل طلب القبول')
@section('page_subtitle', 'مراجعة بيانات الطالب قبل الاعتماد')

@section('style')
<style>
    .admission-request-show {
        direction: rtl;
    }

    .admission-request-show .v2-card.section-card {
        padding: 1rem 1.05rem;
    }

    .admission-request-show .section-title {
        margin: 0 0 .75rem;
        font-size: 1.02rem;
        font-weight: 800;
        color: #2f2b3a;
    }

    .admission-request-show .section-subtitle {
        margin: -.35rem 0 .85rem;
        font-size: .86rem;
        color: #7d7692;
    }

    .admission-request-show .summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
        gap: .6rem;
    }

    .admission-request-show .summary-item {
        border: 1px solid #ebe7f5;
        border-radius: 14px;
        padding: .6rem .7rem;
        background: #fcfbff;
    }

    .admission-request-show .summary-item small {
        display: block;
        color: #7d7692;
        margin-bottom: .15rem;
    }

    .admission-request-show .summary-item strong {
        color: #2f2b3a;
        font-size: .92rem;
    }

    .admission-request-show .doc-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: .6rem;
    }

    .admission-request-show .doc-card {
        border: 1px solid #ece8f5;
        border-radius: 14px;
        padding: .7rem;
        background: #fff;
    }

    .admission-request-show .doc-card h6 {
        margin: 0 0 .6rem;
        font-size: .88rem;
        font-weight: 800;
        color: #3e3758;
    }

    .admission-request-show .doc-actions {
        display: flex;
        gap: .45rem;
        flex-wrap: wrap;
    }

    .admission-request-show .approve-wrap .form-control {
        min-height: 42px;
        border-radius: 12px;
    }

    .admission-request-show .doc-preview-frame {
        width: 100%;
        height: 100%;
        border: 1px solid #ebe7f5;
        border-radius: 12px;
        background: #fff;
    }

    .admission-request-show .doc-preview-image {
        max-width: 100%;
        max-height: 100%;
        display: block;
        margin: 0 auto;
        border-radius: 8px;
        object-fit: contain;
        background: #fff;
    }

    .modal-backdrop {
        z-index: 1040 !important;
    }

    #docPreviewModal.modal {
        z-index: 1055 !important;
    }

    #docPreviewModal .modal-content {
        border: 0;
        border-radius: 16px;
    }

    #docPreviewModal .modal-dialog {
        width: calc(100vw - 2rem);
        max-width: 1100px;
        margin: 1rem auto;
    }

    #docPreviewModal .modal-body {
        padding: .9rem;
        background: #faf9fe;
    }

    .doc-preview-stage {
        min-height: 72vh;
        max-height: 72vh;
        border: 1px solid #ebe7f5;
        border-radius: 12px;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        padding: .5rem;
    }

    .doc-preview-state {
        width: 100%;
        text-align: center;
        color: #7d7692;
        padding: 1rem;
    }

    .doc-preview-state .spinner-border {
        width: 2rem;
        height: 2rem;
    }

    @media (max-width: 992px) {
        .doc-preview-stage {
            min-height: 64vh;
            max-height: 64vh;
        }
    }

    @media (max-width: 576px) {
        #docPreviewModal .modal-dialog {
            width: calc(100vw - 1rem);
            margin: .5rem auto;
        }
        #docPreviewModal .modal-body {
            padding: .6rem;
        }
        .doc-preview-stage {
            min-height: 58vh;
            max-height: 58vh;
            padding: .35rem;
        }
    }

    .admission-request-show .doc-missing-note {
        display: inline-block;
        margin-top: .5rem;
        font-size: .75rem;
        color: #b43a3a;
        background: #fff3f3;
        border: 1px solid #ffdada;
        padding: .2rem .45rem;
        border-radius: 999px;
    }
</style>
@endsection

@section('breadcrumbs')
<nav class="breadcrumbs">
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item">الرئيسية</a>
    <a href="{{ route('studentadmission') }}" class="breadcrumbs__item">قسم القبول</a>
    <a href="{{ route('studentadmission_requests') }}" class="breadcrumbs__item">طلبات القبول</a>
    <a class="breadcrumbs__item is-active">تفاصيل الطلب</a>
</nav>
@endsection

@section('content')
<div class="admission-request-show">
    <div class="v2-card section-card mb-3">
        <h3 class="section-title">بيانات الطالب</h3>
        <p class="section-subtitle">بيانات التسجيل الأساسية كما أدخلها ولي الأمر في نموذج التسجيل.</p>
        <div class="summary-grid">
            <div class="summary-item"><small>الاسم الكامل</small><strong>{{ $record->first_name }} {{ $record->last_name }}</strong></div>
            <div class="summary-item"><small>الهاتف</small><strong>{{ $record->phone ?: '-' }}</strong></div>
            <div class="summary-item"><small>البريد</small><strong>{{ $record->email ?: '-' }}</strong></div>
            <div class="summary-item"><small>الصف المطلوب</small><strong>{{ optional($record->class)->name ?: '-' }}</strong></div>
            <div class="summary-item"><small>تاريخ الميلاد</small><strong>{{ $record->date ?: '-' }}</strong></div>
            <div class="summary-item"><small>الدولة</small><strong>{{ $record->country ?: '-' }}</strong></div>
            <div class="summary-item"><small>المدينة</small><strong>{{ $record->city ?: '-' }}</strong></div>
            <div class="summary-item"><small>الرقم الوطني</small><strong>{{ $record->the_ID_number ?: '-' }}</strong></div>
        </div>
    </div>

    <div class="v2-card section-card mb-3">
        <h3 class="section-title">بيانات الأسرة</h3>
        <div class="summary-grid">
            <div class="summary-item"><small>اسم الأب</small><strong>{{ $record->father_name ?: '-' }}</strong></div>
            <div class="summary-item"><small>اسم الأم</small><strong>{{ $record->mather_name ?: '-' }}</strong></div>
            <div class="summary-item"><small>هاتف الأب</small><strong>{{ $record->father_phone ?: '-' }}</strong></div>
            <div class="summary-item"><small>هاتف الأم</small><strong>{{ $record->mather_phone ?: '-' }}</strong></div>
            <div class="summary-item"><small>هاتف إضافي</small><strong>{{ $record->other_phone ?: '-' }}</strong></div>
        </div>
    </div>

    <div class="v2-card section-card mb-3">
        <h3 class="section-title">معلومات النقل والشروط</h3>
        <div class="summary-grid">
            <div class="summary-item"><small>النقل</small><strong>{{ (int)$record->wants_transport === 1 ? 'نعم' : 'لا' }}</strong></div>
            <div class="summary-item"><small>قبول الشروط المدرسية</small><strong>{{ (int)$record->accepted_terms === 1 ? 'نعم' : 'لا' }}</strong></div>
            <div class="summary-item"><small>قبول شروط النقل</small><strong>{{ (int)$record->accepted_transport_terms === 1 ? 'نعم' : 'لا' }}</strong></div>
            <div class="summary-item"><small>الخطوة الحالية</small><strong>{{ $record->current_step ?: '-' }}</strong></div>
        </div>
    </div>

    <div class="v2-card section-card mb-3">
        <h3 class="section-title">معلومات الدفع والرسوم</h3>
        <div class="summary-grid">
            <div class="summary-item"><small>طريقة الدفع</small><strong>{{ $record->payment_method ?? '-' }}</strong></div>
            <div class="summary-item"><small>حالة الدفع</small><strong>{{ $record->payment_status ?: '-' }}</strong></div>
            <div class="summary-item"><small>تاريخ الدفع</small><strong>{{ $record->payment_date ?: '-' }}</strong></div>
            <div class="summary-item"><small>رسوم التسجيل</small><strong>{{ number_format((float)$record->registration_fee, 2) }}</strong></div>
            <div class="summary-item"><small>رسوم الخدمات</small><strong>{{ number_format((float)$record->services_fee, 2) }}</strong></div>
            <div class="summary-item"><small>رسوم النقل</small><strong>{{ number_format((float)$record->transport_fee, 2) }}</strong></div>
            <div class="summary-item"><small>الإجمالي</small><strong>{{ number_format((float)$record->total_amount, 2) }}</strong></div>
        </div>
    </div>

    <div class="v2-card section-card mb-3">
        <h3 class="section-title">المستندات المرفوعة</h3>
        <p class="section-subtitle">معاينة المستندات داخل النظام أو تنزيلها مباشرة.</p>
        <div class="doc-grid">
            @foreach($docsMeta as $doc)
                    <div class="doc-card">
                        <h6>{{ $doc['label'] }}</h6>
                        <div class="doc-actions">
                            <button type="button" class="btn btn-sm btn-outline-primary js-doc-preview" data-url="{{ $doc['url'] }}" data-download-url="{{ $doc['download_url'] }}" data-label="{{ $doc['label'] }}" data-ext="{{ $doc['ext'] }}" data-exists="{{ $doc['exists'] ? '1' : '0' }}">معاينة</button>
                            <a href="{{ $doc['download_url'] }}" class="btn btn-sm btn-outline-secondary">تنزيل</a>
                        </div>
                        @if(!$doc['exists'])
                            <span class="doc-missing-note">الملف غير متاح في المسار المتوقع</span>
                        @endif
                    </div>
            @endforeach
            @if(empty($docsMeta))
                <span class="text-muted">لا توجد مستندات مرفوعة.</span>
            @endif
        </div>
    </div>

    <div class="v2-card section-card approve-wrap">
        <h3 class="section-title">اعتماد الطالب</h3>
        <p class="section-subtitle">بعد الاعتماد يتم إنشاء الطالب وسجلاته الأكاديمية والفواتير المرتبطة حسب الرسوم المحددة.</p>
        <form method="POST" action="{{ route('approve_student') }}">
            @csrf
            <input type="hidden" name="student_id" value="{{ $record->id }}">
            <div class="row align-items-end">
                <div class="col-12 col-md-4">
                    <label class="d-block mb-1">الصف النهائي</label>
                    <select name="class_id" id="approve_class_id" class="form-control" required>
                        <option value="">اختر الصف</option>
                        @foreach ($classes as $item)
                            <option value="{{ $item->id }}" {{ (string)$record->class1 === (string)$item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-4">
                    <label class="d-block mb-1">الشعبة</label>
                    <select name="room_id" id="approve_room_id" class="form-control" required></select>
                </div>
                <div class="col-12 col-md-4 mt-2 mt-md-0">
                    <button class="btn btn-success btn-block" type="submit">اعتماد الطالب وإنشاء السجلات</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="docPreviewModal">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="docPreviewTitle">معاينة مستند</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div id="docPreviewContainer" class="doc-preview-stage"></div>
            </div>
            <div class="modal-footer">
                <a href="#" id="docPreviewDownload" class="btn btn-primary" download>تنزيل</a>
                <button type="button" class="btn btn-light" data-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(function () {
    function loadRooms(classId, selectedRoomId) {
        $('#approve_room_id').html('');
        if (!classId) {
            return;
        }
        $.get("{{ URL::to('SMT/admin/classes/rooms') }}/" + classId, function (data) {
            $.each(data || [], function (_, value) {
                const isSelected = String(selectedRoomId) === String(value.id) ? 'selected' : '';
                $('#approve_room_id').append('<option value="' + value.id + '" ' + isSelected + '>' + value.name + '</option>');
            });
        });
    }

    const initialClass = $('#approve_class_id').val();
    loadRooms(initialClass, null);

    $(document).on('change', '#approve_class_id', function () {
        loadRooms($(this).val(), null);
    });

    function renderPreview(url, ext, existsFlag) {
        const imageExts = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'];
        const previewBox = $('#docPreviewContainer');
        previewBox.empty();
        const loading = '<div class="doc-preview-state"><div class="spinner-border text-primary mb-2" role="status"></div><div>جاري تحميل المعاينة...</div></div>';
        previewBox.html(loading);

        if (String(existsFlag) !== '1') {
            previewBox.html('<div class="doc-preview-state"><div class="alert alert-warning mb-0">تعذر العثور على الملف في المسار المخزن. يمكنك التحقق من الأرشفة أو إعادة الرفع.</div></div>');
            return;
        }

        if (imageExts.indexOf(ext) !== -1) {
            const img = $('<img>', { src: url, class: 'doc-preview-image', alt: 'document preview' });
            img.on('error', function () {
                previewBox.html('<div class="doc-preview-state"><div class="alert alert-warning mb-0">فشل تحميل الصورة. يمكنك تنزيل الملف مباشرة.</div></div>');
            });
            previewBox.html(img);
            return;
        }

        if (ext === 'pdf') {
            const iframe = $('<iframe>', { src: url, class: 'doc-preview-frame' });
            iframe.on('error', function () {
                previewBox.html('<div class="doc-preview-state"><div class="alert alert-warning mb-0">فشلت معاينة ملف PDF. يمكنك تنزيله مباشرة.</div></div>');
            });
            previewBox.html(iframe);
            return;
        }

        previewBox.html('<div class="doc-preview-state"><div class="alert alert-info mb-0">لا تتوفر معاينة مباشرة لهذا النوع. يمكنك تنزيل الملف.</div></div>');
    }

    $(document).on('click', '.js-doc-preview', function () {
        const url = $(this).data('url');
        const downloadUrl = $(this).data('download-url') || url;
        const label = $(this).data('label') || 'معاينة مستند';
        const ext = ($(this).data('ext') || '').toString().toLowerCase();
        const existsFlag = $(this).data('exists');

        $('#docPreviewTitle').text(label);
        $('#docPreviewDownload').attr('href', downloadUrl);
        renderPreview(url, ext, existsFlag);
        $('#docPreviewModal').modal('show');
    });
});
</script>
@endsection
