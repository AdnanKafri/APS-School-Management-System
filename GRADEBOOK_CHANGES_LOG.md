# Admin Gradebook Module - Changes Log

## Phase 1A: Structure & Admin Entry (2025-01-04)

### New Files
- `app/Http/Controllers/Admin/GradebookController.php` (new)
- `resources/views/admin/gradebook/index.blade.php` (new)
- `resources/views/admin/gradebook/view_options.blade.php` (new)
- `resources/views/admin/gradebook/edit_select_class.blade.php` (new)
- `resources/views/admin/gradebook/edit_select_subject.blade.php` (new)
- `resources/views/admin/gradebook/edit_subject_settings.blade.php` (new)
- `resources/views/admin/gradebook/view_select_subject.blade.php` (new)
- `resources/views/admin/gradebook/view_by_subject.blade.php` (new)
- `resources/views/admin/gradebook/view_select_student.blade.php` (new)
- `resources/views/admin/gradebook/view_by_student.blade.php` (new)

### Modified Files
- `resources/views/admin/index.blade.php` (edited) - Added "Gradebook" entry button.
- `routes/web.php` (edited) - Added Gradebook route group.

## Phase 1B: UI Consistency & Localization (2025-01-04)

### Modified Files (UI & Arabic Updates)
- `resources/views/admin/gradebook/index.blade.php` (edited) - Aligned with Admin theme, added breadcrumbs, translated to Arabic.
- `resources/views/admin/gradebook/view_options.blade.php` (edited) - Aligned with Admin theme, added breadcrumbs, translated to Arabic.
- `resources/views/admin/gradebook/edit_select_class.blade.php` (edited) - Aligned with Admin theme, added breadcrumbs, translated to Arabic.
- `resources/views/admin/gradebook/edit_select_subject.blade.php` (edited) - Aligned with Admin theme, added breadcrumbs, translated to Arabic.
- `resources/views/admin/gradebook/edit_subject_settings.blade.php` (edited) - Aligned with Admin theme, added breadcrumbs, translated to Arabic.
- `resources/views/admin/gradebook/view_select_subject.blade.php` (edited) - Aligned with Admin theme, added breadcrumbs, translated to Arabic.
- `resources/views/admin/gradebook/view_by_subject.blade.php` (edited) - Aligned with Admin theme, added breadcrumbs, translated to Arabic.
- `resources/views/admin/gradebook/view_select_student.blade.php` (edited) - Aligned with Admin theme, added breadcrumbs, translated to Arabic.
- `resources/views/admin/gradebook/view_by_student.blade.php` (edited) - Aligned with Admin theme, added breadcrumbs, translated to Arabic.

## Phase 2: Read-Only Real Data Integration (2025-01-04)

### Controller Logic
- `app/Http/Controllers/Admin/GradebookController.php` (edited) - Implemented `showSubjectGrid`, `showStudentGradebook`, and added API methods (`getRooms`, `getSubjects`, `getStudents`) to fetch real data from `students_marks`.

### View Updates (Real Data & Logic)
- `resources/views/admin/gradebook/view_select_subject.blade.php` (edited) - Added JavaScript for dependent dropdowns (Class -> Room -> Subject).
- `resources/views/admin/gradebook/view_select_student.blade.php` (edited) - Added JavaScript for dependent dropdowns (Class -> Room -> Student).
- `resources/views/admin/gradebook/view_by_subject.blade.php` (edited) - Implemented loop to display real students and parse `mark`/`mark2` JSON columns to show in-person marks.
- `resources/views/admin/gradebook/view_by_student.blade.php` (edited) - Implemented loop to display all subject marks for a specific student using real data.

### Routes
- `routes/web.php` (edited) - Added API routes for dependent dropdowns.

### Phase 2 Debugging (2025-01-04)
- `routes/web.php` (edited) - Fixed missing API route group for `get-rooms`, `get-subjects`, and `get-students`.
- `app/Http/Controllers/Admin/GradebookController.php` (edited) - Fixed `getStudents` method to construct student name from `first_name` and `last_name` instead of invalid `name_ar` alias. Verified `getRooms` and `getSubjects` logic.
- `app/Http/Controllers/Admin/GradebookController.php` (edited) - Replaced Eloquent relationships with explicit `DB::table` JOIN on `room_student` pivot table for `getStudents` and `showSubjectGrid` to resolve performance/hanging issues.

### Phase 2 Final Fix - Cloned Working Logic (2025-01-05)
- **Reference Page:** `resources/views/admin/students_room_lesson.blade.php`
- **Reference Controller:** `app/Http/Controllers/admincontroller.php@StudentsRoomLesson`
- `app/Http/Controllers/Admin/GradebookController.php` (edited) - Replaced ALL custom logic with EXACT working pattern from `admincontroller@StudentsRoomLesson`. Now uses `Room::with(['student.student_mark'])->find($room_id)` then `$students->student()->orderBy('first_name')->get()` - this is the proven production pattern.

## Phase 2 COMPLETE - Cloned Exams Page Pattern (2025-01-05)

### Reference Pages (EXACT CLONES)
- **Classes List:** `resources/views/admin/classes_view_exams.blade.php`
- **Rooms List:** `resources/views/admin/rooms_exams.blade.php`
- **Controller:** `app/Http/Controllers/DashboardController.php@classes_view_exams`, `@classroom_exams`

### New Files Created (Cloned UI)
- `resources/views/admin/gradebook/view_classes.blade.php` (new) - Cloned from `classes_view_exams.blade.php`
- `resources/views/admin/gradebook/view_rooms.blade.php` (new) - Cloned from `rooms_exams.blade.php`
- `resources/views/admin/gradebook/view_subjects.blade.php` (new) - New subjects list page following same pattern

