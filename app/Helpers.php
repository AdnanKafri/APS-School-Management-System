<?php

if (!function_exists('school_text_limit')) {
    /**
     * Truncate UTF-8 text by characters without requiring mbstring.
     */
    function school_text_limit($value, $limit, $end = '...')
    {
        $value = (string) $value;
        $limit = max(0, (int) $limit);

        if ($value === '' || $limit === 0) {
            return $limit === 0 ? '' : $value;
        }

        preg_match_all('/./us', $value, $matches);
        $characters = $matches[0] ?: str_split($value);

        if (count($characters) <= $limit) {
            return $value;
        }

        return implode('', array_slice($characters, 0, $limit)) . $end;
    }
}
