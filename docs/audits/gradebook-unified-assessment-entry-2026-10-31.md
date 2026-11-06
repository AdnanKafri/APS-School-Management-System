# Unified Gradebook Assessment Columns and Entry Permissions

Date: 2026-10-31. Project: `C:/Users/Lenovo/Desktop/aladhamedu`.

## Outcome and implementation boundary

**Implemented: safe, read-only discovery of original exam/quiz occurrences in the Advanced Teacher Gradebook. Synchronized occurrence entry is deliberately NOT enabled.** The existing writer has no server-side assessment-window restriction, and the meaning of a Teacher grading window versus a student exam window needs approval. The request explicitly requires this gap to be documented before enabling another writer.

Configured distribution summaries, original occurrences and supplementary source/history results are distinct. Creating an occurrence does not add a distribution component or change calculations. No parallel grading storage, new lock, migration, template application or school-data correction was introduced.

Reviewed the previous architecture/workflow and distribution-integration reports, active routes/controllers, services, models, templates and actual local schema/data. Existing unfinished changes were preserved; prior reports were not edited.

## 1. Source-of-truth map

| Flow | Actual implementation and scope |
|---|---|
| Admin quiz list | `routes/admin.php`, `DashboardController::room_quizes`, `admin.quizes_of_room`; `/SMT/admin/class/room/quizes/{room_id}`. Corrected its unscoped current-term lookup to match the existing exam list and both creation handlers. |
| Admin exam list | `DashboardController::room_exams`, `admin.exams_of_room`; already uses a current term belonging to the active year. |
| Admin creation | `quize_store` / `exam_store`, POST `/SMT/admin/class/room/quize/store` / `exam/store`. Writes `exams2`, type 2 quiz / type 1 exam, with exact class/section/subject/actual term, dates, maximum, duration, notes, file/automated settings and group. No new creation mechanism. |
| All sections | `room_id=[0]` expands the reference class's active-year sections intersected with existing section permissions. One original `exams2.id` per section, not one global definition. Explicit simultaneous creation can use existing `AssessmentEquivalenceService::createdTogether`; group/name alone is not equivalence evidence. |
| Original modern result | `exam_result2.exam_id -> exams2.id`; `user_id` is the permanent **student ID**, not the login user ID. Original room/class/lesson/actual term and result ID remain authoritative. |
| Teacher ordinary screens | `routes/teacher.php`, `TeacherController_New::teacher_exam_mark`, `teacher_quize_mark`, `teacher_exam_students`, `teacher_quize_students`; `teachers2.teacher_exam_student`, `teacher_exammark_auto`, `teacher_quize_students` and related automated view. Current timetable, current-year term and operational roster restrict access. |
| Ordinary writer | `student_save_mark_quize`, relevant AJAX and bulk actions delegate modern marks to `TeacherAssessmentService::save`. Student/exam locks, exact context, membership, original result bounds, duplicate-row and continuity guards; retains one original result. Notifications remain in existing controller flows. |
| Advanced Gradebook | `Teacher/TeacherGradebookController::index`, `/SMARMANger/dashboard/teacher/gradebook/{class}/{room}/{subject}`, `teachers.gradebook.index`. Current timetable authorization, active-year section and actual current term; shared reader supplies originals. New adapter adds read-only presentation metadata. |
| Existing Advanced manual entry | `TeacherGradebookController::saveMark`. Only configured numeric sources >=100, exact `Dynamic_Section_N` context, existing class/actual-term OPEN status, current roster, locks/bounds/retained results. No occurrence-ID save branch was added. |
| Legacy lesson assessment | `lesson_teacher_room_term_exam` plus `exam_result`, distinct IDs from modern exams. Confirmed results feed `LEGACY_ORAL`; content without a confirmed result is not invented as an assessment. Supplementary read-only details remain available. |
| Distribution | `GradebookSettingsController`, `settings/edit_json`, `GradebookConfigService`; subject/year JSON shared across sections and actual terms. Component ID is not an assessment ID. Source determines aggregation; name does not establish identity. |
| Shared readers | `GradebookReadService` serves Admin subject review, student-card review and Advanced Teacher reads. `GradebookAggregationService` / explicit report import are separate mutation boundaries. Student Academic Record reconstructs selected-placement original records and stored reports; it was not rewired or recalculated. |
| Status | `GradebookStatusService`: `gradebook_status/{class}_{actualTerm}.json`, defaults LOCKED. It controls existing Advanced dynamic entry, not a per-component lock or a universal legacy exam lock. |