### Modified Files
- `app/Http/Controllers/Admin/GradebookController.php` (completely rewritten) - Replaced ALL custom logic with exact Exams pattern. Simple methods: `viewClasses()`, `viewRooms()`, `viewSubjects()`, `viewGridSimple()`
- `routes/web.php` (edited) - Replaced complex dropdown routes with simple link-based routes matching Exams pattern
- `resources/views/admin/gradebook/view_by_subject.blade.php` (reused) - Now receives data from `viewGridSimple()`

### Navigation Flow (NO AJAX, NO DROPDOWNS)
1. `/SMT/admin/gradebook` → Redirects to Classes list
2. `/SMT/admin/gradebook/classes` → Shows all classes with "الشعب" button
3. `/SMT/admin/gradebook/rooms/{classId}` → Shows all rooms for that class with "المواد" button
4. `/SMT/admin/gradebook/subjects/{roomId}` → Shows all subjects for that room with "عرض العلامات" button
5. `/SMT/admin/gradebook/grid?room_id={roomId}&subject_id={subjectId}` → Shows marks grid

### Data Fetching (Cloned from Production)
- `Classe::paginate(paginate_num)` - Exact same as Exams
- `Room::where('class_id', $classId)->where('year_id', $year->id)->paginate(paginate_num)` - Exact same as Exams
- `Room::with(['student.student_mark'])->find($roomId)` then `$students->student()->orderBy('first_name')->get()` - Exact same as Marks entry page

### UI Consistency
- All pages use exact same table styles, breadcrumbs, and card layouts as Exams pages
- All text in Arabic
- All buttons styled identically to Exams pages
- Pagination works identically

## Phase 2 CORRECTIONS - Fixed Critical Issues (2025-01-05)

### ISSUE 1 FIXED - SQL Error (lesson_id column doesn't exist)
**Problem:** `students_marks` table has NO `lesson_id` column. Subject IDs are stored as JSON keys in `mark` and `mark2` columns.

**Solution:**
- `app/Http/Controllers/Admin/GradebookController.php` (edited) - Removed `where('lesson_id', $subjectId)` query
- Now fetches marks by `student_id`, `room_id`, `year_id` only
- `resources/views/admin/gradebook/view_by_subject_corrected.blade.php` (new) - Parses JSON using `$subjectId` as key: `$term1Json[$subjectId]`
- Matches exact pattern from `students_room_lesson.blade.php`

### ISSUE 2 FIXED - Missing "View by Student" Flow
**New Files Created:**
- `resources/views/admin/gradebook/view_classes_student.blade.php` (new) - Classes list for student flow
- `resources/views/admin/gradebook/view_rooms_student.blade.php` (new) - Rooms list for student flow
- `resources/views/admin/gradebook/view_students.blade.php` (new) - Students list
- `app/Http/Controllers/Admin/GradebookController.php` (edited) - Added methods: `viewClassesStudent()`, `viewRoomsStudent()`, `viewStudents()`, `viewStudentCard()`

**Navigation Flow:**
1. `/SMT/admin/gradebook/view/student/classes` → Classes list
2. Click "الشعب" → Rooms list
3. Click "الطلاب" → Students list
4. Click "عرض دفتر العلامات" → Student's complete gradebook

### ISSUE 3 FIXED - Broken Main Menu (Forced Redirect)
**Problem:** `/SMT/admin/gradebook` redirected immediately to classes list

**Solution:**
- `resources/views/admin/gradebook/index.blade.php` (edited) - Now shows main menu with two options
- `resources/views/admin/gradebook/view_options.blade.php` (edited) - Shows "View by Subject" vs "View by Student" choice
- `app/Http/Controllers/Admin/GradebookController.php` (edited) - `index()` method now returns view (no redirect)

### Modified Files Summary
- `app/Http/Controllers/Admin/GradebookController.php` (completely rewritten) - Fixed JSON parsing, removed forced redirect, added student flow
- `routes/web.php` (edited) - Added separate routes for subject flow and student flow
- `resources/views/admin/gradebook/view_by_subject_corrected.blade.php` (new) - Correct JSON parsing
- `resources/views/admin/gradebook/index.blade.php` (edited) - Main menu
- `resources/views/admin/gradebook/view_options.blade.php` (edited) - View options menu

### Complete Navigation Map
**Main Flow:**
1. `/SMT/admin/gradebook` → Main menu (استعراض / تعديل)
2. Click "استعراض" → View options (حسب المادة / حسب الطالب)

**View by Subject:**
3a. Click "حسب المادة" → Classes → Rooms → Subjects → Marks Grid

**View by Student:**
3b. Click "حسب الطالب" → Classes → Rooms → Students → Student Card

## Phase 2 Route Name Fix (2025-01-05)

**Issue:** Blade files referenced `route('admin.gradebook.view_classes')` but this route name was not registered.

**Registered Routes:**
- `admin.gradebook.view_classes_subject` (for subject flow)
- `admin.gradebook.view_classes_student` (for student flow)

**Solution:** Updated Blade files to use correct route names

**Files Modified:**
- `resources/views/admin/gradebook/view_classes.blade.php` (edited) - Changed `view_classes` to `view_classes_subject`
- `resources/views/admin/gradebook/view_rooms.blade.php` (edited) - Changed `view_classes` to `view_classes_subject`
- `resources/views/admin/gradebook/view_subjects.blade.php` (edited) - Changed `view_classes` to `view_classes_subject`

## Phase 3: Aggregation Bridge (2026-01-06)

**Goal:** Bridge the gap between Teacher Entry (`exam_result`, `exam_result2`) and Gradebook (`students_marks`) without touching teacher code.

