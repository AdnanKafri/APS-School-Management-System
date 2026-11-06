# Multi-file lesson content: LOCAL activation

Date: 2026-11-06. This report follows the owner's explicit authorization to activate the existing implementation on the separate local development database only. It supersedes the earlier activation-pending status **for local development only**. Hosted production remains untouched and is not approved or verified by this activation.

## Confirmed target

- Project: `C:\Users\Lenovo\Desktop\aladhamedu`.
- Effective database: `aladham_oct`, configured/effective TCP host `127.0.0.1:3306`.
- MariaDB: `10.4.32-MariaDB`, server hostname `DESKTOP-TBR5S6P`, local data directory resolved to `C:\xampp\mysql\data`.
- Port 3306 is owned by the local XAMPP `mysqld.exe`. Application configuration contains no separate read/write database hosts. CLI and actual HTTP runtime identify the same local database/server.
- Port 8000 is served by `C:\php74\php.exe -S 127.0.0.1:8000` using this project's `server.php`. No hosted database or external deployment endpoint was contacted.

## Recoverable backup, verified before migration

Backup folder, outside the project and Web root:

```text
C:\Users\Lenovo\.codex\backups\lesson-local-activation-adcadc000c95498f818544c10a307c84
```

- SQL: `aladham_oct-before-lesson-content.sql`, **67,017,441 bytes**.
- SHA-256: `e5a311a749036927dd6c3c666ecdaec53977250253c41961ee8071d8c26e182e`.
- Dump includes data, schema, routines, events, triggers and binary-safe values, using a single-transaction dump.
- Restored into the separate local verification database `aladham_lesson_restore_9411767d4c37bbab`. All **166 tables / 326,425 rows**, table definitions and triggers matched the pre-activation snapshot. Restore and comparison completed without warnings. The verified restore database remains available; it was not used to replace the development database.
- `storage-files-before` contains **426 existing uploaded/content files, 676,558,913 bytes**, copied and checksum-verified. Original files remained in place. Runtime cache/session/log files were intentionally excluded from this uploaded-file backup.
- `local.env.before` and `env-example.before` preserve configuration before activation. Backup/evidence files contain private local data and must not be committed, published, or copied into a Web-accessible folder.
- Initial private verification helpers required unbuffered PDO reads for a large table and consistent PDO value typing for snapshot comparison. Those helper errors were corrected without changing PHP limits or application data. The complete restore and final comparisons passed; the earlier helper errors remain in local logs for transparency.

## Named migration only

Executed:

```powershell
C:\php74\php.exe artisan migrate --path=database/migrations/2026_11_06_000001_create_lesson_content_attachment_foundation.php --force
```

Result: success. No blanket migration command or unrelated migration was executed.

Verified:

- Four additive parent columns: `upload_request_hash`, `upload_payload_hash`, `upload_revision`, `upload_deleted_at`.
- New InnoDB `lesson_content_attachments` table, signed INT parent reference and attachment metadata/cleanup fields.
- Parent unique index `lesson_content_request_unique`.
- Child `PRIMARY`, unique `lesson_attachment_path_unique`, and unique `(content_id, position)` index `lesson_attachment_position_unique`.
- `lesson_attachment_content_fk` points to `lesson_teacher_room_term_exam.id`, with DELETE/UPDATE RESTRICT.
- Exactly one new migration registration: **ID 54, batch 26**. No legacy attachment backfill or data rewrite.
- Immediately after migration, the child table was empty and all pre-existing row hashes remained unchanged.

## Local configuration and HTTP runtime

The only permanent configuration change was adding this line to the ignored local `.env`:

```dotenv
LESSON_CONTENT_ENABLED=true
```

`.env.example`, PHP settings and application source files were not changed in this activation pass. Existing unrelated worktree changes were preserved.

Ran `artisan config:clear`, `artisan view:clear`, and `artisan view:cache`. An ephemeral loopback-only, token-protected runtime probe confirmed over the **actual port-8000 HTTP process**:

- `config('lesson_content.enabled') === true`.
- Schema-gated `LessonContentFeature::enabled() === true`.
- Same local project/database identity as the preflight.
- fileinfo and ZipArchive available.
- Effective Web limits unchanged: `upload_max_filesize=128M`, `post_max_size=140M`, `max_file_uploads=20`.
- OPcache inactive; no server restart was necessary. No server-wide settings were changed.

The temporary probe was removed and its former URL verified as 404. No diagnostic access route/file remains in the application.

## Local private-storage protection

Before enabling the flag, real private canary files were requested through the current storage junction and port-8000 server. Direct file, journal, `/public/storage/...`, normalized traversal and encoded-separator requests all returned **404**, with no private bytes. A public asset control returned 200. Only owned canaries were removed.

After activation, actual uploaded private files were again requested via public storage URLs: all denied. Authorized endpoints returned byte-identical files with private/no-store responses. Guest access returned 401; a different-section Student returned 403. No new public storage alias was created.

This verifies the current local PHP router, not hosted Apache/Nginx configuration. Production privacy checks and deployment approval remain separate.

## Actual HTTP functional QA

