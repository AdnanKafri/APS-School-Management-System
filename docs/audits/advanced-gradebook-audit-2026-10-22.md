# Advanced Gradebook and Academic History Audit

Date: 2026-10-22, Asia/Damascus. Project: `C:\Users\Lenovo\Desktop\aladhamedu`.

## 1. Executive Summary

**Mode: read-only investigation and design, not implementation.** Only this report and `advanced-gradebook-evidence-2026-10-22.json` were created. No application, Blade, CSS, JS, migration, configuration, or academic/financial record was changed. No repair, aggregation, seeding, year activation, save endpoint, or production request was executed. Production URLs supplied in the specification were treated as route references, not accessed.

The system can be evolved incrementally. Keep the permanent student identity, the operational membership resolver, placement history, raw assessment results, and existing transcripts. The component that needs replacement is the Advanced Gradebook's mutable JSON configuration/name-based assessment adapter and its duplicated calculations, not the whole school system.

### Decision-ready conclusions

1. **Current Teacher authorization and roster resolution are substantially improved.** GET/POST require an active-year teacher/room/lesson assignment; saves require the student's current membership. Transferred-in students do not need a result row to appear. A real local read of the supplied `2/132/409` context produced 22 students, term 20, and a locked gradebook. The actual assigned teacher is 166. Parameters mean class ID, room ID, lesson ID, not teacher ID.
2. **Admin and Teacher gradebooks share configuration files, but not reliable assessment/calculation semantics.** Teacher dynamic columns look for `Dynamic_Section_{source}` exams of type 1. Admin dynamic columns look for `exams2.type = source`, e.g. 101. A Teacher-created dynamic result will not populate the matching Admin dynamic column through that query.
3. **Historical result survival is not the same as current visibility.** Safe transfers preserve source records, close/open placements, update `room_student`, and create empty target scaffolds. They do not carry an earned mark into the target room. Current Teacher gradebooks do not expose prior-room marks; cross-grade results must remain historical. Same-grade calculation/carry-forward is an unimplemented school policy.
4. **Security and retention fixes must precede UI redesign.** Most `/SMT/admin/gradebook` routes have `web,auth` only, including configuration writes and aggregation. They lack `roleadmin` and a gradebook capability check. Existing assessment-delete code physically deletes results. Dynamic saves lack numeric/range validation, result authorship, audit, uniqueness and a transaction covering container/result creation.
5. **There are confirmed calculation defects.** SQL `MAX(result)` is lexicographic because `exam_result2.result` is `VARCHAR(15)`. A read-only comparison found 775 student/room/lesson/term groups where numeric and string maxima disagree. Teacher legacy oral maps to type-2 exam results rather than the oral source; its homework/oral mapping can overwrite itself. Admin and Teacher dynamic mappings, legacy final-exam aggregation, weights and zero handling differ.
6. **Existing customization is real but limited.** Four subject/year JSON files define editable names, weights and dynamic columns. There is no reusable template library, version pinning, immutable application, assessment equivalence, publication snapshot, or reliable edit audit. The two gradebook table migrations are recorded as applied, but both physical tables are absent locally. Do not blindly rerun migrations or assume the DB models are authoritative.
7. **Local old data needs classified review, not bulk cleanup.** Of 27,537 `exam_result2` rows, 27,495 resolve to old-year assessments and 42 lack both their student and assessment. There are 19 values above current exam maxima, 694 resolvable results with null result-term IDs, and 126 current enrollment/placement mismatches. These are different problems, not a single carry-forward repair.

### Evidence Labels

- **C:** confirmed source/schema/data fact; this does not mean a live browser exploit or save was tested.
- **R:** confirmed by read-only local controller/query execution.
- **I:** inferred consequence; requires an isolated regression test or browser exercise.
- **P:** requires school/product policy approval.
- **B:** requires browser QA. No connected browser was available; no visual, touch, autosave, or authenticated browser verification is claimed.

The evidence JSON contains schema, indexes, numeric discrepancies, runtime route middleware, configuration snapshots and database fingerprints. It contains no student names, phone numbers, credentials, answers, or complaint contents. Numeric IDs still constitute internal audit information: keep the artifact private.

## 2. Evidence Scope and Method

Inspected the active gradebook route file, three Admin controllers, Teacher controller, all three gradebook services, gradebook models/migrations, active Admin/Teacher views and inline scripts/styles; searched alternate gradebook views and references, console aggregation, legacy grading handlers, transfer/preparation/membership services, student results/history, follow-up flows, API references and earlier audit artifacts.

Database inspection used local PDO and `START TRANSACTION READ ONLY`, followed by `ROLLBACK`. A narrowly scoped Laravel bootstrap was used only after inspecting providers; route metadata, membership scopes and known read-only controller methods were evaluated without rendering layouts or submitting requests. Authenticated identity for the Teacher controller was set **in memory only** from the existing assignment; this is not a login/browser test.

No test suite was executed: the audit prohibits record mutations, including synthetic fixtures. Existing tests were inspected as evidence of coverage, not reported as newly passing. No Blade cache, Artisan aggregation/migration, application cache or server configuration was changed.

### Primary Source Index

| Reference | Concrete source and entry point |
| --- | --- |
| S1 | `routes/gradebook.php:10`: Admin group, view/config/aggregation routes; `:40`: separately role-protected status route |
| S2 | `routes/teacher.php:5`: Teacher group; `:7`: gradebook GET; `:8`: save POST |
| S3 | `app/Http/Controllers/Teacher/TeacherGradebookController.php:21`: currentContext; `:42`: index; `:207`: saveMark |
| S4 | `app/Http/Controllers/Admin/GradebookController.php:34`: toggleStatus; `:113`: viewGridSimple; `:249`: viewStudents; `:268`: viewStudentCard |
| S5 | `app/Http/Controllers/Admin/GradebookSettingsController.php:66`: edit; `:80`: update |
| S6 | `app/Services/GradebookConfigService.php:17`: getConfig; `:49`: saveConfig; `:68`: defaults |
| S7 | `app/Services/GradebookAggregationService.php:24`: aggregateRoomSubject; `:113`: calculateTermMarks |
| S8 | `app/Services/GradebookStatusService.php:22`: setStatus; `:39`: default-locked getStatus |
| S9 | `app/Services/CurrentStudentMembership.php:18`: constrain; `app/Room.php:17`: operationalStudents |
| S10 | `app/Services/StudentTransferService.php:164`: transfer transaction; `:182`: return-target protection; `:491`: unscoped-activity block |
| S11 | `app/Services/YearEndPromotionService.php:232`: carryStudentForward; `:318`: fresh scaffolding; `app/Http/Controllers/admincontroller.php:5970`: year activation |
| S12 | `app/Http/Controllers/studentscontroller.php:2512`: current results; `:3117`: timeline; `:3197`: academic_record_show |
| S13 | `resources/views/teachers/gradebook/index.blade.php:83`: inputs; `:138`: change-save; `:147`: local totals; `:158`: AJAX |
| S14 | `resources/views/admin/gradebook/settings/edit_json.blade.php:31`: config form; `:125`: percentage feedback; `:162`: removal; `:184`: new columns |
| S15 | `resources/views/admin/gradebook/view_by_subject_corrected.blade.php:51`: HTML table builder; `:140`: final term summation |
| S16 | `app/Http/Controllers/admincontroller.php:3958`: legacy student_mark; `app/Http/Controllers/TeacherController_New.php:4657`: direct quiz/exam save; `:4908`: bulk save |
| S17 | `app/Http/Controllers/DashboardController.php:13285`: physical assessment/result deletion; `app/Http/Controllers/TeacherController_New.php:373`: legacy deletion |
| S18 | `app/Console/Commands/AggregateGradebook.php:37`: calls missing service methods; `app/Console/Kernel.php:30`: actual scheduler is queue work/restart, not gradebook sync |
| S19 | `app/Http/Controllers/TeacherController_New.php:4314`: add_quize_student resets participation/results; `:5571`: export_exam; `:6090`: export_exam1; GET bindings in `routes/teacher.php:171` |

