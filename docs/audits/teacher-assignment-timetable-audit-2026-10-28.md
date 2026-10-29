# Admin timetable vs Teacher assignments: read-only audit

Date: 2026-10-28 (Asia/Damascus). Project: `C:\Users\Lenovo\Desktop\aladhamedu`.
Scope: current code and the configured local database, not production. Only this report may be written.

## Executive summary

The Admin timetable and Teacher responsibilities are **different records with one-way synchronization**. Timetable save updates a weekly period in `lesson_room_teacher_lecture_time` and ensures a corresponding annual `teacher_room_lesson` responsibility exists. Replacing or deleting a period does **not** retire the former responsibility. The main Teacher dashboard and subject/grading navigation read the responsibility table; the weekly timetable reads period records. Both can therefore be internally faithful to their queries while disagreeing with each other.

Read-only SELECT queries against local `aladham_oct` (MariaDB 10.4.32) verified:

- Active year: **6, 2026/2027**. Its current term: **20, فصل أول 26-27**.
- Seven unique Teacher/account pairs were inspected. Six requested names matched exactly after Arabic normalization. The seventh is the only candidate for “باسل سلوم”, stored as **باسل السلوم**, Teacher 139 / User 1243. That article difference is explicitly disclosed; no accounts were merged and personal identity beyond the database match was not assumed.
- The seven inspected accounts have **72 distinct current responsibilities**, **51 matching scheduled identities**, and **113 weekly periods**.
- **21 responsibility identities have no current timetable period for that Teacher**. Each is scheduled to another Teacher. There are **zero reverse cases** where one of these Teachers has a current period without the matching responsibility.
- Those 21 rows have **21 open assignment-history periods**. They are operational current-year grants, not closed historical assignments.
- Across the school, current year contains **621 responsibilities**, **578 scheduled identities / 1,372 periods**, and **43 responsibilities without current-term periods**. Absence from a timetable is not by itself proof that a responsibility is unauthorized.
- The supplied example section **130 (الصف الأول / الأول - أولى)** is consistent: **13 responsibility identities and 30 periods**. عدنان كفري matches through responsibility **1458** and period **4122**.
- Main web dashboard scoping is correct for the active year. Confirmed additional legacy issues include an inflated timetable section counter, an unscoped layout helper, mobile/API year/term differences, and assignment-authorization gaps in specific legacy endpoints.

**Severity:** P1 operational divergence for the 21 listed identities; potential improper academic access if staff confirm those responsibilities have ended. Separate P0 authorization gaps are confirmed in the legacy route/controller code, without exercising them. There is no evidence here of abuse or of incorrect marks already written.

**Do not automatically delete all unscheduled responsibilities.** The application supports responsibilities without periods and multiple Teachers for a subject. The database has no reliable distinction between an intentionally retained manual grant and a responsibility left behind by a period edit.

## Evidence and audit limits

- The PHP process listening on port 8000 is `C:\php74\php.exe -S 127.0.0.1:8000 C:\Users\Lenovo\Desktop\aladhamedu\server.php`: the requested project is serving the example URL.
- No cached routes or cached config were present in `bootstrap/cache`; only the normal packages/services manifests were present.
- Database access used direct PDO and **SELECT statements only**, including `information_schema` inspection. No Laravel request handlers, migrations, seeders, tests, cache clearing, application edits, or data-repair scripts were run.
- Browser inventory contained no connected browsers or apps. “Displayed” results below mean verified SQL results traced to the active controller/Blade, not screenshots or authenticated browser acceptance.
- In particular, the Follow-up roster GET can synchronize an assignment period ([app/Http/Controllers/TeacherStudentFollowUpController.php:70](C:/Users/Lenovo/Desktop/aladhamedu/app/Http/Controllers/TeacherStudentFollowUpController.php:70)). It was not invoked during this read-only audit.
- The working tree was recorded before inspection. Existing changes include `.env.example` and ongoing Gradebook work. They remain outside the audit write scope.
- Counts use `year + class + room + lesson + teacher`. Repeated day/period rows are counted separately, never mislabeled as duplicate responsibilities.
- Record timestamps were inspected as returned by MariaDB. Assignment-period DATETIME values and row TIMESTAMP values are not treated as interchangeable timezone evidence. Without a timetable change log, timestamps do not prove who replaced whom.

## Architecture and source of truth

| Concept | Actual table/model | Relevant relationship / behavior |
|---|---|---|
| Teacher identity | `teachers` / `Teacher` | `users.teacher_id -> teachers.id`; Teacher login role is `users.type=1`. All seven inspected Teachers have `active=0`, the value the Admin timetable treats as eligible. |
| User account | `users` | Each inspected Teacher has exactly one linked account; no Teacher/User ID substitution was found. |
| Grade | `classes` / `Classe` | Subject definitions belong to a grade through `lessons.class_id`. |
| Section | `rooms` / `Room` | A section has its own `class_id` and `year_id`; room 130 belongs to year 6 / class 1. |
| Subject | `lessons` / `Lesson` | Compare the class-specific lesson ID, not the translated subject name or base-subject name. |
| Official operational responsibility | `teacher_room_lesson` / `Teacher_room_lesson` | Teacher + lesson + room + class + year; **no term, active flag, effective dates, or soft-delete column**. Grade-lock fields such as `quize_status` are not assignment-active flags. Row existence is the principal web authorization source. |
| Responsibility history | `teacher_assignment_periods` / `TeacherAssignmentPeriod` | Snapshot of Teacher/lesson/year/class/room and pivot ID with effective start/end. Open periods support Follow-up authorization; they do not replace the pivot in dashboard/grading queries. |
| Weekly period | `lesson_room_teacher_lecture_time` / `Lesson_room_teacher_lecture_time` | Teacher + lesson + room + lecture-time slot + day + year + term, plus optional meeting link. Not an FK reference to a responsibility ID. |
| Bell-time slot | `lecture_times` / `Lecture_time` | Section-specific start/end and instructional `type=1`; multiple weekly periods for one subject are valid. |
| Teaching content | `lectures`; `lesson_teacher_room_term_exam` | Independent lesson/content/assessment records, not bell slots or responsibility declarations. |
| Current academic context | `years`, `term_years` | Main web code selects current year first, then current term within that year. Responsibility membership is annual; scheduled periods and assessment operations are term-specific. |

No separate canonical `teacher_subject` or `teacher_room` table drives these web pages. `Teacher::rooms()`, `Teacher::lessons()`, `Room::teachers()`, and related Lesson relationships are different Eloquent views of `teacher_room_lesson`. Legacy content/assessment relations and API queries form additional overlapping readers.

Evidence: [app/Teacher.php:28](C:/Users/Lenovo/Desktop/aladhamedu/app/Teacher.php:28), [app/Teacher.php:34](C:/Users/Lenovo/Desktop/aladhamedu/app/Teacher.php:34), [app/Room.php:52](C:/Users/Lenovo/Desktop/aladhamedu/app/Room.php:52), [app/Lesson.php:64](C:/Users/Lenovo/Desktop/aladhamedu/app/Lesson.php:64), [app/Teacher_room_lesson.php:7](C:/Users/Lenovo/Desktop/aladhamedu/app/Teacher_room_lesson.php:7), [app/Lesson_room_teacher_lecture_time.php:7](C:/Users/Lenovo/Desktop/aladhamedu/app/Lesson_room_teacher_lecture_time.php:7).

The source of truth established by actual authorization code is the **annual responsibility pivot**. The timetable is the source of truth for **when a Teacher teaches** and can add a responsibility. It is not implemented as the sole authority for all subject access. A future business decision to make it the sole authority would be a behavior change, not a harmless display repair.

## Actual request and update workflow

### Admin section timetable

