# Pre-deployment audit: intermittent 403, Gradebook and timetable readiness

Date: 2026-10-29. Project: `C:\Users\Lenovo\Desktop\aladhamedu`.
Scope: current working tree and configured **local** MariaDB `aladham_oct`; no production access.
Task: read-only investigation. This report is the only permitted new file.

## 1. Decision

**NO-GO for deploying the complete working tree as-is. Production environment readiness is UNVERIFIED.**

This is not a finding that every Gradebook change is broken. The timetable resolver and new Admin timetable display have positive local evidence. The release is not an isolated timetable patch: existing Teacher grading paths already execute the new Gradebook safety/continuity services and model traits. The Gradebook UI is exposed, not dormant. Production schema, PHP/extensions, Apache document root, migration ledger, sessions and current timetable have not been verified. No safe production approval follows from local tests alone.

Recommended strategy: **Option C**, an explicitly reviewed, isolated timetable release with a dependency-complete manifest and staging acceptance. This requires extracting/reviewing mixed-file changes, or consciously including their tested Gradebook safety dependency closure. It cannot be produced by copying a few controllers. No release or branch was constructed here.

The Admin timetable **display-only** Blade correction is separately narrow and can be considered independently after staging; it does not deliver the wider assignment-authorization correction.

## 2. Evidence and execution boundaries

Read the Gradebook architecture/evidence report, Phase 0A, 0B and Phase 1 implementation reports, future Admin UI/template plan, and both timetable reports. Examined tracked diffs, expanded untracked paths, middleware/guards/providers, routes, models, new services/traits, affected views, tests, schema/migrations and deployment entry points.

Fresh checks in this pass:
- Direct PDO SELECTs and actual Eloquent resolver queries; no school DML/DDL, reconciliation, migrations or write requests.
- In-memory route registration using Laravel's Router and actual route declarations. Locale mounting was explicitly supplied for ar, en and no-prefix registrations; it is **not** a full HTTP/localization test.
- Actual role/global middleware and Gate callbacks exercised in a minimal in-memory application with synthetic users and array session storage, without application boot or request termination.
- Actual current-assignment guard invoked with the real local Teacher 166 account bound **in memory**, not a browser login.
- PHP token parsing, Blade compileString and parsing entirely in memory. No view/config/route cache changes.
- Two database-free PHPUnit rendering tests and two standalone Node harnesses. No school-backed mutations.
- No available connected browser/app. Authenticated browser, WhatsApp/WebView, real cookie expiry, TLS/proxy and Apache behavior are **UNVERIFIED**.
- Existing Laravel log remained 169,040,708 bytes, last-write 2026-10-29 10:04:34 during inspection. No authorization exception headers were found in the last 4 MB; expected 403s need not be reported by Laravel, so absence is not proof of absence.

Older reports' passing fixture suites are historical evidence, not newly rerun results. Their older row counts are not assumed current.

## 3. HTTP 403 investigation

### 3.1 What is confirmed

**No single root cause for the reported intermittent production public-link 403 is established.** No exact failing production URL, incident timestamp, response body/headers or hosting access/error/WAF logs were supplied. There is no evidence that merely visiting the homepage is an authorization prerequisite on the public complaint/staff forms.

Confirmed Laravel denial paths:
1. Global `RestrictComplaintOfficerSchoolAccess` denies authenticated type-8 Officers entering SMT/SMARMANger academic areas. `roleadmin` also explicitly rejects type 8. All roles share the web guard/session. An Officer session in the same browser can therefore explain an apparently surprising **protected-school-page** 403, but does not explain a guest public-page 403.
2. `TeacherController_New::requireCurrentTeacherAssignment` denies a room/subject without valid periods in the active year/current term. Previously retained annual pivots are insufficient. A stale bookmark can now correctly return 403.
3. Assessment guards also require the current term, correct subject/class, current student membership and, for legacy definitions, original Teacher ownership. A preserved historical definition is not necessarily an operationally editable current assessment.
4. `TeacherGradebookController::saveMark` requires an OPEN class/current-term Gradebook status; default status is LOCKED. Its 403 is a deliberate write restriction, not a public GET/deep-link error.
5. `can:...` middleware can deny roles lacking the requested permission. The existing Gate override grants type-2 Admins their legacy full Admin access; the recent timetable work did not remove it. Admins remain intentionally prohibited from the Complaint Officer portal.
6. `student.operational` can return a JSON 403 for archived/foreign student IDs. `rolestudent` instead redirects/logs out an archived or mismatched student context. These are not generic public-link guards.

No inspected public complaint/staff GET uses auth, roleadmin, roleteacher or Gradebook authorization. Their parent/staff workflow remains separate.

### 3.2 Fresh reproduction evidence

These are **middleware/guard results**, not full rendered HTTP page tests. A status of 204 is the audit's sentinel for "allowed to continue"; it is not a claim that the actual page returns 204.

