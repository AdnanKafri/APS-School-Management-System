# Post-transfer regression audit and release gate

**Verdict: NOT READY FOR PRODUCTION RELEASE.** The established tests pass, but
new activation-aware coverage reproduces three regressions through four failing
tests. No application fixes were made. Approval is required for a corrective pass.

## 1. Scope and actual local state

Reviewed the current Git diff, untracked implementations, and the November 19
preservation, return-visit and simplified-UX reports. The simplified-UX report
supersedes the older checkbox/evidence-textarea instructions, not its history
preservation contract. The dirty tree also contains earlier quiz-maintenance and
media-capacity work; that work is distinguished below rather than attributed to
transfer alone.

The November 19 reports' activation-pending statement is now outdated locally:
SELECT-only checks found the visit migration already registered in **batch 27**,
three visit links and one reconciliation event. The active year is **6 / 2026/2027**.
No migration or activation was performed by this audit. Checked core/visit tables
use InnoDB, and the visit indexes exist. Hosted production state is unknown.

There are **542 current operational students without a transfer-history event**;
this is a population count, not a claim to have tested every account. New fixtures
explicitly cover ordinary never-transferred students with the visit foundation
enabled, not just repeated-transfer fixtures.

## 2. Complete application impact map

Paths below identify every application/configuration/view/schema file in the
starting dirty tree. Tests and earlier reports are listed separately. No listed
application file was edited during this audit.

