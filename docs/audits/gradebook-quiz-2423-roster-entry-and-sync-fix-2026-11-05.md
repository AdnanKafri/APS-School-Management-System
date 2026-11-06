# Traditional quiz/exam roster entry and original-result synchronization

Date: 2026-11-05. Project: `C:/Users/Lenovo/Desktop/aladhamedu`.

## Outcome

Traditional quiz/exam entry uses the current eligible roster without requiring persisted participation. The existing original writer creates a result only on a valid mark POST. Optional participation remains available because Student Portal/API assessment visibility and notifications still use it. Repeating that optional action for an Admin-created traditional assessment is now additive: it cannot delete even unused existing placeholders.

**Quiz 2423 is not globally blocked in the inspected implementation.** Actual school SELECTs and real controller/child-view rendering show 20 current-roster students, 19 editable original-assessment inputs, and one legitimate continuity conflict. No placeholder is required to expose the 19 inputs. No continuity, equivalence, calculation or timing protection was bypassed to make the twentieth student editable.

The four requested October 31 reports were reviewed against current code. Their findings describe different stages: read-only occurrence discovery, subsequently approved original-window entry, then manual-lock independence. The latest implementation, not an earlier report's obsolete OPEN requirement, is the baseline.

## 1. Exact operational trace

All Teacher URLs below have prefix `/SMARMANger/dashboard/teacher/`.

| Step | Existing route / implementation | Data and behavior |
|---|---|---|
| Admin quiz list | GET `/SMT/admin/class/room/quizes/130`; `DashboardController::room_quizes`; `admin.quizes_of_room` | Active-year actual current term; original definitions. |
| Admin creation | POST `/SMT/admin/class/room/quize/store`, `quize_store`; exam counterpart `/exam/store`, `exam_store` | `AdminAssessmentInput` and existing transaction create `Exams2` / `exams2`, type 2 quiz or type 1 exam. Exact class/room/lesson/actual term, original maximum and timestamps. Explicit all-sections creation can append equivalence members for distinct original IDs. |
| Teacher lists | GET `teacher_quize/130/166/406`, `teacher_exam/130/166/406`; `teacher_quize_mark`, `teacher_exam_mark` | Current timetable assignment and active-year actual current term; traditional `is_file=1` and automated `is_file=0` remain separate tabs. |
| Optional participation preselection | GET `studentselect/{exam}/{room}`, `studentselect` | Authorizes original context; reads existing current-roster participants. No writes. |
| Optional participation POST | POST `add_quize_student`, `TeacherController_New::add_quize_student` -> `TeacherAssessmentService::participants` | Exact posted definition/room/subject/class, eligible membership, transaction/locks, duplicate/context/continuity guards; returns new participation notifications for the existing push path. |
| Operational quiz entry | GET `teacher_quize_students/130/166/406/2423`, `teacher_quize_students`; `teachers2.teacher_quize_students` | A WRITE interface. The shared read-only roster projection combines current eligible students with optional original results. |
| Operational exam entry | GET `teacher_exam_students/{room}/{teacher}/{lesson}/{exam}`, `teacher_exam_students`; **`teachers2.teacher_exam_student`** | Same traditional projection and write behavior. Automated views remain separate. |
| File filters | GET `quizestudent/{filter}/{exam}/{room}`, `quizestudent` -> `assessmentFilterRows` | Current membership; 0 all, 1 with upload, 2 without upload. Exact assessment result/file context; carried/conflicting rows are read-only. |
| Single marks | POST `student_save_mark_quize`, `student_save_mark3`, `student_save_mark2` | Existing `TeacherAssessmentService::save`; optional original result ID; accepted zero, rejected empty/invalid marks, exact original maximum and context. JSON only when requested; existing HTML POST/redirect fallback. |
| Bulk marks | POST `student_save_mark_bulk`, `kind=exam2`, JSON-string `rows` | Existing outer atomic transaction and shared writer; invalid row rolls back batch. Duplicate assessment/student keys rejected. |
| Advanced read | GET `gradebook/1/130/406`; `TeacherGradebookController::index` | `GradebookReadService` plus `TeacherGradebookAssessmentColumns`; each original `exams2:{id}` occurrence retained. No result-row prerequisite. |
| Advanced save | POST `gradebook/assessment/save` | Exact original exam/student/room/subject; existing writer. Returns original result ID, accepted value, existing component summaries and total. No parallel mark storage. |

