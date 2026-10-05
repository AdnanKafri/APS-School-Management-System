<?php

return [
    'messages' => [
        'saved' => 'The teacher assignments for the current academic year were saved successfully.',
        'scheduled' => 'Scheduled in the current term.',
        'not_scheduled' => 'No timetable session has been set for this assignment in the current term.',
        'schedule_action' => 'Set lesson times',
        'term_unavailable' => 'There is no current term. Assignments can be saved, but a current term must be selected before configuring the timetable.',
    ],
    'validation' => [
        'teacher_required' => 'Please select a valid teacher before continuing.',
        'class_required' => 'Please select at least one class before continuing.',
        'lesson_room_required' => 'Please select a subject and section before saving.',
        'lesson_class_mismatch' => 'The selected subject does not belong to the selected class.',
        'all_sections_exclusive' => 'Select all sections or specific sections, not both.',
        'room_context_invalid' => 'The selected section does not belong to the selected class or current academic year.',
        'no_sections' => 'No sections have been prepared for this class in the current academic year.',
        'scheduled_assignment_removal' => 'This assignment cannot be removed because it has a scheduled session in the current academic year. Remove the timetable session first, then update the assignment.',
    ],
];
