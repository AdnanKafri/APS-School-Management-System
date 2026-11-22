# Quiz repair and Teacher media capacity

Date: 2026-11-18. Local implementation; no production access or deployment.

## Confirmed quiz failure

Read-only queries against local `aladham_oct` on 127.0.0.1:3306 found:

| Quiz | Section | Actual term | Maximum | Results | Published | Student files |
|---|---|---|---|---|---|---|
| 2486, Mathematics | 132 | 20 | 100 | 0 | 0 | 0 |
| 2492, Mathematics | 132 | 20 | 50 | 20 | 20 | 0 |

Quiz 2486 has an `assessment_equivalence_members` entry in a six-section identity containing quizzes 2486-2491. The entire identity has no `exam_result2`, `exams_files`, `exam_questions`, `exam_result_tester` or `exam_student_lesson` entries. The year is 6 (2026/2027), actual current term 20. An older year's current-term marker is not used.

The edit modal, maximum field, POST route, AJAX feedback and deletion confirmation already exist. The failure is the safety contract: `AssessmentResultSafety::hasRecords()` treats equivalence membership alone as retained activity. Both `AdminAssessmentInput` and model update/delete hooks therefore refuse an unused shared quiz. The foreign key is deliberately RESTRICT, so bypassing the guard would still fail deletion. This repair does not bypass the constraint or disable the global model hooks.

The existing account-specific deletion code remains required. An incorrect/missing code produces its existing Arabic validation error. The shared editor displays 422 errors in the modal; the confirmed unused shared assessment was a protected backend rejection, not a missing click handler.

## Approved independent maintenance contract

For Admin quiz deletion or maximum-score changes, `UnusedQuizMaintenance` runs inside the existing transaction with the target definition locked:

1. Require the actual active year/current term and matching section/class. Protect historical definitions and dynamic Gradebook containers.
2. Lock and validate the complete existing equivalence identity, if present. Protect malformed contexts and any group containing retained activity.
3. Check results/attempts, question references, submitted files and other modern exam dependencies. Explicit zero is a real mark. Published NULL results, answers, attempts/timestamps, status, medals and context mismatches also protect the quiz.
4. Only unattempted, unpublished NULL/empty scaffolds can be removed. They are never converted into grades.
5. Withdraw only the unused target's equivalence member. Do not change peer definitions, maxima, results or member metadata. A remaining singleton identity stays valid for normal continuity reads.
6. Apply the existing validation/save or guarded deletion. Roll back the withdrawal, scaffolds and definition together on failure.

No group maximum is changed in bulk. Existing used identities remain protected. Direct model/bulk deletion is still guarded; the approved withdrawal applies only through the explicit Admin transaction. The owner's quiz 2486 remains 100, with its original six-member identity; automated writes use disposable fixtures only. Quiz 2492 and its published results remain intact.

## Upload configuration and flow

Central configuration defaults, approved by the owner:

| Environment option | Default | Meaning |
|---|---|---|
| `LESSON_CONTENT_MAX_FILES` | 30 | Files in one private group |
| `LESSON_CONTENT_MAX_FILE_BYTES` | 104857600 | 100 MiB per file |
| `LESSON_CONTENT_MAX_TOTAL_BYTES` | 157286400 | 150 MiB combined file bytes |

`LessonContentLimits` validates positive finite integer settings and produces localized help/errors. The private validator, declared attachment count, HTML data attributes, filename-selection JavaScript and visible help use these settings. Multipart metadata gets a separate 1 MiB request allowance. A zero-length file is still rejected.

The Files tab accepts a video as an attachment in the existing private parent/ordered-attachments system. Validation precedes storage; hashes are streamed from files; journaling, idempotency, database transactions, rollback compensation and ownership checks remain in place. No upload contents are copied into PHP strings by application code. Large requests still use a conventional multipart POST; no chunking/transcoding/cloud service was introduced.

The separate legacy Video tab had a hardcoded Laravel `max:50000` KiB and a 50M label. It now uses the central byte limits while retaining its original single-file form, MIME rules, type-0 records, public disk and links. It does **not** acquire private grouped storage or journaling by changing its size limit. Use the Files tab for private grouped videos. Existing public videos and legacy API serialization remain unchanged. Any future conversion of legacy media storage needs a separate approved design.

Accepted private video extensions/MIME combinations remain MP4 (`video/mp4`), MOV (`video/quicktime`), AVI (`video/x-msvideo` or `video/avi`) and MPEG (`video/mpeg`). The legacy Video tab retains its narrower original MIME list: MP4, `video/avi`, MPEG. Actual MP4s are tested; MOV/AVI/MPEG codecs and playback are not certified by this pass.

