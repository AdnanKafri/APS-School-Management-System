# Phase 2B local acceptance gate

Date: 2026-10-30, Asia/Damascus.

**SCHEMA ACCEPTED — BROWSER PENDING**

The Phase 2B schema is now installed and verified on the intended local school database. Authenticated Admin browser acceptance has not been performed. This report does not supersede that acceptance requirement or authorize Phase 2C implementation.

## Gate A: local MariaDB

- Independently checked the existing Phase 1, 2A and 2B reports against the current runtime.
- MariaDB was already running: PID **14420**, executable `C:/xampp/mysql/bin/mysqld.exe`, command `--defaults-file="c:/xampp/mysql/bin/my.ini" --standalone`.
- The only MySQL/MariaDB process and port-3306 listener matched that executable. The listener was on `::`, including the expected local IPv4 connection. No competing database service/process was identified.
- Direct PDO and bootstrapped Laravel agree: **mysql, 127.0.0.1:3306, aladham_oct**, server **DESKTOP-TBR5S6P**, MariaDB **10.4.32**, data directory `C:/xampp/mysql/data`.
- Laravel environment is local. No cached configuration, database URL override or socket override was used. The effective account has global privileges including CREATE TRIGGER.
- The school database was readable: **163 InnoDB base tables** before activation. No other client database sessions were present during preflight or the final migration guard.
- No restart, service change, configuration edit, data-directory initialization or restoration was needed or performed. The previous connection refusal is no longer occurring. Its historical cause cannot be established from the inspected log; missing-tablespace warnings reference the unrelated `voltronix` database and were not treated as proof of school-database corruption or repaired.

## Gate B: fresh backup and preflight

Phase 1 remains applied: ledger ID **52**, batch **24**; `assessment_equivalence_members` exists and has **0 rows**. The only pending filesystem migration was `2026_10_29_000001_create_gradebook_template_foundation`. None of its three tables or four triggers existed. There was no partial Phase 2B installation.

All source tables are InnoDB. Verified FK IDs: `years`, `lessons`, `classes` use signed `int(11)`; `users.id` uses unsigned `bigint(20)`. No unrelated historical ledger discrepancy was repaired.

Fresh evidence and confidential backup are outside the repository/web root:

`C:/Users/Lenovo/.codex/backups/gradebook-phase2b-acceptance-3e22ab8700a94771a74cf10cf189324a`

- ACL inheritance disabled; access restricted to the current Windows user. The SQL backup's inherited ACL was also checked.
- `aladham_oct-before.sql`: **66,983,744 bytes**.
- SHA-256: **ebbafcd14adab39aae5333939c53e59b9d6cf6e01fc7c46de70fc3275fb52718**.
- Matching MariaDB 10.4.32 mysqldump used single-transaction/quick, routines, events, triggers, hex blobs and UTF-8. Exit **0**, stderr **0 bytes**. Verified all **163** table definitions, readable content and dump completion marker.
- Credentials were supplied through a private temporary client-options file, never through command-line passwords or report output. That options file was removed afterward.
- `RECOVERY.md` was written before activation. It requires stopping on partial DDL, preserving evidence, reviewing the new tables/triggers/ledger, and restoring only into a separately approved recovery database if recovery is later authorized. No blind retries, destructive rollback or import over newer school data.
- Backup verification did not include a restore drill. The dump contains DROP TABLE statements and must not be imported into the working database as a routine rollback.

`all-tables-before.json` covers **163 tables / 326,258 rows**, with exact counts, SHOW CREATE TABLE hashes and deterministic sorted full-row hashes. It also captures all migration rows, six Gradebook configuration/status files, `.env.example`, the three existing Gradebook service files and the target migration hash.

## Gate C: controlled activation

The guarded file-based runner rechecked effective connection, server/data directory, source migration SHA-256, fresh backup SHA-256, ledger, pending set, absence of target tables/triggers and absence of other client sessions. It then called only:

```php
Artisan::call('migrate', [
    '--path' => 'database/migrations/2026_10_29_000001_create_gradebook_template_foundation.php',
    '--no-interaction' => true,
]);
```

Laravel returned **0**, recording successful migration in **0.89 seconds**. There was one actual migration execution. A preliminary verification helper rejected PDO/Laravel numeric representation differences before any DDL; its scalar comparison was corrected in the private helper. No ledger or application change was used to bypass that check.

Verified afterward:

- Ledger entry **53**, batch **25**, exact migration name. All **51** prior ledger rows remain unchanged.
- **166** base tables, exactly three added: `gradebook_templates`, `gradebook_template_versions`, `gradebook_events`. All are InnoDB and **empty**.
- Primary keys, template UUID uniqueness, lesson/year scope uniqueness, version-number uniqueness and draft-revision uniqueness match the migration.
- All **9** foreign keys have the expected source/target columns and RESTRICT update/delete behavior.
- Four BEFORE triggers exist with the expected UPDATE/DELETE target and SQLSTATE 45000 immutability statement:
  `gb_version_update_immutable`, `gb_version_delete_immutable`, `gb_event_update_immutable`, `gb_event_delete_immutable`.
- Real `GradebookTemplateService::available()` returns **true**.
- A separate read-only `migrate:status --path=<target>` call exits **0** and shows **Yes / batch 25**.
- No unrelated schema change, seed, broad migration, manual ledger edit or rollback occurred. No test template record was created in the school database.

## School-data preservation

All **162 original non-ledger tables** retain identical schema hashes, row counts and complete deterministic data hashes. The migration ledger differs only by its one expected new row. Existing assessment-equivalence mappings, academic context, timetable assignments, membership, locks, marks, results, reports, files and financial records were not modified.

Representative unchanged counts:

| Table | Before | After |
|---|---:|---:|
| students | 1,201 | 1,201 |
| exams2 | 2,255 | 2,255 |
| exam_result2 | 27,318 | 27,318 |
| students_marks | 2,262 | 2,262 |
| report_cards | 1,903 | 1,903 |
| invoices | 3,255 | 3,255 |
| assessment_equivalence_members | 0 | 0 |

All **11** captured files remain byte-identical, including every existing JSON configuration/status file and `.env.example`. Calculators and configuration/status readers were not edited. Published templates remain inactive definitions; no applications, assessment adoption, bindings, invalidation, restoration or calculation changes were introduced.

After regression and anonymous runtime checks, a final complete school snapshot is byte-identical to the immediate post-activation snapshot: SHA-256 **dffc8a7d7a6d4b6ebad0124daacdc2d39528a9370ed8e5a2e0e975ce29d380b4**. Final total: **166 tables / 326,259 rows**, with the additional row solely in the migration ledger.

Private evidence includes `preflight-direct.json`, `preflight-laravel.json`, `backup-verification.json`, `migration-execution.json`, `all-tables-before.json`, `all-tables-after.json`, `all-tables-final.json`, `schema-and-preservation.json` and `runtime-boundary.json`. Do not upload the private evidence directory.

## Gate D: authentication and browser boundary

Browser automation and an existing authenticated Admin browser session were unavailable to this run. No credentials were guessed, read from stored account data, reset or invented; no accounts were created. No authentication bypass or in-process Admin identity was used for acceptance.

The real application HTTP kernel was exercised anonymously with school DB access constrained read-only and temporary runtime storage:

- HTML GET `/SMT/admin/gradebook/templates`: **302 to `/SMARMANger`**, with no authenticated identity. This matches the existing `Authenticate::redirectTo` behavior; it is not a direct login redirect introduced by Phase 2B.
- The same GET with JSON Accept: **401**.

These are **in-process anonymous HTTP checks**, not browser/network acceptance. The localized public login flow was not certified by this CLI route-loading context. No authenticated template-manager page, real Admin shell layout, desktop/mobile rendering or browser console/network interaction is claimed verified.

No confirmed Phase 2B UI defect was found or corrected in this gate. Application code and UI are unchanged.

### Remaining manual Admin acceptance

Prefer a disposable clone with the same schema/code and existing authorized accounts. No safe isolated school lesson/year scope was designated, so do not reserve real school scopes with test templates merely to complete this checklist.

1. Start the normal local application if needed; open `/ar/adh-login` and log in through the existing flow with an authorized Admin account. Open `/SMT/admin/gradebook/templates`; verify the Gradebook navigation link and Arabic RTL shell.
2. In the disposable clone or an explicitly designated isolated scope, choose year/subject, create a clearly named acceptance draft, add at least three components with distinct names/maxima (including a total other than 100), save, navigate away and reopen.
3. Rename a component, reorder, change a maximum, remove a component and add a new one. Save and inspect the structural preview. Existing component IDs must survive rename/reorder; addition/removal must be distinct. English-only renames must also be visible.
4. Confirm the publication-only checkbox and publish V1. Check persisted snapshot, publisher and audit event; confirm no application, legacy JSON/status or mark changed. Repeat the same publish request: no duplicate version/event.
5. Start a draft from V1, edit and publish V2. Verify V1's stored snapshot/hash is unchanged and no edit/delete action exists for it. Confirm API/direct mutation denial using the established tests rather than destructive manual school queries.
6. Start another draft, discard with a reason and verify its administrative evidence. Duplicate the published definition into a second permitted isolated lesson/year scope; copied component IDs must be independent.
7. Check invalid maxima, missing confirmation, stale-tab saves and stale preview errors. Confirm messages are readable and no partial publication occurs.
8. Through legitimate separate accounts/sessions, verify Teacher/Student/Officer/non-Admin denial; do not change accounts or permissions for this test.
9. Review desktop and narrow mobile layouts: labels, Arabic text, form rows, action wrapping, component moves, preview tables, confirmation, audit pagination and navigation. Check console/network failures and duplicate submissions.
10. Compare the clone's original marks/results, JSON/status, equivalence and locking evidence before/after. Keep this browser-write evidence separate from the unchanged school database. Record outcomes before declaring full local acceptance.

## Regression results for this gate

- **104 tests / 1,766 assertions PASS**: Gradebook safety/continuity, timetable authority, follow-up eligibility, 2A contextual readers, multi-section timetable rendering and 2B templates. Tests use SQLite in memory, isolated storage and the existing guarded test environment.
- Existing Admin/Teacher/Academic Record agreement tests pass, including unchanged rendered child views and calculated outputs after inactive publication, actual term identities, source IDs, maxima, zero/null handling and original-result preservation.
- All four Node harnesses PASS: template editor, save, status and continuity.
- PHP 7.4 migration lint, isolated Blade compilation and `git diff --check` pass. No project cache clearing, Gradebook JSON/status writes or school fixture writes were used.
- Earlier 2B real-MariaDB concurrency coverage remains prior evidence (**28 assertions**); it was not rerun or relabeled as authenticated acceptance in this gate. The actual school activation/schema verification above is fresh MariaDB evidence.

## Files, limitations and next gate

Only this report is added to the repository by this acceptance pass. Private backup/verification/recovery artifacts are outside it. Existing unfinished changes, `.env.example`, application logic and the Phase 2B migration source remain unchanged. No commit, push or deployment.

The schema/backup/data-preservation gate is accepted locally. Full Phase 2B acceptance still requires the authenticated Admin workflow and visual checks above; no browser session or credentials were available to complete them safely.

A read-only Phase 2C design review may be separately authorized on this verified schema foundation. This task does not start that review. Phase 2C implementation/adoption remains gated by explicit approval and completion of the remaining 2B acceptance work.
