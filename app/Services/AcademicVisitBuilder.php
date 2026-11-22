<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

/** Bulk Eloquent operations bypass model events; retained visits must not. */
class AcademicVisitBuilder extends Builder
{
    private function protectClosedVisits()
    {
        if (!app(AcademicVisitRecords::class)->enabled()) return;
        $table=$this->getModel()->getTable();
        $type=AcademicVisitRecords::TYPES[$table];
        $this->whereNotExists(function($q)use($table,$type){
            $q->select(DB::raw(1))->from(AcademicVisitRecords::TABLE.' as frozen_visit')
                ->leftJoin('student_academic_placements as frozen_placement','frozen_placement.id','=','frozen_visit.placement_id')
                ->where('frozen_visit.record_type',$type)->whereColumn('frozen_visit.record_id',$table.'.id')
                ->where(function($closed){$closed->whereNull('frozen_placement.id')->orWhere('frozen_placement.status','<>','active');});
        });
        $owner=in_array($table,['exam_result','exam_result2'],true)?'user_id':'student_id';
        $this->whereNotExists(function($q)use($table,$type,$owner){
            $q->select(DB::raw(1))->from('student_academic_placements as ambiguous_first')
                ->join('student_academic_placements as ambiguous_second',function($join){
                    $join->on('ambiguous_first.student_id','=','ambiguous_second.student_id')
                        ->on('ambiguous_first.year_id','=','ambiguous_second.year_id')
                        ->on('ambiguous_first.room_id','=','ambiguous_second.room_id')
                        ->on('ambiguous_first.id','<>','ambiguous_second.id');
                })->whereColumn('ambiguous_first.student_id',$table.'.'.$owner)->whereColumn('ambiguous_first.room_id',$table.'.room_id')
                ->whereNotExists(function($link)use($table,$type){$link->select(DB::raw(1))->from(AcademicVisitRecords::TABLE.' as verified_visit')
                    ->where('verified_visit.record_type',$type)->whereColumn('verified_visit.record_id',$table.'.id');});
        });
    }

    public function update(array $values)
    {
        if (app(AcademicVisitRecords::class)->enabled()
            && array_intersect(array_keys($values),['id','student_id','user_id','year_id','room_id','class_id','class','exam_id','lesson_id','term_id'])) {
            $table=$this->getModel()->getTable();$type=AcademicVisitRecords::TYPES[$table];
            if ((clone $this)->whereExists(function($q)use($table,$type){$q->select(DB::raw(1))->from(AcademicVisitRecords::TABLE.' as original_visit')
                ->where('original_visit.record_type',$type)->whereColumn('original_visit.record_id',$table.'.id');})->exists()) {
                AssessmentResultSafety::reject('retained_results');
            }
        }
        $this->protectClosedVisits();
        return parent::update($values);
    }

    public function delete()
    {
        $this->protectClosedVisits();
        // Never bulk-delete an attributed original, including an empty scaffold.
        if (app(AcademicVisitRecords::class)->enabled()) {
            $table=$this->getModel()->getTable();$type=AcademicVisitRecords::TYPES[$table];
            $this->whereNotExists(function($q)use($table,$type){$q->select(DB::raw(1))->from(AcademicVisitRecords::TABLE.' as retained_visit')
                ->where('retained_visit.record_type',$type)->whereColumn('retained_visit.record_id',$table.'.id');});
        }
        return parent::delete();
    }
}