Additional references below identify specific source methods. Line numbers reflect this checkout on the audit date.

## 3. Existing Architecture and Database Relationships

### Actual data paths

```text
users.student_id --------------------------> students.id (permanent identity)
                                               |
                         room_student(student, year, room) [current projection/year]
                                               |
                      student_academic_placements [dated contexts/history]
                                               |
                                  rooms -> classes, years

users.teacher_id -> teachers -> teacher_room_lesson(year,class,room,lesson)
                                      |
                              teacher_assignment_periods [dated responsibility]

lessons(class, base_subject_id, mark_base_subject_id, max_mark, ...)
  + term_years(year,type,current_term)
  + room
       |
       +--> exams2(id, user_id=creator account, class,room,lesson,term,type,mark)
       |       +--> exam_result2(exam_id,user_id=STUDENT id,room,class,lesson,term,result)
       |       +--> exams_files / exam_result_tester (different purposes)
       |
       +--> lesson_teacher_room_term_exam(teacher,room,lesson,term,type,...)
               +--> exam_result(user_id=STUDENT id,exam_id,room,lesson,term,result,...)
               +--> student_lesson_teacher_room_term_exam [submissions]

raw exam results --> Advanced Gradebook [live, inconsistent adapters/calculations]
                 --> optional aggregation --> students_marks [lesson-keyed JSON]
legacy entry ------------------------------> students_marks [separate calculations]
students_marks + report_cards -------------> legacy reports / Student results
selected placement -> original room/year --> Student Academic Record

storage/app/gradebook/{lesson}_{year}.json --> Admin + Teacher component configuration
storage/app/gradebook_status/{class}_{term}.json --> dynamic Teacher edit gate
```

Names such as `user_id` are misleading: in result tables it is a **student ID**, while `exams2.user_id` is a user-account ID. Do not join results to `users.id`. `Exams2::examResult()` currently points to `Exam_result`, not `Exam_result2`; the audited gradebook avoids that relationship and queries explicitly. It is a fragile wrong-system relationship for future reuse.

### Table and storage inventory

| Store | Meaning / context / keys | Current-history behavior and integrity |
| --- | --- | --- |
| `students` (1,212), `users` (1,336) | Permanent identity; linked account via `users.student_id`; lifecycle active/archive is separate from placement | Transfers do not recreate either. Not all users are students; do not infer one-to-one by equal numeric IDs. |
| `classes` (12), `rooms` (111), `years` (17) | Room has one class and year; class next_class and year next_year are progression configuration | Room IDs are academic context, not portable section names. Duplicate-looking year names exist; ID ordering is not a universal chronological contract. |
| `room_student` (1,623) | `id`, student, room, year, optional term | Current room projection per student/year; older-year rows retained. Same-year transfer updates its room; it is not a full interval log. No physical student/year unique key; zero duplicate groups now. |
| `student_academic_placements` (2,296) | Student/year/class/room, nullable term, effective interval, status/reason/action source/admin | Records distinguish visits, but raw results do not reference these IDs. Normal transfer closes the previous row and appends the target, so append-only means preserve contexts, not literally never update a row's closure fields. Indexed, no active-per-year uniqueness constraint. |
| `student_transfer_histories` (1,064) | From/to class/room/placement IDs, actor, source row IDs and snapshots | Audit event trail, not academic result archive. Some nullable references are intentional legacy compatibility. |
| `lessons` (351) | Class-bound subject/curriculum, maximum/minimum, base/mark-base subject links, language/religion/report flags | Subject ID, not display name, is current identity. Existing base-subject links require reviewed academic semantics before equivalence use. |
| `teacher_room_lesson` (913) | Teacher/year/class/room/lesson assignment and legacy mark gates | Current operational authority, not immutable authorship. Three duplicate context groups exist in old years. |
| `teacher_assignment_periods` (494) | Dated assignment responsibility, nullable source assignment ID | Supports follow-up provenance; not referenced by grade results. Replacement/removal need not erase historical responsibility. |
| `term_years` (9) | Year/type/current flag/date/name fields | One selected active-year term is expected by Teacher gradebook; Admin chooses a representative term for each type. Multiple historical definitions of the same type exist. |
| `exams2` (2,255) | Assessment definition: room,class,lesson,term,creator user, type, max, timing, group | Types 1 (1,025 rows) and 2 (1,230) locally. Name/group are not globally shared assessment identities. No unique container key, version or soft-delete column. |
| `exam_result2` (27,537) | Student + assessment result, denormalized context, nullable result-term, result `VARCHAR(15)`, workflow flags | Only primary key is indexed. No unique student/exam constraint, grader, placement, assignment-period, max snapshot or revision log. Survives safe transfer, not explicit delete flows. |
| `lesson_teacher_room_term_exam` (1,511), `exam_result` (0) | Parallel legacy lesson-content/assessment system, explicit teacher on definition, type-specific fields; result can have lecture ID | Not the same definitions as exams2. Nullable context and multiple content types. Advanced oral reads this result source on Admin but not correctly on Teacher. |
| `exam_result_tester` (91) | Student answer/debug captures; current writer sets synthetic result `11111` | Not an authoritative grade source or trustworthy revision history. Must not be imported into earned marks. See studentscontroller near `:1961`. |
| `students_marks` (2,285), `students_marks_old` (0) | Student/year/room, mark and mark2, result1/result2/result, term_result/year_result, adjustable/status | Multiple subjects in JSON, not one assessment row. No placement ID, author or composite uniqueness. No duplicate contexts currently. All nonempty mark/mark2 JSON parses. |
| `report_cards` (1,903), `report_card_details` (48) | Student/year/room/class, results/notes, attendance JSON, adjustable | Not interchangeable with raw results. 747 rows lack a student; 635 lack a room (overlapping populations). One duplicate group, both orphaned, found. |
| `student_follow_ups` (84), edit audits (1) | Student, teacher, lesson, year, term, room/class, placement (nullable), mandatory assignment period, observed/compliance dates, author/admin actor, level/note | Proper author and edit-audit foundations; five rating keys. Four entries have no placement reference. Author/time permissions differ from gradebook permissions. |
| `exams_files` (16), submissions (2), certificates | Original student/room/assessment/content context | Not copied by transfer; assess provenance from definitions and original room. No automatic gradebook-import contract. |
| `student_schedule_tracer` (154) | User, lesson, lecture-time, day, timestamps | Lacks room/year/placement. Not sufficient for reliable transferred-student historical attendance reconstruction alone. |
| `classes_room_role_exams` (3,399) | Class/room/year/role scheduling/configuration | No student-result relationship; not a result archive. |
| `gradebook_configs`, `gradebook_components` | Old proposed DB-backed configuration models/migrations | Both tables absent locally despite both migrations logged in batch 1. Runtime advanced config uses files instead. Do not claim installed DB templates exist. |
| Gradebook JSON files | Four subject/year configurations, six configuration/status files total | Subject/year scope only, no class/room/teacher/term version. Shared lesson IDs across sections implicitly share the same config. Last-write-wins, no version/audit. |

Physical constraints: none of the audited academic relationships is backed by a foreign key in the local information-schema result. Legacy results, marks, enrollments and reports mainly have primary-key-only indexes. Follow-up/placement/period tables have useful non-unique context indexes. Application validation, not DB referential integrity, currently bears most protection.

## 4. Actual Admin Workflow

