# Timetable-authoritative current Teacher assignments

Implementation date: 2026-10-29 (Asia/Damascus).
Project: `C:\Users\Lenovo\Desktop\aladhamedu`.
Laravel 7.30.6 / PHP 7.4; local database examined: `aladham_oct`.

## Result and authority model

The confirmed school policy is now implemented in code: **a current teaching responsibility exists exactly when a valid period exists for the Teacher/section/subject in the globally active year's current term**. Annual `teacher_room_lesson` rows alone grant no current academic access.

The prior implementation added a responsibility when saving a period but never ended the former Teacher's operational authority. It also mixed a raw annual-pivot section counter, a layout schedule helper without academic context, and mobile/API readers with different term predicates.

`CurrentTeacherAssignments` is the shared resolver. It validates the schedule row year and term, section year, lesson/section class, active Teacher (`active=0`), existing day, instructional slot (`type=1`), slot/section identity, and start-before-end. It does **not** require a pivot to declare a valid scheduled responsibility. The `currentTimetable` pivot scope exposes only the historical projection rows backed by that resolver.

The four requested timetable views now share that query:
- Admin `/SMT/admin/classroom/workschedule/{room}`.
- Admin `/SMT/admin/classroom/workschedule_exam/{room}`.
- Admin `/SMT/admin/teacher_schedule/{teacher}`.
- Teacher `/SMARMANger/dashboard/teacher/teacher_schedule`.

The Teacher dashboard, current class/section/subject readers, assessment and grade guards, Advanced Teacher Gradebook, Follow-up, relevant Teacher API readers, and collision checks use the same authority. An old open history period cannot bypass the timetable predicate.

**School data was not reconciled or migrated.** Effective current access already excludes stale pivot-only grants; physical responsibility-period closure for the pre-existing school data remains an approval-controlled action. No application boot hook applies the dry run.

## Historical preservation and retirement

- Annual responsibility rows are retained as historical references. Schedule synchronization never physically deletes these rows.
- After the last valid current-term period disappears or is reassigned, synchronization closes the old responsibility's open `teacher_assignment_periods` interval.
- If another valid period remains for that Teacher/section/subject, the interval remains open. Other subjects and sections are independent.
- Re-adding a Teacher reuses the annual projection and opens a new interval; a previously closed interval is not rewritten.
- Creating a pivot without a valid current timetable does not open a responsibility period. New tracking starts at the actual authorized synchronization time; no earlier teaching responsibility is invented.
- Original exam/quiz definitions, results, marks, report cards, content ownership, submissions, student identities and financial records are not copied, reassigned or deleted.
- Follow-up history remains accessible through its existing explicit history route to its original Teacher, including after retirement or for a past year. That route requires an owned assignment and either current eligibility or authored history, and returns only that Teacher's authored records.
- Historical Follow-up editing is disabled when the assignment is no longer current or the record belongs to another term. The two-hour rule still applies to current records. The server rejects edits as well as hiding the edit action.
- Previous-term timetable rows remain stored. Their term/year and academic records retain their original relationships. Assignment periods retain Teacher/class/section/year and actual effective dates; Follow-up and assessment records retain their own term IDs.
- Bell-time slot editing/deletion is blocked when the slot is shared with another term, preventing an edit from changing or deleting those other recorded timetables. A separate slot can be created for the current term.
- Historical/reporting relations were not globally converted into current-only relations. In particular, `Teacher::rooms()` remains usable for explicit historical consumers. Current Teacher pages apply the timetable resolver explicitly. `Teacher::lessons()`, which was already a global-current-year relation, now also follows the current timetable.
- Grade calculation formulas, Phase 1 assessment equivalence, continuity and provenance code were not changed.

## Transaction, update and concurrency behavior

`save_schedule` now takes a lock on the active `years` row **before** validating the editable slot, checking conflicts and writing. It retains the existing role/CSRF/input checks and executes within a retryable transaction. The existing slot transaction preserves meeting links and schedule IDs as before; it is followed by projection/history synchronization before success can be returned.

The synchronization loads the edited section's valid current contexts, creates only missing annual projections, retains existing projection IDs and closes/opens responsibility intervals. This does not copy grades or other academic rows. A normal edited-section save can also close pre-existing unscheduled intervals in that section; school-wide reconciliation was not executed by this task.

Deleting a scheduled period uses the same year lock, current context and synchronization. Instructional slot changes/deletion also synchronize the affected section. Current-term management serializes on the same year and synchronizes after an actual term change. Re-selecting an already-current term no longer clears that term accidentally.

The previously separate manual responsibility plan cannot create an unscheduled current grant: it returns a localized instruction to configure the section timetable first. It preserves annual references instead of deleting deselected pivots. Its notice explains the new policy.

Multiple Teachers may teach the same subject/section when each has periods. Weekly occurrences stay distinct; subject/section responsibilities are deduplicated for navigation. No uniqueness rule was added that would forbid co-teaching.

Conflict detection itself now reads valid current timetable rows, rather than requiring a supporting pivot. A valid period imported without a projection therefore still grants timetable context and still prevents overlapping Teacher bookings.

Modern assessment, Advanced Gradebook and Follow-up mutations also lock/revalidate the active year in their transactions so timetable replacement cannot race past their checked responsibility. The coarse year lock avoids a new locking schema; monitor lock contention during busy marking sessions. Ordinary reads take no such lock.

The local InnoDB concurrency test used two PHP worker processes against a newly created disposable database. Writer B waited while A held the year lock. Another connection saw only the fully committed old state; after both writes the final Teacher alone had current authority, both replaced intervals were closed, all three annual references remained, and an original academic sentinel was unchanged. The QA database was dropped and no temporary QA schemas remain.

## Current pages and directly related authorization changes

