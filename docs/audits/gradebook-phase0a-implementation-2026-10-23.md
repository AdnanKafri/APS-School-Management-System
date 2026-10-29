# Gradebook Phase 0A implementation and verification

Date: 2026-10-23. Laravel 7 / PHP 7.4. No deployment, commit, migration, seeding, or school-data repair.

## Implemented behavior

- All Advanced Admin Gradebook routes, including settings, aggregation and status POST, require `auth`, `roleadmin` and the existing `student_marks` capability. The existing Admin Gate override is unchanged. Authentication alone no longer grants access.
- The original `exams2` / `exam_result2` records remain authoritative for Admin-created exams (type 1) and quizzes (type 2). `exam_result2.user_id` means `students.id`, not an account ID. The separate lesson assessment system remains `lesson_teacher_room_term_exam` / `exam_result`.
- `GradebookReadService` reads exact room/class/lesson/year/term context. Both Advanced Gradebooks use it. Original assessment IDs, names, types, maxima, start/end dates and individual results are available without copying results or running aggregation. Admin raw results include every available term/occurrence in the selected room/year; Teacher reads the current term.
- Summary semantics follow the pre-existing Admin rule: confirmed lesson-result average, quiz average, exam numeric maximum. Dynamic sources are separate. No new weighting or report-card formula was introduced. The old `legacy_homework` key remains compatible, but its default label now identifies its actual quiz source.
- Zero is a valid result; blank/null is missing. Invalid numeric strings and conflicting non-null contexts are flagged and excluded, not rewritten. A nullable result term resolves from its parent assessment. Duplicate results and dynamic containers are flagged rather than arbitrarily picked/averaged. Historical above-maximum results are not clipped.
- Existing dynamic container naming is retained, scoped to class/room/lesson/term/type. New containers use the configured component maximum, not a hardcoded 100. Validated writes lock the student, section/container and result inside a transaction; exact current membership and assignment are required. Repeated saves update one row. Empty input cannot erase an earned mark. The existing dynamic class/term lock remains enforced.
- Teacher individual and bulk modern exam/quiz entry uses one context-checked service. Bulk failure rolls back the batch. Participation changes retain earned/current/historical results and create only missing participants; new-participant notifications are retained. Removal of marked/attempted/submitted participants is rejected.
- Definition/result model guards prevent deleting results or changing their academic identity through the affected Eloquent paths. Active legacy cascading student/class/section/subject deletion paths now preflight academic dependencies before removing assignments or summaries. Legacy file submissions are checked by both `exam_id` and `file_id`. Coordinator destructive rebuild branches are blocked when records exist instead of inventing a reset policy.
- Legacy Teacher assessment editing no longer deletes/recreates results or rewrites their class/room/lesson context. Admin exam/quiz edits retain the assessment's stored term instead of assigning the global term. Definition edit/delete transactions coordinate with the modern mark writer.
- `export_exam` and `export_exam1` are POST-only, retaining their route names/paths. Their four active callers are CSRF forms with confirmation and an accurate "transfer marks to report card" label. Preflight checks exact assignment, current term/student, numeric limits, unique current scaffold and report lock before the transaction calls the existing formulas. GET returns 405. Actual download/export routes were not changed.
- Import checks preserve the established report states: `adjustable=0` permits Term 1; `adjustable=1` permits Term 2. Null values in an existing valid scaffold remain supported. A PHP 7.4 `array_key_exists()`-on-object error in both second-term imports was fixed by associative JSON decoding. No stored reports were recalculated during verification.
- Gradebook save UI has visible pending/success/error states, retry, unsaved-change warning, min/max validation and decimal keyboard hints. Only accepted server totals replace the displayed total; failures do not show success. Legacy marks are read-only. Names are escaped. No full redesign.
- MySQL ENUM status bindings use the string label `'1'`, not numeric ordinal `1`.

## Dependency map and scheduling compatibility

