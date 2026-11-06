# Assessment continuity and safe-deletion root-cause resolution

Date: 2026-11-05. Local school database: `aladham_oct`; PHP 7.4 / Laravel 7.30.6 / MariaDB.

## Outcome and evidence boundary

Fixed the contradictory operational eligibility/continuity contracts, not just their warnings. Actual-data resolver checks remove **all seven false conflicts across the three requested sections**, without changing school rows. Genuine ambiguity, earlier earned equivalent results, original IDs, assessment windows and historical reads stay protected.

**Empty equivalent-member deletion is approval-blocked, not implemented or claimed solved.** Its exact storage/audit blocker and the smallest proposed removal contract are below. No migration or workaround that discards verification history was introduced.

Read the November 5 quiz-2423 and Admin-modal/2428 reports and the Phase 1 implementation/activation contracts against current source. All school access in this pass used PDO `SET TRANSACTION READ ONLY` plus a transaction, including application resolver/controller reads. Isolated tests used SQLite `:memory:` and private storage. No browser surfaces were available (`apps=[]`, `browsers=[]`); CLI actor injection/controller rendering is not an authenticated browser test.

Private evidence is outside the repository/web root:
`C:/Users/Lenovo/.codex/backups/gradebook-continuity-5911011e80de4c098676c41668497dfa/`.
It contains before/after table/schema/trigger/config fingerprints, complete ID-based roster/enrollment/placement/transfer/result evidence, rendered child/Admin HTML and render checks. No account credential is included in this report.

## 1. Complete affected-assessment matrix

Inspection at approximately **21:59 +03:00**, November 5. Globally active year **6 (2026/2027)**; current actual term **20**, first term, belongs to year 6. Every requested definition has class **1**, subject **406 (Informatics)**, type **2 (quiz)**, `is_file=1`, `has_traditional=0`, maximum **50**, creator **414 / Admin type 2**. Current authoritative timetable authorization for Teacher **166 / account 1836** succeeds in all three sections.

| Original quiz / section | Explicit group | Current roster | Before: missing / conflict / carried | After: missing / conflict / carried | Original results / placeholders / student uploads | Entry window |
|---|---|---:|---|---|---|---|
| 2428 / 130 | B | 20 | 19 / 1 / 0 | 20 / 0 / 0 | 0 / 0 / 0 | Nov 4 21:03:16 through Nov 12 21:03:21; open |
| 2424 / 131 | A | 21 | 17 / 4 / 0 | 21 / 0 / 0 | 0 / 0 / 0 | Nov 8 19:13:44 through Nov 15 19:13:47; **not started** |
| 2430 / 154 | B | 20 | 18 / 2 / 0 | 20 / 0 / 0 | 0 / 0 / 0 | Nov 4 21:03:16 through Nov 12 21:03:21; open |

There are no earned results, placeholders or `exams_files` rows anywhere in **either complete group**, not just the three selected members. All 61 target-section enrollment students satisfy the existing operational roster scope; no enrollment was omitted by that scope. The seven failures were checked individually, not extrapolated from student 1101.

Missing is an academic result state, not an override of an assessment window. After the fix **40 students** across 2428/2430 are entry-eligible. All **21 students** on 2424 must still wait for its November 8 start unless an authorized Admin intentionally changes that definition through the existing workflow. This pass did not change dates.

### Explicit identities and all members

- Group A: `306e1810-782f-443a-8e61-fd345bc2915b`, membership IDs **1-5**, verified by **414** at **2026-11-05 19:14:05**, evidence `Explicit multi-section assessment creation`.
- Group B: `074f8dd4-3c68-4db0-b6fd-ac83fb45da4f`, membership IDs **6-10**, verified by **414** at **2026-11-05 21:03:50**, same explicit creation evidence.

| Group | Original assessment IDs -> section IDs | Original title | Start / end |
|---|---|---|---|
| A | 2423 -> 130 | مذاكرة ف1 | Nov 4 19:13:44 / Nov 15 19:13:47 |
| A | 2424 -> 131; 2425 -> 154; 2426 -> 155; 2427 -> 158 | مذاكرة ف1 | Nov 8 19:13:44 / Nov 15 19:13:47 |
| B | 2428 -> 130; 2429 -> 131; 2430 -> 154; 2431 -> 155; 2432 -> 158 | مذاكرة ف11 | Nov 4 21:03:16 / Nov 12 21:03:21 |