| Area | Implemented behavior |
|---|---|
| Teacher home, class and section cards | Sections come from valid current periods, not all annual pivots. |
| Subject and mark-entry navigation | Current timetable scope; authenticated Teacher identity remains authoritative over URL Teacher IDs. |
| Four timetable pages | Shared row eligibility, including current term, row year, grade/subject context and instructional slots. Timetable section statistic counts distinct displayed sections. |
| Collision checks | Same schedule authority, with overlapping times and replaced-row exclusions inside the lock. |
| Modern exam/quiz grading | Current timetable gate added to the existing term, roster, assessment, lock and provenance checks. |
| Advanced Teacher Gradebook | Current timetable gate and transaction context lock; calculations and data-source mapping unchanged. Admin current subject settings also show only scheduled Teachers. |
| Follow-up current index, roster, creation/editing | Timetable-backed annual projection and valid period/student context. A stale pivot/open interval is insufficient. |
| Follow-up history | Explicit owned read-only history path remains available after retirement. |
| Teacher content search | Assignment and current-year scope; subject-filtered search cannot fetch an unrelated section/subject. |
| Lecture update | Reauthorizes the destination and rejects editing content from a different year/term. |
| Web stream entry | Validates the authenticated Teacher and all schedule/day/slot/section IDs against current timetable rows before recording entry. |
| Existing Teacher class-subject helper | Previously pointed at nonexistent `studentscontroller@class_lessons`. Its existing route now uses a Teacher method returning only that authenticated Teacher's scheduled subjects for the selected class. |
| Legacy Teacher API | Classes/sections/subjects/timetable, current lessons/details/books, preparation/content and stream context now use timetable scope. Authentication compatibility limitation below remains explicit. |
| Admin student mark compatibility path | Teacher-role calls require the same timetable-backed room/subject scope. Admin behavior and formulas remain unchanged. |

Other legacy Student/history/report readers retain their original record context. This task did not globally scope historical pivots, rewrite original content authors, or redesign Student/Admin report pages.

## Legacy API compatibility decision

The user explicitly chose: **keep the existing API authentication contract in this pass, scope its data to the timetable, and document the separate authentication blocker**.

The legacy Teacher API login returns account data and does not establish a supported bearer-token/session contract. Adding authentication middleware would break existing unauthenticated mobile clients. No such middleware/account/password change was made.

Consequences:
- A stale requested Teacher/section/subject no longer resolves through a pivot-only grant.
- Current term selection is year-scoped; API timetable rows agree with the web resolver.
- **The legacy API still cannot authenticate who is supplying an arbitrary otherwise-valid Teacher ID.** Timetable scoping does not solve impersonation or protect a currently scheduled Teacher's resources against an unauthenticated caller.
- Authenticated web Teacher routes retain role and identity checks; related web search/content/stream gaps were closed.
- Token/session design, login response compatibility, endpoint ownership and mobile-client rollout remain a separate security implementation. Do not treat this pass as full API security sign-off.

## Term/year workflow implications

Current responsibility is term-specific even though its retained annual projection has no `term_id`.

Switching the current term changes current Teacher authority immediately. The term observer synchronizes responsibility periods: a Teacher scheduled only in the earlier term loses current privileges; a Teacher with new-term periods gains them. A continuing Teacher retains a valid current responsibility. Earlier schedule and academic rows are preserved.

If the new term has no configured timetable, current Teacher assignment lists are empty and academic operations are denied with the existing localized missing-context/assignment feedback. Previous terms or years are never used as a fallback. Administrators must configure the new current term's timetable through the existing section workflow. The existing UI does not acquire a new future-term preparation feature in this task.

The active-year/current-term resolver changes authority even before any reconciliation. Old annual rows and older open period metadata cannot override it. Global school-year activation/promotion workflows were not redesigned.

## Fresh school-data dry run - not executed

Re-read on 2026-10-29 using SELECTs, then checked against the **actual new resolver on local MariaDB** without booting request handlers, registering synchronization observers, or invoking synchronization.

Context: **year 6 (2026/2027) / term 20 (فصل أول 26-27)**.

| Metric | Result |
|---|---:|
| Stored annual current-year pivots | 621 |
| Valid scheduled current responsibilities | 578 |
| Valid weekly periods | 1372 |
| Annual pivots to retain as current projection | 578 |
| Pivot-only grants excluded from current authority | 43 |
| Missing projections to create in a future reconciliation | 0 |
| Existing annual pivots to physically delete | 0 |
| Current-year open intervals whose closure is proposed | 43 |
| Closed history intervals to modify | 0 |

The resolver returned **1,372 valid period rows** and **578 current projection grants**, exactly matching the independent SELECT dry run. Teacher 166's room 135 / lesson 419 and room 139 / lesson 44 contexts returned **false**. No migration or school reconciliation was invoked.

Normal timetable writes create the annual projection before committing. If periods are later imported outside that writer without projections, the schedule remains authoritative for the resolver and collision checks, but projection-ID-dependent screens such as Follow-up need the missing references repaired through an approved reconciliation. The present school data has no such missing projections; no read handler was added to reconcile the school database implicitly.

### Seven audited Teachers

The requested basename “باسل سلوم” has one stored candidate, “باسل السلوم”, Teacher 139 / User 1243. The exact spelling difference remains documented; no identity/account merge was performed.

| Stored Teacher | Teacher ID / User ID | Stored annual grants | New effective current grants | Current periods | Proposed ending pivot IDs |
|---|---|---:|---:|---:|---|

| شادن غنوم | 154 / 1258 | 10 | 9 | 23 | 1435 |
| باسل السلوم | 139 / 1243 | 3 | 2 | 4 | 1448 |
| أغيد عدي | 144 / 1248 | 5 | 4 | 16 | 1886 |
| ثريا خانم كرزون | 140 / 1244 | 9 | 8 | 16 | 1885 |
| رزان بن عمر | 85 / 643 | 9 | 8 | 16 | 1874 |
| سماهر الكور | 9 / 87 | 23 | 9 | 27 | 1499, 1588, 1593, 1611, 1612, 1622, 1624, 1628, 1639, 1644, 1655, 1677, 1689, 1690 |
| عدنان كفري | 166 / 1836 | 13 | 11 | 11 | 1905, 1906 |

