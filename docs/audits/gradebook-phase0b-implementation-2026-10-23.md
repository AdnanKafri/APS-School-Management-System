# Gradebook Phase 0B: functional acceptance and UI preparation

Date: 2026-10-23. Laravel 7.30.6 / PHP 7.4. Local work only. Phase 0A's uncommitted implementation is the baseline, not HEAD. No commit, push, deployment, migration, year activation or school-data reconciliation was performed.

## 1. Implemented corrections

1. **Admin assessment creation context and atomicity.** The real exam/quiz creation methods trusted submitted class/room/lesson IDs. An isolated wrong-class request previously returned a success redirect and inserted an unusable definition. Both creation methods now validate a nonempty/distinct section array, existing class/lesson, positive numeric maximum, lesson-to-class and every resolved section-to-class/active-year relationship before inserting. Multi-section creation is transactional; failure on a later section rolls back earlier inserts. The existing all-sections expansion and role filtering remain; an empty resolved set cannot report successful creation. Dates, type, required-lecture settings and scheduling behavior are unchanged.
2. **Configuration round-trip safety.** The editor submits names/weights/source identities, not explicit maxima. Its controller previously discarded stored `max_mark` and silently switched the limit back to weight-derived maximum. Stored explicit maxima now survive unchanged; a browser cannot replace them through this editor. The regression demonstrates 12 staying 12 instead of changing to 20, and a subsequent mark of 13 is rejected.
3. **Configuration error recovery.** Validation failures previously returned the saved configuration without showing errors, losing attempted rows. The editor now displays an alert summary, retains old input, normalizes row indexes for subsequent additions and places hidden fields inside valid table cells. Existing name length is mirrored in HTML. No new weight-total policy was imposed.
4. **Configuration overview truthfulness.** The settings subject page read an unprovided database config collection, so every subject appeared default. It now reports the actual saved lesson/year file. Teacher labels use exact `teacher_room_lesson` class/room/year assignments, not the legacy assessment-author relation. Class section counts use active-year sections. Old-year rooms cannot lead into active-year configuration editing.
5. **Missing-year handling.** Gradebook class/section selectors and settings screens no longer dereference a missing active year or redirect back unpredictably. They return to the Gradebook landing with a localized warning. No academic year is invented or activated.
6. **Lock switch correctness.** Cancellation and failed AJAX used to leave the switch in its optimistic state. It now restores the accepted state, disables while pending, shows a localized error/pending message and reloads only after the server confirms the requested state. Authorization and active-year/current-term rules are unchanged.
7. **Student Gradebook context and totals.** The controller resolved a current room but did not pass it to the card, whose header used a separate legacy class relation. The card now receives the resolved room/year and displays its class/section/year. Configured additional components are listed alongside the fixed legacy component columns so a total is not larger than the visible components without explanation.
8. **Student Academic Record correctness.** Falsy fallback converted earned `0` to "not recorded" in both result systems; term/year zero summaries were also rendered as a dash. Null-coalescing now preserves zero. Stored `mark2` component values and subjects existing only in `mark2` are included and explicitly labeled Term 2; previously only `mark` components were listed. Both terms retain selected placement context. No report/result is recalculated or rewritten.

No Teacher Gradebook cosmetic redesign was necessary for these fixes. Its Phase 0A server-confirmed totals, retry, pending state, numeric inputs, read-only legacy columns and unsaved warning remain intact.

## 2. Exact Phase 0B changed files

This list is incremental to Phase 0A; it deliberately excludes unchanged Phase 0A services/routes/models.

