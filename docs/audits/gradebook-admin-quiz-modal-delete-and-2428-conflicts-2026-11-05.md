# Focused Admin assessment modal, deletion and quiz 2428 correction

Date: 2026-11-05. Laravel 7.30.6 / PHP 7.4 / MariaDB.

## Result and evidence boundary

Implemented focused fixes for section-selection clarity/validation, deletion feedback, misleading continuity wording and traditional Teacher entry context. Original assessment/result identities, equivalence decisions, student membership, academic calculations and school data are unchanged.

Reviewed the assessment-window, comprehensive-unification and quiz-2423 reports against current source and actual local SELECTs. Browser discovery returned no available browser. The new modal screenshot was not available; changes follow the active Blade/JavaScript and existing Admin/Teacher styles, not an invented screenshot. Automated HTTP/DOM/JavaScript tests and actual-data controller rendering are distinguished from authenticated live-browser acceptance below.

## 1. Create Quiz / shared Exam modal

### Confirmed cause and defaults

The active quiz route is `/SMT/admin/class/room/quizes/{room_id}` -> `DashboardController::room_quizes` -> `admin.quizes_of_room` -> `admin.partials.assessment_modal`; the exam route shares the partial and editor script. Both extend Admin V2.

Actual-data render for section 130 confirms the create form's hidden class **1**, reference section `my_room_id=130`, question picker **2**; its default specific selection is section **130**. Subject 406 belongs to class 1 and is an available option. Subject/mode initially require selection; they are not inferred from another modal. Edit population is scoped to the Edit form. There is no Select2 initialization for these native controls.

The old multiple select placed sentinel **0** (All permitted sections) beside real section IDs. Its initial selection was the current section; an error restoration could select 0. Nothing made the all-versus-specific choice exclusive, and the server silently expanded a mixed selection through its all-sections branch.

**Confirmed, reproducible source of the generic red context error:** account **414**, role **104**, has **zero matching `classes_room_role_exams` entries** for the current class-1/year-6 sections. The old all-sections expansion therefore produced an empty destination list, and `validateAssessmentCreationContext()` rejected it with generic `context_invalid`. This is not a subject-406 mismatch. An isolated request with that same absence of permission mappings reproduces the failure. The owner's exact historical failing request was not captured, so this evidence does not assert that every possible red banner had this cause.

Legacy authorization distinction is preserved: `Gate::before` grants type-2 Admin abilities, but the existing **all-sections expansion** separately uses these section-permission rows. Specific-section creation already uses class/year/subject validation under the Admin routes. This pass does not reinterpret full Admin access as permission to bypass the all-sections table, add permission rows, or narrow the existing specific-selection contract.

### Correction

- Display the authoritative current section above the selector.
- Separate All permitted sections into an explicit checkbox, with its actual scoped count. The native multiple select contains only real sections, marks the current section, and explains multiple selection. No plugin dependency added.
- Checking All disables the specific select, so normal form serialization submits only `room_id[]=0`. Unchecking restores specific selection. Destination count updates in a live status area. Default remains the current section.
- If the all-sections permission scope is empty, disable that checkbox and explain how to choose specific sections or request legitimate permission configuration. **For account 414 this option remains unavailable intentionally; no rights were invented.**
- The backend rejects mixed `0 + individual IDs`, malformed selections and an empty allowed scope with localized `room_id` feedback. Exact active-year/current actual-term/reference section/class/subject validation remains. An incompatible subject now receives a specific `lesson_id` message; no context validation is weakened.
- Existing individual, multiple and properly configured all-sections requests still create original per-section definitions and explicit equivalence memberships through the same transactions/services.
- AJAX errors remain in the modal and appear beside the affected field, without clearing valid values. HTML validation redirects retain entered values, reopen the marked modal and reconstruct field feedback. Edit resets its own errors/approval only. In-flight forms cannot switch targets; successful submissions remain disabled until navigation to prevent another click during reload.
- Removed the two pages' old loop assigning `window.onload` toast callbacks for each validation error. It overwrote earlier messages and depended on legacy `notif`; it was not reliable scoped deletion feedback. Modal failures now use the modal alert; unrelated HTML failures use an escaped, dependency-free page alert.

