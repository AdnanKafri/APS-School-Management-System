@extends('admin.layouts.v2')
@section('body_class', 'website-mgmt-v2')
@section('page_title', 'معرض الصور')
@section('page_subtitle', 'إدارة صور المعرض ومحتواها')
@section('breadcrumbs')
    <nav class="breadcrumbs">
        <a class="breadcrumbs__item is-active">معرض الصور</a>
        <a href="{{ route('websitehome') }}" class="breadcrumbs__item">الصفحة الاساسية</a>
        <a href="{{ route('websitecontroller') }}" class="breadcrumbs__item">قسم التحكم الكامل بالموقع</a>
        <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item">الصفحة الرئيسية</a>
    </nav>
@endsection

@section('style')
    <style>
        .gallery-page .table-responsive {
            padding: 0 1rem 1rem;
        }

        .gallery-toolbar {
            display: flex;
            justify-content: flex-end;
            padding: 0 1rem 1rem;
        }

        .gallery-thumb {
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

        .gallery-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .gallery-thumb.is-placeholder img {
            object-fit: contain;
            padding: .55rem;
            background: #fdfdff;
        }

        .gallery-thumb__empty {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .45rem;
            width: 100%;
            height: 100%;
            color: #8a869a;
            font-size: .85rem;
            font-weight: 700;
            text-align: center;
            padding: .75rem;
        }

        .gallery-media-row {
            display: grid;
            gap: .85rem;
            padding: 1rem;
            margin-top: .25rem;
            border: 1px dashed rgba(91, 75, 138, .18);
            border-radius: 18px;
            background: linear-gradient(180deg, #fff 0%, #fafbfe 100%);
        }

        .gallery-media-panel {
            display: grid;
            gap: .85rem;
        }

        .gallery-media-panel .input_image {
            background: #fbfbfe;
            border: 1px dashed rgba(91, 75, 138, .18);
        }

        .gallery-media-panel .input_image::file-selector-button,
        .gallery-media-panel .input_image::-webkit-file-upload-button {
            border: 0;
            border-radius: 10px;
            padding: .55rem .85rem;
            margin-inline-end: .8rem;
            background: rgba(91, 75, 138, .10);
            color: var(--v2-primary);
            font-weight: 700;
            cursor: pointer;
        }

        .gallery-preview-shell {
            display: grid;
            gap: .75rem;
        }

        .gallery-preview-frame {
            width: 100%;
            max-width: 360px;
            aspect-ratio: 16 / 9;
            max-height: 240px;
            border-radius: 18px;
            border: 1px solid var(--v2-border);
            background: #fdfdff;
            overflow: hidden;
            position: relative;
            box-shadow: 0 10px 24px rgba(36, 30, 62, .08);
        }

        .gallery-preview-frame img,
        .gallery-preview-frame .gallery-preview-empty {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
        }

        .gallery-preview-frame img {
            display: block;
            object-fit: contain;
            background: #fff;
        }

        .gallery-preview-frame.is-empty img {
            display: none !important;
        }

        .gallery-preview-frame.is-empty .gallery-preview-empty {
            display: flex;
        }

        .gallery-preview-empty {
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

        .gallery-preview-empty i {
            font-size: 1.5rem;
            color: rgba(91, 75, 138, .38);
        }

        .gallery-preview-actions {
            display: flex;
            align-items: center;
            gap: .55rem;
            flex-wrap: wrap;
        }

        .gallery-preview-actions .close-btn {
            flex: 0 0 auto;
        }

        .gallery-media-preview {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 0;
            border: 0;
            background: transparent;
            padding: 0;
            box-shadow: none;
        }

        .gallery-modal.v2-dashboard-modal.modal.show {
            padding: 1.25rem 1rem 1rem;
        }

        .gallery-modal.v2-dashboard-modal .modal-dialog {
            width: min(760px, calc(100vw - 2rem));
            max-width: 760px;
            margin-top: 0;
            display: flex;
            align-items: stretch;
            height: calc(100vh - 2.25rem);
        }

        .gallery-modal.v2-dashboard-modal .modal-content {
            border-radius: 22px;
            box-shadow: 0 28px 70px rgba(36, 30, 62, .22);
            max-height: calc(100vh - 2.25rem);
            height: 100%;
            background: #fff;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            width: 100%;
        }

        .gallery-modal.v2-dashboard-modal .modal-header,
        .gallery-modal.v2-dashboard-modal .modal-footer {
            padding: 1.05rem 1.35rem;
            background: #fafbfe;
            flex-shrink: 0;
        }

        .gallery-modal.v2-dashboard-modal .modal-body {
            padding: 1.35rem 1.45rem 1.35rem;
            display: flex;
            flex-direction: column;
            gap: .15rem;
            overflow-y: auto;
            flex: 1 1 auto;
            min-height: 0;
        }

        .gallery-modal .form-group {
            margin-bottom: 0;
            display: grid;
            gap: .4rem;
        }

        .gallery-modal .form-control {
            min-height: 46px;
            border-radius: 14px;
            border: 1px solid var(--v2-border);
            background: #fff;
            padding-inline: .95rem;
            box-shadow: none;
            transition: border-color .2s ease, box-shadow .2s ease, background-color .2s ease;
        }

        .gallery-modal .form-control:focus {
            border-color: var(--v2-primary);
            box-shadow: 0 0 0 4px rgba(91, 75, 138, .12);
            background: #fff;
        }

        .gallery-modal .form-group label {
            margin-bottom: 0;
            font-weight: 700;
            color: #3c3750;
            line-height: 1.5;
        }

        .gallery-modal .modal-body > .form-group:last-child {
            margin-bottom: 0;
        }

        .gallery-modal .custom-file-label {
            display: none !important;
        }

        .gallery-modal .modal-footer {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: .6rem;
            flex-shrink: 0;
        }

        .gallery-modal .modal-footer .btn {
            min-width: 110px;
        }

        @media (max-width: 768px) {
            .gallery-modal.v2-dashboard-modal .modal-dialog {
                height: calc(100vh - 1.5rem);
                width: calc(100vw - 1rem);
                max-width: calc(100vw - 1rem);
            }

            .gallery-modal.v2-dashboard-modal .modal-body {
                padding: 1rem;
            }

            .gallery-modal .gallery-media-row {
                padding: .85rem;
            }

            .gallery-modal .modal-footer {
                justify-content: stretch;
                flex-wrap: wrap;
            }

            .gallery-modal .modal-footer .btn {
                flex: 1 1 0;
                min-width: 0;
            }
        }
    </style>
@endsection

@section('content')
    <div class="card gallery-page" style="direction:rtl; text-align:right;margin: 20px;">
        <div class="alert alert-success alert-dismissible" id="success2" role="alert"
            style="text-align: right; display: none; font-size: 30px">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            {{ session()->get('success') }}
        </div>

        <div class="card-header border-0 d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h3 class="mb-0">جدول المعرض</h3>
                <p class="mb-0 text-muted">إدارة صور المعرض وتحديثها من لوحة التحكم.</p>
            </div>
            <div class="gallery-toolbar p-0">
                <a href=".createNewsModal" class="btn btn-success" data-toggle="modal" data-id="">
                    <i class="material-icons" data-toggle="tooltip">إضافة صورة جديدة</i>
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-items-center table-bordered" id="table_xx" style="color: black; text-align:center">
                <thead class="thead-light">
                    <tr>
                        <th style="text-align:center;color:black;">صورة</th>
                        <th style="text-align:center;color:black;">القياس</th>
                        <th style="text-align:center;color:black;">تعديل</th>
                    </tr>
                </thead>
                <tbody class="list">
                    @foreach ($gallery as $item)
                        <tr id="news_{{ $item->id }}">
                            <td>
                                @php
                                    $galleryImageUrl = $item->image_url;
                                @endphp
                                @if (!empty($galleryImageUrl))
                                    <div class="gallery-thumb">
                                        <img src="{{ $galleryImageUrl }}" alt="Gallery image" loading="lazy">
                                    </div>
                                @else
                                    <div class="gallery-thumb is-placeholder">
                                        <div class="gallery-thumb-empty">
                                            <i class="fas fa-image"></i>
                                            <span>لا توجد صورة</span>
                                        </div>
                                    </div>
                                @endif
                            </td>

                            <td style="vertical-align: initial;direction: ltr">
                                {{ $item->size }}
                            </td>

                            <td style="vertical-align: initial;">
                                <button type="button" class="gallery-edit-btn btn btn-success btn-sm"
                                    data-image-url="{{ $item->image_url }}" data-id="{{ $item->id }}"
                                    onclick="return window.openGalleryEditModal(this);">تعديل</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="clearfix" style="padding-left:10px;text-align:center">
            <div class="hint-text">Showing
                <b>{{ !request('page') ? '1' : request('page') }}</b>
                out of <b>{{ ceil($count / paginate_num) }}</b> entries
            </div>
            <div class="row">
                <div class="col-md-12">
                    {{ $gallery->links() }}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade gallery-edit-modal v2-dashboard-modal gallery-modal" id="galleryEditModal" style="text-align:end;">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <form id="form_update" action="{{ route('gallery.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">تعديل صورة (يرجى التقيد بالقياسات)</h4>
                    </div>
                    <div class="modal-body" style="direction:ltr">
                        <input type="hidden" name="id" id="gallery_edit_id" value="">

                        <div class="form-group gallery-media-row">
                            <label>الصورة</label>
                            <div class="gallery-media-panel">
                                <input type="hidden" class="del" name="del_img1" value="del_img1" disabled="disabled">
                                <input type="file" name="image" onchange="loadFile_edit(event)" title=" size: 1350 × 500 px"
                                    class="form-control input_image" id="input_edit_image1" lang="en">
                                <label class="custom-file-label" for="customFileLang">Select file</label>
                                <div class="gallery-preview-shell">
                                    <div class="gallery-preview-frame is-empty" id="edit_gallery_preview_frame">
                                        <img src="" class="del_edit_img gallery-media-preview" id="gallery_preview" alt="Gallery preview">
                                        <div class="gallery-preview-empty" id="edit_gallery_empty_state">
                                            <i class="fas fa-image"></i>
                                            <span>لا توجد صورة</span>
                                        </div>
                                    </div>
                                    <div class="gallery-preview-actions">
                                        <span class="close-btn del_icon" title="الغاء" id=""
                                            style="display:inline-flex;font-size:44px;color:red;font-weigh:bold;cursor:pointerld">&times;</span>
                                        <span class="close-btn del_img" title="الغاء" id=""
                                            style="display:none;font-weight:bold">&times;</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <a class="btn btn-default" data-dismiss="modal">إلغاء</a>
                        <button class="btn btn-info">تحديث</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade createNewsModal v2-dashboard-modal gallery-modal" style="text-align:end;">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <form id="form_store" action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">إضافة صورة جديدة</h4>
                    </div>
                    <div class="modal-body" style="direction:ltr">
                        <div class="form-group gallery-media-row">
                            <label>الصورة</label>
                            <div class="gallery-media-panel">
                                <input type="file" name="image" onchange="loadFile(event)" id="input_image1"
                                    title=" size: 1350 × 500 px" class="input_image form-control" required>
                                <label class="custom-file-label" for="customFileLang">Select file</label>
                                <div class="gallery-preview-shell">
                                    <div class="gallery-preview-frame is-empty" id="create_gallery_preview_frame">
                                        <img id="gallery_create_preview" style="display:none" src="" class="output gallery-media-preview" alt="">
                                        <div class="gallery-preview-empty" id="create_gallery_empty_state">
                                            <i class="fas fa-image"></i>
                                            <span>لم يتم اختيار صورة بعد</span>
                                        </div>
                                    </div>
                                    <div class="gallery-preview-actions">
                                        <span class="close-btn del_img" title="الغاء" id="del_img"
                                            style="display:none;font-weight:bold">&times;</span>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                            <a class="btn btn-white delete_event" id="delete_event" data-id="" href="">Ok, Got it</a>
                            <a class="btn btn-link text-white ml-auto" data-dismiss="modal">Close</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        if (window.jQuery) {
            $('.alert-success').hide(5000);
            $(function() {
                $('#galleryEditModal, .createNewsModal, .active_result').appendTo(document.body);
            });
        } else {
            var modalNodes = document.querySelectorAll('#galleryEditModal, .createNewsModal, .active_result');
            modalNodes.forEach(function(node) {
                document.body.appendChild(node);
            });
            var successAlert = document.querySelector('.alert-success');
            if (successAlert) {
                setTimeout(function() {
                    successAlert.style.display = 'none';
                }, 5000);
            }
        }

        if (window.jQuery && window.jQuery.fn && window.jQuery.fn.DataTable) {
            $(document).ready(function() {
                $('#table_xx').DataTable({});
            });
        }
        function resetGalleryEditModal() {
            var idInput = document.getElementById('gallery_edit_id');
            var fileInput = document.getElementById('input_edit_image1');
            var preview = document.getElementById('gallery_preview');
            var frame = document.getElementById('edit_gallery_preview_frame');
            var emptyState = document.getElementById('edit_gallery_empty_state');
            var delIcon = document.querySelector('.gallery-edit-modal .del_icon');
            var delImg = document.querySelector('.gallery-edit-modal .del_img');

            if (idInput) idInput.value = '';
            if (fileInput) fileInput.value = '';
            if (preview) {
                preview.src = '';
                preview.style.display = 'none';
            }
            if (frame) frame.classList.add('is-empty');
            if (emptyState) emptyState.style.display = 'flex';
            if (delIcon) delIcon.style.display = 'none';
            if (delImg) delImg.style.display = 'none';
        }

        function openModalFallback(modal) {
            if (!modal) {
                return;
            }
            modal.classList.add('show');
            modal.style.display = 'block';
            modal.setAttribute('aria-hidden', 'false');
            document.body.classList.add('modal-open');
            if (!document.querySelector('.modal-backdrop.fallback-gallery-backdrop')) {
                var backdrop = document.createElement('div');
                backdrop.className = 'modal-backdrop fade show fallback-gallery-backdrop';
                backdrop.style.zIndex = '1440';
                backdrop.addEventListener('click', function() {
                    closeModalFallback(modal);
                });
                document.body.appendChild(backdrop);
            }
        }

        function closeModalFallback(modal) {
            if (!modal) {
                return;
            }
            modal.classList.remove('show');
            modal.style.display = 'none';
            modal.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('modal-open');
            var fallbackBackdrop = document.querySelector('.modal-backdrop.fallback-gallery-backdrop');
            if (fallbackBackdrop && fallbackBackdrop.parentNode) {
                fallbackBackdrop.parentNode.removeChild(fallbackBackdrop);
            }
        }

        window.openGalleryEditModal = function(button) {
            var id = button && button.getAttribute ? (button.getAttribute('data-id') || '') : '';
            var imageUrl = button && button.getAttribute ? (button.getAttribute('data-image-url') || '') : '';

            console.log('Gallery edit clicked:', id);

            if (!id) {
                console.warn('Gallery edit clicked without an id', button ? button.dataset : null);
                return false;
            }

            var $modal = document.getElementById('galleryEditModal');
            var $frame = document.getElementById('edit_gallery_preview_frame');
            var $empty = document.getElementById('edit_gallery_empty_state');
            var $preview = document.getElementById('gallery_preview');
            var $idInput = document.getElementById('gallery_edit_id');

            if (!$modal) {
                console.error('Gallery edit modal is missing from the DOM');
                return false;
            }

            $modal.setAttribute('data-gallery-id', id);
            if ($idInput) $idInput.value = id;

            if (imageUrl) {
                if ($preview) {
                    $preview.src = imageUrl;
                    $preview.style.display = 'block';
                }
                if ($frame) $frame.classList.remove('is-empty');
                if ($empty) $empty.style.display = 'none';
                document.querySelectorAll('.gallery-edit-modal .del_icon').forEach(function(el) { el.style.display = 'inline-flex'; });
                document.querySelectorAll('.gallery-edit-modal .del_img').forEach(function(el) { el.style.display = 'none'; });
            } else {
                if ($preview) {
                    $preview.src = '';
                    $preview.style.display = 'none';
                }
                if ($frame) $frame.classList.add('is-empty');
                if ($empty) $empty.style.display = 'flex';
                document.querySelectorAll('.gallery-edit-modal .del_icon').forEach(function(el) { el.style.display = 'none'; });
                document.querySelectorAll('.gallery-edit-modal .del_img').forEach(function(el) { el.style.display = 'none'; });
            }

            if (window.jQuery && jQuery.fn && typeof jQuery.fn.modal === 'function') {
                jQuery($modal).modal('show');
            } else {
                openModalFallback($modal);
            }
            return false;
        };

        if (window.jQuery) {
            $(document).on('show.bs.modal', '.createNewsModal', function() {
                $('#input_image1').val('');
                $('#gallery_create_preview').attr('src', '').hide();
                $('#create_gallery_preview_frame').addClass('is-empty');
                $('#create_gallery_empty_state').show();
                $('#del_img').hide();
            });

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
                    url: "{{ route('gallery.delete') }}",
                    enctype: 'multipart/form-data',
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'id': id,
                    },
                    success: function(data) {
                        $(`#news_${id}`).remove();
                        $('#success2').show();
                        document.getElementById('success2').innerText = "تم حذف الصورة بنجاح";
                        $('.close').click();
                        $('#success2').hide(5000);
                    },
                    error: function(xhr) {}
                });
            });
        }

        if (window.jQuery) {
            $(document).on('hidden.bs.modal', '#galleryEditModal', function() {
                resetGalleryEditModal();
            });
        }

        document.addEventListener('hidden.bs.modal', function(event) {
            if (event.target && event.target.id === 'galleryEditModal') {
                resetGalleryEditModal();
            }
        });

        $(document).on('click', '[data-dismiss="modal"]', function() {
            var $modal = $(this).closest('.modal');
            if (!$modal.length) {
                return;
            }
            if ($.fn && $.fn.modal) {
                $modal.modal('hide');
            } else {
                closeModalFallback($modal.get(0));
            }
        });
    </script>

    <script>
        var loadFile = function(event) {
            var file = event.target.files && event.target.files[0];
            if (!file) {
                return;
            }

            var output = document.getElementById('gallery_create_preview');
            var frame = document.getElementById('create_gallery_preview_frame');
            var emptyState = document.getElementById('create_gallery_empty_state');
            var del_img = document.getElementById('del_img');
            var objectUrl = URL.createObjectURL(file);

            output.setAttribute('src', objectUrl);
            output.onload = function() {
                output.setAttribute('style', 'display:block');
                if (frame) {
                    frame.classList.remove('is-empty');
                }
                if (emptyState) {
                    emptyState.style.display = 'none';
                }
                del_img.setAttribute('style', 'display:inline-flex;font-size:44px;color:red;font-weigh:bold;cursor:pointer');
                URL.revokeObjectURL(objectUrl);
            };

            if (frame) {
                frame.classList.remove('is-empty');
            }
            if (emptyState) {
                emptyState.style.display = 'none';
            }
        };

        var loadFile_edit = function(event) {
            var file = event.target.files && event.target.files[0];
            if (!file) {
                return;
            }

            var output = document.getElementById('gallery_preview');
            var frame = document.getElementById('edit_gallery_preview_frame');
            var emptyState = document.getElementById('edit_gallery_empty_state');
            var del_img = document.querySelector('.gallery-edit-modal .del_img');
            var objectUrl = URL.createObjectURL(file);

            $('.gallery-edit-modal .del_icon').hide();
            output.setAttribute('src', objectUrl);
            output.onload = function() {
                output.setAttribute('style', 'display:block');
                if (frame) {
                    frame.classList.remove('is-empty');
                }
                if (emptyState) {
                    emptyState.style.display = 'none';
                }
                del_img.setAttribute('style', 'display:inline-flex;font-size:44px;color:red;font-weigh:bold;cursor:pointer');
                URL.revokeObjectURL(objectUrl);
            };

            if (frame) {
                frame.classList.remove('is-empty');
            }
            if (emptyState) {
                emptyState.style.display = 'none';
            }
        };

        $(document).on('click', '.del_img', function() {
            var $modal = $(this).closest('.modal');
            if ($modal.hasClass('createNewsModal')) {
                $('#gallery_create_preview').attr('style', 'display:none;').attr('src', '');
                $('#input_image1').val('');
                $('#create_gallery_preview_frame').addClass('is-empty');
                $('#create_gallery_empty_state').show();
            } else if ($modal.hasClass('gallery-edit-modal')) {
                $('#gallery_preview').attr('style', 'display:none;').attr('src', '');
                $('#input_edit_image1').val('');
                $('#edit_gallery_preview_frame').addClass('is-empty');
                $('#edit_gallery_empty_state').show();
            }
            $(this).hide();
        });

        $(document).on('click', '.del_icon', function() {
            $(this).prevAll('.del:first').attr('disabled', false);
            $('#gallery_preview').hide().attr('src', '');
            $('#edit_gallery_preview_frame').addClass('is-empty');
            $('#edit_gallery_empty_state').show();
            $(this).hide();
        });
    </script>
@endsection
