<script>
    function toggleGradebookStatus(classId, termId, control) {
        if (control.disabled) return;
        var previous = control.dataset.accepted === 'OPEN';
        var checkbox = typeof control.checked === 'boolean';
        var newStatus = checkbox ? (control.checked ? 'OPEN' : 'LOCKED') : (previous ? 'LOCKED' : 'OPEN');
        if(!confirm(@json(__('gradebook.status_confirm')))) {
            if (checkbox) control.checked = previous;
            return;
        }
        control.disabled = true;
        var feedback = document.getElementById(control.dataset.feedback || 'gradebook-status-feedback');
        control.setAttribute('aria-busy', 'true');
        feedback.textContent = @json(__('gradebook.saving'));
        function failed(message) {
            if (checkbox) control.checked = previous;
            feedback.textContent = message || @json(__('gradebook.write_failed'));
            feedback.className = 'text-danger';
        }

        $.ajax({
            url: "{{ route('admin.gradebook.status') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                class_id: classId,
                term_id: termId,
                status: newStatus
            },
            success: function(response) {
                if(response.success && response.status === newStatus) {
                    control.dataset.accepted = newStatus;
                    control.setAttribute('aria-checked', newStatus === 'OPEN' ? 'true' : 'false');
                    var label = control.querySelector('[data-status-label]');
                    if (label) label.textContent = newStatus === 'OPEN' ? @json(__('gradebook_ux.open')) : @json(__('gradebook_ux.locked'));
                    feedback.textContent = response.message || @json(__('gradebook.status_saved'));
                    feedback.className = 'text-success';
                } else {
                    failed(response.message);
                }
            },
            error: function(xhr) {
                var response = xhr.responseJSON || {};
                failed(response.message);
            },
            complete: function() {
                control.disabled = false;
                control.removeAttribute('aria-busy');
            }
        });
    }
</script>