Single/multiple specific requests remain unchanged. All-sections sentinel requests retain their existing permission intersection. Replayed independent POSTs are not deduplicated by title/date; such a rule would confuse legitimate independent assessments. The UI prevents duplicate in-flight/reload-gap submission; no new database/session idempotency system was introduced.

## 2. Deletion confirmation

### Exact credential and failure

Active route: POST `/SMT/admin/class/room/exam_quize/delete`, named `exam_quize.delete`, under existing Web/CSRF/auth/roleadmin middleware -> `DashboardController::exam_quize_delete`.

**The established credential is `Auth::user()->view_password`, the account-specific legacy stored deletion code.** `admincontroller::user_store` stores the submitted account password both as a hash in `users.password` and separately in `view_password`; account update paths can update the latter. It is not a global PIN/token, and the delete action did not call `Hash::check` on the current login hash. It can differ from a subsequently changed login password.

Read-only verification for account 414 found a configured code and confirmed that it currently matches its login hash. Only booleans were retained in private evidence; no credential/hash value was printed in the report, browser output or logs. No account was reset or changed. Therefore a wrong current password is **not** the demonstrated explanation for that account, and the credential mechanism was not silently replaced.

The old delete form submitted as a normal POST, not through the shared assessment AJAX handler. Wrong-code responses flashed an error/redirect; retained-data guards threw validation errors. The modal did not show those errors inline or reopen its target after redirect. The page's legacy toast mechanism was unreliable. **Quiz 2428 has equivalence memberships, so its deletion is legitimately blocked even with the correct code and zero results.** The same applies to 2423. No real assessment was deleted to test this.

### Correction and safeguards

- Shared `admin.partials.assessment_delete` for quiz/exam: clear account-code label/help, original assessment name, scoped alert, accessible controls, native POST fallback and the existing responsive modal CSS.
- Existing code source preserved; validate nonempty string input and use `hash_equals` instead of loose equality. An absent stored code cannot authorize deletion via an empty submission. No password-hash migration or authentication change.
- Explicit existing `delete_quize` / `delete_exam` authorization is checked in the action; type-2 Admin's existing Gate behavior and route restrictions remain unchanged.
- The entered secret is removed from request input before further errors; validation responses never flash it. HTML recovery stores only the assessment ID plus errors, never the code. No new logging of request/credentials. The client clears the code after completion and on modal close.
- The definition is still locked and `AssessmentResultSafety::assertDeletable` runs before deletion/file access. Results, placeholders, student uploads/submissions and equivalence memberships continue to block deletion. The impossible dependent-file delete loop below that guard is no longer present. Existing deletion of an otherwise deletable definition's own handout remains; this does not authorize deleting student submissions.
- Success is returned only after transaction commit. JSON requests receive `success/message`; HTML callers retain redirect/flash. Wrong/missing code and protected assessment failures receive localized 422 errors; HTML errors reopen the delete dialog without a secret.
- The shared frontend now handles delete POST/CSRF and visible JSON errors, permission denial, not found, expired session/token, an HTML login response and generic server failure. It does not expose raw server internals. The existing global CSRF handler still redirects to login; that HTML response is recognized as session recovery rather than success. No global error-handler change.

Safe alternative for a protected assessment: keep it and request Admin review. No new archive, forced delete or override was invented.

## 3. Exact quiz 2428 findings

Actual local read-only inspection around 21:12 +03:00:

| Item | Finding |
|---|---|
| Active year / current actual term | **6 / 20**, 2026/2027, first term belonging to year 6. |
| Original definition | **2428**, `مذاكرة ف11`, type **2**, traditional `is_file=1`, `has_traditional=0`, Admin creator **414/type 2**. |
| Academic context | Class **1**, section **130**, subject **406 (معلوماتية)**; consistent room/subject/year/term context. |
| Original maximum / duration | **50 / 40 minutes**. |
| Window | **2026-11-04 21:03:16 -> 2026-11-12 21:03:21**, seconds retained; currently ongoing and entry-eligible at inspection. |
| Effective clock | Existing `Asia/Riyadh`, UTC+03:00, matching applicable Damascus local time; not changed. |
| Teacher responsibility | Teacher **166**, account **1836**, authoritative current schedule **4122** for room 130 / lesson 406 / year 6 / term 20. |
| Eligible roster | **20** students. |
| Results / placeholders | **0** for 2428; no results in its equivalence group at inspection. |
| Student uploads | **0** for 2428. |
| Explicit equivalence | Five members, IDs **2428-2432**, sections **130, 131, 154, 155, 158**, identity `074f8dd4-3c68-4db0-b6fd-ac83fb45da4f`. Context/type/maximum agree. This is a different original identity from quiz 2423's group. |
| Continuity | **19 missing/editable**, **1 conflict/read-only**. Missing does not require a placeholder. |
| Traditional vs Advanced | Same per-student decisions; no whole-quiz denial. Manual status OPEN; original entry is independent of that lock. |

