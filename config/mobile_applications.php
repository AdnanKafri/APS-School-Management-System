<?php

return [
    'disk' => env('MOBILE_APPLICATIONS_DISK', 'mobile_applications'),
    'max_upload_kb' => (int) env('MOBILE_APPLICATION_MAX_UPLOAD_KB', 102400),

    'applications' => [
        'parent' => [
            'audience' => 'public',
            'icon' => 'fas fa-users',
        ],
        'teacher' => [
            'audience' => 'staff',
            'icon' => 'fas fa-chalkboard-teacher',
        ],
        'transport_supervisor' => [
            'audience' => 'staff',
            'icon' => 'fas fa-bus-alt',
        ],
    ],
];
