# Complaint Officer Portal implementation

## Authentication findings and account policy

Inspected the current User/Role models, MySQL users/roles schema, custom
permissions, Gate::before, roleadmin, both login paths, logout, generic account
operations, complaint controller/model/routes/views, receipts, and Admin V2
navigation/composer/polling code before implementation.

Laravel 7.30.6 / PHP 7.4.33 use App\User and the session-based web guard.
The actual MySQL users.type was ENUM('0','1','2','3','4','5','6','7').
Account type 8 was unused. Other code uses assessment/content type 8, which is
unrelated to users.type. Type 2 retains its existing unrestricted Admin Gate
behavior; complaint officers are type 8, not type 2.

Officers receive the custom `Complaint Officers` role, created on first account
creation, with only these permissions:

- view_complaints
- manage_complaints
- archive_complaints
- receive_complaint_notifications

An officer cannot gain unrelated permissions through a role edit: the Gate
rejects abilities outside this list. Missing/invalid role permissions fail
closed. Other school-account types cannot enter the complaint portal.
The school-path boundary and roleadmin deny officer access to Admin, Teacher,
Student and other school-management URLs. Officers can still use the public
website and public complaint form.

Full type-2 Admins manage officer accounts only. Operational portal access is
restricted to active, authorized type-8 officers. Admin requests return 403.
No emergency access or impersonation is available.

## Login and account management

- Dedicated login: GET/POST `/complaint-portal/login`.
- Dedicated logout: POST `/complaint-portal/logout`.
- Successful officer login always redirects to `/complaint-portal`, not a
  caller-controlled intended school URL.
- Generic website login dispatches officer credentials through the same
  throttled officer login implementation. The standard Laravel login also
  handles officer redirects and inactive accounts.
- Generic login/home entry points send authenticated officers to their portal.
- Passwords use the existing Laravel Hash implementation; no officer plaintext
  password is stored or displayed. Minimum length: 10, with confirmation.
- Officer-only active/session-version fields revoke access after deactivation
  and password reset; remember tokens are rotated. Revoked sessions are logged
  out at their next portal request. No other account lifecycle is changed.
- Officer model guards prevent type escalation, plaintext password retention,
  and Eloquent deletion through legacy account-management paths. Logout remains
  available if an officer's role permissions are removed.

Admin sidebar entry: `مسؤولو متابعة الشكاوى`, under admissions/communication.
Account page: `/SMT/admin/complaint-officers`.
Admin can create, update name/email, activate/deactivate, and change passwords.
Input cannot set type, role, linked student/teacher identity or plaintext
credential fields. Existing non-officer IDs cannot be managed through this area.
There is no deletion action or generic role-management link in the officer portal.

## Routes, UI, and legacy treatment

The dedicated portal has a separate Arabic RTL shell, responsive complaint
cards, type/status filters, pagination, details, status actions, archive
confirmation, account identity/logout, and independent personal notifications.
CSS and JavaScript are local and isolated from Admin/Teacher/Student layouts.

Portal routes:

- GET `/complaint-portal`
- GET `/complaint-portal/complaints/{id}`
- POST `/complaint-portal/complaints/{id}/status`
- POST `/complaint-portal/complaints/{id}/archive`
- GET `/complaint-portal/notifications`
- POST `/complaint-portal/notifications/{notificationId}/open`

Every management operation has server-side type/account/permission checks.
All mutations use the existing web CSRF middleware. An expired portal CSRF
request redirects to its own login with a localized message and does not write.
Complaint officers share authorized access to all complaints; complaint IDs are
not student IDs. Notification receipts are restricted to their recipient.

Admin operational complaint sidebar/card/bell/counters/polling and the shared
notification composer were removed. The Admin entry now manages officer accounts.
Old authorized Admin GET bookmarks, receipt links, mutations and poll endpoints
return 410 without exposing data or marking receipts read. Officers receive 403
on those Admin URLs. Legacy Admin complaint Blade templates remain on disk but are not returned by any
active controller; their existing identifier edits were preserved.

## Shared workflow, notifications, audit, and concurrency

`ComplaintWorkflowService` owns submission persistence, authorized listing and
detail lookup, transitions, first-handler assignment, archive, and audit writes.
Web controllers supply validation/presentation only. A future API can call the
same service after implementing appropriate authentication; no API was added.

`AdminComplaintNotificationService` retains its legacy class/table names for
compatibility but its recipient method is `notifyAuthorizedOfficers`.
New complaints notify only active type-8 officers with both view and receive
permissions. Normal Admins receive no new operational copies. Existing receipts
and their read states are preserved, including inaccessible old Admin receipts. No synthetic historical receipts are created for new officers.
Receipt creation is idempotent; Officer A reading does not change Officer B.
Reading uses owned CSRF-protected POST, never a state-changing GET.

Transitions lock the complaint row inside a transaction and validate the freshly
locked status. Repeated completed actions are idempotent. Complaint changes and
append-only action inserts commit together. First-handler identity is preserved.
Audits record complaint, actor, action, previous/new status, previous/new handler,
and server timestamp. No complaint body/phone/password/request payload is logged.
No audit edit/delete or ownership-reassignment action exists. Page reads are not
logged. Existing actions were not backfilled or invented.

