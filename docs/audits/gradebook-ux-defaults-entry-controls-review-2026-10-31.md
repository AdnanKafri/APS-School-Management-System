# Gradebook UX, Defaults and Entry Controls Review

Date: 2026-10-31. Scope: focused compatibility audit and safe presentation/access fixes.

## Outcome

Implemented contextual rescheduling confirmation, exposed the existing entry lock in operational Settings, and corrected misleading distribution/result labels. No grading policy, calculation, source mapping, authorization scope, template application or persistence format changed. Read the unified-assessment-entry and assessment-windows reports dated 2026-10-31 as the implemented baseline; the owner's successful synchronization test remains valid.

No school database/configuration writes, migrations, commits, pushes or deployment. Unfinished work and `.env.example` preserved.

## 1. Assessment Edit confirmation

### Confirmed cause and local evidence

Both active Admin quiz/exam pages use `admin.partials.assessment_modal`. Its Edit branch always rendered a checkbox, even for title/work/notes-only edits or an assessment without results. It was not an HTML-required field. `AdminAssessmentInput::validate()` required it only when `AssessmentResultSafety::hasRecords()` was true and a start/end value differed.

Retained records conservatively include any original result row (even an unmarked placeholder), uploaded submissions, or equivalence membership. They are not synonymous with a nonzero earned mark. This conservative boundary remains unchanged.

Read-only local SQL found quiz 2422, subject 406, section 130, actual term 20, maximum 50, duration 40, traditional mode, with 20 original result rows. Its stored start/end are `2026-10-31 17:41:45` and `2026-10-31 17:45:58`; seconds must not be truncated. The active modal already used `step="1"` and its JS already retained seconds. There is no evidence that this quiz suffered a seconds-loss false positive. The raw backend string comparison nevertheless treated equivalent SQL/local timestamp formatting as a change; a regression now covers that case.

### Exact correction

- Remove the always-visible checkbox from Edit. A hidden confirmation value starts at zero and is never restored as an old approval.
- Canonicalize both stored and submitted timestamps with the existing school wall-clock parser before comparing them. No UTC conversion, rounding, or loss of seconds.
- Submit normally. Only a server 422 containing the sole `confirm_window_change` error prompts the localized rescheduling dialog. Acceptance retries the same form after the in-flight flag is cleared; cancellation sends no retry and keeps the entered values.
- Other validation errors remain visible without a confirmation prompt. Reset approval after completion, on date changes and when another Edit record is loaded. Existing duplicate-submit protection remains.
- No result-bound changes to subject, maximum, mode, question-picker or duration become permissible. Exact type/room/class/year/actual-term checks, model safety and original-result identities remain unchanged.
- Create has no confirmation field. Both types continue using the same isolated Create/Edit implementation.

No-record rescheduling needs no approval. Real retained-record changes, including a one-second change, still require explicit server-validated confirmation. No operational assessment was rescheduled during this audit.

## 2. Actual distribution/default/bounds behavior

### Sources and scope

`GradebookConfigService::getConfig(subjectId, yearId)` reads `storage/app/gradebook/{subject}_{year}.json`. Its legacy two-argument scope is subject/year, shared by sections and actual terms. It is not a per-section template application.

Missing files, malformed JSON or caught read failures use the existing defaults without writing a file. A valid explicit empty component array stays empty. Invalid row shapes are not comprehensively validated by the legacy getter; the opt-in contextual reader diagnoses these separately. The editor now uses that existing read-only adapter for a missing/invalid-file notice, but its actual component collection still comes from the unchanged legacy getter.

| Default ID | Existing label / actual source | Weight |
|---|---|---:|
| `legacy_oral` | Participation (Oral); confirmed legacy lesson assessment results, `LEGACY_ORAL` | 0 |
| `legacy_homework` | Quizzes; original modern type-2 assessments, `LEGACY_HOMEWORK` | 0 |
| `legacy_exam` | Exam; original modern type-1 assessments, `LEGACY_EXAM` | 0 |

These are compatibility placeholders, not a school-approved allocation. Renaming `legacy_homework` to Homework does not create a new independent manual source. Manual numeric sources >=100 use their existing reserved dynamic containers. None were allocated or normalized here.

### Maximum and minimum meanings

