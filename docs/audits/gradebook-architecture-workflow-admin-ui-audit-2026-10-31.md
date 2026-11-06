# Advanced Gradebook: Architecture, Workflow and Admin UI Audit

Date: 2026-10-31, Asia/Damascus. Project: `C:/Users/Lenovo/Desktop/aladhamedu`.

**Scope: read-only investigation; this report is the only permitted new file. No implementation is authorized by this document.**

## Evidence and Limits

Reviewed the current routes, controllers, services, models, migration source, active Blade hierarchy, local frontend assets, configuration/status JSON and these existing reports:

- `gradebook-phase2-readiness-and-roadmap-2026-10-29.md`
- `gradebook-phase2a-context-compatibility-2026-10-29.md`
- `gradebook-phase2b-implementation-2026-10-30.md`
- `gradebook-phase2b-local-acceptance-2026-10-30.md`
- `gradebook-phase2b-admin-ui-integration-2026-10-30.md`

Local database evidence comes from direct PDO SELECT queries inside read-only transactions, rolled back afterward, against the verified local `aladham_oct` database, MariaDB 10.4.32. No Laravel application bootstrap, migrations, test fixtures, cache generation or authenticated form submissions were performed for this audit. Existing tests and earlier results were inspected, not rerun. They are prior evidence, not fresh acceptance.

**Authenticated browser acceptance: not performed.** No browser-control/authenticated Admin session was available. Route behavior below is established from source plus actual stored context, not claimed as observed HTTP responses, screenshots or viewport tests. Local asset existence is not proof that every deployed URL/CDN loads.

## A. Executive Verdict

**Partially duplicated architecture; unnecessarily duplicated everyday administration.**

The operational distribution editor already configures named components, percentages, ordering and source mappings. Phase 2B adds a second component-definition editor with different storage and semantics. Both are exposed in the same subject workflow as **إعداد التوزيع** and **قالب تقييم المادة**, although only the former currently affects operational Gradebook reads/entry. The template notice accurately says publishing does not apply anything; that warning does not make two everyday editors simpler for staff.

The new backend is not merely redundant: stable UUIDs, immutable publication, revision checks, reviewed publication, audit and independent duplication are useful capabilities missing from the active JSON editor. However, these capabilities are not yet connected to active distributions. A published version is **not** an applied distribution, an assessment-equivalence identity, a frozen transcript or an authorization grant.

**Recommendation: Option A as the target, with Option C as the immediate release boundary.** Keep one familiar distribution workflow. Retain all Phase 2B infrastructure and records; defer its separate everyday management surface until explicit adoption/application semantics are approved. Later integrate useful versioning behind that same workflow rather than require staff to maintain two competing definitions. Do not connect the editors merely by renaming buttons or swapping their save services.

The visual mismatch is independently confirmed: the real dashboard uses `admin.layouts.v2`; every routed Admin Gradebook screen still reaches `admin.master`.

## B. Existing System Map

### Actual navigation and route contract

`routes/web.php:264` loads `routes/gradebook.php`. Gradebook endpoints retain `auth`, `roleadmin`, `can:student_marks`. Template operations additionally require the service's existing type-2 Admin check and capability checks. Navigation visibility is not a substitute for those server checks.

Existing operational path:

`دفتر العلامات -> إعداد التوزيع -> الصف -> الشعبة -> المادة -> تعديل التوزيع`

Existing review paths:

`دفتر العلامات -> استعراض -> حسب المادة / حسب الطالب -> الصف -> الشعبة -> جدول / بطاقة`

Template discovery was inserted into settings/class selection, subject actions and the distribution editor. Its own context is **year -> class -> subject**, not section or actual term. The loose home-page template shortcut was already removed in the preceding integration; competing subject/editor links remain.

For the following route table, `G` means `app/Http/Controllers/Admin/GradebookController.php`, `S` means `GradebookSettingsController.php`, and `T` means `GradebookTemplateController.php`. View paths are relative to `resources/views/`; every listed GET ultimately uses `admin/master.blade.php`, including templates through their intermediate layout.

