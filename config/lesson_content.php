<?php

return [
    // Remains off until the owner approves activation after isolated acceptance.
    'enabled' => env('LESSON_CONTENT_ENABLED', false),
    'max_files' => env('LESSON_CONTENT_MAX_FILES', 20),
    'max_file_bytes' => env('LESSON_CONTENT_MAX_FILE_BYTES', 2040 * 1024 * 1024),
    'max_total_bytes' => env('LESSON_CONTENT_MAX_TOTAL_BYTES', 2040 * 1024 * 1024),
    'multipart_reserve_bytes' => 8 * 1024 * 1024,
    'note_max' => 2000,
];
