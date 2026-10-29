# Phase 1 completion: cross-section grade continuity

Completion verification: 2026-10-25. Laravel 7 / PHP 7.4. This supersedes the foundation-only checkpoint in this file.

## Status

**Implemented and tested in isolation for modern exams/quizzes. Not activated on the school database or browser-accepted.**

Verified equivalent results are now consumed by the receiving Teacher's legacy exam/quiz forms, Advanced Teacher Gradebook and Advanced Admin Gradebook. The original `exam_result2` record remains authoritative. No receiving result is inserted for a carried mark. Unrelated uncommitted work and `.env.example` were preserved. No commit, push or deployment.

## Implemented behavior

### Identity and verification

- Admin multi-section exam/quiz creation collects the definitions created in that transaction and establishes a UUID identity inside the same transaction after the mapping table is activated. If the table is absent, existing creation continues without claiming continuity. Separate creations never acquire equivalence merely because names, dates, maxima or legacy `groupe` match.
- Existing independent assessments can be explicitly verified at `GET/POST /SMT/admin/gradebook/equivalence`, linked from the Gradebook main page. Existing `auth`, `roleadmin`, `can:student_marks` middleware applies. The service independently enforces Admin type 2 and the capability.
- The form selects year/subject, shows unmapped assessments with section, term, type, maximum and original ID, and requires at least two selections, written evidence and explicit confirmation. One definition cannot be remapped and one identity cannot have two members from the same section. Conflicting existing earned attempts for one student prevent mapping rather than silently resolving a winner. No update/delete mapping endpoint exists.
- Mapping snapshots validate section/year/class/lesson/term/type/maximum. All members are revalidated during resolution. Incompatible maxima are not scaled. Reserved dynamic containers are not mapped.

### Read-only continuity

`AssessmentContinuityService` resolves only an explicitly mapped assessment into the student's current operational membership for the globally active year. It checks the mapping, original result identity, original result context and recorded student placements. Historical readers retain their original room-scoped data; no global search for an arbitrary latest result is added.

- States are `current`, `carried`, `missing` and `conflict`; an absent mapping leaves normal local reads unchanged. Unmapped previous-section results appear separately in the Advanced Gradebooks and are not included in totals.
- Duplicate/competing results, changed mappings, incompatible context, invalid values or unsupported placement evidence are conflicts, not averages or arbitrary first matches. Zero remains a valid result; missing remains missing.
- The source timestamp is read from either `created_at` or the actual legacy `Created_at` attribute. The latter was confirmed in the existing schema fixture and isolated return-visit test. A known timestamp must match exactly one placement interval. If there is no timestamp and multiple possible visits to the original section, continuity is blocked as ambiguous.
- Both Advanced Gradebooks and aggregation use `GradebookReadService`. Each target assessment contributes at most one original value; multiple distinct occurrences and different terms remain separate. Existing quiz-average/exam-maximum semantics are unchanged. No report is recalculated merely by opening a page.
- Provenance badges display the original section, assessment and result identifiers. Only authorized current-roster students are projected into a receiving Teacher's view. This does not grant that Teacher access to the original section's roster or correction pages.

### Legacy Teacher forms and mutations

- All four legacy manual/automated exam/quiz templates show carried/conflicting rows without editable mark inputs or save/correction actions. Those rows are not collected by bulk save.
- The existing file-filter AJAX response renders the same escaped read-only row. Its no-file filter now includes current-roster students who have no receiving result, including carried students. Unrelated result relationships are removed from the response.
- `TeacherAssessmentService` rejects overwriting/duplicating a carried mark and rejects conflicts. Participation changes skip creating a receiving placeholder for carried/conflicting records.
- An `Exam_result2` saving guard applies continuity protection to other Eloquent entry points, including automated attempts. Mapping-aware definition guards prevent changing/deleting mapped definitions. This is not a guarantee against arbitrary direct SQL outside the application.
- The bypassing `student_save_mark3` AJAX writer now delegates to the validated transactional service. It is POST-only; its three active Teacher callers send CSRF and show validation errors. Existing notification behavior is retained. The two automated-assessment forms now target the modern writer rather than the unrelated lesson-assessment writer.
- Explicit legacy report imports can consume verified original results without moving or rewriting them. Current-roster/student locking, report locks, current-room/year scaffolds and the existing 20% quiz / 40% exam limits remain. Repeated imports replace the same derived current-report value; they do not accumulate it. Historical reports and original result rows remain unchanged.

