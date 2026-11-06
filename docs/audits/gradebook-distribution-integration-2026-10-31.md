# Gradebook Distribution Integration and Dynamic Assessment Workflow

Date: 2026-10-31, Asia/Damascus. Scope: operational distribution improvements, not Phase 2C.

## 1. Result and Boundaries

Implemented two safe improvements in the existing Admin V2 workflow:

- The Admin individual-student review now displays each subject's actual configured component set instead of imposing oral/homework/exam columns on every subject. The subject grid also stops inventing those columns when an explicitly empty configuration is stored.
- The distribution editor now offers percentage input and **exact whole-number maximum-mark input**, plus allocated/remaining marks and clear validation feedback. Only reversible, existing-schema-compatible conversions are accepted. The request and stored JSON remain the existing percentage contract.

**Not implemented:** automatic subject hiding, bulk/default application, decimal-percentage storage, fractional assessment maxima, new weighting formulas, template adoption or broader Student/Teacher workflow rewrites. Their precise safety/approval boundaries are below. This is not a claim of full dynamic report-card/Student Portal integration.

Reviewed the architecture audit, full V2 migration report and relevant Phase 0A/0B, Phase 1, Phase 2A and Phase 2B reports against current source. Earlier reports describe earlier checkpoints; current SQL/files take precedence. No school form was submitted and no school data, configuration/status file, template record, assignment or schema was changed.

## 2. Actual Distribution-to-Grade Architecture

| Stage / consumer | Active code and storage | Actual context and meaning |
|---|---|---|
| Settings discovery | `Admin/GradebookSettingsController@index/viewRooms/viewSubjects`; `admin.gradebook.settings.*` | Globally current year; section must belong to it. Class lessons are listed. The section is a discovery context, not a separate distribution owner. Teacher labels remain current timetable-backed. |
| Operational editor | `/SMT/admin/gradebook/settings/edit/{subjectId}` -> `edit_json`; POST `settings/update/{subjectId}` | Subject and current year. Component IDs, source mappings, name, integer weight 0..100 and order remain authoritative. Existing explicit maxima survive saves; this editor does not change them. |
| Configuration | `GradebookConfigService`; default Storage disk `gradebook/{lesson}_{year}.json` | **Subject/year only**, shared by every section and actual term in that year. Class derives from `lessons.class_id`. No section/term application or inheritance table exists. |
| Configuration diagnostics | Phase 2A `GradebookContextReader` / context / snapshot | Optional read-only inspection of exact context, valid/missing/invalid/unreadable files and source hashes. It does not activate a versioned backend. Existing readers retain their contract. |
| Source definitions/results | `exams2` -> `exam_result2`; `lesson_teacher_room_term_exam` -> `exam_result` | Definitions retain original IDs and section/class/subject/actual-term context; term identifies year. Result `user_id` is the student ID in these legacy tables. A configured component is not an assessment occurrence. |
| Shared read | `GradebookReadService` and Phase 1 `AssessmentContinuityService` | Reads selected section's stored year and all actual terms, or an explicit term subset. Resolves exact sources, original results and approved continuity without copying or changing marks. |
| Advanced Teacher | `Teacher/TeacherGradebookController`, `teachers/gradebook/index` | Active year/current actual term, timetable authorization and current student membership. Already renders configured component columns. Numeric dynamic sources >=100 are editable through the existing guarded writer; legacy sources remain read-only here. |
| Ordinary Teacher assessments | Existing exam/quiz/manual/automated assessment screens and `TeacherAssessmentService` | Assessment-specific original maximum and results, not a new generic distribution engine. Current authorization, retained-result and carried/conflict protections remain. |
| Admin subject review | `GradebookController@viewGridSimple`, `view_by_subject_corrected` | Stored section/year; shared results/configuration. Existing representative term-type summary plus exact-assessment matrix. No aggregation on GET. |
| Admin student review | `GradebookController@viewStudentCard`, `view_by_student`, new `partials/student_components` | Current resolved membership/year; subject-specific configured IDs/names/bounds/values now presented separately. Existing term selection and totals remain unchanged. |
| Legacy report aggregation | `GradebookAggregationService`, explicit protected POST | Derived `students_marks.mark/mark2` JSON keyed by lesson ID. Imports fixed `oral`, `quize`, `exam` source values and respects report locks. Does not automatically adopt all dynamic components or run on page open. |
| Student results / report cards | `studentscontroller@results`, `student_view_report_card`; `students.results` and existing report views | Permanent student plus selected current academic context and stored `students_marks`, `report_cards`, report-design fields. These are a distinct legacy report contract, not live dynamic component configuration. |
| Parent mobile consumers | `routes/api.php`; `Api/websitecontroller@app_parent_children/homeworke/test/quize/exam/certificates` | Parent/child discovery plus legacy definition/result responses. Quiz/exam use current-year actual term, subject/type and student-filtered result relations; they do not read dynamic distribution JSON. These are not the Admin dynamic summary API. |
| Student Academic Record | `studentscontroller@academic_record_show`, `students.academic_record_show` | Owned selected placement/year/section, stored report JSON and original assessments/files/certificates. Does not directly load distribution JSON or Phase 2B versions. Original result occurrence/provenance remains separate from configured summaries. |
| Entry status | `GradebookStatusService`, `gradebook_status/{class}_{actualTermId}.json` | Existing OPEN/LOCKED Advanced dynamic-entry scope. Missing defaults LOCKED. Not a universal lock for all legacy assessment/report workflows. |

