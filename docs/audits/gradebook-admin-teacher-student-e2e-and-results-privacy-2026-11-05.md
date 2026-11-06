# Traditional assessments: Admin / Teacher / Student acceptance and privacy

Date: 2026-11-05. Laravel 7.30.6 / PHP 7.4 / MariaDB. Source and school data, not URL similarity, establish relationships.

## Executive result

Implemented focused Student discovery, traditional-result rendering, publication/privacy and card corrections. Retained the previous seven-student continuity fix, original identities, timetable responsibility, windows, historical protection, calculations and deletion restrictions.

**Verified:** isolated Admin-create -> Teacher-discover/save/edit -> Student-list/detail for quiz and exam; actual-data controller rendering through the real Student layout; false/true publication behavior; no school data/config changes.

**Not certified production-ready:** no authenticated browser was available; real concurrent MariaDB mutation tests were not performed. The legacy mobile API still has an explicitly deferred authentication/IDOR exposure. Several older non-main Student routes also have pre-existing unsupported view contracts; these are not represented as successfully repaired main assessment flows.

Reviewed the assessment-window/synchronized-entry, comprehensive unification, quiz-2423, Admin-modal/2428 and continuity/safe-deletion reports against current code. Their earlier publication/discovery limitations are superseded only as described below. No existing report was edited.

## 1. Phase A findings

| Severity | Evidence / defect before this pass | Disposition |
|---|---|---|
| High | Student main lists selected definitions only through `exam_result2` participation. An Admin traditional original could be writable for 20 current students yet invisible until a participation/result row existed. | Read-only, section/current-year/actual-term traditional discovery; no placeholder insertion. Automated participation remains explicit. |
| High | `view_main_exam` required `selected_ques`, dereferenced absent results and redirected traditional marks back with `no_questions`. | Owned, context-checked traditional summary; no invented questions or redirect. Automated question review remains separate. |
| Critical | Global flag covered main lists but not direct Web result details, dedicated marks, Academic Record, report cards or medals. | Central policy, server-side grade redaction/blocked responses, approved broader scope below. |
| High | Direct modern/legacy result review ignored `show_result` and completion state. | Require the existing completed/published state in addition to the global switch. |
| High | First Teacher save without a placeholder relied on the DB `show_result` default, unlike participation creation which derives it from `has_traditional`. | New rows explicitly use the same publication choice; existing choices are not reset on edit. |
| High | Student main list methods trusted the URL room, although middleware checked only student identity. | Validate the authenticated student's current membership, exact active year and actual term before discovery. |
| High | Certificate template/detail actions selected arbitrary `Certificate::find(id)` rows. | All seven existing certificate render actions require the authenticated student's certificate, then apply the privacy gate. |
| Medium | Current-year mobile main lists selected the first globally flagged term, potentially an older year's term. | Scope those two lookups to the active year; empty term returns the existing empty-list shape. Mobile medals receive equivalent year/term scoping and privacy/publication checks. |
| Medium | Web modern result detail labelled actual term ID 20 using `id == 1 ? first : second`. | Resolve the stored `Term_year` name instead of treating a primary key as a semester number. |
| Medium | Hidden/blank/earned zero were conflated; cards were crowded and grade colors implied success for every result. | Safe card DTO states and compact neutral, labelled results. |
| High | Future Academic Record rows were hidden in the list but could be selected by owned placement ID directly. | Detail rejects a placement beyond the globally active year. No future row is deleted. |
| Critical, deferred | Legacy mobile routes accept route/input student IDs without a required authenticated student principal. `student.operational` checks lifecycle and, only when a Student session exists, ownership. | **Not fixed**, per explicit owner instruction. The flag is publication control, not authentication. See section 10. |

## 2. Complete active route/data-flow map

Web uses the existing session/web guard and Web CSRF. Teacher/Admin authorizations remain their existing route middleware and service checks. Student routes use `rolestudent`, which requires an active type-0 account and the account's permanent `student_id`; another URL/input student ID is denied by its existing redirect/logout behavior, not silently accepted.

