# Admin Student create/delete workflow repair

Date: 2026-11-06. Target: `/SMT/admin/students`. No deployment.

## Root cause and runtime evidence

The active route is `POST /SMT/admin/delete_student`, named `delete_student`, handled by `DashboardController@delete_student` behind `web`, `auth` and `roleadmin`. `DashboardController@students` returns the singular `admin.student` view, using `admin.layouts.v2`. The delete trigger is delegated from DataTable row actions; it sets `student_id` and the selected student's name in `#delete_class`. The original form was an ordinary CSRF-protected POST, not an AJAX request.

The original controller compared the submitted password with `Auth::user()->view_password`, then called `AssessmentResultSafety::assertContextDeletable`. A read-only controller reproduction for existing student 170 reached that exact guard and raised `ValidationException`, field `assessment`, before any deletion. All 1,201 current student identities have marks rows; all are therefore blocked by this existing guard, even where a row contains only scaffolding. HTML validation failures redirect back with an error bag; JSON validation failures use 422. The page rendered validation errors only when `old('student_create_form')` was present. The V2 layout displayed success/error flash messages, not this validation bag. Delete had no inline error area, restore marker or AJAX failure handler. Consequently the valid safety rejection appeared to do nothing.

The legacy display-password comparison was also insecure and could diverge from the actual password hash; it was not established as the cause of this particular rejection. It is now replaced by `Hash::check` against the authenticated Admin's password hash. No password values are included in this report or application logging.

## Destructive legacy semantics and approved boundary

The old path was hard deletion, not soft deletion or archive. After the academic guard it attempted to delete marks, assessment submissions/results, enrollments, the linked user, messages, certificates, medals, rewards/sanctions, FCM tokens, detail documents with `unlink`, student details and the student identity. There was no encompassing transaction. Missing user/detail rows or files could interrupt the chain after earlier deletions. Financial rows, placements and other history were not comprehensively handled and could be disconnected.

The inspected schema has no foreign keys to `students` or `student_details`. Only three declared user references were found, all restrictive Gradebook references. This does not imply other relationships are absent; most are application-enforced.

Before repair, the owner explicitly approved the narrower alternative: reject deletion whenever retained academic, financial, placement, attendance or other linked history exists; guide the operator to the existing Archive workflow; allow transactional deletion only for verified history-free erroneous/test identities. No automatic archive or new cleanup cascade was introduced.

## Repair

- `StudentDeletionService` locks the identity/account/details and checks all-year student/account references, the legacy FCM alias, converted-admission references, audit actor references and declared foreign keys. Ambiguous legacy `user_id` references conservatively check both student and linked-account IDs. Archived identities, document paths, additional populated detail records, multiple identity shells and non-Student linked accounts block deletion.
- The service removes only history-free identity shells: optional student details, the Student-type user account and the student. It never deletes academic/financial/enrollment/history rows or files. Removal and a persistence check are in one transaction.
- `delete_student` now authorizes the existing permission, validates IDs/password, checks the real hash, and returns success only after the transaction completes. Validation messages are localized and HTML fallback restores the delete form without flashing passwords. Unexpected failures log only an exception class, not request data, credentials or SQL bindings.
- The existing modal identifies the selected student and now has accessible inline errors, a current-password input and an Archive link. Delegated AJAX submission preserves CSRF, blocks duplicate clicks, has a 30-second timeout, handles 401/403/404/405/419/422/server/network failures, clears credentials and restores the button. Uncertain network outcomes advise refreshing before retrying. Only confirmed success closes the modal, announces feedback/toast and reloads the DataTable.
- An ordinary newly created student has enrollment, placement, marks and a zero-value invoice scaffold, so is intentionally not hard-deletable. Archive is the normal safe removal workflow.

## Add Student audit and fixes

The active modal POSTs to `/SMT/admin/students/store`, handled by `DashboardController@student_store`. Existing required fields, length rules and unique public-record-number validation remain. Names alone are not treated as unique. The selected section must belong to the selected class and active year. Existing detail/guardian fields, generated account credentials, invoice scaffolding, enrollment, placement and marks setup remain the same.

Confirmed fixes:

1. Related writes previously had no common transaction. They now commit together; failures preserve safe old input, reopen the existing form and return a localized error, with no partial student/account/invoice/enrollment state.
2. Active year/section and duplicate public-record-number are rechecked under transaction locks. Success is flashed only after commit.
3. Validated residence country was passed to `Student::create` but omitted from that model's fillable list, so it was silently discarded. This action now assigns it explicitly before saving, without changing global mass-assignment behavior.
4. The existing `create_student` permission is also checked server-side. The existing Admin authorization policy still grants type-2 Admin access.

Account generation, password generation/storage, marks calculations and registration requirements were not redesigned. The existing legacy secondary controller routes were not repurposed.

## Exact files changed in this pass

1. `app/Http/Controllers/DashboardController.php` (only the two target action bodies).
2. `app/Services/StudentDeletionService.php` (new).
3. `resources/views/admin/student.blade.php`.
4. `public/assets/admin/js/student-delete.js` (new).
5. `resources/lang/ar/student_deletion.php` (new).
6. `resources/lang/en/student_deletion.php` (new).
7. `tests/Frontend/student-delete.test.js` (new).
8. `tests/Integration/student-workflow-mariadb.php` (new).
9. This report.

No routes, global middleware/error handler, unrelated lesson-content files, migrations, `.env` or `.env.example` were modified. Controller content outside the two target methods was compared with the private pre-task copy and is identical.

## Verification

`C:\php74\php.exe tests/Integration/student-workflow-mariadb.php --create-disposable-database` passed **58 assertions** on MariaDB 10.4.32. Final disposable database: `aladham_student_workflow_test_521ee450def334c2`; isolated storage: `C:\Users\Lenovo\AppData\Local\Temp\aladham-student-workflow-e1f3bcb4c586b3ffd1557749db7b5eb5`.

The opt-in runner reads schema definitions only, creates a uniquely named local database, verifies its connection, and uses synthetic identities and isolated storage. No school records are copied. Legacy zero-date DDL requires relaxed SQL mode only on the disposable schema-copy connection; Laravel mutation tests retain normal strict mode. No migration is run. Failure-injection triggers are created and removed only in fixtures.

Coverage includes correct hashed password with deliberately stale `view_password`, wrong/empty password, missing/invalid/deleted student, guest/Teacher/Officer denial, real CSRF middleware failure (testing bypass disabled), HTML redirect/error/old-input fallback, safe deletion, repeat deletion, rollback after a forced final identity-delete failure, academic/financial/transport/enrollment/placement/admission/attendance retention, document and archive protection, incomplete history-free identities, valid creation with long Arabic guardian name, account/hash consistency, active-year scaffolds, duplicate rejection, mismatched class/section, creation rollback after later placement failure, safe old-input recovery and no pre-commit success. The actual Students Blade and V2 layout render through the Web route/kernel in the disposable environment.

`node tests/Frontend/student-delete.test.js` passed: actual handler registration, serialized CSRF/ID payload, duplicate-submit suppression, validation/status/network errors, text-only error insertion, credential clearing, recoverable state and confirmed table refresh. This is a VM event/AJAX harness, not graphical browser testing or a real network transport test.

PHP lint passed for the controller, service, Blade, translations and integration runner. JavaScript syntax, Blade `view:clear`/`view:cache`, UTF-8 without BOM and `git diff --check` passed. The live local Students URL redirects guests to the existing Arabic login (302); the new JS asset returns 200.

School before/after snapshots match exactly: **167 tables, 326,486 rows**, identical row/schema/trigger/protected-file hashes. Snapshot SHA-256: `b92a6894789d0669397befda09c33ecfea8f380f46200d9be548a42fa4d85423`. All 432 checked uploaded/content files retain their checksums. Environment file hashes are unchanged. No original school record or uploaded file was changed.

## Remaining checks and limitations

No graphical browser or authenticated Admin browser surface was connected. Actual localhost authenticated visual acceptance is not claimed. Manually check a selected name, modal placement, wrong-password error, protected-student Archive explanation, button recovery and toast/table refresh. Do not hard-delete a real school student for QA; use the disposable environment.

The guard deliberately favors preservation: even empty scaffolds or ambiguous legacy account-ID references can prevent hard deletion. Missing/undocumented future relationship aliases must be added to the guard when introduced. Most legacy relationships lack foreign keys; transaction locks and current reference checks protect this path but are not a system-wide schema-integrity redesign. No source database schema repair, history cleanup or account-storage redesign was attempted. Disposable test databases are retained for inspection; cleanup is deferred rather than issuing destructive commands.

No commit, push or deployment was performed.
