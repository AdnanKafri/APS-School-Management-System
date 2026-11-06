# Assessment Windows, Admin Modals and Synchronized Entry

Date: 2026-10-31. Project: `C:/Users/Lenovo/Desktop/aladhamedu`.

## Result

**Implemented:** the approved inclusive Teacher entry window for current-context traditional Admin exams/quizzes, shared enforcement across original Teacher mark routes, synchronized original-result entry in the Advanced Gradebook, and focused repair of both Admin create/edit modal flows. Calculations, report import, manual-component storage, historical identities and school data are unchanged.

Read `gradebook-unified-assessment-entry-2026-10-31.md` before implementation. Its previous timing blocker is resolved for the traditional current-context contract below. Its separate totals/replacement, per-component lock and operational configuration-versioning decisions remain deferred.

## 1. Confirmed findings and corrections

| Finding | Correction |
|---|---|
| Admin edit handlers used global `.lesson_id`, `.start_date`, etc.; even the mode select shared a subject class. Opening Edit could overwrite Create and unrelated fields. | One shared modal partial, unique IDs, named controls scoped to the actual edit form, reset before population, delegated Bootstrap `show.bs.modal` handling. |
| SQL timestamps were assigned directly to `datetime-local`; some browser inputs became blank. | Strict wall-clock conversion between `YYYY-MM-DD HH:mm:ss` and local input `YYYY-MM-DDTHH:mm:ss`, preserving seconds. No JS Date/UTC conversion. Backend normalizes minutes/seconds with the same parser before validation. |
| Page-level jQuery reload could replace the V2 layout's jQuery/Bootstrap/DataTables instance; quiz DataTables was initialized twice, and Select2 was called unconditionally. | Removed the redundant jQuery script and fragile duplicated scripts. Initialize/reuse one DataTable. Native modal selects need no Select2. |
| AJAX subject-filter renderer used `note` instead of `notes`, mismatched quiz permissions, unsafe interpolation and rebuilt modal metadata. | Use the existing DataTable's subject-column filter over the already-loaded records. No replacement rows or metadata are fabricated. Existing filter endpoints remain, now rejecting non-current-year sections. Search/pagination/sorting still belong to DataTables. |
| Modals could inherit transformed/clipped ancestors and overflow short viewports. | Move only assessment/delete modals to body after load; new scoped CSS constrains the modal to viewport height, scrolls body only, keeps header/footer reachable, and uses RTL labels in normal flow. No global layout redesign. |
| Create/update handlers did not consistently validate dates, end-after-start, mode, integer database bounds or notes length; edit could accept a different type/year/section. | Shared `AdminAssessmentInput`: strict dates and ordering, positive integer maximum, nonnegative integer duration, mode/question-picker options, required work, 99-character notes matching the actual `varchar(99)`, exact active-year/actual-term/class/subject/section checks. Names remain free text. |
| Existing-result structural edits needed a clear boundary. | Reject changes to maximum, subject, mode, question-picker and duration with records; preserve existing model context/result/submission/equivalence guards. Wrong exam/quiz type, other section/year and room reassignment are rejected. |
| Changing dates after results exist changes who can edit, even without rewriting results. | Admin must explicitly confirm a window change in Edit. Stored results, their original timestamps and attachment references stay unchanged. Name/work/notes and deliberately confirmed dates can be updated without rescaling or moving marks. |
| Legacy `student_save_mark2` wrote result rows directly, bypassing shared bounds/duplicate/context protections. | Removed its duplicated writer body and delegate to `TeacherAssessmentService::save`, retaining its redirect contract. |
| Traditional correction endpoint could bypass the ordinary writer and accept a different posted assessment ID. | Modern `update_result1` checks exact original definition ID and uses the shared writer for traditional results inside a transaction. Automated correction calculation remains separate and unchanged. |

The active views really are `admin.quizes_of_room` and `admin.exams_of_room`, both extending `admin.layouts.v2`. The new partial replaces only their create/edit modals. Existing list styling, action routes, all-sections meaning, delete protection and Teacher visual identity remain.