All **21** extra grants from the seven-account audit are excluded by the new resolver. Their annual rows and **21 open intervals remain physically unchanged** in the school database pending separately approved reconciliation.

### School-wide ending list: 43 proposed interval closures

These rows remain stored. “Other scheduled Teachers” describes the matching current section/subject timetable; an empty value means no Teacher has a valid period for that section/subject.

| Pivot ID | Teacher (ID / User ID) | Class / section (IDs) | Subject (ID) | Open interval ID(s) | Other scheduled Teacher IDs |
|---:|---|---|---|---|---|

| 1421 | غدير خفيف (151 / 1255) | الصف الثاني (2) / الثاني - رابعة (157) | التربية الموسيقية (16) | 118 | 102 |
| 1435 | شادن غنوم (154 / 1258) | الصف الثاني (2) / الثاني - خامسة (166) | التربية الدينية (7) | 132 | 152 |
| 1448 | باسل السلوم (139 / 1243) | الصف الثاني (2) / الثاني - سادسة (167) | معلوماتية (409) | 145 | 166 |
| 1452 | دينا الوكيل (107 / 692) | الصف الثاني (2) / الثاني - سادسة (167) | المهارات الكتابية (5) | 149 | 158 |
| 1487 | أماني اسماعيل (72 / 630) | الصف الثالث (3) / الثالث - ثانية (135) | التربية البدنية و الرياضة (26) | 184 | 55 |
| 1499 | سماهر الكور (9 / 87) | الصف الثالث (3) / الثالث - ثالثة (159) | إثرائية (533) | 196 | 103, 106 |
| 1539 | كريستا حصني (102 / 660) | الصف الرابع (4) / الرابع - 1-إناث (136) | اللغة الفرنسية (416) | 236 | 61 |
| 1570 | جودي عسكر (161 / 1810) | الصف الرابع (4) / الرابع - 4 -ذكور (175) | التربية الدينية (28) | 267 | 169 |
| 1571 | جودي عسكر (161 / 1810) | الصف الرابع (4) / الرابع - 4 -ذكور (175) | المهارات الشفوية (148) | 268 | 169 |
| 1572 | جودي عسكر (161 / 1810) | الصف الرابع (4) / الرابع - 4 -ذكور (175) | الدراسات الاجتماعية (32) | 269 | 169 |
| 1575 | جودي عسكر (161 / 1810) | الصف الرابع (4) / الرابع - 4 -ذكور (175) | التربية البدنية و  الرياضة (36) | 272 | 160 |
| 1577 | جودي عسكر (161 / 1810) | الصف الرابع (4) / الرابع - 4 -ذكور (175) | المهارات الكتابية (29) | 274 | 169 |
| 1581 | جودي عسكر (161 / 1810) | الصف الرابع (4) / الرابع - 4 -ذكور (175) | إثرائية (534) | 278 | 160 |
| 1588 | سماهر الكور (9 / 87) | الصف الخامس (5) / الخامس - أولى (138) | الدراسات الاجتماعية (41) | 285 | 168 |
| 1593 | سماهر الكور (9 / 87) | الصف الخامس (5) / الخامس - أولى (138) | إثرائية (535) | 290 | 103, 148 |
| 1598 | رهف نبهان (103 / 661) | الصف الخامس (5) / الخامس - أولى (138) | التربية البدنية و  الرياضة (45) | 295 | 55 |
| 1611 | سماهر الكور (9 / 87) | الصف الخامس (5) / الخامس - الثانية (139) | الدراسات الاجتماعية (41) | 308 | 168 |
| 1612 | سماهر الكور (9 / 87) | الصف الخامس (5) / الخامس - الثانية (139) | إثرائية (535) | 309 | 103, 148 |
| 1622 | سماهر الكور (9 / 87) | الصف الخامس (5) / الخامس- الثالثة (161) | الدراسات الاجتماعية (41) | 319 | 168 |
| 1624 | سماهر الكور (9 / 87) | الصف الخامس (5) / الخامس- الثالثة (161) | إثرائية (535) | 321 | 103, 148 |
| 1628 | سماهر الكور (9 / 87) | الصف الخامس (5) / الخامس - الرابعة (170) | الدراسات الاجتماعية (41) | 325 | 168 |
| 1639 | سماهر الكور (9 / 87) | الصف الخامس (5) / الخامس - الرابعة (170) | إثرائية (535) | 336 | 103, 162 |
| 1642 | شفاء ابو امين (147 / 1251) | الصف السادس (6) / السادس-1- إناث (140) | المهارات الشفوية (47) | 339 | 9 |
| 1644 | سماهر الكور (9 / 87) | الصف السادس (6) / السادس-1- إناث (140) | الدراسات الاجتماعية (50) | 341 | 168 |
| 1646 | شفاء ابو امين (147 / 1251) | الصف السادس (6) / السادس-1- إناث (140) | المهارات الكتابية (168) | 343 | 9 |
| 1653 | شفاء ابو امين (147 / 1251) | الصف السادس (6) / السادس-1- إناث (140) | إثرائية (536) | 350 | 9, 103 |
| 1655 | سماهر الكور (9 / 87) | الصف السادس (6) / السادس- 2- إناث (141) | الدراسات الاجتماعية (50) | 352 | 168 |
| 1657 | شفاء ابو امين (147 / 1251) | الصف السادس (6) / السادس- 2- إناث (141) | إثرائية (536) | 354 | 9, 103 |
| 1658 | شفاء ابو امين (147 / 1251) | الصف السادس (6) / السادس- 2- إناث (141) | المهارات الشفوية (47) | 355 | 9 |
| 1661 | شفاء ابو امين (147 / 1251) | الصف السادس (6) / السادس- 2- إناث (141) | المهارات الكتابية (168) | 358 | 9 |
| 1670 | شفاء ابو امين (147 / 1251) | الصف السادس (6) / السادس-3-ذكور (162) | المهارات الشفوية (47) | 367 | 9 |
| 1674 | شفاء ابو امين (147 / 1251) | الصف السادس (6) / السادس-3-ذكور (162) | المهارات الكتابية (168) | 371 | 9 |
| 1677 | سماهر الكور (9 / 87) | الصف السادس (6) / السادس-3-ذكور (162) | الدراسات الاجتماعية (50) | 374 | 168 |
| 1679 | شفاء ابو امين (147 / 1251) | الصف السادس (6) / السادس-3-ذكور (162) | إثرائية (536) | 376 | 9, 103 |
| 1689 | سماهر الكور (9 / 87) | الصف السادس (6) / السادس-4-ذكور (173) | الدراسات الاجتماعية (50) | 386 | 168 |
| 1690 | سماهر الكور (9 / 87) | الصف السادس (6) / السادس-4-ذكور (173) | إثرائية (536) | 387 | 103, 162 |
| 1814 | أمير عدي (90 / 648) | الصف التاسع (58) / التاسع-2-إناث (147) | رياضيات (472) | 511 | 22 |
| 1874 | رزان بن عمر (85 / 643) | الصف الحادي عشر (60) / الحادي عشر-1-إناث (150) | رياضيات (498) | 571 | 90 |
| 1885 | ثريا خانم كرزون (140 / 1244) | الصف الحادي عشر (60) / الحادي عشر-2-ذكور (151) | اللغة الإنكليزية (499) | 582 | 118 |
| 1886 | أغيد عدي (144 / 1248) | الصف الحادي عشر (60) / الحادي عشر-2-ذكور (151) | علوم (496) | 583 | 136 |
| 1905 | عدنان كفري (166 / 1836) | الصف الخامس (5) / الخامس - الثانية (139) | التربية الفنية البصرية و الجمالية (44) | 602 | 141 |
| 1906 | عدنان كفري (166 / 1836) | الصف الثالث (3) / الثالث - ثانية (135) | معلوماتية (419) | 603 | 72 |
| 1910 | رشا برازي (55 / 219) | الصف الثالث (3) / الثالث - رابعة (168) | التربية الفنية البصرية و الجمالية (25) | 607 | 111 |

