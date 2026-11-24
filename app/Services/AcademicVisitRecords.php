<?php

namespace App\Services;

use App\StudentAcademicPlacement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/** Append-only attribution. Original academic rows are never backfilled/reparented. */
class AcademicVisitRecords
{
    private $schemaReady = false;
    public const TABLE = 'student_academic_visit_records';
    public const TYPES = ['students_marks'=>'marks','report_cards'=>'report','exam_result2'=>'modern_result',
        'exam_result'=>'legacy_result','exams_files'=>'exam_submission',
        'student_lesson_teacher_room_term_exam'=>'lesson_submission','certificates'=>'certificate'];

    public function enabled(): bool
    {
        if ($this->schemaReady) return true;
        return $this->schemaReady = Schema::hasTable(self::TABLE) && Schema::hasTable('student_placement_reconciliations');
    }

    public function link($type, $id)
    {
        return $this->enabled() ? DB::table(self::TABLE)->where('record_type',$type)->where('record_id',$id)->first() : null;
    }

    public function bind($record, StudentAcademicPlacement $placement, $evidence)
    {
        if (!$this->enabled()) return;
        $type = self::TYPES[$record->getTable()];
        $studentId = $record->student_id ?: $record->user_id;
        if ((int)$studentId !== (int)$placement->student_id || (int)$record->room_id !== (int)$placement->room_id
            || ($record->year_id !== null && (int)$record->year_id !== (int)$placement->year_id)) {
            AssessmentResultSafety::reject('context_invalid');
        }
        $term=$record->term_id ? \App\Term_year::find($record->term_id) : null;
        if ($term && (int)$term->year_id !== (int)$placement->year_id) {
            AssessmentResultSafety::reject('context_invalid');
        }
        if ($record->class_id !== null && (int)$record->class_id !== (int)$placement->class_id) {
            AssessmentResultSafety::reject('context_invalid');
        }
        $existing = $this->link($type, $record->id);
        if ($existing) {
            if ((int)$existing->placement_id !== (int)$placement->id) AssessmentResultSafety::reject('ambiguous_result');
            return;
        }
        DB::table(self::TABLE)->insert(['placement_id'=>$placement->id,'student_id'=>$studentId,
            'year_id'=>$placement->year_id,'room_id'=>$placement->room_id,'record_type'=>$type,'record_id'=>$record->id,
            'summary_type'=>in_array($type,['marks','report'],true) ? $type : null,
            'evidence'=>$evidence,'created_at'=>now()]);
    }

    public function created($record)
    {
        if (!$this->enabled()) return;
        $student = $record->student_id ?: $record->user_id;
        $room = \App\Room::find($record->room_id);
        if (!$room) AssessmentResultSafety::reject('context_invalid');
        $placements = StudentAcademicPlacement::where('student_id',$student)->where('room_id',$record->room_id)
            ->where('year_id',$room->year_id)->where('status','active')
            ->when($record->year_id !== null, function($q)use($record){$q->where('year_id',$record->year_id);})->get();
        if ($placements->count() > 1) AssessmentResultSafety::reject('ambiguous_result');
        if ($placements->isEmpty() && StudentAcademicPlacement::where('student_id',$student)
            ->where('year_id',$room->year_id)->exists()) {
            app(AcademicWriteObservation::class)->forCreation($record, $room);
            return;
        }
        if ($placements->count() === 1) $this->bind($record,$placements->first(),'created_in_active_visit');
    }

    public function protect($record)
    {
        $link = $this->link(self::TYPES[$record->getTable()],$record->id);
        if (!$link) {
            if ($this->resultState($record) === 'conflict') AssessmentResultSafety::reject('ambiguous_result');
            return;
        }
        $placement = StudentAcademicPlacement::find($link->placement_id);
        if (!$placement || $placement->status !== 'active') AssessmentResultSafety::reject('carried_read_only');
        if ($record->isDirty(['id','student_id','user_id','year_id','room_id','class_id','class','exam_id','lesson_id','term_id'])) {
            AssessmentResultSafety::reject('retained_results');
        }
    }

    public function resultState($record)
    {
        $link=$this->link(self::TYPES[$record->getTable()],$record->id);
        if (!$link) {
            if (!$this->enabled()) return null;
            $room=\App\Room::find($record->room_id);
            return $room && StudentAcademicPlacement::where('student_id',$record->student_id ?: $record->user_id)
                ->where('year_id',$room->year_id)->where('room_id',$room->id)->count() > 1 ? 'conflict' : null;
        }
        $active=StudentAcademicPlacement::where('student_id',$link->student_id)->where('year_id',$link->year_id)
            ->where('status','active')->get();
        return $active->count() === 1 && (int)$active->first()->id === (int)$link->placement_id ? 'current' : 'carried';
    }