### Genuine conflict: student 1101

The exact first failure is unchanged from 2423: `AssessmentContinuityService::resolve()` requires one active target-room placement for a verified equivalent context. Enrollment **1786** says room **130**, updated September 17. Active placement **1367** says room **131**, effective August 25, no end date. The legacy same-grade newer-enrollment compatibility rule admits this student to the current roster, but `$active->count() !== 1` finds **zero** target-room active placements for continuity. No duplicate result, prior earned equivalent result, missing placeholder or name similarity causes this conflict.

Private `classification-before.json` and `classification-after.json` enumerate only the 20 target student IDs/states and relevant context evidence, outside the repository/web root. No unrelated student personal data is included in the report.

### Presentation correction, not relaxed protection

Previously `gradebook.continuity_row` always printed `carried_read_only`, even for a conflict with no saved mark. That incorrectly claimed an original mark existed, beside a generic ambiguous-result message. The result was intimidating but **row-scoped**, not a newly introduced global roster block.

Added read-only reason metadata (`placement_context` versus `assessment_context`) to the **existing same conflict decision**. No state, membership, equivalence, write eligibility or calculation rule changed. The row now explains that this student's enrollment requires Admin review and that other eligible students remain writable. The carried-original wording is used only for an actual carried result. Advanced uses the same reason-aware badge.

Actual-data rendering after the fix confirms 20 roster rows, one conflict, authoritative class/section names, the placement-review message and no false carried-mark claim. Original 2428 results remain zero. Isolated tests prove another independently defined quiz with the same title/times retains its own result and is not automatically treated as equivalent.

### Approval-gated remediation, not executed

Before changing student 1101, confirm the intended room and effective movement date, compare transfer events and room-bound academic records, and approve a narrowly scoped reconciliation plan. If room 130 is confirmed, preserve the prior placement interval and record an authorized transition/new active placement through a controlled audited path; do not simply overwrite placement 1367 or fabricate result/equivalence rows. If room 131 is correct, reconcile the enrollment projection instead under explicit approval. Recheck affected history and fingerprints in that separate operation. **No school placement, enrollment, transfer event or mapping was changed here.**

## 4. Teacher class/section context

Both traditional operational views now include `teachers.gradebook.entry_context`. It displays the original assessment title, class name from the server-loaded room relation, section name, subject name, original maximum and exact start/end timestamps. Names do not come from URL labels or guessed IDs.

The shared header uses the existing blue/neutral Teacher language with a small RTL definition-list grid, three columns desktop, two mobile and one at very narrow widths. Text can wrap; no fixed-width child. Removed the old duplicate timing/title block and its commented markup. The filter's obsolete negative top offset/fixed 300px width no longer competes with the header. Existing routes, hidden IDs/maximum, entry-window notice, original result inputs and AJAX save behavior remain.

## 5. Verification