1. `GET /SMT/admin/classroom/workschedule_exam/{room_id}` is registered in [routes/admin.php:695](C:/Users/Lenovo/Desktop/aladhamedu/routes/admin.php:695), under `web/auth/roleadmin` ([routes/admin.php:11](C:/Users/Lenovo/Desktop/aladhamedu/routes/admin.php:11)).
2. `DashboardController::workschedule_exam()` resolves year 6, term 20, and a room in that year. It loads subjects by the room's class, Teachers with `active=0`, room-specific slots, days, and timetable rows by room/year/term ([app/Http/Controllers/DashboardController.php:7524](C:/Users/Lenovo/Desktop/aladhamedu/app/Http/Controllers/DashboardController.php:7524)).
3. The returned view is `admin.workschedule_exam`. Each cell reads the supplied schedule collection by day and slot, displays the stored Teacher, and places the existing schedule ID/lesson ID/Teacher ID in the edit payload ([resources/views/admin/workschedule_exam.blade.php:745](C:/Users/Lenovo/Desktop/aladhamedu/resources/views/admin/workschedule_exam.blade.php:745)).
4. The form posts to `POST /SMT/admin/save_schedule` (`save.schedule`, [routes/admin.php:489](C:/Users/Lenovo/Desktop/aladhamedu/routes/admin.php:489)). CSRF, room ID, `schedule_context=exam`, day, slot, and `lesson[i][schedule_id|lesson_id|teacher_id]` are submitted ([resources/views/admin/workschedule_exam.blade.php:816](C:/Users/Lenovo/Desktop/aladhamedu/resources/views/admin/workschedule_exam.blade.php:816), [resources/views/admin/workschedule_exam.blade.php:989](C:/Users/Lenovo/Desktop/aladhamedu/resources/views/admin/workschedule_exam.blade.php:989)). The “exam” context selects the return page, not a second assignment table.
5. The controller validates active year/current term, section/year, slot/section/instructional type, lesson/class, active Teachers, and slot IDs. Language/religion split subjects can share a slot; duplicate Teacher use within a slot is rejected. Collision checks consider overlapping current-year/current-term periods with valid supporting responsibilities ([app/Http/Controllers/DashboardController.php:6925](C:/Users/Lenovo/Desktop/aladhamedu/app/Http/Controllers/DashboardController.php:6925), [app/Http/Controllers/DashboardController.php:7065](C:/Users/Lenovo/Desktop/aladhamedu/app/Http/Controllers/DashboardController.php:7065)).
6. A database transaction locks the existing timetable slot rows, preserves linked meeting rows against removal, removes omitted schedule rows, and executes `Teacher_room_lesson::firstOrCreate(...)` for each submitted assignment. It then updates or creates the period ([app/Http/Controllers/DashboardController.php:7120](C:/Users/Lenovo/Desktop/aladhamedu/app/Http/Controllers/DashboardController.php:7120), [app/Http/Controllers/DashboardController.php:7153](C:/Users/Lenovo/Desktop/aladhamedu/app/Http/Controllers/DashboardController.php:7153)).
7. **Nothing in that transaction removes the former Teacher's responsibility or closes its history period.** A retained schedule ID can change Teacher while the former pivot survives. The separate period-delete action likewise deletes only one schedule row ([app/Http/Controllers/DashboardController.php:7339](C:/Users/Lenovo/Desktop/aladhamedu/app/Http/Controllers/DashboardController.php:7339)).
8. Model creation opens a responsibility period through `TeacherRoomLessonObserver::created`. Deleting a pivot through the model closes its period; schedule edits/deletions do not fire that pivot deletion observer ([app/Observers/TeacherRoomLessonObserver.php:10](C:/Users/Lenovo/Desktop/aladhamedu/app/Observers/TeacherRoomLessonObserver.php:10), [app/Services/TeacherAssignmentPeriodService.php:12](C:/Users/Lenovo/Desktop/aladhamedu/app/Services/TeacherAssignmentPeriodService.php:12), [app/Providers/AppServiceProvider.php:31](C:/Users/Lenovo/Desktop/aladhamedu/app/Providers/AppServiceProvider.php:31)).
9. Success is returned after the transaction and a fresh read of saved period rows. AJAX refreshes the timetable cell using server data ([app/Http/Controllers/DashboardController.php:7193](C:/Users/Lenovo/Desktop/aladhamedu/app/Http/Controllers/DashboardController.php:7193), [resources/views/admin/workschedule_exam.blade.php:1097](C:/Users/Lenovo/Desktop/aladhamedu/resources/views/admin/workschedule_exam.blade.php:1097)). There is no demonstrated false period-save persistence; success simply does not promise that old academic responsibilities were retired.
10. Teacher pages query the database on each request. No assignment cache/session refresh mechanism is involved.

### Separate responsibility-management workflow

The active Admin Teachers view links to `/SMT/admin/teacher/set_task/{teacher_id}` ([resources/views/admin/teacher.blade.php:1077](C:/Users/Lenovo/Desktop/aladhamedu/resources/views/admin/teacher.blade.php:1077)).

The later route declarations resolve to `admincontroller::set_task/store_set_task/edit_task/update_set_task` with `can:set_task` or `can:edit_task` ([routes/admin.php:259](C:/Users/Lenovo/Desktop/aladhamedu/routes/admin.php:259)). Earlier same-method/same-URI declarations pointing at DashboardController still exist at lines 206/208 and are shadowed by the later route registrations. They are a maintenance hazard, not evidence that the example timetable uses a different view.

`set_task` explicitly distinguishes a current responsibility from `has_current_term_schedule` ([app/Http/Controllers/admincontroller.php:1305](C:/Users/Lenovo/Desktop/aladhamedu/app/Http/Controllers/admincontroller.php:1305)). This is strong evidence that an unscheduled responsibility is a supported state.

`syncTeacherAssignmentPlan` validates class/lesson/current-year section pairs, locks the Teacher's current-year pivots, keeps selected pairs, removes deselected/duplicate pivots through model deletion, and adds missing pairs inside a transaction. It **blocks removal if any timetable period remains for that pair in the year**, even another term. It does not remove periods automatically ([app/Http/Controllers/admincontroller.php:1374](C:/Users/Lenovo/Desktop/aladhamedu/app/Http/Controllers/admincontroller.php:1374), [app/Http/Controllers/admincontroller.php:1461](C:/Users/Lenovo/Desktop/aladhamedu/app/Http/Controllers/admincontroller.php:1461)).

Thus a period edit can succeed and the dashboard retain a former responsibility until this separate responsibility plan is explicitly updated. The code supports this outcome; it cannot tell which of the 21 rows staff still intend to authorize.

## Teacher-page source and authorization matrix

| Active page / operation | Data source and context | Authorization / discrepancy relevance |
|---|---|---|
| `/SMARMANger/teacher` | Authenticated account's Teacher; `currentTeacherRooms` from pivots and rooms in active year; distinct classes/rooms. | Current-year scope is correct. Additional live pivots create extra class/section cards. |
| `/SMARMANger/teacher_lessons2/{room}/{teacher}` | Pivots for authenticated Teacher + selected room + active year; unique lessons. | Route Teacher parameter is replaced with authenticated Teacher ID. Room grant required; no timetable requirement. |
| Content/lessons/books | Subject/room responsibility guard; `lectures` and content tables. Main lecture list filters content through active-year terms, not necessarily only the current term. | Stale current responsibility can still authorize content access/create. Existing record ownership and context checks vary by action; exceptions below. |
| `/SMARMANger/teacher/exams_quizes` | Same current rooms/classes as dashboard. | Subject responsibility list, not period list. |
| `/SMARMANger/teacher_marks_subjects/{room}/{teacher}` | Same active-year room pivots, unique lessons. | All 21 extra responsibilities remain in this source. |
| `teacher_exam`, `teacher_quize`, student grade entry | Room/lesson assignment, current term in active year, assessment room/lesson/class, current student membership. | Annual grant is an actual backend gate. No period requirement; grade locks and result/history safeguards still apply. |
| `mark_class`, `mark_room` | Current rooms and current room/subject pivots. | Same responsibility scope; report/mark editing retains its additional checks. |
| Advanced Gradebook | Exact Teacher/year/class/room/subject pivot, valid lesson/class, current term, current student membership; Gradebook read service. | Does not derive authority from timetable or fall back to old-year grants. Phase 1/2 files were not changed. |
| Teacher Student Follow-up | Current-year pivot joined to rooms/lessons; exact assignment validation, open responsibility period, operational current student membership. | The 21 open periods are still eligible responsibility contexts. Additional student/time/content checks remain. Roster GET can create a missing period and was not executed. |
| Weekly Teacher timetable | Period table for Teacher + active year/current term + valid current room/slot + existence of matching responsibility. | Shows the 51 scheduled identities / 113 periods, not all 72 responsibilities. Its room-count card separately uses the unscoped relation, a confirmed UI defect. |
| Admin Teacher timetable `/SMT/admin/teacher_schedule/{id}` | Same current period/room/slot/pivot-existence model. | Does not include an unscheduled grant just because it exists. |
| Rewards/sanctions navigation | Landing page uses current rooms. Subject list rechecks current room access, then uses an unscoped room/Teacher pivot query. | All current pivots are context-consistent in this DB, so the missing inner year condition is a latent hardening issue, not an extra verified mismatch. |
| Shared Teacher layout | Calls `available_schedule` with Teacher/day only and scans time slots. | Old rows can be selected. Returned variable is currently not rendered elsewhere in `teachers2`, so this is not proven to cause visible dashboard cards. |
| Mobile/API classes/sections | `Teacher::rooms()` filtered by room year; pivot year not explicitly checked. | Matches the current DB because all pivot/room years agree; remains less strict than the web helper. |
| Mobile/API subjects/content/timetable | Subjects use room/Teacher without year. Lessons use global first current term. Timetable filters room year/day/Teacher but not schedule year/term or responsibility existence. | Separate reader with confirmed term-selection inconsistency and authorization concerns below. |

