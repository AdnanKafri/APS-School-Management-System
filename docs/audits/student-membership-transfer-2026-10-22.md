# Current student membership and transfer audit

Date: 2026-10-22, Asia/Damascus. Local database only. No data repair performed.

The complete numeric-ID preview is in
`student-membership-discrepancies-2026-10-22.json`. It contains no student
names, credentials, phone numbers or financial amounts.

## Evidence and root causes

The active year is `years.id=6` (`2026/2027`). There are 967 active-year
`room_student` rows and no duplicate student/year enrollment rows. The year has
977 active, 407 closed and 255 withdrawn placement rows; no student has two
active placements in this year. Ten active placements have no matching
enrollment. These are discrepancies, not permission to infer an enrollment.

126 current enrollments disagree with the active placement's room. All 126
are same-grade differences, not current cross-grade differences:

| Stale placement source | Count |
| --- | ---: |
| Student creation | 63 |
| Earlier manual cross-grade transfer | 61 |
| Restore | 1 |
| Year rollover | 1 |

The current Admin details form submits to `admincontroller@student_update`.
That action previously assigned `room_student.room_id` directly, without a
placement close/open, transfer event or new-room academic scaffold. This
explains a later section move leaving an older creation/transfer placement
behind. The legacy `DashboardController@student_change` route also bypassed
the safe service and contained destructive academic-row handling.

Follow-up previously allowed only a very narrow stale *creation* placement
exception. Its effective eligible population was 904, against 967 current
enrollments. The other 63 stale same-grade cases were omitted. Separately,
assessment grading pages used saved result rows as rosters, retaining
transferred-out students and omitting transferred-in students who had no
result scaffold. Several aggregate mark queries selected the first student/
year row, which can belong to a previous room or grade.

## Concrete examples (no personal information)

| Student | Current enrollment room / class | Stale placement room / class | Existing mark rooms in year 6 |
| --- | --- | --- | --- |
| 340 | 132 / 2 | 157 / 2 | 130, 157 |
| 359 | 156 / 2 | 133 / 2 | 154, 133 |
| 386 | 137 / 4 | 160 / 4 | 159, 160 |
| 1543 | 152 / 61 | 153 / 61 | 153 |

For student 340, transfer event 699 recorded room 130 -> 157 on August 31;
enrollment was subsequently changed to 132 on September 3 without a new
placement/event. Room 157 has teacher 151 / lesson 13 (assignment 1409),
whereas room 132 has teacher 76 / lesson 13 (assignment 1370). The old
assignment must not authorize new work for this student.

Existing follow-ups also survive these mismatches. Examples: student 1048
is enrolled in 158 with placement 130, student 1049 in 154 with placement
130, and student 1101 in 130 with placement 131; each has an existing
follow-up. No follow-up author, timestamp or context was changed.

Sample roster counts after the correction:

| Room | Current roster | Follow-up before | Follow-up after |
| --- | ---: | ---: | ---: |
| 130 | 21 | 21 | 21 |
| 131 | 20 | 20 | 20 |
| 132 | 22 | 21 | 22 |
| 157 | 21 | 19 | 21 |
| 158 | 19 | 19 | 19 |

Assignments 1458 and 1462 still refer to teacher 166, lesson 406, year 6,
rooms 130 and 158 respectively. No assignment was inferred or modified.

## Membership contract

`room_student` is the current enrollment projection for a student/year.
Rooms belong to one class and one year. Placements are the append-only
context/history, with effective interval `[effective_from, effective_to)`.
An active status in a future year is preparation, not global current
membership. Teacher assignments are separate year/class/room/lesson rows.

`CurrentStudentMembership` is the shared operational check:

- Require operational student lifecycle, a valid room/year enrollment and
  one effective active placement in that year.
- A matching placement determines eligibility even when a competing stale
  enrollment row exists; the other room does not gain access.
- Multiple active placements fail closed. Missing, closed-only or future-
  effective placements do not authorize academic mutations.
- A unique later enrollment edit may supersede one stale placement only
  within the same grade, with valid original room/year/class relationships,
  a later enrollment timestamp and no unknown/newer transfer event.
- Never treat that stale placement as the new record's placement ID.
  Follow-ups keep the actual current room/year/class and a null placement
  reference until separately approved reconciliation.
- Duplicate enrollment rows for the same room do not duplicate student
  rosters. Ambiguous enrollment across rooms without a single matching
  placement remains denied.

Historical queries intentionally retain the unscoped `Student::room()`
relationship. `Room::operationalStudents()` and `Student::currentMembership()`
are operational APIs. Do not substitute these scopes into academic archives
or identity-based finance history.

## Changes by workflow