All mapped context/maxima agree with their original definitions. These are two separate occurrences; neither titles nor similar dates establish equivalence. Different window dates in A are not a mapping-context mismatch.

### Current rosters (permanent student IDs)

- Section 130: 1047, 1073, 1074, 1076, 1077, 1078, 1079, 1080, 1081, 1082, 1083, 1084, 1085, 1086, 1087, 1088, 1089, 1101, 1361, 1566.
- Section 131: 1057, 1066, 1068, 1092, 1093, 1094, 1096, 1097, 1098, 1099, 1102, 1103, 1104, 1105, 1106, 1107, 1108, 1113, 1567, 1568, 1589.
- Section 154: 1049, 1112, 1114, 1115, 1116, 1117, 1118, 1119, 1120, 1121, 1122, 1123, 1124, 1125, 1126, 1127, 1128, 1362, 1363, 1364.

The private matrices include every roster student's current enrollment, all year-6 placements/effective dates and transfer rows. The other **54** students already passed the physical target-placement check; their academic state remains missing.

## 2. Every blocked student's first failing condition

All seven have exactly one year-6 enrollment and one active same-grade placement, but in different sections. The enrollment is newer than the stored placement update. None has a competing enrollment, another active placement, a prior target-section placement or any transfer-history event. All seven have zero group-A/B results/files.

| Student | Affected quiz | Enrollment ID -> operational section | Enrollment updated (conservative boundary) | Placement ID -> stored section | Placement effective_from | Placement updated |
|---:|---:|---|---|---|---|---|
| 1101 | 2428 | 1786 -> 130 | 2026-09-17 15:05:23 | 1367 -> 131 | 2026-08-25 13:35:14 | 2026-08-25 16:35:14 |
| 1057 | 2424 | 1742 -> 131 | 2026-09-17 15:08:19 | 1323 -> 130 | 2026-08-24 13:11:30 | 2026-08-24 16:11:30 |
| 1066 | 2424 | 1751 -> 131 | 2026-10-21 12:39:29 | 1332 -> 130 | 2026-08-25 10:18:45 | 2026-08-25 13:18:45 |
| 1068 | 2424 | 1753 -> 131 | 2026-09-17 15:07:45 | 1334 -> 130 | 2026-08-25 11:20:38 | 2026-08-25 14:20:38 |
| 1113 | 2424 | 1798 -> 131 | 2026-09-03 15:14:27 | 1379 -> 154 | 2026-08-26 10:48:38 | 2026-08-26 13:48:38 |
| 1049 | 2430 | 1734 -> 154 | 2026-09-03 15:17:52 | 1315 -> 130 | 2026-08-24 12:26:18 | 2026-08-24 15:26:18 |
| 1364 | 2430 | 2049 -> 154 | 2026-10-21 12:41:41 | 1851 -> 155 | 2026-09-16 10:43:36 | 2026-09-16 13:43:36 |

For **each row**, the exact first continuity failure was:
`history.where(status=active).where(room_id=target).count() == 0`, leading to `placement_context`. No result duplication, invalid maximum, malformed equivalence, carried mark or missing participation placeholder caused those failures. For the four students on 2424, the independent entry-window check also correctly rejects an actual save before November 8.

Other actual academic data must not be confused with this group: student **1101** has original result **42231**, independent quiz **2422**, section **130**, lesson **406**, term **20**, value **7**, raw `Created_at=2026-11-05 21:45:50`. It belongs to neither identity and is unchanged. No other year-6 `exam_result2` row was found for the other six students in the joined original-definition/year check. This does not claim they have no older-year or legacy-system academic history.

## 3. Root causes and authoritative contracts

### A. Contradictory operational and continuity eligibility

`CurrentStudentMembership::constrain` already accepts a later same-grade enrollment when one effective active placement is stale, with no competing placement/enrollment or later/undated transfer. Traditional rosters, `Exam_result2::currentRoster`, `Room::operationalStudents`, `TeacherAssessmentService` and current Gradebook membership use that scope.

Continuity separately required a physically matching active target placement. It rejected students that those same operational entry paths legitimately admitted. The seven database contexts demonstrate this contradiction across three sections.

Added `CurrentStudentMembership::assessmentEntryContexts` as a **read-only operational evidence contract**, not a replacement placement model or historical resolver. It first reuses the unchanged membership scope and batches placements/enrollments. Normal matching placements retain their real interval. Legacy compatibility requires one enrollment, one effective active same-grade placement, the existing chronology/transfer safeguards, no prior visit to the target section, and a non-future projection timestamp. It returns the stored placement ID/room separately from the effective operational room.