### Numeric and identity contract

Configuration envelope: `lesson_id`, `year_id`, `updated_at`, `components[]`. Each component retains `id`, `name`, `weight`, `data_source`, `sort_order`, optionally `max_mark`. Core IDs/sources are not interchangeable: the stored source determines the read, not its displayed name.

- `LEGACY_ORAL`: confirmed lesson-system results.
- `LEGACY_HOMEWORK`: modern type-2 quiz results; despite the internal name, it is not a separate universal homework grade store.
- `LEGACY_EXAM`: modern type-1 exams, excluding properly identified reserved dynamic containers.
- Numeric source >=100: exact `Dynamic_Section_N` container, scoped by section/class/subject/actual term/type. Names are not equivalence evidence.

Configured component maximum is the existing `GradebookReadService::componentMaximum`: explicit stored `max_mark`, otherwise `lessons.max_mark * weight / 100`. **Original assessment maximum** remains its definition's `mark`; a distribution edit does not rewrite that field.

Earned component value remains raw matching-source average, except `LEGACY_EXAM` maximum, rounded to one decimal. Total remains the sum of present component values. Percentages are **not** a newly introduced multiplication or normalization of earned marks. Zero is earned zero; missing remains null/dash; all-missing total remains null. Historical decimal result strings remain unchanged.

Malformed/conflicting/duplicate-context results retain existing issue handling. Explicit verified continuity can be current/carried/missing/conflict; unmapped previous-section history stays separately read-only and excluded from new totals. This task adds no invalidation status or fabricated invalidation history. Original assessment/result/equivalence identities are preserved.

## 3. Confirmed Versus Intended Behavior

| Area | Before | After this task |
|---|---|---|
| Admin subject grid | Configured columns, but empty-config fallback fabricated three fixed columns | Configured columns only; explicit empty state and original assessments still visible |
| Admin student card | Fixed oral/homework/exam columns with additional components tucked into one cell | Per-subject component tables with actual configured labels, IDs, configured bound and earned value |
| Term review | Representative actual term per type; exact occurrences below | Same selection; selected term ID is explicit presentation metadata. Other actual terms remain in detailed assessments, not silently combined |
| Distribution entry | Percentages only | Percentages plus exact integer-mark conversion where compatible |
| Allocation policy | Each percentage integer 0..100; total 100 was not required | Unchanged. Incomplete/excess totals get explicit warnings, not a new academic save restriction |
| Teacher/student reports | Advanced Teacher dynamic; report paths use their own legacy structures | Audited and left unchanged; no claim that their report schema now understands arbitrary dynamic columns |
| Subject discovery/default application | All class lessons; missing-file legacy defaults | Preserved pending the visibility/application decisions below |

The Admin controller adds a read-only presentation projection (`subject_id`, selected `term_id`, component ID/name/maximum/value) from the already-computed shared read. Existing legacy `details`, `additional` and total fields remain for compatibility. No result is fetched by matching names and no additional database queries are needed for the projection.

## 4. Percentage Versus Mark Conversion

Real schema SELECTs confirm **`lessons.max_mark` and `exams2.mark` are `int(11)`**. Subject maximum is a mutable subject property, not year/section/term/version-specific. Current subject totals include 0, 10, 40, 50, 100, 150, 200, 300, 400, 500 and 600. Zero-total subjects are not valid for mark conversion.

Existing weight validation accepts whole percentages only. An optional stored `max_mark` can independently override the calculated component bound, and source mappings do not themselves require percentages. Existing earned decimals are different from authorizing fractional allocation/maxima.

