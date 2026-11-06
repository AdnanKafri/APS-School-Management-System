# Lesson content groups: implementation and activation gate

Date: 2026-11-06. Laravel 7.30.6, PHP 7.4, MariaDB 10.4.32.

## Status and approval boundary

The approved additive Option B is implemented and passes isolated acceptance. **It is NOT activated on the school database.** No school migration, upload, edit, deletion, notification, or test-data insertion was performed. The prior architecture report and proposal remain preserved; this report supersedes their implementation-pending status, not their historical findings.

The real Web configuration was inspected: `lesson_content.enabled=false`. The school database has neither `lesson_content_attachments` nor the new migration registration. Its current legacy upload form still uses scalar `addition`; it does not expose the new multiple-file/notes controls.

Final activation requires separate explicit owner approval after review of this report, staging browser acceptance, and private-storage/web-server checks. Do not run a blanket migration command: this worktree contains unrelated pending migrations and unfinished work.

## Architecture and behavior

- Existing `lesson_teacher_room_term_exam` remains the content parent. Only new Web file groups use the new path. Reuse its existing `note` field; do not repurpose existing exam instructions or backfill legacy notes.
- New `lesson_content_attachments` owns ordered attachment rows, with original display name, verified MIME, byte length, SHA-256, generated private path, and parent FK. Files with identical names remain separate ordered attachments; no grouping is inferred from titles or timestamps.
- Parent additions: nullable unique `upload_request_hash`, nullable `upload_payload_hash`, `upload_revision`, and nullable `upload_deleted_at`. An HMAC request receipt plus payload fingerprint makes identical retries return the same parent. Changed payloads with the same token conflict. Deleted receipts are retained, preventing accidental resurrection on retry.
- Maximum five files, 10 MiB per file and 25 MiB combined. Selected count is checked against the received count to detect truncated multipart uploads. Validate every file before any storage or transaction mutation. Optional plain-text notes have a 2,000-character limit; titles are limited to 500, external HTTP(S) links to 2,048.
- New uploads accept verified PDF, JPEG/PNG/GIF/WebP, text/CSV/checksum text, MP3/MP4/MOV/AVI/MPEG, and validated DOCX/XLSX/PPTX. MIME/suffix disagreement, script/HTML/SVG/executable content, empty files, nested/sparse arrays, oversized payloads, and unsafe Office archives are rejected. Legacy stored files and the unactivated legacy handler are not rewritten or revalidated. New arbitrary binaries/legacy Office formats are intentionally not accepted by the private uploader.
- New private disk root: `storage/app/lesson-content-private`. Original names are not used as filesystem paths. A generated `files/<UUID>.<verified-extension>` path is used; journals are separate private metadata.
- Create uses the existing Teacher POST route. New update/remove/delete POST routes require authentication, Teacher role, timetable-backed current responsibility, exact lecture/subject/class/section/year/actual-term ownership, CSRF, and an optimistic revision. The current term is required for writes; historical content cannot be mutated through the new management actions. Management forms are not offered for a previous term.
- Edit changes title, notes, and external link; remove deletes one selected attachment; delete removes the group from Web presentation and soft-deletes child metadata. This slice does not add an append/reorder/replace-file editor. Upload a new group when replacement content is needed. Removing the last file without retaining an external link is blocked.
- New groups cannot use the legacy deletion action or ordinary model mutation paths. The database FK prevents orphaning attachment ownership through raw parent deletion. Unrelated legacy bulk subject-deletion workflows are not redesigned here; they must respect this FK and may refuse deletion while private groups exist.
- Student lesson reads now verify the logged-in identity, current membership, exact lecture/subject/section/class/year/term and lecture publication before rendering the affected page. This closes the relevant lesson-ID scoping weakness without changing placement or assignment data.
- Authenticated view/download endpoints independently authorize each attachment. Admin, foreign Teacher, foreign-section Student, archived Student, guest and future-year access are denied. Historical Student access is permitted only where a preserved placement matches student/year/class/section and contains the content creation time. The current lesson page remains a current-context page; no new historical browsing UI was added.
- Private responses use no-store/private caching, nosniff and sandbox headers. Only verified PDF/images can be served inline; other files download as attachments. No private disk paths, hashes or attachment relation are serialized in the legacy parent API representation. Private-group notes are redacted in that representation; legacy records retain their previous keys and values.