### Complete retain/end manifest for the current school year

Every annual pivot is listed exactly once below. Retain entries use **pivot_id@room_id/lesson_id**. Each retained key has at least one valid current-term period in the independent SELECT result and the shared resolver. End entries are proposed closures, not deletes. Class/year are verified by each section/subject context.

| Teacher (ID) | Retain as current (count and full pivot/section/subject list) | End current interval (full pivot IDs) |
|---|---|---|

| آمنة دويك (8) | **4**: 1725@163/435, 1738@174/435, 1777@164/455, 1786@176/455 | none |
| سماهر الكور (9) | **9**: 1652@140/536, 1669@141/536, 1672@162/536, 1919@140/47, 1921@140/168, 1925@141/47, 1927@141/168, 1930@162/47, 1931@162/168 | 1499, 1588, 1593, 1611, 1612, 1622, 1624, 1628, 1639, 1644, 1655, 1677, 1689, 1690 |
| مخلصة زلوخ (22) | **5**: 1699@142/439, 1711@143/439, 1751@144/458, 1764@145/458, 1815@147/472 | none |
| لما زلوخ (23) | **4**: 1727@163/439, 1736@174/439, 1776@164/458, 1790@176/458 | none |
| هبة المصري (26) | **10**: 1463@134/147, 1464@134/19, 1465@134/22, 1466@134/20, 1467@134/21, 1470@134/23, 1472@134/25, 1474@134/26, 1475@134/419, 1476@134/533 | none |
| زينة موسى باشا (27) | **9**: 1305@130/151, 1306@130/133, 1307@130/10, 1308@130/130, 1309@130/8, 1311@130/531, 1314@130/12, 1315@130/4, 1317@130/9 | none |
| لينا العلي (28) | **4**: 1703@142/435, 1712@143/435, 1750@144/455, 1761@145/455 | none |
| عبير علواني (29) | **3**: 1823@165/476, 1832@177/476, 1853@149/484 | none |
| سالي برشيني (52) | **2**: 1411@157/6, 1423@166/6 | none |
| رشا برازي (55) | **20**: 1498@159/26, 1514@168/26, 1524@169/26, 1592@138/45, 1606@139/45, 1623@161/45, 1634@170/45, 1648@140/54, 1663@141/54, 1680@162/54, 1693@173/54, 1701@142/454, 1713@143/454, 1753@144/469, 1766@145/469, 1803@146/479, 1813@147/479, 1842@148/490, 1863@150/506, 1907@135/26 | 1910 |
| ميلاد برشيني (60) | **8**: 1597@138/43, 1609@139/43, 1625@161/43, 1636@170/43, 1654@140/52, 1666@141/52, 1682@162/52, 1695@173/52 | none |
| رنيم الكردي (61) | **17**: 1473@134/415, 1484@135/415, 1496@159/415, 1517@168/415, 1530@169/415, 1543@136/416, 1556@137/416, 1568@160/416, 1582@175/416, 1584@138/417, 1601@139/417, 1616@161/417, 1637@170/417, 1645@140/418, 1667@141/418, 1683@162/418, 1694@173/418 | none |
| تيماء طيفور (63) | **13**: 1726@163/447, 1728@163/450, 1733@163/448, 1741@174/450, 1743@174/448, 1747@174/447, 1775@164/465, 1784@164/462, 1785@164/463, 1789@176/465, 1794@176/462, 1797@176/463, 1858@149/487 | none |
| احمد فخري (64) | **9**: 1821@165/477, 1829@165/478, 1837@177/477, 1840@177/478, 1854@149/491, 1855@149/492, 1868@150/504, 1877@151/504, 1899@153/523 | none |
| أماني اسماعيل (72) | **9**: 1477@135/147, 1478@135/19, 1480@135/23, 1481@135/20, 1482@135/21, 1485@135/419, 1486@135/22, 1488@135/533, 1490@135/25 | 1487 |
| هزار الموسى (74) | **9**: 1319@131/151, 1320@131/130, 1322@131/12, 1323@131/8, 1324@131/10, 1325@131/133, 1327@131/4, 1328@131/9, 1329@131/531 | none |
| أيمن كردي (75) | **14**: 1709@142/447, 1710@142/448, 1717@143/447, 1723@143/448, 1758@144/462, 1760@144/463, 1769@145/462, 1773@145/463, 1807@146/477, 1808@146/478, 1817@147/477, 1820@147/478, 1846@148/491, 1850@148/492 | none |
| عزة قاشوش (76) | **9**: 1370@132/13, 1372@132/15, 1373@132/146, 1374@132/5, 1375@132/14, 1376@132/532, 1377@132/7, 1380@132/17, 1382@132/134 | none |
| رولا عبود (77) | **12**: 1706@142/445, 1722@143/445, 1731@163/445, 1746@174/445, 1759@144/461, 1772@145/461, 1782@164/461, 1796@176/461, 1849@148/521, 1859@149/521, 1871@150/522, 1880@151/522 | none |
| رزان بن عمر (85) | **8**: 1704@142/453, 1720@143/453, 1755@144/468, 1770@145/468, 1804@146/475, 1816@147/475, 1852@148/489, 1872@150/500 | 1874 |
| قمر أبي عيشة (86) | **16**: 1698@142/437, 1708@142/516, 1718@143/437, 1721@143/516, 1754@144/457, 1757@144/514, 1762@145/457, 1768@145/514, 1800@146/470, 1805@146/515, 1812@147/470, 1819@147/515, 1847@148/494, 1862@149/494, 1873@150/501, 1879@151/501 | none |
| أمير عدي (90) | **6**: 1801@146/472, 1845@148/483, 1865@150/498, 1875@151/498, 1892@152/525, 1902@153/525 | 1814 |
| شيماء المحمد (94) | **8**: 1586@138/39, 1608@139/39, 1620@161/39, 1638@170/39, 1641@140/48, 1660@141/48, 1671@162/48, 1688@173/48 | none |
| رشا طبا (96) | **8**: 1313@130/2, 1318@131/2, 1335@154/2, 1349@155/2, 1366@158/2, 1371@132/6, 1384@133/6, 1398@156/6 | none |
| مجد مارتيني (97) | **4**: 1724@163/443, 1739@174/443, 1778@164/460, 1787@176/460 | none |
| يوسف ميعاري (98) | **6**: 1806@146/471, 1818@147/471, 1825@165/471, 1836@177/471, 1851@148/486, 1860@149/486 | none |
| ميس الأصفر (100) | **14**: 1310@130/153, 1321@131/153, 1331@154/153, 1350@155/153, 1361@158/153, 1379@132/156, 1386@133/156, 1401@156/156, 1415@157/156, 1434@166/156, 1451@167/156, 1540@136/431, 1551@137/431, 1566@160/431 | none |
| كريستا حصني (102) | **20**: 1312@130/11, 1330@131/11, 1342@154/11, 1344@155/11, 1367@158/11, 1378@132/16, 1391@133/16, 1405@156/16, 1422@157/16, 1425@166/16, 1447@167/16, 1468@134/24, 1489@135/24, 1495@159/24, 1516@168/24, 1519@169/24, 1555@137/34, 1563@160/34, 1580@175/34, 1908@136/34 | 1539 |
| رهف نبهان (103) | **17**: 1585@138/320, 1599@139/320, 1618@161/320, 1633@170/320, 1647@140/46, 1659@141/46, 1673@162/46, 1686@173/46, 1909@159/533, 1922@140/536, 1923@138/535, 1926@141/536, 1928@139/535, 1933@161/535, 1934@162/536, 1936@173/536, 1937@170/535 | 1598 |
| ريم الخلف (106) | **7**: 1491@159/147, 1492@159/19, 1493@159/22, 1494@159/23, 1497@159/21, 1502@159/20, 1504@159/533 | none |
| دينا الوكيل (107) | **2**: 1441@167/6, 1579@175/431 | 1452 |
| أسماء زيدان (108) | **9**: 1332@154/8, 1333@154/151, 1334@154/133, 1336@154/531, 1337@154/12, 1338@154/10, 1339@154/130, 1341@154/4, 1343@154/9 | none |
| رزان باشوري (109) | **9**: 1345@155/531, 1346@155/8, 1347@155/151, 1348@155/130, 1351@155/133, 1352@155/10, 1353@155/12, 1354@155/9, 1356@155/4 | none |
| روان قنبر (110) | **8**: 1518@169/21, 1520@169/22, 1521@169/19, 1522@169/147, 1523@169/533, 1526@169/20, 1528@169/23, 1529@169/25 | none |
| سحر فرحات (111) | **8**: 1505@168/23, 1507@168/19, 1508@168/21, 1509@168/22, 1510@168/147, 1512@168/533, 1513@168/20, 1515@168/25 | none |
| شذا بغاجاتي (113) | **4**: 1705@142/443, 1719@143/443, 1756@144/460, 1767@145/460 | none |
| وعد عبد الغني (114) | **8**: 1591@138/42, 1605@139/42, 1619@161/42, 1640@170/42, 1650@140/51, 1668@141/51, 1678@162/51, 1696@173/51 | none |
| ساره الملكي (117) | **13**: 1471@134/158, 1483@135/158, 1500@159/158, 1511@168/158, 1527@169/158, 1594@138/442, 1602@139/442, 1621@161/442, 1627@170/442, 1643@140/508, 1656@141/508, 1675@162/508, 1692@173/508 | none |
| هنادي مغمومة (118) | **2**: 1881@151/499, 1900@153/528 | none |
| عمر الفهيم (121) | **3**: 1798@146/476, 1810@147/476, 1843@148/484 | none |
| عمران عدي (123) | **3**: 1824@165/472, 1835@177/472, 1857@149/483 | none |
| كنان شقفة (128) | **4**: 1867@150/502, 1876@151/502, 1889@152/524, 1898@153/524 | none |
| أسعد عروق (136) | **4**: 1866@150/496, 1884@151/496, 1890@152/527, 1897@153/527 | none |
| ماوية بركات (137) | **7**: 1702@142/450, 1716@143/450, 1748@144/465, 1771@145/465, 1799@146/474, 1811@147/474, 1844@148/487 | none |
| قحطان البكري (138) | **1**: 1887@152/523 | none |
| باسل السلوم (139) | **2**: 1894@152/530, 1903@153/530 | 1448 |
| ثريا خانم كرزون (140) | **8**: 1735@163/453, 1745@174/453, 1783@164/468, 1795@176/468, 1830@165/475, 1839@177/475, 1861@149/489, 1883@151/500 | 1885 |
| دعاء قنباز (141) | **18**: 1503@159/25, 1595@138/44, 1610@139/44, 1626@161/44, 1635@170/44, 1651@140/53, 1665@141/53, 1681@162/53, 1697@173/53, 1700@142/446, 1715@143/446, 1730@163/446, 1742@174/446, 1749@144/511, 1765@145/511, 1780@164/511, 1792@176/511, 1841@148/488 | none |
| أحمد كريج (142) | **8**: 1729@163/436, 1737@174/436, 1774@164/456, 1791@176/456, 1827@165/473, 1833@177/473, 1856@149/485, 1878@151/497 | none |
| براء الحسن (143) | **8**: 1707@142/436, 1714@143/436, 1752@144/456, 1763@145/456, 1802@146/473, 1809@147/473, 1848@148/485, 1864@150/497 | none |
| أغيد عدي (144) | **4**: 1870@150/495, 1882@151/495, 1891@152/526, 1901@153/526 | 1886 |
| عمار الخالد (145) | **2**: 1869@150/499, 1893@152/528 | none |
| منذر جعيلة (146) | **2**: 1888@152/525, 1896@153/525 | none |
| شفاء ابو امين (147) | **0**: none | 1642, 1646, 1653, 1657, 1658, 1661, 1670, 1674, 1679 |
| ميسم زكية (148) | **9**: 1587@138/38, 1590@138/164, 1596@138/535, 1600@139/535, 1604@139/38, 1607@139/164, 1613@161/38, 1615@161/535, 1617@161/164 | none |
| ديمة الجاسم (150) | **9**: 1396@156/532, 1397@156/5, 1399@156/14, 1400@156/146, 1402@156/13, 1403@156/7, 1404@156/15, 1407@156/17, 1408@156/134 | none |
| غدير خفيف (151) | **9**: 1409@157/13, 1410@157/5, 1412@157/7, 1413@157/532, 1414@157/146, 1416@157/15, 1417@157/17, 1418@157/134, 1420@157/14 | 1421 |
| شهد كوجان (152) | **9**: 1424@166/532, 1426@166/5, 1427@166/146, 1428@166/13, 1429@166/14, 1430@166/15, 1431@166/17, 1433@166/7, 1436@166/134 | none |
| إيثار خليف (153) | **9**: 1383@133/5, 1385@133/14, 1387@133/15, 1388@133/7, 1389@133/13, 1390@133/146, 1392@133/17, 1393@133/532, 1395@133/134 | none |
| شادن غنوم (154) | **9**: 1531@136/31, 1532@136/148, 1533@136/28, 1535@136/36, 1536@136/534, 1537@136/29, 1538@136/32, 1541@136/33, 1542@136/35 | 1435 |
| غالية الحمصي (155) | **9**: 1544@137/33, 1545@137/148, 1546@137/32, 1547@137/31, 1549@137/29, 1550@137/36, 1552@137/534, 1553@137/28, 1554@137/35 | none |
| بهاء الزبدي (156) | **14**: 1732@163/437, 1734@163/516, 1740@174/437, 1744@174/516, 1779@164/457, 1781@164/514, 1788@176/457, 1793@176/514, 1822@165/470, 1826@165/474, 1828@165/515, 1831@177/474, 1834@177/470, 1838@177/515 | none |
| حكمت عيسى (157) | **9**: 1357@158/133, 1358@158/8, 1359@158/10, 1360@158/4, 1362@158/151, 1363@158/130, 1364@158/531, 1368@158/9, 1369@158/12 | none |
| تسنيم صمصام (158) | **9**: 1437@167/134, 1438@167/14, 1439@167/5, 1440@167/7, 1442@167/146, 1443@167/532, 1444@167/13, 1445@167/15, 1446@167/17 | none |
| قمر الدرويش (159) | **9**: 1557@160/534, 1558@160/32, 1559@160/148, 1560@160/31, 1561@160/35, 1564@160/29, 1565@160/33, 1567@160/28, 1569@160/36 | none |
| رفيف الشيخ طه (160) | **5**: 1573@175/534, 1574@175/31, 1576@175/33, 1583@175/35, 1917@175/36 | none |
| جودي عسكر (161) | **0**: none | 1570, 1571, 1572, 1575, 1577, 1581 |
| عائدة إبراهيم (162) | **6**: 1630@170/38, 1631@170/535, 1632@170/164, 1684@173/536, 1685@173/47, 1687@173/168 | none |
| طلة هبرة (163) | **4**: 1649@140/49, 1662@141/49, 1676@162/49, 1691@173/49 | none |
| احمد صالح (164) | **4**: 1589@138/40, 1603@139/40, 1614@161/40, 1629@170/40 | none |
| عمار العطار (165) | **9**: 1469@134/27, 1479@135/27, 1501@159/27, 1506@168/27, 1525@169/27, 1534@136/30, 1548@137/30, 1562@160/30, 1578@175/30 | none |
| عدنان كفري (166) | **11**: 1453@167/409, 1454@132/409, 1455@133/409, 1456@157/409, 1457@166/409, 1458@130/406, 1459@131/406, 1460@154/406, 1461@155/406, 1462@158/406, 1664@156/409 | 1905, 1906 |
| طارق لحلح (167) | **2**: 1895@152/529, 1904@153/529 | none |
| عمر خنفور (168) | **8**: 1911@161/41, 1915@138/41, 1918@170/41, 1920@140/50, 1924@141/50, 1929@139/41, 1932@162/50, 1935@173/50 | none |
| إسراء برادعي (169) | **4**: 1912@175/148, 1913@175/29, 1914@175/28, 1916@175/32 | none |