## Public form and database

Public AR/EN forms remain anonymous. Identifier validation remains exactly the
existing required five-character `233/3`, `233-2`, `001/4` format. No matching to
students.public_record_number was added. Only the helper copy was shortened to
`مثال: 233/3 أو 233-2` / `Example: 233/3 or 233-2`.

New additive migration:
`2026_10_06_000002_add_complaint_officer_foundation.php`.

- Append type 8 to the existing MySQL enum, preserving other enum values and
  null/default behavior.
- Add users.complaint_officer_active and users.complaint_auth_version.
- Add complaint_action_audits. No cascading deletion of this audit history.
- Existing complaints/statuses/identifiers/receipts are not rewritten.
- Guards tolerate already-created foundation columns/table after an interrupted
  migration. Normal repeated migration execution does nothing.
- Automatic rollback is deliberately refused: removing officer identities or
  audit history requires an explicit preservation plan.

Local status: identifier migration remains batch 24; new foundation is batch 25.
Only the new migration path was executed, not unrelated pending migrations.
For a deployment, apply any missing prerequisite complaint/identifier migrations
before this foundation and provision real officers through Admin. No production
deployment or upload-package rebuild was performed.

## Verification evidence

- 43 focused PHPUnit cases passed using isolated SQLite memory databases and
  separate PHP processes (legacy route bootstrap defines paginate_num globally).
  SQLite extensions were enabled for test commands only; PHP configuration was
  not changed. No PHPUnit result cache was changed.
- Tests cover public identifier/honeypot behavior, persistence on receipt
  failure, scoped permissions, direct Admin URL denial, receipt IDOR, POST-only
  reads, CSRF rejection, status/archive/audit/idempotence, disabled/revoked
  sessions, password hashing, privilege-injection rejection, legacy model guards,
  migration repeatability, and shared officer login throttling.
- Student/Teacher/Admin website login destination tests passed unchanged.
- Real local MySQL rollback verification exercised Admin account creation,
  actual web-guard officer login, two-officer receipts, transitions/handler/audit,
  archive, deactivation, roleadmin denial, and Arabic list/detail rendering.
  The actual Admin account page also rendered without password disclosure.
- Before/after data hashes matched for complaints, receipts, audits, users, roles,
  students/details, enrollments, placements/transfer history, teacher assignments,
  invoices, invoice images and transport invoices. Test fixtures were rolled back.
- The original complaint baseline was unchanged. One original complaint remains;
  no permanent test officers, receipts or fabricated historical audits remain.
- Actual HTTP GETs returned 200 for `/ar`, `/en`, both public complaint forms,
  officer login, and its local CSS/JS. Concise helper and UTF-8 markup confirmed.
- PHP lint passed for the modified/new PHP files; ten relevant compiled Blade
  PHP files passed syntax checks. Full Blade cache cleared/rebuilt, route list
  checked, 14 new route names unique, JavaScript syntax and git diff check passed.
- Changed files validated as UTF-8 without BOM; no obvious mojibake on added lines.
- Row-locking is implemented and real MySQL transitions were verified. A parallel
  multi-process load/race test was not performed.

Browser runtime reported no connected browser. There are no authenticated browser
screenshots or verified mobile measurements. Private unrelated school pages were
not browser-tested; their authentication destinations and protected data were
checked as described above. Visual/mobile/manual acceptance is still required.

## Files added or changed in this pass

Authentication/security integration:

- app/User.php
- app/Exceptions/Handler.php
- app/Http/Kernel.php
- app/Http/Middleware/ComplaintPortalAccess.php
- app/Http/Middleware/RestrictComplaintOfficerSchoolAccess.php
- app/Http/Middleware/roleadmin.php
- app/Http/Middleware/RedirectIfAuthenticated.php
- app/Providers/AuthServiceProvider.php
- app/Http/Controllers/Auth/LoginController.php
- app/Http/Controllers/websitecontroller.php
- app/Http/Controllers/HomeController.php
- config/global.php

Complaint workflow, accounts, routes and schema:

- app/Services/ComplaintAccess.php
- app/Services/ComplaintWorkflowService.php
- app/Services/AdminComplaintNotificationService.php
- app/Http/Controllers/ComplaintController.php
- app/Http/Controllers/ComplaintPortalController.php
- app/Http/Controllers/ComplaintOfficerLoginController.php
- app/Http/Controllers/Admin/ComplaintOfficerController.php
- routes/complaint_portal.php
- routes/admin.php
- routes/web.php
- database/migrations/2026_10_06_000002_add_complaint_officer_foundation.php

Views, assets, localization, tests and documentation:

- resources/views/complaint_portal/layout.blade.php
- resources/views/complaint_portal/login.blade.php
- resources/views/complaint_portal/index.blade.php
- resources/views/complaint_portal/show.blade.php
- resources/views/admin/complaint_officers/index.blade.php
- resources/views/admin/components/sidebar.blade.php
- resources/views/admin/components/navbar.blade.php
- resources/views/admin/index.blade.php
- resources/views/admin/layouts/v2.blade.php
- app/Providers/AppServiceProvider.php
- public/css/complaint-portal.css
- public/js/complaint-portal.js
- resources/lang/ar/complaint_portal.php
- resources/lang/en/complaint_portal.php
- resources/lang/ar/complaints.php
- resources/lang/en/complaints.php
- tests/Feature/ComplaintWorkflowTest.php
- docs/complaint-officer-portal-implementation.md

The pre-existing identifier migration, public-form markup and legacy Admin detail
identifier edits remain in the workspace; they were not reverted.

## Exact manual browser QA

1. Sign in as an existing Admin. Open the sidebar item
   `مسؤولو متابعة الشكاوى` (`/SMT/admin/complaint-officers`). Create two officer
   accounts with distinct email addresses and confirmed passwords of 10+ chars.
2. Confirm Admin navigation no longer shows operational complaint links or a
   complaint bell, and that existing Admin student/finance/schedule pages work.
3. In an anonymous/private session open `/ar/complaints`. Submit an academic
   complaint with all required fields and identifier `233/3`; confirm feedback.
4. Open `/en/complaints` anonymously. Submit a transport complaint with bus number
   and identifier `233-2`; check concise English helper and success feedback.
5. In a separate session open `/complaint-portal/login` as Officer A. Confirm
   dashboard, type/status filters, account identity and complaint-only navigation.
6. Open both new complaints. Verify names, class/section/bus, identifiers, text,
   status and original timestamps. On a legacy null identifier see `غير متوفر`.
7. Use status buttons to review/start/resolve. Refresh and confirm persistence,
   first handler, and actor/date in the action history; backward transitions must
   not be available/accepted.
8. Open `إشعاراتي` and submit an Officer A receipt button. Confirm its read state
   changes and the correct detail opens. In Officer B's separate session, confirm
   the corresponding receipt is still unread. Try A's receipt ID as B: deny/404.
9. Archive one test complaint through the styled confirmation. Test cancel,
   Escape, backdrop, keyboard focus and reopening. Confirm the complaint remains
   in the archived filter and its action history remains visible.
10. As Officer A manually enter `/SMT/admin/students`, `/SMT/admin/users`,
    `/SMT/admin/complaints` and `/SMT/admin/complaint-officers`: expect 403.
11. As Admin deactivate A while A has an open session. A's next protected portal
    request must end that session. Reactivate, sign in afresh, then change A's
    password as Admin; the old session must fail and the new password must work.
12. Check generic login/home officer redirects; no Student/Teacher/Admin landing
    or redirect loop. Verify existing Student/Teacher/Admin logins normally.
13. As Admin visit an old complaint GET/receipt bookmark: expect 410. Direct
    portal list/detail/notifications/mutations must return 403. Officer account
    management remains available. No retired endpoint may change data.
14. Use the portal logout and confirm protected pages demand officer login.
15. Check list, detail, filters, notices and archive confirmation at desktop,
    tablet, 430/390/360/320/280px and short landscape heights. Verify long Arabic
    names wrap, no page horizontal overflow, controls remain reachable, correct
    RTL, no console errors and no failed local asset requests.

## Risks and deferred items

- Manual visual/mobile/authenticated-browser acceptance remains pending.
- Provision real active officer accounts before operational rollout; no accounts
  were silently created for staff. If none exist, public complaints still persist
  but no officer receipts can be generated.
- Admin operational access is intentionally denied; only officer accounts may
  operate complaints.
- Inert legacy Admin complaint templates can be cleaned up separately; retired
  POST callers must adopt the portal instead of retrying an old form.
- The known separate backup-security/deployment blocker remains deferred and
  untouched. This task does not declare the entire school system deployment-safe.
- No mobile API/authentication/push or external notification delivery was added.
- No commit, push, deployment or package rebuild was performed.

COMPLAINT OFFICERS ARE ADMIN TYPE=2: NO
SEPARATE AUTH DATABASE CREATED: NO
MOBILE API IMPLEMENTED: NO
PUBLIC COMPLAINT SUBMISSION REMAINS AVAILABLE: YES
EXISTING COMPLAINT DATA PRESERVED: YES
BACKUP SECURITY ISSUE MODIFIED: NO

## Access correction and UI refinement - 2026-10-07

The follow-up removes the former type-2 exception in ComplaintAccess and portal
logout middleware. Legacy Admin complaint endpoints uniformly return 410.
Portal views now use compact complaint rows, shared expandable notifications,
filter reset, localized absolute timestamps, differentiated status badges,
responsive context grids and guarded duplicate form submissions. Business
transitions and public submission validation remain unchanged.

Manual acceptance pending: sign in as an authorized officer, check empty and
filtered lists, long mixed Arabic/English names, academic and transport details,
legacy missing identifiers, owned unread receipts, archive cancel/confirm and
keyboard focus. Repeat at 1200px, 1024px, 768px and 360px with short heights.
Assert document.documentElement.scrollWidth <= document.documentElement.clientWidth.
Check Admin account management works while direct portal access returns 403.
No connected browser was available for this pass.