The conservative entry boundary is `max(placement.effective_from, enrollment.updated_at)`. It is not presented as an actual transfer date and is never written to a placement or transfer event. Missing evidence remains a row conflict; genuinely competing placements remain outside authorized current membership.

### B. Historical ownership must not be fabricated

`AssessmentContinuityService` consumes that context for both traditional and Advanced entry. Results still reference their **original assessment/result/student/section/subject/actual-term IDs**. It does not copy, move or relabel an earned result.

- A missing result in a proven operational context can be entered normally.
- A new target-original result timestamp at/after the conservative boundary is current and can subsequently be edited using the same result ID.
- A valid earlier equivalent result from the stored source placement is carried/read-only, including zero.
- The stale physical source interval is not treated as continuing operational ownership after that boundary.
- A result without reliable time evidence, before the target boundary without a real interval, with overlapping ownership, duplicates, incompatible context or more than one earned equivalent remains blocked.
- A prior target-section placement is not synthesized into a return visit. That requires actual interval reconciliation, consistent with the existing transfer return-visit protection.
- Real matching-placement paths retain their original timestamp/interval behavior. The existing MySQL `Created_at` fallback remains in use.

### C. Window and independent occurrence contracts

No date/window bypass, `allow_conflicts`, title inference or whole-roster permission override was added. Quiz 2424 remains upcoming. Quiz 2422 and genuinely independent new quizzes remain independent. `TeacherAssessmentService` still checks current year, actual term, timetable responsibility and student membership, and retains its student/definition locks and transaction.

### Sources by responsibility

| Responsibility | Source/contract |
|---|---|
| Current roster and Teacher eligibility | Existing `CurrentStudentMembership` plus current timetable authorization |
| Current continuity entry boundary | New evidence-only method in that same membership service |
| Original earned mark ownership | Original definition/result context and real placement intervals; narrowly proven current operational interval only for target results |
| Cross-section equivalence | Explicit verified `assessment_equivalence_members`; never names/dates |
| Transferred historical marks | Original rows and closed placement intervals; receiving equivalent stays read-only |
| Admin eligibility/readers | Existing current membership and `GradebookReadService`; no new Admin rights |
| Official Academic Record | Selected stored placement/year/room and original records; no synthetic historical interval or widened query |

The compatibility layer does **not** repair the Academic Record's stale stored section or automatically expose new-section data under an old-section placement. New marks retain correct original section context and remain queryable there. Full placement-timeline completeness for these seven students requires the separately approved reconciliation below. Current transfer safeguards are not bypassed to force a subsequent transfer from an inconsistent stored placement.

## 4. Deletion audit and exact policy

Active mutation route remains POST `/SMT/admin/class/room/exam_quize/delete` -> `DashboardController::exam_quize_delete`, existing auth/Admin middleware and `delete_quize`/`delete_exam` ability. The account-specific confirmation value is still `users.view_password`, checked using the existing nonempty/hash-equality contract; no credential reset or disclosure.

Inside its transaction, the action locks the original definition and calls `AssessmentResultSafety::assertDeletable`. The model's `PreservesAssessmentResults` deleting event rechecks it. `hasRecords` also protects definition restructuring and therefore must not be globally weakened just to enable deletion.

| Category | Current safe behavior / decision |
|---|---|
| A: empty independent original | Existing authorized deletion remains available; isolated HTTP tests prove removal and success after commit. |
| B: empty explicit group member | **No unlink/delete implemented in this pass.** Audit contract/schema approval is needed; see below. |
| C: unused placeholders only | Retain. Student/API assignment visibility, automated attempt state, `show_result`, participation and notifications use these rows; null mark does not prove no dependency. No bulk placeholder purge. |
| D: earned result, attempt, upload, carried provenance or historical reference | Retain. No force-delete or dependent student-file/result deletion. |

For each of **2428, 2424 and 2430**, and the other seven members, the immediate deletion dependency is **explicit equivalence membership alone**, not student results/uploads. Zero results was verified across both groups. This is not an assertion that membership must permanently ban deletion.

### Why B cannot safely be enabled under the current contract