Code evidence:
- Web routes: [routes/teacher.php:5](C:/Users/Lenovo/Desktop/aladhamedu/routes/teacher.php:5), [routes/teacher.php:12](C:/Users/Lenovo/Desktop/aladhamedu/routes/teacher.php:12), [routes/teacher.php:24](C:/Users/Lenovo/Desktop/aladhamedu/routes/teacher.php:24), [routes/teacher.php:66](C:/Users/Lenovo/Desktop/aladhamedu/routes/teacher.php:66), [routes/teacher.php:186](C:/Users/Lenovo/Desktop/aladhamedu/routes/teacher.php:186).
- Current assignment helpers: [app/Http/Controllers/TeacherController_New.php:169](C:/Users/Lenovo/Desktop/aladhamedu/app/Http/Controllers/TeacherController_New.php:169); dashboard: [app/Http/Controllers/TeacherController_New.php:1410](C:/Users/Lenovo/Desktop/aladhamedu/app/Http/Controllers/TeacherController_New.php:1410); subjects: [app/Http/Controllers/TeacherController_New.php:1461](C:/Users/Lenovo/Desktop/aladhamedu/app/Http/Controllers/TeacherController_New.php:1461).
- Timetable: [app/Http/Controllers/TeacherController_New.php:2488](C:/Users/Lenovo/Desktop/aladhamedu/app/Http/Controllers/TeacherController_New.php:2488); exam navigation: [app/Http/Controllers/TeacherController_New.php:2613](C:/Users/Lenovo/Desktop/aladhamedu/app/Http/Controllers/TeacherController_New.php:2613); marks subjects: [app/Http/Controllers/TeacherController_New.php:2654](C:/Users/Lenovo/Desktop/aladhamedu/app/Http/Controllers/TeacherController_New.php:2654); report navigation: [app/Http/Controllers/TeacherController_New.php:5213](C:/Users/Lenovo/Desktop/aladhamedu/app/Http/Controllers/TeacherController_New.php:5213).
- Modern assessment guards: [app/Services/TeacherAssessmentService.php:18](C:/Users/Lenovo/Desktop/aladhamedu/app/Services/TeacherAssessmentService.php:18); Advanced Gradebook: [app/Http/Controllers/Teacher/TeacherGradebookController.php:24](C:/Users/Lenovo/Desktop/aladhamedu/app/Http/Controllers/Teacher/TeacherGradebookController.php:24).
- Follow-up: [app/Http/Controllers/TeacherStudentFollowUpController.php:30](C:/Users/Lenovo/Desktop/aladhamedu/app/Http/Controllers/TeacherStudentFollowUpController.php:30), [app/Services/StudentFollowUpService.php:40](C:/Users/Lenovo/Desktop/aladhamedu/app/Services/StudentFollowUpService.php:40).
- Admin Teacher schedule: [app/Http/Controllers/DashboardController.php:12036](C:/Users/Lenovo/Desktop/aladhamedu/app/Http/Controllers/DashboardController.php:12036); rewards subjects: [app/Http/Controllers/TeacherController_New.php:6436](C:/Users/Lenovo/Desktop/aladhamedu/app/Http/Controllers/TeacherController_New.php:6436).
- Layout helper: [resources/views/teachers2/layouts/app.blade.php:5](C:/Users/Lenovo/Desktop/aladhamedu/resources/views/teachers2/layouts/app.blade.php:5), [app/Http/Controllers/TeacherController_New.php:3682](C:/Users/Lenovo/Desktop/aladhamedu/app/Http/Controllers/TeacherController_New.php:3682).
- API: [routes/api.php:145](C:/Users/Lenovo/Desktop/aladhamedu/routes/api.php:145), [app/Http/Controllers/Api/websitecontroller.php:126](C:/Users/Lenovo/Desktop/aladhamedu/app/Http/Controllers/Api/websitecontroller.php:126), [app/Http/Controllers/Api/websitecontroller.php:180](C:/Users/Lenovo/Desktop/aladhamedu/app/Http/Controllers/Api/websitecontroller.php:180), [app/Http/Controllers/Api/websitecontroller.php:199](C:/Users/Lenovo/Desktop/aladhamedu/app/Http/Controllers/Api/websitecontroller.php:199), [app/Http/Controllers/Api/websitecontroller.php:259](C:/Users/Lenovo/Desktop/aladhamedu/app/Http/Controllers/Api/websitecontroller.php:259).

## Teacher identity and comparison summary

All rows below use year **6 (2026/2027)** and schedule term **20**. No duplicate linked accounts were found. “Grant” means a distinct annual Teacher/section/subject responsibility, not a weekly period.

| Requested name | Stored name | Teacher ID | User ID / role | Current grants | Matched grants | Extra grants | Periods | Dashboard sections / scheduled sections |
|---|---|---:|---|---:|---:|---:|---:|---|

| شادن غنوم | شادن غنوم | 154 | 1258 / 1 | 10 | 9 | 1 | 23 | 2 / 1 |
| باسل سلوم | باسل السلوم (article variant) | 139 | 1243 / 1 | 3 | 2 | 1 | 4 | 3 / 2 |
| أغيدعدي | أغيد عدي | 144 | 1248 / 1 | 5 | 4 | 1 | 16 | 4 / 4 |
| ثريا خانم كرزون | ثريا خانم كرزون | 140 | 1244 / 1 | 9 | 8 | 1 | 16 | 8 / 8 |
| رزان بن عمر | رزان بن عمر | 85 | 643 / 1 | 9 | 8 | 1 | 16 | 8 / 8 |
| سماهر الكور | سماهر الكور | 9 | 87 / 1 | 23 | 9 | 14 | 27 | 9 / 3 |
| عدنان كفري | عدنان كفري | 166 | 1836 / 1 | 13 | 11 | 2 | 11 | 13 / 11 |

### 1. شادن غنوم — Teacher 154 / User 1258

Nine Grade 4 / section 136 subjects match the timetable. Responsibility **1435** additionally grants Grade 2 / section 166 / Religious Education (lesson 7). That subject's periods are assigned to شهد كوجان (Teacher 152), so Shaden's dashboard has an extra Grade 2 section relative to her timetable. Period history **132** remains open. This is a confirmed source divergence, with final responsibility ownership requiring staff confirmation.

### 2. باسل سلوم — candidate stored as باسل السلوم — Teacher 139 / User 1243

This is the only Teacher/account found when searching first name باسل and surname variants containing سلوم. The requested spelling omits the surname article; no other account was selected or merged. Two Grade 12 French responsibilities match sections 152/153. Responsibility **1448** adds Grade 2 / section 167 / Informatics (lesson 409), whose timetable now names عدنان كفري (166). Open period **145** preserves the additional operational grant. Treat this comparison as applying to verified database account 139; staff can confirm the requested-name variant.

### 3. أغيدعدي — stored as أغيد عدي — Teacher 144 / User 1248

Space/Alef normalization resolves one account. Four Arabic responsibilities in Grade 11/12 sections 150/151/152/153 match. Responsibility **1886** additionally grants Grade 11 / section 151 / Science (496); those periods name أسعد عروق (136). Open period **583** remains. His class/section cards can look right while the section's subject list contains the extra Science subject.

### 4. ثريا خانم كرزون — Teacher 140 / User 1244

Eight French responsibilities across Grades 7–11 match. Responsibility **1885** additionally grants Grade 11 / section 151 / English (499), while four timetable periods name هنادي مغمومة (118). Open period **582** remains. The extra subject is in a section already legitimately assigned for French.

### 5. رزان بن عمر — Teacher 85 / User 643

Eight French responsibilities across Grades 7–11 match. Responsibility **1874** adds Grade 11 / section 150 / Mathematics (498), whose six periods name أمير عدي (90). Open period **571** remains. Seven previous-year responsibility rows also exist, but are excluded by the main dashboard's current-year helper; they are not the cause of this Mathematics discrepancy.

### 6. سماهر الكور — Teacher 9 / User 87

The account name contains an initial Arabic combining mark (`ٍسماهر`), while the Teacher identity is سماهر الكور. Normalization resolves the link uniquely.

Nine current responsibilities in Grade 6 sections 140/141/162 match 27 periods. Fourteen more grants cover Social Studies and enrichment across Grades 3/5/6, where the timetable names other Teachers (all IDs below). Consequently the dashboard has nine current sections across three grades, but her current weekly timetable covers only three Grade 6 sections. Twenty older responsibility rows also exist; current cards exclude them, but the timetable's unscoped count card includes them.

All fourteen discrepant history periods remain open. Enrichment is visibly scheduled to multiple Teachers in some sections, so a one-Teacher-per-subject assumption would be wrong.

### 7. عدنان كفري — Teacher 166 / User 1836

Eleven Informatics responsibilities across Grade 1/2 sections match eleven periods. Two extra grants remain: **1906**, Grade 3 / section 135 / Informatics (419), scheduled to أماني اسماعيل (72); and **1905**, Grade 5 / section 139 / Visual Arts (44), scheduled to دعاء قنباز (141). Open history periods **603/602** remain. These grants add Grade 3 and Grade 5 sections to his dashboard.