The new local JS enhancement uses bounded decimal parsing and integer/BigInt arithmetic, not floating-point rounding:

| Example | Result |
|---|---|
| Total 300; 20%, 30%, 50% | Exact bounds 60, 90, 150; reversible |
| Total 200; 50 marks | Exact 25% canonical input |
| Total 300; 150 marks | Exact 50% canonical input |
| Total 300; 100 or 50 marks | Rejected in mark mode: would require repeating fractional percentages |
| Total 150; 25% | Existing percentage behavior remains; mark mode unavailable because the derived 37.5 maximum would not fit current integer assessment columns safely |
| Independent explicit bound, reserved-ID/source mismatch, invalid total/weights | No mark-mode conversion; preserve existing percentage editing without repairing the configuration |

The requested **100 + 50 + 150 out of 300 cannot be represented exactly by the current whole-percentage contract**. Supporting it requires an approved absolute-bound or precision design; it was not approximated as 33/17/50 or silently rewritten.

Visible mark controls are unnamed and initially disabled. The component payload still contains existing named `components[*][weight]` controls and unchanged IDs/names/sources. Valid mark input updates those canonical fields exactly and invokes existing percentage feedback. Invalid input leaves the last valid values untouched, disables save and prevents normal submission with a localized explanation. Returning to percentage mode restores the last exact values, as the help text explains.

Mark mode additionally enables the optional `_allocation_subject_total` precondition. The server validates it and compares it with the freshly read subject maximum before saving, rejecting a stale rendered total with a clear localized error and no file write. Percentage mode omits it, so existing callers/validation remain compatible. This metadata is never saved in configuration JSON; it does not change maximum authority. This is a stale-total precondition, not a new global concurrent-file/revision transaction contract.

No-JS/no-BigInt browsers retain the original percentage workflow. Existing configurations are not converted on GET, mode selection or page initialization. New allocation totals/remainders are display diagnostics, not a second calculation engine. Explicit maxima are deliberately not editable through this mode.

## 5. Subject Visibility: Evidence and Safe Boundary

Read-only SQL compared real records with the current resolver's scope predicates: active year/current actual term, valid room/year/class/lesson, active Teacher, existing day and teaching slot in the same room with valid times. No assignment synchronization was invoked.

| Current year 6 / 2026/2027 | Class lessons | Effective scheduled subjects | Additional class-only lessons |
|---|---:|---:|---|
| Section 130, class 1 | 20 | 13 | 154 Cambridge Math; 280 المشروع; 281 السلوك; 410 الحساب سحري; 413 اللغة الفرنسية; 424 التمييز; 425 Sciences Cambridge |
| Section 132, class 2 | 18 | 13 | 157 Math; 300 السلوك; 414 اللغة الفرنسية; 426 Sciences Cambridge; 427 التمييز |

Neither sampled current section has modern Exams2 definitions/results. However, year-6 `students_marks` exists: 64 rows in section 130 and 45 in section 132. Both `mark` and `mark2` contain the extra lesson keys (128/90 document occurrences respectively), with **no numeric oral/homework/activities/quiz/exam values for those extra subjects**. A JSON key/document therefore does not prove a real earned mark; neither should it be erased or casually hidden as corrupt data.

There are real current-year unscheduled assignment pivots with open tracking periods, e.g. assignment 1421 (room 157/lesson 16), 1435 (room 166/lesson 7), 1448 (room 167/lesson 409). They were not declared stale, synchronized or removed. Conversely, annual pivots are intentionally retained as historical references, so raw pivots cannot independently grant current Teacher authority.

**No automatic hiding was implemented.** Existing configuration/result access and assigned-but-unscheduled subjects remain discoverable. This is an intentional safety boundary, not a claim that class-only lesson lists already filter to taught subjects.

Recommended approved visibility policy: a conservative relevant-subject union of validated scheduled subjects, legitimate unscheduled assignments, existing subject/year configuration, exact-context assessment/content/results and reliable report references; retain an obvious **all class subjects** fallback. Historical/ambiguous contexts should keep that fallback rather than infer current responsibility. Missing assignments/new-year setup must never yield a misleading blank list. The visible-subject policy must remain distinct from timetable-authoritative Teacher authorization.

Before default-filtering, approve how retained pivots versus legitimate unscheduled assignments are identified and how empty report scaffolds/content references count. Tests currently explicitly confirm unscheduled/configured subjects are not hidden and that their mere visibility grants no Teacher assignment permission.

## 6. Existing Defaults and Proposed Safe Application