| Exact requested route | Controller and active view | Context, purpose and reads/writes | Operational/dependency status |
|---|---|---|---|
| `/SMT/admin/gradebook` | `G@index` -> `admin/gradebook/index` | Review/settings entry cards and equivalence link. No calculation or configuration write. | Working legacy-shell entry; misleading old source comment says edit is disabled, but its settings link is enabled. |
| `/SMT/admin/gradebook/settings` | `S@index` -> `settings/index` | First globally current year; classes and counts of that year's sections; pagination 10. Template entry carries year. GET reads only. | Operational distribution discovery, not a template application. |
| `/SMT/admin/gradebook/settings/rooms/1` | `S@viewRooms` -> `settings/rooms` | Class 1 plus globally current year; paginated sections with student relation. No selected term and no write. | Section is a navigation/discovery context, not a separate config owner. |
| `/SMT/admin/gradebook/settings/subjects/130` | `S@viewSubjects` -> `settings/subjects` | Section must belong to current year; class's lessons; Teacher labels constrained by section/class/year and `currentTimetable()`; JSON-file existence per subject. | Shows both competing actions. File presence is not proof of valid/used configuration. No template/mark write. |
| `/SMT/admin/gradebook/settings/edit/2` | `S@edit` -> **`settings/edit_json`** | Lesson 2 and globally current year; `getConfig(2,yearId)`. No section/term-specific config. GET reads only. | Active operational editor; `settings/edit.blade.php` is not this route's view. POST is separate, described below. |
| `/SMT/admin/gradebook/view/options` | `G@viewOptions` -> `view_options` | Select subject-review or student-review path; no year-specific read/write yet. | Operational legacy-shell navigation, no template dependency. |
| `/SMT/admin/gradebook/templates` | `T@index` -> `templates/index` | Validates explicit year/class/lesson when present; defaults year only if exactly one is current. Paginates classes with lesson counts. GET creates no draft. | Phase 2B discovery is installed; definitions remain operationally inactive. |
| `/SMT/admin/gradebook/templates?year_id=6&class_id=1` | Same -> `templates/index` | Explicit year 6/class 1; only that class's lessons, 20 per page; batched lookup of existing subject/year templates. No section/term application or write. | Separate definition workflow, not an alternative operational settings reader. |
| `/SMT/admin/gradebook/templates?year_id=6&class_id=1&lesson_id=2` | `T@index`; existing-parent branch redirects to `templates.show`, whose `T@show` renders `templates/show` | Class/subject pairing validated. Actual local parent is template 1, so source dictates reopening it, not creating another. Reads its versions and paginated events. | Existing empty draft, revision 1; no published version. Redirect is source-verified, not browser-tested. |

### Local identities and installation state

Fresh SELECTs confirmed:

| Item | Current local evidence |
|---|---|
| Current year | Exactly one flag: year **6**, **2026/2027**. |
| Example class/section | Class **1**, **الصف الأول**; section **130**, **الأول - أولى**, class 1/year 6. |
| Example subject | Lesson **2**, **اللغة الأجنبية**, class 1, subject maximum **100**. Lesson 406 is معلوماتية, also class 1/max 100. |
| Actual terms | Year 6 has term **20**, type 1/current. Year 5 has **13,17,18,19**, including two type-1 and two type-2 instances; 17 is that year's flagged term. An older year's current flag must not be treated as globally current. |
| Phase 1 | Migration ledger 52/batch 24; `assessment_equivalence_members` exists, **0** mappings. Installed foundation does not prove live mapped continuity has been accepted. |
| Phase 2B | Migration ledger 53/batch 25; all three tables and four immutability triggers present. **1 template, 0 versions, 1 event**. |
| Existing draft | Template **1**, year 6/class 1/lesson 2; revision **1**, last version **0**, **0 draft components**; created 2026-10-31 11:54:46. Event is `template_created`. Do not assume it is disposable test data. |
| Legacy assessment population | `exams2`: **2,255**; `exam_result2`: **27,318**; `exam_result`: **0**. The second source remains supported in code despite having no rows locally. |
| Old SQL config architecture | Migration ledger contains the old `gradebook_configs`/`gradebook_components` entries, but neither physical table exists in this database. Their old models/views are not the active JSON editor. Do not repair this unrelated discrepancy here. |

The October 30 reports' empty-table statements describe their earlier checkpoints. They must not be reused as the current database state. This audit created none of the existing template/event records.

### Persistence, calculations and readers