| Method / path or layer | Identity/context | Observed result | Origin / confidence |
|---|---|---|---|
| GET /ar/complaints; /ar/staff-feedback, global Officer boundary | Guest, Admin, Teacher, Student, Officer | All continue | Actual middleware, high |
| Same public paths under English declarations | Public GET routes | No auth/role requirement; staff explicitly registered for both locales | Route inventory/static, high; full HTTP unverified |
| GET /SMT/admin/students, global boundary + roleadmin | Synthetic type-2 Admin | Continues | Actual middleware, high |
| Same roleadmin layer | Guest/Teacher/Student | 302 to school entry | Actual middleware, high |
| GET SMT/SMARMANger academic paths | Synthetic Officer | 403 at global boundary; roleadmin also 403 | Laravel, intentional, high |
| GET /SMARMANger/teacher, roleteacher | Synthetic Teacher | Continues | Actual middleware, high |
| Same roleteacher layer | Guest/Admin/Student | 302 to school entry | Actual middleware, high |
| GET /SMARMANger/teacher_lessons2/130/166, subject 406 | Real local Teacher 166, year 6 / term 20 | Assignment guard passes both with no Referer and with internal Referer | Actual guard + local SELECTs, high |
| GET /SMARMANger/teacher_lessons2/132/166, subject 409 | Same | Passes both | Actual guard + local SELECTs, high |
| GET /SMARMANger/teacher_lessons2/135/166, subject 419 | Same, stale assignment | 403 with both Referer states | Laravel, intended current policy, high |
| GET /SMARMANger/teacher_lessons2/139/166, subject 44 | Same, stale assignment | 403 with both Referer states | Laravel, intended current policy, high |

Fresh/expired browser sessions and actual Admin/Student controller renders were not simulated by issuing production-like requests. Missing authentication normally redirects through `Authenticate` or role middleware, rather than yielding a generic public 403. JSON auth requests may be 401. CSRF mismatch normally maps to Laravel's token-mismatch handling (this project redirects to login/public form); it is not evidence of a GET 403. Throttling is a separate 429 case.

### 3.3 Hosting evidence and plausible causes

Local server is PHP's built-in server, command:
`C:\php74\php.exe -S 127.0.0.1:8000 C:\Users\Lenovo\Desktop\aladhamedu\server.php`.
It does not execute Apache .htaccess or reproduce Hostinger WAF decisions.

Confirmed repository structure:
- Front controller is root `index.php`, loading root vendor and bootstrap. Local router is root `server.php`; it serves static files from `public`. There is no `public/.htaccess`. Do not assume a stock Laravel public/index.php deployment.
- Root `.htaccess` skips rewriting existing files **and directories** and disables directory listing. Root includes real `login`, `profile` and `blog` directories without a visible index file. With that root as Apache DocumentRoot, a request such as **/login** can be intercepted as a directory rather than reach the Laravel login route; with listing disabled it can become an Apache 403. This is a strong structural candidate for bare deep links, **not a reproduced production diagnosis**. /ar/login is a different filesystem path.
- Root .htaccess intentionally forbids protected file extensions (including JSON/MD/lock/env) and the private application-release storage prefix. A direct URL matching these restrictions should fail server-side. Whether a failed shared URL matches one is unknown.
- Active .htaccess targets HTTP redirects for aladhamedu.com; separate inactive filename `htaccess` targets aladham.school. Neither is proof of the live vhost rules. The active hostname regex does not normalize www/apex universally.
- Apache 2.4 compatibility for legacy Order/Deny directives and AllowOverride/mod_rewrite settings must be checked. Unsupported directives can produce 500 rather than this 403; do not conflate them.
- Local session defaults: file driver, 120 minutes, host-only domain unless overridden, HttpOnly, SameSite=Lax, Secure unset unless configured. In-app browsers may have a separate cookie jar. Losing cookies normally leads to login/CSRF behavior, not a public GET 403.
- Trusted proxy configuration has no explicitly configured proxy list. Actual TLS termination, canonical host, session domain and Secure-cookie flags are production-specific.
- ModSecurity/WAF, file ownership/modes, hotlink/referrer rules, caching and Apache directory handling remain unverified. No live-host requests or permission probes were performed.

Locale middleware saves/redirects locale in session; its inspected paths produce redirects, not permission denials. There is no inspected Referer/homepage check on public form GETs. Legacy Auth/LoginController has previous-URL-dependent Student redirection and constructor token deletion/logout for an already-authenticated Student. This is an existing navigation/write side effect, not a proven source of public 403; no request was sent to it.

**Required diagnostic action before any 403 fix:** capture the exact URL/method, timestamp/timezone, guest/auth role, browser vs WhatsApp WebView, sanitized response headers/body and redirect chain. Correlate with Hostinger access/error/ModSecurity logs; compare whether Laravel was reached. Test the same URL fresh, authenticated and after homepage navigation on staging. Do not disable WAF/auth/CSRF or add homepage warm-up workarounds without that evidence.

## 4. Git and working-tree inventory