| Changed files | Direct and indirect consumers / effects |
|---|---|
| `app/Students_mark.php`, `app/Report_card.php` | New visit trait/builder and operational summary global scope. All direct Eloquent queries AND `Student::student_mark`, `Student::report_card` and nested Room/Student relationships inherit it: Admin/Teacher grading, imports, summaries, reports, Student results and API reads. Historical callers must explicitly bypass the operational scope. |
| `app/Exam_result.php`, `app/Exam_result2.php` | Model save/delete and bulk-write guards affect Web, Admin, Teacher, Coordinator and legacy API writers, not only transfer. Result serialization fields are unchanged, but write acceptance can change: see R1/R2. |
| `app/Exam_file.php`, `app/Student_lesson_teacher_room_term_exam.php`, `app/Certificate.php` | Attribution and history protection affect student uploads, certificate creation/editing/deletion, relationship reads and API uploads. No attachment bytes/paths are migrated. |
| `app/StudentFollowUp.php` | Placement-aware edit eligibility adds to existing ownership/two-hour rules. Teacher and Admin-on-behalf editing/history/roster presentation are indirect consumers. |
| `app/Concerns/BelongsToAcademicVisit.php`, `app/Services/AcademicVisitBuilder.php`, `app/Services/AcademicVisitRecords.php` | Central schema gate, student-lock saves, created-record attribution, current-summary scope, historical reads, frozen originals and bulk mutation protection. Broadest impact surface; R1/R2/R3 cross this layer. Raw query-builder SQL does not automatically acquire model hooks. |
| `app/Services/StudentTransferService.php`, `app/Services/StudentPlacementReconciliation.php` | Individual/bulk transfers and legacy delegators; profile section changes; current observation/audit, closure, fresh destination/scaffolds, return visits, automatic evidence vs explicit exceptional review, rollback and Arabic feedback. |
| `app/Services/CurrentStudentMembership.php` | Timezone-consistent membership/entry context. Indirect consumers include Teacher rosters, assignment authorization, Student current content, timetable, grading and follow-ups. Student identity is not replaced. |
| `app/Services/AssessmentContinuityService.php`, `app/Services/GradebookReadService.php`, `app/Services/StudentAssessmentReadService.php` | Original/current/carried/conflict state, earned zeroes, equivalence, independent return attempts, read-only carried grades, current participation and Student-safe cards. Admin/Teacher grids and legacy assessment screens call these services indirectly. R3 concerns query growth, not changed weighting. |
| `app/Services/StudentAcademicHistory.php`, `app/Http/Controllers/StudentAcademicSubmissionController.php` | Student-owned placement/movement context and authenticated submission downloads, path traversal/symlink containment and ownership. Never grants historical learning-content discovery. |
| `app/Services/StudentFollowUpService.php` | Placement-time resolution and student lock on edits; Teacher and Admin-on-behalf operations, Student prior-section follow-up visibility. |
| `app/Services/StudentLifecycleService.php` | Archive attributes the source visit before withdrawal; retained-history checks inspect all summaries rather than the current projection. Restore still uses existing activity/conflict protections. |
| `app/Http/Controllers/admincontroller.php` | History flag on existing student-context JSON; details/current section; normal transfer and exceptional approval presentation. Existing update/transfer callers also use the shared service. |
| `app/Http/Controllers/studentscontroller.php` | Current-section timetable/lessons/category authorization; append-only uploads and rollback cleanup; selected-visit Academic Record data/legacy bucket, result presentation and movement/submission links. Shared Student layout remains a dependency. |
| `app/Http/Controllers/DashboardController.php` | Eight joined marks/report publication/update branches now constrain section/year and writable visits. Other dirty changes are the earlier independent unused-quiz repair, which interacts with R2. Active Students page is `admin.student`, not the legacy plural view. |
| `app/Http/Controllers/ReportController.php` | Chart marks query now uses the scoped model rather than raw table; report/chart consumers must retain correct year/section context. Exhaustive chart/PDF acceptance is still pending. |
| `app/Services/UnusedQuizMaintenance.php` | Earlier quiz-repair work: independently withdraw unused section definitions without altering peers. The visit-link guard now conflicts with genuinely unused current participation in R2. |
| `app/Http/Controllers/TeacherController_New.php`, `app/Http/Controllers/LessonContentController.php`, `app/Services/LessonContentInput.php`, `app/Services/LessonContentLimits.php`, `app/Exceptions/Handler.php` | Adjacent earlier media-capacity work: centralized 30 files / 100 MiB each / 150 MiB total, video validation/inline delivery and scoped oversized-request feedback. Not a transfer change or proof of hosted upload capacity. |
| `routes/student.php` | Adds only the authenticated placement/submission download route, with `lesson|exam` kind restriction. Existing Student route group remains authoritative. No mobile routes/auth contract change. |
| `resources/views/admin/student.blade.php`, `resources/views/admin/student_details.blade.php`, `resources/views/admin/students/_transfer_history_notice.blade.php`, `resources/views/admin/students/_transfer_review.blade.php` | Simple normal modals, exact Arabic notice, existing named AJAX URL, stale-response guard and separate exceptional approval. Admin layout/DataTables remain dependencies. |
| `resources/views/students/academic_record_show.blade.php` | Exact placement detail, movement links and explicit unattributed legacy history; one main year card remains in the existing list flow. |
| `resources/views/teachers2/teacher_addcontent.blade.php`, `public/teachers_2/assets/js/lesson-upload-selection.js`, `config/lesson_content.php` | Earlier upload-capacity UI/configuration; no transfer navigation redesign. |
| `resources/lang/ar/student_transfer.php`, `resources/lang/en/student_transfer.php`, `resources/lang/ar/student_history.php`, `resources/lang/en/student_history.php`, `resources/lang/ar/assessment_entry.php`, `resources/lang/en/assessment_entry.php`, `resources/lang/ar/lesson_content.php`, `resources/lang/en/lesson_content.php` | Transfer/reconciliation/history messages, retained-assessment feedback and adjacent upload limits. |
| `database/migrations/2026_11_19_000001_create_student_academic_visit_records.php` | Existing additive dependency: unique original `(record_type, record_id)`, per-visit marks/report summary uniqueness, context indexes and reconciliation audit. No academic-column rewrite/backfill; no polymorphic foreign keys. Application validation/locks provide those link checks. Populated destructive rollback is refused. Unchanged and not operationally run in this audit. |

Database dependencies include permanent `students/users`, `room_student`,
`student_academic_placements`, transfer/reconciliation/visit histories, marks,
report cards, both result systems, both submission systems, certificates,
follow-ups/assignment periods, years/actual terms, classes/sections/subjects,
timetable assignments and assessment-equivalence definitions. Financial tables
are preservation invariants, not transfer destinations.

Existing supporting changes reviewed: `tests/Feature/GradebookSafetyTest.php`,
`TeacherStudentFollowUpEligibilityTest.php`; `tests/Concerns/AcademicVisitChecks.php`,
`SectionTransferHistoryChecks.php`, `StudentTransferUxChecks.php`;
`tests/Frontend/lesson-upload-selection.test.js`, `student-transfer-ux.test.js`;
`tests/Integration/lesson-content-mariadb.php`, `section-transfer-history-mariadb.php`,
`academic-visit-concurrency.php`, `academic-visit-worker.php`,
`lesson-content-http-capacity.php`, `quiz-upload-capacity.php`.
The integration runners that invoke Artisan migrations were inspected, not run.

## 3. New regressions requiring approval