- `app/Http/Controllers/Admin/GradebookController.php`
- `app/Http/Controllers/Admin/GradebookSettingsController.php`
- `app/Http/Controllers/DashboardController.php`
- `app/Http/Controllers/studentscontroller.php`
- `resources/lang/ar/gradebook.php`
- `resources/lang/en/gradebook.php`
- `resources/views/admin/gradebook/index.blade.php`
- `resources/views/admin/gradebook/settings/edit_json.blade.php`
- `resources/views/admin/gradebook/settings/subjects.blade.php`
- `resources/views/admin/gradebook/view_subjects.blade.php`
- `resources/views/admin/gradebook/view_by_student.blade.php`
- `resources/views/students/academic_record_show.blade.php`
- `tests/Feature/GradebookSafetyTest.php`
- `tests/Frontend/gradebook-status.test.js`
- `docs/audits/gradebook-phase0b-implementation-2026-10-23.md`
- `docs/audits/gradebook-admin-ui-redesign-plan-2026-10-23.md`

Unrelated files and `.env.example` were preserved. No package or schema change.

## 3. Acceptance evidence

### Isolated automated writes

All write tests use asserted SQLite `:memory:`, fake local storage and disposable in-memory identities/assignments. No school mark was entered for testing. SQLite is enabled through a temporary test-process INI directory, not a project/system configuration change. Existing tests were not weakened.

Final combined command:

```powershell
$env:PHP_INI_SCAN_DIR = Join-Path $env:TEMP 'aladham-gradebook-php-test-ini'
C:\php74\php.exe vendor/phpunit/phpunit/phpunit --filter 'GradebookSafetyTest|TeacherStudentFollowUpEligibilityTest' --process-isolation --do-not-cache-result
node tests/Frontend/gradebook-save.test.js
node tests/Frontend/gradebook-status.test.js
```

**49 tests / 748 assertions passed:** 36 Gradebook tests and 13 existing membership/transfer/follow-up regressions. The ten `phase0b` tests include 171 assertions; the existing route guard test additionally now asserts exactly 17 Admin routes and their `can:student_marks` middleware.

| Workflow | Verification |
| --- | --- |
| Admin creates exam and quiz | Actual POST routes/controllers, stored type/context/current-year term/max/date; then actual assigned Teacher list GETs contain each title. Future scheduled assessments remain visible without inventing a new mark-entry timing rule. |
| Individual then bulk marks | Actual Teacher POSTs persist zero and maximum, update the same result rather than duplicate it, and store both students. Both Advanced Gradebooks return the same assessment identities and values. |
| Reporting compatibility | Original report-import POSTs update the existing JSON scaffold without changing raw results. Assessment mark 100 is valid for a 100-max definition but rejected by existing report caps (exam 40, quiz 20). A legitimate correction within those caps imports correctly. No hidden rescaling. |
| Both terms, missing/zero, calculations | Existing tests cover nullable inherited term, explicit conflicting term, numeric max versus text max, quiz/oral averages, second-term import with first-term preservation, duplicate result/container rejection and blank-versus-zero. New Academic Record test renders zero summaries and a subject present only in `mark2`. |
| Creation failure | Wrong class, wrong curriculum, old-year section, empty/duplicate sections and invalid maxima rejected before any insert. An injected second-section insert failure leaves zero definitions for either exam or quiz. |
| Config and status | Stored maximum preserved, used component/source protected, validation input retained, saved status/assignment labels accurate. JS harness exercises lock cancel/failure/retry/persisted success. |
| Teacher replacement | Former Teacher GET/write denied after assignment replacement; replacement Teacher reads the same original result. Reading does not reauthor it. |
| Transfers and rollover | Existing isolated suite executes safe same-grade/cross-grade/bulk transfer, year preparation, rollback, history retention and active-membership denial. No old result is copied to the receiving section. |
| All active Admin screens | All 14 GETs render the actual child views in isolated fixtures and do not create result/summary rows. All 17 routes retain Admin authorization; non-Admin types including Student, Teacher and Officer are denied. |

The initial failing tests reproduced discarded explicit maxima, lost old input, missing-year 500, zero-as-missing and invalid Admin context acceptance. These are evidence of corrected behavior, not merely post-change lint.

### Read-only real-local runtime

The actual local database was inspected inside `START TRANSACTION READ ONLY`. Existing users were bound to the guard in memory for controller rendering; this is **not browser login testing**.

