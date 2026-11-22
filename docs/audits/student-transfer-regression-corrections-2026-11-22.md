# Post-transfer regression corrections

Date: 2026-11-22. Scope: the three approved regressions R1/R2/R3 only.
Baseline: `student-transfer-post-regression-audit-2026-11-22.md`.

## 1. Reproduction and fixes

All four audit failures were reproduced before source edits: 4 tests, 52
assertions, 4 failures. The complete final suite includes all four, now passing.

### R1: legacy mobile assessment uploads

Both `upload_exam_files` and `upload_exam_files2` selected the first globally
flagged current term, not the assessment's term. The local school has a flagged
term in both years 5 and 6; the first is term 17/year 5, whereas the fixture
assessment belongs to term 20/year 6. Before visit activation the upload could
save incorrect context. After activation, attribution rejects that mismatch with
422, after the public file has already been written. There was no transaction
or file compensation, so a rejected request left an orphan. A multi-file request
could also partially persist.

Both controllers now delegate to `MobileAssessmentSubmission`. It preserves the
single base64 and JSON-array base64 request formats, the stored extension value,
the HTTP 200 `status`/`msg` success envelope and original Arabic success message.
Existing missing-extension/item/file error envelopes remain. New failure paths
also use that legacy error envelope, without exception details.

The service verifies current operational membership, active year, assessment
room/class/subject and the actual assessment term's year before writing. Another
valid term within the same active year remains supported, matching Web upload
semantics; it is not replaced by the globally flagged term. Student, assessment
and year locks protect the transaction. Files/rows are appended, not replaced.
All new rows and visit attribution roll back together. Compensation removes only
new paths, including partially written paths, on a false storage return,
exception, or database failure. Cleanup failures are reported server-side.

The legacy mobile authentication contract is NOT changed or repaired here.
Operational-student middleware and authenticated-student ownership checks remain;
they are not a substitute for authenticated mobile identity.

### R2: unused participation and quiz maintenance

New participation placeholders receive visit links even without a mark or attempt.
The general model deletion guard rejected every linked record, and Admin unused
quiz maintenance also classified every sidecar as retained academic activity.

`UnusedAssessmentParticipation` is a narrow internal maintenance exception. It
requires the surrounding locked transaction and rechecks the freshly locked row,
current student, assessment context, current year/term, membership and visit.
It rejects earned zeroes, any other mark, selected questions, answers, traditional
results, start/end timestamps, completed status, medals, file submissions or
alternate `exam_result_tester` attempts, invalid
attribution, closed visits and ambiguous unlinked return visits. Placement locking
reads additionally guard against concurrent transfer state changes.

Teacher participation removal uses this exception only for the existing current
roster removal set. Admin quiz maintenance additionally requires unpublished empty
placeholders and retains all existing definition/dependency/equivalence checks.
Only the eligible target's empty participation and its sidecar are removed.
The generic model/bulk history guards are unchanged. Other quizzes/results are
not deleted. A later transaction failure restores the placeholder and its link.

### R3: Gradebook read query growth

`resultState()` previously issued schema/link/room/placement queries per result;
continuity projections repeated those reads, and section-name queries ran per
student as well. Even an absent visit schema generated repeated metadata queries.

`AcademicVisitReadContext` loads links by record type, rooms and placements in
batches and resolves states/names in memory. Its lifetime is one local read, not
a singleton or persistent cache. Both direct Gradebook results and equivalent or
independent continuity projections use it. Writer integrity checks still resolve
fresh state; no result selection, component mapping, maximum, averaging, total,
zero/null handling, original result ID or authorization policy was changed.

## 2. Query evidence

Same ordinary-student fixture: one assessment, same contexts, 1 versus 12 students.

| Visit schema/context | Before: 1 / 12 | After: 1 / 12 |
|---|---:|---:|
| Absent | 14 / 36 | 13 / 13 |
| Active, unlinked originals | 27 / 93 | 29 / 29 |
| Active, linked originals | 26 / 81 | 29 / 29 |

The fixed overhead with visits is slightly higher for one student, but student
count no longer increases SQL count. A mixed fixture with equivalence, four modern
assessments, both actual terms, a dynamic component and legacy oral results used
102 queries for both 1 and 40 students. Every expected component, total, original
result/assessment ID and maximum was asserted, including zero and null.
Repeated in-memory state/link/name resolution performs no SQL.

MariaDB's separate two-assessment fixture used 42 / 42 queries with linked visits
and 16 / 16 without visit tables, for 1 / 12 students. Its computed marks agreed
in both schema modes. These different fixtures are not interchangeable baselines.

## 3. Verification

### PHPUnit: 260 tests / 6,655 assertions, all PASS

| Suite | Tests | Assertions |
|---|---:|---:|
| GradebookSafetyTest | 155 | 4,086 |
| GradebookAdminV2Test | 15 | 1,089 |
| GradebookTemplatesTest | 18 | 206 |
| TimetableAuthorityTest | 17 | 205 |
| SchoolLoginNavigationTest | 8 | 133 |
| TeacherStudentFollowUpEligibilityTest | 17 | 314 |
| LessonWorkspaceViewTest | 9 | 315 |
| StudentFollowUpViewTest | 2 | 29 |
| AdminStudentFollowUpObservationViewTest | 3 | 104 |
| AdminStudentFollowUpReportingTest | 3 | 19 |
| LessonAttachmentProposalTest | 3 | 17 |
| GradebookContextReaderTest | 8 | 97 |
| AdminTeacherTimetableViewTest | 2 | 41 |