### R1 High: legacy mobile uploads rejected and new files orphaned

Affected: `/api/dashboard/student/upload_exam_files` and `upload_exam_files2`.

Both API methods choose `Term_year::where('current_term', 1)->first()` without year
scoping and write bytes BEFORE saving `Exam_file`. The new created-record hook
validates attribution against the actual room/placement year. A wrong-year term
therefore rejects the save, correctly protecting academic context; the legacy API
does not compensate the bytes or preserve its old success response.

Evidence: the real local SELECT returns **term 17/year 5** for that unscoped lookup,
while the active year is **6** with **term 20**. No real API upload was attempted.
In isolated fixtures for a never-transferred student, both routes return HTTP 200
and `{status:true,msg:...}` before activation. After activation, both return **422**
with a different JSON shape, create **one orphan file each**, and leave submission
row count unchanged at two. Existing submitted rows remain intact.

The unscoped lookup and missing cleanup predate this work; activation introduces
the reproducible rejection of these formerly accepted requests. Restoring the old
wrong-term write or removing the integrity guard is NOT an acceptable fix.

Reproduce: configure one current term in an older year and one in the active year;
give an ordinary student an active enrollment/placement and active-year assessment;
POST base64 content to each route, then enable fixture visit tables and repeat.
Test: `test_audit_legacy_mobile_upload_success_contract_across_visit_activation`.

Recommended minimal approved fix: resolve the submitted assessment's actual valid
term/year, validate current student membership before writing, and compensate only
new bytes on failure. Preserve the existing success contract and do not change
legacy authentication as a side effect. Confirm expected error compatibility too.

### R2 Medium: unused participation becomes undeletable retained history

`AcademicVisitRecords::created()` attributes every new result, including an
unattempted NULL placeholder. `BelongsToAcademicVisit` rejects deletion of any
attributed row; `UnusedQuizMaintenance::assertUnused()` likewise rejects any link.

Reproduce with no student transfer: create an automated quiz, `is_file=0`,
`has_traditional=1`, and select students using
`/SMARMANger/dashboard/teacher/add_quize_student`. Results are NULL/unattempted and
unpublished. Removing an unattempted selected student now redirects with a retained-
results error instead of succeeding. An authorized Admin deleting the otherwise
unused quiz at `/SMT/admin/class/room/exam_quize/delete` receives **422** too.

Two new failing tests cover the actual Teacher and Admin routes. In the Admin
case the existing `hasEarnedData()` rule explicitly returns false. Existing tests
that insert placeholders directly with `DB::table` miss this activation seam.

Recommended minimal approved fix: distinguish disposable CURRENT unattempted
participation from retained attempts when attributing/cleaning records. Define a
narrow locked policy; preserve earned zeroes, submissions, historical/ambiguous
originals and other sections' quizzes. Do not broadly permit linked-row deletion.

### R3 Medium: Gradebook per-student N+1 regression

`GradebookReadService::assessment()` calls `resultState()` per result; continuity
does so again. The resolver performs link/placement/room queries, and absent-schema
checks repeatedly query metadata because false is not retained as a cached state.

One assessment, same ordinary fixtures, same results, SELECT query counts:

| Current code / foundation state | 1 student | 12 students |
|---|---:|---:|
| Schema absent | 14 (4 schema queries) | 36 (26 schema queries) |
| Active, existing unattributed results | 27 | 93 |
| Active, linked current results | 26 | 81 |

These are measured current-code baselines, not a whole-application HEAD benchmark
or production latency test. They establish linear per-result database work even
for never-transferred students. The new read loop is absent from HEAD. The targeted
query-growth acceptance check fails; numerical values/zeroes remain correct.

Recommended minimal approved fix: batch link/placement/room loading and share
request-scoped lookup/schema state across the read/continuity pass. Ensure cache
invalidation does not make a subsequent authorized write use stale placement data.
Do not change grading calculations or continuity rules.

## 4. PASS / FAIL / NOT TESTED matrix

PASS refers to the stated isolated/query scope, NOT graphical browser acceptance.