`exam_result2.user_id` is **students.id**, not users.id. The original `exam_result2.id` remains the same on later edits. `students`, linked `users`, `room_student`, placements, original assessment identities, report/financial records and file references are not rewritten by roster reads.

`TeacherAssessmentService::save` retains its existing student and definition locks, subject lock against distribution edits, active-year/current actual-term/timetable/membership checks, entry-window and continuity checks, bounds, duplicate rejection, original-context checks and three-attempt transaction retry. It looks up the original result by exam/student and can create it without prior participation. No new writer was added.

## 2. What Add Students really did, and now does

### Before this pass

The Teacher endpoint already did **not** reset or recreate earned marks. It loaded all original results under a definition lock; rejected duplicates and mismatched context; rejected omission of earned rows or uploaded submissions; deleted only omitted, unused current-roster placeholders that passed those guards; and created blank placeholders for newly selected eligible students. Already-present rows retained their IDs/values. Only newly created participants received participation notifications. Carried/conflicting results were not materialized in the destination.

Also, the existing `currentAssessmentRows()` helper already added unsaved virtual rows for missing eligible students. Thus it would be inaccurate to claim that the inspected backend universally required Add Students or a second quiz. Re-selecting students was necessary for **persisted participation / Student Portal exposure**, not for the helper's mark-entry roster. The old labels strongly implied a prerequisite, while actual frontend defects could leave students missing:

- Quiz filter 0 had no renderer: returning from a restricted filter to All did not restore the roster.
- The with-upload renderer dereferenced the last element of an empty upload array. A student with no result/upload could stop rendering through a JavaScript exception.
- One quiz no-result branch emitted two mark inputs for one student.
- Filtered mark maxima read nonexistent `student.mark`; their fallback maximum came from nonexistent `.mark` instead of `#success_mark`.
- Initial row forms were invalid children wrapping table cells. Their native POST association was not reliable in browsers.
- Initial marks used a loose null comparison, which is unsafe for numeric zero in PHP 7.4.

### After this pass

For **Admin-created traditional type-1/type-2 assessments**, non-reserved identity, participation is additive. Omitting an already-present student retains every original placeholder, mark, attempt and file; no existing result is deleted or reset. New explicitly selected eligible participants can still receive the same blank row/notification. Repetition does not duplicate either.

Automated participation retains its previous guarded selection/removal semantics. Unsupported Teacher-created/reserved contexts are not silently moved to the new additive policy. Original authorizations, transactions, result/continuity guards and notification contracts remain.

Traditional list links now say `إدخال / تعديل العلامات`. The retained action says `إتاحة للطلاب (اختياري)`, with a localized explanation of roster entry, blank versus zero and optional Student Portal visibility. Automated tab labels and operations are unchanged.

## 3. Actual quiz 2423 diagnosis

Read-only local evidence on November 5, approximately 19:36 +03:00:

| Condition | Actual state |
|---|---|
| Active year / current actual term | Year 6, 2026/2027; term **20**, type 1, belongs to year 6. |
| Original definition | ID **2423**, name `مذاكرة ف1`, type **2**, `is_file=1`, `has_traditional=0`, `question_picker=2`. |
| Creator | User **414**, account type **2** (Admin). |
| Class / section / subject | **1 / 130 / 406**, consistent with room year 6 and subject class 1. |
| Original maximum / duration | **50 / 40 minutes**. |
| Start, seconds preserved | **2026-11-04 19:13:44**. |
| End, seconds preserved | **2026-11-15 19:13:47**. |
| Effective application timezone | **Asia/Riyadh, UTC+03:00**. Existing duplicate timezone declarations were not changed. |
| Window resolver | `ongoing`, `allowed=true`; not expired. |
| Teacher timetable | Teacher **166**, authoritative schedule **4122**, section 130 / subject 406 / year 6 / term 20, Wednesday 13:20-14:00. Resolver `has(...)` is true. |
| Current eligible membership | **20** distinct students. Raw status counts alone are not the operational roster. |
| Original result rows | **0** for 2423. No school placeholders were created. |
| Explicit equivalence | Five members: original IDs **2423-2427**, sections **130, 131, 154, 155, 158**; same verified academic context/maximum. Different original dates remain untouched. |
| Cell continuity | **19 `missing`**, **1 `conflict`**. Missing is editable; it does not mean unauthorized/un-enrolled. |
| School manual status | Class 1 / actual term 20 is **OPEN**. Original entry is independent of this switch anyway; isolated LOCKED tests pass. |
| Actual controller/child render | Traditional roster **20** rows; Advanced **19** inputs with `data-exam="2423"`. |

