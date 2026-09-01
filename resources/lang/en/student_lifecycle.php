<?php

return [
    'ui' => [
        'archive_title' => 'Student Archive', 'archive_subtitle' => 'Students removed from current operations while their academic and financial history is preserved.',
        'search_archive' => 'Search archive', 'search' => 'Search', 'empty' => 'No archived students.', 'restore' => 'Restore student',
        'choose_year' => 'Choose year', 'choose_class' => 'Choose class', 'choose_section' => 'Choose section', 'restore_reason' => 'Restore reason',
        'archive_reason' => 'Archive reason', 'cancel' => 'Cancel', 'confirm_archive' => 'Confirm archive',
        'archive_explanation' => 'The student will leave current academic operations while the account and academic and financial history remain preserved.',
    ],
    'validation' => [
        'student_required' => 'Please select a student.',
        'reason_required' => 'Please provide an archive reason.',
        'reason_max' => 'The reason may not exceed 1000 characters.',
        'required' => 'Please complete all required fields.',
    ],
    'messages' => ['archived' => 'Student archived successfully.', 'restored' => 'Student restored successfully.'],
    'errors' => [
        'student_forbidden' => 'You are not allowed to access another student\'s data.',
        'student_missing' => 'The student was not found.',
        'student_not_operational' => 'This student is not available for current operations.',
        'account_archived' => 'This account is currently inactive. Please contact the administration.',
        'invalid_archive_state' => 'The student cannot be archived from the current state.',
        'invalid_restore_state' => 'The student cannot be restored from the current state.',
        'active_year_missing' => 'No active academic year is configured.',
        'duplicate_active_placement' => 'The student has more than one current academic placement.',
        'current_enrollment_invalid' => 'The current enrollment is invalid.',
        'placement_enrollment_mismatch' => 'The academic placement does not match the current section.',
        'unknown_active_placement' => 'The student has an unknown active academic placement.',
        'unknown_future_enrollment' => 'The student has an unclassifiable future enrollment.',
        'future_activity' => 'The student cannot be archived because future academic activity exists.',
        'account_missing' => 'No account is linked to this student.',
        'restore_context_invalid' => 'The selected year, class, or section is invalid.',
        'restore_past_year' => 'The student cannot be restored to a year older than the active year.',
        'restore_conflict' => 'Another enrollment exists for the student in the selected year.',
        'restore_activity_conflict' => 'Academic data prevents restoring the student in this context.',
        'operation_failed' => 'The student operation could not be completed.',
    ],
];
