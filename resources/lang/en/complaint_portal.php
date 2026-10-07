<?php

return [
    'invalid_credentials' => 'Invalid credentials or unavailable account.',
    'login_throttle' => 'Too many login attempts. Please retry in :seconds seconds.',
    'validation' => [
        'required' => 'The :attribute field is required.', 'string' => 'Enter valid text for :attribute.',
        'email' => 'Enter a valid email.', 'unique' => 'This email belongs to another account.',
        'min' => ':attribute must contain at least :min characters.', 'max' => ':attribute must not exceed :max characters.',
        'confirmed' => 'Password confirmation does not match.', 'boolean' => 'Invalid account state.',
    ],
    'immutable_type' => 'A complaint officer account cannot be converted to an Admin or another school account.',
    'deactivate_instead' => 'Deactivate this officer instead of deleting the account, to preserve action history.',
    'title' => 'Complaint Follow-up Portal', 'officers' => 'Complaint Officers',
    'account_management' => 'Create and manage officer accounts',
    'account_saved' => 'Account details saved.', 'session_expired' => 'Session expired or account disabled. Please sign in again.',
    'login' => 'Sign in', 'logout' => 'Sign out', 'email' => 'Email', 'password' => 'Password',
    'confirm_password' => 'Confirm password', 'name' => 'Name', 'create_account' => 'Create officer account',
    'save' => 'Save details', 'active' => 'Active', 'inactive' => 'Inactive', 'activate' => 'Activate', 'deactivate' => 'Deactivate',
    'reset_password' => 'Change password', 'password_hint' => 'At least ten characters. Saved passwords are never displayed.',
    'audit' => 'Action history', 'actor' => 'Officer', 'empty' => 'No matching complaints.',
    'archive_question' => 'Archive this complaint? It will remain stored in complaint history.',
    'cancel' => 'Cancel',
    'reset' => 'Reset filters',
    'no_audit' => 'No actions have been recorded for this complaint.',
    'filter' => 'Apply', 'all' => 'All', 'notifications' => 'My notifications',
];
