# Teacher media capacity and protected educational file types

Date: 2026-11-25. Local implementation only; no deployment or hosting changes.

## Result and capacity contract

The existing Teacher protected Files uploader now supports the explicit 161-extension inventory below. Existing public audio/video tabs remain media-only and use the same effective size policy. There is no wildcard, new upload architecture, dependency, migration, mobile API change, or Student submission limit change.

| Setting | Previous application default | New application default |
| --- | --- | --- |
| Files in one protected group | 30 | 20, also capped by PHP max_file_uploads |
| Individual bytes | 104857600 (100 MiB) | 2139095040 (2040 MiB) |
| Combined bytes | 157286400 (150 MiB) | 2139095040 (2040 MiB) |
| Multipart reserve at a 2048M POST limit | Ad hoc request allowance | 8388608 (8 MiB) |

Legacy video editing previously had a separate 50000 KiB validator. It now uses the shared effective policy; audio editing also gains explicit size/type checks. Those single-media fields still accept one file, not twenty.

LESSON_CONTENT_MAX_FILES, LESSON_CONTENT_MAX_FILE_BYTES and LESSON_CONTENT_MAX_TOTAL_BYTES remain supported. Existing environment overrides take precedence over defaults. LessonContentLimits caps application settings against the actual PHP upload, POST and file-count limits. The POST reserve is proportional for smaller PHP limits, bounded by the configured 8 MiB maximum. All UI byte attributes/messages and server validation use this service. A 64-bit PHP runtime is required.

The observed local PHP 7.4.33 x64 has upload_max_filesize=128M and post_max_size=140M, not the reported production limits. Its effective limits are 20 files, 134217728 bytes/file and 145332633 aggregate bytes. No PHP, .env or .env.example settings were changed. The large isolated tests inject the reported hosting policy into the test container only.

## Exact protected Files extension inventory

Extensions are case-insensitive. Matching MIME/content checks are also required; an extension alone does not authorize a file.

```text
txt csv tsv sha256sum md markdown rst log ini conf cfg properties yaml yml
tex bib cls sty srt vtt ass ssa
html htm css scss sass less js mjs cjs jsx tsx ts php phps py java c cc cpp
cxx h hpp cs sql sh bash bat cmd ps1 r rb go rs swift kt kts lua pl dart asm
vue svelte json ipynb gltf xml svg
pdf rtf doc dot xls xlt ppt pot pps docx dotx docm dotm xlsx xltx xlsm xltm
pptx potx ppsx pptm potm ppsm odt ods odp odg ott ots otp odf epub
jpg jpeg png gif webp tif tiff bmp ico heic heif avif
mp4 m4v mov webm mkv avi wmv mpeg mpg 3gp ogv mts m2ts
mp3 wav m4a aac ogg opus flac wma aif aiff mid midi
zip rar 7z tar gz tgz bz2 xz
ttf otf woff woff2 eps ps ai dxf dwg stl obj scad step stp glb
```

TS supports textual TypeScript or validated MPEG transport-stream content. Header checks cover ISO media containers, MPEG-TS, EBML, OLE, RTF, fonts, DWG, STL and GLB where applicable. Office/OpenDocument/EPUB packages receive bounded ZIP metadata validation and required-entry checks. Macro packages require their explicit macro extension; ordinary DOCX/XLSX/PPTX do not silently accept macros.

## Security and compatibility boundaries

- New source, SVG, HTML, scripts, macro documents, archives, fonts and design assets use generated opaque .bin names on the existing private disk. Original names remain display/download metadata, never paths. Existing legacy names, paths and records are not rewritten.
- Active content always downloads as an attachment, including the /view endpoint, with nosniff, private/no-store and sandbox headers. It is not rendered as an authenticated same-origin document. Authorization and current/history access rules are unchanged.
- Verified image/PDF/audio/video previews retain protected delivery and BinaryFileResponse streaming/range support. Browser codec/container support varies; download remains available.
- Public legacy video/audio paths remain public media paths; source/document formats are not added to them. The feature-disabled legacy Files handler, homework/test uploads, Student submissions, Admin uploads and legacy mobile API are not expanded by this work. Do not use those older public paths to upload source code.
- EXE, DLL, COM, SCR, MSI, APK, JAR, PHAR, PHTML and unknown extensions are excluded. Leading executable binary signatures, MIME/extension disagreement, invalid packages, path traversal and invalid/empty uploads are rejected. ZIP entry count/uncompressed size are bounded; traversal, encrypted entries and executable entries are rejected. Nothing is extracted.
- This is not antivirus, a complete file decoder or a document sanitizer. RAR/7z/compressed-stream checks are MIME/signature checks, not a recursive content inspection. Explicitly downloadable macros/scripts can still be dangerous if opened/executed on a recipient's own computer. Unsupported formats must not be renamed to bypass validation.
- Partial batches are rejected before storage. Existing private transaction/journal/idempotency compensation is retained. Legacy audio/video failures compensate only newly written unowned files; replacements no longer delete the previous video before saving. Previous files are retained, not migrated or purged.
- There is no chunking, background upload or new progress UI. Existing native form/error behavior remains. A request lost after persistence must still be retried using the existing protected upload token.