Twenty full shared-layout renders succeeded:

- All 14 Admin Gradebook GET views (full inventory in the companion UI plan).
- `/SMT/admin/classroom/exams/1`: parameter `1` is a class ID.
- `/SMARMANger/teacher_marks_subjects/132/166`: section/Teacher navigation context.
- `/SMARMANger/dashboard/teacher/teacher_exam/132/166/409` and `teacher_quize/...`: room, Teacher, lesson.
- `/SMARMANger/dashboard/teacher/gradebook/2/132/409`: class, room, lesson, **not Teacher ID**.
- Student 340's real year-5 Academic Record placement detail, with the complete Student shell.

The supplied Teacher is account type `'1'`, Teacher 166, current year 6 / term 20, class 2 / room 132 / lesson 409. Its current roster has **22 students and zero assessment definitions**. No fake current-year school assessments were created to manufacture a demonstration.

### Syntax, frontend and integrity

- Seven changed non-Blade PHP files lint successfully with `C:\php74\php.exe`.
- `artisan view:clear` and `artisan view:cache` succeed.
- All **24** Gradebook/admin-settings/shared-assessment/Teacher-Gradebook/Student-detail templates compile and their generated PHP passes lint (includes inactive Gradebook templates).
- Both Node frontend harnesses pass. They test event/AJAX behavior, not layout, touch, keyboard focus or browser plugin integration.
- Fourteen changed source/test files are valid UTF-8 without BOM. New Arabic strings are readable. Existing unrelated mojibake in large legacy controllers was not broadly cleaned.
- `git diff --check` passes; route inspection confirms the 17 Admin routes and two Advanced Teacher routes.
- **18/18 full-row school-table before/after fingerprints match**, including identities, enrollments, placements, transfers, assignments, definitions, both raw result tables, marks, report cards/details, files/submissions and invoices. No school academic/financial data was changed.

Local verification artifacts: `%TEMP%/aladham-gradebook-phase0b-before.json`, `-after.json`, `-reconciliation.json`, `-runtime.json`. These contain checksums/counts or render metadata, not credentials. No production connection was used.

## 4. Calculation and publication boundaries

Original `exam_result2` / `exam_result` rows remain authoritative. Their `user_id` is the permanent **student ID**, not the linked login account ID. Definition table plus ID distinguishes the two assessment systems.

Shared-reader summaries remain confirmed lesson-assessment average, quiz average and numeric exam maximum; dynamic components remain separate. Each original assessment is visible with its stored context. Null and blank do not become earned zero. No averaging across sections, grade scaling, artificial attempts or result-copy table was added.

Important unresolved existing behavior, not silently changed:

- Legacy report imports use fixed 40/20 caps; raw assessment maxima can differ. Decide an approved normalization/selection rule before automating any bridge.
- Dynamic Gradebook saves do not publish into Student legacy transcript totals. Aggregation writes component JSON, not a full publication/recalculation pipeline. No active Gradebook Blade caller currently exposes the aggregate endpoint.
- Admin summaries choose one representative term per type; raw matrices retain all terms. Year 5 has multiple term definitions per type. Merging them requires an explicit policy.
- Final Admin tabs still have legacy simple sum/50-threshold labels. They are not validated promotion decisions. Template/UI work must distinguish previews from authoritative finalized results; changing the threshold is not authorized here.
- Percentage labels/configured maxima do not establish new weighting of legacy raw averages. Mixed maxima and incomplete terms require school decisions.
- Existing file configurations are mutable and can silently fall back to defaults if unreadable. File revision/concurrent-edit protection, immutable versions and historical maximum snapshots remain Template System work.

## 5. Transfer/history readiness and concrete read-only design

**No carry-forward or new historical Teacher endpoint was added.** Preserving original results, granting read access and including a result in a new total are separate decisions.