`getDefaults()` already supplies three legacy core components with **zero weights** when no usable file is returned. This is fallback code, not a school-managed default-distribution record, inheritance system or bulk apply feature. A custom file is independent; changing default code would not update existing files and could silently reinterpret missing/invalid contexts.

Fresh filesystem evidence: five configs (`10_6`, `158_5`, `31_5`, `49_5`, `50_5`) and two status files. Current `10_6.json` already existed in the before-manifest and contains 20/40/40; it was not created or changed here. Historical `49_5` retains its known `legacy_homework` -> numeric 100 mismatch. No proposed 20/30/50 example was installed as a school default.

**Design only; no new default record, preview route, apply action or persistence was implemented.** A safe future workflow should:

1. Define a proposed distribution inside the familiar operational settings experience, not a resurrected template manager. Begin with explicitly supported core sources; dynamic additions need fresh per-target IDs/source allocation, not name matching or copied source numbers.
2. Choose year/classes/subjects and show every affected section. Deduplicate targets by **subject/year**. Reject a request implying section-only or term-only application, because the current storage cannot honor it.
3. Preview exact compatibility: total maximum, integer/precision limits, IDs/sources, missing/invalid/custom config, existing definitions/results, used dynamic containers and report context. Show old/new bytes or normalized display plus original hashes. Missing, malformed and explicit empty are different states.
4. Default to **skip all custom, invalid, ambiguous, explicit-bound and result-bearing contexts**. Do not overwrite earned-context definitions, resize old maxima, reassign sources or copy marks. Compatible missing contexts still require explicit review; built-in fallback is not proof that a new policy is historically correct.
5. Require scope/count confirmation and actor/reason. Revalidate hashes and activity at execution to reject stale previews. Configuration sharing must be clear before staff confirms.
6. Preserve previous file bytes and existence state privately, with an operational change journal and per-target status. Coordinate file writes/recovery explicitly: an SQL transaction cannot atomically roll back multiple JSON files. Recovery must compare current hashes/activity and never overwrite newer work or grades blindly.
7. Reopen only the resulting operational editor; do not automatically create exams, import grades, publish templates, change locks or declare a report final.

An auditable persisted default, revision/journal and safe recovery need approved persistence/schema or file-journal contracts. Phase 2B events belong to template entities and cannot simply be repurposed as operational config provenance. This is the requested approval boundary; no new template system or Phase 2C application was introduced.

## 7. Teacher, Student and Historical Compatibility

Advanced Teacher already uses dynamic config columns and the same source reader; only current timetable/membership-authorized context is editable. It retains current actual-term filtering, legacy-source read-only behavior, dynamic caps, locks, zero/null, original IDs and continuity protection. Teacher code/views were not modified.

Student results/report-card paths still use stored legacy report structures and report designs; Academic Record still uses selected placement/year/section plus original records. Their fixed stored fields cannot safely become arbitrary dynamic component IDs by renaming labels. Existing explicit imports aggregate legacy categories and have their own bounds/formulas/locks. This task intentionally does **not** copy new dynamic components into those JSON documents or rewrite issued reports.

Parent mobile methods were source-audited separately: child discovery uses operational membership, while legacy assessment methods return original definition/result structures rather than configured component summaries. Some definition queries filter subject/current term without an explicit room predicate, and the legacy `test_marks` query is broader than its selected subject/term. Parent lookup alone in these methods is not proof of a complete ownership/authorization contract. Their routing/middleware and mobile response contract require a separate scoped authorization/history review before claiming full dynamic Parent integration. They were not invoked, rewritten or certified by the PHP/UI regression suite. Existing source-specific hidden-result sentinels must not be reinterpreted as earned zero by a future adapter.

Further integration needs an approved mapping/publication contract between operational components, multiple assessment occurrences, stored report fields and historical placement context. Otherwise a dynamic Admin total may legitimately differ from a previously imported report. No automatic aggregation, weighting, final-result/promotion-policy change, correction or new historical version was performed.

## 8. Verification and Preservation

