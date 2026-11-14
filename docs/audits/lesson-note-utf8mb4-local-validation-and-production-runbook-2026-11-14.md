# Lesson notes UTF8MB4 repair: local validation and production runbook

Date: 2026-11-14. Local correction applied; no production access or deployment performed in this task.

## Verified cause and scope

The previously supplied production log identifies MariaDB 1366 / SQLSTATE 22007 at `LessonContentService::create()`, parent `$content->save()`, for Teacher 166, section 130, lecture 5066. Four-byte Unicode in the note was rejected before the attachment-storage loop. Normal Arabic does not require four-byte encoding and therefore could succeed. The log was not edited, cleared, packaged or copied into this report.

The current local connection was verified through Laravel, not inferred from a failed connection attempt:

- Effective target: `127.0.0.1:3306`, `aladham_oct`, hostname `DESKTOP-TBR5S6P`.
- MariaDB 10.4.32; PHP 7.4.33; Laravel 7.30.6; configuration cache absent.
- Laravel configuration: charset `utf8mb4`, collation `utf8mb4_unicode_ci`.
- Actual PDO session: client/connection/results `utf8mb4`, connection collation `utf8mb4_unicode_ci`, REPEATABLE-READ.
- Port 8000 runs this project's `server.php` with `C:\php74\php.exe`; the real local login GET returns 200.
- Table: InnoDB, legacy default `utf8_general_ci`; database default `utf8` / `utf8_general_ci`.
- `note`: `TEXT NULL DEFAULT NULL`, no extra attributes or comment, originally `utf8` / `utf8_general_ci`.
- `name_addition`: also `TEXT NULL DEFAULT NULL`, `utf8` / `utf8_general_ci`. It is not the failing field and is deliberately unchanged.
- Attachment text metadata (`original_name`, disk/path, MIME, SHA-256) already uses `utf8mb4_unicode_ci`; its schema does not need conversion.
- The parent has primary, request-receipt unique, subject/Teacher/section/term indexes; `note` is not indexed. The attachment ownership FK references the parent's signed INT identity with RESTRICT. No parent triggers were found. No application/schema change to these dependencies was needed.
- Original parent count: 1,540; five non-NULL notes, 1,535 NULL notes, no empty strings. Existing notes include Arabic and Latin text, with a maximum 263 characters / 524 bytes. No personal note contents are reproduced here.
- Parent reported data/index lengths: 262,144 / 212,992 bytes. This small local table did not require a broader conversion.

An initial server-availability check failed. A startup attempt was made before the owner's later no-restart clarification. The server subsequently became available, and real read-only Laravel queries succeeded. No further start/restart, recovery flags, database-file repair, configuration or environment changes were made after clarification. Startup warnings about missing tablespaces in unrelated databases were not repaired; all school tables used for the before/after snapshots were readable. MySQL was left running as-is.

## Minimal implementation

Migration: `database/migrations/2026_11_14_000001_ensure_lesson_content_note_utf8mb4.php`.

Before:

```sql
`note` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL
```

After:

```sql
`note` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL
```

This is a column-specific ALTER, not a database/table character-set conversion. TEXT byte capacity, NULL/default semantics and existing comment are preserved. The engine may internally rebuild/copy the table while executing ALTER; there is no manual truncate/recreate or row rewrite in application code. Entire CREATE TABLE definitions compared equal after normalizing only this note charset/collation clause.

The migration fails closed on an unexpected column type/default/nullability, generated/extra attributes, source encoding, non-InnoDB table, note index, incompatible connection or unavailable collation. It preserves an already-compatible utf8mb4 column/collation without issuing ALTER. Metadata lock wait is limited to 15 seconds for this connection and restored afterward; this is not a guaranteed limit on ALTER runtime. `down()` refuses a Unicode-narrowing rollback, which could destroy subsequently entered supplementary characters.

No application controller/service, validation limit, note sanitization, file path, authorization, calculation, environment or connection configuration change was necessary. In particular, emoji are not stripped or replaced.

## Recoverable local backup

Private directory, outside the project and public root:

```text
C:\Users\Lenovo\.codex\backups\lesson-note-utf8mb4-b1274dd40a334721aa85f7230997e383
```

