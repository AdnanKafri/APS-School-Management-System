# Gradebook Unification, Cleanup and UX Stabilization

Date: 2026-10-31. Laravel 7.30.6 / PHP 7.4. Scope: compatible operational improvements, not a calculation/template migration.

## Result and evidence boundary

Implemented the approved manual-only collective lock, source-aware entry presentation, operational component modal, safe empty distributions, source-preserving configuration saves and asynchronous traditional mark entry. Original assessment IDs/results, calculation services, official reports and historical context remain authoritative and unchanged.

Reviewed the architecture/workflow, distribution integration, unified entry, assessment windows and UX/defaults reports dated 2026-10-31 against current source and schema. Earlier reports describe earlier checkpoints; this report supersedes their description of the Advanced occurrence lock and configuration UI, not their historical evidence.

School evidence: direct PDO SELECTs inside read-only transactions, with rollback. Mutation tests: disposable SQLite `:memory:` and private test storage only. **No connected browser** was available; the browser tool returned `No browser is available`. Rendered isolated HTTP tests and Node interaction harnesses are not authenticated live-school browser acceptance.

## 1. Owner context: exact diagnosis

`/SMARMANger/dashboard/teacher/gradebook/1/130/406` means class **1**, section **130**, subject **406**; the first URL argument is not a Teacher ID. Teacher identity comes from the authenticated account.

Fresh local evidence:

| Item | Observed value |
|---|---|
| Active year / actual current term | Year 6, 2026/2027 / term 20, فصل أول 26-27 |
| Section / subject | 130, الأول - أولى, class 1 / 406, معلوماتية, maximum 100, stored minimum 40 |
| Collective status | `1_20.json` is OPEN |
| Configured components | `406_6.json`: participation, quizzes, exam; each weight 10, sources `LEGACY_ORAL`, `LEGACY_HOMEWORK`, `LEGACY_EXAM` |
| Timetable-backed responsibility | Teacher 166, عدنان كفري; period 4122, Wednesday 13:20-14:00, for section 130/subject 406/actual term 20 |
| Current original occurrence | Quiz 2422, مذاكرة ف1, traditional, maximum 50, start 17:41:45/end 17:45:58 on 2026-10-31 |
| Current original exam | No type-1 exam definition in this exact context |

**Participation:** this configured column is a summary of confirmed legacy lesson results, not direct manual storage. Its name does not grant editability. The local `exam_result` table has no rows. OPEN status cannot turn this source into an editable oral/participation field.

**Exam:** this column is the existing aggregate of original type-1 exams, not an independent input. There is currently no original type-1 exam in this context. The existing type-2 quiz is not an exam just because another configured column is called Exam.

The configured bounds are 10 each; the original quiz maximum remains 50. The existing reader does not normalize its raw results into a 10-point allocation. That apparent mismatch is an academic calculation-policy question, not permission to rescale marks.

The timetable supports Teacher 166; no authenticated account/session was available to identify the owner's actual session. Thus authorization evidence is query-level plus isolated route tests, not a claim of live account acceptance. Quiz 2422 is writable only inside its own valid window by an authorized current Teacher/student context; it does not become writable merely because the manual switch is OPEN.

## 2. Compatibility and conflict matrix