1. `/SMT/admin/gradebook` returns `admin.gradebook.index`, using `admin.master`.
2. Browse: choose subject versus student, then class and current-year section.
3. Subject branch loads all class lessons, then room/subject grid (`view_by_subject_corrected`) with first-term, second-term and final tabs and browser printing.
4. Student branch lists room students and opens a card by student ID. **The card discards the selected room and calls `$student->room()->first()`**, then combines that room's curriculum with global-current-year terms.
5. Configuration branch traverses classes -> current-year rooms -> class lessons -> `settings/edit/{subjectId}`. The actual saved scope is subject + active year, not the room used to reach the form.
6. The editor changes names/weights, adds/removes components, preserves hidden ID/source fields, assigns new sources from 100 upward, and writes the JSON file immediately. No draft/publish/review stage, version, result-bearing-change warning, duplication action or dependency lock.
7. Subject selection also has an OPEN/LOCKED toggle. It applies to **the whole class and term**, not just this subject/room, despite appearing on a room-subject page. The template queries current year/term inside Blade and dereferences term without a legitimate no-term state.
8. An aggregation POST exists; it mutates legacy JSON summaries. The main Advanced Gradebook views do not depend on it and read raw results directly. The console wrapper refers to service methods that no longer exist.

Admin configuration does propagate to Teacher component loading when they read the same subject/year file. That is configuration sharing, not a guarantee that marks/totals synchronize.

## 5. Actual Teacher Workflow

Entry: `teachers2/mark_room.blade.php:93` provides the parallel gradebook link. The active view is `teachers/gradebook/index.blade.php`, extending `teachers2.layouts.app`; it is not a separate Teacher authentication system.

```text
class_id / room_id / subject_id from URL
 -> active year + room in that year
 -> authenticated teacher's assignment for exact class/room/lesson
 -> current term in that year (422 if missing)
 -> CurrentStudentMembership roster
 -> subject/year component file or three defaults
 -> component-to-exam mapping
 -> current-room student/exam results
 -> legacy read-only cells, dynamic inputs only when OPEN
 -> input change -> one AJAX POST per cell
 -> re-resolve assignment/current membership/current term/status
 -> locate/create named container exam -> locate/update/delete one result
 -> {success:true}; no authoritative result/totals/version returned
```

New students and transferred-in students can appear with empty cells. Transferred-out students fail the current roster and save guard. Teacher parameter is never trusted from this route because it is not present; actual identity comes from Auth.

Dynamic components have data_source >=100 but the backing exam is **type 1**, named `Dynamic_Section_{ID}`. Clearing a field physically deletes its result row. Nonempty values are assigned directly to the string result column. No backend numeric/min/max rule, absence/exemption state, transaction around container/result, unique upsert constraint, grader, revision audit, updated-at conflict token or finalization snapshot exists.

The controller sets neither result.term_id nor result.lesson_id nor explicit status when creating a dynamic result. Term/lesson can be reconstructed from the container, but Admin/aggregation often filter the nullable result-term field instead. Container maximum is hardcoded 100, unrelated to the subject-based displayed component maximum.

Autosave is `change`, not keystroke debounce. Totals update optimistically before server acceptance; local recalculation sums only editable `.grade-input` cells and drops displayed read-only legacy values. Failure turns a cell red and shows a generic error, but does not restore the accepted value or total. There is no pending queue, unload warning, sequencing, retry/idempotency token, field-specific validation display, bulk save, or keyboard spreadsheet navigation.

## 6. Confirmed Defects and Reliability Risks

### Priority Findings

| Priority / evidence | Defect | Impact / safe future correction |
| --- | --- | --- |
| P0 / C,R | Admin gradebook group is `web,auth`, not `roleadmin` or capability-protected; base controller has no extra gate | A normal authenticated student/teacher is not excluded by the route/controller permission stack from views, config writes or aggregation. CSRF is still present and Officer type 8 has a separate school exclusion; neither makes these Admin-only. Add explicit role/capability policy and regression tests before exposure. No unauthorized write was attempted. |
| P0 / C | Assessment delete flows physically delete source results/files | Transfer preservation does not protect against later definition deletion. Add archive/result-bearing delete restrictions, then audited correction policy; never run a cleanup during reconciliation. |
| P0 / C | `add_quize_student` deletes all existing exam/room results before rebuilding selected/all student rows; it lacks the assignment/current-assessment guard used by newer grading endpoints | An active Teacher-only route can destroy completed grades through participation management and accepts supplied student IDs with lifecycle filtering rather than exact membership. Protect the handler itself and replace reset/recreate behavior with non-destructive participation changes. No request was sent. |
| P0 / C | GET routes named `export_exam` / `export_exam1` are actually grade-to-summary import operations | They update legacy marks/totals after reading results; they are not harmless exports. GET CSRF protection does not cover these writes. Separate true read-only export from explicit authorized, transactional POST aggregation; validate every supplied exam/room/lesson tuple. These GETs were deliberately not executed. |
| P1 / C | Dynamic Teacher writer uses exam NAME + type 1; Admin reader uses numeric exam TYPE | Same configured column is semantically disconnected. Explicit stable assessment binding required. No local dynamic assessments exist, so post-save UI reproduction remains pending. |
| P1 / C,R | Admin final SQL max uses result VARCHAR | 775 groups differ from numeric max; e.g. student 330, room 118, lesson 413, term 17: text maximum 90 vs numeric 100. Fix calculation via an agreed numeric read adapter first, without rewriting raw values. |
| P1 / C | Teacher LEGACY_ORAL uses type 2; LEGACY_HOMEWORK also uses type 2; exam-ID map stores one component per exam | Later homework assignment replaces oral mapping. Oral is missing or can be another component's quiz bucket, not actual oral results. Use an explicit source adapter, never broad type fallback. |
| P1 / C | Admin/aggregation filter result.term_id; Teacher reads via assessment.term_id | 694 resolvable older-year rows with null result term are excluded by Admin per-term filters. Newly created dynamic rows have the same risk. Resolve/validate authoritative assessment term consistently, report contradictory values. |
| P1 / C,R | Admin student card uses first lifetime enrollment | Student 340 selects room 93 (year 5) rather than current room 132 (year 6), confirmed by read-only runtime. Wrong curriculum/context can appear with current-year terms. |
| P1 / C | Admin room and student selectors use unscoped `Room::student`; room parameters not consistently checked against active year/subject class | Archived/unresolved enrollment may remain; direct old-room URLs can combine old room and new terms. Active Teacher path is stricter. Use explicit operational versus historical contexts. |
| P1 / C | Value not numeric/range validated; no result revision/uniqueness/transaction | Negative, above-max or nonnumeric input is not rejected at validation; partial container creation and concurrent duplication/last-write loss are possible. 19 above-current-max rows exist, but their origin cannot be attributed to this writer. |
| P1 / C | Legacy and dynamic locking are unrelated | Class/term JSON lock applies only to dynamic gradebook saves. `students_marks.adjustable` and `report_cards.adjustable` gate other workflows. Reopening one is not reopening all. Define a single enforced publication/finalization policy. |
| P1 / C | No immutable evaluator or accepted maximum in raw result row | Historical assessment creator is not necessarily the teacher who entered the mark. Replacement can change grades without capturing evaluator; cannot reconstruct old graders by current assignment. |
| P1 / C | Config IDs/sources are client-supplied with no distinctness/source-integrity validation; new source numbers consider only submitted rows | Removed source 100 can be reused later, rediscovering old named containers as a new column. Names/weights/source changes can reinterpret history immediately. Validate against pinned version and retain tombstones. |
| P1 / C | Admin calculated table emits config/student names through raw HTML string output | Unescaped stored-XSS sink in S15. Execution not tested. Escape all labels/names independently of role protection. |
| P2 / C | Zero/missing/publication semantics inconsistent | Admin uses `total > 0` to display totals; Academic Record uses `?:` for result strings, turning `"0"` into unrecorded. There are 107 zero-valued raw results. Missing summaries can look like zero; no explicit absent/exempt state. |
| P2 / C | Aggregate command calls absent `aggregateRoom` / `aggregateStudent` methods | CLI wrapper is stale, not a safe automatic sync mechanism. No gradebook sync is scheduled. Do not execute it. |
| P2 / C | Settings save ignores storage return; file status toggle also reports success without checking write result | Disk write failures can produce false success. No atomic file/version concurrency contract. |