| Workflow | Result | Evidence / boundary |
|---|---|---|
| Ordinary grade entry/edit, first result, zero/null and totals | PASS | Existing Gradebook tests plus activated-schema never-transferred E2E, bulk entry and report imports. |
| Gradebook read scaling | FAIL | R3, measured query growth above. No 900-student load acceptance claim. |
| Assessment creation, windows, equivalence and independent section quizzes | PASS | Existing safety/Admin/template suites; original IDs, conflicts and earned-result guards. |
| Unused automated participation / Admin unused quiz after activation | FAIL | R2, two actual-route tests. |
| Student/Teacher result ownership, publication and privacy | PASS | Both flag states, direct result routes, original/carried results, year/section checks; activated ordinary fixtures included. |
| Report imports, unchanged original summaries and closed-visit protection | PASS | Gradebook and visit fixtures; MariaDB original mark unchanged after synthetic transfer. |
| Certificate creation/current edit/history display/freeze | PASS | New fixture creates/updates a current certificate, transfers, displays it only in original history and rejects historical mutation. |
| Full issued report/certificate artwork/PDF and every joined Admin publication branch | NOT TESTED | Needs complete issuance fixtures/browser acceptance; previous reports' MariaDB checks are not counted as rerun. |
| Follow-up eligibility/create/edit, prior-section visibility and closed-visit protection | PASS | Teacher eligibility suite plus Student/Admin follow-up views/reporting. |
| Academic Record current/past/future hiding, repeated visits and legacy bucket | PASS | Real child-view/route fixtures; old originals remain distinct. |
| Web student uploads over time, download ownership and missing-file safety | PASS | Existing transfer/history tests; unique new paths, earlier bytes, rollback, traversal/foreign-owner/future-history denial. |
| Legacy API submission writes | FAIL | R1, both routes and response/byte/row evidence. |
| Normal current-section lesson/category access | PASS | Old-section URLs denied; destination lessons restored normally on valid returns. |
| Private Teacher attachment full create/edit/delete/download lifecycle | NOT TESTED | Access code inspected and workspace/UI checks pass; full private-storage mutation runner not rerun because it executes migrations. |
| Weekly timetable / Teacher roster membership | PASS | Timetable authority and Teacher eligibility suites; before/after destination tests and multi-section/simultaneous-period timetable render regression. No live seven-Teacher comparison was rerun. |
| Active Admin Students Blade and current-section query | PASS | Real MariaDB fixture GET 200. Query-level DataTables filter moves synthetic student ID 4 from section 134 to 135: source 1 -> 0, destination -> 1, correct returned room. Not a browser interaction. |
| Simplified transfer, explicit exception, returns and rollback | PASS | Existing UX/visit tests; separate synthetic MariaDB persisted transfer, unchanged account/original mark. |
| Enrollment/create, guarded hard delete, archive/restore | PASS | Disposable MariaDB creation/deletion/rollback/CSRF checks; new activated archive/restore service fixture preserves owned records. |
| Gradebook/Admin follow-up dashboards and filters | PASS | Admin V2/template/reporting suites and current-section query. |
| All other Admin summary charts/reports | NOT TESTED | Impact inspected; exhaustive report output/general dashboard totals still require acceptance. |
| Student/Admin/Teacher login and role boundaries | PASS | SchoolLoginNavigation fixtures; no real account reset or login claimed. |
| Finance/history isolation and Admin finance page rendering | PASS | SQLite history invariant and MariaDB GET financial/invoice-detail pages return 200 before/after query checks; invoice/transport/fee/image hashes unchanged. |
| Full finance monetary presentation, payments and Student finance UI | NOT TESTED | No payment operations or exhaustive amount recalculation performed. |
| Mobile read contracts | NOT TESTED | Route/serialization review found no route/key edits, and existing privacy checks pass; not an exhaustive mobile-client contract test. Cannot claim whole API compatibility due R1. |
| Simultaneous InnoDB grade/transfer lock races | NOT TESTED | Prior concurrency results reviewed, not rerun in this migration-free audit. |
| Authenticated graphical desktop/mobile Admin/Teacher/Student interaction | NOT TESTED | Browser tooling fails initialization with a kernel-assets path error. No screenshots or graphical acceptance claimed. |

## 5. Test results and environment

Final PHPUnit runs: **251 tests / 5,870 assertions; 247 passed, 4 failed**.
Four failures represent R1, R2 (two routes) and R3, not four independent root causes.
All **136 pre-existing GradebookSafety tests** pass; the final suite adds ten
activation-aware audit tests, six passing and four exposing the regressions.