- `lesson-content-before.sql`: 539,322 bytes, structure/data/triggers for the parent and attachment tables, UTF8MB4 connection, single transaction, hex-safe binary representation.
- SHA-256: `45888f9dfaccfe7520fcbe1f5f81e99d57bbe62857d5e0eab18fe26a1500b8f4`.
- Restored successfully into **separate** local database `aladham_note_restore_6e2a1f1d8c5d2346`.
- Restored parent 1,540 rows and attachment eight rows match source row fingerprints and CREATE TABLE hashes exactly. Restore was not applied over the school database.
- `backup-verification.json`, before/after metadata, full-school snapshots, environment copies and storage checksums retain private verification evidence. The directory includes a local-client credentials file and must never be uploaded, committed or published.

Local execution, after restore verification and a fresh unchanged-source fingerprint check:

```powershell
C:\php74\php.exe artisan migrate --path=database/migrations/2026_11_14_000001_ensure_lesson_content_note_utf8mb4.php --force
```

Result: migrated in approximately 0.03 seconds, batch 27. A second execution returned `Nothing to migrate`. No other pending migration ran.

## Data preservation

- All original rows in all 167 school tables retain their before hashes and counts. The only inserted row is this migration's registration: total database rows 326,486 -> 326,487.
- All 1,540 original content rows, including every field and note value, retain their exact row fingerprint. The attachment table's eight rows/schema remain unchanged.
- Parent DDL changed only at the note charset/collation clause. Other table schemas, indexes, FKs, triggers and protected Gradebook/configuration files are unchanged.
- All 432 checked existing uploaded/content files retain their checksums; no existing file was moved, edited or deleted.
- `.env` and `.env.example` hashes remain unchanged. No original Student/Teacher/academic/financial record was modified or used as a mutation fixture.

## Reproducible verification

```powershell
C:\php74\php.exe tests/Integration/lesson-content-mariadb.php --create-disposable-database
```

The runner uses a uniquely named disposable MariaDB database and isolated storage, never the school database for mutations. The added Unicode case deliberately reproduces the three-byte note column and legacy table/title defaults instead of inheriting the fixture database's utf8mb4 default.

Before correction, the actual upload route/controller/service returned the same safe generic 500 for emoji notes, with no partial parent/attachment/notification/file/journal state. This reproduction passed before the migration was implemented.

Final integration result: **279 assertions passed**, database `aladham_lesson_test_838c6fc1b0578b73`, isolated storage `C:\Users\Lenovo\AppData\Local\Temp\aladham-lesson-test-5ec3ff73a83439677fba42efe71ac4e2`.

Coverage includes:

- Arabic, Arabic plus emoji, multiple emoji, mixed English/Arabic, supplementary Gothic/music/CJK characters, NULL/empty inputs, quotes/backslashes/HTML-like plain text, and a 2,000-character Unicode boundary. Existing empty-string-to-NULL middleware behavior is preserved. 2,001-character notes still fail validation.
- Actual single-/multiple-file and link-only creation, exact database retrieval, edit adding/removing emoji, Student note rendering/escaping, authorized downloads and foreign-Student denial. File hashes remain exact.
- Migration preserves all existing parent values, all other column attributes, table defaults and attachment ownership; scoped Artisan registration/rerun; already-compatible no-op; rejection of unreviewed defaults, indexed notes and three-byte application sessions; refusal of unsafe down migration.
- Deliberate late upload failure after Unicode parent/file creation rolls back rows and compensates only new files. Existing single/multiple upload, MIME/size, idempotency/concurrency, legacy content, private authorization, journal/recovery and hosting-failure regressions also pass.

Additional focused checks passed: seven render-only Blade tests / 264 assertions, four frontend harnesses, PHP lint, UTF-8/no-BOM and `git diff --check`. No graphical browser/app surface was connected; authenticated graphical acceptance is not claimed. No synthetic content was inserted into the local school copy to obtain these results.

## Production runbook: owner review required, NOT executed

Production has newer uploads. **Never import this local database or local backup over production. Uploading the migration does not execute it.**

### 1. Package and inspect

The only required runtime file to upload is:

```text
database/migrations/2026_11_14_000001_ensure_lesson_content_note_utf8mb4.php
```

Do not upload tests, production logs, private backups/client credentials, `.env`, cached configuration from local, database dumps or unrelated changes. No Composer/package update or runtime application-file replacement is required for this correction. No configuration change is required if the actual hosting connection already uses utf8mb4; if it does not, stop and review that discrepancy rather than modifying environment/configuration blindly.