| Entry | Handler / source | Behavior retained or protected |
| --- | --- | --- |
| Admin `class/room/exam/store`, `quize/store` | `DashboardController@exam_store/quize_store`, `exams2` | Original creation, dates, maxima, type and settings; term now belongs to active year |
| Teacher `teacher_marks_subjects/{room}/{teacher}` | Existing Teacher subject/assignment navigation | Unchanged entry point |
| Teacher `teacher_exam/{room}/{teacher}/{lesson}`, `teacher_quize/...` | `TeacherController_New@teacher_exam_mark/teacher_quize_mark` | Exact active assignment/current term; upcoming, active and ended assessments remain visible |
| Teacher `student_save_mark_quize`, `student_save_mark_bulk` | `TeacherAssessmentService`, original `exam_result2` | Validated/transactional persistence; no second gradebook result copy |
| Advanced Teacher `gradebook/{class}/{room}/{subject}` | `TeacherGradebookController` | Current membership/current term and shared reader |
| Advanced Admin `gradebook/view/subject/grid`, `view/student/card` | `GradebookController` | Shared reader; student card resolves actual current membership, not first historical room |
| Teacher `export_exam`, `export_exam1` | Guarded POST wrappers, original report formulas | Existing explicit report-mark operation, not a read-only file export |
| Student Academic Record placement detail | Existing `studentscontroller@academic_record_show` | Original student/room/year context and raw tables remain intact; no carry-forward added |

The familiar Teacher assessment pages show time/state and permit mark-page access for assessments in their current context. There was no uniform server-side before/during/after mark-entry window to replace. This phase does not invent one or equate the dynamic Gradebook lock with a universal assessment-opening switch.

## Verification evidence

- New isolated `GradebookSafetyTest`: **26 tests, 350 assertions passed**. Includes direct Admin route GET/POST authorization, genuine student role 0, Teacher/other roles/Officer denial, Admin creation, exam/quiz saves and immediate shared reads, upcoming/active/ended list rendering, both terms, numeric maximum, zero/missing/invalid, nullable/conflicting terms, bounds, duplicate saves, lock enforcement, exact assignment pairs, transferred-out denial, participation retention, definition/summary/file deletion guards, GET 405, CSRF denial, POST imports, failed batch/insert rollback, configuration protection and escaped rendering.
- Existing membership/transfer/follow-up regression suite: **13 tests, 210 assertions passed**. Two fixture corrections: explicitly assign the test assessment maximum (not mass-assignable in the real model), and include the newly required mark value in the unauthorized-placement request. No assertion was weakened to permit access.
- `node tests/Frontend/gradebook-save.test.js`: passes pending/repeated-change protection, POST/CSRF payload, rejected save, retry, zero, server-confirmed total and unsaved warning. This is a DOM/AJAX harness, **not browser QA**.
- All write tests use asserted SQLite `:memory:` and fake storage. SQLite was enabled only for test processes through a temporary `PHP_INI_SCAN_DIR`; no project/system PHP configuration was edited. Tests run in separate processes because legacy routes define a global constant.
- Read-only MySQL runtime: the real Teacher 166 account renders class 2 / room 132 / lesson 409, year 6 / term 20, roster 22. Current context has zero assessment definitions; no real marks were added to manufacture a demonstration. Teacher and Admin full shared layouts render successfully.
- Historical shared-reader sample: year 4, five definitions, four resolved student results, zero context warnings. A real Student account's year-5 Academic Record controller returns 44 raw results, and its full shared-layout detail renders. These checks set the existing account in memory and use `START TRANSACTION READ ONLY`; they are not browser login tests.
- All **18** before/after full-row SHA-256 fingerprints match. Counts: students 1,212; users 1,336; years 17; terms 9; enrollments 1,623; placements 2,296; transfer events 1,064; students_marks 2,285; report_cards 1,903; report_card_details 48; exams2 2,255; exam_result2 27,537; exam_result 0; lesson definitions 1,511; exams_files 16; lesson submissions 2; invoices 3,252; assignments 913. Hash files are in the local temporary directory, not school tables.
- PHP lint: all 24 changed/new non-Blade PHP files pass. Changed source files are valid UTF-8 without BOM; no new obvious mojibake found. `git diff --check` passes.
- `artisan view:clear` / `view:cache` succeed. Lint of all 754 compiled views found three pre-existing errors in untouched sources: `students/new_start_exam3.blade.php`, `coordinators/load_en.blade.php`, `acadsupervisors/load_en.blade.php`. All affected Gradebook/assessment templates pass. Those unrelated templates were not repaired or hidden.
- No accessible browser surface was available. Real browser login, keyboard/mobile/RTL interaction and simultaneous MySQL writer contention remain manual/staging QA. The isolated fixtures and real controller/shared-layout rendering do not substitute for those checks.

## Exact files changed