| Responsibility | Actual owner and scope | Important boundary |
|---|---|---|
| Active config read/write | `GradebookConfigService`, default Storage disk, `gradebook/{lessonId}_{yearId}.json` | One subject/year distribution across sections and terms. `getConfig(lessonId,yearId)` has not become contextual. |
| Operational distribution save | `S@update`, POST `/SMT/admin/gradebook/settings/update/{subjectId}` | Writes JSON only; not a draft/version/application. No optimistic revision token or immutable file history. |
| Operational status | `GradebookStatusService`, `gradebook_status/{classId}_{actualTermId}.json` | OPEN/LOCKED, missing defaults LOCKED; class/actual-term scope, not subject/section/version. |
| Status write | `G@toggleStatus`, POST **`/gradebook/status`** | Existing protected endpoint, validates term belongs to a current year. Preserve scope; do not silently make it a universal assessment lock. |
| Shared academic read | `GradebookReadService` | Reads original results, actual terms and legacy source mappings; Phase 1 continuity projections do not rewrite originals. |
| Legacy aggregation | `GradebookAggregationController` / `GradebookAggregationService`, POST `/SMT/admin/gradebook/aggregate` | Explicit administrative mutation into `students_marks` legacy JSON; not needed for the live subject grid. Do not run during UI work or assume it understands template UUID components. |
| Context inspection | `GradebookContext`, `GradebookContextReader`, `GradebookReadSnapshot` | Phase 2A opt-in read-only DTO; validates exact relationships and fingerprints files. Existing callers were deliberately not switched to it. |
| Inactive definitions | `GradebookTemplate`, `GradebookTemplateVersion`, `GradebookEvent`, `GradebookTemplateService` | SQL draft/version/event history only; no applications, source-binding cutover or Teacher assignment creation. |

`S@update` validates component names <=191 characters and integer weights 0..100. Stored components contain `id`, `name`, `weight`, `data_source`, `sort_order`; an existing explicit `max_mark` is preserved but is not edited by this form. The envelope stores lesson/year and update time. Existing IDs are retained, new legacy component IDs use `comp_...`, and unused dynamic source numbers begin at 100. Used dynamic containers protect removal/weight changes; source-rebinding checks protect existing mappings. These protections are real, but are not comprehensive immutable historical configuration/versioning.

The UI displays total percentages and colors the progress bar; the server does **not** require a total of exactly 100. Do not infer an approved mandatory-100 policy from the form's presentation.

The calculation contract in `GradebookReadService:29-105` is decisive:

- Component maximum: valid explicit `max_mark`, otherwise `subject.max_mark * weight / 100`.
- Actual earned component value: maximum for `LEGACY_EXAM`; average for other matching sources; rounded to one decimal.
- Total: sum of present raw component values. Weight is **not** a new multiplication/scaling rule applied to earned marks.
- Zero is a real result; missing is null. Historical decimal scores remain decimal.
- `exams2`/`exam_result2` and `lesson_teacher_room_term_exam`/`exam_result` are distinct source systems. The latter contributes confirmed status-1 results as `LEGACY_ORAL`.
- Ordinary Exams2 type 1/type 2 map to exam/quiz sources; `Dynamic_Section_N` requires its exact valid type/class/section/subject/actual-term context. Component labels are not identities.
- All actual year terms are read unless an explicit term subset is supplied. Multiple occurrences remain separately available. Duplicate dynamic containers/conflicting carry are flagged rather than silently combined.

Downstream Admin `viewGridSimple` uses the selected section's stored year; current rosters use operational membership and old-year rosters use year-scoped enrollment. It renders **`view_by_subject_corrected`**. Its compatibility summary chooses one representative actual term per type, preferring flagged/current then higher ID; the included `gradebook/assessment_results` still exposes exact assessments/terms. The student card uses current membership and renders `view_by_student`. A future UI must not mistake those two summary tabs for all actual term identities.

Advanced Teacher `Teacher/TeacherGradebookController` uses the unique active year, that year's current actual term, current timetable authorization and current student membership. Shared reads use the current term. Its dynamic entry additionally checks OPEN status and a numeric configured source >=100, writing original assessment/result rows under existing safeguards. Templates are not consulted.

Student Academic Record `studentscontroller@academic_record_show` scopes by the student's owned placement/year/section and reads stored `students_marks`, `report_cards`, original results, files/submissions and certificates. It does **not** directly use the new template backend or the JSON config reader. Report summaries and original assessments have their own mappings; config/version adoption therefore needs explicit consumer agreement, not an assumption that every portal already shares the same template calculator.

