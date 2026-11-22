# Student section transfer: preservation implementation

Date: 2026-11-19. Local implementation only; not deployed.

## Final policy

- Normal learning-content interfaces belong to the current section only.
- Student-owned marks, results, reports, follow-ups and submitted files retain
  their original section/year/assessment context after transfer.
- No grade or content copying, inferred equivalence, account recreation or
  financial changes. Existing verified assessment continuity remains unchanged.
- No historical Teacher learning-content discovery was added.

## Changes

1. StudentTransferService revalidates student lifecycle, active year, source and
   destination rooms, enrollment, marks and report-card state under transaction
   locks. Audit snapshots use the reloaded source rows. Inconsistent class,
   placement interval and enrollment context fails closed. Return visits remain
   blocked. Destination scaffold values are always empty, regardless of posted
   mark-like inputs. Existing scoped earned records are not blockers.
2. CurrentStudentMembership now converts comparison instants to the application's
   timezone before comparing timezone-less placement timestamps. The follow-up
   placement lookup uses the same conversion. No stored date or timezone setting
   is changed. Disposable MariaDB revealed a real one-hour winter discrepancy:
   this PHP 7.4 runtime reports Damascus +02:00 while app.timezone is Riyadh
   +03:00. Previously a committed placement could temporarily disappear from
   operational rosters. School month/half and two-hour follow-up policies remain
   unchanged. Do not reinterpret or backfill uncertain legacy timestamps.
3. StudentAcademicHistory validates ownership, active/past year and section/class
   context. Academic Record keeps one top-level card per year, with links inside
   a selected placement to its same-year active/closed/withdrawn placements.
   Each detail still queries only its selected original context.
4. A read-only StudentAcademicSubmissionController endpoint serves only the
   authenticated student's recorded submission in the selected placement.
   Both known legacy filesstudents/... and public/filesstudents/... forms work.
   Realpath/prefix checks reject traversal, Teacher files, missing files and
   symlinks escaping the student-upload directory. Responses are attachment-only,
   private/no-store and nosniff. Files are not moved or migrated. Existing public
   legacy URLs remain public; this endpoint does not retroactively privatize them.
5. Current section membership is required by the lesson listing and legacy
   lecture category entry points, reusing existing lecture access checks.
6. Transfer notice/error copy now distinguishes unscoped records, a return visit
   and an inconsistent placement. No advice to delete or archive earned records.

## Files changed in this pass

- app/Services/StudentTransferService.php
- app/Services/CurrentStudentMembership.php
- app/Services/StudentFollowUpService.php
- app/Services/StudentAcademicHistory.php (new)
- app/Http/Controllers/studentscontroller.php
- app/Http/Controllers/StudentAcademicSubmissionController.php (new)
- routes/student.php
- resources/views/students/academic_record_show.blade.php
- resources/lang/ar/student_history.php (new)
- resources/lang/en/student_history.php (new)
- resources/lang/ar/student_transfer.php
- resources/lang/en/student_transfer.php
- tests/Concerns/SectionTransferHistoryChecks.php (new)
- tests/Feature/GradebookSafetyTest.php (additive trait inclusion only)
- tests/Feature/TeacherStudentFollowUpEligibilityTest.php
- tests/Integration/section-transfer-history-mariadb.php (new)
- this report

All pre-existing working-tree changes were preserved. No migration, environment,
mobile API, Teacher attachment access-policy or financial code changes.

## Verification

- Final Gradebook suite: 109 tests, 2,420 assertions, all passing. Final run uses
  its own temporary storage (aladham-gradebook-2a-18c004a39add4617b678fc92d186567a)
  and SQLite :memory:, with PHPUnit result caching disabled. Do not overlap
  fixture runs sharing the same fake-disk directory; an intermediate overlapping
  run exhibited test-storage interference and was replaced by this clean run.
- Final targeted transfer HTTP/controller checks: 9 tests, 150 assertions.
- Teacher follow-up eligibility/transfer suite: 16 tests, 286 assertions. Includes
  rendered Student Portal visibility of old/new section follow-ups and immediate
  winter destination placement eligibility. Fixture placement instants are stored
  in application-local time, matching actual transfer writes; future-placement
  denial remains tested.
- Lesson workspace Blade suite: 9 tests, 315 assertions.
- Student follow-up view suite: 2 tests, 29 assertions.
- Disposable MariaDB 10.4.32: 399 assertions including the existing upload suite
  and 20 new transfer assertions. Database aladham_lesson_test_8b6ba8a6d0a712e8;
  storage is outside the project under aladham-lesson-test-da79958b9596a0d4b7d40333aed3fef0.
  The runner verifies its random local database identity before mutation.
  InnoDB failure injection after projection/history/marks changes rolls back
  everything. Successful transfer preserves original rows/account credentials,
  closes/creates placements, updates membership, keeps a neighbor unchanged,
  renders original results and serves only owned submissions.
- Both lesson-workspace and upload-selection Node regression scripts pass.
- PHP lint, UTF-8 without BOM checks, Blade cache compilation and diff whitespace
  checks run without application/schema changes. Blade cache targets isolated
  temporary storage, not the school's compiled cache.
- No graphical/authenticated browser acceptance claimed. HTTP/controller tests
  use isolated fixture accounts and the real routes/child views with a fixture
  shared layout. Full production layouts and device-level visual QA remain manual.
- Optional large real multipart/video transport gates were not rerun; this pass
  does not change upload behavior.

## Real-data checks and limitations

Only SELECTs were run against aladham_oct, inside read-only transactions.
Student 1444 remains unchanged: account 1657, enrollment 2137 in room 164,
placement 2032 active in room 176, original marks 2440 in room 176, 14 follow-ups,
zero transfer events, invoice 3084 unchanged. No reconciliation was attempted.

All 18 local student-submission paths (16 exams_files and 2 legacy submissions)
use the supported path forms, but their bytes are missing on the configured local
public disk. The new endpoint correctly returns 404 rather than serving another
file. Fixture downloads pass with real isolated files. Restoring real missing
files requires a separate owner-approved storage task; database rows were not
rewritten. The earlier 170 missing private Teacher attachment files are a separate
pre-existing local storage issue, not a transfer repair performed here.

Blocked scenarios remain: source placement/enrollment mismatch, conflicting rows,
ambiguous unscoped academic activity, future/invalid placement intervals and
returning to an already-used section in the same year. No destructive workaround.

## Separate access-policy decision

LessonContentAccess::download already has a historical-placement fallback for
some private Teacher attachments. It is NOT modified, expanded or used for the
new historical student-submission endpoint. Removing/narrowing that existing
fallback needs a separate explicit decision. Normal lesson interfaces do reject
old sections. Existing public Teacher file URLs likewise remain unchanged.

## Production requirements

No new migration or environment flag is required. Deploy all changed application,
route, view and language files together only after owner approval, then refresh
the relevant route/view caches through the normal release procedure. Verify the
public disk's student-upload files and permissions. Confirm PHP timezone data and
the effective application timezone on the host without rewriting old timestamps.
Confirm original publication/privacy controls and authenticated Student/Admin/
Teacher workflows on hosting. Mobile contracts are untouched and do not acquire
the new Web history endpoint automatically. No commit, push or deployment made.