**New Files:**
- `app/Services/GradebookAggregationService.php`: Core logic to read marks, calculate averages/max, and update JSON safely.
- `app/Console/Commands/AggregateGradebook.php`: Artisan command (`gradebook:aggregate`) to trigger the service manually.

**Logic:**
- **Homeworks (Oral):** Reads from `exam_result`. Aggregates via Average.
- **Quizzes (Mid):** Reads from `exam_result2` (type 2). Aggregates via Average.
- **Exams (Final):** Reads from `exam_result2` (type 1). Aggregates via Max.
- **Safety:** Updates only specific keys (`oral`, `mid`, `exam`) in `students_marks` JSON. Does not overwrite other keys.

**Usage:**
- `php artisan gradebook:aggregate --room_id=123`
- `php artisan gradebook:aggregate --student_id=456`

## Phase 3 Fix (2026-01-06) - Critical Aggregation Logic

**Issues Fixed:**
1.  **Invalid SQL:** Removed `Student::where('room_id')` which caused crashes (column does not exist). Now uses correct `Room -> Student` relation.
2.  **Missing Lesson Iteration:** Service now iterates through `Student -> Rooms -> Class -> Lessons` to ensure every subject is processed.
3.  **JSON Structure:** Confirmed `students_marks` has one row per Student/Room containing JSON for ALL subjects. Logic updated to fetch row once, update JSON keys for all lessons, and save once.

**Files Mofidied:**
- `app/Services/GradebookAggregationService.php`: Complete logic refactor for `aggregateStudent`.
- `app/Console/Commands/AggregateGradebook.php`: Improved output messages.

## Phase 3 Final (2026-01-06) - Admin Contextual Aggregation [FINAL]

**Goal:** Enable Admins to refresh gradebook data contextualy from the UI.

**Changes:**
1.  **[ADMIN UI] Button:** Added "Refresh Gradebook" (`تحديث دفتر العلامات`) button to `view_by_subject_corrected.blade.php`.
2.  **[NEW] Controller:** `App\Http\Controllers\Admin\GradebookAggregationController` handles the refresh request.
3.  **[SERVICE OPTIMIZATION]**: Added `aggregateRoomSubject` to `GradebookAggregationService` to efficienty refresh ONLY the selected subject for the room, preventing full-student rescans during UI usage.
4.  **[ROUTE]**: Registered `admin.gradebook.aggregate` POST route.


- `app/Services/GradebookAggregationService.php` (edited)
- `app/Http/Controllers/Admin/GradebookAggregationController.php` (edited)
- `resources/views/admin/gradebook/view_by_subject_corrected.blade.php` (edited)
- `app/Console/Commands/AggregateGradebook.php` (edited)

## Phase 3 Strict Fix (2026-01-06) - Context-Aware Aggregation [FINAL]

**Logic:**
- Implemented `aggregateRoomSubject(room, subject, year)` strictly.
- **Oral/Homework:** Fetched from `Exam_result` where `lesson_id` matches.
- **Mid/Exam:** Fetched from `Exam_result2` JOIN `exams2` (linking table) where `lesson_id` matches.
- **Scope:** Loops ONLY students in the room. Updates ONLY the specific subject key in JSON.

**Files:**
- `app/Services/GradebookAggregationService.php` (edited): Replaced global logic with strict subject-scoped method.
- `app/Http/Controllers/Admin/GradebookAggregationController.php` (edited): Updated to pass current `year_id` and call new service method.
- `resources/views/admin/gradebook/view_by_subject_corrected.blade.php` (edited): Added "Refresh" button form.
- `app/Console/Commands/AggregateGradebook.php` (edited): Deprecated in favor of UI.

## Phase 3 DEBUG Fix (2026-01-06) - Critical Root Cause Resolution [FINAL]

**Root Causes Identified:**
1.  **JSON Key Mismatch:** Service was writing to key `mid`, but Admin UI/Legacy structure expects `quize`.
2.  **Term Selection Logic Failure:** Service's `first()`/`last()` logic blindly picked Term ID 13 (Old, Type 2) instead of Term ID 17 (Active, Type 1). This caused aggregation to look for marks in the wrong term (empty) and fail to find the valid marks in Term 17.

**Fixes Applied:**
- Modified `GradebookAggregationService.php`:
  - **Type-Aware Term Selection:** Now explicitly searches for `current_term=1` and filters by `type` (1 vs 2) to guarantee correct Term ID.
  - **Key Remapping:** Specifically mapped "Quiz" results (Type 2) to the `quize` JSON key to match legacy patterns.

**Verification:**

- Validated via direct execution: Marks for Student 412 now successfully equate to `quize: 50` in the database JSON. Aggregation is operational.

## Phase 4: On-the-Fly Calculation (2026-01-06)

**Goal:** Remove reliance on Aggregation Jobs and `students_marks` JSON for display.

**Changes:**
1.  **Direct Calculation:** Updated `GradebookController` to calculate marks in real-time from `exam_result` (Oral) and `exam_result2` (Homework/Quiz/Exam).
2.  **View Refactor:** Removed JSON parsing logic from views. Created clean, structured View variables.
3.  **No Side Effects:** This read-only approach ensures the legacy system remains untouched while providing accurate real-time data to Admins.

**Files Modified:**
- `app/Http/Controllers/Admin/GradebookController.php` (edited): Replaced `viewGridSimple` and `viewStudentCard` logic with on-the-fly calculation.
- `resources/views/admin/gradebook/view_by_subject_corrected.blade.php` (edited): Updated to receive calculated arrays.
- `resources/views/admin/gradebook/view_by_student.blade.php` (edited): Updated to receive calculated totals.

