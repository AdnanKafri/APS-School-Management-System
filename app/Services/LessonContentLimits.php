<?php

namespace App\Services;

class LessonContentLimits
{
    public function values()
    {
        $limits = [];
        foreach (['max_files', 'max_file_bytes', 'max_total_bytes'] as $key) {
            $value = filter_var(config('lesson_content.'.$key), FILTER_VALIDATE_INT, ['options'=>['min_range'=>1]]);
            if ($value === false) throw new \RuntimeException('Invalid lesson upload limit: '.$key);
            $limits[$key] = $value;
        }
        return $limits;
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