The legacy `TeacherController_New::exam_update` also contains a result delete/recreate branch when a room changes. Definition-edit safety therefore needs more than disabling a Delete button. `exam_update123` checks allowed rooms and subjects using independent sets; an exact assignment tuple is safer than a room-set/lesson-set cross product. Coordinator routes have parallel assessment-management handlers and must be included in the eventual mutation inventory before a global historical-read-only claim; they were source-discovered, not exercised here.

Confirmed code defects are not all demonstrated production incidents. In particular, invalid dynamic saves, concurrent edits and script execution were **not** attempted. Current local files contain no active-year custom components; every active-year gradebook defaults locked. That limits live-data verification, not the relevance of the source defects.

## 7. Transfers, Placement History and Read-only Semantics

### What survives

`StudentTransferService::handle` validates target year/class/room, locks student/enrollment/placements, closes the source placement, appends target placement and audit event, updates the same-year enrollment projection, and creates target marks/report scaffolds. Student/account IDs and source marks/results/files/reports are not rewritten. Source snapshots in transfer history supplement but do not replace the originals.

Its unscoped-activity safety block remains for null-room results/submissions/files/certificates and null-room current-year marks/reports. It also rejects duplicate source mark/report rows and conflicting enrollment. No grade-equivalence policy exists; none should be inferred from subject names.

### Same grade A -> B

- Original result stays with its original exam/room; original aggregate stays in source room (C).
- Current Teacher roster excludes the student from A and includes them in B even with no new result (C,R).
- B's gradebook cannot see A's completed scores or use them in calculations through the active-room query (C).
- A's teacher cannot edit the transferred-out student's results via guarded current membership, but loses normal current-roster access rather than receiving a dedicated read-only historical view (C).
- Historical author may be known for legacy definitions/follow-ups, but not for general `exam_result2` grading (C).

### Different grade / different year

Cross-grade transfer creates blank target context rather than copying marks. Year preparation carries the same class/section into newly year-scoped rooms and leaves old-year placement open until activation. Fresh scaffolds contain null components and some zero totals; they are not earned marks. Activating a year closes previous-year active placements and runs legacy reconciliation. It is a mutation, not a harmless history selector; never toggle years to test history.

`next_class` may configure intended progression, but current preparation is not an automatic grading/promotion decision. Repeat across years is representable by different year/room/placement IDs without grade mixing.

### Return A -> B -> A

Placements can distinguish periods. `students_marks`, report cards and raw results cannot reliably distinguish two visits to the same room/year. Current manual transfer deliberately blocks a target with existing placement/mark/report context (S10). That must not be removed until period-aware result provenance and a reviewed resumption policy exist.

The only repeated student/year/room group found is student 1436, year 6, room 164: two **withdrawn**, non-overlapping lifecycle periods. It is not evidence of an accidental duplicate or of a completed A-B-A transfer. No placement interval overlap was found.

### Closed is not globally immutable today

Current assignment/membership guards protect many Teacher/Student mutations from old-room access. However, Admin aggregation can target old rooms with global-year context, legacy Admin mutation paths are not uniformly placement-aware, and definition deletion can remove history. A `status='closed'` row alone is not an application-wide write barrier.

Follow-up edits use the author-only two-hour rule, not a universal placement-closure lock. Decide explicitly whether an author may correct a just-created observation after a transfer within those two hours; do not quietly change that approved rule as part of gradebook work.

## 8. Existing Data Integrity: Revalidated, Not Repaired

Active year is **6 / 2026/2027**, active-year current term is **20 / type 1**. Year 5 still has a selected term 17; it must not be treated as globally current without year scoping.

| Check | Current local result | Classification |
| --- | --- | --- |
| Enrollment | Year 5: 656; year 6: 967 distinct students; no duplicate student/year groups | Valid historical + current projections |
| Placements | Year 5: 656 closed. Year 6: 977 active, 408 closed, 255 withdrawn | Status is year-specific, not proof of global current membership |
| Operational resolver | 967 students | Matches current enrollment total; includes narrow proven stale same-grade fallback |
| Enrollment/active placement disagreement | 126, all same class/different room | Confirmed inconsistency; do not infer exact transition dates |
| Active placement without matching exact room projection | 136 | 126 mismatches above + 10 with no year enrollment at all; do not double-count as 136 missing students |
| Duplicate active placement/student/year | 0 | Current safety condition holds in local data, not physically enforced |
| Missing current-room mark row | 126 | Fresh-context gaps; do not copy old results to fill them |
| Missing current-room report card | 613 | Not automatically corruption: reports may not be issued yet |
| Result-year mapping | 27,458 in year 5; 37 in year 4; 42 unresolved; 0 active-year raw results | Older results are legitimate history, not failed active-year rosters |
| Orphan results | 42 missing assessment and student | Confirmed orphan population; preserve/quarantine for review, do not delete |
| Result context | No non-null room/class/lesson disagreement with resolved exams, no non-null result/exam term disagreement | Parent assessment is usable provenance for resolved rows |
| Null result term | 730 total, 694 with valid assessment; 36 in unresolved rows | Valid historical rows omitted by direct result-term filters; remaining context unresolved |
| Exam definitions | No missing creator/lesson/room/term or room-year/class mismatch among 2,255 | Reference existence does not establish actual grading authorship |
| Dynamic assessment/container population | 0 named dynamic containers, 0 numeric types >=100 | Writer/reader mismatch is code-proven but not a local historical dynamic-result incident |
| Duplicate student/exam results | 0 | Future race risk remains because no composite unique key |
| Mark rows | 2,285; no missing student/room/year, no room-year contradiction, no duplicate context; valid mark/mark2 JSON | Well-linked storage can still be semantically stale/empty |
| Report cards | 747 missing student; 635 missing room; one duplicate context | Legacy orphan issue distinct from correct marks; populations overlap |
| Duplicate report example | IDs 2105/2142, student 4692, year 3, room 404; both student and room missing | Proven duplicate-shaped orphan group; not permission to merge/delete |
| Raw mark bounds | 19 above current assessment max; 0 negative; 0 nonnumeric nonempty; 727 missing/empty | Above-max is inconsistency relative to current max; cannot infer whether mark or max changed |
| Example above-max | Result 11231, student 338, exam 1052: 50 with max 20 | Requires school review, not automatic clipping |
| Numeric maximum | 775 grouped discrepancies | Confirmed calculation bug, not corrupt raw values |
| Follow-ups | 83 excellent + 1 good, all year 6; four null placement links | Preserve author/room/period/time context; null placement is not evidence of invalid follow-up |
| Definition creator | All 27,495 resolved results belong to exams created by type-2 Admin accounts | Cannot name an inactive/active teacher evaluator from these rows; grader was not stored |
| Assignment duplicates | 3 old-year groups; active year has 481 assignment rows | Do not import historic assignment ambiguity into current responsibility |

### Representative identity/history case

Student 340 has 48 raw results in year 5 / room 93. Mark rows: 358 (year 5 / room 93), 1074 (year 6 / room 130), 1884 (year 6 / room 157); no room-132 mark row. Current membership resolves room 132. Admin's first-room card instead resolves room 93. Old results are present; current-context omission and wrong-room selection are different defects.

### Comparison with earlier audit

The 126 stale placements, 126 mark gaps, 613 report gaps, 10 entirely unprojected active placements and raw-result counts remain consistent with the earlier numeric audit. Year-6 closed placement count is now 408 rather than 407; follow-ups are now 84 rather than 83. These are snapshot differences, not changes performed here. No speculative explanation or repair was applied.