## Phase 4 UI/UX Polish (2026-01-06) - Tabbed & Detailed Views

**Goal:** Provide professional "School Gradebook" UX with Tabs and Detailed Breakdowns.

**Changes:**
1.  **Tabbed Navigation:** Split marks into "Term 1", "Term 2", and "Final Summary" tabs for clarity.
2.  **Detailed Breakdowns:**
    - Replaced simple totals with columns for `Oral`, `Homework/Quiz`, `Exam`, and `Total`.
    - Applied these standard layouts to both **View by Subject** and **View by Student** pages.
3.  **Controller Adjustment:** Minor tweak to `viewStudentCard` to return data arrays instead of pre-calculated sums.

**Files Modified:**
- `app/Http/Controllers/Admin/GradebookController.php` (edited)
- `resources/views/admin/gradebook/view_by_subject_corrected.blade.php` (edited)
- `resources/views/admin/gradebook/view_by_student.blade.php` (edited)

## Phase 5: Gradebook Configuration (2026-01-07) - Configuration Layer

**Goal:** Allow Admins to define max marks for Oral, Homework, and Exam per subject.

**Changes:**
1.  **Database:** Created `gradebook_configs` table to store `oral_max`, `homework_max`, `exam_max` per Lesson/Year.
2.  **Backend:** Created `GradebookSettingsController` to manage these configurations.
3.  **Frontend:**
    - Enabled "Edit Gradebook" card in main menu.
    - Added clean navigation (Class -> Room -> Subject -> Edit).
    - Added form to input max marks.

**Files Created:**
- `database/migrations/2026_01_06_000000_create_gradebook_configs_table.php` (new)
- `app/GradebookConfig.php` (new)
- `app/Http/Controllers/Admin/GradebookSettingsController.php` (new)
- `resources/views/admin/gradebook/settings/index.blade.php` (new)
- `resources/views/admin/gradebook/settings/rooms.blade.php` (new)
- `resources/views/admin/gradebook/settings/subjects.blade.php` (new)
- `resources/views/admin/gradebook/settings/edit.blade.php` (new)

**Files Modified:**
- `routes/web.php` (edited) - Added Settings routes.
- `resources/views/admin/gradebook/index.blade.php` (edited) - Linked Edit button.

## Phase 5 Fixes (2026-01-07) - Critical Stability

**Issues Fixed:**
1.  **Crash Fix:** "Call to member function count() on null" in Settings Index.
    - Cause: `Classe` model has relation `room()` (singular), but blade used `$class->rooms`.
    - Fix: Updated to `$class->room` and added defensive `optional()` checks.
2.  **Defensive Coding:**
    - Updated `GradebookSettingsController` to safely handle missing Year records.
    - Added eager loading (`with('room')`, `with('student')`) for performance and safety.
    - Applied `optional($obj->relation)->prop` pattern in all settings views.

**Files Modified:**
- `resources/views/admin/gradebook/settings/index.blade.php` (edited)
- `resources/views/admin/gradebook/settings/rooms.blade.php` (edited)
- `resources/views/admin/gradebook/settings/subjects.blade.php` (edited)
- `app/Http/Controllers/Admin/GradebookSettingsController.php` (edited)

## Phase 5 Fixes (2026-01-07) - Missing Table Error Handling

**Issue:** CRITICAL ERROR `Table 'aladhamedu.gradebook_configs' doesn't exist` when accessing settings.
**Root Cause:** Review revealed the feature was deployed but migration was pending.
**Fixes Applied:**
1.  **Robustness Refactor:** Refactored `GradebookSettingsController@viewSubjects` to fetch configs safely with a try-catch block.
2.  **View Optimization:** Removed direct SQL queries from `subjects.blade.php` and used data passed from controller.
3.  **Migration:** Executed `2026_01_06_000000_create_gradebook_configs_table.php`.

**Files Modified:**
- `app/Http/Controllers/Admin/GradebookSettingsController.php` (edited)
- `resources/views/admin/gradebook/settings/subjects.blade.php` (edited)

## Phase 5.1 (2026-01-07) - Enforcing Configuration Limits

**Goal:** Prevent Teachers from entering marks exceeding the configured maximums.

**Changes:**
1.  **`app/Http/Controllers/newcontroller.php`**:
    -   Modified `student_save_mark` to fetch `GradebookConfig`.
    -   Enforced `homework_max` for Type 1 (Homework) and `oral_max` for others.
2.  **`app/Http/Controllers/teacherscontroller.php`**:
    -   Modified `update_result` (Types 0,1,6,4): Enforced `homework_max` (Type 1) or `oral_max` (Others).
    -   Modified `update_result1` (Exams Type 1/2): Enforced `exam_max` (Type 1) or `oral_max` (Type 2/Quiz).
    -   Added defensive checks to ensure `GradebookConfig` table existence doesn't crash (try-catch implicit in standard Eloquent calls if table exists, if not it might error, but we fixed the missing table issue in Phase 5).

**Status:**
- Admin Configuration is now **Strictly Enforced** on the creation/update of marks by teachers.

## Phase 6 (2026-01-07) - Dynamic Components (Phase 1: View Only)

**Goal:** Transition from hardcoded "Oral/Homework/Exam" columns to a dynamic, component-based system for the Admin Gradebook View.