| Scenario | Current safe behavior / unresolved boundary |
| --- | --- |
| Same-grade A to B | Current roster and entry use B; original A results survive and remain queryable by their original placement/room/year. B's summaries must not include A implicitly. Current Teacher UI does not yet provide a prior-section panel. |
| A to B to A in one year | Transfer service explicitly blocks re-entering a target context with an existing placement/marks/report. Legacy results lack placement-period identity, so a second stay cannot be distinguished safely. Do not remove this guard. |
| Teacher replacement | Assignment gates switch access; existing results stay intact. Modern result rows do not reliably store grader authorship; definition `user_id` may be the Admin creator, not the grader. Never infer or rewrite historical authorship from today's assignment. |
| Cross-grade | Old curriculum remains historical; matching subject names do not establish equivalence. Default carry-forward off. |
| New year | Old-room/year data remains historical; current operations use the active year. Do not attach old results to newly prepared enrollments. |
| Different assessments/configuration | Same source bucket/name/weight does not mean same assessment. Separate original IDs; no double counting or automatic normalization. |

The smallest next historical-read implementation should:

1. Add a **read-only** endpoint keyed by current room/subject plus one student and selected prior placement. Require exact current Teacher assignment and the student's current operational membership on every request, not only on the link.
2. Require selected placement ownership, closed status, same academic year/class, valid historical room/class/year and same stable lesson ID. Cross-grade, different-year and ambiguous repeated-room periods stay denied or separately Admin-reviewed. Never accept an arbitrary submitted student list.
3. Use the shared reader on only that student's old room/subject/term set. Do not use the old room's whole roster. Keep original assessment/result keys, dates, maximum, source room and term. Preserve unknown authorship rather than calling the current Teacher the old grader.
4. Return a labeled prior-context panel with no writable controls or save URLs. No historical value is included in current totals. Assignment replacement immediately changes authorization on the next request.
5. Add negative tests for unrelated students/subjects/Teachers, future/old-year/cross-grade placements, conflicting periods and revoked assignments. Mutation paths must still reject old context.

Why defer even this apparently small panel: 126 local current placement discrepancies and legacy absence of period/result provenance make blindly widening reads unsafe. Resolve responsibility/visibility policy and design the panel with Template/UI work rather than presenting inferred equivalents. Reliable A-to-B-to-A support eventually needs explicit result-to-placement/attempt attribution; timestamps alone are not sufficient proof for old data.

School decisions needed: who may see prior-teacher work; same-subject equivalence; assessment/attempt identity; average/best/latest rules; maxima normalization; missing/exempt handling; rounding; publication/finalization and audited correction rules. Follow-up qualitative ratings are not numerical grades.

## 6. Revalidated reconciliation plan (no repair performed)

Active year remains **6 / 2026/2027**, current term **20**. Year 5 retains 656 enrollments; year 6 has 967. Placement counts: year 5 has 656 closed; year 6 has 977 active, 408 closed and 255 withdrawn. There are no duplicate active student/year placements. Repeated student/year/room group 1436/6/164 remains a prior recorded context; it was not deleted or merged.