| Stage | Routes and implementation | Source / view / client contract |
|---|---|---|
| Admin quiz/exam lists | GET `/SMT/admin/class/room/quizes/{room}`, `/exams/{room}` -> `DashboardController::room_quizes/room_exams` | `Exams2`/`exams2`, exact active-year room/current actual term; `admin.quizes_of_room`, `admin.exams_of_room`, Admin V2 layout. |
| Admin create/edit | POST `/class/room/quize/store`, `/exam/store`, `/quize/update`, `/exam/update` under `/SMT/admin` | Existing `AdminAssessmentInput`, section permission intersection for All, original per-section definitions, transactions and explicit `AssessmentEquivalenceService::createdTogether`. Shared `assessment_modal`, `assessment-editor.js/css`. No writer rewrite in this pass. |
| Teacher discovery | GET `/SMARMANger/dashboard/teacher/teacher_quize/{room}/{teacher}/{lesson}`, `teacher_exam/...` -> `teacher_quize_mark/teacher_exam_mark` | Current-year actual-term `CurrentTeacherAssignments` timetable authority; original IDs; traditional/automated tabs; `teachers2.teacher_quize_mark/teacher_exam_mark`. URL Teacher ID does not override authenticated identity. |
| Traditional roster | GET `teacher_quize_students/{room}/{teacher}/{lesson}/{exam}`, `teacher_exam_students/...` | `CurrentStudentMembership`, real current roster plus optional original rows, `AssessmentContinuityService`; `teachers2.teacher_quize_students` / singular `teacher_exam_student`. No GET participation writes. |
| Teacher save/edit | POST `student_save_mark3`, `student_save_mark_quize`, `student_save_mark2`, modern bulk and traditional correction routes | Existing `TeacherAssessmentService`, original maximum/window/current-year/current-actual-term/timetable/student context, locks/transactions and original result lookup. `legacy-grade-entry.js`, `assessment-window.js`. |
| Advanced original entry | GET `gradebook/{class}/{room}/{subject}`, POST `gradebook/assessment/save` | Same `exam_result2` originals and shared writer; `GradebookReadService`, occurrence projection/scripts. No parallel grades or changed formulas. |
| Student assessment hub | GET `/SMARMANger/dashboard/student_exam` -> `student_exam` | Existing `students.student_exam`, real shared `students.layouts.app4`; active placement preferred; existing non-future historical fallback retained for the hub only. |
| Student main lists | GET `/dashboard/student/room/main_quizes/{room}/{student}`, `main_exams/...` under `/SMARMANger` | `StudentAssessmentReadService`, `StudentResultsVisibility`; active-year membership and actual term; `students.new_student_quizes/new_student_exams`, shared `assessment_list`, existing upload modal scripts. |
| Student original result | GET `/dashboard/student/view/main_exam/{exam}` -> `view_main_exam` | Own `exam_result2`, exact original class/section/lesson/actual term, real current/historical placement context, no future year, completed + `show_result=1` + global flag. Traditional: new `students.assessment_result`; automated: existing `new_view_main_exam2`. |
| Student automated activity | GET `student/start_main_exam/{exam}`, POST `student/exam/save_main_exam` | Existing question/timer/scoring/participation contract. A traditional definition or a different actual term cannot be submitted through this automated Web path. Privacy does not disable legitimate automated participation. |
| Legacy lesson result | GET `student/view/exam/{exam}` -> `view_exam` | Separate `lesson_teacher_room_term_exam` / `exam_result`, account's own result and publication gate. Not inferred equivalent to `exams2`. |
| Dedicated results | GET `student/results/{student}` | Current membership resolver, year/room-scoped `students_marks`; blocked without grades when disabled. |
| Academic Record | GET `student/academic-record`, `/{placement}` | Owned placements; list metadata remains available; detail selected stored year/room/all actual terms, no future placement. Grade fields redacted while file/history/attendance metadata remains available. |
| Report/award output | `student/view/report/card`, `student/medals/{student}`, seven existing certificate template routes | Server-side gate before grade-bearing report/award output, including browser-side printable/PDF generation. Certificate-ID ownership enforced even when publication is enabled. |
| Mobile API | `/api/dashboard/student/main_exam/...`, `main_quize/...`, `exam/view_quize/...`, `exam/view_test/...`, medals/report and legacy lesson reads | Existing `Api/websitecontroller`, existing `student.operational` boundary; centralized flag reader, existing blocked response shape and scoped JSON redaction. **No authenticated mobile principal was added.** |

`exam_result2.user_id` remains **students.id**, not users.id. Student identity always comes from the Web account, not a submitted result/student ID. Original assessment/result IDs are preserved on edits, carry and display. No service infers equivalence from titles or dates.

## 3. Publication/privacy contract

### Before