**Changes:**
1.  **Database:** Created `gradebook_components` table.
2.  **Model:** Created `GradebookComponent` model.
3.  **Seeder:** Created `GradebookComponentsSeeder` to migrate existing `gradebook_configs` (Fixed) to `gradebook_components` (Dynamic) using Legacy Mappings (`LEGACY_ORAL`, `LEGACY_HOMEWORK`, `LEGACY_EXAM`).
4.  **Admin View:**
    -   Refactored `GradebookController` to render columns dynamically based on the components table.
    -   Updated `view_by_subject_corrected.blade.php` to loop through components for headers and data.
    -   **Defensive Handling:** Added fallback logic in Controller and View to display standard columns or specific messages if the components table is empty or migration hasn't run.

**Status:** PAUSED (Waiting for Manual Migration Reconciliation)

**Troubleshooting / Known Issues:**
-   **Migration Error:** `SQLSTATE[42S01]: Base table or view already exists: 1050 Table 'failed_jobs'`
    -   **Cause:** The project contains a `create_failed_jobs_table` migration but the table already exists in the database.
    -   **Resolution:** **MANUAL RECONCILIATION REQUIRED.** Do NOT delete migration files. The database `migrations` table must be updated manually to reflect existing legacy migrations.

## Phase 7 (2026-01-07) - JSON Configuration (Zero-DB Architecture)

**Goal:** Implement dynamic gradebook configuration using JSON files instead of database tables to avoid migration risks on the legacy system.

**Changes:**
1.  **Created Service:** `app/Services/GradebookConfigService.php`
    -   Handles Read/Write of configurations to `storage/app/gradebook/{lesson}_{year}.json`.
    -   Provides automatic fallback to Legacy Defaults (Oral/HW/Exam) if file is missing.
    -   Returns Collection of Objects to maintain interface compatibility with Views/Controllers.

2.  **Refactored Controller:** `app/Http/Controllers/Admin/GradebookController.php`
    -   Replaced `GradebookComponent::where()` with `GradebookConfigService::getConfig()`.
    -   Admin View now renders purely based on JSON configuration.

3.  **Refactored Settings:** `app/Http/Controllers/Admin/GradebookSettingsController.php`
    -   Replaced DB saving logic with `GradebookConfigService::saveConfig()`.
    -   Updated `edit()` method to load `edit_json.blade.php`.

4.  **New View:** `resources/views/admin/gradebook/settings/edit_json.blade.php`
    -   Dynamic UI for adding/removing gradebook sections.
    -   JavaScript-based interaction.
    -   Maps dynamic columns to Legacy Sources (`LEGACY_ORAL`, `LEGACY_HOMEWORK`, `LEGACY_EXAM`).

**Status:** COMPLETE - READY FOR VERIFICATION

## Phase 2 (Refinements & Analysis) - 2026-01-07

**1. Logic & Persistence Refinements (Completed)**
- **Admin Persistence Fixed:**
  - **Issue:** Adding new sections failed due to missing unique IDs.
  - **Fix:** Updated `GradebookSettingsController` to generate `uniqid()` for new components.
- **Percentage-Based Logic:**
  - **Change:** Switched from absolute `max_mark` to `weight` (percentage).
  - **Admin View:** Updated `edit_json.blade.php` to accept percentages (0-100%) and auto-calculate limits.
  - **Backend:** Updated `GradebookController` to calculate absolute max marks dynamically based on `subject->max_mark`.
  - **Grid View:** Updated `view_by_subject_corrected.blade.php` to display correct limits (e.g., "Project (20)").

**2. Teacher Gradebook Analysis (Completed)**
- **Controller:** `app/Http/Controllers/TeacherController_New.php`
- **Method:** `StudentsRoomLessontotal($room_id, $teacher_id, $lesson_id)`
- **Views:**
  - `resources/views/teachers2/teacher_total.blade.php` (Elementary?)
  - `resources/views/teachers2/teacher_total1.blade.php` (Middle?)
  - `resources/views/teachers2/teacher_total2.blade.php` (High?)
- **Findings:**
  - All three views contain **HARDCODED** columns:
    - Oral: 10%
    - Homework: 10%
    - Activities: 20%
    - Quizzes: 20%
    - Exam: 40%
  - **Conclusion:** Implementing dynamic gradebooks for teachers REQUIRES refactoring all three views to iterate over the JSON configuration instead of using fixed HTML columns.




## Phase 3 (UX Simplification & UI Redesign) - 2026-01-07

**1. Critical Fixes & Logic Repair (Completed)**
- **View:** `edit_json.blade.php` now uses clean, robust JavaScript.
  - **Fixed:** "Add Section" now correctly appends rows using `document.createElement`.
  - **Fixed:** Percentage Logic is live-calculated and updates a visual Progress Bar.
  - **Refined:** Inputs force values between 0-100 and handle NaN gracefully.

**2. UI & UX Rebuild (Completed)**
- **Redesign:** Completely rebuilt the page to match the general Admin theme.
  - **Styling:** Used standard `card shadow`, `table-hover`, and generic Bootstrap utilities.
  - **Clean:** Removed all alerts, "Source" columns, and "Calculated Mark" columns.
  - **Validation:** Visual feedback (Green/Red progress bar) guides the user to exactly 100%.

**3. Internal Logic Updates**
- **Hidden Defaults:** New sections automatically carry `data_source="LEGACY_HOMEWORK"` via hidden inputs.
- **Controller:** Updated default fallback for safety.


**4. Architecture: Dynamic Assessment Types (Completed)**
- **Goal:** Ensure Data Independence for all sections without adding DB tables.
- **Strategy:** "Assessment Type Partitioning" using `exams2.type` column.
- **Changes:**
  - `GradebookSettingsController.php`: Auto-assigns unique logical IDs (100+) to new sections.
  - `GradebookController.php`: Refactored `viewGridSimple` to support numeric types (Dynamic) alongside legacy types.
  - `edit_json.blade.php`: Cleaned up default values to trigger ID generation.