At audit start:
- Branch: **main**. HEAD: **2c65b22d93a79e7847ed416f7295e48ef9d9825f**.
- Tracking: origin/main; local comparison **0 ahead / 0 behind**. No fetch; this says nothing about unseen remote updates.
- Recent commits: 2c65b22d student id fix; 0fa4b8f7 Bugs + Updates; f9a406b4 updates phase1; fa346a37 update + bug fix; dc6e15a0 bugs.
- **46 tracked modified files**, **35 individual untracked files**, **81 total** before this report; no staged changes, tracked deletions or renames.
- Tracked diff: **1,042 additions / 1,294 deletions**. Untracked source, tests and the migration are not included in those ordinary diff statistics.
- This report adds one untracked file: expected final total **82**.
- .env.example changes only the example DB name from aladham_real to aladham_oct. It is unrelated to this release and preserved exactly; do not upload it as production environment configuration.

Ignored/generated deployment-sensitive locations: .env, bootstrap/cache/packages.php and services.php, vendor, node_modules, storage and public/storage. Only ordinary package/service manifests exist locally; no config/route cache was present. Their absence locally does not establish production cache state. public/storage exposes the broad storage tree locally; do not package that tree or Windows links blindly. Six local Gradebook config/status JSON files exist under storage/app; these are operational data, not a replacement for production configuration.

### Feature separation

- **0A:** permanent original-result reads, stricter academic/Teacher authorization, protected model updates/deletions, safe participation/mark writes, validated config/status/report aggregation, legacy form/AJAX repairs.
- **0B:** missing-context handling, config validation/maximum preservation, roster/summary display, status/save feedback and shared context. It includes preparation for a future UI, not completion of that UI.
- **Phase 1:** explicit modern assessment identity, read-only cross-section continuity/provenance, original-result preservation, receiving legacy/Advanced display and guarded writes.
- **Future Template/UI phase:** documented redesign/versioned template plan; no completed replacement framework or feature flag was found. Existing comments saying "Phase 2 CORRECTED"/"Phase 5" predate and do not prove that the planned next UI phase is complete.
- **Timetable:** shared current authority, model scope/relations, Teacher/Admin/API readers, Follow-up guards, period tracking/synchronization, term observer, serialized timetable/academic writes and localized policy messages.
- **Admin Teacher timetable display:** new_teacher_schedule Blade + dedicated unit regression, now all sections/time windows.
- **Unrelated:** .env.example example DB name; leave outside release intent.

The complete path inventory at the end records overlaps; phase attribution is cumulative, not an exclusive per-hunk ownership claim.

## 5. Gradebook deployment and schema risk

### Implemented versus unfinished

Implemented safety/continuity behavior is exercised by existing tests and is supported by source inspection. The original assessment/result rows remain the grade source; no second receiving result is created for a carried mark. Modern definitions and result models now use PreservesAssessmentResults / PreservesEarnedResult, and those traits call AssessmentResultSafety. Deleting contexts with earned data is deliberately blocked.

However, Gradebook is **not dormant**:
- Admin V2 sidebar exposes **دفتر العلامات (Beta)** -> /SMT/admin/gradebook.
- Admin landing exposes the equivalence route and settings/review flows.
- Teacher section mark navigation exposes the Advanced Gradebook.
- Four legacy Teacher exam/quiz entry templates now consume shared continuity partials and currentAssessmentRows.
- TeacherController_New, TeacherAssessmentService, Dashboard assessment creation, and model save/delete paths call new services outside the Advanced Gradebook landing.
- Student Academic Record detail presentation includes Gradebook-related readable data adjustments.

Unfinished/deferred: full Admin V2 internal-page redesign, immutable/versioned templates, file configuration/status concurrency/versioning, approved normalization of mismatched maxima, combining duplicate legacy term definitions, final-result/publication policy and historical correction policy. Old summary thresholds/sums are not certified promotion decisions. Advanced dynamic saves are not a complete legacy report publication pipeline. Keep explicit aggregation distinct from a read-only refresh.

### Fresh local migration state

Only filesystem migration absent from local ledger:
`2026_10_23_000001_create_assessment_equivalence_members`.

Physical table **assessment_equivalence_members is absent**. Its migration remains unapplied. The previous statement is still true, independently rechecked now.

The migration requires source exams2 to be InnoDB with a signed INT ID. Locally: **InnoDB / int(11)**, compatible with that preflight. Production is unverified. The mapping adds a unique exam membership, identity/section uniqueness and RESTRICT source FK; populated rollback deliberately refuses to destroy mapping history. No backfill is automatic.

Missing mapping table does **not by itself make current readers crash**:
- AssessmentContinuityService::resolve returns no continuity when Schema::hasTable is false.
- createdTogether skips mapping without the table.
- Admin equivalence GET shows an unavailable state; POST explicitly returns **503**, not a successful mapping.
- AssessmentResultSafety/GradebookReadService protect optional mapping queries.