| Category and verified count | Cause / impact | Approval and safe proposed repair |
| --- | --- | --- |
| 42 `exam_result2` rows lack both student and assessment | Proven missing references; historical cause cannot be reconstructed from these rows alone. They cannot be reliably attributed or displayed by valid assessment readers. Not current-year results. | Require school/data-owner approval and comparison with original backups. Restore original identities/definitions only from verified source evidence, never guess by name. Otherwise retain unresolved records separately in review scope without assigning marks to somebody else. |
| 19 numeric results above the current definition maximum | Proven bounds mismatch; could be old definition changes or original data entry. No audit proves which. Shared reads preserve raw values; correcting/scaling them would change meaning. | Compare original marked papers/assessment definitions and approved historical maxima. Approve each correction with before/after audit; do not clip or bulk normalize. |
| 126 enrollment/active-placement room mismatches, all same-grade | Different operational projection and placement room. Existing resolver permits a constrained later-enrollment exception; this explains roster visibility but does not repair chronology. | Compare enrollment timestamps, placement intervals, transfer events and school placement register. Produce explicit proposed transitions per student and freeze concurrent moves during an approved batch. No blanket update of placement rooms. |
| 126 missing current-room `students_marks` scaffolds | Exact current enrollment room/year has no matching summary. Historical marks may exist elsewhere and must stay there. Explicit report import can be safely blocked. | After placement reconciliation, confirm a truly missing target scaffold; create only an approved empty scaffold through the existing path. Never copy old earned values. Dry run checks uniqueness and all old rows. |
| 613 current enrollments without a report card | Missing report does not prove corruption; a report may not have been issued/prepared. | Establish issuance policy first. No automatic report generation merely to satisfy a count. |
| 747 reports missing student, 635 missing room (overlapping populations) | Legacy dangling references; unreachable/ambiguous historical reports, not proof current students lost results. | Match original source backups and original IDs before any repair. Do not attach orphan reports to current users based on text. |
| One duplicate report context: student 4692/year 3/room 404, two rows | Orphan context, not a valid active duplicate to merge. Contents must be compared before choosing any record. | Preserve both until verified provenance and report issuance decide whether either is redundant. Never delete by highest/lowest ID. |
| 730 null result terms; 694 parent-resolvable | Shared reader can inherit actual definition term safely; 36 belong to unresolved/orphan subset. | No physical backfill needed for safe reads. Any future normalization requires immutable parent evidence and row-level preview. |

Additional checks: 0 duplicate exam/student raw result groups; 0 conflicting non-null raw room/class/lesson/term values against surviving definitions. Results by resolved year: 27,458 year 5, 37 year 4, 42 unresolved; none in the active year.

**Required process for every approved repair category:** encrypted full DB/config/media backup plus restore rehearsal; read-only manifest with original IDs/full row hashes and explicit proposed diffs; school approval; disposable-clone dry run with row counts, FK/context checks, all affected reader/portal tests and unchanged finance hashes. Execute bounded transactional batches only if before hashes still match; record exact audit IDs and before-images. Rollback is by exact approved before-images in reverse dependency order, never broad delete/merge. Remove a newly created empty scaffold only if it is still byte-identical to the created row and has no new dependents; otherwise halt rollback for review. Do not restore a whole database over unrelated newer school activity.

## 7. Security and reliability

Phase 0A protections remain: exact Teacher assignment, current member, original assessment identity, non-destructive participation/edit/delete guards, numeric limits, locked dynamic Gradebook, explicit POST report imports, CSRF and transactional mark batches. The 17 Admin routes still require Admin role and `student_marks`; visibility is not authorization.

The replacement-teacher test verifies access revocation without changing original data. GET render tests perform no academic writes. Failed Admin creation now also rolls back all sections. No API, coordinator reset, permission model or financial behavior was redesigned. Broader legacy raw-query/API mutation paths are not certified by this web-focused suite.

SQLite tests verify logical transaction rollback, not MySQL contention. Concurrency between real MySQL writers, file-config/status updates and assignment changes remains disposable-staging QA. No concurrency experiment was run on the real school database.

## 8. Browser limitations and precise manual acceptance checklist

The UI automation inventory returned `apps: []`, `browsers: []`. There was no authenticated browser surface. Full local controller/shared-layout renders and isolated HTTP tests passed, but **visual/mobile/keyboard/browser-login acceptance is pending**. No screenshots or overflow measurements are claimed.

Use a disposable staging database with approved test Admin/Teacher/Student accounts and equivalent class 2, room 132/133, Teacher 166, lesson 409, active year/terms. Do not execute this write checklist on the real school data. Provision disposable accounts through normal authorized tooling; never reuse exported school credentials.