## Migration and rollout requirements

**No new migration is required for this implementation.** It uses existing timetable, annual projection, academic context and `teacher_assignment_periods` columns. No schema was altered in the school database. Unrelated pending Gradebook migrations were not applied.

InnoDB transactions and the existing active-year primary-key row provide serialization. New periods reuse the existing history schema; historical term context remains on original timetable/follow-up/assessment rows. No new lifecycle status or current-authority flag was added.

Rollout/activation order:
1. Review/deploy the code through the project's normal approval process; this task does not deploy.
2. Confirm an active year/current term and its valid section timetable. Current web access follows that timetable immediately, even with unreconciled pivots.
3. Review this exact dry-run manifest, take the normal backup, and obtain separate approval before applying legacy school-wide period closures. There is no auto-apply startup job or newly exposed reconciliation endpoint.
4. If reconciliation is later approved, close only the listed obsolete open intervals, leave all annual pivots and closed intervals intact, and create only genuinely missing scheduled projections. Recheck a fresh dry run before execution.
5. Verify the seven accounts and Admin timetable screens in authenticated browsers, including last-period replacement/deletion and current-term transition.
6. Complete the separate legacy API authentication/mobile-client compatibility work before API security sign-off.

No requirement remains for staff to visit a second responsibility page after ordinary timetable edits. Future normal timetable changes synchronize the affected section before returning success.

