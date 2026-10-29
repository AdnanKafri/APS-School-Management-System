# Advanced Admin Gradebook: mandatory Template/UI phase plan

Date: 2026-10-23. Source: current routes, controllers and rendered views, including uncommitted Phase 0A and Phase 0B. This is an implementation specification, not a claim of completed visual redesign.

## Commitment and boundaries

The next **Admin Template System/UI phase MUST include the landing page and every internal screen below**. It is not an optional landing-page polish task. Release acceptance must cover the whole navigation chain, configuration, locks, errors and read-only results. No new independent result store, automatic carry-forward, weighting or publication policy is authorized by this plan.

Phase 0B corrects functional defects now. Full layout migration is deliberately left for one cohesive implementation rather than mixing two shells page by page indefinitely. Existing URLs, authorization and authoritative result readers remain contracts.

## Existing Admin design to reuse

The active Students page (`admin/student.blade.php`) and Follow-up landing/report pages use `admin.layouts.v2`; **all 14 active Gradebook GET views currently extend `admin.master`**, the older shell. This is a real reason Gradebook looks disconnected from the current Admin dashboard.

| Existing source | Reuse in the next phase |
| --- | --- |
| `resources/views/admin/layouts/v2.blade.php` | Cairo typography; shared sidebar/navbar; Bootstrap/jQuery dependencies; `--v2-*` tokens; current RTL/LTR and modal infrastructure. Do not import the old shell's duplicate plugin bundles. |
| `admin/components/page-header.blade.php` | `page_title`, `page_subtitle`, breadcrumbs; one page header, not an extra nested colored banner. |
| `admin/components/sidebar.blade.php`, `navbar.blade.php` | Existing Gradebook link and `admin.gradebook.*` active state; keep permission checks server-side and use existing navigation conventions. |
| `admin/student.blade.php` | Bordered, aligned search/filter toolbar; separated primary action; contained table scrolling; clear modal footer, errors and responsive stacking. Reuse patterns, not its student-specific code or broad CSS overrides. |
| `admin/student_follow_ups/index.blade.php`, `_styles.blade.php`, report screens | Context strip, `v2-card`, scoped feature styles, summary tiles and drill-down navigation. No copying follow-up business logic. |
| Existing V2 notifications and Bootstrap forms | Inline field errors plus alert summary; visible pending/success/error feedback. Do not rely on a toast alone. |

Actual tokens: primary `#5B4B8A`, accent `#1f9d6b`, background `#f6f7fa`, white surface, text `#2f2b3a`, muted `#8a869a`, border `#e9e8ef`. Preserve these rather than introducing a new palette/font system. Scope new feature CSS under one Gradebook root; avoid global `th`, `td`, `.row`, `.modal-header` rules.

## Complete active route/view inventory and acceptance criteria

Prefix below: `/SMT/admin/gradebook`. `GC` = `Admin\GradebookController`, `SC` = `Admin\GradebookSettingsController`. View paths are relative to `resources/views/admin/gradebook/`.