### First failing condition: student 1101 only

`AssessmentContinuityService::resolve()` requires exactly one active placement in the target section for a verified equivalence context. Student **1101** has enrollment **1786** in section **130**, updated September 17; active placement **1367** remains in section **131**, effective August 25, with no end date. The legacy same-grade newer-enrollment compatibility rule admits this student to the operational roster, but **`$active->count() !== 1`** fails in continuity because there are zero active section-130 placements. No result exists for this student in the five mapped assessments.

This is a real enrollment/placement disagreement, not a missing quiz placeholder or expired window. It is deliberately still blocked in both entry paths. Correcting that student's academic placement requires a separately authorized data reconciliation; no enrollment/history relationship was changed here.

**A blanket Advanced editability failure for all students could not be reproduced from current database/resolver/rendered-child output.** No speculative permission fix was made. Real authenticated browser behavior remains to be checked; a source render cannot certify the owner's browser session/cache/assets.

## 4. Implemented entry improvements

- Both traditional branches use `traditionalAssessmentRows()` over original results, then the existing current-membership projection. No participation join defines student eligibility; unsaved rows have null original IDs and no saved mark.
- Existing and virtual rows use the same assessment-scoped student/file relation. Nullable legacy section fields are allowed when the authoritative student/assessment link identifies the context; unrelated assessment files are not returned by filter JSON. No files are moved or rewritten.
- Initial zero uses null coalescing; decimal input uses `step=any`. Blanks remain empty, not zeros or absence codes.
- Valid row-local forms inside cells plus explicit `form` ownership preserve native CSRF POST/redirect fallback. The AJAX enhancer also accepts associated form controls, retains delegated filtered-row saving and remembers returned result IDs even when an old filtered row has no usable hidden ID.
- Filter 0 restores all quiz rows. Empty uploads no longer crash. One mark field per student in the no-result branch; all filtered controls use the original assessment maximum.
- Expiry disables row Save controls as well as inputs and bulk actions even with explicit external form ownership.
- Existing no-reload single/bulk feedback, keyboard/scroll behavior, in-flight blocking, failed-value retention, zero/null semantics, atomic bulk validation and changed-result notification suppression remain. No calculation or weighting changed.

## 5. Consumer compatibility and boundaries

| Consumer | Finding / preservation |
|---|---|
| Teacher quiz/exam lists and optional modal | Both call the existing named Teacher POST route. Preselection reads `studentselect`; only traditional copy/semantics are refined. |
| Traditional Teacher entry and filters | Read-only roster projection; legitimate marks use the original shared writer. No GET insertion or roster backfill. |
| Student Portal `student_main_exams`, `student_main_quizes` | Existing `Exam_result2` IDs select visible assessments; therefore optional participation cannot simply be removed. Without it, a new traditional assessment appears for a student after a legitimate first mark creates the original result. No new automatic publication/show-result policy introduced. |
| Student start/submission/correction and API `Api/websitecontroller` | Existing attempts/list/result/submission consumers depend on original participation IDs; not converted to virtual participation, not edited. No external API route/payload changes. Source-inspected, not mobile-client acceptance-tested. |
| Automated Teacher views/correction | Existing definitions, selection, questions, results, files, calculation/publication and guarded placeholder-removal behavior retained. Existing automated/continuity regressions included. |
| Coordinator legacy Add Students | Separate `coordinatorcontroller::add_quize_student`; its old delete body is preceded by `AssessmentResultSafety::assertDeletable`, which blocks definitions with results/files/mappings. Not the shared Teacher service. Not changed or revived. The older school-controller quiz view's Teacher route reference was not treated as permission to bypass Teacher middleware. |
| Advanced/Admin shared readers and official reports | Original result IDs/context, aggregation/source mappings and explicit report-import boundary unchanged. No extra occurrence contribution or copied mark. |
| Equivalence, Academic Record, transfers | Existing original IDs/placement context remain authoritative. Carried/conflict guards retained; no mapping inference/normalization or historical correction. |

There is no need for blank participation rows merely to expose Teacher mark fields. They remain necessary for the existing optional Student Portal notification/participation contract and automated flows. This distinction is intentional, not a blind left join replacing participation everywhere.

## 6. Verification and preservation