## Verification

| Check | Final result |
|---|---|
| Focused timetable / Gradebook / membership / Follow-up regressions | **80 tests, 1,388 assertions passed** |
| Full isolated PHPUnit suite | **183 tests, 2,771 assertions; 182 passed, one pre-existing unrelated failure** |
| Full-suite exception | `Tests\Feature\ExampleTest::testBasicTest` expects HTTP 200 for `/`, while the existing locale redirect returns 302. Neither that test nor homepage behavior was changed. |
| Parallel local MariaDB/InnoDB integration | **Passed** with two PHP writers; lock serialization, atomic visibility, final authority, retained references, closed intervals and unchanged academic sentinel verified. Disposable database removed. |
| Real local school database, read-only resolver | **1,372 periods / 578 current grants**, including all seven Teacher comparisons; no synchronization invoked. |
| PHP syntax | Modified/new PHP files passed PHP 7.4 lint. |
| Blade | All three modified Blade templates compiled and their generated PHP passed lint. |
| Frontend compatibility | Existing Gradebook save/status/continuity harnesses passed; no new JS/CSS was introduced. |
| Encoding | Implementation files and report passed strict UTF-8 decoding without BOM. |
| Whitespace | `git diff --check` passed. |
| School data preservation | Repeated fingerprints of seven assignment/context/identity datasets matched; no school DML/DDL was executed. |

