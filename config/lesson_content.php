<?php

return [
    // Remains off until the owner approves activation after isolated acceptance.
    'enabled' => env('LESSON_CONTENT_ENABLED', false),
    'max_files' => 5,
    'max_file_bytes' => 10 * 1024 * 1024,
    'max_total_bytes' => 25 * 1024 * 1024,
    'note_max' => 2000,
];