## 2. One server-side window policy

`AssessmentEntryWindow` parses dates and evaluates original `exams2` definitions:

- Before start: deny.
- At start, within window and exactly at end: allow, subject to all other authorization.
- After end: deny.
- Missing, malformed, impossible, equal or reversed timestamps: deny.
- Direct Advanced occurrence entry requires positive original maximum, type 1/2, traditional/file mode (`is_file=1`), Admin creator/account type 2, and no reserved `Dynamic_Section_*` identity.

Dates and now use effective `config('app.timezone')`, not the browser clock or a submitted timestamp. Existing config declares Damascus and then Riyadh; effective Riyadh is UTC+03:00, matching Damascus for the applicable 2026/2027 school context. UTC-to-local boundary tests verify the comparison. **No global timezone setting was changed** and no historical dates were converted.

`TeacherAssessmentService::save` re-evaluates this policy after locking the student and original assessment and validating current context. It retains active-year/current-actual-term checks, timetable authority, operational membership, maximum validation, duplicate-row rejection, original result context, continuity/carried/conflict safety and transaction retries. The Advanced endpoint independently rejects a mismatched posted section/subject/term before exposing window feedback, then delegates persistence to that same writer.

### Mutation-path coverage

| Path | Enforcement / compatibility |
|---|---|
| `student_save_mark_quize` | Shared traditional policy through existing service; existing notification/push flow retained. |
| `student_save_mark3` AJAX | Same writer/policy and original identity; existing notification/push behavior retained. |
| `student_save_mark2` | Previously a bypass; now same writer/policy. |
| `student_save_mark_bulk`, `kind=exam2` | Each row calls the shared writer within the existing outer transaction; one denied row rolls back the batch. |
| Modern `update_result1` | Exact posted/original definition match. Traditional edits use shared writer and timing; automated question correction retains its separate calculation and publication contract. |
| Advanced `gradebook/assessment/save` | New POST under existing Teacher middleware/Web CSRF. Exact original assessment/student IDs, current context, existing Advanced class/actual-term OPEN status, original writer and original result row. |
| Participation changes | Existing current-roster, retained-earned-result/file and continuity guards remain. Unused participation placeholders are not treated as earned mark entry. No Teacher earned-result deletion enabled. |
| Automated/student submissions | No new model-wide timing hook. Automated legacy Teacher correction, Student controllers/API grading and authorized Admin correction remain separate; the new Advanced action rejects automated occurrences. |
| Legacy lesson assessments | Separate `lesson_teacher_room_term_exam`/`exam_result` contracts remain unchanged. They are not mapped to this modern occurrence writer. |

Teacher question selection (`myquestions1`) now verifies **all** target definitions/assignments before its existing writes and rejects traditional definitions. Existing automated question-authoring remains a separate workflow; this does not enable Teacher creation/rescheduling/configuration from Gradebook. Existing Teacher attachment delivery is unchanged. No new delete, rename or schedule action is available to Teachers.

### Historical boundary

The modern shared writer already requires the globally active year and that year's actual current term. Old-year/old-term records remain historical/read-only through this route; they are not retroactively regraded or timestamp-normalized. Malformed current-context traditional dates now intentionally fail closed under the approved policy. Admin can deliberately correct/reschedule an eligible current definition, with confirmation when results exist. No automatic exception or historical-data rewrite was introduced.

## 3. Synchronized Gradebook entry

The read-only occurrence projection now also includes policy eligibility/reason. Its creator lookup is a join in the existing single batched definition query, not a per-column/student query.