Verified functional cases include: add, replace, delete last/one-of-many periods, co-teaching, multiple sections, stale pivots, missing projections, instructional/day/class/Teacher validity, current vs prior term/year, no current term, all four timetable query results, direct route and forged POST denial, Gradebook and Follow-up compatibility, owned read-only retired history, previous-term slot protection, re-adding with a fresh interval, idempotence, rollback, stale editor IDs, and source-independent time-conflict detection.

The full test suite uses SQLite `:memory:` with explicit driver/database assertions. This local PHP CLI had SQLite DLLs installed but disabled; a temporary per-test PHP configuration enabled them for the parent and PHPUnit child processes. The shared `C:\php74\php.ini`, project environment and server configuration were not modified.

The standalone parallel test `tests/Integration/timetable-concurrency.php` requires local MariaDB/MySQL and permission to create an isolated QA database. It generates a random guarded `aladham_timetable_qa_*` name, overrides Eloquent's database explicitly, starts two workers, and removes that database in `finally`. It refuses a remote host and cannot take the school's database name as its test target. No temporary QA schema remained after verification.

Actual school-data runtime verification used Capsule/Eloquent for **read methods only**. No HTTP request to the real school instance was used for a mutation or for a GET handler that could synchronize records. School assignment/context/identity fingerprints before and after verification matched.

Browser inventory has no connected authenticated browser or app. Actual browser interaction and production deployment remain unverified; isolated authenticated HTTP tests and real read-only MariaDB resolver queries are distinguished from browser acceptance.

Manual browser checks still required after approval:
- Admin section timetable and both Teacher timetable views show the same day/slot/Teacher/subject rows.
- Each audited Teacher sees only the effective current contexts in the table above.
- A last-period reassignment removes the former Teacher's current card/direct write access and grants the new Teacher's context after refresh; another remaining period preserves access.
- Current Follow-up/Gradebook works; a retired Teacher's authored history is read-only.
- Empty new-term timetables produce empty current assignment lists, with no old-term/year fallback.
- Existing Arabic/RTL, messages and save feedback remain usable on the normal pages.

## Changed files

These are this implementation's files, including updates within files that already had unrelated Gradebook work. Existing work was preserved.

