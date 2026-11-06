# Teacher/Student lesson UI and login/403 reliability

Date: 2026-11-06 (Asia/Damascus)

## Outcome and verification boundary

All three requested workstreams are implemented locally. The focused and related isolated regressions pass. The four requested lesson URLs render through the real HTTP kernel, middleware, controllers and layouts using real local data in a database-enforced read-only transaction.

**Authenticated browser and visual acceptance remain pending.** The available computer-use inventory returned no browsers or apps. The attachment contained text, not the referenced screenshots. No screenshot comparison, browser clicks, measured layout overflow, or device testing is claimed. Production Apache/WAF behavior was not reproduced or changed on the host.

No school data, assignments, grades, publication rules, migrations, result-visibility configuration, `.env`, or `.env.example` were changed. No commit, push or deployment.

## Ownership and confirmed UI causes

| Requested page | Active controller | Active view/layout |
|---|---|---|
| `/SMARMANger/dashboard/teacher/lessons/lectures/406/166/130` | `TeacherController_New@lectures` | `teachers2.teacher_lessons` / `teachers2.layouts.app` |
| `/SMARMANger/dashboard/teacher/teacher_rooms2/1/166/130/4986` | `TeacherController_New@teacher_rooms2` | `teachers2.teacher_addcontent` / same Teacher layout |
| `/SMARMANger/dashboard/teacher/lessons/book_details/406/166/130/4986` | `TeacherController_New@book_details` | `teachers2.teacher_showcontent` / same Teacher layout |
| `/SMARMANger/dashboard/student/lesson/lecture/content/409/363/4999` | `studentscontroller@lecture_content` | `students.new_lecture_content` / `students.layouts.app4` |

Teacher routes are registered in `routes/teacher.php` behind the existing Teacher-role boundary. Student routes retain their existing Student-role/identity boundary. No lesson route or content controller was changed.

The actual Add Lesson modal has name and publication-date fields. The name/link/upload interface described in the request belongs to `teacher_addcontent`, reached through Add Content. Both presentations were handled without moving fields between workflows.

Confirmed style problems:

- Half-width outer Bootstrap columns were combined with `.tab .tab-content` widths around 198-232%, large horizontal offsets, and negative/positive vertical offsets. Several breakpoint declarations used `!important`.
- Shared `showcontent_style.css`, inline page CSS and Student V2 styles competed. The dark background/dashed border belonged to this legacy content container, not a backend upload requirement.
- Fixed/narrow cards, decorative shapes and positioned text forced titles into narrow columns. Audio/link controls also had mobile offsets.
- Student tabs used a no-wrap horizontal-scrolling presentation, further affected by legacy widths.
- Child pages loaded additional jQuery/Bootstrap 3 scripts after the shared portal bundles. These could replace the layout's plugin/event environment.
- Teacher supervision files already had `Section6` content but no tab; Student supervision files had `Section7` content but no tab.

### Presentation changes

- New opt-in `lc-page lc-lesson-page` stylesheet resets only these lesson workspaces, not sidebar offsets or unrelated portal screens.
- Outer tab columns use the available content width. Tabs use a wrapping grid with clear active/focus states. Legacy important widths/offsets are explicitly neutralized with scoped rules.
- Content cards use balanced grid columns and natural heights. Titles/URLs wrap; media stays inside its card; decorative shapes no longer collide with text.
- Upload forms use aligned labeled fields, contained native file inputs, visible selected filenames, and readable server validation errors. The misleading generic video-upload error toast was replaced by the actual validation messages on this page.
- Add/Edit lesson modals share clean RTL header/body/footer styling and scrollable viewport-constrained content. The duplicate Add/Edit form ID was corrected; names, field requirements and submission endpoints are unchanged.
- Existing supervision-file panels are now reachable. Empty categories retain their tabs and show a neutral empty state.
- Tabs continue using the layout's Bootstrap implementation. Added ARIA relationships, one tab stop, Home/End and direction-aware arrow navigation. Filename output uses `textContent`, not HTML insertion.
- Valid submits expose a busy state and disable submit buttons after native form data capture; `pageshow` restores them on back navigation. Native validation still applies.
- Removed redundant child jQuery/Bootstrap imports; retained the shared layout dependencies.
- Student sidebar `student_exam` now reads `النتائج والعلامات`. Removed only the active sidebar item for `dashboard.student.results`. The latter route, controller, permissions and result policy are untouched.