| # | Method/path; controller | Current view; confirmed weakness | Required redesign and screen acceptance |
| --- | --- | --- | --- |
| 1 | GET `/`; GC@index | `index.blade.php`; large nested colored cards, excessive padding, no clear academic context | V2 header and year/term strip. Two concise branches: review marks and configure distribution. Missing-year warning remains visible. Both links work by keyboard/mobile. |
| 2 | GET `/view/options`; GC@viewOptions | `view_options.blade.php`; another full-screen menu with inconsistent colors | Compact subject/student choice in shared review shell. Preserve direct route and breadcrumbs even if combined visually with the landing. No dead edit/disabled affordance. |
| 3 | GET `/view/subject/classes`; GC@viewClassesSubject | `view_classes.blade.php`; global table styles, large type, mixed English pagination text | Reusable class selector with current year, search when needed, accurate pagination and empty state. Correct subject-mode destinations. |
| 4 | GET `/view/subject/rooms/{classId}`; GC@viewRooms | `view_rooms.blade.php`; margin-heavy table, inaccurate all-room pagination count | Reusable section selector, chosen class/year pinned; only active-year sections. Count derives from this paginator. No section is a clear empty state, not a blank table. |
| 5 | GET `/view/subject/subjects/{roomId}`; GC@viewSubjects | `view_subjects.blade.php`; unlabeled-looking lock switch, oversized global cells | Subject selector with class/section/year context. Place lock control in a distinct administration area, visibly explain class + current-term scope, not subject-only scope. Confirm/cancel/failure must reflect persisted state. Historical room has no operational lock toggle. |
| 6 | GET `/view/subject/grid?room_id&subject_id`; GC@viewGridSimple | `view_by_subject_corrected.blade.php`; dense tabs, fixed-width student cells, mixed legacy/config maxima, simplistic final labels | Read-only subject grid plus original-assessment panel. Year/term/room/subject visible. Term summaries explicitly distinguished from raw assessments. Zero differs from missing. Dynamic and legacy results are traceable to original identity. Print hides navigation and labels context. Policy-dependent final labels require school sign-off, not a cosmetic formula change. |
| 7 | GET `/view/student/classes`; GC@viewClassesStudent | `view_classes_student.blade.php`; duplicates class screen | Share selector component with #3; keep student-mode links. Same empty/search/pagination/accessibility criteria. |
| 8 | GET `/view/student/rooms/{classId}`; GC@viewRoomsStudent | `view_rooms_student.blade.php`; duplicates section screen | Share #4 with student-mode destination, keep context and back navigation. |
| 9 | GET `/view/student/students/{roomId}`; GC@viewStudents | `view_students.blade.php`; long unpaginated roster, heavy margins, no useful empty state | Searchable current-membership list with clear student names, section and read-only card action. Preserve current resolver; never recover transferred-out students by broadening the roster query. One coherent search/pagination implementation. |
| 10 | GET `/view/student/card?student_id`; GC@viewStudentCard | `view_by_student.blade.php`; fixed legacy columns and visually disconnected raw panels | Student context header from resolved room/year. Subject cards/table with legacy and configured components, missing/zero distinction, term totals and original records. Phase 0B supplies missing context and additional-component detail. A no-placement/no-subject state must not imply a zero or failure. |
| 11 | GET `/settings`; SC@index | `settings/index.blade.php`; old shell, table without consistent responsive wrapper | Configuration class selector; active-year counts (fixed in 0B), year badge, no misleading historical counts. Clarify settings are shared by lesson/year. |
| 12 | GET `/settings/rooms/{classId}`; SC@viewRooms | `settings/rooms.blade.php`; raw IDs emphasized, student relation count may not equal operational roster | Same section selector as #4/#8. Use authoritative membership if showing operational counts; remove an irrelevant count instead of relabeling a legacy count. No result mutation. |
| 13 | GET `/settings/subjects/{roomId}`; SC@viewSubjects | `settings/subjects.blade.php`; previously always default and read teacher from assessment relation | Phase 0B fixes saved-file state and exact assigned Teachers. Next phase shows applied template/version/default state from real storage, not invented DB config. Explain all sections sharing a lesson/year are affected. Reject old-room configuration links. |
| 14 | GET `/settings/edit/{subjectId}`; SC@edit | `settings/edit_json.blade.php`; percentage-only grid, fixed widths, weak deletion affordance | Cohesive component editor; stable identities, read-only source mapping, names, ordered rows, existing maximum semantics. Show scope and preview, protect used components, preserve old input and display errors. The total-progress indicator is not permission to impose 100% weighting on legacy averages. |
| 15 | POST `/settings/update/{subjectId}`; SC@update | Returns to editor, no separate view | Disabled duplicate submit, pending state, inline errors, preserve attempted input; only show success after persistence. Preserve explicit maxima and reserved mappings. Future versioned edit requires conflict detection and impact preview. |
| 16 | POST `/aggregate`; `Admin\GradebookAggregationController@aggregateContext` | Redirect/flash; **no active Blade caller found** | Do not add an innocently labeled refresh button that writes reports. If exposed, use a distinct authorized action showing context, affected summaries, lock checks and explicit confirmation. Preview versus write must be unmistakable. Recalculation/publication policy approval required before expanding behavior. |
| 17 | POST `/gradebook/status` (outside prefix); GC@toggleStatus | AJAX from #5 | CSRF retained; local pending/error text, no double request while pending, cancellation/failure restores accepted state. Persisted success only. Class/term label and active-year server check remain. |

All 17 remain under `auth`, `roleadmin`, `can:student_marks`; the existing Admin Gate override is unchanged. No new route or permission was introduced in Phase 0B.

### Legacy files are not active screens

Seven additional Gradebook Blade files exist without current controller `view()` callers:

- `edit_select_class.blade.php`
- `edit_select_subject.blade.php`
- `edit_subject_settings.blade.php`
- `view_by_subject.blade.php`
- `view_select_student.blade.php`
- `view_select_subject.blade.php`
- `settings/edit.blade.php`

Route-name compatibility aliases in `AppServiceProvider` and `roleadmin` point at current routes, not these templates. Do not redesign an inactive file and claim the live screen changed. Do not delete them during the UI phase without a separate reference check. Shared `resources/views/gradebook/assessment_results.blade.php` is active in both Admin and Teacher and must receive compatible, scoped styling.

