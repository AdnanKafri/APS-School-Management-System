<?php

return [
    'messages' => [
        'saved' => 'The teacher assignments for the current academic year were saved successfully.',
    ],
    'validation' => [
        'teacher_required' => 'Please select a valid teacher before continuing.',
        'class_required' => 'Please select at least one class before continuing.',
        'lesson_room_required' => 'Please select a subject and section before saving.',
        'lesson_class_mismatch' => 'The selected subject does not belong to the selected class.',
        'all_sections_exclusive' => 'Select all sections or specific sections, not both.',
        'room_context_invalid' => 'The selected section does not belong to the selected class or current academic year.',
        'no_sections' => 'No sections have been prepared for this class in the current academic year.',
    ],
];