Thus basic timetable authority needs **no new migration**, but delivering/advertising verified equivalence continuity needs controlled schema activation and staging QA. Applying the migration alone does not map old assessments. Do not run a broad migrate or fake ledger entries.

Important older schema drift: ledger records the January gradebook_configs and gradebook_components migrations, but **both physical tables are absent locally**. Current active Gradebook services use storage JSON and existing exams/results, not these models. Remaining GradebookConfig references in old newcontroller/teacherscontroller paths are not proof the current shared reader needs those tables; those paths contain legacy fallback handling. Do not recreate those tables or mark migrations again blindly. Audit production independently.

Fresh SELECTs still find **42 modern results with no surviving definition** and **18 numeric results above their current definition maximum**. These are read-only findings, not authorized repairs; older reports have different snapshots/counts. New safety checks may reject operations involving inconsistent legacy contexts instead of silently rewriting them. Preserve data and establish correction provenance separately.

## 6. Timetable release dependency and behavior

Current local context: year **6 / 2026/2027**, term **20 / فصل أول 26-27**.
621 annual current-year projection rows; 578 timetable-backed responsibilities; 1,372 valid weekly periods. 43 annual-only projections remain stored and excluded. 634 assignment periods exist, 621 open and 13 closed. No reconciliation was run.

### Dependency closure

| Layer | Required current implementation / coupling |
|---|---|
| Resolver and models | CurrentTeacherAssignments, Teacher_room_lesson currentTimetable scope, Teacher current relations, existing schedule/room/lesson/day/slot models and year-scoped current term |
| History synchronization | TeacherAssignmentPeriodService, TeacherRoomLessonObserver, new TimetableTermObserver, AppServiceProvider registration, existing teacher_assignment_periods schema/model |
| Timetable reads/writes | DashboardController, TeacherController_New, admincontroller assignment-plan retirement, routes/teacher.php class-subject helper, Teacher timetable/shared Admin display views, assignment/timetable translations |
| Current academic guards | TeacherAssessmentService, TeacherGradebookController, StudentFollowUpService and TeacherStudentFollowUpController; several already contain Gradebook work |
| Legacy API compatibility | Api/websitecontroller current timetable scope; unchanged unauthenticated Teacher-ID contract, separate security limitation |
| Transitive Gradebook dependencies when copying mixed files whole | AssessmentResultSafety -> GradebookReadService -> GradebookConfigService + AssessmentContinuityService -> AssessmentEquivalenceService; two model traits; continuity/assessment partials and ar/en Gradebook translations; Admin Gradebook route/controller/view changes if their callers are included |

The **resolver itself has no Gradebook dependency**. The current mixed controller files do. Missing a new untracked class/trait/partial while uploading tracked controllers can yield class/trait/view-not-found 500s on existing grading pages. No list of a handful of filenames is a verified standalone release package.

### Side effects and academic safety

- Resolver, scope, dashboard/current subject queries and four timetable query builders are SELECT-only. No global synchronization runs at application boot; providers register observers.
- Synchronization is a **writer** invoked after current timetable/slot changes and qualifying Term_year saves. It can create missing annual projections, open responsibility periods and close stale open periods. It preserves annual rows, original marks/results/history and personal/financial identity.
- This is an operational policy change: selecting a new current term with no timetable removes current Teacher authority and can close old open responsibility periods. Do not enable a new empty term casually.
- Saving an edited section can close that section's pre-existing unscheduled intervals. A term change can synchronize the whole active year. These must be explained to staff; they are not cosmetic fixes.
- Active-year row locks serialize the changed timetable writers and corresponding assessment/Follow-up/Gradebook mutation checks. Tested transaction code does not make file-based config/status updates transactional. Production engine/lock waits and competing legacy writers remain acceptance checks.
- **Read-only visits are not globally write-free:** Follow-up roster GET calls openForAssignment (line 76), which may create a missing current responsibility period. Existing open rows make it return the row. Auth/LoginController construction can delete an authenticated Student's token rows and log them out. Stream-entry GET is intentionally a tracer write. These handlers were not invoked. Do not call them during a strict database-read-only smoke test and claim nothing could mutate.
- Student transfer/lifecycle/finance services are not changed by this diff. Existing model/context deletion guards can intentionally prevent destructive legacy academic actions; that behavior must not be mistaken for a failed transfer.
- An imported valid period without a projection is authoritative to the resolver; projection-ID-dependent Follow-up still needs a valid projection. Present local data has no such missing projections. Do not introduce an automatic read-repair to hide production discrepancies.

### Seven-Teacher verification

Latest display implementation groups by actual day and exact start/end pair and renders every period in a cell separately with original IDs. Local data-backed compiled-Blade verification from the immediately preceding focused pass found:

| Teacher ID | Responsibilities before -> effective | Expected / rendered periods |
|---:|---:|---:|
| 154 | 10 -> 9 | 23 / 23 |
| 139 | 3 -> 2 | 4 / 4 |
| 144 | 5 -> 4 | 16 / 16 |
| 140 | 9 -> 8 | 16 / 16 |
| 85 | 9 -> 8 | 16 / 16 |
| 9 | 23 -> 9 | 27 / 27 |
| 166 | 13 -> 11 | 11 / 11 |
| Total | 72 -> 51 | 113 / 113 |