Phase 2A distinguishes valid JSON, missing/defaults, invalid/unreadable data, unresolved/historical/future context, ID/source warnings and conflicting legacy lookups. A requested `versioned_template` still returns **backend unavailable**: installing definition tables did not implement applications. The context object is neither permission nor a historical-policy reconstruction.

### Actual local legacy examples

There are four local config files, all for year 5: `158_5`, `31_5`, `49_5`, `50_5`; none has explicit `max_mark`. Status files are `3_17` OPEN and `4_17` LOCKED. No current-year JSON exists for lesson 2, so its active editor resolves the three legacy defaults with zero weights, not the new SQL draft.

`49_5.json` contains the known mismatch: component ID **`legacy_homework`**, name **الوظائف**, weight **0**, but source **numeric 100**, not `LEGACY_HOMEWORK`. Other examples mix string and numeric dynamic sources and include configurations without `legacy_oral`. These are evidence to retain, not permission to normalize. The existing update branch forces canonical sources for reserved IDs; replaying a mismatched old file through it is consequently not a guaranteed lossless import.

## C. Old Distribution Versus New Template

| Capability | Active distribution | Phase 2B template |
|---|---|---|
| Named components/order/add/remove | Yes, operational | Yes, structurally overlaps |
| Scope | Subject/year; section is discovery | One parent per subject/year, pinned class; no application |
| Numeric definition | Integer percentage weight 0..100; optional retained explicit maximum; zero permitted | Positive integer absolute maximum 1..2,147,483,647; no percentage/source binding field |
| IDs and mappings | Reserved legacy IDs, `comp_...`, exact source strings/numbers, original assessment/result IDs | Server UUID v4 component identity; not a source mapping or assessment equivalence |
| Actual grading effect | Used now by Admin/Advanced Teacher shared reads and dynamic entry | None; structural publication only |
| Stable rename/reorder | Existing IDs retained, mutable file | Stable UUID plus revision history |
| Publication/history | No immutable published snapshot | Immutable versions with hash, scope/name snapshots and publisher/time |
| Concurrency | File put; no compare-and-swap revision | Parent locks, revision checks, publication uniqueness/idempotency |
| Audit | File update timestamp, no complete immutable change trail | Append-only events, discard reason/payload, actor evidence |
| Reuse | No dedicated reviewed version duplication | Copy published version to another available subject/year with independent component IDs |
| Permissions/locks | Existing Admin guards and class/term Advanced-entry lock semantics | Existing Admin publishing safeguards; publishing does not open/close Gradebooks |
| Historical safety | Original result safeguards, but mutable configuration remains a limitation | Definition history protected; old marks are not automatically bound to it |

**Why templates were introduced:** repeatable reusable definitions, controlled editing/publication and traceability needed before a later application layer. **What was already solved:** staff could configure the active subject distribution. Two visible editors were not required to deliver the backend foundation.

Removing/hiding normal template links, while preserving authorized review access, loses discoverability of drafting/preview/version-copy tools, not current Teacher grading functionality. Disabling all template UI would also remove staff access to the existing draft/audit and needs explicit approval. Abandoning the backend entirely would forfeit its version/audit/concurrency investment; dropping its installed tables/triggers would additionally risk history and is not recommended.

Version history can eventually sit behind the familiar editor, but not through a lossless field rename. With subject maximum 200, weight 25 means calculated bound 50, not maximum 25. With maximum 100 they happen to coincide numerically. Explicit maxima, zero/default components, integer-only template maxima and nonstandard source mappings prevent a universal reversible conversion. Neither an inferred maximum nor a matching label proves historical meaning. Preserve raw legacy evidence and reviewed mappings; do not auto-convert percentages, scale old marks or infer equivalence.

The template policy string `legacy_read_v1_unchanged` is metadata. It is not an executed compatibility engine or evidence that a future application preserves current calculations.

## D. Why the Previous UI Integration Missed the Target

The preceding integration report correctly identified the parent of the **existing Gradebook routes**, then treated it as the intended school-wide design reference. That was the wrong comparison target.