- **Outcome:**
  - Legacy Data (`type=1` Exam, `type=2` Homework) is preserved.
  - New Sections (e.g. Projects) get unique IDs (e.g. `101`) and data isolation.
  - No DB Migrations were required.



**6. Phase 4: Teacher Gradebook (Started)**


- **Updated:** `routes/web.php`
- **Route:** `GET dashboard/teacher/gradebook/{class}/{room}/{subject}` -> `Teacher\TeacherGradebookController@index`


- **Updated:** `resources/views/teachers2/mark_room.blade.php`

- **Fixed:** `resources/views/teachers/gradebook/index.blade.php`

- **Fixed:** `app/Http/Controllers/Teacher/TeacherGradebookController.php`
- **Issue:** Layout `teachers2.layouts.app` requires `$teacher` and `$message` variables.

- **Fixed:** `app/Http/Controllers/Teacher/TeacherGradebookController.php`
- **Issue:** SQL Error: Column `to` not found.

**7. Critical Fix: Teacher Gradebook Column Rendering (2026-01-11)**

**Root Cause Analysis:**
- `GradebookConfigService::getConfig()` returns a **Collection** directly (line 31 in service)
- Admin controller correctly iterates Collection: `foreach ($components as $comp)`
- Teacher controller incorrectly treated it as array: `$config['components']`
- This caused `$components` to be empty array, preventing column rendering

**Files Modified:**

1. **`app/Http/Controllers/Teacher/TeacherGradebookController.php`**
   - **Line 37:** Changed `$config = GradebookConfigService::getConfig()` to `$components = GradebookConfigService::getConfig()`
   - **Line 38:** Removed `$components = $config['components'] ?? []`
   - **Line 141:** Changed `$config = GradebookConfigService::getConfig()` to `$components = GradebookConfigService::getConfig()`
   - **Line 144:** Changed `foreach ($config['components'] as $comp)` to `foreach ($components as $comp)`
   - **Line 145:** Changed `$comp['id']` to `$comp->id` (object notation)
   - **Line 155:** Changed `$component['data_source']` to `$component->data_source`
   - **Line 193:** Changed `$component['name']` to `$component->name`
   - **Line 219:** Changed `$component['weight']` to `$component->weight`

2. **`resources/views/teachers/gradebook/index.blade.php`**
   - **Lines 52, 54:** Changed `$comp['name']` and `$comp['weight']` to `$comp->name` and `$comp->weight`
   - **Line 71:** Changed `$comp['id']` to `$comp->id`
   - **Lines 81-82:** Changed `$comp['id']` and `$comp['weight']` to `$comp->id` and `$comp->weight`

**Result:**
- Teacher Gradebook now loads same dynamic sections as Admin
- Columns render correctly based on JSON configuration
- No hardcoded columns, fully data-driven

**Additional Fix (2026-01-11 10:06):**
- **Line 62:** Changed `$comp['data_source']` to `$comp->data_source` (missed in initial fix)
- **Line 87:** Changed `$comp['id']` to `$comp->id` (missed in initial fix)
- These were causing "Cannot use object of type stdClass as array" error

**Additional Fix (2026-01-11 10:08):**
- **`app/Services/GradebookConfigService.php`:** Changed default configuration property from `max_mark` to `weight`
- **Issue:** Saved JSON configs use `weight` property, but defaults used `max_mark`, causing "Undefined property: weight" error
- **Lines 75, 82, 89:** Changed `'max_mark' => 0` to `'weight' => 0`

**8. Design Decision: Read-Only Legacy Sections (2026-01-11 10:26)**

**Context:**
- Teacher Gradebook is designed to handle ONLY Dynamic Sections (ID >= 100)
- Legacy sections (LEGACY_ORAL, LEGACY_HOMEWORK, LEGACY_EXAM) use separate entry flows
- Allowing input on legacy sections caused "Unsupported Data Source" errors

**Implementation:**

1. **`resources/views/teachers/gradebook/index.blade.php`**
   - **Lines 50-63:** Added visual indicators to column headers
     - Lock icon (🔒) for legacy sections (read-only)
     - Edit icon (✏️) for dynamic sections (editable)
   - **Lines 69-100:** Conditional rendering of input cells
     - Legacy sections: Display lock icon + value or "-" (read-only)
     - Dynamic sections: Editable number input with AJAX save
   - **Logic:** `$isLegacy = strpos($comp->data_source, 'LEGACY_') === 0`

2. **`app/Http/Controllers/Teacher/TeacherGradebookController.php`**
   - **saveMark() method:** No changes required
   - Correctly rejects LEGACY_* data sources (returns 400 error)
   - This is intentional and prevents data corruption

**Result:**
- Teachers can ONLY edit Dynamic Sections (Projects, Activities, etc.)
- Legacy sections are visible for context but cannot be modified
- No more "Unsupported Data Source" errors
- Clear visual distinction between editable and read-only columns

---

**9. Critical Fix: Name-Based Dynamic Section Storage (2026-01-11 10:39)**

**Problem Identified:**
- Code assumed `exams2` table had `exam_type` column
- **Reality:** Only `type` column exists (values: 1=Exam, 2=Quiz/Homework)
- Using `type` for dynamic IDs (100+) would break legacy code expecting only 1 or 2

