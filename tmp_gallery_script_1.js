
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
                        document.getElementById('success2').innerText = "?? ??? ?????? ?????";
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
    