- `lessons.max_mark` is the stored subject maximum. Local examples: subject 10 has maximum 100/minimum 41; subjects 406 and 409 have maximum 100/minimum 40. Both columns are integers, not universal constants.
- `componentMaximum()` uses a valid explicit `max_mark` first; otherwise subject maximum times percentage divided by 100. For a subject maximum of 200, weight 30 gives a component bound of 60. An explicit bound of 42 stays 42 even with weight 30.
- `lessons.min_mark` exists independently. It was not displayed in the operational distribution editor; the older prototype settings view had a read-only minimum field. The operational editor now shows the stored minimum as reference only, without changing pass/fail evaluation.
- Input minimum zero is an entry/allocation bound, not the minimum passing mark. The new help text makes this distinction explicit.
- Local maxima include 0, 10, 40, 50, 100, 150, 200, 300, 400, 500 and 600; no single maximum should be imposed. Invalid/nonpositive maxima keep exact marks-mode conversion unavailable.

### Calculations explicitly preserved

The shared reader averages quiz/participation/numeric-source values, takes the maximum final-exam value, rounds component aggregates to one decimal and sums present components. Percentages define bounds; they do not introduce weighted scaling of earned values. All-missing remains null; earned zero remains zero. An unsaved zero-weight default can therefore have a zero configured bound while still displaying real original earned results. Silently forcing these marks to zero would destroy meaning and was not done.

Original Admin quiz/exam occurrences keep original `exams2` and result IDs, their own maximum and window, and separate per-occurrence columns. Configured summaries may intentionally aggregate their sources; they are not newly configured manual occurrences. This audit did not add original columns to the component allocation or add them again into totals.

### Safe display fixes

1. Explain missing defaults, invalid/unreadable configuration, percentage bounds, stored subject minimum and independent stored bounds in the operational editor.
2. Stop displaying `max_mark` as a fallback percentage when weight is absent. Display weight or zero in the percent field and the independent bound separately; no stored JSON is repaired or saved by GET.
3. Remove the student-card summary's hardcoded `final >= 50` pass/fail badges. This rule ignored real subject minima and arbitrary maxima. Keep the exact existing numeric summary and explain that it is not an official pass/fail decision. No new passing rule was substituted.

### Exact conversion and known mismatch

The existing marks-mode editor accepts only reversible whole-number marks/whole-number percentages. At maximum 200, 50 marks maps to 25%; 67 marks cannot map to a whole percentage. At maximum 300, 100 marks would require 33.333...%, so it is rejected rather than rounded. At maximum 150, 25% gives 37.5: percentage mode remains available, but whole-mark mode is unavailable for that distribution. Explicit bounds, unreliable totals and source/ID mismatches also block marks-mode conversion. Saving remains the existing percentage contract.

Five operational JSON files were inspected without modification: `10_6`, `158_5`, `31_5`, `49_5`, `50_5`. Current subject 10/year 6 is explicitly configured 20/40/40. Historical `49_5` maps reserved ID `legacy_homework` to numeric source 100, not `LEGACY_HOMEWORK`. Its historical source and zeros were not normalized. The pre-existing settings writer forces reserved core IDs to legacy sources on a save; that is separate legacy debt, not a safe mechanism for repairing historical files. Do not resave that historical configuration as a cleanup operation.

## 3. Existing Admin ON/OFF control

### Before and after

Before: only discoverable at Gradebook -> Review -> By subject -> Class -> Section -> Subjects, route `/SMT/admin/gradebook/view/subject/subjects/{roomId}`, view `view_subjects.blade.php`. It was not in operational Settings. Its existing checkbox/AJAX behavior was functional but misplaced.

Now: Gradebook -> Settings, `/SMT/admin/gradebook/settings`, shows one labeled control per class for the active year's actual current term, alongside the existing section links. The year/term are visible. Missing current term shows the existing localized message and no actionable toggle. Status script is shared with the original review control, preserving confirmation, CSRF, pending disable, failed-request rollback and server-confirmed refresh. No new route or permission was added.

### Exact existing contract, unchanged

- Default storage disk, `gradebook_status/{class_id}_{actual_term_id}.json`, values `OPEN`/`LOCKED`; missing/invalid status defaults to LOCKED. Year is implicit in the actual term record.
- Scope: all subjects and sections of that class/actual term, not per subject/component/section. Only old term-17 files `3_17` OPEN and `4_17` LOCKED currently exist locally; they do not unlock actual term 20.
- `POST /gradebook/status`, `admin.gradebook.status`, `GradebookController::toggleStatus`; existing `auth`, `roleadmin`, `can:student_marks`, Web CSRF and request validation remain.
- Backend accepts an actual term belonging to the active year; it does not require that term's `current_term` flag. This pre-existing API contract was not narrowed. Both normal controls resolve the current term inside the active year.
- Advanced manual numeric-component saves require OPEN. Advanced original-occurrence saves/rendering also currently require OPEN, plus original window, timetable responsibility, current membership and retained-history rules.
- Ordinary traditional Teacher assessment entry uses the shared original writer/window and existing permissions, without the Advanced JSON lock. Thus the current lock is **not manual-only**. Settings wording explicitly discloses this, rather than silently changing its scope.

