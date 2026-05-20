@extends('admin.layouts.v2')
@section('body_class', 'website-mgmt-v2')
@section('page_title', 'السلايدر')
@section('page_subtitle', 'إدارة شرائح الصفحة الرئيسية ومحتواها')
@section('breadcrumbs')
    <nav class="breadcrumbs">
        <a class="breadcrumbs__item is-active">سلايدر </a>
        <a href="{{ route('websitehome') }}" class="breadcrumbs__item ">الصفحة الاساسية</a>
        <a href="{{ route('websitecontroller') }}" class="breadcrumbs__item ">قسم التحكم الكامل بالموقع</a>
        <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
    </nav>
@endsection
@section('style')
    <style>
        .slider-page .table-responsive {
            padding: 0 1rem 1rem;
        }

        .slider-thumb {
            width: min(170px, 100%);
            aspect-ratio: 16 / 9;
            border: 1px solid var(--v2-border);
            border-radius: 16px;
            background: #fbfbfe;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            box-shadow: 0 10px 24px rgba(36, 30, 62, .06);
        }

        .slider-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .slider-thumb.is-placeholder img {
            object-fit: contain;
            padding: .55rem;
            background: #fdfdff;
        }

        .slider-thumb__empty {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .45rem;
            width: 100%;
            height: 100%;
            color: #8a869a;
            font-size: .85rem;
            font-weight: 700;
        }

        .slider-media-row {
            display: grid;
            gap: .85rem;
            padding: 1rem;
            margin-top: .25rem;
            border: 1px dashed rgba(91, 75, 138, .18);
            border-radius: 18px;
            background: linear-gradient(180deg, #fff 0%, #fafbfe 100%);
        }

        .slider-media-panel {
            display: grid;
            gap: .85rem;
        }

        .slider-media-panel .input_image {
            background: #fbfbfe;
            border: 1px dashed rgba(91, 75, 138, .18);
        }

        .slider-media-panel .input_image::file-selector-button,
        .slider-media-panel .input_image::-webkit-file-upload-button {
            border: 0;
            border-radius: 10px;
            padding: .55rem .85rem;
            margin-inline-end: .8rem;
            background: rgba(91, 75, 138, .10);
            color: var(--v2-primary);
            font-weight: 700;
            cursor: pointer;
        }

        .slider-preview-shell {
            display: grid;
            gap: .55rem;
        }

        .slider-preview-frame {
            width: 100%;
            max-width: 320px;
            aspect-ratio: 16 / 9;
            border-radius: 18px;
            border: 1px solid var(--v2-border);
            background: #fdfdff;
            overflow: hidden;
            position: relative;
            box-shadow: 0 10px 24px rgba(36, 30, 62, .08);
        }

        .slider-preview-frame img,
        .slider-preview-frame .slider-preview-empty {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
        }

        .slider-preview-frame img {
            display: block;
            object-fit: cover;
            background: #fff;
        }

        .slider-preview-frame.is-empty img {
            display: none !important;
        }

        .slider-preview-frame.is-empty .slider-preview-empty {
            display: flex;
        }

        .slider-preview-empty {
            display: none;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: .4rem;
            color: #8a869a;
            font-size: .88rem;
            font-weight: 700;
            background:
                radial-gradient(circle at top, rgba(91, 75, 138, .08), transparent 60%),
                #fdfdff;
            text-align: center;
            padding: 1rem;
        }

        .slider-preview-empty i {
            font-size: 1.5rem;
            color: rgba(91, 75, 138, .38);
        }

        .slider-preview-actions {
            display: flex;
            align-items: center;
            gap: .55rem;
            flex-wrap: wrap;
        }

        .slider-preview-actions .close-btn {
            flex: 0 0 auto;
        }

        .slider-media-preview {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 0;
            border: 0;
            background: transparent;
            padding: 0;
            box-shadow: none;
        }

        .slider-modal.v2-dashboard-modal.modal.show {
            padding: 1.25rem 1rem 1rem;
        }

        .slider-modal.v2-dashboard-modal .modal-dialog {
            width: min(820px, calc(100vw - 2rem));
            max-width: 820px;
            margin-top: 0;
        }

        .slider-modal.v2-dashboard-modal .modal-content {
            border-radius: 22px;
            box-shadow: 0 28px 70px rgba(36, 30, 62, .22);
            max-height: calc(100vh - 2.25rem);
            background: #fff;
        }

        .slider-modal.v2-dashboard-modal .modal-header,
        .slider-modal.v2-dashboard-modal .modal-footer {
            padding: 1.05rem 1.35rem;
            background: #fafbfe;
        }

        .slider-modal.v2-dashboard-modal .modal-body {
            padding: 1.35rem 1.45rem 1.35rem;
            display: flex;
            flex-direction: column;
            gap: .15rem;
        }

        .slider-modal .form-group {
            margin-bottom: 0;
            display: grid;
            gap: .4rem;
        }

        .slider-modal .form-control {
            min-height: 46px;
            border-radius: 14px;
            border: 1px solid var(--v2-border);
            background: #fff;
            padding-inline: .95rem;
            box-shadow: none;
            transition: border-color .2s ease, box-shadow .2s ease, background-color .2s ease;
        }

        .slider-modal .form-control:focus {
            border-color: var(--v2-primary);
            box-shadow: 0 0 0 4px rgba(91, 75, 138, .12);
            background: #fff;
        }

        .slider-modal textarea.form-control {
            min-height: 120px;
            resize: vertical;
            line-height: 1.8;
            padding-top: .85rem;
        }

        .slider-modal .form-group label {
            margin-bottom: 0;
            font-weight: 700;
            color: #3c3750;
            line-height: 1.5;
        }

        .slider-modal .modal-body > .form-group:last-child {
            margin-bottom: 0;
        }

        .slider-modal .custom-file-label {
            display: none !important;
        }

        .slider-modal .modal-footer {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: .6rem;
        }

        .slider-modal .modal-footer .btn {
            min-width: 110px;
        }

        @media (max-width: 768px) {
            .slider-modal.v2-dashboard-modal .modal-body {
                padding: 1rem;
            }

            .slider-modal .slider-media-row {
                padding: .85rem;
            }

            .slider-modal .modal-footer {
                justify-content: stretch;
                flex-wrap: wrap;
            }

            .slider-modal .modal-footer .btn {
                flex: 1 1 0;
                min-width: 0;
            }
        }

        .slider-modal .input_image {
            background: #fbfbfe;
            border: 1px dashed rgba(91, 75, 138, .18);
        }

        .slider-modal .input_image::file-selector-button,
        .slider-modal .input_image::-webkit-file-upload-button {
            border: 0;
            border-radius: 10px;
            padding: .55rem .85rem;
            margin-inline-end: .8rem;
            background: rgba(91, 75, 138, .10);
            color: var(--v2-primary);
            font-weight: 700;
            cursor: pointer;
        }

        .slider-modal .slider-media-row .slider-media-preview {
            max-width: 260px;
        }

        .slider-modal .slider-media-row .del_icon,
        .slider-modal .slider-media-row .del_img {
            flex: 0 0 auto;
        }

        .slider-modal .modal-footer {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: .6rem;
        }

        .slider-modal .modal-footer .btn {
            min-width: 110px;
        }

        .slider-modal .modal-body > .form-group:last-child {
            margin-bottom: 0;
        }

        @media (max-width: 768px) {
            .slider-modal.v2-dashboard-modal .modal-body {
                padding: 1rem;
            }

            .slider-modal .slider-media-row {
                padding: .85rem;
            }

            .slider-modal .modal-footer {
                justify-content: stretch;
                flex-wrap: wrap;
            }

            .slider-modal .modal-footer .btn {
                flex: 1 1 0;
                min-width: 0;
            }
        }
    </style>
@endsection
@section('content')
    @php
        $sliderFallbackImage = asset('assets/admin/plugins/ckeditor/plugins/image/images/noimage.png');
        $localMediaExists = function ($relativePath) {
            $relativePath = ltrim((string) $relativePath, '/');
            if ($relativePath === '') {
                return false;
            }

            $candidates = [
                public_path($relativePath),
                public_path('storage/' . $relativePath),
                storage_path($relativePath),
                storage_path('app/public/' . $relativePath),
            ];

            if (\Illuminate\Support\Str::startsWith($relativePath, 'storage/')) {
                $trimmed = ltrim(substr($relativePath, strlen('storage/')), '/');
                if ($trimmed !== '') {
                    $candidates[] = storage_path($trimmed);
                    $candidates[] = storage_path('app/public/' . $trimmed);
                }
            }

            foreach ($candidates as $candidate) {
                if (is_string($candidate) && file_exists($candidate)) {
                    return true;
                }
            }

            return false;
        };

        $sliderMediaPool = [];
        foreach (['sliderimages', 'newsimages'] as $folder) {
            foreach (glob(public_path('storage/' . $folder . '/*')) ?: [] as $candidate) {
                if (!is_file($candidate)) {
                    continue;
                }

                $extension = strtolower((string) pathinfo($candidate, PATHINFO_EXTENSION));
                if (!in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'], true)) {
                    continue;
                }

                $sliderMediaPool[] = [
                    'mtime' => (int) (@filemtime($candidate) ?: 0),
                    'path' => $candidate,
                    'url' => asset('storage/' . $folder . '/' . basename($candidate)),
                ];
            }
        }

        usort($sliderMediaPool, function ($a, $b) {
            return [$b['mtime'], $b['path']] <=> [$a['mtime'], $a['path']];
        });

        $sliderMediaPool = array_values(array_map(function ($item) {
            return $item['url'];
        }, $sliderMediaPool));

        $resolveSliderMediaUrl = function ($path, $index = 0, $fallback = null) use ($localMediaExists, $sliderMediaPool, $sliderFallbackImage) {
            $path = trim((string) $path);

            if ($path !== '' && \Illuminate\Support\Str::startsWith($path, ['http://', 'https://'])) {
                return $path;
            }

            if ($path !== '' && $localMediaExists($path)) {
                return asset('storage/' . ltrim($path, '/'));
            }

            if (array_key_exists((int) $index, $sliderMediaPool)) {
                return $sliderMediaPool[(int) $index];
            }

            return $fallback ?: $sliderFallbackImage;
        };
    @endphp
    {{-- <div class="col" > --}}
    <div class="card slider-page" style="direction:rtl; text-align:right;margin: 20px;">

        <!--@if (session()->has('success'))
    -->


        <!--<div class="alert alert-success alert-dismissible" role="alert" style="text-align: right; font-size: 30px">-->
        <!--    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
        <!--    {{ session()->get('success') }}-->
        <!--    </div>-->

        <!--
    @endif-->

        <div class="alert alert-success alert-dismissible" id="success2" role="alert"
            style="text-align: right;  display: none; font-size: 30px">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            {{ session()->get('success') }}
        </div>


        <div class="card-header border-0">
            <h3 class="mb-0">جدول السلايدر</h3>
        </div>

        <div class="table-responsive">
            <a href=".createNewsModal" class=" btn btn-success" data-toggle="modal" data-id=""><i class="material-icons"
                    data-toggle="tooltip">إنشاء سلايدر جديد</i></a>


            <table class="table align-items-center table-bordered" id="table_xx" style="color: black; text-align:center">
                <thead class="thead-light">
                    <tr>
                        <!--<th scope="col" class="sort" data-sort="name">Id</th>-->
                        <th style="text-align: center;
                    color: black;"> العنوان بالعربي </th>
                        <th style="text-align: center;
            color: black;"> العنوان بالانكليزي </th>
                        <th style="text-align: center;
                    color: black;"> المحتوى بالعربي </th>
                        <th style="text-align: center;
            color: black;"> المحتوى بالانكليزي </th>
                        <th style="text-align: center;
                    color: black;"> االكلمة المفتاحية بالعربي </th>
                        <th style="text-align: center;
            color: black;"> الكملة المفتاحية بالانكليزي </th>


                        <th style="text-align: center;
                    color: black;"> صورة </th>

                        <th style="text-align: center;
                    color: black;"> حذف </th>

                        <th style="text-align: center;
                    color: black;"> تعديل </th>

                    </tr>
                </thead>
                <tbody class="list">
                    @foreach ($sliders as $item)
                        <tr id="news_{{ $item->id }}">



                            <td style="vertical-align: initial;">
                                {{ $item->header_ar }}



                            </td>

                            <td style="vertical-align: initial;">
                                {{ $item->header_en }}


                            </td>
                            <td style="vertical-align: initial;">
                                {{ $item->content_ar }}



                            </td>

                            <td style="vertical-align: initial;">
                                {{ $item->content_en }}


                            </td>
                            <td style="vertical-align: initial;">
                                {{ $item->key_word_ar }}



                            </td>

                            <td style="vertical-align: initial;">
                                {{ $item->key_word_en }}


                            </td>


                            <td>
                                @php
                                    $sliderImageUrl = $resolveSliderMediaUrl($item->image, $loop->index);
                                    $sliderImageLabel = $item->header_ar ?: $item->header_en ?: 'Slider image';
                                    $isPlaceholderSlider = \Illuminate\Support\Str::contains($sliderImageUrl, 'noimage.png');
                                @endphp
                                <div class="slider-thumb {{ $isPlaceholderSlider ? 'is-placeholder' : '' }}">
                                    <img src="{{ $sliderImageUrl }}"
                                        alt="{{ $sliderImageLabel }}"
                                        loading="lazy"
                                        onerror="this.onerror=null;this.src='{{ $sliderFallbackImage }}';this.parentElement.classList.add('is-placeholder');">
                                </div>
                            </td>


                            <td class="delete" style="vertical-align: initial;"> <a
                                    class="delete_news one  btn-sm btn-danger" data-id="{{ $item->id }}"
                                    href=".active_result" data-toggle="modal"> حذف
                                </a>

                            </td>
                            <td style="vertical-align: initial;">

                                <a class="edit_news btn btn-success btn-sm" data-header_ar="{{ $item->header_ar }}"
                                    data-header_en="{{ $item->header_en }}" data-content_ar	="{{ $item->content_ar }}"
                                    data-content_en="{{ $item->content_en }}" data-key_word_ar="{{ $item->key_word_ar }}"
                                    data-key_word_en="{{ $item->key_word_en }}" data-image-url="{{ $resolveSliderMediaUrl($item->image, $loop->index) }}"
                                    data-id="{{ $item->id }}" href=".editNewsModal" data-toggle="modal">تعديل</i>
                                </a>

                            </td>

                        </tr>
                    @endforeach


                </tbody>
            </table>

        </div>

        <div class="clearfix" style="padding-left:10px;text-align: center">
            <div class="hint-text">Showing
                <b>{{ !request('page') ? '1' : request('page') }}</b>
                out of <b>{{ ceil($count / paginate_num) }}</b> entries
            </div>
            <div class="row">
                <div class="col-md-12">
                    {{ $sliders->links() }}
                </div>
            </div>
        </div>


    </div>
    {{-- </div> --}}



    <div class="modal fade editNewsModal v2-dashboard-modal slider-modal" style="text-align: end;">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <form id="form_update" action="{{ route('slider.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">تعديل السلايدر </h4>
                    </div>
                    <div class="modal-body" style="direction:ltr">
                        <input type="hidden" name="id" id="news_id" value="">

                        <div class="form-group">
                            <label>العنوان بالعربية</label>
                            <input type="text" id="header_ar" name="header_ar" class="form-control" value=""
                                maxlength="100" style="direction: rtl" placeholder="">
                        </div>

                        <div class="form-group">
                            <label>العنوان بالإنكليزية</label>
                            <input type="text" id="header_en" name="header_en" class="form-control" value=""
                                maxlength="100" style="direction: rtl" placeholder="">
                        </div>
                        <div class="form-group">
                            <label>المحتوى بالعربية</label>
                            <input type="text" id="content_ar" name="content_ar" class="form-control" value=""
                                maxlength="100" style="direction: rtl" placeholder="">
                        </div>

                        <div class="form-group">
                            <label>المحتوى بالإنكليزية</label>
                            <input type="text" id="content_en" name="content_en" class="form-control" value=""
                                maxlength="100" style="direction: rtl" placeholder="">
                        </div>
                        <div class="form-group">
                            <label>الكلمة المفتاحية بالعربية</label>
                            <input type="text" id="key_word_ar" name="key_word_ar" class="form-control"
                                value="" maxlength="100" style="direction: rtl" placeholder="">
                        </div>

                        <div class="form-group">
                            <label>الكلمة المفتاحية بالإنكليزية</label>
                            <input type="text" id="key_word_en" name="key_word_en" class="form-control"
                                value="" maxlength="100" style="direction: rtl" placeholder="">
                        </div>

                        {{-- ----------------- --}}


                        <div class="form-group slider-media-row">
                            <label>الصورة</label>
                            <div class="slider-media-panel">
                                <input type="hidden" class="del" name="del_img1" value="del_img1" disabled="disabled">

                                <input type="file" name="image" onchange="loadFile_edit(event)"
                                    title=" size:	1350 × 500 px" class="form-control input_image" id="input_edit_image1"
                                    lang="en">
                                <label class="custom-file-label" for="customFileLang">Select file</label>

                                <div class="slider-preview-shell">
                                    <div class="slider-preview-frame is-empty" id="edit_slider_preview_frame">
                                        <img src="" class="del_edit_img slider-media-preview" id="image1"
                                            alt="Slider preview">
                                        <div class="slider-preview-empty" id="edit_slider_empty_state">
                                            <i class="fas fa-image"></i>
                                            <span>لا توجد صورة</span>
                                        </div>
                                    </div>
                                    <div class="slider-preview-actions">
                                        <span class="close-btn del_icon" title="الغاء" id=""
                                            style="display:inline-flex;font-size: 44px; color:red;font-weigh:bold;cursor:pointerld">&times;</span>
                                        <span class="close-btn del_img" title="الغاء" id=""
                                            style="display: none; font-weight:bold">&times;</span>
                                    </div>
                                </div>

                                <img id="edit_slider_preview" class="output slider-media-preview" style="display: none" src=""
                                    alt="">
                            </div>
                        </div>

                        {{-- ================================= --}}

                    </div>

                    <div class="modal-footer">
                        <a class="btn btn-default" data-dismiss="modal">إالغاء</a>
                        <button class="btn btn-info">تحديث</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade createNewsModal v2-dashboard-modal slider-modal" style="text-align: end;">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <form id="form_update" action="{{ route('slider.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">إنشاء سلايدر جديد</h4>
                    </div>
                    <div class="modal-body" style="direction:ltr">
                        <div class="form-group">
                            <label>العنوان بالعربية</label>
                            <input type="text" name="header_ar" class="form-control" value="" maxlength="100"
                                style="direction: rtl" placeholder="" required>
                        </div>

                        <div class="form-group">
                            <label>العنوان بالانكليزية</label>
                            <input type="text" name="header_en" class="form-control" value="" maxlength="100"
                                placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label>المحتوى بالعربية</label>
                            <input type="text" name="content_ar" class="form-control" value="" maxlength="100"
                                style="direction: rtl" placeholder="" required>
                        </div>

                        <div class="form-group">
                            <label>المحتوى بالانكليزية</label>
                            <input type="text" name="content_en" class="form-control" value="" maxlength="100"
                                placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label>الكلمة المفتاحية بالعربية</label>
                            <input type="text" name="key_word_ar" class="form-control" value=""
                                maxlength="100" style="direction: rtl" placeholder="" required>
                        </div>

                        <div class="form-group">
                            <label>الكلمة المفتاحية بالانكليزية</label>
                            <input type="text" name="key_word_en" class="form-control" value=""
                                maxlength="100" placeholder="" required>
                        </div>





                        <div class="form-group slider-media-row">
                            <label>الصورة</label>
                            <div class="slider-media-panel">
                                <input type="file" name="image" onchange="loadFile(event)" id="input_image1"
                                    title=" size:	1350 × 500 px" class="input_image form-control" required>
                                <label class="custom-file-label" for="customFileLang">Select file</label>

                                <div class="slider-preview-shell">
                                    <div class="slider-preview-frame is-empty" id="create_slider_preview_frame">
                                        <img id="create_slider_preview" style="display: none" src="" class="output slider-media-preview"
                                            alt="">
                                        <div class="slider-preview-empty" id="create_slider_empty_state">
                                            <i class="fas fa-image"></i>
                                            <span>لم يتم اختيار صورة بعد</span>
                                        </div>
                                    </div>
                                    <div class="slider-preview-actions">
                                        <span class="close-btn del_img" title="الغاء" id="del_img"
                                            style="display: none; font-weight:bold">&times;</span>
                                    </div>
                                </div>
                            </div>


                        </div>

                        {{-- ================================= --}}


                        <br>
                        <br>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-default" data-dismiss="modal">الغاء</a>
                        <button class="btn btn-info">حفظ</button>
                    </div>

                </form>
            </div>
        </div>
    </div>







    <div class="col-md-4" class="delete_modal">
        {{-- <button type="button" class="btn btn-block btn-warning mb-3" data-toggle="modal" data-target="#modal-notification">Notification</button> --}}
        <div class="modal fade active_result v2-dashboard-modal" id="modal-notification" tabindex="-1" role="dialog"
            aria-labelledby="modal-notification" aria-hidden="true">
            <div class="modal-dialog modal-danger modal-dialog-scrollable" role="document">
                <div class="modal-content bg-gradient-danger">
                    <form id="form_delete" method="POST">
                        @csrf
                        @method('delete')
                        <div class="modal-header">
                            <h6 class="modal-title" id="modal-title-notification">Your attention is required</h6>
                            <a type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" class="close">×</span>
                            </a>
                        </div>

                        <div class="modal-body">

                            <div class="py-3 text-center">
                                <i class="ni ni-bell-55 ni-3x"></i>
                                <h4 class="heading mt-4">You should read this!</h4>
                                <p>Are you sure you want to delete the item ?</p>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <a class="btn btn-white delete_event" id="delete_event" data-id="" href="">Ok,
                                Got it</a>
                            <a class="btn btn-link text-white ml-auto" data-dismiss="modal">Close</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>



    <script>
        $('.alert-success').hide(5000);
        $(function() {
            $('.editNewsModal, .createNewsModal, .active_result').appendTo(document.body);
        });
        $(document).ready(function() {
            $('#table_xx').DataTable({});
        })
        $(document).on('click', '.one', function() {

            var id = $(this).data('id');
            $('.delete_event').attr('href', `{{ route('admin.news.delete') }}`);

            $('.delete_event').data('id', id);

        });

        $(document).on('click', '.delete_event', function(e) {
            var id = $(this).data('id');
            e.preventDefault();
            $.ajax({

                type: 'post',
                url: "{{ route('slider.delete') }}",
                enctype: 'multipart/form-data',
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': id,

                },

                success: function(data) {

                    $(`#news_${id}`).remove();
                    $('#success2').show();
                    document.getElementById('success2').innerText = "Deleted Successfully !";
                    $('.close').click();

                    $('#success2').hide(5000);

                },
                error: function(xhr) {

                }

            });


        });



        $(document).on('click', '.edit_news', function(e) {
            var id = $(this).data('id');
            e.preventDefault();

            var imageUrl = $(this).data('imageUrl') || $(this).data('image-url') || '';



            $('#news_id').val(id);
            $('#header_en').val($(this).data('header_en'));
            $('#header_ar').val($(this).data('header_ar'));
            $('#content_en').val($(this).data('content_en'));
            $('#content_ar').val($(this).data('content_ar'));
            $('#key_word_en').val($(this).data('key_word_en'));
            $('#key_word_ar').val($(this).data('key_word_ar'));


            if (imageUrl) {
                $('#image1').attr('src', imageUrl).show();
                $('#edit_slider_preview').attr('src', '').hide();
                $('.editNewsModal .del_img').hide();
                $('.editNewsModal .del_icon').show();
            } else {
                $('#image1').attr('src', '').hide();
                $('.editNewsModal .del_icon').hide();
            }



        });
    </script>


    <script>
        var loadFile = function(event) {
            var file = event.target.files && event.target.files[0];
            if (!file) {
                return;
            }

            var output = document.getElementById('create_slider_preview');
            var del_img = document.getElementById('del_img');
            var objectUrl = URL.createObjectURL(file);

            output.src = objectUrl;
            output.onload = function() {
                output.style.display = 'block';
                del_img.setAttribute('style',
                    'display:inline-flex;font-size: 44px; color:red;font-weigh:bold;cursor:pointer');
                URL.revokeObjectURL(objectUrl);
            };

        };


        var loadFile_edit = function(event) {
            var file = event.target.files && event.target.files[0];
            if (!file) {
                return;
            }

            var output = document.getElementById('edit_slider_preview');
            var del_img = document.querySelector('.editNewsModal .del_img');
            var objectUrl = URL.createObjectURL(file);

            $('#image1').hide();
            $('.editNewsModal .del_icon').hide();

            output.setAttribute('src', objectUrl);
            output.onload = function() {

                output.setAttribute('style', 'display:block');
                del_img.setAttribute('style',
                    'display:inline-flex;font-size: 44px; color:red;font-weigh:bold;cursor:pointer');
                URL.revokeObjectURL(objectUrl);
            };

        };


        $(document).on('click', '.del_img', function() {
            var $modal = $(this).closest('.modal');
            if ($modal.hasClass('createNewsModal')) {
                $('#create_slider_preview').attr('style', 'display:none;').attr('src', '');
                $('#input_image1').val('');
            } else if ($modal.hasClass('editNewsModal')) {
                $('#edit_slider_preview').attr('style', 'display:none;').attr('src', '');
                $('#input_edit_image1').val('');
            }
            $(this).hide();

        });

        $(document).on('click', '.del_icon', function() {
            $(this).prevAll('.del:first').attr('disabled', false);
            $(this).prevAll('.del_edit_img:first').hide();
            $('#image1').hide();
            $(this).hide();

        });
    </script>


    <script>
        var loadFile3 = function(event) {
            var output = document.getElementById('output3');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                document.getElementById('output3').setAttribute('style', 'display:inline');
                document.getElementById('del_img3').setAttribute('style',
                    'display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointer');

                URL.revokeObjectURL(output.src) // free memory
            }
        };

        $(document).on('click', '#del_img3', function() {

            $('#output3').attr('style', 'display:none;');
            $('#input_image3').val('');
            $(this).hide();


        });
    </script>



    <script>
        var loadFile4 = function(event) {
            var output = document.getElementById('output4');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                document.getElementById('output4').setAttribute('style', 'display:inline');
                document.getElementById('del_img4').setAttribute('style',
                    'display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointer');

                URL.revokeObjectURL(output.src) // free memory
            }
        };

        $(document).on('click', '#del_img4', function() {

            $('#output4').attr('style', 'display:none;');
            $('#input_image4').val('');
            $(this).hide();


        });
    </script>
@endsection
