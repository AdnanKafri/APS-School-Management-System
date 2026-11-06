# Lesson content: filenames, multi-file attachments and notes

Date: 2026-11-06, Asia/Damascus.

## Delivery status and approval gate

**Completed:** the independent Teacher filename presentation fix, accessible selected-file feedback, and isolated regression checks. Both requested pages render successfully through the authenticated HTTP kernel against read-only local data.

**Prepared for review, not activated:** the additive attachment migration and the multi-file/notes integration contract below. The draft is deliberately outside `database/migrations`, so a routine `artisan migrate` cannot apply it. No migration was executed against the school database.

**Not implemented yet:** accepting multiple files in the Web handler; grouped Student attachment presentation; Notes create/edit controls; private attachment downloads; grouped edit/delete/rollback handling. Those features must be completed together after approval. No `multiple` attribute or array upload contract has been enabled against the existing single-file handler.

The request explicitly permits finishing the independent filename/UI repair and presenting the precise remaining proposal when a schema change is necessary. This report does not claim completion of the entire multi-file feature.

## Existing architecture verified

| Layer | Actual implementation |
|---|---|
| Teacher page | `TeacherController_New@teacher_rooms2`, `teachers2.teacher_addcontent`, `teachers2.layouts.app` |
| Create endpoint | POST `dashboard/teacher/classes_lessons/store_items`, named `dashboard.store_items`, under the existing Teacher routes |
| Content model/table | `Lesson_teacher_room_term_exam` / `lesson_teacher_room_term_exam` |
| Lesson definition | `Lecture` / `lectures`; content rows link through `lecture_id` |
| Student page | `studentscontroller@lecture_content`, `students.new_lecture_content`, `students.layouts.app4` |
| Teacher content list | `TeacherController_New@book_details`, `teachers2.teacher_showcontent` |

The exact Teacher target `/SMARMANger/dashboard/teacher/teacher_rooms2/2/166/132/5037` resolves to lecture 5037, Teacher 166, class 2, section 132, subject 409, year 6, actual term 20. The Student target uses Student 748 and the same lecture/subject.

Read-only schema inspection confirms:

- Parent `id` is signed `INT(11)`. Foreign-key columns must match it; blindly using `foreignId()`/unsigned BIGINT would be wrong.
- Type `'4'` is general files: title `name_addition`, one path `addition`, optional `addition_link`, extension, Teacher/section/subject/actual-term/lecture context, timestamps.
- Other existing types remain separate: video `'0'`, homework `'1'`, audio `'6'`, automated lesson assessments `'7'`/`'8'`, and other legacy assessment types.
- **A nullable TEXT `note` column already exists.** It is used for assessment instructions elsewhere. Only one existing nonempty note was found, on type `'8'`. The active file-content create/list pages neither save nor display it. It can be reused as plain-text notes on the parent for file content without adding a notes column or rewriting existing notes.
- There is no content-attachment relation, reliable upload-group relationship, or original-filename column. `key` is used by legacy assessment/version behavior and must not be repurposed.
- Existing `exams_files` represents Student assessment submissions, not Teacher attachments; `electronic_files` and supervision/staff file tables have different ownership and purposes. They are not safe substitute attachment tables.
- There are 1,218 type-`'4'` records: 1,194 have a file value, 35 have a link value; some have both. Lecture 5037 has three separate type-`'4'` records (3689, 3702, 3703). Nothing proves they form a group, so they remain independent.
- SQL diagnostics compare the ENUM to the string `'4'`; numeric `type=4` would compare its ENUM ordinal and return a different category.

### Current request and storage contracts

The file form sends `teacher_id`, `class_id`, `room_id`, `lesson_id`, `lecture_id`, `type=4`, `name_addition`, `addition_link`, and a single `addition` UploadedFile. Audio/video/homework use separate existing names and forms. No request names, actions, required flags or multipart encoding changed in this pass.