- Traditional original columns are editable only when the server-resolved window is open, the existing Advanced class/actual-term status is OPEN and the cell is neither carried nor conflicting. Other occurrences remain visible/read-only with localized reasons and their original-page link.
- The new action takes `exam_id`, permanent `student_id`, section, subject and value. It never accepts a dynamic-component mapping as occurrence identity, creates another assessment, copies results or changes a distribution.
- Both entry interfaces update the same `exam_result2` row. Response includes its original result ID and server-confirmed components/total from the unchanged shared calculator.
- The UI updates the accepted cell, configured summary and total only after success; zero is visible, missing stays missing. Invalid/expired writes do not update totals. Expiry is rechecked on every save; a window denial disables the stale input and removes ineffective retry controls. Unsaved values remain explicitly marked with a leave-page warning.
- Duplicate events are blocked in flight per student. Serialized repeat requests retain one result row. The new action creates one in-app notification only when the value actually changes; unchanged retries add none. Existing legacy notifications/push code is not moved into the writer or double-dispatched.
- Traditional legacy mark screens now show the same localized window reason, disable mark/single/bulk controls when closed, reapply this after AJAX row replacement, and expire an open screen using a server-derived interval. This is usability only; the shared server policy remains authoritative. No browser timer can grant permission.

Manual components remain independent. Existing numeric dynamic sources and class/actual-term status behavior are preserved. There is no new per-component status store, no reinterpretation of `LEGACY_HOMEWORK` as a manual field and no new row-sum/replacement policy. Original aggregation remains average for oral/quiz sources and maximum for `LEGACY_EXAM`, with existing rounding, zeros/nulls and report formulas.

## 4. Admin modal behavior and persistence

Create/Edit both use the same fields and styles. Edit loads only the clicked original definition. Closing/reopening resets to the correct definition. The create form is not overwritten when Edit opens. Start/end, mode, subject, maximum, duration, required work, notes, exact ID and section round-trip without timezone shifts.

XHR submission includes Web CSRF, prevents duplicate in-flight submits, disables only the submit button while busy, and shows escaped server errors inside the modal while retaining entered values. Success JSON/flash is returned only after the database transaction commits, then reloads the list via GET. Non-JS POST/redirect validation preserves old input; the matching modal is restored when JavaScript becomes available. No automatic retries are performed after an ambiguous network failure.

The old forms had multipart encoding but no Admin attachment input. This task adds no new upload contract and never clears `file`, selected questions or submitted files on edit. Notes are limited to the existing database capacity rather than silently truncated. Original all-sections expansion and explicit assessment-equivalence creation remain authoritative.

## 5. Verification

All writes were tested using SQLite `:memory:`, disposable fixture schema and fake/private storage. No school assessments, assignments, results or accounts were created for QA. No school migrations or synchronization were run.

| Check | Result |
|---|---|
| Focused/regression PHP suites | **141 tests / 3,193 assertions PASS**: Gradebook safety, Admin V2, templates/context, follow-up, timetable authority and Teacher timetable views. |
| Timing | Before, exact start, within, exact end, after end, UTC/local boundary; null/invalid/impossible/reversed dates. |
| Writer routes | Traditional single/AJAX/bulk and modern correction denial; batch rollback, valid zero/max, null/overflow rejection, exact IDs and duplicate original-row protection. |
| Synchronization | Original screen writes zero, Gradebook reads same result ID; Gradebook writes maximum, original screen renders it; unchanged repeat adds no new result or notification. |
| Authorization | Wrong room/subject/student, transferred membership, Admin-on-Teacher route, locked Advanced context; existing continuity/carried/conflict and historical regressions. |
| Automated compatibility | Expired automated legacy correction still follows its existing route; Advanced rejects it; old-year writes remain denied. |
| Admin modals | Both active child views render; strict date round-trip, JSON/redirect validation, restored input, bounds/99-char notes, type/section/year/mode/max safeguards, attachments/result snapshots and confirmed rescheduling. |
| Frontend | **Nine harnesses PASS**: new modal population/submission, original-occurrence save/expiry, legacy-window controls/expiry, plus six prior save/status/continuity/Admin V2/distribution/template harnesses. |
| Blade/PHP/encoding | **56** relevant Admin/Teacher/shared views compile/lint in isolated storage; task PHP lint, UTF-8 without BOM and introduced-text mojibake scan pass; `git diff --check` passes. |

Concurrency safeguards reuse existing student/exam/result locks and transaction retries. Tests prove repeat-request identity, duplicate detection and atomic rollback. **A genuinely concurrent MariaDB write/load test was not run**; SQLite fixture tests do not certify production row-lock scheduling or deadlock behavior. No unique-index/schema change was made.

