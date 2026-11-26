<?php

namespace App\Services;

class LessonContentLimits
{
    public function values()
    {
        if (PHP_INT_SIZE < 8) throw new \RuntimeException('Large lesson uploads require 64-bit PHP.');
        $limits = [];
        foreach (['max_files', 'max_file_bytes', 'max_total_bytes'] as $key) {
            $value = filter_var(config('lesson_content.'.$key), FILTER_VALIDATE_INT, ['options'=>['min_range'=>1]]);
            if ($value === false) throw new \RuntimeException('Invalid lesson upload limit: '.$key);
            $limits[$key] = $value;
        }
        $runtime = $this->runtime();
        $limits['max_files'] = min(20, $limits['max_files']);
        if ($runtime['count'] > 0) $limits['max_files'] = min($limits['max_files'], $runtime['count']);
        if ($runtime['post'] > 0) $limits['max_total_bytes'] = min($limits['max_total_bytes'], max(0, $runtime['post'] - $this->reserve($runtime['post'])));
        if ($runtime['file'] > 0) $limits['max_file_bytes'] = min($limits['max_file_bytes'], $runtime['file']);
        $limits['max_file_bytes'] = min($limits['max_file_bytes'], $limits['max_total_bytes']);
        return $limits;
    }

    protected function runtime()
    {
        return ['file'=>self::iniBytes(ini_get('upload_max_filesize')), 'post'=>self::iniBytes(ini_get('post_max_size')),
            'count'=>(int)ini_get('max_file_uploads')];
    }

    public static function iniBytes($value)
    {
        if (!preg_match('/^\s*(\d+)\s*([KMG]?)\s*$/iD', (string)$value, $m)) throw new \RuntimeException('Invalid PHP upload limit.');
        $factor = [''=>1,'K'=>1024,'M'=>1048576,'G'=>1073741824][strtoupper($m[2])];
        return (int)min(PHP_INT_MAX, (float)$m[1] * $factor);
    }

    private function reserve($post)
    {
        return min((int)config('lesson_content.multipart_reserve_bytes',8388608), max(65536, (int)ceil($post / 100)));
    }

    public function requestBytes()
    {
        $runtime = $this->runtime();
        return $this->values()['max_total_bytes'] + $this->reserve($runtime['post'] ?: PHP_INT_MAX);
    }

    public function message($key)
    {
        $values = $this->values();
        return __('lesson_content.'.$key, [
            'count'=>$values['max_files'],
            'file'=>round($values['max_file_bytes'] / 1048576, 2),
            'total'=>round($values['max_total_bytes'] / 1048576, 2),
        ]);
    }
}
