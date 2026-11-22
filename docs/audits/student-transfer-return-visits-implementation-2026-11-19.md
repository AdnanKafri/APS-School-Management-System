# Student transfers, return visits and original academic records

## Activation boundary

Implemented and tested against isolated fixtures. **Not activated on the school
database.** No school records, including student 1444, were reconciled or changed.
The effective local school connection was inspected with SELECTs in read-only
transactions: `127.0.0.1:3306`, database `aladham_oct`. Neither new table exists
there. No migration was applied to that database. No production access was used.
Existing unfinished work, `.env`, `.env.example`, mobile routes and payloads were
preserved. No commit, push or deployment.

## Why the return guard existed

Legacy marks and report cards are addressed by student/room/year, not an enrollment
visit. Reusing those rows on A -> B -> A would expose the first A visit's marks to
current edits. Simply adding another row would make `first()` and legacy joins
ambiguous. Modern results also represent an original student/assessment attempt,
not a new attempt on each enrollment visit.

## Additive structure

Migration: `database/migrations/2026_11_19_000001_create_student_academic_visit_records.php`.

- `student_academic_visit_records`: append-only attribution of an original record
  to a placement, with student/year/section, record kind, original ID and evidence.
- A unique `(record_type, record_id)` prevents reparenting one original to another
  visit. `(placement_id, summary_type)` allows exactly one linked marks summary and
  one linked report per visit. NULL summary types allow multiple assessments/files.
- Supported originals: `students_marks`, `report_cards`, `exam_result2`,
  `exam_result`, `exams_files`, `student_lesson_teacher_room_term_exam`, certificates.
- Follow-ups already have `student_academic_placement_id`; no parallel copy is made.
- `student_placement_reconciliations`: actor, reason, verified current enrollment,
  observation placement, original state snapshot, confirmation time and explicitly
  unknown historical transition date.
- No academic column changes, destructive backfill, result duplication or file
  migration. Mixed legacy ID types are left intact; attribution is validated under
  the student lock rather than introducing incompatible polymorphic foreign keys.
- A physical/partially existing foundation is refused. Down refuses to drop either
  table once retained links or reconciliation events exist.

## Transfer and read/write contracts

1. Existing Admin authorization, active year/section checks and single enrollment
   validation remain. The student, enrollment, placement and related source rows
   are locked within the transaction.
2. Originals from a uniquely documented source visit receive sidecar links, never
   edits. A sole documented historical destination visit can also be linked before
   returning. Multiple unresolved visits are never chosen arbitrarily. Known dates
   outside the documented interval are not asserted to belong to that visit.
3. Close the source placement, append the destination placement and transfer event,
   update the legacy current enrollment projection and create fresh EMPTY marks and
   report rows linked to the new visit. Never reuse, reset or copy the older rows.
4. Existing operational summary queries select the latest documented visit within
   each student/year. This is not a global-current-year history filter. Historical
   Academic Record queries explicitly bypass that projection and select visit links.
5. Eloquent model and bulk-write guards freeze attributed closed originals and
   unresolved multi-visit originals. Joined Admin report-publication queries are
   constrained to the matching enrollment/year and writable visit; lifecycle safety
   checks explicitly inspect all retained summaries, not just the operational row.
6. For a return to the same assessment, display the original as carried/read-only.
   Explicit cross-section equivalence remains the only cross-assessment carry rule.
   No title matching, numerical ID replacement, copied results or invented retakes.
   Unassigned/conflicting attempts are excluded from current calculations; the
   unchanged original remains available in its legacy history context.
7. Teacher mark writes and transfer writers serialize on the student lock. A stale
   grade writer must re-authorize after waiting; loaded old models cannot overwrite
   a closed visit. Current linked summaries remain editable normally.
8. Closing through Archive also attributes the visit before withdrawal. This does
   not expand Restore policy or change its existing activity protections.

## Explicit Admin reconciliation

Use the existing individual transfer modal on Student Details. If enrollment and
placements disagree, the placement is missing/ended, or summaries conflict, it
requires an explicit verification checkbox and 20-2000 character evidence/reason.
The posted enrollment and active-placement IDs are checked again under lock.
Only an authenticated user with `edit_student` may confirm.