### Return visits

The resolver is tested against a valid, non-overlapping A -> B -> A history with a timestamped original zero result: it reads that original exactly once and marks it read-only.

**Operational A -> B -> A remains blocked by `StudentTransferService`.** Its existing guard was not removed. Legacy room-scoped report/scaffold records do not distinguish repeat enrollment periods safely. Enabling return transfers requires a separate membership/report period design and migration decision. Resolver support must not be presented as operational return-transfer support.

## Migration and activation

`2026_10_23_000001_create_assessment_equivalence_members.php` is additive and was run only in disposable SQLite test databases, never against the school database.

- Unique `exam_id`; unique `(identity, room_id)`; restricted FK to the original `exams2.id`.
- `exam_id` uses signed INT to match the actual legacy schema fixture. Other context fields are snapshots; they are not cascading relationships.
- Before MySQL DDL, check that the source table is InnoDB and its ID is signed INT. An incompatible source fails before creating the mapping table. No automatic engine/type conversion is attempted.
- Empty up/down/up is tested. Populated rollback refuses to erase verified mapping history and requires an approved preservation plan. Uniqueness and restricted source deletion are tested with SQLite foreign keys enabled.
- MySQL engine/FK activation and concurrent-writer testing remain staging tasks. MySQL was unavailable during final verification, so no MySQL migration or engine-compatibility success is claimed.
- Activation needs separately approved migration execution, after inspecting actual deployment schema and migration state. Existing historical assessments are NOT automatically backfilled. Do not run migrations as part of this handover.

## Verification

### Automated

- Final focused Gradebook plus membership/transfer regression suite: **62 tests, 972 assertions passed**.
- Includes real Admin multi-section creation, actual `StudentTransferService` A -> B execution, original Teacher mark entry, receiving legacy/Advanced views, different receiving Teacher authorization, individual/bulk/AJAX save rejection, participation preservation, current-mark AJAX updates, notifications with push transport mocked, CSRF rejection, historical provenance, zero/missing/conflict, multiple occurrences/terms, stale maximum/year/class/term/lesson mappings, timestamped A -> B -> A, explicit mapping UI, migration constraints/rollback, and repeated current-report import without old-report changes.
- Original student/account attributes, source results, old mark scaffolds and old reports are compared before/after in isolated tests. Existing transfer regressions retain their broader academic/financial preservation checks.
- Final full-suite run: **165 tests, 2,355 assertions; 164 passed and one unrelated stock `Tests\Feature\ExampleTest::testBasicTest` failed** because `GET /` returns the application's locale redirect (302) while the example test expects 200. No unrelated homepage behavior or test was changed.
- Existing `gradebook-save.test.js` and `gradebook-status.test.js` pass.
- New `gradebook-continuity.test.js` passes: nine legacy filter branches, POST/CSRF/error handling, and syntax compilation of four scripts extracted from actually rendered fixture pages. These are harness checks, not browser interaction.
- 31 affected/shared Blade templates compiled and their generated PHP linted successfully. Modified/new PHP lint and `git diff --check` pass. Blade cache clear/rebuild succeeds.
- 49 changed/new PHP/Blade/JS files from the cumulative worktree passed strict UTF-8 decoding without BOM. New continuity files and localization have no obvious mojibake. Pre-existing corrupted legacy comments elsewhere were not broadly rewritten.

### School database and browser limitations

A read-only before fingerprint was captured for 18 school tables in `%TEMP%/aladham-gradebook-phase1-before.json`: students 1,212; users 1,336; years 17; terms 9; enrollments 1,623; placements 2,296; transfers 1,064; mark scaffolds 2,285; report cards 1,903; report details 48; modern assessments 2,255; modern results 27,537; legacy results 0; lesson definitions 1,511; exam files 16; lesson submissions 2; invoices 3,252; assignments 913. Each entry contains a full-row SHA-256 digest.

The later read-only runtime and after-fingerprint attempts failed with MySQL connection refused (`SQLSTATE[HY000] [2002]`). Therefore **no matched school before/after fingerprint comparison or live page-render success is claimed**. No school writes, reconciliation, activation or migration were attempted. Tests assert SQLite `:memory:` and use isolated/fake storage.

Browser discovery returned no connected apps or browsers. Authenticated visual/mobile/RTL interaction was not performed. Full shared-layout acceptance on real data remains pending; isolated feature tests render the real child views with a lightweight shell fixture.