## Verification evidence

All mutation tests used SQLite memory or new guarded disposable MariaDB databases and temporary storage. The MariaDB runner copied schema definitions, not school data, and did not invoke migrations. School access was SELECT/SHOW only. Local MariaDB briefly stopped responding during the work; the owner restored availability. No service restart, database-file repair or configuration change was performed by this implementation.

- Focused PHP regression run: 287 tests, 7422 assertions, zero failures, one intentional opt-in large-file skip (286 tests passed). Coverage includes Gradebook, zeroes/history, assessments/templates, transfers/visits, rosters, follow-ups, privacy, login/navigation and lesson views.
- Dedicated SQLite large-file run: one test, 14 assertions, passed. Real 2139095040-byte input, private stored size and SHA-256 checked, oversized/aggregate rejection and dedicated fixture removal checked. Peak PHP allocation: 35651584 bytes.
- Disposable MariaDB full media run with --large-file: 235 cumulative assertions passed, including 93 existing student/grade/upload/transfer assertions. Database aladham_student_workflow_test_594c3cc8394efe83, MariaDB 10.4.32. Real 2139095040-byte storage/hash test passed; measured upload/hash/boundary/cleanup section 74.92 seconds, peak PHP allocation 44040192 bytes. A separate ordinary media run passed 229 assertions.
- Actual application HTTP-kernel routes tested for protected active-source delivery, original bytes, Teacher/Student/guest/Admin/foreign-section authorization, Office/ODF/EPUB, twenty/twenty-one files, malformed/mixed batches, selected-count truncation, rollback, legacy media replacement and video byte-range responses. These tests construct UploadedFile objects; they do NOT prove that a 2 GB multipart body passed a browser, PHP Web upload parser, proxy or Hostinger.
- Representative policy fixtures cover text/source, PDF, image, WAV, gzip, font and design formats. Executable-prefix spoofing is tested against every allowlisted extension. Not every binary format has a real end-user sample/decoder compatibility test.
- All 17 existing Node frontend test scripts passed, including size boundaries, selection/removal, BFCache, edit inputs, safe filename text and unrelated Gradebook/transfer UI regressions.
- Final focused rerun after the media MIME-alias response adjustment: 10 tests, 465 assertions, zero failures, one intentional large-file skip (separately verified above).
- PHP lint and strict UTF-8 without BOM checks passed for changed PHP/Blade files; git diff --check passed. Blade clear/cache ran in isolated storage. All changed compiled views linted successfully.
- Repository-wide compiled PHP scan: 784/787 passed. Three untouched pre-existing templates contain invalid directives: students/new_start_exam3.blade.php (empty if/elseif), coordinators/load_en.blade.php and acadsupervisors/load_en.blade.php (bare if). They were not changed as part of media uploads. Blade caching alone does not detect these syntax errors.
- Before/after ordered-row SHA-256 fingerprints matched for 24 school tables, including students/users, enrollment/placements/visits, marks/results/reports, follow-ups, invoices, lesson content, attachments, lectures, assignments and timetable. No existing school record or uploaded content was changed.
- A read-only HEAD to a known existing local private-storage URL returned 404. This checks the local exposure boundary only, not hosting aliases.
- No graphical browser sessions were available. Actual authenticated visual acceptance, native file-picker behavior and Hostinger upload ingress remain manual checks.

Reproduction commands (supply the existing nonce-protected test storage and isolated SQLite INI for PHPUnit):