| Check | Result |
|---|---|
| Isolated PHP suite | **122 tests / 2,858 assertions PASS** |
| New focused cases | Distinct three/four component sets and totals 300/200; scoped HTML; configured versus original maxima; zero/missing/decimal values; canonical payload/round-trip; decimal-percent/stale-total rejection; year/term/section isolation; explicit bounds/source mismatch/empty config; unscheduled-subject visibility |
| Existing regressions | Authorization, real V2 shell, navigation, JSON/status, Teacher save, Admin/Teacher/Academic Record agreement, continuity/original IDs, timetable authority and legacy result protection |
| Frontend | **Six harnesses PASS**: exact units/events, native editor, template editor, Teacher save, status, continuity; new asset syntax passes |
| Blade | **43 views compile/lint** in disposable storage, including Gradebook/shared V2 views |
| PHP | Controller, new translations and affected tests pass PHP 7.4 lint |
| Encoding / whitespace | UTF-8 without BOM and obvious mojibake scans; `git diff --check` passes (line-ending warnings only) |
| School preservation | Identical before/after manifests for **166 tables / 326,261 rows**, schemas/triggers and all existing Gradebook config/status bytes |

Final suite uses `--process-isolation`, SQLite `:memory:` and fake Storage. Installed SQLite extensions are enabled only via the prior private test ini; project/global PHP configuration is untouched. Fixture mutations never connect to the school database. Existing Phase 2B regression publications are synthetic fixture operations only; school versions remain zero.

School SELECT-only manifests and protected-file hashes match:

`64f6404c4cbb36128be998d8b06d446ec270b72f2e36a54f4a664716265594ce`

This preserves marks, original definitions/results, report cards, placements, finances, assignments, equivalence, migration ledger, templates/events and the current/historical JSON files. Evidence is outside the repository/web root at `C:/Users/Lenovo/.codex/backups/gradebook-distribution-6db0aa118e3a46fab7aa46a00f2e0ac8`; these manifests are not a restorable database backup.

**Authenticated browser acceptance remains pending.** Tests render real V2 views and execute isolated DOM/event harnesses, but do not certify pixel layout, real mobile numeric-keyboard behavior, browser console/network or authenticated clicks. Manual QA should check unit switching, rejected 100/300 input, restoring percentages, add/remove rows in both modes, save/validation in an isolated clone, student component cards and responsive table scrolling. Do not mutate school records for demonstration.

## 9. Files Changed

- `app/Http/Controllers/Admin/GradebookController.php`: additive read-only presentation projection; existing calculations/totals retained.
- `app/Http/Controllers/Admin/GradebookSettingsController.php`: optional mark-mode stale-total validation only; old percentage requests remain compatible.
- `resources/views/admin/gradebook/view_by_student.blade.php`: subject-specific component presentation.
- New `resources/views/admin/gradebook/partials/student_components.blade.php`.
- `resources/views/admin/gradebook/view_by_subject_corrected.blade.php`: truthful empty configuration instead of fixed fallback columns.
- `resources/views/admin/gradebook/settings/edit_json.blade.php`: mode controls, unnamed mark inputs and compatibility metadata; original named fields/native row script preserved.
- New `public/assets/admin/js/gradebook-distribution-units.js`.
- `public/assets/admin/css/gradebook-admin-v2.css`: scoped allocation presentation only.
- New `resources/lang/ar/gradebook_distribution.php` and English counterpart.
- `tests/Feature/GradebookAdminV2Test.php`: focused integration coverage.
- `tests/Feature/GradebookSafetyTest.php`: former fixed additional-column label assertion updated to the configured-bound/project presentation; value/context assertions retained.
- New `tests/Frontend/gradebook-distribution-units.test.js`.
- This report.

No routes, configuration/status service, shared calculator, Teacher/Student controller, membership/assignment service, template backend, financial code or schema changed. Previous unfinished work and `.env.example` are preserved. No ordinary template discovery link was reintroduced.

## 10. Exact Owner Decisions Needed Next

1. **Unrepresentable allocations such as 100/50/150 out of 300:** retain the current exact subset, or approve a separate absolute-bound/decimal-percentage design with compatibility and historical protections. Recommendation: keep the exact subset until a reviewed contract is approved; do not loosen validation or round as a shortcut.
2. **Subject visibility:** approve a conservative union plus an explicit all-subjects fallback, and define legitimate unscheduled assignment evidence. Recommendation: do not use timetable-only hiding or raw annual pivots as authorization.
3. **Unified default:** approve default/revision/change-journal persistence and recovery first, then a read-only target preview. Recommendation: skip existing custom/used contexts initially and keep subject/year-wide scope explicit. No bulk application yet.
4. **Student/report integration:** approve how arbitrary components map to report structures and publication, distinct from live Admin summaries. Recommendation: preserve old reports/original marks and do not automatically aggregate new components into historical documents.

Safe Admin dynamic presentation and exact-input progress is implemented. Wider automatic integration remains deliberately gated by these decisions. **No commit, push or deployment.**