Select a low-traffic maintenance window and verify the actual application root and the PHP binary used by the website. Do not assume the project is under Laravel's usual `public/` arrangement; follow the existing Hostinger `public_html` front controller. Inspect private-storage HTTP denial rules, but do not create new public symlinks or move storage.

Using the actual production database in phpMyAdmin (read-only SQL):

```sql
SELECT DATABASE(), VERSION();
SELECT DEFAULT_CHARACTER_SET_NAME, DEFAULT_COLLATION_NAME
FROM information_schema.SCHEMATA WHERE SCHEMA_NAME=DATABASE();
SELECT ENGINE,TABLE_COLLATION,DATA_LENGTH,INDEX_LENGTH
FROM information_schema.TABLES
WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='lesson_teacher_room_term_exam';
SELECT COLUMN_NAME,COLUMN_TYPE,IS_NULLABLE,COLUMN_DEFAULT,
       CHARACTER_SET_NAME,COLLATION_NAME,EXTRA,COLUMN_COMMENT
FROM information_schema.COLUMNS
WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='lesson_teacher_room_term_exam'
  AND COLUMN_NAME IN ('note','name_addition');
SHOW CREATE TABLE lesson_teacher_room_term_exam;
SHOW CREATE TABLE lesson_content_attachments;
SHOW COLLATION LIKE 'utf8mb4_unicode_ci';
SELECT migration,batch FROM migrations
WHERE migration='2026_11_14_000001_ensure_lesson_content_note_utf8mb4';
```

Confirm the note is nullable TEXT with NULL default, no unreviewed extra attributes/index dependencies, and the parent is InnoDB. Compare the production table size with the small local table; a substantially larger or busy table needs its own lock/time/disk-capacity assessment before proceeding. Charset changes may copy the table and block writes. Do not assume instant/online ALTER or zero downtime.

From SSH in the verified application root, with `PHP` set to the reviewed hosting PHP executable, inspect the actual Laravel connection without printing credentials:

```sh
PHP=/verified/path/to/php
"$PHP" <<'PHP'
<?php
require 'vendor/autoload.php';
$app=require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$c=Illuminate\Support\Facades\DB::connection();
echo json_encode([
 'php'=>PHP_VERSION, 'config_cached'=>$app->configurationIsCached(),
 'host'=>$c->getConfig('host'), 'port'=>$c->getConfig('port'),
 'database'=>$c->getDatabaseName(), 'configured_charset'=>$c->getConfig('charset'),
 'configured_collation'=>$c->getConfig('collation'),
 'session'=>$c->selectOne('SELECT @@character_set_client client,@@character_set_connection connection_charset,@@character_set_results results_charset,@@collation_connection connection_collation')
],JSON_PRETTY_PRINT);
PHP
```

This is a CLI check. Ensure hPanel assigns the same reviewed PHP/runtime configuration to the Web application; do not create a public diagnostic PHP file or expose configuration output online. A phpMyAdmin connection charset alone is not proof of Laravel's charset.

### 2. Quiesce writes and take a fresh verified backup

Owner-controlled maintenance must stop content creation/edit/delete during backup, conversion and data comparison. Laravel maintenance mode is one option; it affects the whole school site, so coordinate the brief outage. Existing in-flight requests and any independent writers must finish first. Do not perform a broad schema change while Teachers are uploading.

```sh
"$PHP" artisan down
umask 077
B="$HOME/private-backups/lesson-note-$(date +%Y%m%d-%H%M%S)"
mkdir -p "$B"
DUMP=$(command -v mariadb-dump || command -v mysqldump)
# Set these from the verified production connection, not the local environment.
DB_HOST='verified-production-host'
DB_PORT='3306'
DB_NAME='verified-production-database'
DB_USER='verified-production-user'
"$DUMP" -h "$DB_HOST" -P "$DB_PORT" -u "$DB_USER" -p \
  --single-transaction --skip-lock-tables --hex-blob --default-character-set=utf8mb4 \
  --result-file="$B/lesson-content-before.sql" "$DB_NAME" \
  lesson_teacher_room_term_exam lesson_content_attachments
sha256sum "$B/lesson-content-before.sql"
```