`store_items` verifies the current Teacher assignment and lecture owner/section/subject before file processing. It does not fully prove every submitted class/year/term field matches the original lecture. The future grouped service must obtain that context from the stored lecture, not the browser.

Current file upload calls `store('filesteachers', 'public')`, generating server-side names. The configured public disk is **`storage_path()`**, not conventional `storage/app/public`; its URL is `/storage`, with a matching storage link. Existing Student links use `asset('storage/'.$path)`. Do not move or rewrite those paths.

The type-`'4'` branch has no MIME allowlist or application size/count limit. It checks extension guessing after storing, so a failed check or later DB failure can leave an orphan. Only the video branch has an explicit `video/mp4,video/avi,video/mpeg|max:50000` rule. Real legacy file rows include PDF, JPG, DOCX, PNG, HTML, MP4, TXT, MP3, MOV and unknown extension values. Their continued readability is distinct from a safe policy for new uploads.

Local PHP 7.4 settings read from `C:\php74\php.ini`: `max_file_uploads=20`, `upload_max_filesize=128M`, `post_max_size=140M`. Production settings remain to be checked. No PHP settings were changed.

### Ordering, edits, deletion and failures

- Teacher content details order by descending ID; Student category queries have their existing ordering. Independent records are never grouped by title, filename or timestamp.
- General file cards expose download and deletion, not a proper file-notes edit flow. The existing `dashboard.file.update` method updates homework fields; it is not a safe generic grouped-file editor.
- `addition_delete` verifies Teacher ownership/current assessment and result-safety guards, then deletes the relevant physical file and related rows. It has legacy filesystem-before-database behavior and is reached by an existing GET deletion route. It must not be reused unchanged for attachment groups.
- Current create/delete flows do not coordinate a transaction with filesystem compensation. Existing Teacher/Student lesson read paths also need explicit lecture/subject/section/year checks before grouped content is exposed.

## Filename repair implemented

Previously, the selected filename was appended as an unbounded wrapping span inside the picker label in a half-width field. Long technical names could break into a narrow column. The feedback had no independent full-width layout or way to remove a selection.

Now:

- Each of the four existing Teacher upload fields spans its form grid. The native file control stays visible, labeled and keyboard accessible.
- A separate preview is appended to the field group **outside** the picker label. It shows selected count and a bounded, scrollable list.
- Each filename has a single-line ellipsis, safe full-name tooltip, and a native keyboard-accessible `details/summary` expansion. Expanded text wraps within the available width; the list has a maximum height.
- `bdi`/automatic direction keeps mixed Arabic/English names readable. Names are assigned using `textContent`; no filenames enter `innerHTML`.
- Removing one selected file clears the native control and returns focus. The renderer also handles multi-selection with DataTransfer where supported, ready for a later approved backend; unsupported browsers do not pretend a file was removed. Assignment failures show a reselect message.
- Back navigation refreshes the preview without duplicating it. Existing native validation, CSRF and submit/busy handling remain.
- The old shared filename handler skips only these explicitly marked inputs, avoiding duplicate output. Other consumers retain their previous behavior.

The preview can display a `.bin.sha256sum` name safely. This does **not** assert that the existing backend accepts that file type. Single-file input names remain unchanged and the picker still does not accept multiple files in one submission.

## Architecture decision for approval

### Alternatives

| Approach | Assessment |
|---|---|
| A. Several existing rows plus an explicit group | Requires group identity/ownership, shared notes and changes to every independent edit/delete path; duplicates context and complicates legacy readers. |
| B. One existing content parent plus additive attachments | **Recommended.** Parent owns title, notes and academic context. Children own file metadata and order. Existing independent rows stay intact. |
| C. Independent rows inferred/presented as a group | Rejected without explicit identity; matching names/times cannot prove a group. Adding reliable identity effectively becomes A. |

### Exact additive draft

Review `docs/proposals/2026_11_06_000001_prepare_lesson_content_attachments.php`:

1. Add nullable `upload_request_hash CHAR(64)` with a unique index on the existing content parent, for retry/duplicate-submit identity. Existing rows keep NULL. Hide this internal field from model serialization before any API can see it; the migration must not silently add a field to existing mobile response shapes.
2. Add `lesson_content_attachments` with ID, **signed INT** content FK, disk, generated relative path, original display name, verified MIME type, byte size, SHA-256, position and timestamps.
3. Unique `(content_id, position)` preserves explicit ordering; unique generated `path` avoids duplicate ownership. The 191-character indexed path fits older utf8mb4 index limits. Original names are stored separately at up to 255 characters.
4. Foreign key uses `RESTRICT`, not cascade. Group/file deletion must go through the reviewed service. Existing records are not backfilled, copied or normalized.
5. Refuse blind reapplication over a partially existing schema. The draft's rollback refuses to drop attachment metadata or populated upload hashes.

No additional notes column is needed. Reuse the parent's existing `note` TEXT for optional plain-text instructions, proposed limit 2,000 characters, preserving line breaks and escaping output. Only type-`'4'` file/link content would be in the initial grouped implementation; homework, assessments, audio/video and supervision semantics remain separate.

Before approved activation, the model/service/view changes must be delivered together: relation eager loading, validated create and notes edit, safe attachment removal/group deletion, authorization, private file serving and failure compensation. Applying a table alone does not enable or complete the feature.

### Upload policy and compatibility decisions

Recommended initial limits for **new grouped uploads**: at most five files, at most 10 MiB per file, at most 25 MiB total, additionally capped below effective PHP request/count limits. Accept only a flat UploadedFile array. The existing scalar request remains a supported input to the new service; reject mixing scalar and array payloads ambiguously.

Validate files before storing; inspect server-detected content/MIME, not only browser headers or suffixes. Preserve safe document/image/audio/video formats where appropriate. New executable/active HTML, script, SVG and macro uploads require rejection or a separately approved safe delivery policy. Unknown binaries and checksum-text suffixes need an explicit policy; do not falsely signal acceptance from filename preview alone. No new allowlist is active in this patch.

**Storage/privacy approval is also necessary:** the existing public disk exposes the storage root and legacy files directly. New private attachment bytes must not be placed there and then called secure merely because their UI link has authorization. Use a disk outside the publicly served root, with a controlled Web download/view endpoint that resolves the stored attachment and validates the current/historical Student context. Verify hosting rewrites/document root before choosing the physical disk root. Serve untrusted formats as downloads with safe headers; never execute uploaded HTML/scripts.

Keep old paths and URLs untouched. Existing mobile readers consume scalar legacy file fields, and the mobile authentication contract is not sufficient to assume a new private download endpoint will work. Choose before activation:

- A Web-first rollout with explicit, documented limitations for new grouped content on old mobile clients, while old content/API shapes remain unchanged; or
- A separately approved authenticated mobile adapter before grouped content is released.

Do not silently publish the first new attachment publicly to fake backward compatibility, invent paths containing traversal segments, or add a new API response shape without approval.

### Transaction and file lifecycle contract for the next implementation

- Resolve the actual Teacher/lecture/current academic context and authorize before processing uploads. Lock/validate the existing parent on notes/edit/delete paths. Refuse closed historical mutations.
- Use a server-validated request token and unique stored hash so a retry returns the same completed group rather than creating a second one.
- Validate every file, count, total bytes, title/link and optional note before storage. Store under generated names, retaining original display metadata separately.
- Track only newly created owned paths. On any storage or database failure, roll back the database and remove those paths; never clean up unrelated legacy files.
- Queue notifications after successful commit and avoid retrying the operation as a second upload if notification delivery fails. Existing stored notifications/recipients stay intact.
- For deletion/replacement, preserve the live files until the database change succeeds, then perform owned-path cleanup with a recoverable retry record/strategy. A process crash between filesystem and DB operations requires cleanup/recovery handling; a SQL transaction alone cannot promise filesystem atomicity.
- Eager load the attachment relationship once per category/page. Student presentation uses one parent card with optional escaped notes and an ordered compact file list; old independent rows keep their existing cards. Files remains the default tab.