For the requested starting page, section 130 is a positive control: responsibility **1458**, lesson **406**, period **4122**, Wednesday **13:20–14:00**, Teacher **166**, year **6**, term **20**, all agree.

## Discrepancy matrix: the 21 verified responsibility-only identities

For every row: the Admin period query has **no period for the named affected Teacher**; the dashboard/subjects/marks/Follow-up responsibility source **does include that Teacher**. Each listed replacement/scheduled Teacher also has a valid annual pivot. This is a comparison, not a declaration that co-teaching or non-timetabled responsibility is invalid.

| Affected Teacher | Class / section (IDs) | Subject (lesson ID) | Current pivot / open period | Admin-scheduled Teacher(s) | Schedule row IDs |
|---|---|---|---|---|---|

| شادن غنوم (154) | الصف الثاني (2) / الثاني - خامسة (166) | التربية الدينية (7) | 1435 / 132 | شهد كوجان (152) | 4380,4385,4388 |
| باسل السلوم (139) | الصف الثاني (2) / الثاني - سادسة (167) | معلوماتية (409) | 1448 / 145 | عدنان كفري (166) | 4414 |
| أغيد عدي (144) | الصف الحادي عشر (60) / الحادي عشر-2-ذكور (151) | علوم (496) | 1886 / 583 | أسعد عروق (136) | 5410,5411,5418 |
| ثريا خانم كرزون (140) | الصف الحادي عشر (60) / الحادي عشر-2-ذكور (151) | اللغة الإنكليزية (499) | 1885 / 582 | هنادي مغمومة (118) | 5399,5401,5413,5415 |
| رزان بن عمر (85) | الصف الحادي عشر (60) / الحادي عشر-1-إناث (150) | رياضيات (498) | 1874 / 571 | أمير عدي (90) | 5364,5374,5376,5379,5380,5382 |
| سماهر الكور (9) | الصف الخامس (5) / الخامس - أولى (138) | الدراسات الاجتماعية (41) | 1588 / 285 | عمر خنفور (168) | 4707,4717 |
| سماهر الكور (9) | الصف الخامس (5) / الخامس - أولى (138) | إثرائية (535) | 1593 / 290 | رهف نبهان (103); ميسم زكية (148) | 4732; 4708,4728 |
| سماهر الكور (9) | الصف الخامس (5) / الخامس - الثانية (139) | الدراسات الاجتماعية (41) | 1611 / 308 | عمر خنفور (168) | 4745,4753 |
| سماهر الكور (9) | الصف الخامس (5) / الخامس - الثانية (139) | إثرائية (535) | 1612 / 309 | رهف نبهان (103); ميسم زكية (148) | 5483; 4760,5492 |
| سماهر الكور (9) | الصف السادس (6) / السادس-1- إناث (140) | الدراسات الاجتماعية (50) | 1644 / 341 | عمر خنفور (168) | 4832,4842 |
| سماهر الكور (9) | الصف السادس (6) / السادس- 2- إناث (141) | الدراسات الاجتماعية (50) | 1655 / 352 | عمر خنفور (168) | 4859,4863 |
| سماهر الكور (9) | الصف الثالث (3) / الثالث - ثالثة (159) | إثرائية (533) | 1499 / 196 | رهف نبهان (103); ريم الخلف (106) | 4514; 4500 |
| سماهر الكور (9) | الصف الخامس (5) / الخامس- الثالثة (161) | الدراسات الاجتماعية (41) | 1622 / 319 | عمر خنفور (168) | 4781,5500 |
| سماهر الكور (9) | الصف الخامس (5) / الخامس- الثالثة (161) | إثرائية (535) | 1624 / 321 | رهف نبهان (103); ميسم زكية (148) | 4785; 4777,5495 |
| سماهر الكور (9) | الصف السادس (6) / السادس-3-ذكور (162) | الدراسات الاجتماعية (50) | 1677 / 374 | عمر خنفور (168) | 4893,4906 |
| سماهر الكور (9) | الصف الخامس (5) / الخامس - الرابعة (170) | الدراسات الاجتماعية (41) | 1628 / 325 | عمر خنفور (168) | 4800,5520 |
| سماهر الكور (9) | الصف الخامس (5) / الخامس - الرابعة (170) | إثرائية (535) | 1639 / 336 | رهف نبهان (103); عائدة إبراهيم (162) | 4821; 5515,5519 |
| سماهر الكور (9) | الصف السادس (6) / السادس-4-ذكور (173) | الدراسات الاجتماعية (50) | 1689 / 386 | عمر خنفور (168) | 4920,5524 |
| سماهر الكور (9) | الصف السادس (6) / السادس-4-ذكور (173) | إثرائية (536) | 1690 / 387 | رهف نبهان (103); عائدة إبراهيم (162) | 5530; 5518,5535 |
| عدنان كفري (166) | الصف الثالث (3) / الثالث - ثانية (135) | معلوماتية (419) | 1906 / 603 | أماني اسماعيل (72) | 4487 |
| عدنان كفري (166) | الصف الخامس (5) / الخامس - الثانية (139) | التربية الفنية البصرية و الجمالية (44) | 1905 / 602 | دعاء قنباز (141) | 4754 |

No target-schedule-only rows were returned. No exact current-year duplicate pivot tuples or duplicate timetable occurrences were found. The difference is **21 distinct grants**, not 21 weekly periods.

## Confirmed causes and severity

### F1 — P1: additive timetable synchronization leaves live annual responsibility behind

Confirmed in code and data. `save_schedule` adds the requested pivot but does not close/delete the former one; schedule deletion also leaves it. The 21 discrepant rows and corresponding open periods explain why Teacher subject/navigation queries still return these contexts. See the save/delete/observer references above.

The missing mechanism is **an explicit responsibility-retirement decision**, not a missing period insert. “Assign this period” and “end all teaching responsibility for this subject/section” currently remain separate actions. Automatic retirement is unsafe without distinguishing independent responsibilities and co-teaching.

Causality limit: the current database does not retain old versions of a schedule Teacher field or the Admin actor/action that changed it. For example, responsibility 1886 was created at the returned TIMESTAMP `2026-10-15 15:39:28`, while the current Science schedule rows' latest update is `2026-10-15 15:39:14`. One cannot claim every discrepancy was caused by a later period replacement. Direct plan additions, multiple slot edits, imported data, and intentional concurrent grants cannot be separated from snapshots alone.

### F2 — P2: Teacher timetable section-count card counts unscoped pivot rows

`teacher_schedule()` loads a plain Teacher, without replacing its `rooms` relation. Blade computes `collect($teacher->rooms)->count()`, and the relation has neither a year filter nor distinct room IDs. The count therefore means “all responsibility rows across years”, not current sections.

Evidence: [app/Http/Controllers/TeacherController_New.php:2499](C:/Users/Lenovo/Desktop/aladhamedu/app/Http/Controllers/TeacherController_New.php:2499), [app/Teacher.php:28](C:/Users/Lenovo/Desktop/aladhamedu/app/Teacher.php:28), [resources/views/teachers2/teacher_schedule.blade.php:540](C:/Users/Lenovo/Desktop/aladhamedu/resources/views/teachers2/teacher_schedule.blade.php:540), [resources/views/teachers2/teacher_schedule.blade.php:588](C:/Users/Lenovo/Desktop/aladhamedu/resources/views/teachers2/teacher_schedule.blade.php:588).

| Teacher ID | Counter derived by current Blade | Distinct current responsibility sections | Distinct current scheduled sections |
|---:|---:|---:|---:|

| 154 | 10 | 2 | 1 |
| 139 | 3 | 3 | 2 |
| 144 | 5 | 4 | 4 |
| 140 | 9 | 8 | 8 |
| 85 | 16 | 8 | 8 |
| 9 | 43 | 9 | 3 |
| 166 | 13 | 13 | 11 |

The primary dashboard already deduplicates and scopes its rooms; this bug is specific to the timetable summary card.

### F3 — P1/P2: legacy current-context readers disagree with the web portal

- API `teacher_lessons` uses `Term_year::where(current_term,1)->first()` without year. The identical SELECT in this DB returns **term 17 / year 5**, while the current web context is **term 20 / year 6**. This can select old-year content or return an apparently empty current section. The term-selection bug is confirmed; which mobile screen a school employee uses was not browser-verified.
- API timetable filters the room year only, while the web timetable also filters row year/term, validates the slot, and requires a pivot. In the present DB all 1,372 current-room periods happen to be year 6 / term 20, so no additional API-only current-period mismatch was observed.
- The shared layout calls `available_schedule`, which has no year, term, valid-assignment, or room-year filter and stops at the first overlapping time. It can scan **55 legacy year-2/term-2 rows for Teacher 9** and **14 for Teacher 85**. The returned variable is currently unused in the rendered `teachers2` templates, so the audit does **not** attribute visible subject cards to it.
- The rewards/sanctions subject reader omits the inner pivot-year predicate after a current-room gate. All current pivots match room years in this snapshot; this is a latent inconsistency.

### F4 — P2: schema/history weaknesses, not the current dashboard cause

