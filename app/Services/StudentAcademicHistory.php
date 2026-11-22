<?php

namespace App\Services;

use App\Exam_file;
use App\StudentAcademicPlacement;
use App\Student_lesson_teacher_room_term_exam;
use App\Year;
use Illuminate\Support\Facades\Storage;

/** Student-owned records only; never grants access to a section's learning content. */
class StudentAcademicHistory
{
    public function placement($id)
    {
        $user = auth()->user();
        abort_unless($user && (string) $user->type === '0', 403);
        $year = Year::where('current_year', 1)->first();
        $placement = StudentAcademicPlacement::with(['year', 'room', 'classRoom'])
            ->whereKey($id)->where('student_id', $user->student_id)
            ->whereIn('status', ['active', 'closed', 'withdrawn'])->firstOrFail();
        abort_unless($year && (int) $placement->year_id <= (int) $year->id
            && $placement->room && (int) $placement->room->year_id === (int) $placement->year_id
            && (int) $placement->room->class_id === (int) $placement->class_id, 404);
        return $placement;
    }

    public function movements(StudentAcademicPlacement $placement)
    {
        $movements = StudentAcademicPlacement::with(['room', 'classRoom'])
            ->where('student_id', $placement->student_id)->where('year_id', $placement->year_id)
            ->whereIn('status', ['active', 'closed', 'withdrawn'])
            ->orderByDesc('effective_from')->orderByDesc('id')->get();
        if (app(AcademicVisitRecords::class)->enabled()) {
            $unverified=[];
            foreach (\Illuminate\Support\Facades\DB::table('student_placement_reconciliations')
                ->where('student_id',$placement->student_id)->where('year_id',$placement->year_id)->get() as $audit) {
                $snapshot=json_decode($audit->before_snapshot,true);
                foreach ($snapshot['placements']??[] as $old) $unverified[(int)$old['id']]=true;
                $unverified[(int)$audit->observed_placement_id]=true;
            }
            foreach($movements as $movement)$movement->setAttribute('interval_unverified',isset($unverified[(int)$movement->id]));
        }
        return $movements;
    }

    public function submissionFile($placementId, $kind, $id)
    {
        $placement = $this->placement($placementId);
        $models = ['lesson' => Student_lesson_teacher_room_term_exam::class, 'exam' => Exam_file::class];
        abort_unless(isset($models[$kind]), 404);
        $record = $models[$kind]::whereKey($id)->where('student_id', $placement->student_id)
            ->where('room_id', $placement->room_id)->firstOrFail();
        $link=app(AcademicVisitRecords::class)->link(AcademicVisitRecords::TYPES[$record->getTable()],$record->id);
        abort_if($link && (int)$link->placement_id !== (int)$placement->id,404);

        // These legacy student uploads use either filesstudents/... on the public
        // disk or public/filesstudents/... on the default local disk. Never serve
        // arbitrary paths, Teacher material, or symlinks escaping that directory.
        $path = str_replace('\\', '/', (string) $record->file);
        if (strpos($path, 'public/') === 0) $path = substr($path, 7);
        abort_unless(strpos($path, 'filesstudents/') === 0 && strpos($path, "\0") === false
            && !in_array('..', explode('/', $path), true), 404);
        $disk = Storage::disk('public');
        $root = realpath($disk->path('filesstudents'));
        $file = realpath($disk->path($path));
        $prefix = $root ? str_replace('\\', '/', $root).'/' : null;
        abort_unless($prefix && $file && is_file($file)
            && strpos(str_replace('\\', '/', $file), $prefix) === 0, 404);
        return $file;
    }
}