Use the password prompt; do not put passwords in shell history or shared transcripts. Confirm exit status and non-empty dump. Keep the directory outside all served document roots. Restore this **fresh production** backup into a separate, clearly named validation database (on an authorized isolated MariaDB host if hPanel limits database creation). Verify CREATE TABLE definitions, counts and deterministic data dumps against source. Never point that restore at the live database. Do not continue without a verified restore and sufficient backup/rebuild disk space.

For deterministic, all-field row comparison before/after, use the same binary/connection/flags and paused writers:

```sh
"$DUMP" -h "$DB_HOST" -P "$DB_PORT" -u "$DB_USER" -p \
  --single-transaction --no-create-info --skip-triggers --skip-comments \
  --skip-extended-insert --complete-insert --order-by-primary --hex-blob \
  --skip-add-locks --skip-disable-keys --skip-set-charset --default-character-set=utf8mb4 \
  --result-file="$B/rows-before.sql" "$DB_NAME" \
  lesson_teacher_room_term_exam lesson_content_attachments
sha256sum "$B/rows-before.sql"
```

Record original counts, NULL counts, all column definitions, indexes, FK/trigger definitions and existing upload file checksums. Restore verification compares row content, not merely counts. Preserve those evidence files privately.

### 3. Apply only this migration

After approving all checks and keeping writers paused:

```sh
"$PHP" artisan migrate --path=database/migrations/2026_11_14_000001_ensure_lesson_content_note_utf8mb4.php --force
```

Do not run blanket migrate, migrate:fresh, rollback, reset or a manual table/database conversion. Do not bypass a migration guard. DDL is not an ordinary rollback-safe data transaction. The named path is important because other pending migrations may exist.

### 4. Verify before reopening

Repeat the metadata queries. Only `note` should change to utf8mb4 / utf8mb4_unicode_ci; its TEXT type, NULL/default/comment and all other definitions remain. Confirm exactly one registration for this migration. Repeat the identical data-only dump command, changing only the result filename to `$B/rows-after.sql`:

```sh
cmp "$B/rows-before.sql" "$B/rows-after.sql"
sha256sum "$B/rows-before.sql" "$B/rows-after.sql"
```

Require identical row dumps/counts/NULL values and unchanged existing-file checksums before allowing new test content. A file-dump mismatch must be investigated; do not automatically restore over the live database. Schema comparison must allow only the reviewed note encoding clause and migration registration.

```sh
"$PHP" artisan up
```

Then an authorized Teacher should create one clearly identified new test content entry with Arabic/English/emoji notes and one/two small files, retrieve/edit the note, and verify an authorized Student's view/download and unauthorized denial. Keep the title free of emoji: title encoding is intentionally outside this patch. Verify no new error 1366, normal legacy content, and file hashes. Any cleanup must use only the normal authorized workflow for that new test entry, never older Teacher uploads. Perform this smoke test only under the owner's explicit production deployment authorization.

### 5. Recovery if anything fails

- Keep/restore maintenance while investigating. Save the exact error, migration output, physical column definition and current row fingerprints. Check whether ALTER changed the column even if Artisan registration failed. Never blindly rerun or manually mark migration rows.
- A metadata-lock timeout before ALTER completes is a reason to reschedule/resolve the blocking writer, not to raise timeouts indiscriminately. Guards intentionally stop unreviewed schemas.
- Do not call `down()` or narrow to utf8/utf8mb3 once four-byte notes can exist. Keeping the widened column while reverting an unrelated application change is safer than an encoding downgrade.
- If data restoration is truly necessary, restore the fresh production backup into an isolated recovery database first. Compare against the live post-incident data and preserve/reconcile every newer production write before a separately approved repair. Never replace production with the older local copy or blindly import a backup over a database with newer content.
- No uploaded-file move/deletion is part of this repair. Private attachment ownership, paths, tokens and journals remain as before. Do not delete committed files or rerun old foundation migrations as a recovery shortcut.

## Exact changed files and limitations

1. New note-only migration listed above.
2. `tests/Integration/lesson-content-unicode.php` (new).
3. `tests/Integration/lesson-content-mariadb.php` (one include for the new regression).
4. This report.

Titles and other legacy columns can still reject emoji; this is deliberately not a broad Unicode normalization. The production schema, connection/cache, lock conditions and final upload behavior must be verified there by the owner; local success is not production activation. Existing unrelated missing-tablespace startup warnings are deferred, not repaired by this migration. Graphical authenticated browser QA remains pending.

No production filesystem/database access, production operation, unrelated migration, environment change, commit, push or deployment was performed.
