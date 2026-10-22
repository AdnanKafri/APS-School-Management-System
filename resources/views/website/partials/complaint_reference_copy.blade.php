<script>
document.getElementById('copy-complaint-reference').addEventListener('click', function () {
    var value = document.getElementById('complaint-reference').textContent.trim();
    var feedback = document.getElementById('copy-complaint-feedback');
    function success() { feedback.textContent = @json(__('complaint_tracking.copied')); }
    function fallback() {
        var input = document.createElement('textarea');
        input.value = value;
        input.style.position = 'fixed';
        input.style.opacity = '0';
        document.body.appendChild(input);
        input.select();
        var copied = document.execCommand('copy');
        input.remove();
        feedback.textContent = copied ? @json(__('complaint_tracking.copied')) : @json(__('complaint_tracking.copy_failed'));
    }
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(value).then(success, fallback);
    } else { fallback(); }
});
</script>