```powershell
C:\php74\php.exe vendor/phpunit/phpunit/phpunit --do-not-cache-result tests/Feature/TeacherMediaPolicyTest.php
C:\php74\php.exe vendor/phpunit/phpunit/phpunit --do-not-cache-result --filter test_media_ tests/Feature/GradebookSafetyTest.php
# Opt in to the real 2040 MiB SQLite disk test with ALADHAM_LARGE_MEDIA_TEST=1.
C:\php74\php.exe tests/Integration/teacher-media-mariadb.php --create-disposable-database --large-file
node tests/Frontend/lesson-upload-selection.test.js
```

The older lesson-content migration lifecycle runner was not executed because this request did not approve migrations. Its old unsupported-PHP-source fixture was changed to an unsupported executable; its explicit smaller-limit fixtures remain independent of CLI PHP caps. The current DDL-copy runner and SQLite suites cover the modified upload paths without operational migration execution.

## Hosting acceptance and required settings

Under the OWNER-REPORTED upload_max_filesize=2048M, post_max_size=2048M, max_file_uploads=20 profile, the application default permits 2040 MiB, not exactly 2 GiB. No additional PHP limit increase is required for that target if those are the effective Web values and no lower request cap exists. Review existing LESSON_CONTENT_MAX_* overrides and refresh the deployment's configuration cache through the normal approved process; this implementation did not do so on production.

A full 2147483648-byte file requires application file/aggregate limits at least 2147483648, PHP upload_max_filesize at least 2048M and post_max_size at least 2056M for this 8 MiB reserve. If the Hostinger plan caps POST at 2048M, exact 2 GiB cannot fit in one conventional multipart POST on that plan. Do not advertise it or bypass validation. Hostinger plan limits and other ingress limits require owner verification.

Verify effective Web-SAPI values, 64-bit PHP, fileinfo, ZipArchive, temporary upload directory, private disk and journal write permissions. Allow at least two payload copies (PHP temporary file and destination: roughly 4.3 GB decimal for one maximum request), plus concurrency/headroom and inode/quota allowance. Retained previous legacy media files also consume storage. Memory need not equal upload size; measured streaming memory was under 43 MiB, but other application load still needs normal headroom.

Receiving 2040 MiB within 360 seconds requires approximately 47.5 Mbit/s sustained before overhead; slower users may exceed max_input_time or reverse-proxy timeouts. Check hosting/Web server/WAF request-body caps, execution/input/proxy timeouts and storage performance. Do not automatically raise them or assume a settings screen overrides plan limits. See [PHP upload pitfalls](https://www.php.net/manual/en/features.file-upload.common-pitfalls.php) and [Hostinger hosting parameters](https://www.hostinger.com/support/6976044-parameters-and-limits-of-hosting-plans-in-hostinger/).

Manual acceptance: use an authorized fixture lesson/student; upload a single existing format, a mixed private source/document group and a real large video; verify selection messages, exact downloaded bytes, safe forced source downloads, media range playback, twenty-file boundary, retry/rollback errors and unchanged legacy links. Confirm private paths cannot be served by direct public URLs. Do not run this against real school content without separate authorization.

## Changed files

- app/Exceptions/Handler.php
- app/Http/Controllers/LessonContentController.php
- app/Http/Controllers/TeacherController_New.php
- app/Services/LessonContentFileTypes.php (new)
- app/Services/LessonContentInput.php
- app/Services/LessonContentLimits.php
- app/Services/TeacherLessonMedia.php (new)
- config/lesson_content.php
- public/teachers_2/assets/js/lesson-upload-selection.js
- resources/lang/ar/lesson_content.php
- resources/lang/en/lesson_content.php
- resources/views/teachers2/teacher_addcontent.blade.php
- resources/views/teachers2/teacher_edit_video.blade.php
- resources/views/teachers2/teachers_edit_audio.blade.php
- resources/views/teachers2/partials/lesson_media_limits.blade.php (new)
- tests/Concerns/TeacherMediaUploadChecks.php (new)
- tests/Feature/GradebookSafetyTest.php
- tests/Feature/TeacherMediaPolicyTest.php (new)
- tests/Frontend/lesson-upload-selection.test.js
- tests/Integration/lesson-content-cases.php
- tests/Integration/lesson-content-mariadb.php
- tests/Integration/quiz-upload-capacity.php
- tests/Integration/teacher-media-mariadb.php (new)
- docs/audits/teacher-media-capacity-and-file-types-2026-11-25.md (this report)

Application implementation and isolated large-file acceptance are complete. Production readiness remains conditional on actual hosting/browser verification. No production changes, school writes, migrations, environment changes, commits, pushes or deployment were performed.