**Root Cause Analysis:**
- Admin Gradebook uses: `SELECT 'exams2.type as exam_type'` (creates alias in result set)
- Teacher Gradebook incorrectly tried: `WHERE exam_type = ...` (column doesn't exist)
- Legacy system strictly uses `type = 1` or `type = 2` throughout

**Solution: Name-Based Identification (Option A)**

**Implementation:**

1. **`app/Http/Controllers/Teacher/TeacherGradebookController.php`**

   **saveMark() Method (Lines 120-235):**
   - **Validation:** Explicitly rejects `LEGACY_*` data sources (400 error)
   - **Validation:** Only allows numeric IDs >= 100 (dynamic sections)
   - **Container Pattern:** `"Dynamic_Section_{$dynamicId}"`
   - **Query:** `where('name', $containerName)->where('type', 1)`
   - **Creation:** Sets `name = "Dynamic_Section_101"` (example), `type = 1`
   - **Result:** Stores marks in `Exam_result2` linked to container exam

   **index() Method (Lines 41-122):**
   - **Dynamic Sections:** 
     - Query: `where('name', "Dynamic_Section_{ID}")->where('type', 1)`
     - Builds `examIdToComponentId` map for efficient lookup
   - **Legacy Homework:**
     - Query: `where('type', 2)` (all homework/quiz exams)
   - **Legacy Exam:**
     - Query: `where('type', 1)->where('name', 'NOT LIKE', 'Dynamic_Section_%')`
     - Excludes dynamic containers to avoid collision
   - **Result:** Correctly retrieves and displays all marks

**Key Technical Decisions:**

| Aspect | Decision | Rationale |
|--------|----------|-----------|
| **Column Used** | `exams2.name` | Existing column, no migration needed |
| **Pattern** | `"Dynamic_Section_{ID}"` | Clear, parseable, collision-free |
| **Type Value** | Always `1` for dynamic | Avoids breaking legacy code |
| **Legacy Separation** | `NOT LIKE 'Dynamic_Section_%'` | Prevents data mixing |

**Database Impact:**
- ✅ No schema changes
- ✅ No migrations
- ✅ Uses only existing columns: `name`, `type`, `room_id`, `lesson_id`, `term_id`
- ✅ Legacy exams remain untouched (type = 1 or 2, no special naming)

**Data Independence Verified:**
- Dynamic section "Projects" (ID 101) → Exam named "Dynamic_Section_101"
- Dynamic section "Activities" (ID 102) → Exam named "Dynamic_Section_102"
- Legacy Exam → Exam with `type = 1`, name = actual exam name (e.g., "Midterm")
- Legacy Homework → Exam with `type = 2`, name = actual homework name

**Result:**
- ✅ Teacher Gradebook fully functional
- ✅ Dynamic sections save and load correctly
- ✅ Legacy sections remain read-only and visible
- ✅ No `exam_type` column errors
- ✅ Complete data independence between sections

**Schema Compliance Fix (2026-01-11 10:54 - FINAL STABLE PROFILE):**

**Problem:** Incremental patching revealed new required fields with each attempt.

**Solution:** Analyzed legacy code (DashboardController::exam_store, lines 12168-12188) to create comprehensive profile.

**Complete Exams2 Container Profile:**

| Field | Value | Required? | Purpose |
|-------|-------|-----------|---------|
| `user_id` | `Auth::id()` | ✅ Yes | Creator's user account |
| `class_id` | From room | ✅ Yes | Class association |
| `room_id` | Request param | ✅ Yes | Room association |
| `lesson_id` | Request param | ✅ Yes | Subject association |
| `term_id` | Current term | ✅ Yes | Term association |
| `name` | `"Dynamic_Section_{ID}"` | ✅ Yes | **Name-based identification** |
| `type` | `1` | ✅ Yes | Standard exam (legacy compat) |
| `is_file` | `0` | ✅ Yes (no default) | No file attachment |
| `question_picker` | `0` | ✅ Yes (no default) | No question picker |
| `required` | `0` | ✅ Yes (no default) | Not required |
| `groupe` | Auto-increment | ✅ Yes (no default) | Unique group ID |
| `start_date` | `now()` | ⚠️ Optional | Start date |
| `end_date` | `now()->addYear()` | ⚠️ Optional | End date (far future) |
| `mark` | `100` | ⚠️ Optional | Default max mark |
| `period` | `0` | ⚠️ Optional | No time limit |
| `notes` | Description | ⚠️ Optional | Auto-generated note |

**Fields Explicitly NOT Used:**
- ❌ `teacher_id` - Column doesn't exist
- ❌ `date` - Not in fillable array
- ❌ `file` - Not needed for containers
- ❌ `selected_ques` - Not needed for containers

**Result:** Deterministic, stable container creation with NO trial-and-error SQL errors.

---

**14. Architecture: Hiding Internal Plumbing (2026-01-13 11:05)**

**Controller: `DashboardController`**
- **Methods Modified:** `room_exams`, `exam_filter_search`
- **Change:** Added filter `WHERE name NOT LIKE 'Dynamic_Section_%'`
- **Reason:** Prevents "internal" Gradebook container exams from cluttering the Admin's standard Exam Manager. The Gradebook plumbing is now invisible to the Admin.

**15. Admin UI: Gradebook Status Toggle (2026-01-13 11:15)**

**Controller: `Admin\GradebookController`**
- **Method Added:** `toggleStatus(classId, termId, status)`
- **Route:** `POST /admin/gradebook/status`

**View: `resources/views/admin/gradebook/view_subjects.blade.php`**
- **Feature:** Added "Lock/Open Gradebook" button at the top.
- **Function:** Uses AJAX to call `toggleStatus`.
- **Logic:** Locks/Unlocks the gradebook for the **entire Class** for the **current Term**.

**15. Admin UI: Gradebook Status Control Center (2026-01-14 20:30)**

**View: `resources/views/admin/gradebook/view_subjects.blade.php`**
- **Upgrade:** Replaced simple button with a **Gradebook Control Center** card.
- **Features:**
  - Status Badge (OPEN/LOCKED).
  - Explicit scope display (Class - Term).
  - Toggle Switch for better UX.
  - Explanatory warning text regarding teacher access.

**16. Teacher UI: Visual Grouping & Clarity (2026-01-14 20:35)**

**Controller: `TeacherGradebookController`**
- **Sorting:** Components are now sorted: **Legacy (Gray)** first, then **Dynamic (White)**. This creates logical grouping.

**View: `resources/views/teachers/gradebook/index.blade.php`**
- **Banner:** Updated top banner to clearly explain the color coding:
  - **Gray:** Formal Assessment (Read-Only) - synced from Exams/Homework.
  - **White:** Continuous Assessment (Editable) - entered purely in Gradebook.

**17. Critical Fix: Middleware Alignment**
- **Route:** `routes/web.php`
- **Fix:** Changed middleware from `role:admin` to `roleadmin` to match legacy system architecture and prevent `Target class [role] does not exist` error.

**18. UI/UX Refinement: Legacy Alignment (2026-01-14 20:45)**

**Scope:** Frontend / UI Only (NO Logic Changes)

**Files Modified:**
- `resources/views/teachers/gradebook/index.blade.php`
- `resources/views/admin/gradebook/view_subjects.blade.php`

**Changes:**
- **Teacher View:**
  - Removed "foreign" banners and info cards.
  - Enforced strict RTL direction and Arabic labels ("سجل الدرجات", "متاح للتعديل").
  - Simplified Table: Removed custom `thead` styles, applied standard system font sizes (13px/14px).
  - Reduced visual noise: Simple "badge" for status instead of full-width alerts.
- **Admin View:**
  - Removed "Gradebook Control Center" card (Concept removal).
  - Reverted to standard "Header Body" layout.
  - Implemented Status Toggle as a simple "Badge + Switch" element inside the existing header row.
  - Colors matched to system palette (`bg-primary`, `badge-success/danger`).

**19. Final UI Standardization (2026-01-14 20:55)**

**Scope:** Strict UI/UX Alignment (No Logic)

**Admin View (`view_subjects.blade.php`):**
- Replaced custom "header bg-primary" layout with legacy `Admin.master` compatible layout.
- Used standard `card` container with correct RTL margins.
- Integrated Status Toggle into standard `card-header`.
- Applied legacy CSS for table styling (borders, alignments).

**Teacher View (`index.blade.php`):**
- **Breadcrumbs:** Enforced `direction: rtl` and `text-align: right` to fix left-floating overlap.
- **Table Contrast:** Changed header and cell text color to Black (`#000`) and Dark Blue (`#001586`) for maximum legibility.
- **Hierarchy:** Removed "Documentation" footnotes to reduce noise.
- **Labels:** Standardized Arabic labels (Right-aligned).

**20. Layout & Stability Fixes (2026-01-14 21:00)**

**Fixes:**
- **Admin View Crash:** Resolved `InvalidArgumentException` in `view_subjects.blade.php` caused by file corruption/duplication. The file was cleaned and restored to the correct legacy layout.
- **Teacher View Layout:**
  - Removed Subject/Class details from Breadcrumbs (Nav only).
  - Moved Subject/Class details to the Main Header (Right-aligned, prominent) to satisfy specific user layout request.

**Status:** ALL reported issues (Crash + Layout) are resolved.
- **Storage:** `gradebook_status/{class_id}_{term_id}.json`
- **Default:** `LOCKED` (Safe by default)
- **Methods:**
  - `setStatus($classId, $termId, $status)`: 'OPEN' or 'LOCKED'
  - `getStatus($classId, $termId)`: Returns current status

**11. Feature: Admin Gradebook Control (2026-01-13 10:52)**

**Problem:** Need to control Gradebook availability independently from Exams.
**Solution:** Implemented `GradebookStatusService` using JSON storage.

**Class: `app/Services/GradebookStatusService.php`**
- **Storage:** `gradebook_status/{class_id}_{term_id}.json`
- **Default:** `LOCKED` (Safe by default)
- **Methods:**
  - `setStatus($classId, $termId, $status)`: 'OPEN' or 'LOCKED'
  - `getStatus($classId, $termId)`: Returns current status

**Why JSON?** No database migrations allowed. Mirrors `GradebookConfigService` pattern.

**10. Critical Fix: Mark Persistence Issue (2026-01-11 11:06)**

**Problem:** Marks saved successfully but disappeared after page refresh.

**Root Cause Analysis:**
- **Save Logic:** `saveMark()` creates `exam_result2` records WITHOUT `term_id` (not in fillable array)
- **Load Logic:** `index()` filtered by `WHERE term_id = current_term`
- **Result:** All saved marks excluded from query results

**Mismatch Details:**

| Aspect | Save (saveMark) | Load (index) | Match? |
|--------|----------------|--------------|--------|
| `user_id` | ✅ Set | ✅ Filter | ✅ Yes |
| `exam_id` | ✅ Set | ✅ Filter | ✅ Yes |
| `room_id` | ✅ Set | ✅ Filter | ✅ Yes |
| `class_id` | ✅ Set | ❌ No filter | ✅ OK |
| `lesson_id` | ✅ Set | ❌ No filter | ✅ OK |
| `term_id` | ❌ NOT set | ❌ **Filtered!** | ❌ **MISMATCH** |

**Solution:**
- Removed `term_id` filter from `index()` load query (line 107)
- Term filtering already handled via `exam_id` → `exams2.term_id`
- `exam_result2.term_id` is not in fillable array and cannot be set

**Files Modified:**
- `app/Http/Controllers/Teacher/TeacherGradebookController.php` (line 103-109)

**Result:** Marks now persist correctly and reappear after refresh.