- All 1,053 pivots resolve an existing Teacher, lesson, room and year; all pivot years, room years, class IDs and lesson class IDs agree. No current-year orphan/context mismatch was found.
- No duplicate current pivot identities were found. Historical duplicates exist: Teacher 8 / year 3 / room 1 / lesson 151 -> IDs **35,36,37**; Teacher 55 / year 3 / room 39 / lesson 17 -> **188,189**; Teacher 23 / year 5 / room 106 / lesson 439 -> **850,851**. These are not among the seven requested current comparisons.
- There are **1,039 legacy period rows with year_id=2 and term_id=2**, whose year/term records no longer exist; their sections belong to other years, and one has an invalid instructional-slot relationship. Current web period queries exclude them. They must not be promoted into current authority or deleted as a side effect of synchronization.
- `teacher_room_lesson` has no composite unique constraint for a responsibility identity. `lesson_room_teacher_lecture_time` has only a primary-key index. Concurrent `firstOrCreate` calls could duplicate a grant without a supporting unique constraint; no such current duplicates were found.
- The four examined assignment/follow-up tables are InnoDB but have **no declared foreign keys** in this local schema. Application-level guards and observers carry the consistency burden.
- There are **634 history periods: 621 open, 13 closed**, and no open period pointing to a missing pivot. All 72 target pivots have an open period. The 21 discrepant contexts currently have **zero authored Follow-up records**; this is not proof that other academic records can be removed.
- **45 current room/subject pairs have multiple Teachers.** Some are actively co-scheduled (for example enrichment), so a uniqueness rule omitting `teacher_id` would break existing behavior.

### F5 — P0: actual authorization gaps in adjacent legacy routes (code-confirmed, not exercised)

1. **Legacy API Teacher routes have no authentication/Teacher ownership middleware.** `/api/teacher_subjects`, `/api/teacher_lessons`, `/api/teacher_schedule`, `/api/get_room_student`, and `/api/teacher/store/lecture` sit outside the separately protected `/api/user` route. The API group is throttle + bindings only. The API controller constructor only resolves a year. The student-list method returns section student IDs/names by room ID, and the lecture create method accepts Teacher/class/room/lesson IDs directly. This is a route/controller authorization gap independent of timetable drift. Evidence: [routes/api.php:133](C:/Users/Lenovo/Desktop/aladhamedu/routes/api.php:133), [routes/api.php:145](C:/Users/Lenovo/Desktop/aladhamedu/routes/api.php:145), [routes/api.php:160](C:/Users/Lenovo/Desktop/aladhamedu/routes/api.php:160), [app/Http/Kernel.php:48](C:/Users/Lenovo/Desktop/aladhamedu/app/Http/Kernel.php:48), [app/Http/Controllers/Api/websitecontroller.php:76](C:/Users/Lenovo/Desktop/aladhamedu/app/Http/Controllers/Api/websitecontroller.php:76), [app/Http/Controllers/Api/websitecontroller.php:351](C:/Users/Lenovo/Desktop/aladhamedu/app/Http/Controllers/Api/websitecontroller.php:351), [app/Http/Controllers/Api/websitecontroller.php:384](C:/Users/Lenovo/Desktop/aladhamedu/app/Http/Controllers/Api/websitecontroller.php:384). No request was sent to exploit or write through these routes.
2. **Web lesson-search endpoints are only Teacher-role protected.** `search_lecture` / `search_lecturetime` accept a room (and sometimes subject), query active lecture content, and return it without the assignment/year guard used on their parent page. Evidence: [routes/teacher.php:37](C:/Users/Lenovo/Desktop/aladhamedu/routes/teacher.php:37), [app/Http/Controllers/TeacherController_New.php:1517](C:/Users/Lenovo/Desktop/aladhamedu/app/Http/Controllers/TeacherController_New.php:1517), [app/Http/Middleware/roleteacher.php:19](C:/Users/Lenovo/Desktop/aladhamedu/app/Http/Middleware/roleteacher.php:19). No cross-Teacher data request was performed.
3. **Legacy stream entry does not verify that its IDs belong to the authenticated Teacher/current context.** It checks supplied day/slot time, then records attendance and redirects using the independently selected schedule row. Schedule/Teacher/room/slot relationships are not reconciled. Evidence: [routes/teacher.php:393](C:/Users/Lenovo/Desktop/aladhamedu/routes/teacher.php:393), [app/Http/Controllers/TeacherController_New.php:2575](C:/Users/Lenovo/Desktop/aladhamedu/app/Http/Controllers/TeacherController_New.php:2575). This mutating GET was not executed.
4. **Lecture update validates the original assignment, then accepts new context fields.** After authorizing the existing record, it assigns request `class_id/room_id/lesson_id` without reauthorizing that destination. Evidence: [app/Http/Controllers/TeacherController_New.php:1622](C:/Users/Lenovo/Desktop/aladhamedu/app/Http/Controllers/TeacherController_New.php:1622). No attempt was made to move content across assignments.

These are findings in the actual local code, not proof of production reachability behind an external proxy or proof that any Teacher used them. No Phase 1/2 Gradebook code was altered or accused of bypassing its current assignment checks.

## Security impact of the 21 extra responsibilities

This is not only cosmetic. Their exact year/class/room/subject combinations satisfy the responsibility predicates in current grade-entry and Advanced Gradebook access. Follow-up also sees their still-open periods. Other current student membership, term, assessment consistency, lock and historical read-only rules continue to apply.

If a Teacher was meant to stop teaching one of these contexts, leaving its pivot open preserves academic access. Merely hiding a card or filtering the dashboard by timetable would not revoke backend access. Conversely, removing a legitimate unscheduled/co-teaching grant would remove intended access.

No unauthorized writes, mark changes, data exposure via crafted requests, or account impersonation were attempted. Staff confirmation is required to label the 21 individual responsibilities obsolete; the verified fact is that both the responsibility and a different Teacher's period ownership coexist.

## Caching, performance and false-positive checks

- No assignment data is cached in the traced web controllers. Auth session supplies Teacher identity; year, term and pivots are freshly queried. No cache clearing is indicated by these findings.
- Main dashboard deduplicates section/class models. Subjects use eager loading and unique lesson IDs. Repeated periods do not create duplicate cards.
- Teacher timetable uses eager-loaded lesson/slot/room/class, but still loads all lecture-time rows and performs per-today-row lookups. The shared layout's unused schedule helper adds a query and repeated slot lookups on every page.
- API subjects loop over pivots with `Lesson::find` (N+1). API weekly timetable repeats its query for each day. Admin subject options can lazy-load each base subject. These are performance concerns, not explanations for wrong Teacher identity.
- Exact-current-period duplicates: **0**. Current schedule rows missing supporting pivots: **0**, school-wide.
- Current Teacher/User links are consistent and single-valued for all seven inspected records.
- Older responsibility rows are intentionally retained by current-year plan synchronization. They are excluded by current web helpers. Open history periods from other years would not override the active-year gates.
- Missing current-term periods can be intentional for annual duties. Because all 21 discrepant contexts have another Teacher scheduled, they warrant staff review, but the audit does not infer exclusive ownership from that fact alone.

## Unverified hypotheses

- That every extra grant resulted from replacing the Teacher of a period. The code permits that, but manual responsibility changes can produce the same snapshot and no per-period audit trail establishes the origin.
- That all 21 responsibilities are obsolete. Timetabling, co-teaching, support roles and term-only differences need school confirmation.
- That production contains this exact data/code. This report covers the local `aladham_oct` database and current working tree.
- That a browser cache causes the mismatch. No assignment caching was found; browser inspection was unavailable.
- That any Teacher modified grades or accessed records improperly. No such claim is supported by this audit.
- That an unscoped API term has already caused a particular user's missing lesson. The wrong term selection is verified; authenticated mobile UI effects were not exercised.
- That `باسل سلوم` is definitely the same human as the unique stored `باسل السلوم` account. The candidate is explicit and unique, but the exact wording differs.

## Recommended fixes (future approval only)

