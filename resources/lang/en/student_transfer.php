<?php

return [
    'notifications' => [
        'transfer_no_change' => 'No transfer was applied because the student is already assigned to that section.',
        'room_updated' => 'The student was moved to the new section while keeping the same class and academic record.',
        'transferred' => 'The student was transferred successfully while keeping the same account and preserving the archived academic snapshots.',
        'transfer_failed' => 'The transfer could not be completed safely. No academic data was changed.',
    ],
    'validation' => [
        'transfer_active_year_missing' => 'No active academic year is configured.',
        'transfer_student_missing' => 'The selected student could not be found.',
        'transfer_class_invalid' => 'The selected target class is invalid.',
        'transfer_room_invalid' => 'The selected target section is invalid.',
        'transfer_room_year_mismatch' => 'The selected target section does not belong to the active academic year.',
        'transfer_requires_current_enrollment' => 'The student does not have a valid active-year enrollment to transfer.',
        'transfer_conflicting_enrollment' => 'The student has conflicting active-year enrollments. Please review the academic record before transferring.',
        'transfer_conflicting_marks' => 'The student has more than one active-year marks record. Please review the academic record before transferring.',
        'transfer_conflicting_report_card' => 'The student has more than one active-year report card. Please review the academic record before transferring.',
        'transfer_existing_assessments' => 'This cross-grade transfer is blocked because the student already has room-based assessment or lesson records in the current class. Use the year-end promotion workflow or archive those academic records first.',
    ],
    'notice' => 'Changing the class or section keeps the same student account and personal identity. Same-class section moves stay in place, while cross-grade moves are blocked once current-class assessments already exist.',
    'change_action' => 'Change class or section',
];