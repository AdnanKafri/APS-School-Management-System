(function ($) {
    'use strict';
    $(document).on('submit', '#student-delete-form', function (event) {
        event.preventDefault();
        var $form = $(this);
        if ($form.data('submitting')) return;
        var $button = $('#student-delete-submit');
        var $errors = $('#student-delete-errors');
        var $feedback = $('#student-delete-feedback');
        function showError(message) {
            $errors.empty().append($('<p>', { 'class': 'mb-0', text: message })).prop('hidden', false);
        }
        $form.data('submitting', true).attr('aria-busy', 'true');
        $button.prop('disabled', true);
        $errors.empty().prop('hidden', true);
        $feedback.empty().prop('hidden', true);
        $.ajax({
            url: $form.attr('action'), type: 'POST', data: $form.serialize(), dataType: 'json', timeout: 30000,
            headers: { Accept: 'application/json' }
        }).done(function (data) {
            if (!data || !data.student_id || !data.message) {
                showError($form.data('network'));
                return;
            }
            $form.find('[name=password]').val('');
            $('#delete_class').modal('hide');
            $feedback.text(data.message).prop('hidden', false);
            if (window.toastr && typeof window.toastr.success === 'function') window.toastr.success(data.message);
            if ($.fn.dataTable && $.fn.dataTable.isDataTable('#table_xx')) {
                $('#table_xx').DataTable().ajax.reload(null, false);
            } else {
                window.location.reload();
            }
        }).fail(function (xhr) {
            $form.find('[name=password]').val('');
            if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                $errors.empty();
                $.each(xhr.responseJSON.errors, function (field, messages) {
                    $.each(messages, function (index, message) {
                        $errors.append($('<p>', { 'class': 'mb-1', text: message }));
                    });
                });
                $errors.prop('hidden', false);
            } else {
                var key = xhr.status === 401 || xhr.status === 419 ? 'session'
                    : xhr.status === 403 ? 'forbidden'
                    : xhr.status === 404 || xhr.status === 405 ? 'invalid'
                    : xhr.status >= 500 ? 'failed' : 'network';
                showError($form.data(key));
            }
        }).always(function () {
            $form.data('submitting', false).attr('aria-busy', 'false');
            $button.prop('disabled', false);
        });
    });
    $(document).on('hidden.bs.modal', '#delete_class', function () {
        $('#student-delete-form [name=password]').val('');
    });
}(jQuery));
