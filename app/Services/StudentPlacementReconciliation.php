<?php

namespace App\Services;

use App\StudentAcademicPlacement;
use Illuminate\Support\Facades\DB;

/** Audited current observation, never an inferred historical transfer date. */
class StudentPlacementReconciliation
{
    public function resolve($request, $enrollment, $placements)
    {
        if ($request->boolean('reconcile_confirmed')) return $this->confirm($request,$enrollment,$placements);
        $this->authorize();
        $evidence=$this->reliableEvidence($enrollment,$placements);
        if ($evidence === null) throw new \RuntimeException('student_transfer.validation.reconciliation_required');
        return $this->observe($enrollment,$placements,
            'Current enrollment verified from existing records; earlier transition date remains unknown.',
            'automatic',$evidence);
    }

    private function authorize()
    {
        if (DB::transactionLevel() < 1) throw new \LogicException('Reconciliation requires the locked transfer transaction.');
        if (!app(AcademicVisitRecords::class)->enabled()) {
            throw new \RuntimeException('student_transfer.validation.visit_migration_required');
        }
        if (!auth()->user() || !auth()->user()->can('edit_student')) {
            throw new \RuntimeException('student_transfer.validation.reconciliation_required');
        }
    }

    /** Operational evidence only. Never infer the date or owner of older grades. */
    private function reliableEvidence($enrollment, $placements)
    {
        $room=\App\Room::whereKey($enrollment->room_id)->where('year_id',$enrollment->year_id)->first();
        if (!$room) return null;
        if ($placements->count() === 1) {
            $placement=$placements->first();
            if (!$placement->effective_from || $placement->effective_from->gt(now()) || $placement->effective_to !== null) return null;
            if ((int)$placement->room_id === (int)$room->id && (int)$placement->class_id === (int)$room->class_id) {
                return ['basis'=>'matching_unique_placement_and_enrollment','placement_id'=>$placement->id,'enrollment_id'=>$enrollment->id];
            }
            // Reuse the existing narrow, same-grade operational projection rule:
            // newer enrollment, no competing/later transfer, no prior room visit.
            $context=app(CurrentStudentMembership::class)->assessmentEntryContexts(
                [$enrollment->student_id],$enrollment->year_id,$room->id)[$enrollment->student_id] ?? null;
            if ($context && $context['legacy_projection'] && (int)$context['placement_id'] === (int)$placement->id) {
                return ['basis'=>'verified_legacy_current_projection','enrollment_id'=>$enrollment->id,'context'=>$context];
            }
            return null;
        }
        if (!$placements->isEmpty() || StudentAcademicPlacement::where('student_id',$enrollment->student_id)
            ->where('year_id',$enrollment->year_id)->exists()
            || DB::table('student_transfer_histories')->where('student_id',$enrollment->student_id)
                ->where('year_id',$enrollment->year_id)->exists()) return null;
        $created=$enrollment->getRawOriginal('created_at');$updated=$enrollment->getRawOriginal('updated_at');
        foreach ([$created,$updated] as $date) {
            if (!is_string($date) || !preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/D',$date)) return null;
            try {
                $parsed=\Carbon\Carbon::parse($date,config('app.timezone'));
                if ($parsed->format('Y-m-d H:i:s') !== $date || $parsed->gt(now())) return null;
            }
            catch (\Throwable $e) { return null; }
        }
        if ($created > $updated) return null;
        return ['basis'=>'sole_dated_enrollment_without_conflicting_placement_or_transfer','enrollment_id'=>$enrollment->id];
    }

    public function confirm($request, $enrollment, $placements)
    {
        $this->authorize();
        if (!$request->boolean('reconcile_confirmed')) {
            throw new \RuntimeException('student_transfer.validation.reconciliation_required');
        }
        $request->validate(['reconcile_reason'=>'nullable|string|max:2000',
            'observed_room_id'=>'required|integer','observed_placement_ids'=>'present|nullable|string']);
        $ids=$placements->pluck('id')->map(function($id){return (int)$id;})->sort()->values()->implode(',');
        if ((int)$request->observed_room_id !== (int)$enrollment->room_id || $ids !== (string)$request->observed_placement_ids) {
            throw new \RuntimeException('student_transfer.validation.reconciliation_stale');
        }
        return $this->observe($enrollment,$placements,
            $request->reconcile_reason ?: 'Admin explicitly approved the displayed current enrollment before transfer; earlier transition date remains unknown.',
            'manual',['basis'=>'explicit_authorized_admin_confirmation']);
    }

    /** Internal academic writer only; manual Admin reconciliation remains separately authorized. */
    public function observeAcademicWrite($enrollment, $placements, array $evidence)
    {
        if (DB::transactionLevel() < 1 || !auth()->id()
            || ($evidence['basis'] ?? null) !== 'verified_legacy_current_projection'
            || empty($evidence['context']['legacy_projection'])
            || $placements->count() !== 1 || (int)$placements->first()->room_id === (int)$enrollment->room_id
            || $this->reliableEvidence($enrollment, $placements) === null) {
            AssessmentResultSafety::reject('placement_inconsistent');
        }
        return $this->observe($enrollment, $placements,
            'Current membership observed during authorized academic creation; earlier transition date remains unknown.',
            'academic_write', $evidence);
    }

    private function observe($enrollment, $placements, $reason, $mode, array $evidence)
    {
        $now=now();
        $snapshot=json_encode(['enrollment'=>$enrollment->toArray(),'placements'=>$placements->toArray(),
            'verification_mode'=>$mode,'verification_evidence'=>$evidence,
            'historical_transition_date'=>'unknown','confirmation_is_current_observation_only'=>true],JSON_UNESCAPED_UNICODE|JSON_THROW_ON_ERROR);
        foreach ($placements as $old) {
            if (($old->effective_from && $old->effective_from->gt($now))
                || ($old->effective_to && ($old->effective_to->gt($now)
                    || ($old->effective_from && $old->effective_to->lt($old->effective_from))))) {
                throw new \RuntimeException('student_transfer.validation.transfer_placement_mismatch');
            }
            app(AcademicVisitRecords::class)->closeVisit($old);
            $old->status='closed';$old->effective_to=$old->effective_to ?: $now;$old->save();
        }
        $room=\App\Room::whereKey($enrollment->room_id)->where('year_id',$enrollment->year_id)->firstOrFail();
        $observed=StudentAcademicPlacement::create(['student_id'=>$enrollment->student_id,'year_id'=>$enrollment->year_id,
            'class_id'=>$room->class_id,'room_id'=>$room->id,'status'=>'active','effective_from'=>$now,
            'reason'=>'verified_current_observation','action_source'=>$mode==='academic_write'?'academic_write_observation':($mode==='manual'?'admin_explicit_reconciliation':'admin_verified_reconciliation'),'actioned_by'=>auth()->id()]);
        DB::table('student_placement_reconciliations')->insert(['student_id'=>$enrollment->student_id,'year_id'=>$enrollment->year_id,
            'actioned_by'=>auth()->id(),'from_placement_id'=>$placements->count()===1?$placements->first()->id:null,
            'observed_placement_id'=>$observed->id,'observed_room_id'=>$room->id,'reason'=>$reason,
            'before_snapshot'=>$snapshot,'confirmed_at'=>$now]);
        return $observed;
    }
}
