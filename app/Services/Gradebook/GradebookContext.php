<?php

namespace App\Services\Gradebook;

/** Academic read scope, not authorization or an applied template. */
final class GradebookContext
{
    private $values;

    public function __construct($yearId, $subjectId, $termId = null, $classId = null, $roomId = null,
        $configurationSource = null, $configurationVersion = null)
    {
        $this->values = [];
        foreach (['year_id'=>$yearId, 'subject_id'=>$subjectId, 'term_id'=>$termId,
            'class_id'=>$classId, 'room_id'=>$roomId] as $key=>$value) {
            if ($value === null && !in_array($key, ['year_id', 'subject_id'], true)) {
                $this->values[$key] = null;
                continue;
            }
            if ((!is_int($value) && !is_string($value))
                || filter_var($value, FILTER_VALIDATE_INT, ['options'=>['min_range'=>1]]) === false) {
                throw new \InvalidArgumentException('Invalid Gradebook context: '.$key);
            }
            $this->values[$key] = (int) $value;
        }
        if ($configurationSource !== null
            && !in_array($configurationSource, ['legacy_json', 'legacy_defaults', 'versioned_template'], true)) {
            throw new \InvalidArgumentException('Unknown Gradebook configuration source.');
        }
        if ($configurationVersion !== null && (!is_string($configurationVersion)
            || $configurationVersion === '' || $configurationSource === null)) {
            throw new \InvalidArgumentException('A configuration revision requires a source.');
        }
        $this->values['configuration_source'] = $configurationSource;
        $this->values['configuration_version'] = $configurationVersion;
    }

    public function yearId() { return $this->values['year_id']; }
    public function subjectId() { return $this->values['subject_id']; }
    public function termId() { return $this->values['term_id']; }
    public function classId() { return $this->values['class_id']; }
    public function roomId() { return $this->values['room_id']; }
    public function configurationSource() { return $this->values['configuration_source']; }
    public function configurationVersion() { return $this->values['configuration_version']; }
    public function toArray() { return $this->values; }
}