1. Admin: open `/SMT/admin/classroom/exams/1`, navigate to the intended class/section and create one exam and one quiz through the actual modals. Record their original IDs, type, class/room/lesson, current term, maximum and dates. Repeat a future/active/ended definition only in staging; list visibility must not be confused with new timing authorization.
2. Teacher: open `teacher_marks_subjects/132/166`, then `teacher_exam/132/166/409` and `teacher_quize/132/166/409`. Confirm titles, distinct types and no wrong-section/year records. Open the normal student mark-entry action, save zero and maximum for test students; edit one and use bulk entry for two. Confirm one original result per assessment/student and correct notifications.
3. Open Advanced Teacher `/SMARMANger/dashboard/teacher/gradebook/2/132/409` and Advanced Admin `/SMT/admin/gradebook/view/subject/grid?room_id=132&subject_id=409`. Match original assessment IDs/values/maxima/term. Blank is a dash, zero is zero. Open `/view/student/card?student_id=<test-student>`; verify class/section/year and every additional component explain totals.
4. Admin: navigate settings class to section to subject to editor. Verify exact Teachers and saved configuration state. Rename a component without changing its explicit maximum; reload and compare. Submit an invalid weight and confirm visible errors plus preserved attempted rows. Used-source/removal safeguards must remain errors.
5. Admin: at `/view/subject/subjects/132`, cancel the lock switch; it must revert with no request. Force a failed request in browser DevTools; it must revert with visible error. Retry successfully, reload and verify persisted state. Teacher dynamic save when locked is denied.
6. Teacher dynamic entry: test zero, maximum, over-maximum, invalid text, blank clearing of an earned mark, network failure and retry. Totals change only after accepted responses. Rapid repeated input must not create duplicates. Check Tab/Shift+Tab, retry focus, unsaved-leave prompt and long Arabic names; row disabling may require a dedicated keyboard improvement if it disrupts focus in the actual browser.
7. Use the explicit report-import POST action. Test existing 40/20-compatible values and an out-of-cap raw value. Confirm accepted legacy report JSON, unchanged originals, clear rejection rather than normalization, and locked-report denial. Never use GET to execute an import.
8. In staging only, repeat with Term 2 active. Check first-term data unchanged, shared raw matrix includes both terms and Student Academic Record includes both component sets/zero totals in the selected placement. Switch back only in disposable data.
9. Transfer one staging student A to B through existing safe flow. Old marks remain in A; B starts separately. Teacher A cannot write for the moved student; unrelated students cannot be accessed. Return A-to-B-to-A remains blocked. Replace a staging assignment and verify former Teacher loses current access without old-result reauthoring.
10. Non-Admin direct GET/POST to every Admin route is denied; wrong Teacher class/room/subject and wrong student writes are denied; invalid CSRF rejected; no historical mutation on reads. Keep parent/student history owner checks intact.
11. Walk every screen in the companion UI inventory at 280/320/360/375/390/430/768/1024/desktop, portrait/short landscape. Check RTL, tabs, menus, labels, error feedback, long names, contained matrix scrolling and `scrollWidth <= clientWidth` at the page level. Inspect Network/console; validate no duplicate IDs/handlers, stuck disabled controls, clipped actions or broken print output.
12. Compare before/after staging manifests: only intentional fixture definitions/results/report imports/config changes, with no accidental identity/finance/history changes. Final school production rollout still requires backup and browser acceptance sign-off.

## 9. Next implementation recommendation

Implement the **mandatory all-screen Admin Template System/UI phase** described in `gradebook-admin-ui-redesign-plan-2026-10-23.md`, not another isolated landing-page redesign. Complete school policy decisions before template calculation/publication or cross-section carry-forward. Reconciliation remains a separately approved operation.

Known deferred items include prior-room Teacher visibility, repeated-placement attribution, immutable template/config versions, historical maximum/author snapshots, duplicate-term policy and authoritative publication. Three pre-existing unrelated compiled PHP failures reported in Phase 0A (`students/new_start_exam3`, `coordinators/load_en`, `acadsupervisors/load_en`) were not changed; all 24 templates in this phase's Gradebook/Academic Record lint set pass.

**Outcome:** focused functional corrections and isolated acceptance complete; school data unchanged; complete Admin redesign plan delivered. Actual browser/mobile and MySQL concurrency acceptance remain explicit release gates, not claimed complete.