| Type / owner | Definition and original result | Display / editability | Timing and lock | Calculation / reporting boundary |
|---|---|---|---|---|
| Admin traditional exam | `exams2` type 1 / `exam_result2`; original IDs | Existing Teacher exam screen and Advanced original occurrence | Original start/end, current year/actual term, timetable and roster, original maximum, duplicate/context/continuity guards. Independent of manual lock now. | Original result contributes to `LEGACY_EXAM` maximum only where that source is configured. Explicit report import remains separate. |
| Admin traditional quiz | `exams2` type 2 / `exam_result2` | Existing quiz screen and Advanced original occurrence | Same original protections/window; independent of manual lock | Matching quiz source average, not raw occurrence summation or new weighting. |
| Automated modern assessment | `exams2` with automated mode; selected answers, question corrections and `exam_result2` | Existing automated workflows; Advanced visible but no new direct occurrence input | Existing automated contract. Advanced direct action still rejects it. | No automated scoring/publication change. |
| Numeric manual component | Subject/year JSON component, numeric source >=100; exact `Dynamic_Section_N` type-1 section/subject/actual-term container and `exam_result2` | Configured manual column in Advanced Teacher Gradebook | Collective class/actual-term OPEN plus timetable/current membership; valid positive integer storage bound. No original quiz/exam window inferred for a manual container. | Existing numeric-source average and existing total. No second result store. |
| Legacy participation summary | `LEGACY_ORAL`; `lesson_teacher_room_term_exam` / confirmed `exam_result` | Configured read-only summary; legacy content/assessment routes stay separate | Existing lesson author/context and historical protections, not the new modern-assessment timing policy | Existing average; renamed Participation/Oral does not become manual. |
| Quiz/exam source summaries | `LEGACY_HOMEWORK` / `LEGACY_EXAM`; original modern occurrences | Read-only configured aggregates | Neither summary name nor OPEN grants arbitrary aggregate writes | Same source averaging/maximum; original occurrence table is separate and is not added twice. |
| Carried/conflicting history | Original result and explicit equivalence/placement context | Visible with provenance; carried/conflict cells remain non-editable | Existing continuity and historical guards | No copying, source remapping, new receiving result or historical recalculation. |
| Report cards / Student Academic Record | Stored report JSON and student's selected placement/year/section/original results | Existing official/historical pages | Existing authorization/read-only boundaries | No automatic report reimport; arbitrary manual components are not silently added to official report JSON. |

All-sections creation still creates section-specific original definitions/results and uses existing explicit equivalence support. Same title/group/subject does not authorize guessing that unrelated assessments are equivalent. No school definitions or mappings were created here.

## 3. Implemented slices

### A. Source-aware entry and bounds

`GradebookComponentEntry` centralizes the manual-source/representable-maximum check used by the Teacher view and manual writer. Human labels identify independent manual components versus read-only source summaries. Unknown/noncanonical numeric source spellings do not gain editable-looking controls; no source value is rewritten.

Manual entry requires a positive whole-number maximum within the existing signed integer storage range. Previously a fractional calculated bound could appear editable even though creating its integer `exams2.mark` container would truncate it. Such contexts now fail closed with an explanation rather than silently approximating. Existing fractional results are not rounded, deleted or rewritten. Original assessment entry continues using its original maximum, not a manual component's bound.

Teacher header explicitly labels OPEN/CLOSED as **manual component entry**, not universal assessment availability. Renaming a summary remains a rename only; Admin can instead add a genuine manual component. An independent manual component called Exam would be a separate contribution, not the original exam result; the editor warns against entering the same marks twice.

### B. Collective status and original occurrence independence

Settings `/SMT/admin/gradebook/settings` retains one control per class for the actual current term in the active year. The subject-review control also remains available. Native accessible switch buttons now have a visible label, 44px target, `aria-checked`, busy/disabled feedback, deliberate confirmation, error rollback and server-confirmed state without reloading the page. A failed/cancelled button can be retried; it is not accidentally converted into a checkbox state machine.

Existing `POST /gradebook/status`, CSRF, `auth`, `roleadmin`, `can:student_marks`, `GradebookStatusService` and `gradebook_status/{class}_{actualTerm}.json` are reused. No new status store or per-subject/component override exists. Missing status remains LOCKED; invalid other-year requests remain denied. The existing endpoint can select actual terms within the active year; normal UI targets its current actual term.

Removed only the collective status check from Advanced **original occurrence** rendering/save. `AssessmentEntryWindow`, exact original ID/type/mode/creator/context, maximum, current timetable, current student membership, transaction/result locks, duplicate rejection and historical/carried/conflict guards remain. A LOCKED manual Gradebook no longer blocks a valid in-window original traditional assessment. Expired or automated occurrences do not become writable.

### C. Operational component modal and persistence safety

The existing subject/year editor now offers Add/Edit modal, source-type explanation, percent or exact whole-mark entry, allocation/remaining feedback, accessible up/down ordering and unused-row removal. The modal is scoped, RTL/localized, viewport-constrained with a scrolling body, moved outside transformed ancestors using the existing Bootstrap plugin. Applying changes stages them in the distribution; the main Save remains explicit. Cancel does not apply modal edits. Focus returns to the launcher. Read-only row fields retain a normal HTML POST fallback; enhanced editing uses the modal.

Intentional empty configuration is supported end-to-end: remove unused rows, submit the explicit empty marker, save `components: []`. Original assessments remain separately visible. Missing-file legacy zero placeholders remain for backward compatibility; they are not seeded as mandatory editable defaults. Admin's explicit saved subject/year structure is what subsequent readers use. No universal new participation/homework/exam defaults, global-default inheritance or template application was introduced.