- **153 tests / 3,497 assertions PASS**: focused Gradebook, assessment, templates/context, Teacher follow-up and timetable regressions, isolated SQLite `:memory:` and private test storage. Final focused rerun: **6 tests / 156 assertions PASS**.
- New fixtures exercise zero pre-enrollment, existing zero/earned/null rows, files including nullable legacy section, omitted students, direct first saves in traditional and Advanced entry, same-result repeated edits/synchronization, additive participation with marks/placeholders/submissions, automated guarded removal, transferred-out student denial and retained placement-conflict protection.
- Exact quiz-2423 dates/maximum/equivalence are reproduced in disposable fixtures. Tests prove missing-result entry under manual LOCKED, inclusive seconds at start/end, before-start/after-end rejection and stable original result identity. The real school window was never edited.
- Existing regression coverage retains original bounds, incorrect IDs/terms/rooms/timetables, duplicates, carried results/history, blank/zero, bulk rollback, notification idempotency, HTML redirect fallback and authorization. Frontend harnesses test in-flight duplicate prevention; serialized requests reuse the original row. **No real MariaDB concurrency/load exercise was performed.**
- **10 Node harnesses PASS**. The expanded legacy harness executes the actual six traditional filter branches with no result, null placeholder and zero; one field per student, valid maximum, no empty-upload exception. It also checks explicit form submit handling, returned ID reuse, no reload, JSON/CSRF, failure, keyboard and expiry behavior.
- **61 Blade views compile/PHP-lint** in disposable storage. Touched PHP files lint under PHP 7.4. UTF-8 without BOM checks and `git diff --check` pass. Pre-existing mojibake comments in the large legacy controller remain untouched; no new corrupted UI copy was introduced.
- Actual school evidence used PDO SELECTs in a **read-only transaction**, including query/resolver/child-view verification with an explicitly supplied Teacher actor and isolated shell/cache. It was not an authenticated browser click/save test.
- Before/after fingerprints match: **166 tables / 326,314 rows**, schemas/triggers, operational Gradebook JSON/status files and protected sources including `.env.example`, Config/Read/Status/template services and route/migration sources. SHA-256 **`c68e220434d6b36d018fc2477baf2ee3db15d5a99f725566223bd9cd9b29ffde`**. Private evidence is outside repository/web root in the task's `gradebook-quiz-2423-*` backup directory. This fingerprint is not a restorable database backup.

No school results, assessments, accounts, memberships, placements, reports, files, notifications, financial records or migration ledger were written. No school config/status JSON was written. No migration, commit, push or deployment.

## 7. Files changed in this pass

1. `app/Http/Controllers/TeacherController_New.php`
2. `app/Services/TeacherAssessmentService.php`
3. `resources/views/teachers2/teacher_quize_mark.blade.php`
4. `resources/views/teachers2/teacher_exam_mark.blade.php`
5. `resources/views/teachers2/teacher_quize_students.blade.php`
6. `resources/views/teachers2/teacher_exam_student.blade.php`
7. `resources/lang/ar/assessment_entry.php`
8. `resources/lang/en/assessment_entry.php`
9. `public/teachers_2/assets/js/legacy-grade-entry.js`
10. `public/teachers_2/assets/js/assessment-window.js`
11. `tests/Feature/GradebookSafetyTest.php`
12. `tests/Frontend/legacy-grade-entry.test.js`
13. This new report. Existing reports and unrelated unfinished work preserved.

## 8. Remaining acceptance checks

Browser discovery returned **no available browser**. No authenticated school POST or fabricated school assessment/student was used. Actual visual layout, browser console/network, native form association and focus/scroll/mobile behavior require browser acceptance; automated HTTP/DOM and JavaScript fixtures are not substituted for that claim.

On a disposable clone, as the genuinely assigned Teacher, open both traditional list -> entry paths without Add Students; save zero/decimal first marks, repeat edits, compare Advanced and traditional original IDs, restore All after either file filter, test a student with no upload, and inspect visible feedback/network without reload. Verify optional participation notifies/exposes only explicitly selected new students and never removes an old traditional result. Test expired, denied, rapid repeated and invalid bulk requests, current/history separation and automated attempts. Repeat at desktop and narrow RTL/mobile widths, and with JavaScript disabled for initial-row POST fallback.

For the real current quiz 2423, read-only acceptance should show 19 editable cells and one placement conflict at the recorded time. Do not bypass or silently reconcile student 1101, and do not save school marks just for QA. No broader all-students Advanced denial was reproduced at query/render level.
