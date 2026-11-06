# Phase 1 controlled local migration activation

Date: 2026-10-29. Scope: local infrastructure activation only, not Phase 2B.

## A. Verdict

**ACTIVATED AND VERIFIED**

The existing migration was applied once through Laravel's migration runner. No migration source or application code was changed. No historical equivalence or mark was imported, inferred, copied, corrected or recalculated.

## B. Preflight

- Project: C:/Users/Lenovo/Desktop/aladhamedu.
- Runtime: PHP 7.4.33, Laravel 7.30.6, MariaDB 10.4.32.
- Effective Laravel environment: local; connection mysql; 127.0.0.1:3306; database aladham_oct.
- Database server: DESKTOP-TBR5S6P; local listener owned by C:/xampp/mysql/bin/mysqld.exe, process 19064. Server data directory is the local XAMPP mysql/data directory.
- No cached Laravel config, DATABASE_URL override or socket override was present. Effective bootstrapped Laravel connection agreed with the direct PDO preflight.
- Initial database: 162 base tables, all InnoDB; no routines, events or triggers. Initial migration ledger: 50 rows.
- Only pending filesystem migration: 2026_10_23_000001_create_assessment_equivalence_members. Its table and constraints were absent. No separately required pending dependency was found.
- Source exams2 uses InnoDB with signed INT id; the new signed exam_id FK is compatible. Existing exam_result2 bigint result/exam reference columns are not altered or newly constrained.
- up() creates only the mapping table and its indexes/FK. It performs no result updates, name-based matching, backfill or ownership change. The FK restricts source deletion rather than cascading. down() refuses to remove populated mapping history; no rollback was executed.
- Source migration SHA-256 before/after: 12f0a19a6ce70158863ff0afb7247ae684d6f15b64951da4839e2523abab8a7b.

Pre-existing unrelated debt remains untouched: the rooms migration is duplicated in the ledger, and January gradebook_configs/gradebook_components migrations are recorded although those physical tables are absent. They are not dependencies of this migration or the active file-backed Gradebook. The 42 existing modern results without surviving definitions remain unchanged; the new FK does not constrain those result rows.

## C. Backup and recovery

Restricted backup directory, outside the project and web root:

`C:/Users/Lenovo/.codex/backups/gradebook-phase1-activation-7f982d0124144f55b0a5ff8f451d9dc1`

- Full dump: aladham_oct-before.sql, **66,982,146 bytes**.
- SHA-256: **6c180979891b4702c6ab8e1b38c7224892b6a97dc53b3c38ecb68e807fdd8c03**.
- Matching XAMPP MariaDB 10.4.32 mysqldump, --single-transaction --quick --routines --events --triggers --hex-blob --default-character-set=utf8mb4. Database was selected explicitly; no --databases/USE directive targets a recovery import back into the original database.
- Dump exited 0 without warnings. Verified readability, nonzero size, all 162 CREATE TABLE definitions/data-section markers, completion marker and SHA-256. No restore drill or claim of restore-tested recovery is made.
- Directory ACL inheritance was disabled and access restricted to the current Windows user. No credentials were printed, added to command-line arguments or stored in the runbook/metadata. The SQL backup itself contains confidential school data and must not be uploaded or committed.
- RECOVERY.md was written before activation. It instructs stopping writers, checking the hash, restoring with the mysql client into a separately approved recovery database, comparing the saved schema/row manifests, and reviewing newer work before any cutover. No automatic destructive rollback or restore is authorized. The dump contains DROP TABLE IF EXISTS and must not be sourced into the working database without a separate approved recovery operation.

Private evidence includes backup-verification.json, all-tables-before.json, all-tables-after.json, reader-before.json, reader-after.json, migration-execution.json and schema-after.json.

## D. Exact activation and schema

After validating the effective connection, source hash, backup, pending list, source schema and absence of the target table, the guarded Laravel runner executed:

```php
Artisan::call('migrate', [
    '--path' => 'database/migrations/2026_10_23_000001_create_assessment_equivalence_members.php',
    '--no-interaction' => true,
]);
```

No --force, broad migrate, seed, manual ledger insertion, rollback, reset or refresh was used.