`config/student_results.php` maps `student_pages_enabled` to `env('STUDENT_RESULTS_PAGES_ENABLED', false)`. Missing means **false**. Web main quiz/exam lists used a full-page blocked response. Several mobile list/detail/report methods already had a blocked JSON response. Other Web grade surfaces were outside that implementation, and direct result methods ignored per-row publication.

### Approved scope in this pass

The owner explicitly approved hiding grades across all Student Portal grade-bearing surfaces, including history, reports, medals, direct details and JSON, while keeping normal navigation and non-sensitive metadata. The owner explicitly excluded changing the mobile authentication contract.

`StudentResultsVisibility` is the central config-only reader and completed/published-row predicate. It does not re-read `.env` to override cached settings. Existing config defaults, permissions and stored data remain intact.

| Surface | False | True |
|---|---|---|
| Main quiz/exam cards | Keep authorized subject/title and required activities; no earned result/link/ID/value; neutral hidden state. | Own results only when completed and `show_result=1`; distinguish unentered, zero, earned, hidden and ambiguous. |
| Original direct details | Neutral blocked HTML or existing-style blocked JSON, no result or answer-review data. | Own original/context plus per-row publication required. Traditional detail does not require questions. |
| Dedicated marks / report card / medals | Block before grade-bearing output. No grade-bearing PDF/print markup. | Existing authorized stored records, with assessment medal publication checks retained. No recomputation or retrospective import. |
| Academic Record list | Year/class/section/status metadata remains accessible. | Same historical scoping. |
| Academic Record detail | Clear raw mark/result/report models from view data; redact displayed components, term/year values, assessment grades and report outcome. Retain attendance, subject/title/year/section and file/certificate metadata. | Existing stored academic records; original assessment rows also respect completion/publication. |
| Certificate render/download pages | Block grade/award output server-side. Listing metadata is not a grade release. | Same owner-only certificate ID and existing rendering. |
| Lesson/homework content | Do not assign earned result properties while disabled; do not block homework/content/upload functionality. | Existing completed/published values. The old lesson-detail aggregate is withheld when disabled. |
| Student header | Omit structured medal/mark/report notification types 3/7/9; suppress their foreground push rendering and remove raw payload console logging. | Existing notification behavior. Types 4/5 assessment notices contain assessment names, not stored numeric marks, in the inspected writers. |
| Mobile grade reads | Existing early blocked responses plus targeted recursive grade/award/answer-field redaction on related read responses. | Existing mobile response contracts; row publication is checked on direct result review. **This is not student authentication.** |

Student responses use `Cache-Control: private, no-store, max-age=0`; related mobile read responses do too. This prevents new HTTP caching, not recall of screenshots, already downloaded files, previously delivered push messages or an already-open page. Arbitrary manually written messages may mention grades; the policy does not censor unrelated free text. External/background push delivery and public files are not made private merely by a Blade flag.

### First-result publication compatibility

For a newly created result, the authoritative writer now explicitly sets `show_result = 1` when the original `has_traditional == 0`, otherwise 0, matching the existing optional-participation writer. This fixes bypass-by-missing-placeholder. An existing result's publication decision survives every mark edit, regardless of the current definition default. No school row was backfilled.

### Safe operational flag procedure

1. Owner authorizes the release/hide decision. Change only the deployed `STUDENT_RESULTS_PAGES_ENABLED=true` or `false` value through normal configuration management.
2. From the correct deployed project/runtime, run `php artisan config:clear` and then `php artisan config:cache` if deployment normally uses cached config. On this local stack the executable is `C:\php74\php.exe`. Do not assume editing `.env` changes a cached config.
3. Refresh affected PHP/long-running runtimes through the normal hosting procedure if necessary. Refresh existing Student tabs; previously obtained data cannot be revoked by a later flag change.
4. Verify an authenticated Student list, a direct result URL, history detail, report output and JSON with both release states. Keep an unpublished per-row fixture unpublished when the global flag is true. Verify Teacher/Admin entry independently.
5. Do not change result rows or publication flags to operate the global switch.

The actual school `.env` flag was **true** at inspection, config was not cached, and neither was changed. Fresh and cached Laravel `LoadConfiguration` tests use a private fixture cache: cached values win over a different environment value until the cache is rebuilt. Missing/null/invalid boolean values fail closed. Windows cache-path handling in that fixture is explicit; no project config cache was generated or cleared.