- `/SMT/admin/index` -> `DashboardController@index` (`app/Http/Controllers/DashboardController.php:4637-4649`) -> `admin/index.blade.php` -> **`admin.layouts.v2`**.
- Gradebook -> `admin.gradebook.*` -> **`admin.master`**; templates add `admin.gradebook.templates.layout` but still inherit the same old master.
- `admin2` is not the parent of either requested flow. No stale view cache is needed to explain this mismatch: the source explicitly selects different shells.
- Class/subject-first navigation and breadcrumbs improved structural integration, but deliberately reused legacy cards/breadcrumbs/colors/footer. It could not yield the modern dashboard sidebar/header/typography.
- Prior child-view tests used an isolated layout fixture, and the report disclosed no authenticated browser acceptance. Those tests cannot certify the real modern shell. The earlier claim of the "correct master" was true only relative to old Gradebook pages, not the user's dashboard reference.

This is an integration-target error, not evidence that the immutable-template transaction design must be discarded.

## E. Recommended Architecture

| Criterion | A: unified distribution | B: separate library and distributions | C: defer separate template management |
|---|---|---|---|
| Staff simplicity | Best eventual fit: one editor/context | Requires understanding definition vs application | Best immediate fit: keep familiar working flow |
| Technical complexity | Medium/high backend compatibility work | Highest: two concepts plus complete applications | Low immediately; no cutover |
| Existing-code reuse | Reuse forms/navigation/readers and 2B safeguards | Reuse both, but maintain two workflows | Reuse operational path; preserve 2B unchanged |
| Duplicate UI | Removes competing everyday actions | Justified only after a real reusable-library need | Removes/de-emphasizes duplication once approved |
| Historical-mark safety | Good only with explicit adoption/provenance | Good only with version-pinned applications | No new calculation/history risk |
| Phase 2C | Still required behind one UI | Required before applying anything | Deferred, not bypassed |
| Maintainability | One product surface, explicit adapters | Greater navigation/support/test burden | Simple now; avoid leaving a permanent undocumented half-feature |
| Migration needs | None for UI; additive application/binding schema later | Same plus wider application UX | None for visibility/layout; retain installed schema |
| Calculation risk | High if implemented as direct replacement; bounded with shadow agreement | Same semantic risk plus two editors | Lowest now; existing limitations remain |

**Choose A as product architecture, delivered through a C-style interim boundary.** This is a justified hybrid, not authorization to hide/delete UI now.

Everyday staff flow remains the existing class/section/subject path, with one obvious active-distribution action. Explain on that screen that the distribution is shared across that subject/year, despite discovery through a section. Review remains a separate read-only branch. A later controlled versioning step can present "review changes / save new approved version" inside the same flow; staff need not manage a second editor merely to change a component.

For now retain the existing template service, migration, models, tests, immutable versions/events and existing draft. Seek approval to remove competing normal-navigation links and retain clearly labeled authorized development/review access. Do not quietly change route permissions or replace the JSON writer. Option B remains reasonable only if the school explicitly needs a centrally managed reusable library distinct from active distributions; current code supplies no application workflow to make that distinction operationally useful.

## F. UI Unification Plan

### Exact reusable shell

Use **`resources/views/admin/layouts/v2.blade.php`**, with:

- `resources/views/admin/components/sidebar.blade.php`: school identity/logo, permission-aware menu sections, existing Gradebook link and `admin.gradebook.*` active state. Reuse it; do not add another Gradebook sidebar.
- `resources/views/admin/components/navbar.blade.php`: school title, mobile sidebar button, user/logout action. Its quick-search form is currently `javascript:void(0)`, not a working Gradebook filter.
- `resources/views/admin/components/page-header.blade.php`: `page_title`, `page_subtitle`, `breadcrumbs`, optional `hide_page_header`. Without explicit titles, a migrated page defaults to "لوحة التحكم".
- Main content, `style` and `js` section hooks; locale-aware RTL/LTR body and school-data branding. `admin/index`, `admin/student` and `admin/classes` demonstrate actual modern consumers. Dashboard-specific card CSS is not the universal shell contract.

V2 loads Cairo, Font Awesome 5.5, `assets/admin/css/style.css`, Toastr, local DataTables/Bootstrap-4 adapter, `plugins/common/common.min.js` and `js/custom.min.js`. The common bundle identifies **jQuery 3.3.1 and Bootstrap 4.1.3**. Thus basic existing Bootstrap forms/cards/tabs and jQuery AJAX have a compatible foundation; no Bootstrap upgrade is needed. Referenced local core/Gradebook asset files exist.

