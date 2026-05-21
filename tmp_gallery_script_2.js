
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
    