| Workflow | Context and correction |
| --- | --- |
| Admin Students | Active runtime route is `DashboardController@students`, `admin.student`. Its year-scoped enrollment remains the list source. |
| Admin profile/edit | Section changes now use `StudentTransferService` inside the profile transaction; route student ID is authoritative; profile mark maintenance is room-scoped. |
| Individual/bulk transfers | Preserve student/user IDs; close source placement, append target placement/event, update the legacy projection, create fresh target scaffolds. Lock/recheck enrollment and reject competing active placements. |
| Legacy transfer alias | `DashboardController@student_change` delegates to the safe service. Its destructive body was removed. |
| Year preparation | Preserve source-year rows. Target enrollment without a corresponding preparation cannot be duplicated; conflicting carry-forward enrollment is rejected. No automatic next-grade policy was added. |
| Teacher room cards/rosters | Shared current membership, active-year assignments, distinct student rows. |
| Follow-up GET/POST/admin-on-behalf | Shared eligibility; historical author/context preserved; author-only two-hour edits unchanged; no Teacher delete added. |
| Admin current follow-up browse | Student/class/section counts and current labels use the shared enrollment projection. Historical compliance/observation period queries remain historical and require repaired intervals before missing transitions can be represented accurately. |
| Exams/quizzes grading | Results filtered to current roster. A transferred-in student can render as an unsaved result row and save normally; GET does not fabricate persisted results. |
| Individual exam correction | Require authenticated teacher assignment, current room/student/term and source assessment ownership where applicable. |
| Aggregate marks/reporting/export | Read/update marks and report cards by student + year + room; do not select the first student/year row. |
| Parallel Teacher gradebook | GET and POST now enforce assignment and current student membership. |
| Files and academic rewards | Current file-marking and reward creation validate teacher assignment/current membership; old records remain stored. |
| Student profile | Cannot change academic room or another student's identity; removed historical result/file room rewriting. |
| Student current report/follow-up | Resolve the actual enrollment context instead of preferring a stale placement room. Mutation guards use current membership. |
| Student Academic Record | Selected placement/year/room queries unchanged; old academic rows are not reclassified. Existing stale placement cards still require data reconciliation. |
| Teacher room API | Current membership limits returned students. Existing authentication contract was not replaced. |
| Parent children API | Current room relation is year- and membership-scoped; endpoint verification is blocked by missing `App\Parents` in this checkout. |
| Finance | No code or record changes; identity-based invoice and transport invoice history preserved. |

The active route collection has no Teacher roster route using the old
`teacherscontroller` class. Its remaining route is Admin exam reactivation.

## Academic preservation and policy boundaries

`students_marks` and `report_cards` have student/year/room context. Aggregate
mark JSON is keyed by lesson; it is not automatically a portable mark across
sections. `exam_result` and `exam_result2.user_id` refer to the student ID,
not the linked user-account ID. Assessment definitions, terms, lessons and
rooms supply the remaining context. Files retain original student/room/source
assessment IDs. Follow-ups retain teacher, placement/room, assignment period,
term/year, observed time and authorship.

Same-grade old marks remain historical and are not copied into the target
gradebook. Teacher-owned or section-specific assessments remain in their
original section. An explicit school decision is needed before carrying
selected same-grade lesson aggregates into a target section. Cross-grade
marks are never treated as the new curriculum's results.

Returning to a previously used room in the same year is blocked when the
target already has placement/mark/report context. These legacy tables lack
a placement foreign key to distinguish two visits; automatically creating
another scaffold would duplicate or reopen history.

The 126 current-room mark gaps are reported, not backfilled. 613 current
enrollments have no current-room report card; absence alone is not proof of
corruption because reports may be optional/not yet issued. Existing
report-card attendance stays room/year-scoped. The legacy attendance tracer
contains user/lesson/day/lecture-time, without room/year/placement; a unique
historical placement cannot be reconstructed from it alone.

All 27,537 stored `exam_result2` rows are outside the valid current roster.
27,495 resolve through an assessment and term (37 in year 4, 27,458 in year
5); 42 lack a resolvable definition/term link. Those rows remain untouched.
There is no current-year saved-result population for a real-data grading
transfer test; isolated fixtures cover that behavior.

Legacy mobile APIs accept supplied teacher/student/parent IDs without a
consistent token-authentication boundary. `student.operational` does not
authenticate anonymous callers. This is existing security debt; adding
authentication requires a coordinated mobile-client/API rollout. The
missing Parent model also prevents claiming Parent end-to-end verification.
Unrelated legacy content-definition/delete policy is not changed by this
membership repair; archive retention for deleting shared assessments/content
requires a separate decision.

The existing `admincontroller@current_year` also closes prior-year active
placements and invokes `reconcileActiveYearPlacements()` on year activation.
That legacy reconciliation can infer a new placement start from enrollment
creation time. It was not executed or changed in this pass. Do not toggle
years as an attempted repair for the 126 discrepancies: their missing
section-transfer intervals require the separately audited plan below.