It compared all 40 distinct relevant sections, no omitted/duplicate schedule IDs, including 4122 / room 130 / Wednesday 13:20-14:00. Fresh queries/guard checks in this audit reconfirm year/term, school totals and Teacher 166's allowed/denied contexts. No claim of a fresh browser render is made. The previous display pass's 19 tests/246 assertions are historical results; this audit reran only the database-free 2-test subset.

## 7. Routing, authentication and security release concerns

Actual route declarations include web, Admin SMT, legacy SMARMANger Admin, Teacher, Student, supervisor, coordinator, academic supervisor, administrator, Complaint Officer, Gradebook and API groups. teacher_legacy.php is comments/reference, not a second active Teacher portal.

In-memory ar registration: **1,193 declarations / 1,176 effective routes**, **28 duplicate method+URI keys** (including GET/HEAD separately), **23 duplicated route names**. Repeated declarations can replace handlers; not all are different logic. Examples: /ar/register intentionally overrides default registration, duplicate coordinator routes, Admin teacher/set_task, classes/rooms, invoice_store, roles, logout, changemessage and dashboard.class.lessons. Name collisions can generate a URL for the wrong role's area. They are not proof of an intermittent public 403. The Teacher class-lessons route already shared a name before this fix; changing its target does not remove that legacy collision.

Gradebook routes now explicitly require auth + roleadmin + can:student_marks. Teacher routes retain roleteacher and authenticated Teacher identity is authoritative over URL Teacher IDs. Direct permitted assignment guard checks do not require a prior homepage request.

**Known existing security blockers requiring an explicit owner decision:**
- /api/teacher_classes/{teacher_id}, /api/teacher_schedule/{teacher_id} and associated legacy Teacher API declarations have only api middleware (throttle/bindings), not a verified Teacher session/token. Timetable scoping does not prevent caller impersonation of a valid Teacher ID. The user previously chose contract compatibility for this pass; do not silently secure/break mobile clients. Separate authentication rollout or documented restricted-release risk acceptance is required, not a "fully secure" sign-off.
- Legacy Admin backup code contains embedded database credentials and can produce a predictable publicly located ZIP. Admin authorization protects invocation, not necessarily the generated static file. No secrets are reproduced here; no endpoint was invoked and local public/myzip.zip is absent. Assess exposure and secret handling separately before any blanket production-security approval.
- Raw-query/external legacy writers can bypass model events. Model protections are not a certification of every API mutation path.

No authorization weakening, permission edits, logout, token changes or account reset occurred in this audit.

## 8. Production compatibility and runtime configuration

| Area | Local/repository evidence | Production status / prerequisite |
|---|---|---|
| PHP/framework | PHP 7.4.33; locked Laravel 7.30.6; no new Composer/package change | Verify actual web AND CLI PHP; do not upgrade blindly |
| Composer | composer.json pins php 7.2.5 and has malformed platform string 7.2.; lock platform override is 7.2.5 | Existing reproducibility mismatch, not introduced here; validate a locked install on staging before any vendor rebuild. Never composer update as a deployment workaround |
| Extensions | Local mbstring, pdo_mysql, fileinfo, XML/DOM, zip, openssl present; curl absent although a locked legacy dependency requires ext-curl. SQLite absent by default | Check production extensions; PHP CLI and web SAPIs can differ. Current focused tests need no SQLite |
| Source requirements | Existing PHP 7.4-compatible syntax; all audited changed/new PHP parses | Production engine/version unverified |
| DB engine | Relevant local timetable, history, exam/result, enrollment/report tables are InnoDB | Verify actual production engines, ID signedness, columns, migration state, transaction isolation and SQL mode |
| Current context | One current local year and its scoped current term | Confirm production's current-year/current-term timetable and projection gaps; no fallback to old year |
| Storage | JSON configs/statuses in storage/app; existing broad storage/public mapping and custom public_path conventions | Preserve production config/history/uploads, verify writable required directories and private media/download protection; no chmod changes here |
| Assets | No changed public asset or npm lock/build input in 81-file set; display/Gradebook changes are Blade/inline scripts | No new Mix build justified by this diff. Existing asset paths and custom public_html layout still need staging HTTP checks |
| Cache | Local config/routes uncached; manifests present. Routes include closures (17 under ar, 15 without prefix) | Do not upload Windows/stale compiled caches. Generic Laravel 7 route:cache is not automatically valid for this route set; validate supported localization/cache procedure on staging. Nothing cleared here |
| Queue/scheduler | Existing database queue; scheduler starts queue:work and restarts workers | Not a new timetable dependency. Verify existing notification workers, jobs table and Hostinger cron/process limits; do not spawn workers here |
| Environment | No new env key for timetable/continuity; .env.example DB-name edit unrelated; local APP_DEBUG=true and localhost APP_URL | Never upload local .env/config cache. Production APP_DEBUG=false, canonical URL/cookies/proxy settings require review |
| Hosting | Root front controller plus public assets, not stock public/index layout; root .htaccess and inactive htaccess differ | Actual public_html tree, ownership, Apache/WAF/TLS configuration UNVERIFIED; do not move roots or overwrite host rules without a manifest |