| Priority | Proposed change and reason | Preserve / historical risks | Migration? | Verification |
|---|---|---|---|---|
| P0 | Audit and close the confirmed legacy API/web assignment authorization gaps before relying on presentation fixes. Bind identity to authenticated Teacher and validate exact target context on reads/writes. | Existing mobile clients may need authenticated requests; retain legitimate current access and owned history. Do not change grades/history to enforce authorization. | Normally no; authenticated API rollout may require a separate compatibility plan. | Role/ownership matrix, arbitrary other-room denial, old-year denial, valid current Teacher access; isolated tests and approved manual QA. |
| P1 | Review the 21 listed grants with staff and explicitly retain co-teaching/manual grants or end obsolete responsibility using the existing transaction/history mechanism. | Preserve periods, marks, content ownership, student identity and finance. Former-Teacher historical access must be assessed before a pivot is removed; current history screens can require that pivot. Zero Follow-up rows in these 21 contexts does not clear every data type. | No schema change is required for an individually reviewed plan using the current close-period behavior. | Before/after approved grant list, exact new pivot/year scope, old period closed, all historical records unchanged, former Teacher denied current operations, intended Teacher allowed. |
| P1 | Route responsibility changes and schedule side effects through one explicit operation/service, with an Admin decision for “change this period only” versus “end this subject responsibility”. Never blindly derive every grant from the timetable. | Preserve other periods/terms, co-teachers, unscheduled valid duties and historical evidence. Retire only when policy and remaining obligations allow it. | Reliable automatic retirement needs recorded grant provenance or equivalent event evidence; existing generic `source=teacher_room_lesson` cannot distinguish manual vs schedule-created grants. A small additive provenance/audit migration would be needed for that automation. | Slot replacement, one of several slots changed, last slot changed, independent grant, co-teaching, term switch, no partial transaction, truthful feedback. |
| P2 | Make current timetable statistics use a defined distinct current-section set; align unused helper/API readers with the current year/term resolver and strict period context. | Do not globally change the historical `Teacher::rooms()` relation or remove legitimate annual unscheduled grants. | No. | Counts match SELECT; historical rows excluded from current pages; APIs and web choose term 20 when year 6 is active; selected historical pages retain their own context. |
| P2 | Remove shadowed assignment route declarations and make responsibility vs period labels explicit in the existing Admin workflow. | Preserve the effective controller, permissions, POST payloads and existing account management. | No. | Route resolution, permission denial, assignment form, schedule form, and no duplicated/disappearing links. |
| P2 | Consider supporting indexes and a full-identity uniqueness guarantee only after separately reviewing the three historical duplicate groups. | Never collapse repeated weekly periods or multiple Teachers into one subject owner. Existing historical duplicates must be preserved/reconciled explicitly before a unique constraint can succeed. | Additive index migration; uniqueness may require an approved historical strategy first. | Explain plans, concurrent-idempotent assignment tests, historical data equality, no unsupported ALTER failure. |

## Proposed small implementation phases

1. **Responsibility approval:** give staff the discrepancy matrix, resolve the Basel name variant, mark each extra grant as intended or ended, and decide the period-change versus subject-responsibility rule. No automatic reconciliation.
2. **Authorization correction:** address the confirmed legacy gaps with compatibility tests. Reuse the strict current-context predicates already present in the web Gradebook rather than modifying Phase 1 calculations/continuity.
3. **Operational consistency:** implement the agreed responsibility update path and provenance/explicit confirmation as required. Preserve closed periods and record Admin action. Apply only approved corrections after backups and verification.
4. **Reader consistency:** fix the timetable counter/helper/API year/term scope and shadowed navigation routes, then validate each of the seven accounts against SQL and real browser pages.
5. **Acceptance:** test same-subject multiple periods, co-teaching, annual unscheduled responsibility, previous-year records, term switch, Teacher replacement, remaining periods, former-Teacher history, current grading/Follow-up access, and concurrent saves. No destructive cleanup should be part of UI acceptance.

## Reproducible SELECT evidence

The values 6 and 20 below were obtained from the active year and its current term, not assumed. All statements are read-only.

```sql
SELECT id, name FROM years WHERE current_year = 1;
SELECT id, term, year_id
FROM term_years WHERE year_id = 6 AND current_term = 1;

SELECT t.id AS teacher_id, t.first_name, t.last_name, t.active,
       u.id AS user_id, u.type
FROM teachers t LEFT JOIN users u ON u.teacher_id = t.id
WHERE t.id IN (154,139,144,140,85,9,166);

-- The 21 responsibility identities missing from these Teachers' timetable.
SELECT a.id, a.teacher_id, a.year_id, a.class_id, a.room_id,
       r.name AS section, a.lesson_id, l.name AS subject
FROM teacher_room_lesson a
JOIN rooms r ON r.id = a.room_id
JOIN lessons l ON l.id = a.lesson_id
WHERE a.year_id = 6 AND r.year_id = 6
  AND a.teacher_id IN (154,139,144,140,85,9,166)
  AND NOT EXISTS (
    SELECT 1 FROM lesson_room_teacher_lecture_time s
    WHERE s.teacher_id = a.teacher_id AND s.room_id = a.room_id
      AND s.lesson_id = a.lesson_id AND s.year_id = 6 AND s.term_id = 20
  )
ORDER BY a.teacher_id, a.room_id, a.lesson_id;

-- Distinct academic assignments; period/day counts are deliberately separate.
SELECT teacher_id, room_id, lesson_id, COUNT(*) AS weekly_periods,
       GROUP_CONCAT(id ORDER BY id) AS schedule_ids
FROM lesson_room_teacher_lecture_time
WHERE year_id = 6 AND term_id = 20
  AND teacher_id IN (154,139,144,140,85,9,166)
GROUP BY teacher_id, room_id, lesson_id;

SELECT id, teacher_room_lesson_id, teacher_id, year_id, class_id,
       room_id, lesson_id, effective_from, effective_to, source
FROM teacher_assignment_periods
WHERE teacher_room_lesson_id IN (
  1435,1448,1886,1885,1874,1588,1593,1611,1612,1644,1655,
  1499,1622,1624,1677,1628,1639,1689,1690,1906,1905
);
```

## Appendix A: full per-Teacher responsibility comparison

Each row is a distinct current-year responsibility. “Same” means at least one current period for the same Teacher/section/subject. “Different” means this Teacher has none; the Admin column gives the other scheduled Teacher(s). Dashboard subjects, marks navigation and Follow-up read the pivot in **every row**; their additional record/period/student checks remain as described above.

| Teacher ID | Class / section | Subject | Pivot ID | Admin current period ownership | Comparison |
|---:|---|---|---:|---|---|