### Proposed dry-run reconciliation, not executed

1. Freeze a reviewed backup/export and record stable IDs plus hashes, including config/status files and all result-bearing records.
2. Independently classify orphan, contradictory context, stale enrollment/placement, null result-term with resolvable parent, target scaffold gap, above-max and publication-state issues. Never classify all old-room marks as corrupt.
3. For the 126 placement mismatches, combine enrollment timestamps, transfer events and school evidence. Do not invent a transfer date from a three-hour offset or assume the latest edit is an exact effective date.
4. Produce a per-student proposed close/append projection correction and separate optional empty scaffold creation. No raw mark/result rewrite or automatic carry-forward in that operation.
5. Resolve 694 null-term results at **read time** from their exact assessment where unambiguous; report contradictions. A later additive provenance backfill must retain original values and evidence.
6. Quarantine the 42 unresolved results and orphan report populations in an Admin reconciliation report. Recover context only from reliable archived exports/evidence; never join by equal-looking user IDs or names.
7. Review 19 above-max values and the max change history with staff. Do not clamp marks or modify definitions blindly.
8. Apply only separately approved batches with student/context locks, before/after audit, exact-row rollback strategy and post-checks. Stop if dependent records changed after preview. No DB repair has approval in this audit.

## 9. Assessment Identity and Carry-forward Design

**Preservation, visibility, column placement and calculation eligibility are four different decisions.** A result can be retained and shown read-only without being counted in a new column or final total.

| Model | Current capability | Safe target behavior |
| --- | --- | --- |
| A. One shared assessment across sections | exams2 has one room; group/name is not an enforced common-assessment entity | Stable shared assessment/version plus explicit participating section registrations. Student has one earned result per defined attempt. Section change changes membership, not result owner/author. |
| B. Section-specific assessments | Existing exams2 identity naturally keeps A and B distinct | Preserve original A result; show in read-only prior-context panel. Never fill B's unrelated exam column or reassign author. Teacher B can enter a separate assessment. |
| C. Common categories, different assessments | JSON component sources are loose buckets, not academic equivalence | Map assessment versions to stable category versions. An explicit policy chooses eligible attempts across same-grade periods, scale normalization, count/average/best, cutoff dates, exemptions and double-count prevention. |

Sharing a template means common structure, **not common assessment identity**. Subject-name equality, equal maximum, same source number, same category name or same class is insufficient proof of equivalent exams. Existing `base_subject_id` / `mark_base_subject_id` can inform an approved mapping, not establish one automatically.

For an earned 95/100 before transfer: retain original assessment/result/section/period/author/time/max provenance. Teacher B may read the relevant result for an actively assigned student under a narrow history permission. It appears in B's current column only if the same assessment identity/version applies, or an explicit reviewed equivalence is recorded. Otherwise it remains a separately labeled historical result. Calculation eligibility is evaluated by the approved category policy, not by copying rows.

Cross-grade/next-year carry-forward defaults **off**. Exceptional curriculum equivalence requires an explicit authorized mapping and audit. Never reclassify previous-grade marks into current curriculum simply because a subject is called Arabic in both grades.

## 10. Existing Template Capabilities and Safe Editing

### What exists now

- Mutable component list per lesson/year: ID, single display name, weight, data source, sort order.
- Three legacy core IDs with forced source mappings **when submitted**; backend does not require those IDs to remain present.
- Dynamic source allocation starting at 100; whole-file save shared by sections using that subject ID.
- No term-specific config, independent category hierarchy, reusable template identity/name/description, assignment record, bilingual fields, draft/published state, version, immutable maxima or audit.
- Physical `gradebook_configs`/`gradebook_components` absence contradicts migration ledger. Four file configs belong to year 5; none to active year 6. Only status files are class 3/term 17 OPEN and class 4/term 17 LOCKED.

### Template-edit scenarios: policy for future implementation

| Scenario | Required safe behavior / audit / migration implication |
| --- | --- |
| 1. Add column before any marks | Edit draft; allocate stable non-reusable column identity. Publish/apply validated version. No legacy result move. |
| 2. Add after marks | New applied version with effective date and visible missing state; retain prior result/version bindings. Recompute only a preview until approved. |
| 3. Rename column | Keep identity; create versioned presentation change. Preserve published label snapshot. Do not rename container exams as linkage. |
| 4. Change maximum | Block in-place change on result-bearing assessment. Create assessment revision/approved correction or new assessment; retain original score/max and conversion evidence. |
| 5. Remove result-bearing column | Retire/hide from new entry; preserve historical column/result, calculation snapshots and audited inclusion policy. Never physically cascade-delete grades. |
| 6. Change category weights | New policy/version; show impact preview; no implicit change to finalized totals. Record actor/reason and publish affected calculation version. |
| 7. Duplicate for another term | Copy definition as draft with new applied context; no results/attempts/author copying. |
| 8. Apply to many sections | Explicit compatible class/subject/year/term assignments pinned to one published version; not duplicate raw results. |
| 9. Transfer with same template | Structure compatible, assessment identity still checked. Read old results, reuse only truly shared assessment result. |
| 10. Transfer with different templates | Read-only source history plus an explicit reviewed mapping where justified; no positional/category-name guess. |
| 11. Teacher replacement | Close/open assignment periods. Preserve actual evaluator. New teacher gets current entry rights and relevant read-only prior results; corrections need attributed revisions. |
| 12. Edit after finalization | New draft/version or formal correction workflow only. Prior published transcript/calculation remains immutable and reproducible. |

Editing a reusable draft definition must not mutate an already-applied result-bearing gradebook. An application pins a version; applying an upgrade is a separate explicit operation with a diff and audit. Original files and result rows remain readable through a legacy adapter.

### Practical MVP versus later options

MVP: reusable name/description; class/subject applicability; ordered categories/columns; immutable IDs; Arabic name plus optional English name; separate decimal maximum and optional category weight; one supported deterministic total policy; published versions; explicit year/term/section applications; preview; copy-as-draft; archive/retire; author/revision audit; controlled finalization. Validate total weights when weighted mode is chosen and reject unsupported formulas.

Later: global default/inheritance rules, rich coefficient/formula editor, automatic multi-template equivalence, optional/conditional columns, advanced exemption redistribution, cohort analytics and broad report designer. These need policy first. Do not implement a general expression language or multiple competing weighting systems in the first slice.

## 11. Admin UX Findings and Proposed Screen Hierarchy

Source-based findings, not visual-browser claims:

- Long class -> section -> subject navigation obscures the fact that settings affect **all sections with the same subject/year**.
- Config form labels weights as percentages, while Teacher code treats them as mark contribution/capacity without normalization; progress bar accepts totals below/above 100 and does not consistently disable submit.
- The delete button can remove a component even after result use; no affected-record count, warning, version diff, preview or publication step.
- IDs/sources are hidden in form payload, not meaningfully explained; no protection against ID/source reuse.
- Open/lock toggle is class-wide but appears in a room/subject workflow; cancellation/error can leave displayed toggle state misleading until reload.
- Missing active term can crash subject selection Blade; no current-year/term preparation guidance.
- Subject/Student grids, prints and legacy cards are distinct calculation implementations, not consistent report views.
- Single-language hardcoded Arabic strings and mixed English errors; configuration table has large fixed widths and horizontal scrolling rather than focused mobile editing.
- Unescaped HTML generation in the subject grid is a correctness/security issue, not just style.

Proposed hierarchy:

```text
Gradebooks
  Operational contexts [year, term, class, section, subject, state]
    Applied gradebook [roster / calculations / history / publication]
  Templates
    Template details [draft versions / published versions / usage]
      Editor [categories -> columns -> maxima/weights -> preview -> publish]
  Apply template
    Compatible contexts -> impact preview -> confirm version pinning
  Exceptions / reconciliation [read-only dry-run inventory; separately authorized action]
```

