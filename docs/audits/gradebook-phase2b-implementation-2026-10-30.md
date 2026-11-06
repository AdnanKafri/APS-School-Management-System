# Advanced Gradebook Phase 2B implementation

Date: 2026-10-30, Asia/Damascus. PHP 7.4.33 / Laravel 7.30.6.

## A. Verdict

**PHASE 2B IMPLEMENTED — ACCEPTANCE PENDING**

The draft/version/publishing foundation is implemented and verified with isolated HTTP/controller tests, existing reader regressions, frontend harnesses and real MariaDB 10.4.32 concurrency tests. The new migration has **not** been applied to the school database. Authenticated acceptance in the real Admin shell and school installation remain pending. No subsequent phase is started.

Publishing a template creates an inactive definition. It does not apply it to students, sections, terms or existing Gradebooks.

## B. Architecture and contract

| Entity | Responsibility |
|---|---|
| `gradebook_templates` | Stable UUID, immutable year/lesson/class/creator ownership, editable draft JSON, optimistic draft revision, source version number and last published number. One parent per lesson/year. |
| `gradebook_template_versions` | Complete immutable snapshot: scope IDs and display names, ordered component definitions, positive integer maxima, definition policy, draft revision, base version, publisher, timestamp, SHA-256 content identity and reviewed-preview token. |
| `gradebook_events` | Append-only administrative evidence, actor, template/version, action, timestamp and change metadata. Discard records its required reason and discarded definition. |

The initial scope follows the verified legacy lesson/year configuration contract. `lessons.class_id` supplies the class; lessons themselves do not have a year relationship. The selected year is explicit ownership, not an inferred lesson-year FK. Foreign keys use the inspected signed `int` year/lesson/class IDs and unsigned `bigint` user IDs. There are no term/section application rows.

Drafts live on the parent rather than in a fourth table. A saved component gets a server-generated UUID v4. Rename and reorder preserve that ID. Added components get new IDs; removed components remain in published snapshots and change evidence. Duplicating a published definition into another lesson/year allocates independent component IDs. No legacy assessment IDs, labels or source codes are inferred from component names.

`GradebookTemplateService` authorizes type-2 Admins with the existing `student_marks` ability. All ten added routes also retain `auth`, `roleadmin` and `can:student_marks`; the existing type-2 Gate semantics are unchanged. The server supplies actor identity. Form inputs cannot change ownership. Guest, Teacher, Student, Officer and other non-Admin accounts cannot manage templates.

Save/discard/start/publish take the parent row lock and require the submitted draft revision. Stale edits fail rather than overwrite a newer draft. Publication revalidates the definition and an HMAC token bound to scope, snapshot, revision and prior version. It requires explicit confirmation. Publication, parent update and audit event commit in one transaction. A retry of the same reviewed revision/token returns the original version without another event, including when another draft already exists.

Unique `(template_id, number)` and `(template_id, draft_revision)` indexes reinforce publication concurrency. Model guards and four database triggers reject updates/deletes of published versions and events. Foreign keys restrict deletion of referenced parents/actors/context. Templates have no delete endpoint; discarding only closes the draft. The service checks all three tables and four trigger names before enabling operations, so interrupted trigger installation fails closed.

The snapshot's `content_hash` is SHA-256 of canonical service JSON (`JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES`), not of database-driver formatting of the LONGTEXT value. `calculation_policy=legacy_read_v1_unchanged` is metadata only: no calculation engine consumes template components in this phase.

## C. Files and migration

New application files:

- `app/GradebookTemplate.php`
- `app/GradebookTemplateVersion.php`
- `app/GradebookEvent.php`
- `app/Services/Gradebook/GradebookTemplateService.php`
- `app/Http/Controllers/Admin/GradebookTemplateController.php`
- `database/migrations/2026_10_29_000001_create_gradebook_template_foundation.php`
- `resources/lang/ar/gradebook_templates.php`
- `resources/lang/en/gradebook_templates.php`
- `public/assets/admin/js/gradebook-template-editor.js`
- `resources/views/admin/gradebook/templates/index.blade.php`
- `resources/views/admin/gradebook/templates/show.blade.php`
- `resources/views/admin/gradebook/templates/preview.blade.php`
- `resources/views/admin/gradebook/templates/version.blade.php`
- `resources/views/admin/gradebook/templates/scope.blade.php`
- `resources/views/admin/gradebook/templates/component.blade.php`
- `resources/views/admin/gradebook/templates/definition.blade.php`
- `resources/views/admin/gradebook/templates/notice.blade.php`

Modified application files: `routes/gradebook.php` adds the bounded routes; `resources/views/admin/gradebook/index.blade.php` adds the templates link. Existing settings, result writers, contextual reader and calculators are unchanged.

New verification files:

- `tests/Concerns/GradebookTemplateFixtures.php`
- `tests/Feature/GradebookTemplatesTest.php`
- `tests/Frontend/gradebook-template-editor.test.js`
- `tests/Integration/gradebook-templates-mariadb.php`

