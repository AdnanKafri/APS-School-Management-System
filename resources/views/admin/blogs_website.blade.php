@extends('admin.layouts.v2')
@section('body_class', 'website-mgmt-v2')
@section('page_title', __('admin.blog.title'))
@section('page_subtitle', __('admin.blog.subtitle'))

@section('breadcrumbs')
    <nav class="breadcrumbs">
        <a class="breadcrumbs__item is-active">{{ __('admin.blog.title') }}</a>
        <a href="{{ route('websitehome') }}" class="breadcrumbs__item">{{ __('admin.blog.website_home') }}</a>
        <a href="{{ route('websitecontroller') }}" class="breadcrumbs__item">{{ __('admin.blog.website_management') }}</a>
        <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item">{{ __('admin.blog.dashboard') }}</a>
    </nav>
@endsection

@section('style')
    <style>
        .blog-page .table-responsive {
            padding: 0 1rem 1rem;
        }

        .blog-thumb {
            width: 150px;
            aspect-ratio: 16 / 9;
            margin-inline: auto;
            border: 1px solid var(--v2-border);
            border-radius: 14px;
            overflow: hidden;
            background: #fafbfe;
        }

        .blog-thumb img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
        }

        .blog-thumb__empty {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #8a869a;
            font-size: .82rem;
            font-weight: 700;
        }

        .blog-modal .modal-content>form {
            display: flex;
            flex-direction: column;
            min-height: 0;
            max-height: inherit;
            overflow: hidden;
        }

        .blog-modal .modal-body {
            min-height: 0;
            overflow-y: auto;
            overscroll-behavior: contain;
            -webkit-overflow-scrolling: touch;
        }

        body>.blog-modal.v2-dashboard-modal.modal.show {
            position: fixed !important;
            inset: 0 !important;
            width: 100vw !important;
            height: 100dvh !important;
            top: 0 !important;
            left: 0 !important;
            transform: none !important;
            min-height: 0 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 1rem !important;
            overflow: hidden !important;
        }

        body>.blog-modal.v2-dashboard-modal.modal.show .modal-dialog {
            width: min(720px, calc(100vw - 2rem));
            max-width: 720px;
            max-height: calc(100vh - 2rem);
            margin: 0 auto !important;
            transform: none !important;
        }

        body>.blog-modal.v2-dashboard-modal.modal.show .modal-content {
            max-height: calc(100vh - 2rem);
        }

        @supports (height: 100dvh) {
            body>.blog-modal.v2-dashboard-modal.modal.show {
                height: 100dvh !important;
            }

            body>.blog-modal.v2-dashboard-modal.modal.show .modal-dialog,
            body>.blog-modal.v2-dashboard-modal.modal.show .modal-content {
                max-height: calc(100dvh - 2rem);
            }
        }

        .blog-preview {
            width: 100%;
            max-width: 320px;
            aspect-ratio: 16 / 9;
            border: 1px solid var(--v2-border);
            border-radius: 14px;
            object-fit: contain;
            background: #fafbfe;
        }

        .blog-description {
            min-width: 220px;
            max-width: 320px;
            white-space: normal;
        }

        @media (max-width: 768px) {
            .blog-modal.v2-dashboard-modal.modal.show {
                padding: .5rem;
            }

            .blog-modal.v2-dashboard-modal .modal-dialog {
                width: calc(100vw - 1rem);
            }

            .blog-modal.v2-dashboard-modal .modal-content {
                max-height: calc(100vh - 1rem);
                max-height: calc(100dvh - 1rem);
            }

            body>.blog-modal.v2-dashboard-modal.modal.show .modal-dialog,
            body>.blog-modal.v2-dashboard-modal.modal.show .modal-content {
                max-height: calc(100vh - 1rem);
                max-height: calc(100dvh - 1rem);
            }
        }
    </style>
@endsection