Every applied screen shows year/term/class/section/subject/version and lock/publication scope. Result-bearing changes require an impact summary and cannot silently reinterpret history. Reuse existing Admin tokens, modal patterns, localization and RTL shell; do not start styling before calculation/permission contracts are fixed.

## 12. Teacher UX Findings and Proposed Interaction Model

The active view is a plain dense table inside `.table-responsive`; no sticky name/header, student search, assessment filter, keyboard movement, pagination or mobile-focused entry is implemented there. Header uses `col-8` plus `col-6` in one row (14 Bootstrap columns), which is a source-confirmed wrapping defect. Inputs are approximately 45px high, but lack min/max, descriptive student/assessment accessible labels, `inputmode`, error detail and saved-value state.

Legacy cells are gray/read-only, but that only indicates the editing source, not historical provenance. Historical prior-section values are not shown. Feedback relies mostly on background color and generic error toast. Updating one dynamic cell replaces row total with editable-only sum even while legacy values remain visible.

Recommended desktop: context/version header; compact search/filter; sticky student name and assessment/category headers; contained horizontal grid scroll; keyboard next/previous cell; explicit blank/zero/absent/exempt states; client hints backed by server rules; per-cell pending/saved/error/conflict indicator with text; accessible error summary; authoritative returned totals; recovery queue and navigation warning. Batch transport may be introduced after atomic/idempotent save semantics exist.

Recommended tablet/mobile: choose assessment or student first, show a compact focused list/card editor rather than twenty miniature columns; keep source-history panel read-only and visibly separate; provide Next/Previous and a clear pending-save status. Retain a read-only wide-grid view for deliberate review. Scope RTL/LTR styles to gradebook, preserve logical inline positioning and contained scrolling; no page-level overflow or forced desktop widths.

Browser QA must cover 280/320/360/375/390/430/768/tablet landscape/desktop, long Arabic names, many columns, keyboard/screen-reader labels, no-current-term empty states and save failure/conflict. None was visually verified in this audit.

## 13. Security, Permissions and Historical Edit Safety

### Current protection that should be retained

- Teacher middleware requires type 1; exact active-year class/room/lesson assignment enforced on GET and POST.
- Current membership required before dynamic mark writes; wrong class was denied 403 in read-only runtime.
- Student result route checks URL student against authenticated student ID; Academic Record detail checks ownership through selected placement.
- Web CSRF middleware remains active. Existing Officer school-route exclusion is separate from Admin authorization.
- Safe transfer uses transaction/row locks and retains source context. Follow-up keeps actual author, assignment period, two-hour edit and audit.

### Remaining boundaries to establish

- Add Admin role plus narrow manage/view/publish/correct capabilities to every Advanced Gradebook endpoint; do not rely on navigation visibility or route name.
- Validate subject belongs to class/room context, active versus historical year selection, component identity/version, decimal mark bounds and allowed states server-side.
- Current result edit must be tied to assignment + student's active membership + applied version/assessment. Historical access is read-only, not authorization to edit a formerly taught student.
- Replacement teacher may enter future results, but must not silently become the author of old results. Existing exams2 author is creator, not grader.
- Noncurrent historical writes require an exceptional, audited Admin correction workflow, not reopening old-year status files or changing global year.
- Finalized results/issued reports need an authoritative immutable publication/correction policy checked by all writers, including legacy/API/import/aggregation routes.
- Unique keys and row/version locks should prevent duplicate result/container races; stale updates return explicit conflict, not last-write success.
- Multi-row bulk grading currently pre-validates membership but then skips invalid definitions and saves row by row without one atomic transaction. It is not equivalent to a validated all-or-nothing batch.
- No dynamic-save acceptance/range/race test was run because writes were excluded. Attack consequences are source-grounded risks, not claimed successful exploits.

## 14. Calculation, Reporting and Synchronization

| Consumer | Actual source / calculation | Inconsistency |
| --- | --- | --- |
| Advanced Teacher | Named dynamic exams; type 1/2 legacy exam mapping; average within mapped component; sum unrounded scores | Oral source wrong, legacy exam averaged rather than Admin max, weights not normalized; displayed rounded cells may differ from total |
| Advanced Admin subject | Raw oral + exams2.type buckets; oral/quiz average, exam max; dynamic numeric-type average; rounded component sum | Dynamic source disconnected; nullable result-term excludes valid data; oral lacks room filter |
| Advanced Admin student | First room curriculum; fixed oral/quiz/exam calculation; ignores custom component config | Not same system as subject view; wrong-room/current-year combination |
| Aggregation service | Room student relation, chosen term per type; oral avg; room quiz avg; SQL exam max; writes mark/mark2 | Oral unscoped room; VARCHAR max; no full result1/result2/term/year recalculation; can retain stale keys; no shared gradebook config |
| Legacy entry/export | students_marks JSON, fixed oral/homework/activity/quiz/exam keys; legacy ratio rules and adjustable/report gates | Different weights, states, rounding and publication; partial bulk writes possible |
| Student current results | Current room/year students_marks, result1/result2/result/term_result/year_result | Dynamic saves do not update this store; no automatic publication bridge |
| Academic Record | Selected student/year/room, raw results and legacy summary fields | Preserves old results, but raw mark2 components not mapped; zero raw result becomes unrecorded through `?:`; names/max are live definitions, not historical snapshots |
| Follow-ups | Qualitative levels, notes and compliance periods | Not numerical marks; must not be imported into grade totals without a separate school policy |

There is no proven end-to-end authoritative flow from dynamic Teacher save -> Admin matching column -> legacy transcript -> Student/Parent result. Configuration sharing does not solve synchronization. Advanced gradebook has no dedicated export route; it uses browser printing. Legacy Teacher total PDF/Excel endpoints exist and consume legacy JSON, not the same Advanced Gradebook view model.

Do not confuse those PDF/Excel totals with `export_exam`/`export_exam1`: the latter are bound to GET and mutate legacy aggregate marks. A manual QA operator clicking what looks like an export can change academic data; make these explicit import/recalculate operations before operational testing.

Use one pure, deterministic calculation service for both previews and published results. Inputs: pinned assessment/maximum/version, accepted attempts, explicit states, approved eligibility across placement periods, weight/missing/exemption policy and rounding mode. Output: per-assessment/category/term/final values, reason/state, included result IDs/revisions and policy version. Preserve full decimal precision internally; round at defined display/publication stages. Blank and zero must remain distinct. Store a publication snapshot with input/revision/policy references; never silently recompute a finalized transcript against mutable definitions.

Terms: Teacher operates only selected term in active year; Admin picks one term per type, preferring current then latest ID. Year 5 has multiple type-1/type-2 definitions, so selecting only one can omit other valid terms/occurrences. Academic Record raw result loading is room-based and can show all available assessments; maintain that coverage and explicitly validate record-year relationships. Do not merge duplicate term definitions by name.

Student timeline deliberately groups one card per year and links only its chosen placement. That keeps the list simple but makes other same-year placement details undiscoverable through normal list navigation. Preserve one year card, then expose read-only placement transitions/results **inside that year** through explicit contexts. Do not combine marks by picking the first row or broadly removing room filters.

Parent/mobile integration remains a separate boundary: API result code reads legacy student marks; parent children code references `App\Parents`, absent in this checkout. There is no dedicated Advanced Gradebook API contract. Anonymous/supplied-ID legacy API authorization debt documented in the prior audit remains; no production endpoint was contacted and no API auth change is proposed inside a styling slice.

## 15. Required Scenario Matrix

Current behavior is grounded in source/data unless marked inferred. Recommendations are not implemented.