Server protections, not browser attributes, govern every save:

- Integer percentage 0..100, name length, unique IDs, scalar source validation, bounded component count and ordered array payload.
- Read-only impact evidence across all sections/actual terms of the subject/year. Any original result row, file/submission or equivalence membership protects its used source. Retained legacy summaries now receive the same removal/weight protection as retained numeric containers. Rename/reorder remain allowed.
- New components receive new numeric manual sources. Clients cannot forge an arbitrary numeric binding. Existing IDs, source types/mappings and explicit maxima are preserved, including the nonstandard reserved-ID/numeric-source pairing previously at risk of automatic remapping. String ID `0` is not treated as a missing ID.
- No used component's weight/source/removal is approved merely by clicking an impact confirmation. The backend still rejects it; no mark migration or forced override was added.
- Main Save warns before structural changes. Current UI pins year and raw-file revision; stale forms are rejected. Failed validation retains the submitted revision rather than blessing old edits with a fresh token. Older callers without these optional new fields keep their legacy request contract.
- Admin obtains the subject lock before snapshot reads; manual and shared original Teacher writers use the same subject lock against configuration changes. Existing transaction retries remain. This is not a replacement for immutable academic configuration versions.
- Malformed/unreadable configurations and duplicate stored IDs fail closed instead of being silently repaired. Known valid nonstandard mappings can round-trip unchanged. Subject maximum changes during exact-mark entry remain rejected.

Percentage/absolute boundary is unchanged: 50 marks at maximum 200 maps exactly to 25%; 67 does not. At maximum 300, 100 marks would require 33.333...% and is rejected. At maximum 150, 25% is 37.5; no 37/38 approximation is made. The modal can accept a different explicitly entered value that converts exactly, such as 45 -> 30%. Existing independent maxima remain visible/read-only; fully arbitrary absolute/fractional allocations need a separately approved persistence/calculation contract.

### D. Asynchronous entry and focused cleanup

Existing Advanced manual/original AJAX implementations were retained. Their in-flight state now preserves keyboard focus using read-only fields, with a shared per-student busy guard. Another attempted edit remains visibly pending/retryable instead of disappearing; Enter saves without browser submission. Server-confirmed values/totals and original occurrence component summaries remain authoritative. Permission/window failures do not grant renewed write permission.

The two active traditional Teacher views previously had initial HTML POST rows, a separate filtered-row AJAX handler that reloaded the page, destructive integer keyup checks and duplicated bulk functions. They now share `legacy-grade-entry.js` and one metadata/feedback partial:

- Delegated initial/filtered row saves use the existing modern writer endpoint; row-local IDs and authoritative page context replace global/duplicated DOM-ID lookups.
- Original single/bulk forms and POST/redirect fallback remain. JSON is returned only when requested. Existing import forms are not intercepted.
- Saving state, inline error/success, preserved failed input, explicit zero/decimal handling, unsaved-leave warning, original result ID refresh and Enter/next-field focus require no reload or new framework.
- Bulk still calls the existing atomic transaction. One invalid row rolls back the batch. Duplicate student/assessment keys are rejected before writes; repeated in-flight requests are prevented. Bulk results refresh only from confirmed returned rows.
- Repeated single saves of an unchanged result no longer add duplicate notifications. Existing changed-result notification types and legacy push calls remain; no second notification is added by the frontend/helper. Bulk retains its existing no-per-row-notification behavior. Live FCM delivery was not exercised.

This does not convert old lesson/content grading or automated question-correction pages into the modern occurrence writer.

## 4. AJAX contracts

| Endpoint | Existing payload / enhanced response |
|---|---|
| `teacher.gradebook.save` | Student/component/section/subject/value + CSRF. Existing accepted value/total JSON; numeric manual storage only. |
| `teacher.gradebook.assessment.save` | Student/original exam/section/subject/value + CSRF. Original result ID/value, component summaries and total. Manual lock dependency removed, original protections retained. |
| `student_save_mark_quize`, `student_save_mark3`, `student_save_mark2` | Existing student/exam/section/lesson/mark/optional original result ID. `Accept: application/json` now gets success, student/exam/result IDs, value, medal and message through read-only `AssessmentSaveResponse`; ordinary form callers retain redirect. |
| `student_save_mark_bulk`, `kind=exam2` | Existing JSON-string rows and kind, CSRF. JSON gets saved count and original confirmed rows without extra configuration queries; ordinary callers retain flash/redirect. No partial success is claimed on validation failure. |
| `admin.gradebook.status` | Existing class/actual-term/OPEN-or-LOCKED + CSRF. Existing server-confirmed status/message; switch updates in place. |