## Files changed in this completion pass

- `app/Services/AssessmentContinuityService.php` (new)
- `app/Services/AssessmentEquivalenceService.php`
- `app/Services/GradebookReadService.php`
- `app/Services/TeacherAssessmentService.php`
- `app/Services/AssessmentResultSafety.php`
- `app/Exam_result2.php`
- `app/Http/Controllers/Admin/AssessmentEquivalenceController.php` (new)
- `app/Http/Controllers/DashboardController.php`
- `app/Http/Controllers/TeacherController_New.php`
- `database/migrations/2026_10_23_000001_create_assessment_equivalence_members.php`
- `routes/gradebook.php`
- `routes/teacher.php`
- `resources/lang/ar/gradebook.php`
- `resources/lang/en/gradebook.php`
- `resources/views/admin/gradebook/index.blade.php`
- `resources/views/admin/gradebook/equivalence.blade.php` (new)
- `resources/views/gradebook/assessment_results.blade.php`
- `resources/views/gradebook/continuity_badge.blade.php` (new)
- `resources/views/gradebook/continuity_row.blade.php` (new)
- `resources/views/teachers2/teacher_exam_student.blade.php`
- `resources/views/teachers2/teacher_exammark_auto.blade.php`
- `resources/views/teachers2/teacher_quize_students.blade.php`
- `resources/views/teachers2/teacher_quize_students_outo.blade.php`
- `tests/Feature/GradebookSafetyTest.php`
- `tests/Frontend/gradebook-continuity.test.js` (new)
- This report.

All other Phase 0A/0B working-tree modifications remain intact. The complete cumulative diff is not exclusively this completion pass.

## Manual acceptance after approved staging activation

1. On a disposable staging copy, verify source table engine/ID, migration state and backup. Apply only the approved additive migration. Do not switch school years or edit original school data for testing.
2. As Admin create an exam and quiz for A/B in the same class, year, term and lesson; confirm two UUID memberships per operation. Also test old independent assessments through Gradebook -> Verify equivalent assessments, requiring evidence and confirmation.
3. As Teacher A enter a zero quiz and a valid exam mark for a disposable enrolled student. Capture student/user IDs, original result IDs/rows, old report rows and financial fingerprints.
4. Use the normal safe transfer UI to move that student A -> B. Do not manufacture a duplicate enrollment or remove the return-transfer guard.
5. As the assigned receiving Teacher B open `teacher_exam_students/...` and `teacher_quize_students/...`, in both manual and automated variants. Confirm the current student appears, old value/provenance is visible, carried rows have no editable input, and all file-filter choices retain the read-only behavior.
6. Open Advanced Teacher Gradebook and Admin subject grid/student card for B. Confirm values and totals agree, zero is visible, missing is not zero, and each separate occurrence is present. Review unmapped history separately; it must not affect totals.
7. Try individual, bulk and AJAX forged saves against carried marks, and a source-room correction URL. Confirm localized rejection and no new receiving result. Confirm a normal non-carried mark can still be entered/updated and produces its normal notification.
8. With valid existing report limits/scaffolds, explicitly import marks twice. Confirm current report values do not accumulate and old reports/source results remain byte-for-byte unchanged. Check finalized-report rejection.
9. Verify missing mapping, maximum/context mismatch and competing earned attempts are not guessed. Check different year/term/grade/subject and another student's IDs. Compare account, academic and financial fingerprints.
10. Check keyboard, RTL, small screens, AJAX feedback and console/network in the real shared layouts. School MySQL concurrency and browser QA are release gates, not proven by SQLite tests.

## Remaining scope and mandatory roadmap

- Modern type-1 exams/type-2 quizzes have explicit continuity. Separate lesson/oral assessments and reserved dynamic Gradebook containers do not acquire invented identities; cross-grade/year carry is not enabled.
- Mapping conflict correction/removal needs an approved audited policy; the UI intentionally cannot destructively rewrite mappings or results.
- Operational return transfers, MySQL activation/concurrency and real browser QA remain separate prerequisites/limitations as explained above.
- The **complete Admin Gradebook frontend redesign, including every internal page, using the existing Admin V2 template and a versioned template system remains mandatory in the next major Template/UI phase**. Preserve `docs/audits/gradebook-admin-ui-redesign-plan-2026-10-23.md`; this feature completion does not replace that plan.