| Suite | Tests | Assertions | Result |
|---|---:|---:|---|
| GradebookSafety, including new audit checks | 146 | 3,301 | 4 failures above |
| GradebookAdminV2 | 15 | 1,089 | PASS |
| GradebookTemplates | 18 | 206 | PASS |
| TimetableAuthority | 17 | 205 | PASS |
| SchoolLoginNavigation | 8 | 133 | PASS |
| TeacherStudentFollowUpEligibility | 17 | 314 | PASS |
| LessonWorkspaceView | 9 | 315 | PASS |
| StudentFollowUpView | 2 | 29 | PASS |
| AdminStudentFollowUpObservationView | 3 | 104 | PASS |
| AdminStudentFollowUpReporting | 3 | 19 | PASS |
| LessonAttachmentProposal | 3 | 17 | PASS |
| GradebookContextReader | 8 | 97 | PASS |
| AdminTeacherTimetableView | 2 | 41 | PASS |

Additional verification:

- **17 Node frontend scripts passed**: Gradebook configuration/windows/status/save,
  continuity, legacy entry, uploads/workspace/responsiveness, delete and transfer UX.
- Existing guarded MariaDB student-workflow runner: **58 assertions passed** on
  `10.4.32-MariaDB`, database `aladham_student_workflow_test_88062d0a4d0e37eb`.
  It copies schema definitions only, never school rows, and runs no migrations.
  Additional probes used the same synthetic database/storage, verified persisted
  transfers and DataTables membership, and rendered Admin Students/financial/
  invoice-detail pages with HTTP 200. These extra probes are not included in 58.
- PHP source lint passed for the 59 starting changed PHP/Blade files and the new
  test trait. All 62 starting changed PHP/Blade/JS sources decode as UTF-8 without
  BOM; no newly added application-diff mojibake lines were detected.
- Blade cache rebuilt ONLY in temporary compiled-view storage. **786** compiled
  views linted: **783 pass**, **3 pre-existing failures** listed below.
- `git diff --check` passed. No new application fix or change to `.env`,
  `.env.example`, framework caches or PHPUnit result cache.

PHPUnit uses SQLite `:memory:`, fixture accounts and a unique
`aladham-gradebook-2a-*` temporary storage root. Existing fixture helpers construct
their in-memory schema, including visit tables. No Artisan migration command was
executed and no schema migration was applied to an existing/local school database.
The disposable MariaDB schema was created with guarded DDL, not migration execution.

Read-only before/after row counts AND SHA-256 row fingerprints match for **19 school
tables**, including students/users, enrollments/placements/transfer/reconciliation/
visit history, marks/reports/results, submissions, follow-ups, certificates and all
four finance tables. The school year remains unchanged. No school upload was moved,
deleted or replaced; all write tests used temporary fixture storage/databases.

## 6. Pre-existing defects and remaining risks

- The three compiled failures are unchanged from HEAD and already recorded in the
  previous report: `students/new_start_exam3.blade.php` has empty conditional
  expressions; `coordinators/load_en.blade.php` and `acadsupervisors/load_en.blade.php`
  have malformed condition directives. No active caller to the first was found;
  Coordinator/Academic Supervisor callers exist for the latter English templates.
  They were not repaired. A blanket globally-clean Blade claim would be false.
- Legacy mobile endpoints still have no reliable authenticated student identity
  contract. Operational-student middleware is not authentication. This is an
  existing separate privacy/security exposure; do not infer it is fixed by Web
  ownership/privacy tests or change it silently during an upload correction.
- The existing private Teacher attachment download policy permits certain original
  historical placements. Normal lesson discovery is current-section-only. That
  separate download fallback was neither broadened nor removed and needs explicit
  policy approval if tightening is desired.
- Raw legacy SQL writes bypass model events; unassigned/inconsistent historical
  context must remain protected rather than arbitrarily attributed. The audit is
  not an authorization proof for every legacy API writer or a historical backfill.
- Missing legacy bytes are not recreated. Missing-file denial is fixture-tested;
  a full physical inventory of real uploads was not performed here.
- Follow-up per-row edit eligibility also performs a placement lookup when visits
  are enabled. Its large-roster query cost was inspected but not benchmarked; do
  not treat the measured Gradebook baseline as a whole-system performance signoff.
- The adjacent media-capacity changes still need Hostinger/PHP/request-limit and
  private-filesystem acceptance. No server settings or hosting state were changed.

## 7. Manual browser acceptance checklist

Use dedicated authorized test identities/data in an approved QA environment, not
real students. Replace braces with that test context. Check desktop and 320/390px
RTL views, browser console/network and refresh persistence throughout.