1. The only stored verification/audit is the membership itself: identity, original exam ID, verifier, evidence and timestamp. The existing service explicitly exposes append-only verification, not removal. Deleting that row erases its provenance.
2. Its non-null unique `exam_id` has a restrictive FK to `exams2`. Retaining a tombstone while deleting the original is not possible in the existing shape. Removing a two-member group down to one also violates continuity's minimum-two-member validity contract and would make remaining rows conflict unless explicitly dissolved.
3. There is no generic assessment audit store. `gradebook_events.template_id` is non-null and FK-bound to a real template. These legacy groups have no template identity; inventing a template or attaching the event to an unrelated one would falsify history. Complaint/follow-up/lifecycle audit stores have unrelated entity contracts; `events` and `teacher_events` are calendar/content data, not audit journals. Rewriting another member's verification text to hide a deletion event is not an append-only audit contract.
4. `GradebookReadService` uses surviving memberships both for carry and exclusion from unmapped history. A nominally empty member can still be a receiving historical identity when another member has an earned result. Deletion must check the whole group, not merely the target's rows.
5. SQLite fixture tests do not establish MariaDB multi-request race safety. No unaudited unlink was shipped on the strength of a unit test.

### Smallest owner-approval alternative (not executed)

Approve an additive assessment-removal audit/tombstone structure independent of template IDs, or retaining originals via a separately approved retirement contract. Do not reuse the unrelated template event FK. With that approved contract, implement an atomic removal service:

1. Authenticate/authorize and verify the same account confirmation code; authorize the current operation again inside its stable context.
2. Lock all original group definitions in ascending ID order, then membership/dependency rows; verify membership is still the exact expected set. Align mutation lock order with mark/participation/attempt/upload writers and equivalence verification, or use a common reviewed serialization anchor.
3. Initially allow only **entirely unused groups**: no result/placeholder, attempt, student file, carried/historical dependency or unreviewed external reference anywhere in the group. Do not remove a receiving member for an existing earned equivalent just because the member has no local row.
4. Append a durable audit snapshot of removed definition, exact membership/verifier/evidence, actor, reason and survivors in the same transaction. Preserve all survivor original IDs and records.
5. Unlink/delete the selected empty original only after revalidation. If two or more remain, retain the same identity; if only one remains, explicitly dissolve that now-independent membership and audit that transition too. No invalid singleton or dangling FK.
6. Revalidate affected counts before commit. Repeat requests return a clear already-removed/not-found state, not another destructive mutation. Transaction failure restores all database state; do not remove handout files ahead of commit without a reviewed recovery strategy.
7. Prove true MariaDB concurrent mark/participation/upload/verify/delete interleavings on a disposable clone before enabling removal.

No proposed migration, tombstone, retirement flag, group removal or school deletion was applied. Existing empty-independent behavior is preserved, not newly certified against every legacy raw/API writer. In particular, not every legacy upload/result mutation is known to share the definition lock, and `exam_result2`/`exams_files` lack database FKs to the original in this schema. That is a concrete concurrency prerequisite for expanded deletion, not grounds to erase existing data now.

### Dependent consumers inspected

- Traditional/Advanced `TeacherAssessmentService`, original model saving hooks and participation notifications.
- `AssessmentResultSafety`, `PreservesAssessmentResults`, `PreservesEarnedResult` and the equivalence migration's FK/unique constraints.
- `GradebookReadService` aggregation/carry/unmapped-history projection and `GradebookDistributionImpact` retained-configuration checks.
- Student `student_exam`/quiz visibility through original participation IDs, original result/attempt/upload actions, Academic Record selected-placement queries and medals/results.
- Legacy mobile `Api/websitecontroller` original results/files and participation-driven assessment lists; no API response or authentication contract changed.
- Teacher `export_exam` / `export_exam1` official-mark imports and existing capped mark/report structures. No formula/rescaling change.
- `exam_questions` definition links; notifications carry student/room/subject/term/title but no authoritative original `exam_id`, so notification absence/matching title is not a reliable dependency proof.

## 5. Dedicated read-only reconciliation proposals

**No genuinely competing active placements were found in these 61 rosters.** Operational section is established by the existing strict membership rule for all seven stale rows. The actual historical movement instant is **not** established by a projection's update time; it may reflect another edit. Current code fixes entry without inventing that instant. Database timeline correction still requires owner approval and school confirmation of the effective date.