The shell provides a right fixed sidebar, modern navbar, light background, rounded white cards and blue navigation accents. Its root `--v2-primary` remains purple while specific navigation rules use `#3B82F6`/`#2563eb`; adopting V2 does not require changing the global palette. It does not include the legacy Sunrise-IT footer.

### Why changing only `@extends` is unsafe

| Compatibility point | Required bounded treatment in a later UI task |
|---|---|
| Titles and breadcrumbs | Provide Gradebook-specific title/subtitle; adapt old green `breadcrumbs__item` markup/styles within the feature. Prevent duplicate/misleading header cards. |
| Style scope | Some active review pages have unscoped `th`, `td`, `.pagination`, `.modal-header` rules; limit new overrides to a Gradebook wrapper. Do not copy global old-master CSS or website-only V2 rules. |
| Plugins | V2 does not reproduce old Select2, SweetAlert, CKEditor, charts or all DataTables extensions. Active config editor/template editor need native JS, review tabs need Bootstrap, status uses jQuery AJAX. Confirm each routed screen's actual dependencies; do not import every legacy plugin. |
| Table behavior | Old master includes multiple local/CDN DataTables bundles/extensions; V2 uses one local pair. Existing simple paginated lists must not gain duplicate initialization/client pagination over server pagination. Preserve matrix scrolling/print. |
| Script slots/order | Active JSON editor initializes on DOMContentLoaded inside content; templates load native delegated editor code in `js`; status AJAX also uses `js`. Preserve those contracts. Old unused selector views declare `scripts`, which neither parent generally yields; do not revive them by bulk migration. |
| Submit/feedback | Old master globally disables form buttons on submit and shows generic SweetAlert validation; V2 uses Toastr and does not have the same blanket submit handler. Keep inline errors, CSRF, confirmation and existing backend concurrency checks. Do not silently rely on removed shell behavior. |
| Modal/mobile | V2 supplies fixed sidebar/backdrop and modal z-index rules. Verify retained screen controls, dropdowns, focus, body scroll and touch behavior in the real shell, not a layout fixture. |
| Responsive proof | V2 hides page overflow globally; that can mask clipping. Test actual table/card widths, not only absence of a scrollbar. Drawer CSS uses max-width 992px while controls use Bootstrap `d-lg-none`; inspect the exact boundary in browser. This is a verification risk, not a newly reproduced bug. |

### Complete target inventory and sequence

The eventual target is the whole routed Admin Gradebook area, not only templates. Its active review bodies include `view_classes`, `view_rooms`, `view_subjects`, `view_by_subject_corrected`, `view_classes_student`, `view_rooms_student`, `view_students`, `view_by_student`, plus shared `gradebook/assessment_results`. Include `equivalence` and retained template index/show/preview/version screens. Do not confuse inactive `settings/edit`, `view_by_subject`, old select/edit views or old SQL models with routed functionality.

Recommended small releases:

1. Approve this workflow/visibility direction and freeze route/form/payload/source-ID/calculation contracts. Inventory all 29 current endpoints, including mutations, before changing any parent.
2. Introduce a Gradebook-only layout bridge to V2 and pilot home plus review-options, preserving links and controllers. Add explicit titles and scoped breadcrumb/card styling. Do not edit global V2 components.
3. Migrate the complete working distribution path: class, section, subject, JSON editor. Preserve input names, hidden IDs/sources, maxima retention, native JS and server responses. Verify old input/errors and the same saved payload on disposable fixtures.
4. Migrate both downstream review paths, exact-assessment partials, status action and equivalence UI. Preserve stored-year reads, exact term identities, legacy summary labels/values, locks, carry/conflicts and print. No automatic aggregation.
5. Migrate any retained template review/definition screens through the same bridge, consistent with approved visibility. Do not remove the existing draft or give publication an implied operational effect.
6. Accept the complete journey in a real authorized V2 session: Arabic/English, long labels, keyboard, 280/320/360/390/430/768/1024/desktop and short-height/landscape; status errors, validation, tabs, pagination, editor actions and stale-tab protection. Use isolated data/storage for mutation tests.

No SQL migration is required for this layout unification. Broader feature rollout must not be called complete after only pilot pages or child-view compilation.

## G. Phase 2B Disposition

**Retain backend; simplify/defer separate everyday UI, subject to owner approval.**

