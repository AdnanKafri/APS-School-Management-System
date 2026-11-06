<?php

return [
    'component'=>'Assessment component',
    'maximum'=>'Maximum mark',
    'configured_maximum'=>'Configured component bound',
    'earned'=>'Earned mark',
    'total'=>'Total',
    'no_components'=>'No components are configured. Original assessments remain available below.',
    'input_mode'=>'Allocation input',
    'percentage'=>'Percentage',
    'marks'=>'Maximum marks',
    'allocation'=>'Percentage allocation',
    'allocated_marks'=>'Allocated marks',
    'remaining'=>'Remaining',
    'exact_help'=>'Whole-number maximum marks convert only to exact whole-number percentages without rounding. Saving still uses existing percentages and does not recalculate earned marks. Returning to percentages retains the last exactly convertible values.',
    'inexact'=>'Enter a whole-number maximum mark representing a whole-number percentage between 0 and 100. Returning to percentages retains the last exactly convertible values; no rounding is performed.',
    'unsupported'=>'Mark input is unavailable: bounds may be fractional, the subject maximum invalid, or stored independent bounds or conflicting mappings may exist. Percentage input remains available without conversion.',
    'invalid_total'=>'An exact mark allocation cannot be displayed for these values; existing validation rules remain unchanged.',
    'incomplete'=>'Allocation is incomplete. This warning does not change existing save rules.',
    'excess'=>'Allocation exceeds 100%. This warning does not change existing save rules.',
    'complete'=>'Allocation is complete.',
    'maximum_changed'=>'The subject maximum changed after this page was opened. Review the current total and re-enter the allocation; no change was saved.',
];