The observation starts NOW. It is closed when the requested transfer is recorded;
the destination starts NOW. No guessed earlier transfer date is entered. Earlier
existing end dates are retained. Pre-existing records are never assigned to the
instantaneous observation visit. Student history labels reconciled intervals as
unverified instead of presenting the observation as a proven historical move date.
The same confirmation is not silently inferred for bulk requests; mismatches must
be reviewed individually. An interrupted confirmation/transfer rolls back together.

## Student history and current content

- The normal Academic Record still has one main card per year, no future years.
  Same-year placements are read-only drill-down links, not duplicate top-level cards.
- A clearly labelled legacy section/year view exposes unassigned originals where
  the exact visit cannot be proven. It does not assign them to the current visit.
  Multiple retained summary rows are rendered individually, not collapsed with
  `first()`. Terms resolve only from the selected academic year.
- Result privacy flags, individual publication and student ownership still apply.
  Owned submissions use exact visit attribution when known; unknown legacy visits
  do not grant access to another student's files or Teacher learning materials.
- Student follow-up lists remain student/year-based and retain observations across
  sections. New observations link the new placement; closed linked observations
  cannot be edited even inside the usual two-hour window.
- Normal lessons/content and timetable requests use current section membership.
  Returning to A restores A's normal content, not a historical content browser.
- A Web upload bug that deleted prior exam submissions was removed. Both Web upload
  paths now retain originals, allocate unique new paths, link the current visit,
  serialize with transfers, and remove only newly written files on DB failure.
  Existing paths, files and download routes are not moved or rewritten.

### Private Teacher material policy (unchanged)

The pre-existing private attachment download policy still has its historical
placement fallback. It is NOT broadened or used for historical lesson discovery.
Normal lesson/category endpoints remain current-section-only. Tightening that
separate existing download policy needs the owner's explicit approval. Existing
public legacy Teacher URLs likewise are not migrated into private storage.

## Exact files changed in this pass

New foundation and migration:

- app/Services/AcademicVisitRecords.php
- app/Services/AcademicVisitBuilder.php
- app/Services/StudentPlacementReconciliation.php
- app/Concerns/BelongsToAcademicVisit.php
- database/migrations/2026_11_19_000001_create_student_academic_visit_records.php

Existing models/services integrated (including preservation of earlier dirty work):

- app/Certificate.php
- app/Exam_file.php
- app/Exam_result.php
- app/Exam_result2.php
- app/Report_card.php
- app/Students_mark.php
- app/Student_lesson_teacher_room_term_exam.php
- app/StudentFollowUp.php
- app/Services/StudentTransferService.php
- app/Services/StudentAcademicHistory.php
- app/Services/AssessmentContinuityService.php
- app/Services/GradebookReadService.php
- app/Services/StudentAssessmentReadService.php
- app/Services/StudentFollowUpService.php
- app/Services/StudentLifecycleService.php
- app/Services/UnusedQuizMaintenance.php

Web queries and presentation:

- app/Http/Controllers/admincontroller.php
- app/Http/Controllers/studentscontroller.php
- app/Http/Controllers/DashboardController.php
- app/Http/Controllers/ReportController.php
- resources/views/admin/student_details.blade.php
- resources/views/students/academic_record_show.blade.php
- resources/lang/ar/student_transfer.php
- resources/lang/en/student_transfer.php
- resources/lang/ar/student_history.php
- resources/lang/en/student_history.php

Tests and this report:

- tests/Concerns/AcademicVisitChecks.php
- tests/Feature/GradebookSafetyTest.php
- tests/Feature/TeacherStudentFollowUpEligibilityTest.php
- tests/Integration/section-transfer-history-mariadb.php
- tests/Integration/academic-visit-concurrency.php
- tests/Integration/academic-visit-worker.php
- docs/audits/student-transfer-return-visits-implementation-2026-11-19.md

## Verification

SQLite runs use in-memory databases and opt-in temporary storage. MariaDB runs
create random `aladham_lesson_test_*` databases and temporary storage, reject school
database reuse, and verify actual database identity before writes or migrations.
Separate PHP processes verify both lock orders against real InnoDB transactions.