| 154 | الصف الرابع (4) / الرابع - 1-إناث (136) | التربية الدينية (28) | 1533 | 154; 3 periods; IDs 4598,4604,4612 | Same |
| 154 | الصف الرابع (4) / الرابع - 1-إناث (136) | المهارات الكتابية (29) | 1537 | 154; 4 periods; IDs 4591,4601,4607,4615 | Same |
| 154 | الصف الرابع (4) / الرابع - 1-إناث (136) | الرياضيات (31) | 1531 | 154; 4 periods; IDs 4592,4596,4606,4614 | Same |
| 154 | الصف الرابع (4) / الرابع - 1-إناث (136) | الدراسات الاجتماعية (32) | 1538 | 154; 2 periods; IDs 4597,4609 | Same |
| 154 | الصف الرابع (4) / الرابع - 1-إناث (136) | العلوم والتربية الصحية (33) | 1541 | 154; 2 periods; IDs 4610,4617 | Same |
| 154 | الصف الرابع (4) / الرابع - 1-إناث (136) | التربية الفنية البصرية و الجمالية (35) | 1542 | 154; 1 periods; IDs 4593 | Same |
| 154 | الصف الرابع (4) / الرابع - 1-إناث (136) | التربية البدنية و  الرياضة (36) | 1535 | 154; 1 periods; IDs 4613 | Same |
| 154 | الصف الرابع (4) / الرابع - 1-إناث (136) | المهارات الشفوية (148) | 1532 | 154; 4 periods; IDs 4590,4599,4603,4608 | Same |
| 154 | الصف الرابع (4) / الرابع - 1-إناث (136) | إثرائية (534) | 1536 | 154; 2 periods; IDs 4589,4605 | Same |
| 154 | الصف الثاني (2) / الثاني - خامسة (166) | التربية الدينية (7) | 1435 | شهد كوجان (152); IDs 4380,4385,4388 | Different |
| 139 | الصف الثاني عشر (61) / الثاني عشر-1-إناث (152) | اللغة الفرنسية (530) | 1894 | 139; 2 periods; IDs 5433,5440 | Same |
| 139 | الصف الثاني عشر (61) / الثاني عشر-2-ذكور (153) | اللغة الفرنسية (530) | 1903 | 139; 2 periods; IDs 5464,5469 | Same |
| 139 | الصف الثاني (2) / الثاني - سادسة (167) | معلوماتية (409) | 1448 | عدنان كفري (166); IDs 4414 | Different |
| 144 | الصف الحادي عشر (60) / الحادي عشر-1-إناث (150) | اللغة العربية (495) | 1870 | 144; 4 periods; IDs 5371,5378,5388,5389 | Same |
| 144 | الصف الحادي عشر (60) / الحادي عشر-2-ذكور (151) | اللغة العربية (495) | 1882 | 144; 4 periods; IDs 5400,5409,5416,5420 | Same |
| 144 | الصف الحادي عشر (60) / الحادي عشر-2-ذكور (151) | علوم (496) | 1886 | أسعد عروق (136); IDs 5410,5411,5418 | Different |
| 144 | الصف الثاني عشر (61) / الثاني عشر-1-إناث (152) | عربي (526) | 1891 | 144; 4 periods; IDs 5427,5431,5435,5436 | Same |
| 144 | الصف الثاني عشر (61) / الثاني عشر-2-ذكور (153) | عربي (526) | 1901 | 144; 4 periods; IDs 5458,5462,5463,5479 | Same |
| 140 | الصف العاشر (59) / العاشر-2-ذكور (149) | French (489) | 1861 | 140; 2 periods; IDs 5348,5353 | Same |
| 140 | الصف الحادي عشر (60) / الحادي عشر-2-ذكور (151) | اللغة الإنكليزية (499) | 1885 | هنادي مغمومة (118); IDs 5399,5401,5413,5415 | Different |
| 140 | الصف الحادي عشر (60) / الحادي عشر-2-ذكور (151) | French (500) | 1883 | 140; 2 periods; IDs 5404,5414 | Same |
| 140 | الصف السابع (56) / السابع-3-ذكور (163) | French (453) | 1735 | 140; 2 periods; IDs 5028,5033 | Same |
| 140 | الصف الثامن (57) / الثامن-3-ذكور (164) | French (468) | 1783 | 140; 2 periods; IDs 5148,5154 | Same |
| 140 | الصف التاسع (58) / التاسع-3-ذكور (165) | French (475) | 1830 | 140; 2 periods; IDs 5261,5269 | Same |
| 140 | الصف السابع (56) / السابع-4-ذكور (174) | French (453) | 1745 | 140; 2 periods; IDs 5055,5066 | Same |
| 140 | الصف الثامن (57) / الثامن-4-ذكور (176) | French (468) | 1795 | 140; 2 periods; IDs 5174,5182 | Same |
| 140 | الصف التاسع (58) / التاسع-4-ذكور (177) | French (475) | 1839 | 140; 2 periods; IDs 5287,5301 | Same |
| 85 | الصف السابع (56) / السابع-1- إناث (142) | French (453) | 1704 | 85; 2 periods; IDs 4955,4969 | Same |
| 85 | الصف السابع (56) / السابع-2-إناث (143) | French (453) | 1720 | 85; 2 periods; IDs 4990,4994 | Same |
| 85 | الصف الثامن (57) / الثامن-1-إناث (144) | French (468) | 1755 | 85; 2 periods; IDs 5076,5083 | Same |
| 85 | الصف الثامن (57) / الثامن-2-إناث (145) | French (468) | 1770 | 85; 2 periods; IDs 5111,5118 | Same |
| 85 | الصف التاسع (58) / التاسع-1-إناث (146) | French (475) | 1804 | 85; 2 periods; IDs 5193,5202 | Same |
| 85 | الصف التاسع (58) / التاسع-2-إناث (147) | French (475) | 1816 | 85; 2 periods; IDs 5222,5233 | Same |
| 85 | الصف العاشر (59) / العاشر-1-إناث (148) | French (489) | 1852 | 85; 2 periods; IDs 5315,5326 | Same |
| 85 | الصف الحادي عشر (60) / الحادي عشر-1-إناث (150) | رياضيات (498) | 1874 | أمير عدي (90); IDs 5364,5374,5376,5379,5380,5382 | Different |
| 85 | الصف الحادي عشر (60) / الحادي عشر-1-إناث (150) | French (500) | 1872 | 85; 2 periods; IDs 5375,5381 | Same |
| 9 | الصف الخامس (5) / الخامس - أولى (138) | الدراسات الاجتماعية (41) | 1588 | عمر خنفور (168); IDs 4707,4717 | Different |
| 9 | الصف الخامس (5) / الخامس - أولى (138) | إثرائية (535) | 1593 | رهف نبهان (103); IDs 4732; ميسم زكية (148); IDs 4708,4728 | Different |
| 9 | الصف الخامس (5) / الخامس - الثانية (139) | الدراسات الاجتماعية (41) | 1611 | عمر خنفور (168); IDs 4745,4753 | Different |
| 9 | الصف الخامس (5) / الخامس - الثانية (139) | إثرائية (535) | 1612 | رهف نبهان (103); IDs 5483; ميسم زكية (148); IDs 4760,5492 | Different |
| 9 | الصف السادس (6) / السادس-1- إناث (140) | المهارات الشفوية (47) | 1919 | 9; 4 periods; IDs 4827,4843,4846,4854 | Same |
| 9 | الصف السادس (6) / السادس-1- إناث (140) | الدراسات الاجتماعية (50) | 1644 | عمر خنفور (168); IDs 4832,4842 | Different |
| 9 | الصف السادس (6) / السادس-1- إناث (140) | المهارات الكتابية (168) | 1921 | 9; 3 periods; IDs 4837,4848,4856 | Same |
| 9 | الصف السادس (6) / السادس-1- إناث (140) | إثرائية (536) | 1652 | 9; 2 periods; IDs 4828,4852 | Same |
| 9 | الصف السادس (6) / السادس- 2- إناث (141) | المهارات الشفوية (47) | 1925 | 9; 4 periods; IDs 4861,4872,4881,4887 | Same |
| 9 | الصف السادس (6) / السادس- 2- إناث (141) | الدراسات الاجتماعية (50) | 1655 | عمر خنفور (168); IDs 4859,4863 | Different |
| 9 | الصف السادس (6) / السادس- 2- إناث (141) | المهارات الكتابية (168) | 1927 | 9; 3 periods; IDs 4865,4874,4883 | Same |
| 9 | الصف السادس (6) / السادس- 2- إناث (141) | إثرائية (536) | 1669 | 9; 2 periods; IDs 4868,5484 | Same |
| 9 | الصف الثالث (3) / الثالث - ثالثة (159) | إثرائية (533) | 1499 | رهف نبهان (103); IDs 4514; ريم الخلف (106); IDs 4500 | Different |
| 9 | الصف الخامس (5) / الخامس- الثالثة (161) | الدراسات الاجتماعية (41) | 1622 | عمر خنفور (168); IDs 4781,5500 | Different |
| 9 | الصف الخامس (5) / الخامس- الثالثة (161) | إثرائية (535) | 1624 | رهف نبهان (103); IDs 4785; ميسم زكية (148); IDs 4777,5495 | Different |
| 9 | الصف السادس (6) / السادس-3-ذكور (162) | المهارات الشفوية (47) | 1930 | 9; 4 periods; IDs 4891,4898,4905,4912 | Same |
| 9 | الصف السادس (6) / السادس-3-ذكور (162) | الدراسات الاجتماعية (50) | 1677 | عمر خنفور (168); IDs 4893,4906 | Different |
| 9 | الصف السادس (6) / السادس-3-ذكور (162) | المهارات الكتابية (168) | 1931 | 9; 3 periods; IDs 4909,4915,5501 | Same |
| 9 | الصف السادس (6) / السادس-3-ذكور (162) | إثرائية (536) | 1672 | 9; 2 periods; IDs 5502,5508 | Same |
| 9 | الصف الخامس (5) / الخامس - الرابعة (170) | الدراسات الاجتماعية (41) | 1628 | عمر خنفور (168); IDs 4800,5520 | Different |
| 9 | الصف الخامس (5) / الخامس - الرابعة (170) | إثرائية (535) | 1639 | رهف نبهان (103); IDs 4821; عائدة إبراهيم (162); IDs 5515,5519 | Different |
| 9 | الصف السادس (6) / السادس-4-ذكور (173) | الدراسات الاجتماعية (50) | 1689 | عمر خنفور (168); IDs 4920,5524 | Different |
| 9 | الصف السادس (6) / السادس-4-ذكور (173) | إثرائية (536) | 1690 | رهف نبهان (103); IDs 5530; عائدة إبراهيم (162); IDs 5518,5535 | Different |
| 166 | الصف الأول (1) / الأول - أولى (130) | معلوماتية (406) | 1458 | 166; 1 periods; IDs 4122 | Same |
| 166 | الصف الأول (1) / الأول - ثانية (131) | معلوماتية (406) | 1459 | 166; 1 periods; IDs 4146 | Same |
| 166 | الصف الثاني (2) / الثاني - أولى (132) | معلوماتية (409) | 1454 | 166; 1 periods; IDs 4265 | Same |
| 166 | الصف الثاني (2) / الثاني - ثانية (133) | معلوماتية (409) | 1455 | 166; 1 periods; IDs 4292 | Same |
| 166 | الصف الثالث (3) / الثالث - ثانية (135) | معلوماتية (419) | 1906 | أماني اسماعيل (72); IDs 4487 | Different |
| 166 | الصف الخامس (5) / الخامس - الثانية (139) | التربية الفنية البصرية و الجمالية (44) | 1905 | دعاء قنباز (141); IDs 4754 | Different |
| 166 | الصف الأول (1) / الأول- ثالثة (154) | معلوماتية (406) | 1460 | 166; 1 periods; IDs 4180 | Same |
| 166 | الصف الأول (1) / الأول-رابعة (155) | معلوماتية (406) | 1461 | 166; 1 periods; IDs 4209 | Same |
| 166 | الصف الثاني (2) / الثاني- ثالثة (156) | معلوماتية (409) | 1664 | 166; 1 periods; IDs 4323 | Same |
| 166 | الصف الثاني (2) / الثاني - رابعة (157) | معلوماتية (409) | 1456 | 166; 1 periods; IDs 4357 | Same |
| 166 | الصف الأول (1) / الاول - خامسة (158) | معلوماتية (406) | 1462 | 166; 1 periods; IDs 4231 | Same |
| 166 | الصف الثاني (2) / الثاني - خامسة (166) | معلوماتية (409) | 1457 | 166; 1 periods; IDs 4391 | Same |
| 166 | الصف الثاني (2) / الثاني - سادسة (167) | معلوماتية (409) | 1453 | 166; 1 periods; IDs 4414 | Same |