Preserve the three installed tables, unique constraints/FKs, all four triggers (`gb_version_update_immutable`, `gb_version_delete_immutable`, `gb_event_update_immutable`, `gb_event_delete_immutable`), current template 1/event, models, service, tests, translations and migration ledger. Never roll back a populated installation to reduce navigation clutter. Published snapshots and events remain immutable even if links are hidden.

The new capabilities are worth reusing behind a coherent editor after 2C approval. They do not justify making inactive drafting a required parallel operational task now. Keep direct authorized review access unless a separate product decision explicitly removes it. Hiding links is not an authorization mechanism and must not change Officer/Admin boundaries.

The earlier reported **109 tests / 1,837 assertions**, frontend harnesses and MariaDB concurrency checks remain useful prior implementation evidence. They do not prove the current draft has been published, that template application exists, or that the modern Admin shell was browser-accepted. No tests were run or new template records created in this audit.

## H. Phase 2C Impact

Unifying the UI does not remove the need for an explicit application/adoption contract. Before templates can drive grading:

1. Define immutable application identity/version pins for exact year, actual term, class, section and subject. Initially require one compatible subject/year distribution across sections/terms to preserve the two-argument reader contract, unless every contextual consumer has first been upgraded. Never choose arbitrary first/latest versions.
2. Preserve original legacy file bytes/hash, component IDs, numeric/string sources, order, percentages and explicit maxima as adoption evidence. The new template payload alone cannot encode all of them. A raw snapshot/import provenance structure and explicit source bindings are required; exact schema needs its own approval.
3. Map UUID components to validated original assessment systems/identities under exact context, including many occurrences per component. Component UUIDs and Phase 1 equivalence UUIDs have different purposes. No name-based matching, number recycling or retrospective inferred responsibility.
4. Establish one write authority per adopted context. Prevent old mutable JSON saves from bypassing versioned rules; do not claim a filesystem write and SQL transaction commit atomically. Legacy contexts remain operationally legacy until adoption succeeds.
5. Implement the approved compatibility policy with shadow comparisons of exact raw results, IDs, actual terms, averages/maxima, one-decimal rounding, totals, zero/null and original bounds. Preserve original result rows and historical decimal marks. Publication metadata is insufficient.
6. Freeze result-bearing structural changes under the approved policy; require a separately reviewed effective-version/impact process for any later change. Do not backdate an adoption as proof of an unavailable historical configuration.
7. Adapt Admin review/config, Advanced Teacher reads/writes, locks, aggregation/report mappings and Student Academic Record deliberately. Preserve timetable-authoritative assignments/current membership; a future application must grant no Teacher access. Retain historical placement/source scoping and protect readonly history.
8. Keep current class/actual-term OPEN/LOCKED semantics until a separately approved lock cutover. Do not make draft publication imply OPEN or retroactively lock ordinary legacy exams/quizzes.

Applications/source-binding/operational-state schema remains future additive work. This audit neither designs final tables nor authorizes 2C, imports, conversions, equivalence records, template application or school-data correction.

## I. Risks, Unknowns and Approval Gates