### Models and guards
- `app/Concerns/PreservesAssessmentResults.php`
- `app/Concerns/PreservesEarnedResult.php`
- `app/Exams2.php`
- `app/Exam_result2.php`
- `app/Exam_result.php`
- `app/Lesson_teacher_room_term_exam.php`

### Services and controllers
- `app/Services/AssessmentResultSafety.php`
- `app/Services/TeacherAssessmentService.php`
- `app/Services/GradebookReadService.php`
- `app/Services/GradebookAggregationService.php`
- `app/Services/GradebookConfigService.php`
- `app/Http/Controllers/Admin/GradebookController.php`
- `app/Http/Controllers/Admin/GradebookSettingsController.php`
- `app/Http/Controllers/Teacher/TeacherGradebookController.php`
- `app/Http/Controllers/TeacherController_New.php`
- `app/Http/Controllers/DashboardController.php`
- `app/Http/Controllers/admincontroller.php`
- `app/Http/Controllers/coordinatorcontroller.php`

### Routes, views and localization
- `routes/gradebook.php`
- `routes/teacher.php`
- `resources/lang/ar/gradebook.php`
- `resources/lang/en/gradebook.php`
- `resources/views/gradebook/assessment_results.blade.php`
- `resources/views/teachers/gradebook/index.blade.php`
- `resources/views/admin/gradebook/view_by_subject_corrected.blade.php`
- `resources/views/admin/gradebook/view_by_student.blade.php`
- `resources/views/admin/gradebook/view_subjects.blade.php`
- `resources/views/teachers2/teacher_exam_student.blade.php`
- `resources/views/teachers2/teacher_exammark_auto.blade.php`
- `resources/views/teachers2/teacher_quize_students.blade.php`
- `resources/views/teachers2/teacher_quize_students_outo.blade.php`

### Tests and report
- `tests/Feature/GradebookSafetyTest.php`
- `tests/Feature/TeacherStudentFollowUpEligibilityTest.php`
- `tests/Fixtures/gradebook-schema.json` (schema metadata only; no school records)
- `tests/Fixtures/gradebook-layout.blade.php` (isolates unrelated layout queries in feature tests)
- `tests/Frontend/gradebook-save.test.js`
- `docs/audits/gradebook-phase0a-implementation-2026-10-23.md`

## Remaining boundaries and required decisions

1. No schema changes or reconciliation. The 42 orphan results, 19 above-current-maximum results, 126 membership discrepancies and unresolved report references remain untouched. Conflicts are blocked/flagged, not silently repaired.
2. No transferred-grade equivalence/carry-forward policy. Current operational rosters exclude transferred-out students; originals remain in their old room/placement context and Academic Record. An Advanced Gradebook cross-placement history UI is deferred.
3. No versioned configuration, new result-state taxonomy, grading formula, finalization snapshot or report redesign. Existing summary tabs select one representative term per type; the added raw matrix retains all available terms. Combining duplicate term definitions needs policy.
4. Dynamic IDs still bind to reserved names within exact academic context because no dedicated FK exists. Duplicate containers/results fail safely; no risky uniqueness migration was applied. Existing old container maxima are not rewritten. Configuration/status file concurrency and template versioning remain legacy concerns.
5. Report aggregation is explicit and separate from raw-result display. Legacy term-specific report locks are enforced; a request spanning locked report terms is rejected transactionally instead of rewriting finalized data. Legacy downstream result/estimation formula behavior beyond confirmed runtime/numeric defects is unchanged.
6. Coordinator reset/rebuild actions with existing records are intentionally blocked pending an approved correction policy. Unknown external/raw-SQL writers can bypass Eloquent guards; this is not a claim that every historical API/controller is fully modernized. The supplied active web write/delete branches are covered. Legacy automatic exam/mobile flows require their own authenticated end-to-end QA.
7. The legacy Admin `exam_reactivate` route points at a missing `teacherscontroller` method. The unused similarly named Dashboard implementation resets results. Neither was re-enabled; a non-destructive retry/correction policy is required before restoring that action.
8. Three untouched legacy compiled-view failures listed above remain, alongside browser/MySQL concurrency QA. Do not treat passing isolated tests as blanket production certification.

Existing Admin creation, scheduling and Teacher exam/quiz entry pass the isolated workflow tests. Saved original results appear in both Advanced Gradebooks on refresh. Identified destructive paths are restricted, and historical school data is byte-for-byte unchanged. Unrelated `.env.example` and prior audit artifacts were preserved.