### School preservation

Read-only PDO transactions compare complete before/after manifests for **166 tables / 326,261 rows**, table schemas, triggers, existing Gradebook JSON/status bytes and protected shared files, including `.env.example`. Identical SHA-256:

`64f6404c4cbb36128be998d8b06d446ec270b72f2e36a54f4a664716265594ce`

Evidence/logs are in the private task-specific `C:/Users/Lenovo/.codex/backups/gradebook-windows-*` directory, outside the repository/web root. Fingerprints are not a restorable database backup. Marks, reports, financial records, student/user identity, placements, timetable, equivalence records and migration ledger were not changed.

### Browser acceptance and limitations

Browser access was attempted; the tool returned **No browser is available**. Real authenticated clicks, modal placement/scrolling at narrow widths, actual DataTables/Bootstrap rendering, console/network and device testing remain pending. Feature tests execute real HTTP routes/controllers and child views in an isolated shell; separate existing Admin V2 regressions still exercise the real shell. This is not claimed as live browser acceptance.

The local active year has no modern assessment definitions. Manual QA should use a disposable clone, not school data: create traditional exam/quiz before start; verify column/read-only reason; test inclusive start/end, old/new entry synchronization, original result ID, expired stale-page rejection, all-sections scoping, Edit/Create isolation, failed validation retention, repeated clicks, notes/seconds and short-viewport footer reachability. Check unchanged dynamic entry and Student historical display too.

New Gradebook notifications are transactional in-app records; live FCM delivery was not exercised or newly dispatched from this action. Existing legacy push delivery remains untouched. Browser in-flight prevention is not a new server-side idempotency ledger for independently repeated Admin create requests; after an uncertain response, refresh/check the list before manually retrying. Existing global group allocation and legacy automated correction internals were not redesigned.

## 6. Files changed

- `app/Services/AssessmentEntryWindow.php` (new shared parser/policy).
- `app/Services/AdminAssessmentInput.php` (new validation/impact boundary).
- `app/Services/TeacherAssessmentService.php` (traditional enforcement).
- `app/Services/TeacherGradebookAssessmentColumns.php` (shared eligibility and batched creator identity).
- `app/Http/Controllers/DashboardController.php` (create/edit validation, post-commit JSON/redirect response and section/year scoping).
- `app/Http/Controllers/Teacher/TeacherGradebookController.php` (original-result action).
- `app/Http/Controllers/TeacherController_New.php` (bypass removal, correction and traditional-definition protection).
- `routes/teacher.php` (one protected occurrence-save route).
- `resources/views/admin/quizes_of_room.blade.php`, `resources/views/admin/exams_of_room.blade.php` (only modal/script integration).
- `resources/views/admin/partials/assessment_modal.blade.php` (new shared modal).
- `public/assets/admin/css/assessment-editor.css`, `public/assets/admin/js/assessment-editor.js` (new scoped assets).
- `resources/views/teachers/gradebook/index.blade.php`, `assessment_columns.blade.php`, new `legacy_window.blade.php` in that directory.
- `resources/views/teachers2/teacher_exam_student.blade.php`, `teacher_quize_students.blade.php` (shared window notice only).
- `public/teachers_2/assets/js/gradebook-occurrences.js`, `assessment-window.js` (new scoped assets).
- `resources/lang/ar/assessment_entry.php`, `resources/lang/en/assessment_entry.php` (new localized messages).
- `tests/Feature/GradebookSafetyTest.php` (approved-window fixture updates and focused regressions).
- `tests/Frontend/assessment-editor.test.js`, `gradebook-occurrences.test.js`, `assessment-window.test.js` (new harnesses).
- This report.

No Phase 2C, new schema, grading formula, report recalculation, manual lock policy, global timezone change, financial logic, migration, commit, push or deployment. Unrelated unfinished work is preserved. **Synchronized traditional entry is code/test complete within this contract; browser and real concurrent-database acceptance remain pending.**