| # / scenario | Current behavior | Expected behavior / gap / recommended change | Evidence |
| --- | --- | --- | --- |
| 1 New student, no marks | Current roster includes student; dynamic/default cells empty; total may show 0 | Explicit unentered state, not failed/earned zero; retain roster independence from results | C,R |
| 2 Partial marks | Available cells summed; missing/unentered has no formal state | Deterministic missing policy; correct pending/provisional total | C,P |
| 3 Same-grade A -> B | Old rows preserved; B current roster blank; old results absent from B | Read-only old results + explicit carry eligibility; no blind copy | C,P |
| 4 A -> B -> A | Manual return blocked by target history/scaffolds | Keep block until enrollment-period provenance/resumption policy | C,P |
| 5 Different grade | Empty target scaffold; previous grade retained | Keep separation; exceptional curriculum equivalence only by approval | C,P |
| 6 Year rollover | New-year room/enrollment/scaffold; source history retained; activation mutates statuses | No old marks inherited; explicit term/config preparation | C,R |
| 7 Teacher replacement | Assignment controls entry; exams2 lacks grader; legacy teacher-owned definitions restrict replacement differently | Dated assignments + original evaluator + audited corrections | C,P |
| 8 Shared exam | One exam has one room; no enforced cross-section identity | Shared assessment/version plus section registrations | C,P |
| 9 Different section exams | Different exam IDs; current room only | Preserve distinct assessments; relevant source history readable, not mapped by name | C,P |
| 10 Same template in two sections | Same lesson/year JSON implicitly shared, separate container exams | Explicit applied version; shared template does not imply shared exam | C,I,P |
| 11 Different templates | Only different lesson/year files, no per-section version/application model | Explicit assignments/equivalence; old data read-only | C,P |
| 12 Edit before marks | Immediate whole-file config overwrite | Validated draft, preview, publish; safe stable identities | C |
| 13 Edit after marks | Same overwrite; no usage lock | Result-bearing version pinning and impact review | C,I,P |
| 14 Delete assessment with results | Existing Admin/legacy Teacher code physically deletes results | Archive or block; no destructive result-bearing deletion | C |
| 15 Change max after results | Live definition affects displays, no accepted max snapshot | Immutable assessment revision/approved correction, preserve original max | C,P |
| 16 Concurrent teachers/admin | No revision token/unique upsert, last writer can win; file overwrite | Optimistic conflict + transactional/idempotent save and audit | C,I |
| 17 Absent/exempt | Null/value/legacy flags, no unified explicit academic state | Approved distinct absent/exempt/missing/zero semantics | C,P |
| 18 Finalize | Dynamic class/term lock and legacy adjustable gates, no unified snapshot | Formal publication scope and immutable calculation snapshot | C,P |
| 19 Historical viewing | Owned selected placement scopes year/room; other same-year cards hidden; zero/mark2 issues | One year card + all legitimate period details and safe source labels | C,R,B |
| 20 Admin/Teacher agreement | Same config, different source identity/term/max/total logic | Shared adapters/calculator/view model; agreement regression tests | C,R |

No scenario involving live saving, transfer, concurrent requests or visual layout was executed. Browser and isolated fixture verification are acceptance requirements for implementation, not completed audit tests.

## 16. Proposed Incremental Target Architecture

```text
Permanent Student/User Identity
         |
CurrentStudentMembership ---- dated StudentAcademicPlacement
         |                          |
Current Teacher Assignment ---- TeacherAssignmentPeriod
         |
Admin Template -> Immutable TemplateVersion -> categories/columns
                              |
                    AppliedGradebook(year,term,class,room,lesson,version)
                              |
               Stable AssessmentVersion + section registrations
                              |
            StudentResult(student,assessment,attempt,state,decimal value)
                    |
          immutable provenance + attributed revisions
          original year/term/class/room/placement/teacher period/max
                    |
       Eligibility/Equivalence policy + one pure calculation service
                    |
     Teacher current + read-only history / Admin review / Student history
                    |
            Published calculation/transcript snapshot
                    |
              Legacy projection adapters (no rewrite of originals)
```

### Minimal responsibilities

1. Keep `CurrentStudentMembership` as operational authorization; centralize its use in all current roster/grade writers. Keep placement history as dated enrollment context, not the only source of result ownership. Review the narrow stale-placement fallback separately; do not create academic provenance against a known wrong placement.
2. Add explicit template/version/application identity. A published version is immutable; an applied gradebook pins it. Context uniqueness is explicit. Retire, do not reuse, component IDs.
3. Introduce an assessment registry/adapter linking exact legacy definition IDs (table discriminator + ID), new stable assessment/version IDs and optional shared-section registrations. Existing numeric IDs retain their meaning.
4. Use an additive result/provenance/revision foundation. Preserve legacy `result` strings and original rows; create canonical decimal/read-state only when parse/context is reliable. Map legacy source table/result ID uniquely. Do not assume synthetic tester rows are attempts or reliable revisions.
5. New writes record actual evaluator account/teacher/assignment period, original placement/context, observed/entered timestamps, maximum version and state. Legacy authorship is explicitly unknown where evidence is absent; exam creator is labeled creator, not grader.
6. A history reader returns relevant prior results for current student/subject/year under a narrow permission; edits remain bound to authorized current assessment or explicit correction workflow. No cross-student/grade disclosure from a broad student-ID query.
7. A single calculation service produces shared view models and auditable publication snapshots. Legacy transcripts remain authoritative until a reviewed bridge/cutover; do not dual-write divergent calculations.

This is additive evolution. A new canonical result table is not permission to duplicate earned marks: use unique source references, explicit migration status and one authoritative write path for each cutover stage.

## 17. Backward Compatibility and Migration Strategy

- First inventory production schema/config independently in a later approved preflight. Local migration-ledger/table mismatch is not proof of production state. No schema operation is authorized here.
- Back up subject/year and class/term JSON alongside DB; current files are effective academic configuration and are not replaceable deployment assets.
- Import files into initial template versions with original IDs/sources and snapshot hashes. Preserve source files read-only; do not reassign source 100 to a new meaning.
- Build read-only adapters and shadow comparisons before canonical result migration. For each source, record confidence: exact assessment/term/room; inferred solely from parent; unresolved. Preserve original nullable fields.
- Add nullable provenance/version links initially. New reliable writes populate them; backfill only unambiguous links with before/after audit. Do not infer an old teacher from the current assignment, nor force every legacy mark into a placement interval.
- Keep old result and summary tables readable. Use compatibility projections only after one published calculation policy has been approved; never overwrite source aggregates during a display rollout.
- Closed history access must not depend on current membership; write access must not be granted just because a historical result is visible.
- Introduce uniqueness/indexes after duplicate review and dry-run planning. No bulk-delete to make constraints pass. Distinguish intentional attempts/periods before choosing a unique key.
- Block ambiguous return transfers and unsafe history corrections until interval-aware identity is available. Do not use a broad `first()` or room-only context to merge two visits.
- Deployment rollback must preserve schema capacity/history and any newly accepted results; do not shrink/drop tables or revert by deleting later dependent academic records.

## 18. Product Decisions Required from the School

1. For same-grade moves, are prior results display-only, calculation-eligible, or reusable only for a shared assessment? Who approves exceptions?
2. Which assessments are genuinely school-wide shared events versus teacher/section-specific events? Are make-up attempts a replacement, best attempt, average, or separate achievement? No dedicated compensatory assessment identity/policy was found in the advanced module.
3. Define marks as raw scores out of a maximum versus weighted contribution. Choose category rules, term/final weighting, precision, minimums/pass thresholds and treatment of optional subjects.
4. Define missing, absent, exempt, not-yet-assessed, zero and unpublished states. Do not use blank or zero as a substitute for all of them.
5. Who can view earlier teachers' assessments for a currently assigned student? Who may correct closed/finalized history, with what approvals/reasons?
6. What is the publication/finalization scope: class/term, section/subject, individual assessment or transcript? What requires republication and a new issued version?
7. For A-B-A returns, resume prior shared assessments or create new attempts? What periods and previously published results can be edited?
8. Approve initial reconciliation for stale placement intervals/orphans/above-max values independently from template/UI implementation. Do not infer that all gaps should be filled.
9. Decide MVP bilingual fields and reporting outputs. Avoid forcing complex formula/optional exemption features before basic academic rules are settled.