## Separate, auditable reconciliation plan (not executed)

1. Back up database and media; export affected enrollment, placement,
   transfer, marks, report and follow-up rows with IDs and hashes.
2. Preview mismatches, missing projections, multiple active placements and
   duplicate enrollments separately. Do not label legitimate closed
   same-year transitions as duplicates.
3. Review the 126 unique later same-grade enrollments, the ten unprojected
   active placements and the missing target scaffolds with school staff.
   Enrollment timestamps are evidence of an edit, not reliable proof of an
   exact historical effective date. Some existing timestamps differ by
   three hours; do not fabricate dates or assignment responsibility.
4. An explicitly approved repair should lock each student/year, snapshot
   prior values, append the missing placement/reconciliation event and
   close only the proven superseded placement. Do not overwrite original
   marks, reports, submissions, author IDs, invoice years or transfer events.
5. Create only agreed fresh empty current scaffolds. Never copy prior marks
   or assume that a missing report card is corrupt. Refuse ambiguous cases.
6. Verify one operational context, teacher GET/POST agreement, old-row
   hashes and academic/financial history. Record before/after IDs per student.
7. Rollback must use the saved per-row snapshots/new row IDs and refuse to
   remove a new placement once later academic records depend on it. Never
   reset tables or bulk-delete history.

Read-only preview:

```sql
SELECT e.student_id, e.year_id, e.room_id AS enrollment_room,
       r.class_id AS enrollment_class, p.id AS placement_id,
       p.room_id AS placement_room, p.class_id AS placement_class,
       e.updated_at AS enrollment_updated, p.updated_at AS placement_updated
FROM room_student e
JOIN rooms r ON r.id = e.room_id AND r.year_id = e.year_id
JOIN years y ON y.id = e.year_id AND y.current_year = 1
LEFT JOIN student_academic_placements p
  ON p.student_id = e.student_id AND p.year_id = e.year_id
 AND p.status = 'active'
WHERE p.id IS NULL OR p.room_id <> e.room_id OR p.class_id <> r.class_id
ORDER BY e.student_id, p.id;
```

## Verification and deployment

16 focused tests passed with 213 assertions. PHP lint and strict UTF-8
without-BOM checks passed for all 18 changed/new PHP files. Real local
Admin follow-up controller queries show student 340 in room 132 and exclude
them from room 157; sampled current roster counts agree across modules.

Isolated SQLite tests use PHP 7.4 with `-d extension=pdo_sqlite`. Each test
method runs in a separate PHP invocation because the legacy routes define
`paginate_num` unconditionally on application boot. No PHP configuration
was edited. Coverage includes transfers, rollover, preserved old rows,
Teacher GET/POST denial/access, missing/future/stale/competing placements,
duplicate enrollment, read-only result placeholders, repeat mark saves,
author/time edit restrictions, profile routing and transaction rollback.

Read-only full-row SHA-256 fingerprints of 43 local tables match before and
after verification, including identities, enrollment/placements/events,
grades/results/reports, submissions, follow-ups, assignment periods,
invoices and transport invoices. No migration or data repair was run.

No connected browser or authenticated browser session is available. Real
local queries and isolated HTTP/controller tests are verified; interactive
Admin/Teacher/Student/Parent browser QA and production verification remain
pending. Do not claim the production incident is fully resolved from this
local verification.

Deploy code only after review and focused staging QA. Preserve existing
placement/transfer/assignment-period schema and indexes. No schema migration
is required. Keep the separately approved data reconciliation and API
authentication rollout independent. No commit, push or deployment performed.

## Changed files

- `app/Services/CurrentStudentMembership.php`
- `app/Student.php`, `app/Room.php`
- `app/Exam_result.php`, `app/Exam_result2.php`
- `app/Services/StudentTransferService.php`
- `app/Services/StudentFollowUpService.php`
- `app/Services/YearEndPromotionService.php`
- `app/Http/Controllers/TeacherController_New.php`
- `app/Http/Controllers/Teacher/TeacherGradebookController.php`
- `app/Http/Controllers/TeacherStudentFollowUpController.php`
- `app/Http/Controllers/AdminStudentFollowUpController.php`
- `app/Http/Controllers/StudentFollowUpController.php`
- `app/Http/Controllers/admincontroller.php`
- `app/Http/Controllers/DashboardController.php`
- `app/Http/Controllers/studentscontroller.php`
- `app/Http/Controllers/Api/websitecontroller.php`
- `tests/Feature/TeacherStudentFollowUpEligibilityTest.php`
- This audit and the numeric-ID discrepancy JSON report.