    public function current($query, $table, $type, $writable = false)
    {
        if (!$this->enabled()) return $query;
        return $query->where(function($q)use($table,$type,$writable){
            $q->whereExists(function($link)use($table,$type,$writable){
                $link->select(DB::raw(1))->from(self::TABLE.' as visit_current')
                    ->join('student_academic_placements as visit_placement','visit_placement.id','=','visit_current.placement_id')
                    ->where('visit_current.record_type',$type)->whereColumn('visit_current.record_id',$table.'.id');
                $this->latestPlacement($link,'visit_placement');
                if ($writable) $link->where('visit_placement.status','active');
            })->orWhere(function($legacy)use($table,$type){
                $legacy->whereNotExists(function($l)use($table,$type){$l->select(DB::raw(1))->from(self::TABLE.' as visit_link')
                    ->where('visit_link.record_type',$type)->whereColumn('visit_link.record_id',$table.'.id');})
                    ->whereNotExists(function($l)use($table,$type){$l->select(DB::raw(1))->from(self::TABLE.' as visit_known')
                        ->where('visit_known.record_type',$type)->whereColumn('visit_known.student_id',$table.'.student_id')
                        ->whereColumn('visit_known.year_id',$table.'.year_id');});
            });
        });
    }

    private function latestPlacement($query, $alias)
    {
        $query->whereIn($alias.'.status',['active','closed','withdrawn'])->whereNotExists(function($later)use($alias){
            $later->select(DB::raw(1))->from('student_academic_placements as visit_later')
                ->whereColumn('visit_later.student_id',$alias.'.student_id')->whereColumn('visit_later.year_id',$alias.'.year_id')
                ->whereIn('visit_later.status',['active','closed','withdrawn'])
                ->where(function($order)use($alias){$order->whereColumn('visit_later.effective_from','>',$alias.'.effective_from')
                    ->orWhere(function($tie)use($alias){$tie->whereColumn('visit_later.effective_from',$alias.'.effective_from')
                        ->whereColumn('visit_later.id','>',$alias.'.id');});});
        });
    }

    public function historical($query, $table, StudentAcademicPlacement $placement, $legacy = false)
    {
        $type = self::TYPES[$table];
        $key = in_array($table,['exam_result','exam_result2'],true) ? 'user_id' : 'student_id';
        $query->where($table.'.'.$key,$placement->student_id)->where($table.'.room_id',$placement->room_id);
        if (in_array($type,['marks','report'],true)) $query->where($table.'.year_id',$placement->year_id);
        if (!$this->enabled()) return $query;
        $query->where(function($q)use($table,$type,$placement,$legacy){
            if (!$legacy) $q->whereExists(function($l)use($table,$type,$placement){$l->select(DB::raw(1))->from(self::TABLE.' as history_visit')
                ->where('history_visit.record_type',$type)->where('history_visit.placement_id',$placement->id)
                ->whereColumn('history_visit.record_id',$table.'.id');});
            if ($legacy || ($placement->reason !== 'verified_current_observation' && StudentAcademicPlacement::where('student_id',$placement->student_id)->where('year_id',$placement->year_id)
                ->where('room_id',$placement->room_id)->count() === 1)) {
                $method = $legacy ? 'whereNotExists' : 'orWhereNotExists';
                $q->{$method}(function($l)use($table,$type){$l->select(DB::raw(1))->from(self::TABLE.' as history_unlinked')
                    ->where('history_unlinked.record_type',$type)->whereColumn('history_unlinked.record_id',$table.'.id');});
            }
        });
        return $query;
    }

    public function closeVisit(StudentAcademicPlacement $placement)
    {
        if (!$this->enabled()) return;
        $unique = $placement->effective_from && $placement->reason !== 'verified_current_observation' && StudentAcademicPlacement::where('student_id',$placement->student_id)->where('year_id',$placement->year_id)
            ->where('room_id',$placement->room_id)->count() === 1;
        $models = ['students_marks'=>\App\Students_mark::class,'report_cards'=>\App\Report_card::class,
            'exam_result2'=>\App\Exam_result2::class,'exam_result'=>\App\Exam_result::class,
            'exams_files'=>\App\Exam_file::class,'student_lesson_teacher_room_term_exam'=>\App\Student_lesson_teacher_room_term_exam::class,
            'certificates'=>\App\Certificate::class];
        foreach (self::TYPES as $table=>$type) {
            $query = $models[$table]::withoutGlobalScope('academic_visit');
            $this->historical($query,$table,$placement)->lockForUpdate();
            $rows=$query->get();
            foreach ($rows as $row) {
                if ($this->link($type,$row->id)) continue;
                $recordedAt=$row->getRawOriginal('created_at') ?: $row->getRawOriginal('Created_at');
                if ($recordedAt && ($recordedAt < $placement->getRawOriginal('effective_from')
                    || ($placement->effective_to && $recordedAt > $placement->getRawOriginal('effective_to')))) continue;
                // Conflicting legacy summary rows remain in the explicitly
                // labelled section/year bucket, never arbitrarily assigned.
                if ($unique && (!in_array($type,['marks','report'],true) || $rows->count() === 1)) {
                    $this->bind($row,$placement,'unique_original_section_visit');
                }
            }
        }
    }
}