**52 checks passed**, using normal HTTP login forms, existing valid credentials, session cookies, real multipart requests and CSRF tokens. Credentials are not included in this report. This was network-level HTTP/DOM verification, not graphical browser automation.

The two supplied contexts were checked independently:

| Page | Actual context | Result |
| --- | --- | --- |
| `/SMARMANger/dashboard/teacher/teacher_rooms2/1/166/158/5023` | Teacher 166, class 1, section 158, subject 406, lecture 5023, year 6, term 20 | 200; activated multi-file form |
| `/SMARMANger/dashboard/student/lesson/lecture/content/409/748/5037` | Student 748, class 2, section 132, subject 409, lecture 5037, year 6, term 20 | 200; existing content and legacy public download still work |

The real Teacher DOM contains one multiple-file picker, optional 2,000-character notes, title, external link, upload token, CSRF token and selected-count input in the **same multipart form**. All six related CSS/JS assets return 200 and match current on-disk hashes. Dynamic filename/count/removal logic is additionally covered by the passing Node harness; native browser picker interaction remains a manual check.

### Dedicated retained test data

No real-looking pre-existing lesson was edited. A new clearly identified local lesson was created in the already-authorized context of lecture 5037:

- Lecture **5059**, name **`[LOCAL MULTIFILE QA 655d71036b]`**.
- Teacher 166 / user 1836; Student 748 / user 909 remains enrolled in the original section 132. No accounts, passwords, placements, assignments or subjects were created/changed.
- Year 6, actual term 20, class 2, section 132, subject 409.
- Uploads were performed while the dedicated lesson was future-scheduled, then **only this test lesson** was published for Student verification. This avoided sending test notifications or queuing push jobs. Notification and job table counts/hashes remained unchanged.
- Parent **3704**: retained single text file, one active attachment.
- Parent **3705**: three-file upload; notes edited and one attachment removed through the real Teacher HTTP actions. Two active attachments remain: a test PDF and PNG, displayed as one group.
- Parent **3706**: dedicated deletion test, now a tombstone with its attachment soft-deleted and owned bytes purged. It is not displayed to the Student.
- Five child rows total: three active and two soft-deleted/purged. No orphaned cleanup journals or pending purges.

Open the retained demonstration using the corresponding authorized accounts:

```text
Teacher: http://127.0.0.1:8000/SMARMANger/dashboard/teacher/teacher_rooms2/2/166/132/5059
Teacher content: http://127.0.0.1:8000/SMARMANger/dashboard/teacher/lessons/book_details/409/166/132/5059
Student: http://127.0.0.1:8000/SMARMANger/dashboard/student/lesson/lecture/content/409/748/5059
```

Verified single/multiple persistence, notes save/display/edit, escaped markup and line breaks, one coherent card per group, Files default tab, identical-request idempotency, individual view/download byte hashes, selected-file removal, group deletion, deleted-file denial, unpublished-lesson denial, guest denial, cross-section file/page denial (Student 331), and refreshed Teacher management controls. Existing legacy content remained intact. Intentionally markup-like test notes render as plain text, not executable HTML.

All four supplied/demo pages were requested again after Blade cache rebuilding: 200; the Teacher upload forms still contained the multiple picker.

## Preservation and regressions

- Final comparison excludes only the explicitly recorded new migration, new test lecture, new test parents and new attachment table. **All 326,425 pre-existing rows across all 166 original tables match the baseline**, including users, students, marks, assessments/results, placements, assignments, financial records, notifications and queued jobs.
- All **426 original uploaded/content files** still match their pre-activation SHA-256 hashes.
- `.env.example` is byte-identical. `.env` differs only by the approved local flag line.
- Cleanup dry run: zero unowned files, zero skipped journals, zero pending removals.
- Re-ran the disposable MariaDB regression suite: **134 assertions PASS**, separate database `aladham_lesson_test_b522d73c5b3a36a1`.
- Three Node frontend harnesses PASS; migration PHP 7.4 lint, real Blade cache rebuilding and `git diff --check` PASS.
- No application HTTP 500 occurred in the successful functional run. Expected 401/403/404 denials were tested deliberately. No graphical browser console was available to inspect.

## Remaining checks and boundaries

- No connected graphical browser is available. Owner should perform visual/native-file-picker and responsive checks at 320, 390, 768, 1366 and 1920px, including selected-name/count feedback, keyboard controls and inline PDF/image presentation. These checks are not claimed as completed.
- Hosted production database, hosting settings, deployment files, mobile API contracts, Gradebook, assessments and academic/financial business logic were not modified. No commit, push or deployment occurred.
- Existing mobile clients remain limited for new Web-private grouped content, as documented in the implementation report. Activation does not add a mobile adapter or secure the legacy API contract.
- Ordinary future uploads follow the existing notification/queue integration. Local QA intentionally created no notification or push jobs; it did not change messaging credentials or queue configuration. Consider external messaging side effects before running local workers against copied device-token data.
- Retained test groups can be managed using their normal secure Teacher actions. Do not blindly remove parent/tombstone/FK rows with raw SQL or roll back the populated migration. Disabling the local flag is the non-destructive feature rollback; it does not erase the new data/files.

**Result: multi-file lesson content is activated and functionally verified on LOCAL development only. Hosted production remains untouched.**
