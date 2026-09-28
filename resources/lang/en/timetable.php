<?php

return [
    'validation' => [
        'class_required' => 'Please select a class before continuing.',
        'room_required' => 'Please select at least one section before continuing.',
        'room_invalid' => 'Please select valid sections before continuing.',
        'room_class_mismatch' => 'The selected section does not belong to the selected class.',
        'year_required' => 'Set the current academic year before managing sessions.',
        'session_required' => 'Please select a session.',
        'session_invalid' => 'The selected session does not exist or is no longer available.',
        'name_required' => 'Please enter the session name.',
        'name_invalid' => 'The session name is invalid.',
        'name_max' => 'The session name may not exceed 20 characters.',
        'type_required' => 'Please select the session type.',
        'type_invalid' => 'The selected session type is invalid.',
        'start_required' => 'Please set the session start time.',
        'start_invalid' => 'The session start time is invalid.',
        'end_required' => 'Please set the session end time.',
        'end_invalid' => 'The session end time is invalid.',
        'end_after_start' => 'The session end time must be after the start time.',
    ],
    'updated' => 'The session was updated successfully.',
    'deleted' => 'The session was deleted successfully.',
];
