# Student transfer: simple UX and conservative reconciliation

## Scope and outcome

The normal transfer modals on the active Admin Students list and Student Details
now show target class/section, the requested short Arabic history notice when
records exist, Cancel and one **تأكيد النقل** submit action. No technical
reconciliation explanation, evidence textarea or extra confirmation checkbox is
rendered in either normal modal. The notice is a shared partial and uses the exact
owner-provided Arabic wording.

The list fetches its history flag from the existing authorized student-detail
endpoint. Its old `SMARMANger/admin/...` URL did not match the real `SMT/admin/...`
route; it now uses the existing named route. A late response for a different
student cannot change the currently open student's notice.

## Backend contract

Existing valid transfers and repeated visits continue through the locked transfer
transaction without any reconciliation inputs. Source visits close, a fresh
destination visit and empty summaries are created, and the legacy enrollment
projection follows the destination. Original records are not rewritten or copied
into unrelated destination assessments.

When reconciliation is needed, automatic verification is deliberately narrow:

- A single valid current placement agrees with the sole current enrollment, even
  if legacy summary rows are ambiguous. Preserve all such summaries; do not select
  an arbitrary one as the authoritative historical record.
- A same-grade mismatch satisfies the existing `CurrentStudentMembership`
  conservative projection resolver: newer enrollment evidence, no conflicting or
  later transfer, and no prior visit to the projected room. This reuses the same
  operational membership rule rather than introducing a second inference policy.
- No placement or transfer exists for this student/year, and the sole current
  enrollment has valid, nonfuture timestamps in the correct order.

Automatic verification records the actor, original snapshot, evidence basis and
observation time in the existing reconciliation audit. It records an observation
NOW, never invents the date of an earlier transition, and never assigns uncertain
old grades to that observation.

Insufficient evidence stops the normal POST without writes and redirects to the
authorized Student Details page. A separate concise review displays current and
destination sections. Its explicit **اعتماد الشعبة الحالية وتأكيد النقل** action
authorizes the observation and transfer. No textarea or checkbox is required.
The server records the approval reason, actor, snapshot and unknown historical
date. Existing callers may still supply an optional reason (maximum 2,000
characters). Source-room/placement snapshots are rechecked under the transfer
lock; stale or unauthorized confirmation fails. All observation, history,
enrollment and scaffold writes roll back together on failure.

Multiple active placements, cross-grade mismatches, evidence of a later transfer,
and prior visits that invalidate legacy projection are never silently reconciled.
An explicitly authorized current observation is separate from correcting history.
Invalid/future placement intervals, conflicting enrollments and academic records
without reliable original context remain protected even after explicit approval.
Bulk transfers do not silently grant manual reconciliation approval.

## Files changed in this pass

- `app/Services/StudentPlacementReconciliation.php`
- `app/Services/StudentTransferService.php`
- `app/Http/Controllers/admincontroller.php`
- `resources/views/admin/student.blade.php`
- `resources/views/admin/student_details.blade.php`
- `resources/views/admin/students/_transfer_history_notice.blade.php` (new)
- `resources/views/admin/students/_transfer_review.blade.php` (new)
- `resources/lang/ar/student_transfer.php`
- `resources/lang/en/student_transfer.php`
- `tests/Concerns/AcademicVisitChecks.php`
- `tests/Concerns/StudentTransferUxChecks.php` (new)
- `tests/Feature/GradebookSafetyTest.php`
- `tests/Frontend/student-transfer-ux.test.js` (new)
- This report.

Existing unfinished work, including the previous visit-foundation migration,
remains preserved. Other dirty files are not additional changes from this pass.

## Verification

All mutation tests used SQLite `:memory:` and isolated temporary storage. No
operational migration was run against the local school database or MariaDB;
existing test helpers construct disposable in-memory fixture schemas only.

- New UX checks: **10 tests / 178 assertions**, included in the Gradebook suite.
  They exercise the real Admin POST route, render the actual normal modal markup
  and exceptional review partial, and call the actual history-flag endpoint.
  Coverage: exact Arabic copy, a single confirm action, no reconciliation controls,
  automatic verified observation, no backdating, uncertain mismatch/no writes,
  explicit audited review without evidence text, repeated HTTP return transfers,
  cross-grade/future-date safeguards, multiple placements, later-transfer/prior-
  visit ambiguity, unauthorized access and rollback.
- Gradebook safety/history/return visits/privacy: **136 tests / 2,958 assertions**.
- Teacher/student follow-up eligibility and preservation: **17 / 314**.
- Lesson workspace, Student follow-up views and Admin observation/reporting:
  **17 / 467**.
- Combined: **170 tests / 3,739 assertions**, passed. These cover original earned
  zeroes, original IDs, publication/ownership/privacy, frozen historical records,
  current-section lessons/timetable/rosters, follow-ups across transfers, current
  grading, submissions/files, account identity and unchanged financial fixtures.
- Node checks passed: new transfer notice handler, existing lesson workspace and
  student-delete regressions. The new check covers delegated binding, the correct
  named URL, conditional notice state and out-of-order responses.
- PHP lint passed for all 12 changed PHP/Blade sources; all 13 changed source files
  decode as UTF-8 without BOM and contain none of the scanned mojibake markers.
- Blade cache rebuilt in isolated temporary compiled-view storage. All four
  changed compiled views passed PHP lint. This is not a claim that unrelated
  pre-existing legacy templates have been repaired.
- `git diff --check` passed. No environment/configuration, routes, assignment,
  learning-content authorization, private-download policy or API contract changes.

## School database and activation boundary

A SELECT-only transaction on local `127.0.0.1 / aladham_oct` confirmed unchanged
row counts AND SHA-256 row fingerprints against the earlier preserved baseline
for 16 tables: students/users, enrollments/placements/transfer audit, marks,
reports, both result tables, both submission tables, follow-ups, invoices, fee
settings, invoice images and transport invoices. Student 1444 and all other real
students remain untouched. No uploaded files were changed.

Both visit-foundation tables are still absent on the school database. The existing
schema gate therefore remains intentionally fail-closed for returns and
reconciliation requiring that foundation. This pass does NOT claim those paths
are operational on the school database. Activation of the previously prepared
named additive migration requires separate approval; no new migration is needed
for this UX pass.

The browser tool reported no available apps or browsers. No authenticated browser
transfer, screenshot/mobile visual acceptance or live-school mutation is claimed.
After separately approved activation, manually verify the normal modal notice,
class/section selection, one-button transfer and the separate exceptional review
with an authorized dedicated test student. Do not silently reconcile real students.

No commit, push, deployment or Slice/feature expansion was performed.
