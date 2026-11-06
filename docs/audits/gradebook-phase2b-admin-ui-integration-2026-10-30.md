# Phase 2B: integration with existing Admin Gradebook

Date: 2026-10-30, Asia/Damascus. Scope: existing Admin navigation and template UX only.

## 1. Existing architecture, verified before editing

All six requested routes use the existing Gradebook route group: `auth`, `roleadmin`, `can:student_marks`. Its definitions remain in `routes/gradebook.php`; no route or authorization change was needed.

| Requested route | Active controller/view and behavior |
|---|---|
| `/SMT/admin/gradebook` | `GradebookController@index` -> `admin.gradebook.index`; review/settings entry cards. |
| `/SMT/admin/gradebook/settings` | `GradebookSettingsController@index` -> `admin.gradebook.settings.index`; current-year class list, current-year section counts, server pagination. |
| `/SMT/admin/gradebook/settings/rooms/1` | `viewRooms(1)` -> `settings.rooms`; sections for class 1 in the globally current year. |
| `/SMT/admin/gradebook/settings/subjects/130` | `viewSubjects(130)` -> `settings.subjects`; current-year section, its class's lessons, current timetable-backed Teacher labels, JSON-file configuration presence. |
| `/SMT/admin/gradebook/settings/edit/406` | `edit(406)` -> **`settings.edit_json`**; `GradebookConfigService::getConfig(406,currentYearId)`. The similarly named `settings.edit` three-field database/config view is not returned by this active route. |
| `/SMT/admin/gradebook/templates` | `GradebookTemplateController@index`; previously global year/combined-class-subject selectors and an unrelated all-template table; now the context-first entry described below. |

The authoritative parent for these routes is **`resources/views/admin/master.blade.php`**. Existing `admin2` views are not returned by these routes. The template pages already extended the same master: a different parent layout was **not** the root cause.

Existing conventions are the `breadcrumbs` section and `breadcrumbs__item` links, `container-fluid mt-3`, Bootstrap cards with white bordered headers and `text-primary` headings, existing Font Awesome icons, bordered/hover/striped tables, standard form controls/buttons, alerts and server pagination. Typography and colors come from the existing Admin stylesheet. The master supplies existing common Bootstrap/jQuery/plugins and the `style`/`js` sections; no additional dependency is needed.

The active JSON editor uses component IDs, data-source mappings and the legacy `weight` field. Its inline JavaScript displays percentages and totals. Those are existing behavior, not an approved new template calculation model. They were inspected but neither copied into the template maxima editor nor changed. Published template UUID components remain separate from legacy config IDs/sources.

Existing settings infer the academic year with `Year::where('current_year',1)->first()`. There is no broader year selector in that flow. The new template navigation reads the same authoritative flag but requires exactly one current row before choosing a default. It does not change the legacy resolver or Teacher logic.

### Verified local identities and relationships

Read-only SQL confirmed:

- Current year: **6 / 2026/2027**, uniquely flagged current; future year records also exist.
- Class **1**: **الصف الأول**.
- Section **130**: **الأول - أولى**, class **1**, year **6**.
- Subject **406**: **معلوماتية**, class **1**, existing maximum **100**.
- Class 1 has **20** stored lessons, discovered by `lessons.class_id`, including subject 406.
- `Classe::lessons()` and `Lesson::classes()` represent this actual relationship. Lessons have no year column. Teacher/section assignments provide operational teaching context, not a prerequisite for creating an inactive subject/year definition.
- All three Phase 2B tables were empty at the start and remain empty in the school database.

No data correction or inference from the numeric IDs was performed.

## 2. Root cause and focused plan

The Phase 2B UI used the correct master but bypassed the familiar context navigation, omitted its breadcrumbs, offered one enormous mixed subject/class selector, and repeated that selector inside duplication. It placed a generic top-level link alongside the Gradebook menu instead of extending settings. Large headings/full-width forms and isolated inline styles reinforced the separation.

The implemented plan preserves the existing backend and integrates the entry points and navigation: reuse settings links, class/subject tables, breadcrumbs and form/card conventions; resolve year explicitly; filter subjects through the same class relationship; reopen existing templates; and retain a clear settings return path. Section/term application remains unavailable.

## 3. Corrected workflow

**Gradebook -> Distribution settings -> Academic year -> Class -> Subject -> Template.**

