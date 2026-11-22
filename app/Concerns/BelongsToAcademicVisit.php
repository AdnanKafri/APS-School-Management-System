<?php

namespace App\Concerns;

use App\Services\AcademicVisitRecords;

trait BelongsToAcademicVisit
{
    public function newEloquentBuilder($query)
    {
        return new \App\Services\AcademicVisitBuilder($query);
    }

    public function save(array $options = [])
    {
        if (!app(AcademicVisitRecords::class)->enabled()) return parent::save($options);
        return $this->getConnection()->transaction(function()use($options){
            $student=$this->student_id ?: $this->user_id;
            \App\Student::whereKey($student)->lockForUpdate()->firstOrFail();
            return parent::save($options);
        });
    }

    protected static function bootBelongsToAcademicVisit()
    {
        static::created(function($record){app(AcademicVisitRecords::class)->created($record);});
        static::updating(function($record){app(AcademicVisitRecords::class)->protect($record);});
        static::deleting(function($record){
            if(app(AcademicVisitRecords::class)->link(AcademicVisitRecords::TYPES[$record->getTable()],$record->id)
                || app(AcademicVisitRecords::class)->resultState($record) === 'conflict') {
                \App\Services\AssessmentResultSafety::reject('retained_results');
            }
        });
        if (in_array((new static)->getTable(),['students_marks','report_cards'],true)) {
            static::addGlobalScope('academic_visit',function($q){$table=$q->getModel()->getTable();
                app(AcademicVisitRecords::class)->current($q,$table,AcademicVisitRecords::TYPES[$table]);});
        }
    }
}