## 4. Student card before / after

Before: sequence number, mode badge, assessment-first hierarchy, four date/time/day/duration cells, requirement button and overloaded green result action. Missing and hidden results were coupled to legacy model/sentinel handling.

After: primary **subject**, secondary **assessment title**, labelled neutral result/state. No visible decorative sequence, date/time/day/duration grid or redundant mode badge. Required work and question download/upload capabilities are preserved in native expandable **details/files**, with the existing upload modal. Automated start/resume remains visible only for assigned, incomplete participation in the existing availability context.

The result styling is neutral dark-blue-on-light-blue, not universal success coloring; static foreground/background contrast is **10.08:1**. Actual zero renders `0 / maximum`; missing does not. Results unavailable for publication do not leave hidden numeric fields/data attributes/embedded result JSON in the cards. The card projection contains only display metadata and the permitted result, never a raw result model or answer blob.

Scoped compact CSS uses shrinkable columns, wrapping titles, a narrow-screen single column and existing RTL tokens. No Teacher/Admin card styling was changed. Real viewport/overflow metrics and native modal interactions remain browser acceptance, not claimed from CSS review.

## 5. Actual-data verification (SELECT only)

Fresh baseline: year **6 / 2026/2027**, actual current term **20**. The examples are two distinct chains, even though the same authorized Teacher can hold both responsibilities.

| Original | Context | Current roster | Original participation/results | Published completed rows | Finding |
|---:|---|---:|---:|---:|---|
| 2428 | class 1 / section 130 / subject 406 / term 20 | 20 | 0 | 0 | All eligible traditional students can discover it without a placeholder; previous continuity correction preserved. |
| 2424 | class 1 / section 131 / subject 406 / term 20 | 21 | 0 | 0 | November 8 start remains an intentional Teacher-entry restriction. |
| 2430 | class 1 / section 154 / subject 406 / term 20 | 20 | 0 | 0 | Same explicit mapping safeguards, no school result creation during inspection. |
| 2433 | class 2 / section 132 / subject 409 / term 20 | 20 | 5 | 5 | Actual Student-748 example is a separate original from the Informatics examples. Traditional detail needs no questions. |

For 2433, actual Admin list and Teacher 166's section-132/subject-409 list both contain the same original **2433**; the Teacher roster has **20** rows. Original result IDs are **42234-42238**. Student **748**, account **909/type 0**, owns original result **42234**. Its current placement is **1407**, year 6/class 2/room 132; closed prior placements **383** (year 5/room 94) and **1039** (year 6/class 1/room 131) remain untouched.

Actual-data controller/render checks use account 909 through the real `students.layouts.app4`, not a substituted shell. With config true: hub, main quizzes, empty main exams, traditional detail, Academic Record and historical detail 383 render. The quiz list has one card/one result link; direct 2433 returns `students.assessment_result`, not a redirect. With config false: the same card retains metadata with **zero result links**, the direct detail returns `students.results_blocked`, and history list/detail still render with redacted grade data. No school mark was printed or persisted in debug HTML.

The read-only console uses explicit authorized actors, not a browser login. No actual school Add/Edit/Save/Delete request was issued. Admin/Teacher/Student identity equality is checked with existing originals, while mutation acceptance is proven separately by isolated fixtures.

## 6. Tests and regression coverage

- Full isolated suite: **172 tests / 4,006 assertions PASS**. Focused acceptance cases also pass (including actual HTTP homework/summary redaction, cache behavior and preservation of assessment/question maxima).
- Both quiz/exam Admin POST creation, single/multiple permitted sections, exact original discovery, optional participation, first save, same-result-ID edit, zero, blank/out-of-range rejection, AJAX recovery and traditional/Advanced agreement.
- Existing inclusive start/end/seconds/server-clock tests, pre/post-window denial, atomic invalid-row rollback, historical originals and current-year/actual-term/timetable/student authorization.
- Student own assessment without placeholder, saved original detail without questions, separate quiz/exam cards, explicit automated participation, transferred carried zero, original publication and no receiving duplicate result.
- False/true flag, neutral direct JSON, no unique grade marker in HTML/attributes/JSON, cached versus uncached configuration, current-term changes, wrong section, wrong student, no own result, future placement denial, certificate-ID tampering and no read-side data mutation.
- All seven existing certificate render routes reject another student's ID; false state blocks the owner's render without entering the printable template. History redaction test retains attendance metadata while removing result/report values.
- Teacher entry and authorized Admin Gradebook remain functional when Student visibility is false. New result publication and subsequent existing-row decisions are both tested.
- Ten existing frontend JavaScript harnesses pass; **76 Blade views compile/PHP-lint** in disposable cache. Modified PHP passes lint, UTF-8 without BOM and `git diff --check` checks pass.
- The actual local CSS URL, including its focused cache-busting version, returns **HTTP 200** and contains the compact card rules. This static HTTP check is not authenticated browser acceptance.
- A reduced follow-up fixture lacked the already-existing real `show_result` column. Added that column only to its disposable schema; its transfer/identity/history regression now passes. This is not a migration or school schema change.