1. Existing settings now exposes templates at the year/class level. The existing subject list and JSON editor have a **قالب تقييم المادة** link carrying the verified year/class/lesson IDs. The loose template shortcut on the main Gradebook menu was removed; its existing settings/review choices remain unchanged.
2. `/templates` defaults to the single current year, displays it clearly, and offers an explicit year selector. Changing the year resets class/subject navigation. If zero or multiple years are current, no default is guessed: a localized warning asks the Admin to choose an existing year explicitly.
3. The class table follows existing settings patterns, showing human-readable names and lesson counts, with 15-row pagination.
4. Choosing a class shows only its `Lesson::where('class_id',...)` subjects, with 20-row pagination and a batched existing-template lookup for the selected year. There is no all-subject dropdown and no section application selector.
5. A subject with an existing template opens it. Selecting that same context directly, or submitting an already-existing context, also reopens it without adding an audit event or replacing its draft. Database uniqueness/concurrency protection remains authoritative for races.
6. A subject without a template opens a compact named-draft form with a read-only context summary and hidden year/class/lesson IDs. The submitted class/subject pair is checked again on the server. The existing service still owns creation, validation and transactions.
7. Draft, preview and immutable-version screens share the existing Admin shell, breadcrumb trail, scoped card/form styling and context hierarchy. Component add/rename/reorder/remove, maxima, preview confirmation, publication, version history, discard and audit retain their original contracts.
8. Duplication follows the same year/class/subject navigation with an explicit source version. It creates independent component UUIDs through the existing service. An existing destination opens for review rather than being overwritten.

All template screens explicitly say that publishing changes neither the active distribution nor student marks and that application to sections/terms is not available yet. The preview still states that it is structural only. It does not show or claim mark-level impact.

For a template in the uniquely current year, the return link opens its matching legacy subject editor (or class sections). For another year, it links only to clearly labelled current-year settings: it cannot misleadingly open an old-year template's subject in a current-year editor under an old-year label. If a lesson's class has drifted, the parent template's pinned class is displayed and the mismatched direct-editor link is not offered.

## 4. Reused components and responsive treatment

- Same `admin.master`, style/script slots, breadcrumbs, Bootstrap grid/cards/headers, form controls/buttons, tables, alerts, Font Awesome icons and pagination.
- `templates/layout.blade.php` centralizes template shell integration; `context` and `settings-link` partials share context/return behavior.
- New CSS is restricted to `.gbt-page` and `.gbt-breadcrumbs`: wrapping toolbars/buttons/breadcrumbs, readable context labels/values, bounded name fields, mobile card padding and contained table scrolling. It inherits the Admin typography/colors and does not style unrelated pages.
- The existing component-editor JavaScript and its delegated handlers/UUID fields are unchanged. Context navigation uses ordinary GET links/forms and works without a new JavaScript plugin or AJAX race.
- Arabic and English labels are localized; Arabic content remains RTL. No claim of pixel-level desktop/mobile acceptance is made without browser inspection.

## 5. Files changed in this correction

Application/read integration:

- `app/Http/Controllers/Admin/GradebookTemplateController.php`: context navigation, bounded discovery, safe reopening, destination class validation and context data for views.
- `app/Http/Controllers/Admin/GradebookSettingsController.php`: passes its already-resolved year to the JSON editor; no settings query/update/calculation change.
- `app/GradebookTemplate.php`: adds the read-only `grade()` relationship for its pinned class.

Views and labels:

- `resources/views/admin/gradebook/index.blade.php`: removes the loose template shortcut introduced in 2B.
- `resources/views/admin/gradebook/settings/index.blade.php`
- `resources/views/admin/gradebook/settings/subjects.blade.php`
- `resources/views/admin/gradebook/settings/edit_json.blade.php`
- `resources/views/admin/gradebook/templates/index.blade.php`
- `resources/views/admin/gradebook/templates/show.blade.php`
- `resources/views/admin/gradebook/templates/preview.blade.php`
- `resources/views/admin/gradebook/templates/version.blade.php`
- `resources/views/admin/gradebook/templates/scope.blade.php`
- New `resources/views/admin/gradebook/templates/layout.blade.php`
- New `resources/views/admin/gradebook/templates/context.blade.php`
- New `resources/views/admin/gradebook/templates/settings-link.blade.php`
- New `public/assets/admin/css/gradebook-templates.css`
- `resources/lang/ar/gradebook_templates.php`
- `resources/lang/en/gradebook_templates.php`
- `tests/Feature/GradebookTemplatesTest.php`: five context/navigation regression cases.
- This report.