Local SELECT evidence: active year **6 (2026/2027)**, actual term **20**. All **2,255** modern definitions are historical: type 1 **1,025**, type 2 **1,230**; modern results **27,318**, legacy lesson results **0**. There are **zero active-year modern definitions**, including the requested section 130/subject 406 and section 132/subject 409. No fake school assessments were created. The authoritative timetable does allow Teacher 166 / section 130 / subject 406 via schedule **4122**, Wednesday 13:20-14:00. This is SELECT/source evidence, not authenticated browser acceptance.

### Confirmed Admin list defect

Before this change, quiz creation used the active year's term, while `room_quizes()` selected the first flagged term across all years. Old-year flagged terms can precede term 20, so a newly created quiz could disappear from its Admin list. The lookup now uses the same active-year subquery already used by the exam list and creation endpoints. An isolated controller regression confirms only the correct year's quiz appears, agreeing with the Teacher occurrence columns. Permissions, definitions, creation parameters and storage are unchanged.

## 2. Implemented presentation

- `TeacherGradebookAssessmentColumns::forContext` projects the existing shared-reader assessment collection, checks exact year/class/section/subject/actual-term context, and batches original type-1/type-2 definitions in **one extra SELECT**. It never writes or recomputes marks.
- Every ordinary occurrence has its own namespaced `exams2:{id}` column, including multiple identical titles, future-start and makeup-named occurrences. No first/latest selection or name-based deduplication. All-sections definitions remain section-specific originals.
- Headers show original title/type/maximum, start/end, duration and a link to the existing original assessment screen. Original group and automated/traditional flags are retained as presentation metadata, not reconfigured or interpreted as entry permission.
- Cells retain shared-reader zero/null, original result IDs and carried/conflict provenance. No occurrence input, submit handler or save URL is introduced. Existing legacy screens remain operational and refresh into this view through the same original results.
- Configured component summaries stay separate, now explicitly labeled with their configured maxima. Dynamic/lesson source details and previous-section history remain in an expandable read-only section without repeating ordinary occurrence columns.
- The existing component input visibility now matches its server contract: numeric source >=100 and existing OPEN status. Unknown/non-numeric sources do not acquire an editable-looking input. No server authorization changed.
- Localized Arabic/English wording, existing Teacher shell, scoped wrapping and contained focusable table scrolling. No Admin V2 redesign.

### Diagnostic timing, not permission

Window labels are upcoming / within assessment window / ended / unreliable. Both dates must be complete, valid and ordered; malformed/missing dates never suggest entry permission. The adapter uses the existing effective `config('app.timezone')`; `config/app.php` currently declares Damascus then Riyadh, with Riyadh effective. This pre-existing configuration was not changed. Labels are explicitly diagnostic and read-only even within the window.

## 3. Writer audit and safe enforcement proposal

**Confirmed gap:** `TeacherAssessmentService::save` does not compare now against `start_date` / `end_date`. Isolated characterization tests successfully update the same original result before start and after expiry. This is existing behavior, not an approved new timing rule. It also does not apply the Advanced class/term JSON lock or distinguish automated from traditional marking permissions. Merely calling it from a new AJAX route would not satisfy the requested safeguards.

Legacy lesson writers have their own routes and rules, including Teacher-created lesson assessment/content definitions. The Advanced Gradebook gains no create/delete/rename/reschedule/configure actions. A universal Admin-only policy for those older lesson routes has **not** been implemented or certified here; it is a separate compatibility boundary, not a reason to reinterpret their results as manual components.

Recommended approval gate before enabling occurrence entry:

1. Decide whether Teacher entry follows student assessment dates, is allowed after completion, or requires a separate explicitly authorized grading window. Decide boundary inclusivity, missing/invalid dates, exceptions and existing automated-result correction behavior. Do not silently apply a student participation window as a new grading deadline.
2. Implement one shared server-side entry policy in the locked `TeacherAssessmentService::save` path used by single/bulk/AJAX entry, not only in Blade. Revalidate context/time/mode on every write. Preserve timetable authority, student locking, exact original ID, maximum, duplicate rejection and carried/conflict protection.
3. Then add a narrowly scoped occurrence-ID Advanced action calling that same policy/writer, with CSRF and server-returned values/totals. Do not route occurrences through numeric dynamic components, create containers for them or copy results. Confirm notification semantics rather than duplicating controller notifications.
4. Test pre-start/active/expired, automated/traditional and direct tampered requests consistently through **both** interfaces before enabling the new path. No new occurrence writes are currently permitted by the Advanced endpoint in any window.

Per-manual-component OPEN/CLOSED is also **not implemented**: today's lock is class/actual term. Adding a per-component flag/scope needs the explicit compatibility review requested by the owner. Numeric manual components retain existing persistence; `LEGACY_HOMEWORK` means original type-2 quizzes, not a new independent homework mark store.

## 4. Totals compatibility proposal - design only

Current calculation is unchanged: matching-source averages except `LEGACY_EXAM` maximum, rounded to one decimal, then sum of present component values. Percentages derive configured bounds, not a new scaling of earned marks. Original occurrence maxima and configured bounds may differ. All-missing is null; zero is earned zero. Multiple components referencing the same source can already repeat its aggregate; do not silently deduplicate or normalize existing configuration.

Concrete isolated comparison:

| Sources | Current summary | Raw occurrence sum |
|---|---:|---:|
| Three quizzes: 10, 30, 0; original maximum 40 each | 13.3 | 40 |
| Two exams: 40, 60; original maximum 80 each | 60 | 100 |
| Manual component: 15 | 15 | 15 |
| Total | **88.3** | **155** |

Both values are mathematically possible but academically different. No new raw-column total was enabled. Existing report formulas and published/historical values remain unchanged.

Recommended future contract: retain the current total as a named legacy calculation; approve a versioned policy for new contexts specifying included occurrence identities, raw versus normalized contribution, category limits, missing handling, rounding and publication. Show a side-by-side impact preview before activation. A replacement must reference its original occurrence and explicitly select replace/highest/both/excluded behavior; an append-only actor/reason decision should retain both original results. Names such as makeup/retest, `groupe`, later dates and cross-section equivalence must never imply replacement. No reliable replacement relation currently exists; equivalence is same-occurrence cross-section continuity, **not** a makeup exclusion rule. Never include carried and original copies twice. Historical reports must stay frozen rather than adopt a new policy retrospectively.

## 5. Distribution change compatibility - existing guards and proposed boundary

| Change | Existing behavior / safe next step |
|---|---|
| Add component | Existing editor allocates a new source without recycling reserved containers. Do not reuse an exam identity; preview changed totals and existing unconfigured sources before broad application. |
| Rename/reorder | Stable IDs/source mappings retained; supported today, but file writes have no operational audit/version journal. Preview affected contexts; preserve prior labels/version if historical presentation must be frozen. |
| Increase/decrease bound | Recorded dynamic containers block either weight change. Explicit stored maxima are retained by this editor. Do not relax this or rescale results. Preview old/new bounds, result maxima and exceedances across all affected sections/terms. Core-source weights can currently change without a complete source-wide impact check; future preview must cover them too. |
| Remove component | Used dynamic components cannot be removed. Core-source removal is not comprehensively impact-guarded; results remain stored but could disappear from summaries. Require impact preview/policy before exposing further structural automation. |
| Change source | Existing mappings reject submitted source rebinding; do not repair known historical `49_5` ID/source mismatch. Reserved core-ID forcing remains a known compatibility risk for blind save/import. A future preview must reject implicit normalization rather than map by name. |
| Disable entry | Existing class/actual-term lock blocks Advanced manual writes without deleting marks. Per-component lock requires approval; no new status store added. |
| Earned value above proposed maximum | Existing original-definition guard prevents maximum/context rewrites once records exist; current dynamic weight guard is conservative. Future impact check must identify every affected original result and block unsupported reductions, never clamp or erase. |