## 19. Prioritized Implementation Roadmap

Complexity is relative engineering scope, not a promised delivery date. Each phase needs review and separate implementation authorization.

| Phase | Goal and exact scope | Dependencies / impact | Safety, acceptance criteria and main risk | Complexity / decision |
| --- | --- | --- | --- | --- |
| 0A: Permission and retention safety | Admin role/capability gates; teacher current-context validation parity; numeric/state/max validation; protect result-bearing deletes and participation reset; separate GET export from POST import; escape raw HTML | No broad redesign. Controllers/routes/policies/validators, focused tests. Preserve existing public/Officer boundaries. | Unauthorized GET/POST denied; valid current teacher works; old results cannot be deleted through protected paths; GETs cannot mutate summaries; values rejected clearly. Risk: breaking legitimate Admin roles if capability mapping is assumed. | Medium; approve Admin capability/correction policy |
| 0B: Context and calculation correctness | Fix exact dynamic assessment adapter, result-term fallback, numeric max, first-room selection, zero handling; inventory actual historical conflicts | After source contract is written; code-only read adapters first. Any reconciliation remains separate dry-run. | Matching Admin/Teacher source fixtures; no historical row writes; wrong-room/student prevented; 694 null-term valid rows reconstruct correctly; 775 numeric maxima regression covered. | Medium/high; approve selected/best/average behavior |
| 1: Academic foundation | Stable assessment/result semantics, additive provenance/revisions, return-period policy, shared pure calculator, deterministic states; fixture suite and shadow reconciliation | Depends on approved decisions and 0A. Additive schema reviewed against actual production state; do not revive absent models blindly. | Exact source IDs unique, old-row hashes preserved, unknown authors explicit, no cross-grade/year carry, calculations reproducible. Risk: ambiguous legacy authorship/intervals. | High; key academic policy decisions required |
| 2: Admin template MVP | Draft/published versioned definitions; categories/columns; maxima/weights; explicit applications; copy/preview/retire; impact diff | Foundation identity/calculator ready. New Admin screens + template/application schema + JSON import adapter. | Edit a draft without altering applied history; result-bearing changes versioned; multi-section application explicit; no reusable source-number collision. | High; choose MVP grading mode and publication scope |
| 3: Teacher entry UX | Current roster + read-only relevant history; desktop sticky grid; mobile focused entry; accessible states; conflict-safe autosave | Applied versions/permissions/calculator stable. Blade/CSS/JS plus transactional revisioned save API. | Retry/idempotency, authoritative totals, pending/error/conflict feedback, keyboard flow, no lost updates, no unauthorized history edit; responsive browser QA. | Medium/high; approve prior-result visibility policy |
| 4: Reporting and portals | One view model/calculator for Admin/Student/history/print/export; immutable publication/transcript snapshots; per-year transitions | Phase 1/2 stable; 3 can proceed alongside report adapters after save contract. Legacy JSON bridge is explicit cutover. | Current and historical results agree; zero retained; all terms/occurrences covered; same-year source contexts discoverable; Parent/API authorization resolved separately. | High; publication/correction and Parent client decisions |
| 5: Stabilization and release | Isolated regression, concurrency/rollback, performance/index plans, browser matrix, export snapshots, staff guide and production preflight | All prior acceptance passed; representative staged data and legitimate accounts available | No destructive migration/backfill; shadow diffs reviewed; DB/config fingerprints; reversible deployment without removing accepted results; approved monitoring. | Medium; school acceptance and reconciliation sign-off |

**Before visual redesign:** complete permission/retention gating, assessment identity contract, context/source fixes and approved calculation semantics. Otherwise a polished UI can still show incompatible totals or destroy history.

### Recommended first implementation slice

A bounded Phase 0A plus a read-only agreement harness: protect all Advanced Admin endpoints; validate current Teacher inputs; forbid deleting result-bearing definitions or resetting earned results through participation management; make export GETs genuinely read-only; escape generated HTML; add fixtures proving Admin/Teacher context and source mismatches. No template UI, carry-forward, data repair or bulk migration in this slice. Confirm fixes before moving to result/calculation adapters in 0B.

## 20. Testing Strategy, Limitations and Audit Closure

### Required implementation tests

- Authorization matrix: guest, student, assigned/unassigned/replaced teacher, Admin capabilities, Officer isolation; GET/POST parity; crafted student/room/subject/year/component IDs; CSRF.
- Provenance: raw results retain original student/assessment/author/max/context across A-B, cross-grade and new-year transitions; A-B-A blocked or period-aware by approved policy.
- Calculations: all occurrences/terms, null result-term with valid parent, conflicts rejected, numeric maxima, decimals, zero/blank, absent/exempt, uneven maxima, all missing, final thresholds, precision and deterministic rounding.
- Save reliability: insert/update/clear with revision audit, retry/idempotency, two editors, stale config/version, partial transaction failure, storage failure, autosave ordering and navigation with pending cells.
- Templates: all twelve editing scenarios above; component retirement/source reuse; many-section assignments; no implicit shared assessment.
- History/portal: owned placement, no future/current mix, all same-year transitions reachable, mark2 components, zero results, file/certificate provenance, issued snapshots and correction audit.
- Report/export: same inputs produce same values on Admin, Teacher, Student and prints; Arabic/English/RTL, spreadsheet formula safety when export exists.
- Browser: authorized desktop/mobile/tablet flow, long names, 280px width, keyboard/touch/focus, scroll containment, sticky cells, save-error recovery, print pagination and no new JS/encoding problems.
- Performance: batched result lookup and indexes verified with read-only EXPLAIN on representative sizes; avoid nested per-cell collection scans or unbounded result hydration for a large term. Do not add caches that outlive assignment/transfer changes without explicit invalidation.

### What was actually verified in this pass

- Read-only live local schema/count/index/reference inspection, raw data integrity calculations and previous-report revalidation.
- Runtime gradebook route collection and middleware.
- Operational membership count 967.
- Teacher example class 2 / room 132 / lesson 409: 22 students, term 20, LOCKED, default three legacy components, no saved current-term marks; wrong class rejected 403.
- Admin same-context query: 22 students, default components; current-term empty data internally represented as total 0.
- Student 340 first-room versus actual current-room difference.
- Configuration files and current absence of physical gradebook tables despite migration ledger.
- Full-row SHA-256 fingerprints of all 33 inspected tables matched at audit start/end, including identities, placements, enrollments, marks/results/reports, follow-ups and invoices. All six gradebook configuration/status file hashes also matched. Exact verification summary is recorded in the evidence artifact.
- Effective filesystem is `local`; read-only `getConfig(31,5)` returns the five configured components, confirming that the audited subject/year JSON files are not merely abandoned files.

### Explicitly unverified

No production access, browser rendering, real login, save, transfer, template update, status toggle, deletion, finalization, concurrent write or migration was tested. No automated fixture suite was run. No claim is made that all legacy writers or API routes are safe; reviewed high-risk paths and unresolved boundaries are identified above. A true dynamic current-year test requires a separately authorized isolated fixture/staging context, not fake operational assignments or marks in this database.

No app code or data fix is part of this deliverable. The next action is school approval of assessment/carry/weight/publication policy and a focused safety implementation, not a full rewrite and not bulk historical mark copying.