The desired independence of original occurrences from a manual-only switch is a product/compatibility decision still requiring approval. This audit did not remove the existing Advanced occurrence gate or weaken original timing enforcement.

## 4. Consumer and writer inventory

| Area | Configuration/status contract |
|---|---|
| Admin Settings controller | Subject/year component read/write; current class/actual-term status reads added to Settings; file-presence badges elsewhere still indicate file presence, not semantic validation. |
| Admin Gradebook controller | Shared read service for subject/student summaries and original details; existing toggle is the status writer. |
| Teacher Advanced controller/view | Subject/year config through shared reader; configured maxima and numeric manual writer; class/actual-term status for manual and Advanced original entry. |
| `GradebookReadService` | Exact original definitions/results, all requested actual terms, source summaries and continuity; no config/status writes. Numeric-container label lookup rereads the same subject/year file. |
| `GradebookAggregationService` | Shared original reads, explicit guarded report import; no automatic import triggered here. Existing term-type/current/latest selection remains unchanged and is not redefined by default policy. |
| `GradebookContextReader` | Read-only diagnostics and exact source/revision identity, now used for editor health messaging only. No template lookup/application is introduced. |
| Original Teacher modern screens/writers | `TeacherController_New`/`TeacherAssessmentService`, original maxima, current context and shared window; not made subject to a new distribution lock. |
| Older `teacherscontroller` / `newcontroller` code | References the separate `GradebookConfig` model/`gradebook_configs` table and oral/homework caps inside legacy exception handling. That table is absent from the inspected local schema. These are not the JSON engine and no writer to that model was found in app/routes. No revival or migration attempted. |
| Student Academic Record | Selected placement/year/room and original marks/reports/results; no direct JSON/status reader or writer. History is not recalculated by these UI changes. |
| Reusable templates | Existing draft/version storage and previews remain separate; no application to operational subject/year JSON or status is added. |

## 5. Proposed academic defaults: approval only

Recommended immediate policy: retain missing-file placeholders, require deliberate subject/year review, and never auto-save on page load. A concrete candidate for future opt-in defaults is the already-used local 20% participation / 40% quizzes / 40% final-exam allocation, **only if the school approves those actual source meanings**:

| Subject maximum | Participation 20% | Quizzes 40% | Exam 40% |
|---:|---:|---:|---:|
| 50 | 10 | 20 | 20 |
| 100 | 20 | 40 | 40 |
| 150 | 30 | 60 | 60 |
| 200 | 40 | 80 | 80 |
| 300 | 60 | 120 | 120 |
| 400 | 80 | 160 | 160 |
| 600 | 120 | 240 | 240 |

These are component **bounds**, not newly scaled earned grades. This proposal does not cap/rescale existing original occurrences, change aggregation, overwrite saved files or impose a universal minimum. Distinct maxima may require different subject policies rather than one ratio.

Decisions required before implementation:

1. Approve ratios, source meanings and which subjects/years they apply to. Participation currently means confirmed lesson assessments, not an independent editable oral field; independent oral/homework requires numeric manual categories rather than relabeling reserved IDs.
2. Decide whether percentages mean bounds only (current behavior) or weighted grading. The latter is a separate academic/calculation change, requiring explicit versioned rules and historical compatibility tests.
3. Confirm per-subject maxima/minima, treatment of zero/missing maxima, decimal allocations and the exact integer-conversion limitation. Do not infer a passing minimum from a percentage input or assume 50.
4. Decide same-type occurrence aggregation, makeup/replacement semantics, missing results and official reporting. Current average/max and zero/null rules remain until approved.
5. Approve creation scope: suggested opt-in new/empty subject/year only, explicit preview/confirmation and no historical replacement. Decide immutable version/application identity before affecting contexts with earned results.

## 6. Proposed independent manual-component locking

Design only; no new schema or status files implemented.

- Introduce one entry-policy reader used by both UI and every manual write. Resolve exact year, actual term, class, subject, stable component ID, source and configuration revision/application identity. Preserve all section/timetable/student authorization independently.
- Initial subject/component scope should cover its class's sections consistently with existing shared subject/year distribution. Per-section overrides require a separate policy decision; never select an arbitrary first/latest configuration.
- Keep current class/actual-term JSON as the compatibility master gate. Missing component overrides inherit it; opening an override must not bypass a locked master. Unknown/mismatched configurations fail closed for writes, with a readable diagnostic.
- Prefer audited database overrides with a unique contextual identity, OPEN/LOCKED, actor, timestamp and optimistic revision, rather than more mutable independent JSON files. Migration/storage choice requires approval; no deployment dependency is created now.
- Bind an override to the exact applied configuration/source identity. A changed distribution/version must not accidentally inherit an unrelated component's permission. Never key by translated label, displayed position or occurrence name.
- Original occurrences are not manual-component overrides. After explicit approval, remove only the Advanced class-lock dependency from their UI and original save endpoint, retaining original assessment ID, exact context, window, Teacher permission, historical read-only and shared transactional writer. Ordinary original entry semantics remain intact.
- Agree on rollout precedence, stale-browser/concurrent-toggle handling and audit retention before enabling the new policy. Existing missing-file LOCKED behavior and authorization must stay predictable throughout rollout.

