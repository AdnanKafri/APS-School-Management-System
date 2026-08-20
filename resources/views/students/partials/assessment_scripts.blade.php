<script>
    $(document).on('click', '.upload-files', function () {
        var button = $(this);
        $('.js-upload-exam-id').val(button.data('id'));
        $('.js-upload-name').val(button.data('name'));
        $('.js-upload-subject').val(button.data('lesson-name'));
    });

    $(document).on('click', '.exam-required', function () {
        var button = $(this);
        $('.js-assessment-name').val(button.data('name'));
        $('.js-assessment-subject').val(button.data('lesson-name'));
        $('.js-assessment-required').val(button.data('required') || 'لا توجد متطلبات إضافية.');
    });
</script>