Proposed preview boundary: subject/year scope across **all** sections and actual terms; compare exact source/IDs, original and configured maxima, result/submission/mapping dependencies, duplicates and existing JSON bytes; show old/new calculations and exceedances; explicit confirmation/actor/reason. Recheck hashes/activity at execution. Use an approved private revision/journal and recovery contract before multi-file writes; SQL rollback alone cannot restore JSON. No preview/apply/audit persistence was invented in this slice.

## 6. Verification and preservation

All mutation tests use isolated SQLite `:memory:` and fake/disposable storage, with opt-in test-only SQLite extensions. The school database is accessed only by direct PDO SELECTs inside read-only transactions followed by rollback. No school migrations, API saves, imports, synchronization or test assessments were run.

- Focused PHP regressions: **131 tests / 3,000 assertions PASS** (Gradebook safety, real Admin V2 views, templates/context, follow-up, timetable authority and Teacher timetable view).
- Nine new cases: pre-start Admin creation visibility; active-year Admin quiz list; all-sections expansion; timing/Advanced write denial; exact actual-term/section/year/subject IDs and repeated titles; original zero/null/result IDs and legacy timing-gap characterization; one-batch query/calculation agreement; timetable denial; distribution bounds/locks retaining originals. Existing tests cover membership, continuity/transfer, duplicate original rows, historical readers, reports, source mapping, explicit maxima and dynamic saves. Additional two-interface write synchronization is **deferred**, not claimed tested.
- Six existing frontend harnesses pass: Teacher save, status, continuity, Admin V2, exact distribution units and template editor. The occurrence view adds no JavaScript dependency.
- **49** relevant Blade views compile and PHP-lint in isolated storage. Modified PHP files pass PHP 7.4 lint; changed files are valid UTF-8 without BOM; new/diff text has no introduced mojibake. `git diff --check` passes (existing LF/CRLF warnings only).
- Before/after fingerprints match across **166 tables / 326,261 rows**, schemas/triggers, all five configuration and two status files, `.env.example` and protected shared services/routes/migration source. Manifest SHA-256: `64f6404c4cbb36128be998d8b06d446ec270b72f2e36a54f4a664716265594ce`. Evidence is stored privately outside the repository/web root under the task-specific `gradebook-unified-*` backup directory; fingerprints are not a restorable database backup.

**Browser acceptance: pending.** Browser access was attempted; the tool reported no browser available. Automated fixtures render the actual child view with an isolated shell; they do not establish real authenticated clicks, pixel layout, 280px/mobile overflow, console/network or original-screen navigation. Real active-year data currently has no occurrences. Manual QA in a disposable clone should create an Admin exam and two quizzes, verify each section's columns before/during/after dates, check original-screen links and refreshed results, narrow-width contained scrolling, read-only carried/conflict cells and unchanged dynamic manual save feedback. Do not create school data merely for demonstration.

## 7. Exact files changed in this task

- `app/Http/Controllers/DashboardController.php`: only the Admin quiz-list current-term lookup.
- `app/Http/Controllers/Teacher/TeacherGradebookController.php`: read-only presentation projection/partition.
- New `app/Services/TeacherGradebookAssessmentColumns.php`.
- `resources/views/teachers/gradebook/index.blade.php`: separate sections, configured maxima and input visibility aligned with existing server eligibility.
- New `resources/views/teachers/gradebook/assessment_columns.blade.php`.
- New `resources/lang/ar/gradebook_occurrences.php` and `resources/lang/en/gradebook_occurrences.php`.
- `tests/Feature/GradebookSafetyTest.php`: isolated regression additions, preserving previous tests.
- This report.

No shared calculator, original result writer, assignment/membership service, financial logic, route, schema, report or school JSON/status file changed. No commit, push or deployment.

## Decisions before the next write-enabled slice

1. Approve the shared Teacher grading-time and automated/manual correction policy, then apply it consistently to existing and future writers.
2. Approve any per-component entry lock scope/storage and operational configuration audit contract.
3. Approve column-total/replacement/exclusion and historical publication semantics separately; do not treat occurrence discovery as approval to recalculate marks.

**Safe read-only integration complete; synchronized occurrence entry and new academic policies remain approval-gated.**