All rows below are year **6**, class **1**. Keep the listed enrollment row exactly as-is. Conditional proposal: close the listed old placement with an owner-confirmed `effective_to=T`; append a new active placement in the indicated target with `effective_from=T`, an approved reconciliation reason/source/actor; append an audit/transfer event referencing both placement IDs and the preserved enrollment. **Do not overwrite the old placement's room.** The enrollment timestamp above is evidence to investigate, not an automatically approved T.

| Student | Old placement to close (current section -> recommended operational section) | Existing mark scaffold to preserve unchanged | Proposed new active row / history implications |
|---:|---|---|---|
| 1101 | 1367: 131 -> 130; enrollment 1786 | `students_marks` 1775 in 131 | New student=1101/year=6/class=1/room=130. Preserve independent result 42231/quiz 2422/value 7 in 130. T must be consistent with that result's provenance; no reassignment. |
| 1057 | 1323: 130 -> 131; enrollment 1742 | `students_marks` 1731 in 130 | New student=1057/year=6/class=1/room=131. No group-A/B earned result to move. |
| 1066 | 1332: 130 -> 131; enrollment 1751 | `students_marks` 1740 in 130 | New student=1066/year=6/class=1/room=131. Confirm whether Oct 21 update is movement or another edit before choosing T. |
| 1068 | 1334: 130 -> 131; enrollment 1753 | `students_marks` 1742 in 130 | New student=1068/year=6/class=1/room=131. Preserve original scaffold/context. |
| 1113 | 1379: 154 -> 131; enrollment 1798 | `students_marks` 1787 in 154 | New student=1113/year=6/class=1/room=131. Preserve prior section 154 interval. |
| 1049 | 1315: 130 -> 154; enrollment 1734 | `students_marks` 1723 in 130 | New student=1049/year=6/class=1/room=154. Preserve original section 130 interval. |
| 1364 | 1851: 155 -> 154; enrollment 2049 | `students_marks` 2259 in 155 | New student=1364/year=6/class=1/room=154. Confirm Oct 21 movement date independently. |

For every row: current stored `status=active`, `effective_to=NULL`, reason/source `student_creation / admin_student_creation`; exact effective_from/updated values are in section 2. All seven have no transfer-history rows, no year-6 report-card row, and no `exams_files` row in the checked student-file query. Their existing marks scaffolds are real historical/contextual records; this pass did not treat them as disposable or move them to the new section. Group memberships are A/B as listed, never student-specific replacement results.

The current safe transfer service expects coherent active placement/enrollment and maintains both on a normal new transfer. These legacy rows predate the queried updates, with no transfer event explaining the difference. The database cannot identify which past writer or operator performed the enrollment-only edits; this audit does not attribute them to a specific current route without evidence.

### Approval, transaction and rollback requirements for each row

1. Obtain owner-confirmed destination and T, inspect all academic systems for that student/year (including legacy results, mark JSON, reports, certificates and scoped files), and take a restorable scoped backup plus fingerprints. These proposals are not execution scripts.
2. In one controlled transaction lock student, enrollment and all student/year placements; compare the exact before IDs/status/rooms/timestamps in this report with live rows. Reject any drift, competing row, target visit or intervening transfer. Recheck all historical dependency contexts at the approved T.
3. Preserve account/personal/financial data and all originals. Close only the specified old placement; append the approved new placement and audit/transfer event. Create a target mark/report scaffold only if genuinely required and absent, never by moving/copying earned values. The current stale-context mismatch must not be bypassed via a generic transfer override.
4. Assert one effective active placement, unchanged enrollment identity and historical result/financial fingerprints, and correct Academic Record visibility before commit. On failure roll back the entire transaction.
5. After commit, a reversal is a separately approved auditable correction, not blind deletion of new history. Restoring a captured before state is only safe if no later academic activity exists; otherwise preserve both actions and correct forward. No reconciliation was executed here.

## 6. Verification and preservation

### Automated and actual-data verification