SQLite transactions/order/rollback tests are not real MariaDB concurrent-request proof. No claim of race-free legacy mobile/automated mutation is made. The existing shared Teacher writer retains its student/original/subject serialization and transaction retries; no new mark store or group-removal race was introduced.

## 7. Traditional / automated / legacy boundaries

- Web modern traditional discovery no longer depends on participation, but is restricted to Admin-created original file assessments in the authorized current section/term. No notification or participation is synthesized on a GET.
- Modern automated discovery still requires a real assigned result/placeholder. Existing automated entry/submission, timers, questions, grading and answer review are not replaced with the traditional summary.
- Web automated start/save reject a traditional original and a different actual term instead of offering an alternate path for changing a traditional Teacher-entered result. Existing automatic scoring is not recalculated or reweighted by this change.
- Reserved `Dynamic_Section_*` containers are not presented as ordinary public quizzes/exams. Their marks remain stored; no original or configuration is renamed.
- Explicit equivalent originals retain their IDs/group. Student carry consults the original result's publication state and never copies it into the receiving section. Stale-projection compatibility and real conflict protections remain in the existing shared resolver.
- Official stored mark/report JSON remains independent of automatic quiz aggregation/import; this task does not retroactively infer or change an official report's release from a quiz setting. Global false hides its grade-bearing output.
- Legacy `lesson_teacher_room_term_exam` / `exam_result` is a second system, not interchangeable IDs. Its result-detail gate and mixed-content grade projection are covered; no destructive normalization or new equivalence was attempted.

## 8. Preservation evidence

Before/after manifests match exactly: **166 tables / 326,335 rows**, all row-content hashes, DDL, triggers, operational Gradebook JSON/status files and protected source files including `.env.example` and Config/Read/Status/template services and existing migration/Gradebook route sources.

Manifest SHA-256: **`c77e1c47ec9f9b7309550360e4cc089f988e9a6c2cada73e2cd000d833cd976b`**.

The actual `.env` file hash also matches. Private ID/context/render-outcome evidence is under `C:/Users/Lenovo/.codex/backups/gradebook-student-e2e-4dc50af3d544482fbb427e03aedbc610/`, outside the web root/repository. Fingerprints establish equality, not a restorable backup. Render checks retain metadata/assertion outcomes, not school grade HTML.

No school marks, definitions, result IDs, accounts, enrollment, placements, transfers, equivalence memberships, reports, files, notifications, finance, schema or migration-ledger rows were written. No operational JSON/status write, migration, `.env`/`.env.example` edit, commit, push or deployment.

## 9. Files changed in this pass

1. `app/Services/StudentResultsVisibility.php` (new central policy).
2. `app/Services/StudentAssessmentReadService.php` (new read-only Student projection/context).
3. `app/Services/TeacherAssessmentService.php` (new result publication initialization only).
4. `app/Http/Controllers/studentscontroller.php` (lists, detail, privacy and ownership/context guards).
5. `app/Http/Controllers/Api/websitecontroller.php` (same policy, targeted JSON redaction/publication and actual-year term scoping; no auth change).
6. `resources/views/students/assessment_result.blade.php` (new traditional summary).
7. `resources/views/students/partials/assessment_list.blade.php` (compact cards/actions).
8. `resources/views/students/new_student_exams.blade.php` (matching concise description).
9. `resources/views/students/academic_record_show.blade.php` (hidden-grade notice; historical structure retained).
10. `resources/views/students/layouts/app4.blade.php` (structured grade-notification suppression/foreground payload logging).
11. `public/student/assets/css/student-portal-v2.css` (scoped compact cards/result contrast).
12. `resources/lang/ar/student_assessments.php`, `resources/lang/en/student_assessments.php` (new result states).
13. `tests/Feature/GradebookSafetyTest.php` (eight new acceptance/privacy cases; explicit published fixtures).
14. `tests/Feature/TeacherStudentFollowUpEligibilityTest.php` (fixture schema parity only).
15. This new report. Other unfinished work, continuity fixes, existing reports and `.env.example` preserved.