## File and transaction safety

Create locks the lecture and rechecks authorization inside the database transaction. Each generated file is recorded in an exclusive, locked, durable cleanup journal before its bytes are written. Storage/SQL failures roll back parent, children and notification rows and compensate only newly owned files. An uncertain COMMIT result retains bytes/journal rather than risking deletion of committed content.

Removals keep live bytes until the database commit, then purge owned paths. Failed purges remain represented by soft-deleted attachment rows with empty `purged_at`; the successful response explicitly indicates pending cleanup. A committed upload is not reported as failed because later push dispatch fails. Notification rows are transactional and idempotent; push dispatch occurs after commit for published lectures and existing current-membership recipients.

`lesson-content:cleanup` is a dry-run command by default. `--execute` checks old unlocked journals against database ownership before deleting only unowned files and retrying pending removals. It does not remove committed owned files, even if a journal remains after a crash. Keep monitoring/retrying failed cleanup; SQL transactions cannot make filesystem operations inherently atomic. The command remains unavailable while the feature is disabled. No production scheduler was changed.

## Teacher/Student presentation

The existing Teacher picker retains native accessibility and its full-width safe filename preview. It adds count/per-file/total feedback, selection removal and a duplicate-submit guard for activated uploads. Notes are optional, multiline and escaped. Validation redisplays title, notes, link and upload token; browsers still require the Teacher to reselect file inputs after an error.

Each new Student group renders one existing-style card with escaped notes and an ordered filename list with separate authorized view/download links. Empty notes create no blank section. Legacy cards, original URLs, external links, other content categories, portal shell, breadcrumbs and tab order remain unchanged. Files remains the initial active Student tab. Parent/attachment display is eager-loaded: two collection queries, not one query per card/file.

## Migration readiness

Authoritative migration: `database/migrations/2026_11_06_000001_create_lesson_content_attachment_foundation.php`.

- Additive only; no legacy row/path/note conversion or backfill.
- MariaDB preflight requires the actual signed INT parent identity and InnoDB engine. It refuses existing/partial new schema rather than blindly adopting or recreating it.
- Empty up/down/up was exercised on disposable MariaDB. Artisan registration and rerun no-op were tested in that database, along with FK restriction and unique constraints.
- Down refuses any populated attachment table or retained upload receipt, including deleted groups. Never use rollback to discard real files or tombstones.
- MariaDB DDL is not transactionally atomic. After interruption, inspect physical schema and migration registration; do not blindly rerun, remove columns, or mark a failed migration applied.
- The earlier `docs/proposals/2026_11_06_000001_prepare_lesson_content_attachments.php` is a preserved inactive proposal, not the migration to execute.

## Verification results

Final reproducible mutation suite:

```powershell
C:\php74\php.exe tests/Integration/lesson-content-mariadb.php --create-disposable-database
```

It creates only a fresh random `aladham_lesson_test_<hex>` database plus private temporary storage, validates the effective connection, refuses reuse of the school database, and copies no school rows. All new migration/mutation tests use MariaDB, not SQLite. Disposable databases/artifacts are retained for inspection; no automatic destructive teardown was added.

Final run: **134 assertions PASS**, database `aladham_lesson_test_c54ff4a6bf64362d`, storage `C:\Users\Lenovo\AppData\Local\Temp\aladham-lesson-test-36a16cbcf64d0c107ef536b81a6bd400`. Includes:

- Scalar single-file compatibility, two/five uploads, duplicate/long Arabic-English names, external links, absent/2,000/2,001-character notes and exact 10/25 MiB boundaries.
- Malformed/missing counts and IDs, unsupported/MIME-spoofed files, empty/oversized files, total/count limits, malicious links and Office macro rejection.
- Identical retry, changed-payload conflict and two independent simultaneous PHP/HTTP-kernel requests producing exactly one parent, file and notification.
- Real Web middleware/CSRF and ownership boundaries, archived/future Student denial, original-byte download integrity, PDF inline/text attachment behavior, no-store/nosniff and path-free serialization.
- Revision-checked edit, foreign edit/removal refusal, one-file removal, last-file protection, group deletion, deleted-token refusal, model guards and MariaDB FK protection.
- Failure after file storage, a real SQL unique-constraint failure, rollback compensation, deferred purge visibility, locked-journal skip, non-destructive dry run, owned-file preservation and uncertain-commit recovery.
- Actual Teacher create/list and Student content routes/controllers/views in the fixture application. Only unrelated outer layouts use a fixture; target Blade templates are real. Grouped cards, escaped notes, legacy URL, Files default and the disabled legacy upload path are checked.

Additional checks:

- **6 existing render-only tests / 227 assertions PASS** for legacy media, cards, form contracts, breadcrumbs and tab states. They create no database fixtures or records.
- Three Node frontend harnesses PASS: selected-file preview/limits/count, confirmation/duplicate-submit recovery, and existing RTL/keyboard/Bootstrap tab synchronization. These are DOM harnesses, not browser layout measurements.
- A separate disposable built-in PHP server using the modified `server.php` and a legacy-style storage junction returned 200 for a public control file and 404 for private-file, journal and normalized traversal requests. No private bytes were returned. Apache/Nginx hosting behavior still requires deployment-environment verification.
- The exact real Teacher add route, Teacher content list, and Student-748 lesson-content route returned **200** through the real HTTP kernel, complete shared layouts and programmatically authenticated local accounts, inside a MariaDB-enforced READ ONLY transaction. This is not an authenticated browser session.
- PHP 7.4 lint and five compiled modified Blade templates PASS. Full `view:clear`/`view:cache` PASS in isolated compiled-view storage, with the school connection read-only. JavaScript syntax, UTF-8 without BOM, no-new-mojibake and `git diff --check` PASS.
- Before/after school snapshots are byte-identical: **166 tables / 326,425 rows**, schemas, triggers, protected Gradebook files and JSON/status data. SHA-256: `5e87c72fdfebf88c8a2be1739bb269a2105b71b658496bea2f79c2da8b93bcdb`. Separate `.env` and `.env.example` hashes match. No real grades, academic records, identities, financial records or assignment rows changed.

## Compatibility and remaining acceptance

The legacy mobile API controller/routes were not changed. Old file records and scalar paths remain usable. New Web-private groups do not manufacture a public first-file URL; legacy clients cannot consume their attachments/notes through the old contract. Some existing API lists may still show parent title/context metadata, including tombstoned groups, because API filtering/authentication was intentionally not redesigned. Existing unauthenticated mobile metadata exposure is NOT fixed by this work. A separately approved authenticated mobile adapter is required for full new-group mobile support.

No browser surface is connected in this environment. Authenticated visual/picker/PDF acceptance at **320, 390, 768, 1366 and 1920px** remains pending on a disposable/staging database, including long filenames, many attachments, keyboard tab interaction, limited-height scrolling, Teacher confirmation/cancel, edit/close/retry, and Student view/download. Do not call this production activation or completed browser acceptance.

## Exact changed files

Foundation, storage, security and routes:

```text
.htaccess
server.php
config/filesystems.php
config/lesson_content.php
database/migrations/2026_11_06_000001_create_lesson_content_attachment_foundation.php
app/Lesson_teacher_room_term_exam.php
app/LessonContentAttachment.php
app/Services/LessonContentFeature.php
app/Services/LessonContentAccess.php
app/Services/LessonContentInput.php
app/Services/LessonContentStorage.php
app/Services/LessonContentService.php
app/Services/LessonContentRecovery.php
app/Http/Controllers/LessonContentController.php
app/Http/Controllers/TeacherController_New.php
app/Http/Controllers/studentscontroller.php
app/Jobs/SendLessonContentNotification.php
app/Console/Commands/CleanupLessonContent.php
routes/teacher.php
routes/web.php
resources/lang/ar/lesson_content.php
resources/lang/en/lesson_content.php
```

Presentation and tests:

```text
resources/views/teachers2/teacher_addcontent.blade.php
resources/views/teachers2/teacher_showcontent.blade.php
resources/views/teachers2/partials/private_lesson_content.blade.php
resources/views/students/new_lecture_content.blade.php
resources/views/students/partials/private_lesson_content.blade.php
public/teachers_2/assets/css/lesson-upload-selection.css
public/teachers_2/assets/css/lesson-content-management.css
public/teachers_2/assets/js/lesson-upload-selection.js
public/teachers_2/assets/js/lesson-content-management.js
public/student/assets/css/lesson-content-cards.css
tests/Frontend/lesson-upload-selection.test.js
tests/Frontend/lesson-content-management.test.js
tests/Integration/lesson-content-mariadb.php
tests/Integration/lesson-content-cases.php
tests/Integration/lesson-content-worker.php
docs/audits/lesson-content-multifile-implementation-and-activation-gate-2026-11-06.md
```

All unrelated pre-existing working-tree edits are preserved. No commit, push or deployment was made.

## Final activation steps - NOT EXECUTED

1. Review this report and complete isolated authenticated browser acceptance. Obtain explicit final owner authorization for the named target environment/database before any school migration or enablement.
2. Back up the target database and storage; inspect the exact parent engine/key, existing migration registration/columns and deployment's real public/storage layout. Do not assume `public_html` matches local symlinks.
3. Prove private files AND journals are denied through every public storage URL/alias. The root Apache rule requires working mod_rewrite/AllowOverride; Nginx needs explicit denial for `/storage/app/lesson-content-private/` and any `/public/storage/...` or deployment-base equivalents. Do not enable if static serving bypasses these rules. Use normal controlled fixture bytes in the approved staging environment, not a real school document.
4. Verify fileinfo, ZipArchive, writable private storage/temp uploads, effective Web PHP limits (`upload_max_filesize >= 10M`, `post_max_size >= 26M`, `max_file_uploads >= 5`), proxy limits/timeouts, and queue delivery. Local CLI values are 128M / 140M / 20; these do not establish hosting/Web PHP values.
5. Only after approval, apply **only** `database/migrations/2026_11_06_000001_create_lesson_content_attachment_foundation.php` using Artisan's explicit `--path`; inspect the physical schema/FK and migration record. Do not execute the proposal or all pending migrations.
6. Only after the schema and private-serving checks pass, enable `LESSON_CONTENT_ENABLED=true` through the authorized environment configuration and refresh the target configuration/view cache and workers as required. No environment file was changed in this task.
7. Perform the owner-approved controlled Teacher-to-Student upload/edit/remove/download smoke test and retain audit evidence. Configure/monitor periodic `lesson-content:cleanup --execute`; first inspect its dry-run output. Use a scheduler outside this task or a separately reviewed scheduler change. Ensure queue workers use the reviewed configuration.
8. Rollback plan: disable the feature to stop new writes and private reads, retaining all data/files/receipts. Never run a destructive down migration on a populated installation. Disabling does not roll back the lecture-authorization hardening; legacy files/URLs remain available under their existing behavior. Investigate and recover cleanup journals deliberately.

**Conclusion: implementation and isolated acceptance complete; school activation and authenticated browser acceptance remain pending.**
