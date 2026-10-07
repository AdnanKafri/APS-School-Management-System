<?php

namespace App\Services;

use Illuminate\Support\Facades\Gate;

class ComplaintAccess
{
    const OFFICER_TYPE = '8';
    const PERMISSIONS = ['view_complaints', 'manage_complaints', 'archive_complaints', 'receive_complaint_notifications'];

    public static function allows($user, $ability)
    {
        if (!$user) {
            return false;
        }
        return (string) $user->type === self::OFFICER_TYPE
            && (bool) $user->complaint_officer_active
            && in_array($ability, self::PERMISSIONS, true)
            && Gate::forUser($user)->allows($ability);
    }

    public static function authorize($user, $ability)
    {
        abort_unless(self::allows($user, $ability), 403);
    }
}