No route, migration, GradebookTemplateService, locking, publication transaction, database trigger, Teacher entry or academic calculation code changed. Existing year/lesson-only POST callers remain compatible; the new UI supplies and validates the additional class field. There is no schema requirement.

## 6. Verification and preservation

- **109 tests / 1,837 assertions PASS** across Gradebook safety/continuity, timetable authority, follow-up eligibility, Phase 2A contextual readers, Admin timetable views and Phase 2B templates.
- The template suite covers creation, saved-draft reopening, component identities/edits, preview, V1/V2, immutable versions, audit, stale saves/publication, idempotency, rollback, CSRF, unauthorized denial and preservation of legacy files/results. The new cases verify year default/explicit choice/ambiguity, class-only discovery, empty classes, forged class-subject rejection, reopening without writes, contextual duplication, pinned class display and localization.
- Existing Admin settings GET/update tests and Admin/Teacher/Academic Record compatibility tests pass. They retain the existing calculator, maxima, original result identities, actual terms and zero/null behavior.
- All four frontend harnesses PASS: template editor, save, status and continuity.
- All **33** Admin Gradebook Blade views compile and lint in isolated storage. Six touched PHP files pass PHP 7.4 lint. **40** inspected application/test/Gradebook-view files are valid UTF-8 without BOM. Obvious mojibake scan and `git diff --check` pass.
- Before/after SELECT-only manifests match for all **166 school tables / 326,259 rows**, including schema, counts and complete deterministic row hashes. All captured configuration/status/service/migration files match. Shared manifest SHA-256: **dffc8a7d7a6d4b6ebad0124daacdc2d39528a9370ed8e5a2e0e975ce29d380b4**.
- No school template, version or audit test records were created. School data, marks, finances, placements, equivalence, assignments, JSON settings and locks remain unchanged. Tests use disposable SQLite and isolated storage; no migrations were run on the school database in this correction.
- Private preservation evidence: `C:/Users/Lenovo/.codex/backups/gradebook-phase2b-ui-61a36bb0934a4c10a6e6f62c665e39f1`. Do not upload private school snapshots.

## 7. Browser evidence and remaining acceptance

**Screens actually inspected in an authenticated browser: none.** Browser tooling and an authenticated Admin session were unavailable. Route/controller/relationship findings are source/SQL evidence; rendered pages in tests use the actual child views with an isolated layout fixture. They do not certify the real shell, screenshots, viewport overflow, focus, browser console or network behavior.

Remaining manual acceptance, preferably on a disposable clone with legitimate existing Admin login:

1. Follow the five requested Gradebook/settings URLs; confirm existing settings and the contextual template links remain usable.
2. Open templates through settings; verify the current-year default, year changes, class reset and class-only subjects. Open the subject context; create a test draft only in the clone or an explicitly approved isolated scope, then reopen it through both settings and context navigation.
3. Save/rename/reorder/remove/add components, preview and publish V1/V2; verify immutability, audit, discard reason, stale-tab feedback and contextual duplication. Confirm no settings/marks/application changes.
4. Review Arabic RTL and English, desktop/tablet/narrow mobile layouts, long names, breadcrumb/action wrapping, internal table scrolling, editor controls, validation, confirmation and console/network errors.
5. Check legitimate unauthorized sessions and confirm historical/future template return links cannot masquerade as old-year legacy editing.

The preceding local schema acceptance remains valid. Full Phase 2B authenticated browser acceptance remains pending; this correction does not label it complete.

## 8. Phase 2C implication

The reusable definition is now reached through the school's year/class/subject workflow. Future application can extend that context with explicit actual-term and one/several/all-section selection under its own approval, impact and authorization contracts. This correction creates no applications, adopts no historical assessments and assigns no Teacher responsibility. It neither replaces the JSON backend nor resolves unrelated legacy year-name/ledger/data inconsistencies.

No Phase 2C work, deployment, commit or push occurred. Existing unfinished work and `.env.example` are preserved.