## 10. Remaining defects, decisions and browser acceptance

### Deferred security: legacy mobile identity

Some mobile routes are reachable as a guest using a student ID. An existing Student session is checked for a mismatched ID, but absence of that session is not authenticated ownership. Global false on verified result/list paths suppresses grades; global true does **not** make those routes secure against another caller choosing an ID. Do not describe this API as authorized merely because a database student is operational.

Owner-approved remediation is required: introduce a real authenticated mobile principal/token contract, derive student identity from that principal, preserve authorized parent-child access explicitly, deny arbitrary IDs, rotate/deprecate unauthenticated clients through a compatibility release, and add independent authentication/IDOR tests. Inventory write/answer/file endpoints too. No token/reset/account/schema change was made here.

### Legacy non-main paths and storage

- `/dashboard/student/room/exams/{room}/{student}` is an older lesson-table route reusing the modern list view without a full modern card/context contract; it is not linked by the active assessment hub. It remains blocked while grades are hidden, but normal enabled-mode legacy view compatibility is deferred rather than represented as a tested main flow.
- The declared `lecture_mark` action is absent, and older `lesson_detail`/`new_courses` references include a missing `students.layouts.app2`. They are legacy runtime debt, not newly built paths. The active hub uses main quiz/exam routes and current lesson pages; confirm any old bookmarks before retiring or restoring those routes separately.
- Legacy automated/API answer-review code performs its own computations and may have inconsistent score/term presentation; this pass did not change academic calculations or silently revive missing-question result contracts. Full mobile traditional detail compatibility is not certified by Web summary tests.
- Mobile lists retain their existing participation-driven contract. An unassigned traditional assessment can remain absent there until participation/a real result exists, even though the Web list can discover it. No fake result was added to hide that client-contract difference; changing mobile discovery needs a separate approved compatibility review.
- The existing automated timer/grace and retry contracts were preserved, not newly certified for all direct/concurrent mobile submissions. Future tightening requires an explicit compatibility review.
- Already-public static files and previously downloaded PDFs/push messages cannot be revoked by this server flag. Current generated report/certificate routes are gated; any separately hosted grade-bearing files need a dedicated protected-delivery/storage audit before claiming universal document confidentiality.
- Existing historical fallback hub metadata is not permission for current-year entry in an old section. Current main lists fail closed without actual active-year membership; history remains in Academic Record.

### Practical manual checklist

1. In a disposable clone, authorized Admin creates a quiz and exam for one section and an explicitly permitted multi-section set. Confirm IDs, maximum, actual term, date seconds, restored errors and double-click behavior.
2. Log in as the timetable-authorized Teacher, discover the exact originals, enter blank/zero/valid/out-of-range marks, reload and edit the same result ID. Compare traditional and Advanced; test precise start/end/expiry without using browser time as authority.
3. Student main lists: subject-first cards, correct original/title/section, no placeholder prerequisite for Admin traditional originals. Expand requirements/files; test upload modal and assigned automated start/resume without duplicate participation.
4. Test global false after cache rebuild: hub/history metadata remain; no earned mark in HTML, data attributes, JSON, direct details, report/award print/PDF or certificate-ID URLs. Attendance/homework/schedule remain available. Test per-row unpublished while global true too.
5. Test another student's IDs, another section/subject, historical/future placement, transferred equivalent and a genuine conflicting enrollment. No copied original result or widened authorization.
6. Desktop/tablet and 280/320/360/390/430px: cards, long Arabic names, grade state, details, modal scrolling and reachable actions; measure page overflow and inspect console/Network. No browser was available for this pass, so these checks are **pending**, not marked passed.
7. Compare scoped data/financial fingerprints before/after clone mutations. Test concurrent Teacher saves, deletion refusal and legacy automated uploads using disposable MariaDB transactions before broad rollout.

**Close-out:** focused Web defects fixed and automated/actual-data checks pass. Intentional windows, publication, continuity and safe-deletion restrictions remain. Browser acceptance, legacy mobile authentication and the explicitly listed legacy/storage contracts prevent an unconditional production-ready verdict.