## 9. Release options

| Option | Feasibility and prerequisites | Risk / decision |
|---|---|---|
| A. All current modified/untracked application files | Technically possible only with all new classes/traits/partials/translations, schema plan, production context/storage checks and full acceptance. Includes exposed unfinished Gradebook UX and operational changes; exclude local env/test/evidence artifacts from web upload. Missing mapping can be safely unavailable but cannot be advertised as working continuity. | High operational scope; **NO-GO as-is**. Passing syntax is not production acceptance. |
| B. Copy only named timetable files from this working tree | Not a proven independent full-feature patch. Mixed Dashboard/Teacher/Admin controllers and TeacherAssessmentService carry Gradebook changes. Copying them without transitive new files can produce 500s; copying the full closure is no longer "timetable only." Resolver alone and display Blade are separable but do not deliver all required readers/guards/writers. | High partial-upload risk. **Not approved as a simple file-copy strategy.** |
| C. Deliberately isolated release | Recommended. Review/extract timetable hunks against an agreed production baseline OR include a bounded, explicitly accepted safety/continuity closure; stage the exact artifact. Include new resolver/observer/provider/model scope/history service, all affected readers/guards/writers, messages and display fix coherently. Schema prerequisite is existing assignment/follow-up foundation; no new timetable migration. Mapping migration only if Phase 1 continuity activation is in scope. | Moderate after isolation and staging; **conditional candidate, not yet GO**. Cannot use whole mixed files while claiming unfinished Gradebook was excluded. |

No release package, Git index change, cherry-pick or branch manipulation was performed. A separate release manifest must be verified against the actual production baseline, which is not available here.

## 10. Safe verification actually performed

- All **47 changed/new non-Blade PHP files** parsed, plus **21 changed/new Blade templates** compiled in memory and generated PHP parsed: no errors. Additionally ran php -l on all 29 tracked non-Blade PHP changes: all pass.
- All 68 PHP/Blade files passed UTF-8/no-BOM checks.
- **AdminTeacherTimetableViewTest: 2 tests / 41 assertions PASS**; no DB or persistent view cache.
- **gradebook-save.test.js PASS** and **gradebook-status.test.js PASS**. Harnesses test event/payload/state logic, not real browser plugins.
- git diff --check PASS.
- Actual Router registration/collisions; isolated middleware/Gate matrix; actual local Teacher assignment guard and database/migration checks described above.
- Verified three unchanged legacy compiled-view errors still exist: students/new_start_exam3 (unexpected ')'), coordinators/load_en and acadsupervisors/load_en (unexpected ':', expecting '('). These are not new timetable regressions. Their exact production reachability must be determined before claiming a full-system clean view cache.
- **Not run:** full GradebookSafetyTest/TimetableAuthorityTest HTTP suites in this strict pass because their current fixtures use Storage::fake, persist compiled views/runtime files or fixed temp HTML paths. The concurrency integration test creates/drops a database; not run under this task's no-DB-writes restriction. Historical results in existing reports remain useful, not a substitute for rerunning in a disposable staging clone.
- No actual public page, login controller, Follow-up roster or stream-entry HTTP request was issued; those can persist sessions or mutate records. No artisan cache/optimize commands, package install, migration, seeding, database repair or dependency network audit was run.

No new live-host 403 could be reproduced locally with Apache/Hostinger evidence because that environment and an exact incident were unavailable.

## 11. Minimal-risk action plan

1. **Blocker:** capture production 403 incident evidence and establish Laravel versus Apache/WAF origin. For a bare /login failure, inspect physical-directory dispatch specifically; for a protected Teacher failure, compare the exact current timetable context. No security bypass.
2. **Blocker:** establish exact production code baseline, PHP web/CLI versions/extensions, custom public_html/DocumentRoot mapping, .htaccess rules, active year/term, relevant table engines/columns and migration ledger through an approved read-only production inspection. Backups and restore plan must be approved before a future rollout.
3. **Blocker:** choose Option C and define the actual code dependency closure. Separate incomplete Template/UI work or explicitly accept the bounded Gradebook safety/continuity behavior. Include untracked required files; do not deploy local .env.example, ignored storage, secrets, node_modules or cached Windows paths.
4. **Blocker if enabling Phase 1 identity:** preflight exams2 engine/signed ID and ledger/table state on staging; rehearse only the approved additive equivalence migration, then functional mapping/transfer/provenance tests. Do not automatically apply all migrations or infer old identities. If deferred, equivalence must remain explicitly unavailable, not a promised operational feature.
5. **Blocker:** on a disposable staging clone run the full Gradebook/timetable/membership/follow-up suites, failing-writer rollback and concurrent MySQL timetable/grading cases. Verify no historical result/identity/finance changes outside intended fixtures. No live-school write tests.
6. **Blocker:** browser acceptance of all seven Teachers and all relevant sections, direct URLs, fresh/expired/role-switched sessions, ar/en public forms and account boundaries, mobile/desktop, current/historical academic views and existing mark saves. Explain stale-bookmark denials and new-term empty-assignment behavior to staff.
7. **Security owner decision:** separately resolve/restrict or formally accept the legacy API authentication and backup-secret/static-export risks for a bounded emergency release. Do not represent timetable scoping as authentication.
8. Rehearse the custom deployment/cache procedure on staging, validate current Gradebook config/status preservation, identify reachability of the three unchanged legacy Blade failures, and prepare code rollback without deleting newly authored school history.
9. Only after review issue a fresh release-specific GO/CONDITIONAL GO. No deployment is authorized by this report.

