<?php

return [
    'validation' => [
        'required' => 'Please complete the required fields.',
        'integer' => 'The selected value is invalid.',
        'in' => 'Choose a valid action.',
        'selected_student' => 'Select at least one student.',
        'year_missing' => 'No current academic year or linked next year is configured.',
        'year_invalid' => 'The next academic year is invalid or is the same as the current year. Link the current year to a different year before starting.',
        'target_class' => 'The target class is invalid.',
        'target_section' => 'The target section is invalid or does not belong to the selected class and next year.',
    ],
    'errors' => [
        'next_year' => 'The selected year is not the configured next academic year.',
        'source_enrollment' => 'The student must have exactly one valid source-year enrollment.',
        'source_section' => 'The student source section is invalid for the source year.',
        'target_missing' => 'Choose a valid class and section for the next academic year.',
        'promote_class' => 'The selected class does not match the configured next class. Use manual destination for an exception.',
        'repeat_class' => 'Repeat must keep the student in the same class with a section from the next year.',
        'outcome' => 'The selected action is invalid.',
        'already_prepared' => 'This student has already been prepared for the next academic year and cannot be processed again.',
        'failed' => 'The operation could not be completed safely. Previous academic data was not changed.',
        'prepared_status' => 'Prepared for next year',
        'pending_status' => 'Pending preparation',
        'prepared_destination' => 'Prepared for next year: :year — :class / :section',
        'carry_forward_context' => 'The student or matching section for the next year could not be resolved.',
        'existing_destination_conflict' => 'The student already has a next-year placement in a different section, so it was not changed.',
    ],
    'messages' => [
        'prepared' => 'The student was prepared for :year. The active academic year was not changed.',
        'bulk_result' => 'Prepared :success students for :year; :failed could not be prepared. The active year was not changed.',
        'bulk_failure_hint' => 'Review the destination class/section and next-year configuration before retrying failed students.',
        'rollover_result' => 'Year :year prepared: :created sections created, :existing already existed, :carried students carried forward, and :skipped already-prepared students skipped.',
        'rooms_cloned' => ':count sections were prepared for the next academic year.',
        'no_sections' => 'No sections exist for this class in the next academic year. Prepare sections first, then return here.',
    ],
];