| Exact page/route | Required actions |
|---|---|
| `/ar/adh-login` | Log in as Student, Teacher and Admin separately; check correct homes, logout, session recovery and cross-role denial. |
| `/SMT/admin/students` and `/SMT/admin/students/student_details/{student_id}` | Search/filter source section; confirm row actions/Bulk Transfer; open the normal transfer, exact notice and single confirm; verify destination options/current year, success and persisted new membership. Recheck an unselected neighbor. |
| Same details page after an uncertain transfer | Confirm no change on refusal; separate explicit review only; verify stale review is rejected and approval is audited. Do not guess an earlier date. |
| `/SMARMANger/dashboard/teacher/gradebook/{class_id}/{room_id}/{subject_id}` | With never-transferred and transferred fixtures, save zero, edit a value, compare totals/current rows and carried read-only originals; verify locked/expired actions remain denied. |
| `/SMT/admin/class/room/quizes/{room_id}` and `/SMT/admin/class/room/exams/{room_id}` | Create separate/shared occurrences; validate per-section edits and protected earned results. After approved R2 repair, remove truly unattempted participation and an unused quiz without touching peers or zeroes. |
| `/SMARMANger/dashboard/student/room/main_quizes/{room_id}/{student_id}`, matching `main_exams` route, `/SMARMANger/dashboard/student/view/main_exam/{exam_id}` | Verify current section, individual publication and both privacy states; no hidden grade in HTML/JSON/links/downloads. Confirm automated actions remain usable. |
| `/SMARMANger/dashboard/teacher/student-follow-ups` and `/assignments/{assignment}` beneath it | Add/edit a level-only and note-only observation; verify edit deadline, assignment/student isolation, history and closed-visit denial. |
| `/SMARMANger/dashboard/student/follow-ups` | Old- and new-section observations remain visible with original context; another student's data remains inaccessible. |
| `/SMARMANger/dashboard/student/academic-record` and `/{placement_id}` | One main card/year, current first, no future year; open original visits and legacy bucket; verify original marks, report/certificate metadata and submission ownership/downloads. |
| `/SMARMANger/dashboard/student/lesson/lecture/content/{lesson_id}/{student_id}/{lecture_id}` | Current-section content and Files default tab; old-section normal URLs denied; long filenames, multiple attachments, missing files and authorized downloads. Review the separate legacy private-download policy deliberately. |
| `/SMARMANger/dashboard/teacher/teacher_schedule`, `/SMT/admin/teacher_schedule/{teacher_id}`, `/SMT/admin/classroom/workschedule/{room_id}` and `workschedule_exam/{room_id}` | Match all real scheduled day/time/section/subject periods; confirm student's timetable switches section. Student route: `/SMARMANger/dashboard/students/room/view_schedule/{room_id}/{student_id}/{time_zone_offset}`. |
| `/SMT/admin/students/lifecycle-archive` | Approved test archive/restore; identity/history retained, archived login denied, restored current enrollment/scaffolds correct, retained-data hard delete still denied. |
| `/SMARMANger/dashboard/student/view/report/card` and a certificate link from the Student UI | Verify issued/unissued states, selected context, layout/PDF/artwork and historical values. |
| `/SMT/admin/students/financial`, `/SMT/admin/students/invoices_details/{student_id}`, `/SMARMANger/dashboard/student/financial_account/{student_id}` | Compare old invoices/payments and displayed balances with unchanged fixture records before/after transfer/year context. Do not post payments for this audit. |
| Both `/api/dashboard/student/upload_exam_files*` routes in an isolated client | After approved R1 correction, verify legacy success fields, real term context, no orphan on rejected upload, repeat uploads and preserved originals. |

## 8. Files changed by this audit and release decision

Only:

- `tests/Concerns/PostTransferRegressionChecks.php` (new targeted tests).
- `tests/Feature/GradebookSafetyTest.php` (one trait inclusion; existing changes retained).
- This report.

All starting application-file hashes remain unchanged. Temporary logs, SQL-count
evidence and fixture response summaries reside under the unique audit temp root;
no credentials or real student records are included in this report. The disposable
database was deliberately retained for inspection, not dropped or reused as school
data. No commit, push or deployment.

**Release blockers:** approve and address R1/R2/R3, rerun the four red tests and
relevant suites, then complete the outstanding browser, issuance/private-download
and concurrency acceptance. Do not deploy this mixed working tree as a blanket
package merely because the transfer tests pass. Production schema/backup/hosting
review remains a separate approved release step.

**Approval requested:** a focused follow-up fixing mobile upload context/cleanup,
unused-current-placeholder handling and Gradebook query batching, with no weakening
of original-history, earned-zero, ownership, publication or authorization guards.