JSON failure messages are shown, not interpreted as success just because HTTP completed. The frontend does not duplicate notifications, calculate marks, sum original columns or fabricate result IDs. Read-only or carried/conflicting rows have no enhanced input; direct tampering remains server-denied.

Legacy original-entry screens have no component-total display. Their response adapter projects the already-confirmed original records only, so an unrelated malformed distribution cannot turn a committed original save into a false failure. An isolated fixture verifies this independence. Advanced screens still return/update their visible summaries through the existing shared reader inside their own transaction.

## 5. Calculation contract: deliberately unchanged

Current earned values: average of matched quiz/participation/numeric sources; maximum of matched final exams; one-decimal aggregate rounding; sum of present configured components. Missing remains null; zero remains a real zero. Percentages configure bounds, not new earned-score multipliers. Original occurrence displays do not add another contribution on top of their configured summary. Subject minima are reference values, not a universal passing threshold. The previous hardcoded-50 display correction remains intact.

Consequences requiring a new approved policy, not a cosmetic fix:

- A raw 40/50 quiz can appear beside a configured bound of 10 without having been scaled to 8/10.
- Multiple quizzes are averaged, not added progressively; multiple final exams use the maximum, not an inferred latest/makeup replacement.
- A manual Exam plus an original exam summary can count two separate contributions. Names cannot prove equivalence.
- Explicit maxima, integer percentages and subject maxima need not describe a new whole-row points model.
- Official report import selects existing legacy fields and is separate from dynamic summaries; no report was reimported or rewritten here.

### Proposed future calculation/preview contract: approval gate

Use an explicitly versioned rule/application for new contexts only. Each approved column declares stable identity/source, display versus contribution role, own maximum, aggregation and missing-value policy. An original result contributes through one declared path only; its visible drill-down must not count again. Same/makeup/replacement identity requires an explicit relationship, never title matching.

Recommend choosing one of two clear policies per approved subject: (A) category allocations with an explicitly defined conversion from original earned/max into category points and approved averaging/replacement; or (B) a genuinely incremental points model with an explicit included occurrence set and subject total. Do not present the current raw-average/max engine as either new policy automatically.

Before adoption, show a read-only preview of current versus proposed components/totals, maxima, missing/zero cases, all actual terms/sections, carried results, possible double-counts, out-of-bound values and report differences. Pin input/configuration hashes, require explicit reviewed acceptance, reject stale/conflicting contexts and retain the legacy result view. No historical overwrite or automatic report reimport. Arbitrary absolute allocations, new weighting, immutable applications and official-report integration remain unimplemented until approved.

## 6. Remaining legacy risks / boundaries

- Operational JSON/status files still are mutable legacy files, not a full immutable academic configuration archive. Revision checks protect the new editor, not arbitrary external file edits or old clients omitting the token. Direct filesystem writes can bypass application locks. Real MariaDB concurrency stress was not performed; isolated SQLite/JS tests do not prove all lock interleavings.
- Older lesson-system `student_save_mark`/`student_save_mark1` and the `kind=exam` branch remain distinct from modern quiz/exam entry. Source inspection shows a legacy GET mutation contract and inconsistent lesson maximum/duplicate handling, including legacy class assignment from request. They must not be described as fully unified or newly certified. Replacing GET/old clients or choosing a lesson maximum needs a separate controlled compatibility fix, not an invented modern exam window or source migration. No local `exam_result` population was fabricated to hide this gap.
- Old `GradebookConfig` SQL-model references remain separate legacy debt; their absent physical tables are not repaired or revived. Phase 2B definition/version infrastructure remains separate and is not automatically applied to operational grading.
- Existing Admin all-sections grouping/idempotency and old automated correction internals were not redesigned. The safe shared original writer remains the only enhanced modern result persistence path.
- Pre-existing mojibake comments in the large legacy Teacher controller remain deferred; no new changed lines or new user-facing strings contain those patterns.

## 7. Verification and preservation