## Information architecture and screen groups

**Context first, results second, administrative writes separate.** Keep a persistent year/class/section/subject or student context strip. Current operational navigation uses the active year; a historical view clearly labels its stored context and is read-only. Never switch global year from Gradebook browsing.

Landing: V2 header; academic-context strip; review branch (subject/student); configure branch; short explanation of raw results versus legacy report summaries. No fabricated analytics tiles.

Subject review: concise header and print action, term navigation, read-only component summary, original assessment names/types/maxima/dates, review warnings for ambiguous legacy data. The complete raw assessment list must not be reduced to one quiz/exam per term. A summary may retain current representative-term semantics until school approves combining duplicate term definitions.

Student review: identity/context at top; subject summaries with all contributing components; original assessment sections grouped by term and subject. Historical transitions, when implemented, are separate panels, not silently merged into current totals.

Configuration/template editor: subject/year scope and all affected sections, default/custom/version state, source/category explanations, stable IDs hidden from normal staff, maximum and weight meanings explicit. New reusable template versions must be draftable, validated, previewed and explicitly applied. A used version is not retroactively overwritten. Do not build a second grade store. Template reuse does not establish equivalence between assessments.

## Functional fixes already made in Phase 0B

- Settings validation now displays errors and retains submitted rows; table hidden fields live inside cells and sparse indexes are normalized for safe add-row indexing.
- Explicit stored maxima survive settings round trips; browser-supplied maxima cannot overwrite them through this editor.
- Configuration overview reflects saved files, exact current assignment and active-year section counts.
- No-year selectors/editing return to the landing with a clear warning rather than dereferencing null or redirecting back unpredictably.
- Lock control restores prior state on cancel/error and reports pending/failure instead of silently looking unlocked.
- Student card displays resolved class/section/year and configured additional components contributing to totals.

## Responsive, RTL and accessibility contract

- Test 280, 320, 360, 375, 390, 430, 768, 1024 and desktop widths, portrait and short landscape heights, long Arabic names and many components. These are acceptance requirements, not completed browser measurements.
- Header and filters wrap/stack using V2 spacing; controls retain visible labels and focus. Primary actions remain reachable without page-level horizontal scroll.
- Dense assessment matrices use a deliberate focusable internal scroll region, caption/context, sticky header/student column with RTL logical positions. Do not collapse a matrix into misleading column-less cards. Mobile can offer focused read-only subject/student panels while keeping the raw matrix available.
- Summary cards must not exceed their container. Print output repeats context and headers. No cut-off values or false clipped zeros.
- Lock actions, tabs and component buttons work with keyboard; visible text accompanies state colors/icons. Errors use a summary and field links; save states use live regions without stealing focus.
- Direction is inherited from locale; numeric scores/dates can use local LTR spans, not flip the whole table. Use Arabic labels including شعبة/الشعب. Preserve all source files as UTF-8 without BOM.
- Do not duplicate sidebar controls, Bootstrap versions, DataTables search inputs or global CSS. Check `document.documentElement.scrollWidth <= document.documentElement.clientWidth` on every screen; internal table scrolling is allowed.

## Mandatory implementation sequence and estimate

1. **Foundation and selector group (screens 1-5, 7-9, 11-13):** migrate to V2 shell together; reusable context, header, selector, empty/error components; preserve routes. Approximately 2-3 focused implementation days plus QA, subject to actual plugin conflicts.
2. **Review group (6 and 10, shared assessment partial):** coherent summaries/raw results, print and responsive matrices, additional-component explanation and historical-context labeling. Approximately 2-3 days plus QA. No formula changes disguised as presentation.
3. **Template/configuration group (14-15):** version-aware template/editor design and backend contract in the approved Template System phase. Existing file-based configuration is an adapter during rollout. Approximately 3-5 days for UI integration after backend/version/policy decisions; backend template architecture is a separate estimate.
4. **Protected operational actions (16-17):** status confirmation, preview/error states; aggregation remains non-exposed until its report semantics and appropriate staff operation are approved. Approximately 1 day plus security tests.
5. **Full-chain release gate:** all 14 GET screens and 3 POST actions, Admin/Teacher parity, unauthorized/locked cases, all viewport sizes, keyboard and Arabic checks, actual staging browser screenshots. Approximately 1-2 days, not a substitute for school acceptance.

These are planning ranges, not a delivery promise. No screen in the inventory can be omitted from the next phase's acceptance matrix. Unresolved policy-dependent badges, weighting, carry-forward, publication and report synchronization must be explicitly decided or labeled non-final; they must not be guessed by the UI implementer.