Nine new corrective tests supplement the original audit coverage. Coverage includes
malformed/mobile payloads, actual term IDs, wrong year/section/student, repeated
uploads, SQL/storage failure and partial bytes, preserved previous uploads,
earned-zero/attempt/submission guards, placeholder rollback, closed/ambiguous
visits, fresh versus batched states and equivalent/legacy calculation agreement.

Existing regressions cover ordinary never-transferred students, transfers and
return visits, explicit reconciliation safety, original-history read-only guards,
follow-ups from previous sections, Teacher eligibility, current-section learning
content, results/publication/privacy, reports/certificates, historical submissions,
Student login, roles, lifecycle and preserved finance. All remain passing.

### Frontend and MariaDB

- All 17 existing Node frontend test files pass; no frontend source was changed.
- `post-transfer-corrections-mariadb.php --create-disposable-database`: PASS,
  93 assertions, including the 58 existing student-workflow checks and 35 additional
  checks. MariaDB 10.4.32, random database
  `aladham_student_workflow_test_1efaf0014ac95214`.
- Only DDL was read from the local school DB to create the disposable schema;
  no school rows were copied. No Artisan migration command was run. Schema-absent
  testing temporarily renames the two fixture visit tables, restoring them in
  `finally`, never touching school tables.
- Actual fixture HTTP kernel requests exercise both mobile routes, authenticated
  cross-student denial, and Admin quiz deletion. InnoDB trigger failures prove
  upload/participation/transfer rollback. An earned zero stays protected, normal
  grade editing retains its ID, and A -> B -> A preserves original marks, reports,
  results, files, invoice and account. The unselected neighbor stays unchanged.
- The successful fixture and isolated storage are retained for inspection:
  `%TEMP%/aladham-student-workflow-6cd3d3d7be8f1bfbd66849c098315c4a`.
  Earlier runner attempts exposed fixture seed omissions/type comparisons, not
  application regressions; those disposable databases were not reused as school
  data or destructively removed.

### Static/runtime safety

- All 12 changed PHP sources lint successfully and are UTF-8 without BOM.
- `view:clear` / `view:cache` succeeded using temporary compiled-view storage,
  SQLite memory configuration and array cache/session, not operational caches.
  Lint of 790 compiled files (including test views) passes for 787. The same three
  pre-existing parse failures remain: `students/new_start_exam3.blade.php`,
  `coordinators/load_en.blade.php`, `acadsupervisors/load_en.blade.php`. No Blade
  source changed; these unrelated defects were not repaired.
- `git diff --check` passes. All unrelated starting dirty/untracked file hashes
  are unchanged. `.env`, `.env.example`, configuration, routes, migrations,
  academic/finance models and transfer/membership services were not edited.
- Read-only before/after row counts AND SHA-256 fingerprints match for all 19
  school tables: identities, enrollments/placements/transfer/reconciliation/visit
  history, marks/reports/results/submissions, follow-ups/certificates and four
  finance tables. The globally active year is unchanged. No real uploaded file
  was moved, deleted, renamed or replaced.

## 4. Exact files changed by this pass

Application:

- `app/Http/Controllers/Api/websitecontroller.php`: delegate the two upload actions.
- `app/Services/MobileAssessmentSubmission.php`: new atomic legacy upload adapter.
- `app/Services/UnusedAssessmentParticipation.php`: new narrow guarded cleanup.
- `app/Services/TeacherAssessmentService.php`: use guarded participation cleanup.
- `app/Services/UnusedQuizMaintenance.php`: validate/clean eligible placeholders.
- `app/Services/AcademicVisitReadContext.php`: new ephemeral batched read snapshot.
- `app/Services/GradebookReadService.php`: batched state/name reads.
- `app/Services/AssessmentContinuityService.php`: batched independent/equivalent reads.

Tests/documentation:

- `tests/Concerns/PostTransferRegressionChecks.php`: strengthen the four audit checks.
- `tests/Concerns/PostTransferCorrectiveChecks.php`: nine isolated corrective tests.
- `tests/Feature/GradebookSafetyTest.php`: include the new corrective trait.
- `tests/Integration/post-transfer-corrections-mariadb.php`: guarded disposable checks.
- This report.

## 5. Remaining acceptance and release limits

The three approved regressions are corrected and their isolated acceptance passes.
This is not a blanket production-release signoff for the entire dirty worktree.

No authenticated graphical browser or actual mobile-client verification was
performed. In approved QA, check both mobile upload forms/contracts and repeated
uploads; Teacher participation removal; Admin unused quiz removal; zero/attempt
refusal; Admin/Teacher Gradebook and Student historical views after a return visit.
Existing browser/private-attachment/Hostinger acceptance from the prior audit
remains outstanding, as do the unrelated legacy Blade defects and mobile API
authentication exposure. Existing ambiguous/inconsistent student records remain
blocked; none were reconciled. A storage cleanup failure is logged and requires
operational attention; compensation cannot override a filesystem refusing deletion.

No school-data modification, operational migration, environment change, commit,
push or deployment occurred. No new blocker was found in the approved scope.