- [app/Http/Controllers/Admin/GradebookSettingsController.php](C:/Users/Lenovo/Desktop/aladhamedu/app/Http/Controllers/Admin/GradebookSettingsController.php)
- [app/Http/Controllers/Api/websitecontroller.php](C:/Users/Lenovo/Desktop/aladhamedu/app/Http/Controllers/Api/websitecontroller.php)
- [app/Http/Controllers/DashboardController.php](C:/Users/Lenovo/Desktop/aladhamedu/app/Http/Controllers/DashboardController.php)
- [app/Http/Controllers/Teacher/TeacherGradebookController.php](C:/Users/Lenovo/Desktop/aladhamedu/app/Http/Controllers/Teacher/TeacherGradebookController.php)
- [app/Http/Controllers/TeacherController_New.php](C:/Users/Lenovo/Desktop/aladhamedu/app/Http/Controllers/TeacherController_New.php)
- [app/Http/Controllers/TeacherStudentFollowUpController.php](C:/Users/Lenovo/Desktop/aladhamedu/app/Http/Controllers/TeacherStudentFollowUpController.php)
- [app/Http/Controllers/admincontroller.php](C:/Users/Lenovo/Desktop/aladhamedu/app/Http/Controllers/admincontroller.php)
- [app/Observers/TeacherRoomLessonObserver.php](C:/Users/Lenovo/Desktop/aladhamedu/app/Observers/TeacherRoomLessonObserver.php)
- [app/Observers/TimetableTermObserver.php](C:/Users/Lenovo/Desktop/aladhamedu/app/Observers/TimetableTermObserver.php)
- [app/Providers/AppServiceProvider.php](C:/Users/Lenovo/Desktop/aladhamedu/app/Providers/AppServiceProvider.php)
- [app/Services/CurrentTeacherAssignments.php](C:/Users/Lenovo/Desktop/aladhamedu/app/Services/CurrentTeacherAssignments.php)
- [app/Services/StudentFollowUpService.php](C:/Users/Lenovo/Desktop/aladhamedu/app/Services/StudentFollowUpService.php)
- [app/Services/TeacherAssessmentService.php](C:/Users/Lenovo/Desktop/aladhamedu/app/Services/TeacherAssessmentService.php)
- [app/Services/TeacherAssignmentPeriodService.php](C:/Users/Lenovo/Desktop/aladhamedu/app/Services/TeacherAssignmentPeriodService.php)
- [app/Teacher.php](C:/Users/Lenovo/Desktop/aladhamedu/app/Teacher.php)
- [app/Teacher_room_lesson.php](C:/Users/Lenovo/Desktop/aladhamedu/app/Teacher_room_lesson.php)
- [docs/audits/teacher-assignment-timetable-consistency-2026-10-29.md](C:/Users/Lenovo/Desktop/aladhamedu/docs/audits/teacher-assignment-timetable-consistency-2026-10-29.md)
- [resources/lang/ar/teacher_assignment.php](C:/Users/Lenovo/Desktop/aladhamedu/resources/lang/ar/teacher_assignment.php)
- [resources/lang/ar/timetable.php](C:/Users/Lenovo/Desktop/aladhamedu/resources/lang/ar/timetable.php)
- [resources/lang/en/teacher_assignment.php](C:/Users/Lenovo/Desktop/aladhamedu/resources/lang/en/teacher_assignment.php)
- [resources/lang/en/timetable.php](C:/Users/Lenovo/Desktop/aladhamedu/resources/lang/en/timetable.php)
- [resources/views/admin/set_task.blade.php](C:/Users/Lenovo/Desktop/aladhamedu/resources/views/admin/set_task.blade.php)
- [resources/views/teachers2/student_follow_ups/history.blade.php](C:/Users/Lenovo/Desktop/aladhamedu/resources/views/teachers2/student_follow_ups/history.blade.php)
- [resources/views/teachers2/teacher_schedule.blade.php](C:/Users/Lenovo/Desktop/aladhamedu/resources/views/teachers2/teacher_schedule.blade.php)
- [routes/teacher.php](C:/Users/Lenovo/Desktop/aladhamedu/routes/teacher.php)
- [tests/Concerns/TimetableFixtures.php](C:/Users/Lenovo/Desktop/aladhamedu/tests/Concerns/TimetableFixtures.php)
- [tests/Feature/GradebookSafetyTest.php](C:/Users/Lenovo/Desktop/aladhamedu/tests/Feature/GradebookSafetyTest.php)
- [tests/Feature/TeacherStudentFollowUpEligibilityTest.php](C:/Users/Lenovo/Desktop/aladhamedu/tests/Feature/TeacherStudentFollowUpEligibilityTest.php)
- [tests/Feature/TimetableAuthorityTest.php](C:/Users/Lenovo/Desktop/aladhamedu/tests/Feature/TimetableAuthorityTest.php)
- [tests/Integration/timetable-concurrency.php](C:/Users/Lenovo/Desktop/aladhamedu/tests/Integration/timetable-concurrency.php)

## Preservation and deferred concerns

- No school INSERT/UPDATE/DELETE/DDL, migration, reconciliation, account changes, password changes, student transfer, grade recalculation, financial edit, commit, push or deployment was performed.
- The only DDL/DML executed outside SQLite tests targeted newly generated disposable QA databases. Those databases were removed.
- Final hash/status comparison found exactly the 30 implementation/report files listed above and no unexpected changes. Existing unrelated working-tree changes, including `.env.example`, were preserved; 49 pre-existing modified/untracked files were wholly unchanged.
- Original marks, results, report cards, content ownership and financial rows remain unchanged; no record was rewritten to make a display or access check pass.
- The retained annual pivot is historical/reference data, not proof of current responsibility. Future current readers must use the resolver or `currentTimetable`; selected historical readers must use their original context instead.
- The legacy API authentication/impersonation risk is explicitly deferred by the user's compatibility decision. Current timetable scoping alone is not sufficient security for those unauthenticated routes.
- The unrelated homepage example test's redirect expectation was not changed.