May wait outside a strictly isolated timetable release: full premium Gradebook UI, versioned template feature work, historical discrepancy reconciliation, a general route-name cleanup and unrelated legacy-view fixes proven unreachable from that release. Their existence must remain documented. Production 403 diagnosis and environment/dependency sign-off cannot be replaced by those later projects.

## 12. Complete working-tree file manifest

M = tracked modified; ?? = untracked at audit start. Tags describe cumulative report membership/actual workstream; shared files are not separable simply by choosing one tag.

| State | Exact path | Workstream |
|---|---|---|
| M | `.env.example` | Unrelated local example DB name; preserve/exclude |
| M | `app/Exam_result.php` | 0A |
| M | `app/Exam_result2.php` | 0A + 1 |
| M | `app/Exams2.php` | 0A |
| M | `app/Http/Controllers/Admin/GradebookController.php` | 0A + 0B |
| M | `app/Http/Controllers/Admin/GradebookSettingsController.php` | 0A + 0B + Timetable |
| M | `app/Http/Controllers/Api/websitecontroller.php` | Timetable |
| M | `app/Http/Controllers/DashboardController.php` | 0A + 0B + 1 + Timetable |
| M | `app/Http/Controllers/Teacher/TeacherGradebookController.php` | 0A + Timetable |
| M | `app/Http/Controllers/TeacherController_New.php` | 0A + 1 + Timetable |
| M | `app/Http/Controllers/TeacherStudentFollowUpController.php` | Timetable |
| M | `app/Http/Controllers/admincontroller.php` | 0A + Timetable |
| M | `app/Http/Controllers/coordinatorcontroller.php` | 0A |
| M | `app/Http/Controllers/studentscontroller.php` | 0B |
| M | `app/Lesson_teacher_room_term_exam.php` | 0A |
| M | `app/Observers/TeacherRoomLessonObserver.php` | Timetable |
| M | `app/Providers/AppServiceProvider.php` | Timetable |
| M | `app/Services/GradebookAggregationService.php` | 0A |
| M | `app/Services/GradebookConfigService.php` | 0A |
| M | `app/Services/StudentFollowUpService.php` | Timetable |
| M | `app/Services/TeacherAssignmentPeriodService.php` | Timetable |
| M | `app/Teacher.php` | Timetable |
| M | `app/Teacher_room_lesson.php` | Timetable |
| M | `resources/lang/ar/teacher_assignment.php` | Timetable |
| M | `resources/lang/ar/timetable.php` | Timetable |
| M | `resources/lang/en/teacher_assignment.php` | Timetable |
| M | `resources/lang/en/timetable.php` | Timetable |
| M | `resources/views/admin/gradebook/index.blade.php` | 0B + 1 |
| M | `resources/views/admin/gradebook/settings/edit_json.blade.php` | 0B |
| M | `resources/views/admin/gradebook/settings/subjects.blade.php` | 0B |
| M | `resources/views/admin/gradebook/view_by_student.blade.php` | 0A + 0B |
| M | `resources/views/admin/gradebook/view_by_subject_corrected.blade.php` | 0A |
| M | `resources/views/admin/gradebook/view_subjects.blade.php` | 0A + 0B |
| M | `resources/views/admin/new_teacher_schedule.blade.php` | Admin timetable display fix / coverage |
| M | `resources/views/admin/set_task.blade.php` | Timetable |
| M | `resources/views/students/academic_record_show.blade.php` | 0B |
| M | `resources/views/teachers/gradebook/index.blade.php` | 0A |
| M | `resources/views/teachers2/student_follow_ups/history.blade.php` | Timetable |
| M | `resources/views/teachers2/teacher_exam_student.blade.php` | 0A + 1 |
| M | `resources/views/teachers2/teacher_exammark_auto.blade.php` | 0A + 1 |
| M | `resources/views/teachers2/teacher_quize_students.blade.php` | 0A + 1 |
| M | `resources/views/teachers2/teacher_quize_students_outo.blade.php` | 0A + 1 |
| M | `resources/views/teachers2/teacher_schedule.blade.php` | Timetable |
| M | `routes/gradebook.php` | 0A + 1 |
| M | `routes/teacher.php` | 0A + 1 + Timetable |
| M | `tests/Feature/TeacherStudentFollowUpEligibilityTest.php` | 0A + Timetable |
| ?? | `app/Concerns/PreservesAssessmentResults.php` | 0A |
| ?? | `app/Concerns/PreservesEarnedResult.php` | 0A |
| ?? | `app/Http/Controllers/Admin/AssessmentEquivalenceController.php` | 1 |
| ?? | `app/Observers/TimetableTermObserver.php` | Timetable |
| ?? | `app/Services/AssessmentContinuityService.php` | 1 |
| ?? | `app/Services/AssessmentEquivalenceService.php` | 1 |
| ?? | `app/Services/AssessmentResultSafety.php` | 0A + 1 |
| ?? | `app/Services/CurrentTeacherAssignments.php` | Timetable |
| ?? | `app/Services/GradebookReadService.php` | 0A + 1 |
| ?? | `app/Services/TeacherAssessmentService.php` | 0A + 1 + Timetable |
| ?? | `database/migrations/2026_10_23_000001_create_assessment_equivalence_members.php` | 1 |
| ?? | `docs/audits/advanced-gradebook-audit-2026-10-22.md` | Gradebook audit evidence |
| ?? | `docs/audits/advanced-gradebook-evidence-2026-10-22.json` | Gradebook audit evidence |
| ?? | `docs/audits/gradebook-admin-ui-redesign-plan-2026-10-23.md` | Future Template/UI plan only |
| ?? | `docs/audits/gradebook-phase0a-implementation-2026-10-23.md` | 0A |
| ?? | `docs/audits/gradebook-phase0b-implementation-2026-10-23.md` | 0B |
| ?? | `docs/audits/gradebook-phase1-implementation-2026-10-23.md` | Gradebook shared support / evidence |
| ?? | `docs/audits/teacher-assignment-timetable-audit-2026-10-28.md` | Before audit evidence |
| ?? | `docs/audits/teacher-assignment-timetable-consistency-2026-10-29.md` | Timetable |
| ?? | `resources/lang/ar/gradebook.php` | 0A + 0B + 1 |
| ?? | `resources/lang/en/gradebook.php` | 0A + 0B + 1 |
| ?? | `resources/views/admin/gradebook/equivalence.blade.php` | 1 |
| ?? | `resources/views/gradebook/assessment_results.blade.php` | 0A + 1 |
| ?? | `resources/views/gradebook/continuity_badge.blade.php` | 1 |
| ?? | `resources/views/gradebook/continuity_row.blade.php` | 1 |
| ?? | `tests/Concerns/TimetableFixtures.php` | Timetable |
| ?? | `tests/Feature/GradebookSafetyTest.php` | 0A + 0B + 1 + Timetable |
| ?? | `tests/Feature/TimetableAuthorityTest.php` | Timetable |
| ?? | `tests/Fixtures/gradebook-layout.blade.php` | 0A |
| ?? | `tests/Fixtures/gradebook-schema.json` | 0A |
| ?? | `tests/Frontend/gradebook-continuity.test.js` | 1 |
| ?? | `tests/Frontend/gradebook-save.test.js` | 0A + 0B |
| ?? | `tests/Frontend/gradebook-status.test.js` | 0B |
| ?? | `tests/Integration/timetable-concurrency.php` | Timetable |
| ?? | `tests/Unit/AdminTeacherTimetableViewTest.php` | Admin timetable display fix / coverage |