The existing authorized private view endpoint now uses inline disposition for those video MIME types. Download mode still forces attachment. BinaryFileResponse provides streaming and Range responses after the existing Teacher/Student authorization. No private directory is made public. Video responses retain sandbox/default-deny CSP and allow same-origin media. Browser codec/player/CSP visual acceptance remains pending.

Oversized PHP POSTs on this Teacher upload endpoint get an Arabic 413 response, including JSON where requested, without exposing exception details. PHP per-file size errors get a localized validation message. Truncated file lists are rejected by the declared-versus-received attachment count. Reverse-proxy rejections before PHP cannot be localized by Laravel.

## Local and Hostinger capacity requirements

The normal local PHP executable is `C:\php74\php.exe`, version 7.4.33; the inspected configuration is `C:\php74\php.ini`. The process serving port 8000 uses that executable and this project. CLI inspection reports upload_max_filesize 128M, post_max_size 140M, max_file_uploads 20, memory_limit 256M, upload_tmp_dir unset (system temporary directory). CLI execution/input time values do not establish FPM/Web limits. No PHP configuration, .env or server-wide setting was changed.

Read-only local storage checks found the configured private root and journal directory writable and outside `public`, and the system temporary directory writable. There were 170 active attachment metadata rows but none of those paths existed in the local private disk; the directory contained eight files. The reason for this local DB/file mismatch is unconfirmed (no assumption of production-file synchronization). These rows/paths/files were not repaired, deleted, copied or reclassified. Real existing-content downloads cannot be certified against missing local bytes; fixture byte comparisons are a separate result.

Consequently the normal local server cannot receive a complete 30-file/150 MiB request with those settings. The application detects truncation/oversize instead of reporting success. The isolated multipart tests use a separate loopback server, fixture DB and storage, explicit process-only `upload_max_filesize=100M`, `post_max_size=160M`, `max_file_uploads=30`, `max_execution_time=120`, `max_input_time=600`. They do not reconfigure/restart port 8000.

Large multipart bodies take substantial CPU/time in the Windows PHP 7.4 development server before the fixture router/Laravel is entered; initial tests with a 120-second client deadline timed out there. This transport limitation must be distinguished from a validation/storage failure. Raising application limits alone does not establish upload reliability for every network/server.

Before production activation, the owner must verify in Hostinger hPanel and the selected site's PHP configuration (CLI php -i alone is insufficient):

- upload_max_filesize >=100M; post_max_size at least 151M, preferably 160M for multipart overhead; max_file_uploads >=30. Confirm effective values and cached application configuration.
- The hosting plan and web server/proxy/WAF permit a request of at least 160 MiB. Ask Hostinger for the actual body-size limit; no provider limit is assumed here.
- Input/proxy/client timeouts allow the expected connection speed and file count. At 5 Mbps, 150 MiB takes roughly four minutes before processing; a fixed short timeout will fail even when sizes are valid. Confirm plan-enforced ceilings rather than blindly copying fixture timeouts.
- PHP upload temporary storage and `storage/app/lesson-content-private/{files,journals}` have capacity and write access for the PHP user. Budget simultaneous temporary and final copies (about 300 MiB per maximum request, plus concurrency/headroom). Keep private storage outside document-root/public symlinks; inspect the customized public_html layout. Do not use chmod 777.
- Confirm current additive attachment/parent schema, UTF8MB4 note support and feature flag as described by the existing activation runbooks. This task adds no migration and runs none on the school DB.
- Deploy code together with the updated JavaScript asset version; refresh configuration/view cache through the established deployment process. Do not copy fixture storage, databases, logs, router scripts, cookie files or test media to hosting.
- Owner-approved real Teacher/Student testing must verify upload completion, authorized Range/view/download, seeking/playback, expired sessions and denied access on the actual hosting plan. No production operation was performed here.

## Verification and limitations

The real local routes were rendered by the application under a read-only DB transaction, using existing Admin/Teacher identity in the CLI harness: Admin room-132 quiz listing 200 with edit/delete modals; Teacher 166 upload page 200 with 30 / 104857600 / 157286400 data attributes. This is server-render verification, not authenticated graphical browser acceptance. No browser surface was connected.

Disposable MariaDB coverage includes independent and shared-unused 100-to-50 edits/deletes; unchanged peer rows/member metadata; remaining singleton; actual zero/nonzero marks; publication, answers, attempts, submissions/question/history dependencies; unauthorized requests; and forced edit/delete rollback restoring all three record types. Existing Gradebook tests also check deletion code, CSRF, errors, continuity and protected results.