- Focused isolated regressions cover proven stale same-grade entry, two distinct stale source sections in a three-member group, traditional/Advanced parity, zero/new result/original-ID edits, independent occurrences, earlier earned equivalent zero, missing timestamps/pre-boundary results, overlapping/return-visit history, stale-source results after boundary, competing active placements, competing enrollments, later/undated transfers, cross-grade and future projection denial.
- Existing safety regressions cover transfers/carried originals, multiple occurrences/terms, current-year/actual-term/timetable boundaries, automated forms/model hooks, Student Academic Record, official report imports/caps, Admin permissions, account confirmation code/CSRF and retained results/files.
- Empty mapped definitions and unused placeholders remain protected, including repeated delete requests, preserved notification/evidence rows, restrictive-FK failure and rollback. New post-save failure fixture proves mark transaction rollback; ordered delete-before/save/delete-after checks preserve the same group and original result. These are **not** claimed to be real concurrent MariaDB race tests.
- Full isolated suite: **164 tests / 3,765 assertions PASS** (Gradebook, assessment, timetable and related follow-up regressions). Ten frontend fixture harnesses pass. **63 Blade views compiled and PHP-linted** using disposable cache/storage. Modified PHP files lint successfully; `git diff --check` passes. Modified files are valid UTF-8 without BOM, with no new mojibake.
- Actual Admin `room_quizes` pages rendered using Admin 414 and the real Admin V2 layout for 130/131/154. Listed original IDs respectively: **2422/2423/2428**, **2424/2429**, **2425/2430**. Traditional controller child rendering using Teacher 1836 and the isolated shell produced **20/21/20** rows and mark inputs; Advanced controller columns give matching missing states and entry-window flags **true/false/true**. Traditional window JavaScript/server guards remain in effect; input presence alone does not mean 2424 may be saved.
- Read-only school checks after the final source change still give zero conflicts for all three rosters, no new original result, no new membership and no upload changes. No school create/delete/save request was issued.

The new context method batches enrollments/placements, not one query per student. A mapped assessment adds two batch reads compared with the old eligible-ID lookup; per-member context validation remains unchanged. No roster-size-dependent query loop or cache of mutable authorization was introduced.

### Before/after fingerprints

Fresh task baseline and final manifest match byte-for-byte: **166 tables / 326,326 rows**, all row-content hashes, table schemas, triggers, operational Gradebook JSON/status files and protected sources including `.env.example`, Config/Read/Status/template services and the existing route/migration files.

Manifest SHA-256: **`b712e069017b7a522f20c3789d9128b2cdbb17c362e14c53c6a06745725c8e4c`**.

Fingerprints are equality evidence, not a restorable backup. No school enrollment, placement, transfer, mark, result, definition, membership, file, report, account, notification, finance or migration-ledger row was written. No Gradebook JSON/status file write, migration, commit, push or deployment. Unrelated unfinished work and existing reports were preserved.

## 7. Files changed in this pass

1. `app/Services/CurrentStudentMembership.php`: new read-only assessment entry-context/evidence method; existing membership scope unchanged.
2. `app/Services/AssessmentContinuityService.php`: consume shared operational evidence while retaining original/historical ownership guards.
3. `tests/Feature/GradebookSafetyTest.php`: six new regressions and two existing conflict fixtures made genuinely ambiguous rather than merely stale.
4. This new report. No UI, controller, route, safety/deletion service, schema, localization or operational configuration change.

## 8. Manual acceptance / remaining approvals

1. Log in as Teacher 166; open the three exact requested pages and Advanced Informatics grids. Confirm 20/21/20 current students and no seven stale-placement conflicts. Check long Arabic names, keyboard navigation and AJAX errors on desktop/mobile.
2. On a disposable clone, save zero and another mark for one of the seven via each entry path; reload and edit the same original result ID. Verify no copy in another section or equivalence group and no change to historical originals/accounts/finance.
3. Confirm 2424 shows its upcoming state and rejects saves until its configured November 8 start; do not force the clock/window on school data for QA.
4. Confirm genuine conflicting projections remain denied, and prior earned equivalents remain visible/read-only without a receiving result. Confirm independent quiz 2422/result 42231 stays intact.
5. On disposable data, test existing deletion with wrong/right account code, empty independent original, mapped empty member, placeholder, earned result and upload. B/C/D must remain protected until a separately approved removal contract exists.
6. Approve/review the additive audit/tombstone removal design before enabling B. Real concurrent MariaDB mark/upload/participation/delete coverage is still required for that future change.
7. Confirm school effective movement dates and explicitly approve each reconciliation row before modifying history. Stale Academic Record section/timeline precision is intentionally not fabricated by this source compatibility fix.

**Result:** recurring false continuity blocks resolved at source, with actual-data and isolated-entry evidence. Empty equivalent-member deletion and physical historical reconciliation remain explicitly approval-gated; no unsafe deletion or invented school transfer was performed.