| Priority / issue | Evidence or uncertainty | Safeguard / required decision |
|---|---|---|
| High: two definitions mistaken for one | JSON is active; template publication is inactive | Approve A target/C interim and exact link visibility. Never imply publishing changes active grading. |
| High: percentage/max mismatch | Zero weights, explicit-max support, raw average/max calculations | D2 compatibility preserved; no automatic conversion or new weighting policy. School examples required before any policy change. |
| High: legacy source mismatch | `49_5` reserved ID maps to numeric 100 | Preserve bytes/mapping; fail reviewed adoption rather than normalize by ID/name. Do not run current writer as a historical converter. |
| High: historical configuration drift | JSON has no immutable revision history | Version future adopted contexts; retain original results. Do not invent what old maxima/config were. |
| High: ambiguous applications | 2B has no section/term applications; 2A reports unavailable | D1 exact-context contract and explicit source bindings before any cutover; no latest-version fallback. |
| High: earned-data structure change | Draft/immutable definition does not freeze active academic records | Respect D3 freeze; any correction/effective-version policy requires approval. |
| High: lock scope expansion | Existing Advanced dynamic entry class/term gate is not universal | Respect D4; no new legacy lock semantics in a visual task. |
| High: assessment identity confusion | Template component UUID != equivalence identity != original assessment ID | D8 explicit verified equivalence only; zero local mappings means genuine mapped browser QA remains unproven. |
| Medium: authorization drift | Existing routes + service guard; navigation may be less restrictive | Respect D5, preserve all existing server checks; no permission redesign through shell work. |
| Medium: numeric/final-result assumptions | Positive integer template maxima vs decimal old scores; final tab sums term summaries with >=50 badges | Respect D6/D7. Neither redesign nor templates certify a new final/promotion policy. No clipping or rounding old raw marks. |
| Medium: actual-term ambiguity | Year 5 has repeated term types; current year has only one actual term | Preserve all IDs/occurrences and representative-summary distinction. Never invent second-term data. |
| Medium: current-year ambiguity | Legacy settings uses first flagged year; template default requires exactly one | Current data is unambiguous. Do not silently harmonize behavior in layout work; report unresolved context when appropriate in later contract work. |
| Medium: legacy SQL ledger debt | Config/component ledger entries exist, tables do not | Avoid inactive ORM/view paths; separate approved investigation, no destructive schema repair. |
| Medium: old year identifiers/names | Duplicate year labels and nonstandard/test-labelled records exist | Validate real foreign keys and chronology; no inferred merge/order/adoption from labels or numeric IDs alone. |
| Medium: full-shell regression | Wrong previous reference; child fixture is not V2 browser proof | Real V2/browser acceptance and bounded asset/script migration; no all-plugin import. |
| Medium: performance | Config discovery checks file existence per subject; shared summaries loop terms/students/components/assessments | No fresh latency/load benchmark performed. Keep pagination and batched template lookup; do not call detail readers per navigation row or add N+1 version probes. Optimize only measured bottlenecks separately. |
| Medium: existing draft | One real local parent/event now exists | Preserve and provide reviewed access; ask before treating it as a test artifact. |

D1-D8 remain the previous approved decision boundaries: application granularity, unchanged calculation policy, used-context editing rules, existing lock scope, authorized publishing/application, precision/state preservation, actual-term/final-result semantics and explicit continuity. This audit requests no reversal and makes no new academic-policy decision.

Remaining owner approvals, in order: (1) A target/C interim and whether template links become non-everyday review access; (2) bounded V2 migration scope and acceptance; (3) later source-binding/adoption and single-writer contract; (4) any genuinely new grading/library/approval policy. Items 3-4 do not block a strictly presentation-only shell pilot; they do block operational template cutover.

Unknowns remain actual authenticated rendering, browser console/network/plugin interactions, viewport behavior, school demand for reusable cross-subject libraries, complete original historical policy evidence and hosting parity. No current browser acceptance, performance certification or production GO is claimed.

## J. Proposed Next Codex Task

**After owner approval: V2 shell pilot for Gradebook home and review-options only.**

Create a narrowly scoped Gradebook layout adapter extending `admin.layouts.v2`, then integrate only `admin/gradebook/index.blade.php` and `view_options.blade.php`. Reuse the real sidebar/navbar/page-header, set accurate page titles and scoped responsive breadcrumbs/cards, and preserve every existing route/link/permission. Keep all editor/template visibility decisions outside this pilot unless explicitly approved. Record the remaining routes as migration backlog so two pilot pages are not mistaken for complete unification.

Acceptance: actual authorized browser journey from `/SMT/admin/index` through Gradebook home/options and back; correct active menu; no legacy topbar/footer; RTL/LTR, keyboard and representative mobile/desktop checks; no added duplicate assets, changed controllers, JSON/status/database writes or calculation changes. Tests must use the real V2 layout where safe, not only a substituted child-view shell. If browser access is absent, state the gate as pending rather than complete.

No migration, new frontend package, 2C schema/application work or operational editor replacement belongs in that task. It is proposed here, **not executed**.

## Close-Out

The immediate problem is not lack of another editor. It is two differently scoped definitions presented as competing everyday actions, inside the wrong Admin shell. Preserve the working distribution and the safe Phase 2B backend; converge on one workflow and migrate the Gradebook to the actual V2 shell in small, verifiable steps. Do not activate templates until their application/source-binding compatibility is proven.

This pass issued no school-data writes, DDL, migration/cache/test commands, template mutations, reconciliation, commit, push or deployment. Application files, existing reports and unfinished work were not intentionally changed. `.env.example` remains untouched. Only this planning report is added.