- Laravel command returned **0**; its captured output records successful migration in 0.3 seconds.
- New ledger entry: id **52**, batch **24**, exact requested migration name. All 50 older ledger rows are byte-equivalent under the saved row digest.
- New physical table: assessment_equivalence_members, InnoDB, **0 rows**.
- Columns verified: bigint unsigned primary id; UUID char(36) identity; signed INT exam_id; unsigned INT room/year/term/class/lesson/type/verified_by snapshots; decimal(15,4) maximum; text evidence; timestamp created_at.
- Unique indexes verified on exam_id and (identity, room_id), plus the primary key.
- FK verified from exam_id to exams2.id, DELETE_RULE=RESTRICT and UPDATE_RULE=RESTRICT.
- MariaDB's current timestamp settings render created_at with implicit CURRENT_TIMESTAMP/ON UPDATE CURRENT_TIMESTAMP. Existing mapping writes explicitly supply created_at and the application exposes append-only insertion, not mapping updates. This engine-level default is recorded, not changed or claimed to be a database-enforced immutability guarantee.
- After activation: **163 tables**, **51 ledger rows**, **zero pending filesystem migrations**. No Phase 2B table was created.

The stdin-based command wrapper returned shell status 1 after the captured Artisan migration had returned 0 and persisted successfully; it was not retried. Physical schema, SQL execution log and ledger were checked independently. A subsequent file-based read-only migrate:status check exited 0, reported Yes/batch 24, and its shutdown diagnostic recorded no PHP error. No migration rerun or unsafe rollback was attempted based on wrapper output.

Only this audit report was added to the repository in this task. All pre-existing unfinished Phase 2A files and .env.example were preserved. No commit, push or deployment.

## E. Validation evidence

### Real local database

- Before manifest covers all 162 tables and 326,257 rows, using exact counts, deterministic full-row digests and SHOW CREATE TABLE hashes.
- All **161 pre-existing non-ledger tables** retain identical row counts, full-row hashes and schema hashes. Only the migration ledger and the new empty table differ, as expected.
- Examples unchanged: exams2 **2,255**; exam_result2 **27,318**; exam_result **0**; students_marks **2,262**; report_cards **1,903**; invoices **3,255**.
- All six Gradebook JSON/status files and .env.example match their prior hashes.
- No mapping row was inserted and no old assessment identity was adopted.

### Real application readers, SELECT-only sessions

Before/after data snapshots use the actual application services/controllers, not hand-written replacement calculations. School DB sessions were set transaction-read-only. Temporary runtime storage isolates logs/views while the Gradebook disk is explicitly pointed back to the real existing storage/app files for these reads.

- Shared reader: year 5, subject/section pairs **158/97**, **31/99**, **49/103**, **50/103**; three actual student identities per pair and respectively 4/4/7/4 assessment definitions, retaining all available actual term IDs.
- Admin: actual viewGridSimple controller data, including complete section roster and calculatedMarks.
- Teacher: actual current-context index controller using a real type-1 account and an authorized timetable context in section **130**; current term, status and membership checks retained. Current-year empty assessment data is not fabricated.
- Academic Record: actual owned historical placement **1**, **45** assessment rows, plus marks/reports/results/files/certificates data.
- Combined snapshot SHA-256 before and after: **bbf6115f25560a14fccf1710310fb686aecfd48f9ffb3949d7dd27882b0de16a**.

These are controller/query-data checks with in-process identities, **not authenticated browser, login or full-layout visual acceptance**. Real legacy inconsistencies were not repaired to make the sample pass.

### Isolated regressions

Both before and after activation:

```text
PHPUnit --filter GradebookSafetyTest|TimetableAuthorityTest|TeacherStudentFollowUpEligibilityTest|GradebookContextReaderTest|AdminTeacherTimetableViewTest
        --do-not-cache-result --process-isolation
PASS: 91 tests, 1,549 assertions
```

Each run uses SQLite :memory:, unique temporary storage, process-only SQLite extension configuration and no school database writes. Includes Phase 1 mapping uniqueness/FK/rollback preservation and continuity tests, original identity/result preservation, transfers, actual terms, zero/null/conflict behavior, contextual configuration and Admin/Teacher/Academic Record agreement.

All three frontend harnesses pass: gradebook-save, gradebook-status, gradebook-continuity (nine legacy filter branches and four rendered scripts).

Migration PHP lint and git diff --check pass. No application source, config or migration was modified. The report is UTF-8 without BOM.

## F. Phase 2B readiness

The **local Phase 1 schema-activation blocker is cleared**. Phase 2B can be separately authorized against the existing architecture and approved D1-D8 policies. None of those future policies was implemented here.

This is not production activation, a deployment approval, historical equivalence adoption or proof of populated live continuity acceptance. Production schema/backup checks, true concurrent MariaDB writer acceptance and browser QA remain distinct later gates. The empty mapping table deliberately leaves all independent historical assessments independent.

## G. Next recommended action

Review this activation evidence, then separately authorize the bounded Phase 2B draft/version foundation under D1-D8. If operational Phase 1 continuity acceptance is needed first, use disposable staging with legitimate explicit mappings, including concurrent-writer and browser checks; do not auto-map school history. No next phase starts automatically.