## Verification and limitations

- **17 isolated PHP tests / 377 assertions PASS** across filename-related view contracts, existing single-file create/upload/link and assignment safety, login regressions, and the additive proposal tests.
- Two focused frontend harnesses PASS. The new harness covers empty/single/five preview entries, mixed long names, duplicates, HTML-like names, exact removal, older-browser fallback, failed FileList assignment, and back-page recovery. These are preview tests, not successful multi-file backend submissions.
- Both exact target URLs return **200** through the real HTTP kernel with programmatically authenticated real local accounts in a MariaDB-enforced READ ONLY transaction. This is not authenticated browser testing.
- PHP 7.4 lint and rendered Blade checks pass. New assets and changed scripts have syntax checks; whitespace/UTF-8/BOM checks are recorded at close-out.
- The migration draft was exercised only against SQLite `:memory:`. It preserves the legacy row/note/path, starts with zero attachments, refuses blind reapplication and populated rollback, and restricts parent deletion when attachments exist. MariaDB DDL has not been applied. Empty SQLite rollback through Laravel 7 needs its missing Doctrine DBAL driver; no dependency was installed just for that path. Empty MariaDB rollback remains unexecuted.
- The full multi-file acceptance matrix (two/five actual uploads, per-file rejection, total limits, malformed arrays, storage/DB failure compensation, idempotency, grouped editing/deletion, private downloads, notes persistence and foreign-Student access) is **pending the approved implementation**, not passed.
- Actual browser visual acceptance remains pending at 320, 390, 768, 1366 and 1920px, including native picker appearance, long filenames, expansion/removal and limited-height scrolling. Static CSS and DOM checks do not measure overflow.

### Preservation evidence

Before/after snapshots are byte-identical across **166 tables / 326,425 rows**, table definitions, triggers, Gradebook JSON/status files and the protected source/configuration files covered by the snapshot. SHA-256: `5e87c72fdfebf88c8a2be1739bb269a2105b71b658496bea2f79c2da8b93bcdb`.

Separate hashes confirm `.env` and `.env.example` unchanged. All eight changed/new files pass UTF-8 without BOM validation; applicable PHP/JS syntax checks and `git diff --check` pass. Both new live asset URLs return 200. No schema/table/migration-log entry was created in the school database, no real file was uploaded/deleted, and no commit/push/deployment occurred.

## Changed files

- `resources/views/teachers2/teacher_addcontent.blade.php`: opt-in full-width preview fields, assets and labels; scalar request contract retained.
- `public/teachers_2/assets/css/lesson-upload-selection.css`: bounded filename presentation scoped to the Teacher picker.
- `public/teachers_2/assets/js/lesson-upload-selection.js`: safe filename lists and selection removal/recovery.
- `public/assets/js/lesson-workspace.js`: one opt-in bypass for the old filename renderer.
- `docs/proposals/2026_11_06_000001_prepare_lesson_content_attachments.php`: inactive exact schema draft.
- `tests/Feature/LessonAttachmentProposalTest.php`: isolated additive-schema preservation tests.
- `tests/Frontend/lesson-upload-selection.test.js`: filename/selection behavior tests.
- This report.

No Student view, Teacher content handler, model, route, authentication rule, Gradebook code or real upload record changed in this pass. The approved Student cards and default Files tab remain intact.

## Approval requested

Approve the additive attachment schema and its activation implementation, reusing the existing parent note field. Confirm the private-download/mobile rollout policy and proposed new-upload limits before that implementation is activated. The draft is concrete and reviewable, but nothing should run against the school database until the owner explicitly approves it.