## 7. Verification and data preservation

All mutation tests used disposable SQLite `:memory:` fixtures and private opt-in test storage. School evidence used PDO SELECTs inside a read-only transaction and rollback, not application controller writes.

- Full focused PHP regression: 143 tests, 3,250 assertions passed. Covers Admin V2 rendered routes, both original types, exact timestamps/nonzero seconds, ordinary vs confirmed edits, structural guards, current context, status authorization, traditional and Advanced windows, manual locks, original IDs/zeros/nulls, continuity, template isolation, Student Academic Record and timetable/follow-up regressions.
- New editor fixtures cover missing/malformed files without write, independent maximum versus percentage, stored minimum reference, actual current-term controls, other-term isolation and no-current-term state. Existing multi-class query test confirms no per-class database query growth; Settings adds one current-term SELECT and at most ten paginated-class status-file reads. Editor diagnostics add four bounded context SELECTs and a read-only file inspection, not per-component queries.
- Nine Node frontend harnesses pass, including contextual-confirm cancel/retry/reset, existing status confirmation/AJAX/error rollback, exact distribution conversions, shared-result entry and window expiry.
- 57 relevant Blade views compiled and PHP-linted in disposable storage; changed PHP files lint clean. UTF-8 decode/no-BOM and obvious mojibake checks pass on files changed in this pass. `git diff --check` passes; repository line-ending warnings are not code errors.
- Read-only before/after manifests match: 166 school tables, 326,304 rows, schemas/triggers, five operational distribution files, two status files, protected Config/Read/Status/template service sources, routes/migration source and `.env.example`. Manifest SHA-256: `3a94dcafed4726368e1e5a05988a7574ade8b19aab63ced8d6b90ffc42cab28d`. No original results, marks, student/account/placement or financial rows changed.

### Remaining real-browser acceptance

No browser is connected (`No browser is available`). HTTP/controller tests rendered the real Admin V2 layout with isolated authenticated fixtures; Node harnesses are interaction simulations, not visual browser acceptance. No authenticated school-session POST was attempted.

Manual checklist: open quiz and exam Create/Edit on desktop and narrow mobile; save unchanged seconds/title/notes without a prompt; change a retained-record window, cancel, then accept and verify original identities; reopen another record to check approval reset; check Settings year/term and class lock label, cancel/toggle/error feedback in a safe approved context; verify exact-percent/marks help and independently stored bound. Confirm Teacher ordinary/Advanced entry still shares original results and that the **existing** Advanced class lock remains as disclosed.

## Files changed in this pass

- `app/Services/AdminAssessmentInput.php`
- `app/Http/Controllers/Admin/GradebookSettingsController.php`
- `public/assets/admin/js/assessment-editor.js`
- `resources/views/admin/partials/assessment_modal.blade.php`
- `resources/views/admin/gradebook/settings/index.blade.php`
- `resources/views/admin/gradebook/settings/edit_json.blade.php`
- `resources/views/admin/gradebook/view_subjects.blade.php`
- `resources/views/admin/gradebook/view_by_student.blade.php`
- `resources/views/admin/gradebook/partials/status_script.blade.php`
- `resources/lang/ar/assessment_entry.php`, `resources/lang/en/assessment_entry.php`
- `resources/lang/ar/gradebook_ux.php`, `resources/lang/en/gradebook_ux.php`
- `tests/Feature/GradebookSafetyTest.php`, `tests/Feature/GradebookAdminV2Test.php`
- `tests/Frontend/assessment-editor.test.js`, `tests/Frontend/gradebook-status.test.js`
- This report.

## Owner summary

The checkbox friction and misplaced existing lock are corrected. Defaults remain unapproved zero-weight placeholders with clearer explanations; incorrect percentage fallback and universal pass/fail labels are removed. Existing original-result synchronization, grading calculations and class/term lock scope are preserved. Academic defaults and independent component permissions require the decisions above, not automatic implementation. Code/regressions are complete for this focused pass; real-browser acceptance remains pending.