@section('content')
    <div class="card blog-page" style="direction: rtl; text-align: right;">
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible mx-3 mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible mx-3 mt-3" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger mx-3 mt-3" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card-header border-0 d-flex flex-wrap align-items-center justify-content-between">
            <h3 class="mb-0">{{ __('admin.blog.table_title') }}</h3>
            <button type="button" class="btn btn-success js-create-blog">
                {{ __('admin.blog.create') }}
            </button>
        </div>

        <div class="table-responsive">
            <table class="table align-items-center table-bordered" id="blogs-table">
                <thead class="thead-light">
                    <tr>
                        <th>{{ __('admin.blog.title_ar') }}</th>
                        <th>{{ __('admin.blog.title_en') }}</th>
                        <th>{{ __('admin.blog.description_ar') }}</th>
                        <th>{{ __('admin.blog.description_en') }}</th>
                        <th>{{ __('admin.blog.image') }}</th>
                        <th>{{ __('admin.blog.delete') }}</th>
                        <th>{{ __('admin.blog.edit_action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($blogs as $item)
                        <tr id="blog-{{ $item->id }}">
                            <td>{{ $item->title_ar }}</td>
                            <td>{{ $item->title_en }}</td>
                            <td>
                                <div class="blog-description">{{ $item->description_ar }}</div>
                            </td>
                            <td>
                                <div class="blog-description">{{ $item->description_en }}</div>
                            </td>
                            <td>
                                <div class="blog-thumb">
                                    @if ($item->image_url)
                                        <img src="{{ $item->image_url }}" alt="{{ $item->title_ar }}">
                                    @else
                                        <span class="blog-thumb__empty">{{ __('admin.blog.no_image') }}</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm js-delete-blog"
                                    data-id="{{ $item->id }}">
                                    {{ __('admin.blog.delete') }}
                                </button>
                            </td>
                            <td>
                                <button type="button" class="btn btn-success btn-sm js-edit-blog"
                                    data-id="{{ $item->id }}" data-title-ar="{{ $item->title_ar }}"
                                    data-title-en="{{ $item->title_en }}"
                                    data-description-ar="{{ $item->description_ar }}"
                                    data-description-en="{{ $item->description_en }}"
                                    data-image-url="{{ $item->image_url }}">
                                    {{ __('admin.blog.edit_action') }}
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-3 pb-3 text-center">
            {{ $blogs->links() }}
        </div>
    </div>

    <div class="modal fade v2-dashboard-modal blog-modal" id="blogEditModal" tabindex="-1" role="dialog"
        aria-labelledby="blogEditModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('blogs_website.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title" id="blogEditModalLabel">{{ __('admin.blog.edit') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" dir="rtl">
                        <input type="hidden" name="id" id="blog_edit_id">
                        <div class="form-group">
                            <label for="blog_edit_title_ar">{{ __('admin.blog.title_ar') }}</label>
                            <input type="text" id="blog_edit_title_ar" name="title_ar" class="form-control"
                                maxlength="255" required>
                        </div>
                        <div class="form-group">
                            <label for="blog_edit_title_en">{{ __('admin.blog.title_en') }}</label>
                            <input type="text" id="blog_edit_title_en" name="title_en" class="form-control"
                                maxlength="255" dir="ltr" required>
                        </div>
                        <div class="form-group">
                            <label for="blog_edit_description_ar">{{ __('admin.blog.description_ar') }}</label>
                            <textarea id="blog_edit_description_ar" name="description_ar" class="form-control" maxlength="255" rows="3"
                                required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="blog_edit_description_en">{{ __('admin.blog.description_en') }}</label>
                            <textarea id="blog_edit_description_en" name="description_en" class="form-control" maxlength="255" rows="3"
                                dir="ltr" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="blog_edit_image">{{ __('admin.blog.image') }}</label>
                            <div class="mb-2">
                                <img id="blog_edit_preview" class="blog-preview" src="" alt="" hidden>
                            </div>
                            <input type="file" id="blog_edit_image" name="image" class="form-control"
                                accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            {{ __('admin.blog.cancel') }}
                        </button>
                        <button type="submit" class="btn btn-info">{{ __('admin.blog.update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade v2-dashboard-modal blog-modal" id="blogCreateModal" tabindex="-1" role="dialog"
        aria-labelledby="blogCreateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('blogs_website.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title" id="blogCreateModalLabel">{{ __('admin.blog.create') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" dir="rtl">
                        <div class="form-group">
                            <label for="blog_create_title_ar">{{ __('admin.blog.title_ar') }}</label>
                            <input type="text" id="blog_create_title_ar" name="title_ar" class="form-control"
                                maxlength="255" required>
                        </div>
                        <div class="form-group">
                            <label for="blog_create_title_en">{{ __('admin.blog.title_en') }}</label>
                            <input type="text" id="blog_create_title_en" name="title_en" class="form-control"
                                maxlength="255" dir="ltr" required>
                        </div>
                        <div class="form-group">
                            <label for="blog_create_description_ar">{{ __('admin.blog.description_ar') }}</label>
                            <textarea id="blog_create_description_ar" name="description_ar" class="form-control" maxlength="255" rows="3"
                                required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="blog_create_description_en">{{ __('admin.blog.description_en') }}</label>
                            <textarea id="blog_create_description_en" name="description_en" class="form-control" maxlength="255" rows="3"
                                dir="ltr" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="blog_create_image">{{ __('admin.blog.image') }}</label>
                            <div class="mb-2">
                                <img id="blog_create_preview" class="blog-preview" src="" alt="" hidden>
                            </div>
                            <input type="file" id="blog_create_image" name="image" class="form-control"
                                accept="image/*" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            {{ __('admin.blog.cancel') }}
                        </button>
                        <button type="submit" class="btn btn-info">{{ __('admin.blog.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade v2-dashboard-modal blog-modal" id="blogDeleteModal" tabindex="-1" role="dialog"
        aria-labelledby="blogDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('blogs_website.delete') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title" id="blogDeleteModalLabel">
                            {{ __('admin.blog.delete_confirmation_title') }}
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" dir="rtl">
                        <p class="mb-0">{{ __('admin.blog.delete_confirmation_text') }}</p>
                        <input type="hidden" name="id" id="blog_delete_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            {{ __('admin.blog.cancel') }}
                        </button>
                        <button type="submit" class="btn btn-danger">{{ __('admin.blog.confirm') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        (function($) {
            'use strict';

            function setPreview(input, previewSelector) {
                var preview = document.querySelector(previewSelector);
                var file = input.files && input.files[0];

                if (!preview || !file) {
                    return;
                }

                preview.src = URL.createObjectURL(file);
                preview.hidden = false;
                preview.onload = function() {
                    URL.revokeObjectURL(preview.src);
                };
            }

            $(function() {
                $('#blogCreateModal, #blogEditModal, #blogDeleteModal').appendTo(document.body);

                if ($.fn.DataTable && !$.fn.DataTable.isDataTable('#blogs-table')) {
                    $('#blogs-table').DataTable({
                        paging: false,
                        info: false
                    });
                }

                $('.alert-success').delay(5000).fadeOut();
            });

            $(document).on('show.bs.modal', '.blog-modal', function() {
                this.scrollTop = 0;
                var modalBody = this.querySelector('.modal-body');
                if (modalBody) {
                    modalBody.scrollTop = 0;
                }
            });

            $(document).on('shown.bs.modal', '.blog-modal', function() {
                var m = this;
                m.style.cssText = '';
                m.style.setProperty('position', 'fixed', 'important');
                m.style.setProperty('top', '0', 'important');
                m.style.setProperty('left', '0', 'important');
                m.style.setProperty('width', '100vw', 'important');
                m.style.setProperty('height', window.screen.availHeight + 'px', 'important');
                m.style.setProperty('display', 'flex', 'important');
                m.style.setProperty('align-items', 'center', 'important');
                m.style.setProperty('justify-content', 'center', 'important');
                m.style.setProperty('z-index', '9999', 'important');
                m.style.setProperty('padding', '1rem', 'important');

                var dialog = m.querySelector('.modal-dialog');
                if (dialog) {
                    dialog.style.setProperty('margin', '0', 'important');
                    dialog.style.setProperty('transform', 'none', 'important');
                    dialog.style.setProperty('max-height', 'calc(' + window.screen.availHeight + 'px - 2rem)',
                        'important');
                    dialog.style.setProperty('width', 'min(720px, calc(100vw - 2rem))', 'important');
                    dialog.style.setProperty('max-width', '720px', 'important');
                }

                try {
                    this.focus({
                        preventScroll: true
                    });
                } catch (e) {
                    this.focus();
                }
            });

            $(document).on('hidden.bs.modal', '.blog-modal', function() {
                document.body.style.position = '';
            });

            $(document).on('hidden.bs.modal', '#blogCreateModal', function() {
                var form = this.querySelector('form');
                var preview = document.getElementById('blog_create_preview');
                if (form) {
                    form.reset();
                }
                if (preview) {
                    preview.removeAttribute('src');
                    preview.hidden = true;
                }
            });

            $(document).on('hidden.bs.modal', '#blogEditModal', function() {
                $('#blog_edit_image').val('');
            });

            function showBlogModal(selector) {
                var $modal = $(selector);
                if (!$modal.parent().is('body')) {
                    $modal.appendTo(document.body);
                }
                document.body.style.position = 'static';
                $modal.modal('show');
            }

            $(document).on('click', '.js-create-blog', function() {
                showBlogModal('#blogCreateModal');
            });

            $(document).on('click', '.js-edit-blog', function() {
                var button = this;
                var imageUrl = button.getAttribute('data-image-url') || '';
                var preview = document.getElementById('blog_edit_preview');

                $('#blog_edit_id').val(button.getAttribute('data-id'));
                $('#blog_edit_title_ar').val(button.getAttribute('data-title-ar'));
                $('#blog_edit_title_en').val(button.getAttribute('data-title-en'));
                $('#blog_edit_description_ar').val(button.getAttribute('data-description-ar'));
                $('#blog_edit_description_en').val(button.getAttribute('data-description-en'));
                $('#blog_edit_image').val('');

                preview.src = imageUrl;
                preview.hidden = !imageUrl;

                showBlogModal('#blogEditModal');
            });

            $(document).on('click', '.js-delete-blog', function() {
                $('#blog_delete_id').val(this.getAttribute('data-id'));
                showBlogModal('#blogDeleteModal');
            });

            $('#blog_edit_image').on('change', function() {
                setPreview(this, '#blog_edit_preview');
            });

            $('#blog_create_image').on('change', function() {
                setPreview(this, '#blog_create_preview');
            });
        })(jQuery);
    </script>
@endsection