`tests/Feature/GradebookSafetyTest.php` updates its protected-route inventory from 19 to 29 and extends the existing three-consumer agreement test with an actual inactive template publication. This preserves the earlier 2A test work. Earlier uncommitted 2A classes, test harness changes, tests and reports remain present; they are not new 2B changes. `.env.example` is unchanged, with SHA-256 `B0D5B8682611895575C397B594689940097F1E0332054A754926129DD1D958CF`.

This report is the only documentation added in this continuation.

### Installation boundaries

The migration was exercised only against SQLite in memory and newly created disposable MariaDB databases. It was not applied to `aladham_oct`; Phase 1's migration and equivalence records were not changed.

The migration rejects pre-existing target tables rather than guessing how to reconcile them. On MariaDB it checks source engine/ID compatibility before DDL. Hosting must permit CREATE TABLE, foreign keys and CREATE TRIGGER. MySQL/MariaDB DDL is not atomic: a failed installation must be inspected and completed under a reviewed recovery plan; do not blindly rerun or drop partially installed tables. The runtime capability check prevents publishing with missing triggers. Unsupported database drivers fail before table creation.

Empty rollback/reinstall is tested. Rollback with any template/version/event rows refuses to destroy history, including unpublished drafts. A populated installation requires a separately approved preservation plan rather than `migrate:rollback`.

## D. Admin workflow

1. After reviewed schema installation, open Admin Gradebook and select **قوالب التقييم**. Direct route: `/SMT/admin/gradebook/templates`.
2. Select academic year and material/class, enter an Arabic template name and create the draft. An existing lesson/year scope must be reopened rather than duplicated.
3. Add Arabic component names, optional English names and positive integer maxima. Reorder or remove components and save. The editor is bounded to 100 components and uses no additional plugin.
4. Open **مراجعة المعاينة البنيوية** after saving. Review scope, order, maxima, unrestricted total maximum and added/removed/renamed/maximum/reorder differences from the latest published version.
5. Confirm the publication-only checkbox and select **نشر إصدار ثابت**. The resulting immutable version is readable independently of subsequent drafts.
6. Start a new draft from any published version, or start empty after a draft closes. Discard requires a reason. A published version can be copied to another available lesson/year scope.

The preview prominently explains that this is structural review only and that publishing changes neither student marks nor active Gradebook configurations. It makes no mark-impact claims. Arabic/English strings are localized; Arabic pages follow the existing RTL Admin shell with responsive form rows, wrapped action buttons and contained table scrolling. Full V2 styling remains deferred.

## E. Data preservation and compatibility

No 2B code writes existing result/mark/report/financial/placement/assignment tables, Gradebook JSON/status files, assessment-equivalence mappings or locks. Templates are not read by `getConfig(lessonId, yearId)`, `GradebookStatusService`, `GradebookReadService` or existing Teacher result-entry flows. The 2A contextual reader continues to reject versioned application requests as unavailable; a published definition alone does not establish an application backend.

The isolated agreement test renders actual Admin grid, Advanced Teacher grid and Student Academic Record child views before and after a 999-point template publication. HTML, result arrays, assessment keys, actual term IDs, zero/null handling, original result IDs and stored result rows remain identical. Separate sentinel tests verify existing result/equivalence rows and configuration/status file bytes remain unchanged during publication.

The school database connection dropped during a SELECT-only full fingerprint attempt and subsequent connections to port 3306 were refused. No repair, server restart, school DDL or school write was attempted. Therefore a completed before/after school-table fingerprint is **not claimed**. The earlier activation report remains prior evidence only. The successful real-MariaDB tests below used a fresh data directory and separate port, with no school data imported.

## F. Verification results

| Verification | Result |
|---|---|
| Focused PHP suite: GradebookSafetyTest, TimetableAuthorityTest, TeacherStudentFollowUpEligibilityTest, GradebookContextReaderTest, AdminTeacherTimetableViewTest, GradebookTemplatesTest | **104 tests / 1,766 assertions PASS** |
| New template HTTP/service suite | **13 tests / 136 assertions PASS**; included in the 104 total, not additional |
| Real MariaDB integration | **28 assertions PASS**, MariaDB **10.4.32**, fixture database `aladham_gbt_test_540e7cbcd619ce53` |
| Frontend | Template editor, existing save, status and continuity harnesses all PASS; JavaScript syntax check PASS |
| PHP 7.4 lint | All 13 new/modified 2B PHP files PASS |
| Blade | All **30 Admin Gradebook views** compile and lint in temporary storage; actual child views also render in HTTP/controller tests |
| Encoding | 24 touched application/test/view files checked as UTF-8 without BOM; no obvious mojibake patterns found in new localized content |
| Whitespace | `git diff --check` PASS; only existing LF/CRLF informational warnings |