Upload fixtures cover the previous 5/10/25 profile, the new 30/100/150 profile and plus-one boundaries, MIME spoofing, private/legacy single and multiple files, PHP limit errors, post-storage rollback, idempotency/concurrency, PDF/image/Office security regressions, Unicode and legacy compatibility. Real MP4 inputs are a 31,603-byte WPT test movie and the unchanged 50,801,758-byte repository background video. Larger multipart fixtures append a valid MP4 free box to a test copy, preserving encoded video bytes; no school file is changed. Source for the small test media: https://raw.githubusercontent.com/web-platform-tests/wpt/master/media/movie_5.mp4 (downloaded only to temporary test storage, not bundled/deployed).

MP4 view/download responses and exact 206 byte-range bytes are verified. Graphical playback/seeking on desktop/iOS/Android and production timeout/body limits remain manual acceptance requirements. No claim of verified Hostinger capacity or graphical playback is made.

Test commands and results:

- `C:\php74\php.exe tests/Integration/lesson-content-mariadb.php --create-disposable-database`, with `ALADHAM_RUN_HTTP_CAPACITY=1` and `ALADHAM_SMALL_MP4_FIXTURE` pointing to the temporary WPT movie: **388 assertions passed**, disposable DB `aladham_lesson_test_18c74198321e3a01`. Includes real HTTP 30-file and small/48.4 MiB MP4 uploads with real CSRF session/cookies. The maximum-body transport gate is separately opt-in with `ALADHAM_HTTP_MAXIMUM_GATE=1`; it takes several minutes on this Windows PHP development server.
- Extended real multipart run: **386 assertions passed**, disposable DB `aladham_lesson_test_ef98212738abc28d`. Includes actual 150 MiB multipart persistence, exact attachment-byte totals, real PHP rejection of a file exceeding 100 MiB and a real oversized-request Arabic 413 response. This run preceded the additional small/48.4 MiB HTTP checks and six-section test case; its assertion count is therefore different. The 150 MiB request took about 406 seconds before router entry, then about 2.6 seconds inside Laravel. No normal-server setting was changed.
- Final application/DB run after adding the six-section reproduction and legacy invalid-upload guard: **391 assertions passed**, disposable DB `aladham_lesson_test_9f82794368ee100c`. This run explicitly skipped the optional HTTP gate; the independent HTTP results above are not being counted as part of its 391 assertions.
- Full `GradebookSafetyTest`: **100 tests / 2,270 assertions passed**. The installed SQLite extensions were loaded only through a temporary test-process INI scan directory; the normal PHP configuration was untouched.
- `LessonWorkspaceViewTest`: **9 tests / 315 assertions passed** in isolated storage.
- `lesson-upload-selection.test.js`, `lesson-content-management.test.js`, `assessment-editor.test.js`: passed.
- PHP lint on all changed PHP/Blade/lang/test files, JavaScript syntax, all-view compilation to isolated compiled-view storage, UTF-8 without BOM and `git diff --check`: passed.

The server rejection path for invalid legacy Video-tab PHP uploads is also guarded before a blank content row could be saved. Its prior missing/invalid-file branch could otherwise skip file handling and reach the normal save/success path.

Exact changed files:

- app/Exceptions/Handler.php
- app/Http/Controllers/DashboardController.php
- app/Http/Controllers/TeacherController_New.php
- app/Http/Controllers/LessonContentController.php
- app/Services/AssessmentContinuityService.php
- app/Services/UnusedQuizMaintenance.php
- app/Services/LessonContentLimits.php
- app/Services/LessonContentInput.php
- config/lesson_content.php
- resources/lang/ar/assessment_entry.php
- resources/lang/en/assessment_entry.php
- resources/lang/ar/lesson_content.php
- resources/lang/en/lesson_content.php
- resources/views/teachers2/teacher_addcontent.blade.php
- public/teachers_2/assets/js/lesson-upload-selection.js
- tests/Feature/GradebookSafetyTest.php
- tests/Frontend/lesson-upload-selection.test.js
- tests/Integration/lesson-content-mariadb.php
- tests/Integration/quiz-upload-capacity.php
- tests/Integration/lesson-content-http-capacity.php
- docs/audits/quiz-repair-and-media-capacity-2026-11-18.md

No real school record, stored upload, schema, environment file, mobile API contract or production configuration was modified. No commit, push or deployment.