Full focused regression: **148 tests / 3,357 assertions passed**. Ten frontend harnesses cover component modal lifecycle/order/empty/impact, exact conversions, status cancel/error/retry/no reload, existing assessment modals, shared original entry, legacy initial/filtered/bulk AJAX, keyboard focus, CSRF, zero/decimals, in-flight duplication, unsaved failure and expiry. **59 Blade views** compiled/linted in disposable storage; changed PHP lint, UTF-8/no-BOM checks and `git diff --check` passed.

New isolated feature coverage includes manual LOCKED/original in-window independence for both original types, expired/tampered/unauthorized denial, numeric-source/representable-bound enforcement, single JSON versus normal fallback, unchanged retry notification suppression, atomic bulk rollback, duplicate-batch rejection, empty distribution persistence, stable/reordered IDs, stale year/revision, scalar tampering, invalid configuration blocking and retained summary/nonstandard source protection. Existing Admin/Teacher/Academic Record calculation/continuity, automated and timetable regressions remain included.

School before/after evidence: **166 tables / 326,304 rows**, schemas/triggers and operational distribution/status files have matching fingerprints. Before/after manifest SHA-256: `2f7381d1666c2a83149fadc7f087c2ee2980b231b7ce12ecc7e7a2b6449e22f3`. Protected calculation/config/status/template service sources, route/migration source and `.env.example` also match. Six distribution files and three status files were present, including the owner's current 406/6 distribution and class-1/term-20 OPEN state; none was changed. No school marks, reports, assessments, submissions, identity, placements, assignments, financial rows or migration ledger were written. Test mutation storage is isolated and disposable.

### Browser acceptance still required

1. Authorized Admin: open operational Settings; cancel/toggle/retry the class switch and verify current year/actual term and visible state without reload.
2. On a disposable clone, open the component modal at desktop/tablet/320px/280px and short height. Check RTL labels, body scrolling, header/footer, focus return, add/edit/cancel/order, exact/inexact absolute entry and allocation refresh. Save an empty distribution and verify original occurrences remain visible. Do not test structural changes against school marks.
3. Teacher 166 or another genuinely assigned account: check class 1/section 130/subject 406. Verify summaries are read-only, a deliberately added numeric manual field follows OPEN/LOCKED and positive integer bounds, and an in-window traditional original ignores that manual switch. Current quiz 2422's expired window must not be bypassed for QA.
4. In a disposable current-context fixture, save zero/decimal marks from initial and filtered legacy rows and Advanced occurrences; inspect JSON/network, same result ID and cross-screen reload agreement. Test failed/expired/session-change saves, preserved input, bulk rollback, rapid repeats and Enter/scroll/focus.
5. Verify carried/history read-only, automated workflows, original files, official reports and Academic Record. Run an approved MariaDB concurrency exercise before claiming production stress acceptance.

## 8. Files changed

- Controllers: `Admin/GradebookSettingsController.php`, `Teacher/TeacherGradebookController.php`, `TeacherController_New.php`.
- Services: new `GradebookComponentEntry.php`, `GradebookDistributionImpact.php`, `AssessmentSaveResponse.php`; one shared subject-lock addition in `TeacherAssessmentService.php`.
- Admin views: `gradebook/settings/edit_json`, `settings/index`, `view_subjects`, `partials/status_script`, new `partials/component_row`.
- Teacher views: `teachers/gradebook/index`, `assessment_columns`, new `legacy_entry`; existing `teachers2/teacher_exam_student` and `teacher_quize_students`.
- Assets: `gradebook-admin-v2.css`, new `gradebook-component-editor.js`, `gradebook-distribution-units.js`, `gradebook-occurrences.js`, new `legacy-grade-entry.js`.
- Localization: Arabic/English `gradebook_ux.php`; new Arabic/English `gradebook_editor.php`.
- Tests: `GradebookSafetyTest`, `GradebookAdminV2Test`; frontend `gradebook-admin-v2`, `gradebook-status`, `gradebook-save`, `gradebook-distribution-units`, new `legacy-grade-entry` harness.
- This report. No existing report, route, schema, migration or dependency was changed.

## Owner decisions and close-out

Approve the future totals/aggregation/replacement policy, arbitrary absolute/fractional storage model, default application/version scope and official-report adoption separately. Used structural changes remain blocked, not overridden. The requested compatible UI/entry improvements are implemented and isolated regressions pass; live browser/device acceptance and the explicitly identified older lesson-system safety contracts remain open. This is not a claim that every legacy grading endpoint has been replaced or that a new academic calculation model is production-active.
