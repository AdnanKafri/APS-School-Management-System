@php
    $labels = [
        'completed' => __('student_follow_up_admin.completed'),
        'missing_first' => __('student_follow_up_admin.missing_first'),
        'missing_second' => __('student_follow_up_admin.missing_second'),
        'incomplete' => __('student_follow_up_admin.missing_first'),
        'no_follow_up' => __('student_follow_up_admin.no_follow_up'),
        'not_due' => __('student_follow_up_admin.not_due'),
        'in_progress' => __('student_follow_up_admin.in_progress'),
        'future' => __('student_follow_up_admin.future'),
        'not_applicable' => __('student_follow_up_admin.not_applicable'),
    ];
@endphp
<span class="sfu-badge {{ $status }}">{{ $labels[$status] ?? $status }}</span>