Coverage includes A -> B, A -> B -> A, repeated visits, activation after a prior
legacy transfer, original earned zeroes, independent and explicitly equivalent
assessments, fresh report/marks summaries, current editing vs historical freeze,
Student follow-up visibility and login credentials, current timetable/lessons and
Teacher rosters, owned submission access and upload compensation, student isolation,
privacy/publication, audited mismatch confirmation, missing placements, ambiguous
legacy summaries/attempts, stale/unauthorized confirmation, idempotent retry, rollback,
neighbor preservation and named migration repeat/refusal safeguards.

Final results:

- Gradebook safety, privacy, return visits and history: **126 tests / 2,779 assertions**.
- Teacher/student follow-up eligibility and transfer preservation: **17 / 314**.
- Lesson workspace, Student follow-up views and Admin follow-up regressions: **17 / 467**.
- Total PHP feature suites: **160 tests / 3,560 assertions**, all passed.
- Disposable MariaDB: **438 assertions**, including 59 transfer/visit checks on top
  of 379 existing upload/quiz checks. Final database:
  `aladham_lesson_test_766294a1f4f4d9bd`, server `10.4.32-MariaDB`.
- Real InnoDB trigger failure rolls back attribution, source closure, destination,
  enrollment, audit and scaffolds. Two independent PHP processes verify grade-first
  and transfer-first lock orders. Joined publication updates only the current report.
- Both existing lesson-workspace and upload-selection Node regression checks passed.
- Changed PHP/Blade source lint: **55 files**, passed. Changed sources decode as
  UTF-8 without BOM. `git diff --check` passed; protected environment/cache files
  unchanged. Blade cache was rebuilt in isolated temporary compiled-view storage.
- Changed compiled views pass PHP lint. The broader all-view lint passed 781 of
  784 compiled views and found three pre-existing errors in untouched templates:
  `students/new_start_exam3.blade.php` (empty `@if()` / `@elseif()`),
  `coordinators/load_en.blade.php`, and `acadsupervisors/load_en.blade.php`
  (malformed condition directives). Git comparison confirms no changes to these
  files. No controller references to `new_start_exam3` were found; the two English
  legacy load templates have Coordinator/Academic Supervisor callers. These are
  deferred unrelated defects, not transfer fixes or a claim of globally clean Blade.
- Read-only before/after SHA-256 row fingerprints match for **16 school tables**,
  including all students/users, enrollments, placements, transfer events, marks,
  reports, results, submissions, follow-ups, invoices, transport invoices, invoice
  images and fee settings. Student 1444 is included in the unchanged student set.
  Both new tables and their migration registration remain absent on the school DB.
- SELECT-only engine inspection confirmed all 13 existing core student/placement/
  result/report/submission/follow-up tables checked locally use InnoDB. This is not
  a verification of the hosted production database.

HTTP tests render real child views with unrelated shared-shell queries isolated.
They are not graphical browser acceptance. The browser tool exposed no browser
sessions. No authenticated live-school transfer or screenshot verification is
claimed. Optional large multipart/media transport gates in the pre-existing upload
runner were not requested; those are unrelated to this transfer change.

## Remaining boundaries and activation requirements

- Still block multiple/missing current enrollments, records without an original
  section, contradictory class/known term context, and invalid/future placement
  intervals. Do not auto-reconcile those records. Unproven visit attribution remains
  read-only legacy context, not a reason to refuse every valid return transfer.
- A new attempt on the SAME original exam ID is not invented. A genuinely new
  occurrence needs a new assessment definition; the original attempt stays frozen.
- Legacy mobile routes and response contracts are unchanged. Raw legacy SQL writers
  do not acquire Eloquent attribution automatically; unassigned records are handled
  conservatively. This is not a claim that the unauthenticated legacy API security
  exposure has been repaired.
- Missing local legacy upload bytes cannot be restored by attribution. Earlier
  read-only checks found missing stored files; the isolated tests use real fixture
  files. No existing uploaded file was moved, deleted or replaced in this pass.
- Before activation: review code and this report, back up the intended database and
  files, confirm DB identity/engines and schema registration, then obtain approval
  to run ONLY the named additive migration. No all-pending migration command.
- After approved activation, verify an authorized Admin modal and real Teacher /
  Student flows visually, including RTL/mobile, selected-visit history, current
  lesson access and the separate existing private-download policy. Do not test by
  silently transferring student 1444 or another real student.

The old return restriction remains fail-closed ONLY when the new schema is absent.
With the foundation active in fixtures, valid repeated return transfers succeed.
