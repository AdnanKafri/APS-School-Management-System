<?php

namespace App\Services;

final class ComplaintStudentIdentifier
{
    // Match the student record-number capacity while retaining public slash notation.
    public const MAX_LENGTH = 15;
    public const REGEX = '~\A[0-9]+(?:[/-][0-9]+)*\z~';
    public const HTML_PATTERN = '[0-9]+(?:(?:/|-)[0-9]+)*';

    public static function isValid($value): bool
    {
        return is_string($value) && strlen($value) <= self::MAX_LENGTH
            && preg_match(self::REGEX, $value) === 1;
    }
}