- Full isolated regression: **158 tests / 3,663 assertions PASS**. Final five new focused cases: **166 assertions PASS**. SQLite `:memory:` and private test storage only; no school create/edit/delete requests.
- Coverage: valid single, multi and permitted-all quiz/exam creation; all-scope absent; mixed sentinel rejection; wrong subject/class/year/room; no current term; old-input preservation; original explicit equivalence; code versus differing login password; missing/wrong/non-string/unconfigured code; secret not flashed; native deletion failure recovery; isolated successful deletion; retained results/files/mappings; guest/Teacher/Officer boundaries; forced CSRF rejection; row-only placement conflict; independent results; current context labels; existing windows/AJAX/automated/history regressions.
- **10 frontend harnesses PASS**. Expanded assessment editor coverage includes scope/count/disable states, modal target reset, field errors, native serialization contract, CSRF, repeated in-flight/reload-gap protection, rescheduling confirmation, delete retry and session/permission/404/5xx/HTML-login feedback. These are JavaScript fixtures, not a real browser or transport trace.
- **63 Blade views compiled/PHP-linted** in disposable storage; changed PHP/Blade and JavaScript syntax checks pass. UTF-8 without BOM; no newly introduced mojibake. `git diff --check` passes (command-local CRLF warning suppression where needed, no Git configuration change).
- Actual school PDO SELECTs used a **read-only transaction**. Controller/resolver/HTML checks supplied explicit authorized actors in a private CLI context, not a browser login: Admin page rendered through the real Admin V2 layout after supplying the error bag normally injected by Web middleware; Teacher child rendered with the isolated shell. Hidden create context is class 1/reference section 130; current default is 130; subject 406 is available; unavailable All is disabled; one delete form exists. Teacher context/conflict output is correct.
- No browser was available, so authenticated clicks, Network/console, desktop/mobile pixel layout, native OS multi-select ergonomics and login/session transitions remain manual acceptance, not claimed verified.
- Before/after school/config manifests match: **166 tables / 326,325 rows**, schemas/triggers, operational Gradebook JSON/status files and protected sources including `.env.example`, Config/Read/Status/template services and route/migration sources. SHA-256 **`b3e769e4859de5e82e94862f8bf8e0facba596890f7b1d7f4717f24ba8e20f2d`**. Private evidence: the task-specific `gradebook-2428-*` directory outside repository/web root. Fingerprints are not a restorable database backup.

No school marks, definitions, results, files, accounts/credentials, placements, enrollment, assignments, reports, financial records, notifications or migration ledger were written. No operational JSON/status write, migration, route/global authorization change, commit, push or deployment.

## 6. Files changed in this pass

1. `app/Http/Controllers/DashboardController.php`
2. `app/Services/AdminAssessmentInput.php`
3. `app/Services/AssessmentContinuityService.php` (reason metadata only)
4. `resources/views/admin/quizes_of_room.blade.php`
5. `resources/views/admin/exams_of_room.blade.php`
6. `resources/views/admin/partials/assessment_modal.blade.php`
7. New `resources/views/admin/partials/assessment_delete.blade.php`
8. `resources/views/gradebook/continuity_row.blade.php`
9. `resources/views/gradebook/continuity_badge.blade.php`
10. `resources/views/teachers2/teacher_quize_students.blade.php`
11. `resources/views/teachers2/teacher_exam_student.blade.php`
12. New `resources/views/teachers/gradebook/entry_context.blade.php`
13. `resources/lang/ar/assessment_entry.php`
14. `resources/lang/en/assessment_entry.php`
15. `public/assets/admin/css/assessment-editor.css`
16. `public/assets/admin/js/assessment-editor.js`
17. `tests/Feature/GradebookSafetyTest.php`
18. `tests/Frontend/assessment-editor.test.js`
19. This new report. Existing reports, `.env.example` and other unfinished work preserved.

## 7. Remaining acceptance / decisions

1. On a disposable clone, test authorized Admin Create/Edit quiz and exam: current default, one/multiple sections, configured All only, changing modes, field-level errors, valid value preservation, cancel/reopen and fast duplicate clicks. Check RTL, narrow width, short viewport and all scroll/footer controls.
2. Do not grant new section permissions merely for QA. Account 414's unavailable all-section scope needs legitimate school permission configuration or a separately approved policy alignment; specific selection remains available under its existing rules.
3. In disposable fixtures only, test missing/wrong/correct stored deletion code, results/placeholders, uploaded submission and equivalence protection; inspect Network, inline errors, native POST fallback, code clearing, expired session/CSRF and visible success. **Do not delete real 2428 or other school assessments to test.**
4. Teacher 166: read-only inspect 2428's class/section/subject/title/maximum/dates, 19 editable rows and one specifically explained conflict. In a disposable clone test successful first/repeated marks, Advanced agreement, expired/unauthorized errors, file filters and automated flows. Do not bypass student 1101's protection or fabricate school marks.
5. Browser acceptance and approval-gated school-data reconciliation remain separate from the completed code fixes. No full production/browser/concurrency certification is claimed.