## Appendix B: weekly occurrences for the 51 matching identities

Year 6 / term 20 throughout. Every occurrence keeps its schedule ID and day/time; 113 periods are represented. This is independent of responsibility count.

| Teacher ID | Section / subject IDs | Schedule ID: day start–end |
|---:|---|---|

| 154 | 136 / 28 | 4598: الاثنين 12:40–13:20; 4604: الثلاثاء 12:40–13:20; 4612: الخميس 09:30–10:10 |
| 154 | 136 / 29 | 4591: الأحد 11:45–12:25; 4601: الثلاثاء 10:10–10:50; 4607: الأربعاء 10:10–10:50; 4615: الخميس 11:45–12:25 |
| 154 | 136 / 31 | 4592: الأحد 13:20–14:00; 4596: الاثنين 11:05–11:45; 4606: الأربعاء 09:30–10:10; 4614: الخميس 11:05–11:45 |
| 154 | 136 / 32 | 4597: الاثنين 11:45–12:25; 4609: الأربعاء 11:45–12:25 |
| 154 | 136 / 33 | 4610: الأربعاء 12:40–13:20; 4617: الخميس 13:20–14:00 |
| 154 | 136 / 35 | 4593: الأحد 12:40–13:20 |
| 154 | 136 / 36 | 4613: الخميس 10:10–10:50 |
| 154 | 136 / 148 | 4590: الأحد 11:05–11:45; 4599: الاثنين 13:20–14:00; 4603: الثلاثاء 11:45–12:25; 4608: الأربعاء 11:05–11:45 |
| 154 | 136 / 534 | 4589: الأحد 10:10–10:50; 4605: الثلاثاء 13:20–14:00 |
| 139 | 152 / 530 | 5433: الثلاثاء 08:00–08:45; 5440: الأربعاء 08:45–09:30 |
| 139 | 153 / 530 | 5464: الثلاثاء 08:45–09:30; 5469: الأربعاء 08:00–08:45 |
| 144 | 150 / 495 | 5371: الاثنين 10:30–11:15; 5378: الثلاثاء 11:15–12:00; 5388: الخميس 09:30–10:15; 5389: الخميس 10:30–11:15 |
| 144 | 151 / 495 | 5400: الاثنين 09:40–10:25; 5409: الثلاثاء 12:00–12:40; 5416: الخميس 08:45–09:30; 5420: الخميس 12:00–12:40 |
| 144 | 152 / 526 | 5427: الاثنين 08:00–08:45; 5431: الاثنين 11:15–12:00; 5435: الثلاثاء 09:30–10:15; 5436: الثلاثاء 10:30–11:15 |
| 144 | 153 / 526 | 5458: الاثنين 08:45–09:30; 5462: الاثنين 12:00–12:40; 5463: الثلاثاء 08:00–08:45; 5479: الخميس 11:20–12:00 |
| 140 | 149 / 489 | 5348: الثلاثاء 10:25–11:10; 5353: الأربعاء 09:40–10:25 |
| 140 | 151 / 500 | 5404: الثلاثاء 08:00–08:45; 5414: الأربعاء 11:20–12:00 |
| 140 | 163 / 453 | 5028: الأربعاء 08:45–09:30; 5033: الخميس 08:45–09:30 |
| 140 | 164 / 468 | 5148: الأربعاء 10:25–11:10; 5154: الخميس 10:25–11:10 |
| 140 | 165 / 475 | 5261: الثلاثاء 11:20–12:00; 5269: الخميس 08:00–08:45 |
| 140 | 174 / 453 | 5055: الثلاثاء 12:00–12:40; 5066: الخميس 12:00–12:40 |
| 140 | 176 / 468 | 5174: الأربعاء 08:00–08:45; 5182: الخميس 09:40–10:25 |
| 140 | 177 / 475 | 5287: الثلاثاء 08:45–09:30; 5301: الخميس 11:20–12:00 |
| 85 | 142 / 453 | 4955: الاثنين 08:00–08:45; 4969: الأربعاء 09:30–10:15 |
| 85 | 143 / 453 | 4990: الاثنين 12:10–12:50; 4994: الثلاثاء 10:30–11:15 |
| 85 | 144 / 468 | 5076: الاثنين 10:30–11:15; 5083: الثلاثاء 11:15–12:00 |
| 85 | 145 / 468 | 5111: الثلاثاء 09:30–10:15; 5118: الأربعاء 10:30–11:15 |
| 85 | 146 / 475 | 5193: الاثنين 09:30–10:15; 5202: الثلاثاء 12:10–12:50 |
| 85 | 147 / 475 | 5222: الاثنين 08:45–09:30; 5233: الأربعاء 08:00–08:45 |
| 85 | 148 / 489 | 5315: الثلاثاء 08:00–08:45; 5326: الأربعاء 12:10–12:50 |
| 85 | 150 / 500 | 5375: الثلاثاء 08:45–09:30; 5381: الأربعاء 08:45–09:30 |
| 9 | 140 / 47 | 4827: الأحد 09:30–10:10; 4843: الثلاثاء 13:20–14:00; 4846: الأربعاء 10:10–10:50; 4854: الخميس 11:45–12:25 |
| 9 | 140 / 168 | 4837: الاثنين 12:40–13:20; 4848: الأربعاء 11:45–12:25; 4856: الخميس 13:20–14:00 |
| 9 | 140 / 536 | 4828: الأحد 10:10–10:50; 4852: الخميس 10:10–10:50 |
| 9 | 141 / 47 | 4861: الأحد 12:40–13:20; 4872: الثلاثاء 10:10–10:50; 4881: الأربعاء 12:40–13:20; 4887: الخميس 12:40–13:20 |
| 9 | 141 / 168 | 4865: الاثنين 11:05–11:45; 4874: الثلاثاء 11:45–12:25; 4883: الخميس 09:30–10:10 |
| 9 | 141 / 536 | 4868: الاثنين 13:20–14:00; 5484: الثلاثاء 09:30–10:10 |
| 9 | 162 / 47 | 4891: الأحد 11:05–11:45; 4898: الاثنين 11:45–12:25; 4905: الثلاثاء 12:40–13:20; 4912: الأربعاء 13:20–14:00 |
| 9 | 162 / 168 | 5501: الأحد 11:45–12:25; 4909: الأربعاء 11:05–11:45; 4915: الخميس 11:05–11:45 |
| 9 | 162 / 536 | 5502: الأحد 13:20–14:00; 5508: الأربعاء 09:30–10:10 |
| 166 | 130 / 406 | 4122: الأربعاء 13:20–14:00 |
| 166 | 131 / 406 | 4146: الثلاثاء 13:20–14:00 |
| 166 | 132 / 409 | 4265: الثلاثاء 12:40–13:20 |
| 166 | 133 / 409 | 4292: الثلاثاء 10:10–10:50 |
| 166 | 154 / 406 | 4180: الأربعاء 11:45–12:25 |
| 166 | 155 / 406 | 4209: الأربعاء 11:05–11:45 |
| 166 | 156 / 409 | 4323: الثلاثاء 11:05–11:45 |
| 166 | 157 / 409 | 4357: الأربعاء 09:30–10:10 |
| 166 | 158 / 406 | 4231: الثلاثاء 09:30–10:10 |
| 166 | 166 / 409 | 4391: الأربعاء 12:40–13:20 |
| 166 | 167 / 409 | 4414: الثلاثاء 11:45–12:25 |

## Audit preservation verification

Only this report was created. Existing application, routes, Blade/CSS/JS, configuration (including `.env.example`), Gradebook implementation files and migrations were not edited. No cache was cleared, no application handler or test was executed, and no commit, push or deployment was performed.

Final verification: all **57 pre-existing modified/untracked files** have the same SHA-256 hashes as at audit start, including `.env.example`. The only additional working-tree file is this report. `git diff --check` returned no whitespace errors; the report itself passed strict UTF-8 decoding, has no BOM, and has no trailing whitespace.

Repeated SELECT fingerprints taken before and after writing the report were identical for seven datasets: responsibilities (1,053 rows), timetable (2,411 rows), assignment periods (634 rows), years (17 rows), terms (9 rows), Teacher identities (77 rows), and Teacher-linked user identities (77 rows). This verifies stability over that final comparison interval; no database-write statement was issued at any point in the audit. Academic and financial records were not changed.