### Contract comparison

Compared private before/after rendered DOMs, sorting fields by name/type rather than markup order:

| Page | Forms before/after | Result |
|---|---:|---|
| Teacher lectures | 6 / 6 | Identical action/method/enctype and named field/type/required/multiple contract |
| Teacher add content | 5 / 5 | Identical contract, including four multipart upload forms |
| Teacher content details | 1 / 1 | Identical contract |
| Student lecture content | 5 / 5 | Identical contract |

Existing non-fragment links are unchanged on all Teacher pages. On the Student page the only removed non-fragment link is the explicitly requested sidebar `/student/results/363` entry. Rendered active sidebar contains one `student_exam` link and zero separate results links.

Real requested content pages currently each contain one content card; multiple-item, media/link and empty states were additionally exercised with isolated view fixtures. No live content was added to manufacture those cases.

## Login/403 diagnosis

### Confirmed causes and corrections

1. Guest role middleware redirected to `/SMARMANger`; its guest branch then redirected to the public homepage. Guests now reach the canonical login URL directly. Authenticated wrong-role handling remains the established denial/fallback.
2. `Auth::routes()` registers the legacy login GET inside the localization group. An earlier bare alias can be overwritten by this registration. The explicit `/login` alias is now registered after that group and retains the `login` route name. Localized legacy GETs use the same controller redirect.
3. `LoginController::redirectTo()` had an invalid Teacher path, duplicated Student conditions, incorrect previous-URL string parsing and a `dd()` fallback. Explicit role destinations replace this code; Teacher home is `/SMARMANger/teacher`.
4. The login controller constructor deleted Student FCM tokens and logged out an authenticated Student merely when instantiated. This is no longer done on login GET. Existing token cleanup is performed on explicit logout, followed by Laravel's session invalidation/token regeneration.
5. Generic CSRF exceptions redirected to the legacy named login without explanatory feedback. Web failures now redirect to localized `adh-login` with a session-expired message. AJAX/JSON failures return 419 with that message, rather than successful-looking login HTML. Public complaint and Officer-specific CSRF branches are preserved.
6. The project root contains a physical `login` asset directory. The root `.htaccess` excludes existing directories from front-controller routing and disables directory listing. On that hosting layout an exact `/login` request can be intercepted by Apache and forbidden before Laravel runs. A narrowly scoped rewrite sends only `login`/`login/` to `index.php`, leaving asset children untouched. This is a confirmed configuration collision; its role in any particular production incident is not established without host logs.

### Navigation contract

`SchoolLoginNavigation` centralizes canonical login locale selection, role homes and conservative intended destinations. Explicit `ar`/`en` URL selection takes precedence, then the supported session locale, otherwise Arabic.

Intended destinations must be same-origin read routes on an explicit allowlist. They reject foreign origins, protocol-relative URLs, malformed paths, unrecognized routes, wrong roles, mismatched Student/Teacher identifiers, and incompatible current assignment/membership contexts. Legacy GET mutations are not eligible. Unverified destinations fall back to the user's role home rather than guessing authorization. Target middleware/controllers still authorize the subsequent request.

This is deliberately not a universal resume-any-GET mechanism. Future additions to the intended allowlist require review of their read-only and ownership contracts. No Teacher timetable, Student membership, or Officer permission rule was changed.

### What was not established

The intermittent production 403 was not reproduced against production. Local PHP's built-in server does not execute Apache `.htaccess`. WAF/ModSecurity decisions, host cookies, session-store expiry, filesystem permissions and hosting rewrite configuration remain possible independent causes. Correlate a failing request's URL, time, status and server/security logs before further changes. Do not globally turn 403 into login redirects or disable security rules.

Root `/` retains the established public localized homepage convention; it was not turned into a forced login page. Genuine 403 and 404 responses remain distinct from unauthenticated access and CSRF expiry. No global error-page/debug configuration was changed.

## Verification performed

### Live local guest HTTP requests

Requests went to the running PHP server at `127.0.0.1:8000`, using the project `server.php`, not only route inspection:

| Request | Observed response |
|---|---|
| `/` | 302 to `/ar` |
| `/ar`, `/en` | 200 |
| `/login`, `/ar/login` | 302 to `/ar/adh-login` |
| `/en/login` | 302 to `/en/adh-login` |
| `/ar/adh-login`, `/en/adh-login` | 200 |
| `/SMARMANger` | 302 to `/ar/adh-login` |
| `/SMARMANger/teacher` | 302 to `/ar/adh-login` |
| `/SMARMANger/dashboard/student` | 302 to `/ar/adh-login` |
| `/SMT/admin/students` | 302 to `/ar/adh-login` |
| Unregistered diagnostic URL | 404 |
| New CSS and JS URLs | 200 each |

### Real-data authenticated runtime rendering

All four requested lesson URLs returned **200** through the Laravel HTTP kernel with their real linked Teacher/Student identities, middleware and shared layouts. This used programmatically bound authenticated users, array sessions/private compiled views and a MariaDB `READ ONLY` transaction; it was not a password login or a browser session. No live account/session was replaced.

### Isolated automated tests

- Combined relevant suite: **264 tests, 5,511 assertions, PASS**. Includes Gradebook/assessment privacy, timetable authority, Teacher follow-up, Admin timetable, Complaint workflow, and the new login/UI tests.
- New focused tests: **11 tests, 232 assertions**. Cover guest redirects; supported session locale; both existing login endpoints; Student/Teacher/Admin homes; safe intended and rejected destinations; login GET without token deletion; explicit logout; 403/404/419 distinctions; wrong role/Student identity; Teacher lesson creation and forbidden assignment; file/link saves in fake storage; unchanged upload fields; all tab targets; empty and multiple content states; original URLs and HTML escaping.
- Four existing AJAX CSRF assertions were updated from login redirects to explicit 419 responses. Their checks for unchanged records remain in place.
- **11 frontend harnesses pass**, including the new lesson workspace harness (RTL/LTR keys, Bootstrap event synchronization, safe long filenames, validation/busy handling and back-page recovery).
- **82 Blade views compiled and PHP-linted in disposable storage**. All changed PHP/Blade files pass PHP 7.4 lint. `node --check` passes for the new script and all **13 inline scripts extracted from the four fully rendered pages** (raw script extraction, not libxml's HTML interpretation of JavaScript template strings).
- Changed files are valid UTF-8 without BOM; comparisons found no increase in suspicious mojibake markers relative to task baselines. Existing unrelated legacy corruption was not rewritten.
- `git diff --check` passes.

Test writes used SQLite `:memory:` and isolated storage. Live-school queries were read-only. Test uploads and notifications did not target school media or real recipients.

### Responsive acceptance still required

| Width | Implemented behavior | Browser status |
|---|---|---|
| 280, 320 | Single-column tabs, forms and content; wrapped filenames | Pending |
| 360, 390, 430 | Two-column wrapping tab grid; single-column forms/cards | Pending |
| 768, 1024 | Adaptive tabs; two-column form/card grid within content shell | Pending |
| 1366 | Adaptive tabs; two-column content grid | Pending |
| 1920 | Bounded content width; three-column content-card grid | Pending |

CSS cascade inspection includes the existing important width/offset rules. It does **not** prove pixel layout. Manually check all listed widths, low-height landscape modals, Add/Edit, long Arabic filenames, tab clicks/keyboard focus, file/media actions, sidebar-open/closed layout, no horizontal page overflow, and actual upload feedback using authorized test data. There is no measured `scrollWidth <= clientWidth` result for this task.

## Data/configuration protection

Before/after snapshots match exactly across **166 tables / 326,341 rows**, table schemas, triggers, Gradebook JSON/status files and selected protected Gradebook source files.

Snapshot SHA-256: `1264ad73c4d264cb070c7d7ed7da7e7d62ffa00e390aacdcae32ed51892de7db`.

Separate hashes confirm `.env` and `.env.example` unchanged. No real upload, lesson, Student/User, placement, financial, grade, notification or assignment rows were modified. Existing dirty worktree changes were preserved. No migrations were run against the school database; test schema setup/migration regressions were isolated.

## Exact files changed in this task

| Files | Purpose |
|---|---|
| `public/assets/css/lesson-workspace.css` | New opt-in layout/form/card/modal rules |
| `public/assets/js/lesson-workspace.js` | New tab accessibility, filenames and submit recovery |
| `resources/views/teachers2/teacher_lessons.blade.php` | Add/Edit modal presentation, assets and validation feedback |
| `resources/views/teachers2/teacher_addcontent.blade.php` | Full-width workspace, upload labels/IDs, form grouping and validation feedback |
| `resources/views/teachers2/teacher_showcontent.blade.php` | Full-width workspace, missing existing panel tab, empty states, dependency cleanup |
| `resources/views/students/new_lecture_content.blade.php` | Scoped presentation, missing existing panel tab, empty states, dependency cleanup |
| `resources/views/students/layouts/app4.blade.php` | Only the requested active sidebar label/item edits in this pass |
| `app/Services/SchoolLoginNavigation.php` | New canonical locale/role/intended-navigation contract |
| `app/Http/Controllers/Auth/LoginController.php` | Canonical legacy GET, role destinations, safe intended handling, cleanup only on logout |
| `app/Http/Controllers/websitecontroller.php` | One successful-login redirect delegates to the safe intended resolver |
| `app/Http/Middleware/Authenticate.php` | Canonical guest login URL |
| `app/Http/Middleware/RedirectIfAuthenticated.php` | Correct role home for existing sessions |
| `app/Http/Middleware/roleadmin.php`, `rolestudent.php`, `roleteacher.php` | Guest-only canonical redirect/JSON 401 branches |
| `app/Exceptions/Handler.php` | Localized generic CSRF recovery; explicit JSON 419 |
| `resources/lang/ar/auth.php`, `resources/lang/en/auth.php` | Session-expired translations |
| `resources/views/website/login.blade.php` | Display the explanatory session error |
| `routes/web.php` | Reliable bare login alias and guest gateway |
| `.htaccess` | Exact legacy login-directory front-controller rewrite |
| `tests/Feature/SchoolLoginNavigationTest.php` | Isolated auth, creation and upload regressions |
| `tests/Feature/LessonWorkspaceViewTest.php` | Isolated view/DOM contracts and content-state regressions |
| `tests/Frontend/lesson-workspace.test.js` | Frontend behavior checks |
| `tests/Feature/GradebookSafetyTest.php`, `tests/Feature/GradebookTemplatesTest.php` | Only four existing CSRF expectations/comment adjusted in this pass |
| This report | Evidence, limits and handoff |

## Additional findings outside the requested fix

These are not resolved by a login redirect and were not silently changed:

1. **High, legacy content scoping review:** `studentscontroller@lecture_content` authenticates the Student through middleware, but loads the supplied lecture and its content by lecture ID without explicitly proving that lecture belongs to the selected subject/current Student section/year. The method also assumes `room[0]` exists. A separate ownership/placement hardening pass should test foreign lecture IDs and missing current enrollment. Existing route-Student-ID protection remains intact; this report does not claim all lesson-object authorization is complete.
2. **High, legacy Teacher read-context review:** `teacher_rooms2` checks current section assignment/class but subsequently loads the supplied lecture ID independently; `book_details` likewise retrieves lecture metadata separately. Write paths already have additional lecture-owner/context checks. Review direct foreign lecture reads separately rather than changing upload or assignment business rules in this UI pass.
3. **Medium, legacy query risk:** `book_details` has ungrouped `orWhere('type', '5')` in its old quiz/exam collections, potentially escaping other constraints. The refined card panels use the separately scoped collections; this is a query risk, not proof those old collections are currently exposed. Do not normalize historical data to address it.
4. **Low, existing denial wording:** wrong Student IDs and archived accounts share the Student middleware's account-archived logout message. This was preserved rather than mixing an authorization-policy rewrite into the navigation correction.
5. **Hosting follow-up:** confirm the exact `/login` rewrite in the production document-root configuration and obtain logs for any remaining intermittent 403. PHP-local success is not Apache acceptance.

## Handoff

Local implementation and automated/runtime checks are complete. The outstanding acceptance items are real-browser visual/interaction checks at the nine requested widths, authenticated browser login/navigation checks, and production-server diagnosis of any remaining intermittent 403. The legacy scoping findings above need separate explicit review before claiming comprehensive content authorization hardening.