## 13. Preservation and close-out

Only this report was created. Application code, .env/.env.example, existing reports, routes, templates, migrations, configuration, caches and school data were not modified. No commit, push, fetch, pull, deployment, reconciliation or migration was performed.

Seven assignment/context table fingerprints captured before inspection are unchanged at close-out. A second detailed read-only snapshot/check covers 20 school identity/enrollment/placement/history/academic/invoice/timetable datasets; final comparison results are recorded after verification below. These hashes show no differences between the paired reads, not a claim of a database-wide atomic backup or evidence about production.

Final verification: all **20/20 paired full-row school dataset fingerprints match**; the seven start/end assignment/context fingerprints also match. All 81 pre-existing working-tree file hashes match; the sole added path is this report (82 total changed/untracked files afterward). No existing file was removed. git diff --check passes. The Laravel log size and last-write timestamp remain unchanged.

Additional cache/autoload check: the local Composer loader is not classmap-authoritative and the local CLI does not load Zend OPcache. Production settings are unknown. A production authoritative classmap can require rebuilding the loader for new classes; stale PHP worker/OPcache state is a release consideration, not a confirmed cause of this incident. No loader rebuild or OPcache reset was performed.

**Final decision: NO-GO for an as-is whole-worktree upload. Option C is the recommended next controlled release process; actual production readiness and the intermittent public-link 403 root cause remain UNVERIFIED.**