Coverage includes authorized HTTP create/edit/preview/publish/read; service and route-boundary denial; CSRF; forged actor/scope/component inputs; cross-template version rejection; zero/negative/decimal/scientific/overflow/malformed maxima; duplicate IDs; stable identity across rename/reorder; additions/removals; V1/V2 immutability; stale saves/previews; idempotent publication; discarded payload/reason evidence; independent duplicate identities; transactional audit failure; direct model/query-builder mutation rejection; schema absence/incompleteness; empty migration rollback/reinstall and populated rollback preservation.

The protected-route inventory tests all **29** current Admin Gradebook endpoints for existing middleware and direct non-Admin denial. Existing assessment continuity, timetable authority, membership, legacy result preservation and contextual-reader regressions pass.

### MariaDB concurrency evidence

A newly initialized local MariaDB 10.4.32 data directory was used at port **33317**, distinct from the school's port 3306. The runner refuses a non-local connection, existing fixture database, non-matching fixture name or effective connection outside its new `aladham_gbt_test_<16 hex>` database. Workers independently verify the recorded database/storage/project identity.

For each race the parent holds a real `FOR UPDATE` lock on the template. Two worker processes reach a barrier; both pending `FOR UPDATE` requests are observed in PROCESSLIST before releasing that lock, with neither result file yet present. Concurrent publication produces one V1 and one publish event, returning the same version to both callers. Concurrent save accepts one update and rejects the stale request. A later publication creates V2 while V1's stored snapshot stays unchanged.

The runner also exercises real MariaDB immutability triggers, uniqueness/FK rejection, failed-audit transaction rollback and populated rollback refusal. It does not substitute SQLite locking for MariaDB evidence. PROCESSLIST evidence is retained in `publish.locks.json` and `save.locks.json`; no claim relies on INNODB_LOCK_WAITS reporting.

Successful artifacts: `C:\Users\Lenovo\AppData\Local\Temp\aladham-gbt-mariadb-16685efa4115b1fa78dab6bffd29a671\result.json` and adjacent worker/lock evidence. The temporary server data directory is `C:\Users\Lenovo\AppData\Local\Temp\aladham-gbt-server-0cc49017e4984747bab6aa743e85c651`. Only synthetic users, academic scope and template records were created. Earlier fixture attempts are also retained. After verifying its process command/data-directory identity, the temporary server was shut down cleanly through mysqladmin on port 33317. Its data directory remains available. No cleanup deletes or school-data restoration was performed.

Reproduce the integration test against an available local server using:

```powershell
C:\php74\php.exe tests/Integration/gradebook-templates-mariadb.php --create-isolated-database
```

For a separately initialized temporary server on another port, set `ALADHAM_GBT_ISOLATED_PORT` only in that test process. This intentionally uses a fresh local root account with an empty password and must point only to that disposable server. It never edits `.env`. The default runner uses the local `.env` connection to create a unique fixture database; it never reuses the school database. Each run gets a new database, so its recovery is recreation from fixtures rather than restoring school data.

The PHPUnit run uses SQLite `:memory:`, the installed PHP SQLite extensions and an opt-in `ALADHAM_TEST_STORAGE` directory matching the existing `aladham-gradebook-2a-<32 hex>` guard. Set `VIEW_COMPILED_PATH` to that temporary root's `framework/views`; cache/session drivers remain array. School configuration/status files and project view caches are not used for fixture writes.

### Acceptance still pending

- Reviewed activation of only the new migration against the intended school environment, including source FK types, trigger permissions and backup/recovery review.
- Authenticated browser create/save/preview/publish/V2/discard/duplicate flows through the real Admin shell; desktop/mobile/RTL visual acceptance and browser console/network checks.
- A fresh completed school-table preservation fingerprint once the local school MariaDB service is available. Automated preservation evidence above is isolated, not a substitute for that live check.
- Production hosting schema, permissions, load and deployment acceptance. No production action occurred.

## G. Deferred boundaries

Phase 2C must define explicit actual-term/class/section applications, contextual resolution, legacy adoption/bindings and single-authority activation before templates can affect Gradebooks. Existing configuration ID/source mismatches must remain exact evidence, not be normalized by name.

Phase 2D owns the full Admin V2 experience and whole-chain visual/browser acceptance. Phase 2E owns managed Teacher entry and forward provenance after application adoption. Mark-impact execution/restoration and result publication require their separately approved workflows; none is inferred from template publication here. No weighting, annual formula, pass/fail rule, historical correction or new Teacher authority has been introduced.

## H. Next step

Complete the narrow local schema/browser acceptance gate for 2B after the school's MariaDB connection is restored. Review this implementation and its immutable snapshots before approving 2C application design. Do not automatically apply published definitions or adopt old assessments.

No commit, push or deployment was performed. Student identity, academic records, finance, timetable synchronization and existing working-tree changes remain outside this implementation's mutation paths.
