# Gradebook Phase 2A: contextual configuration/status compatibility

Date: 2026-10-29 (Asia/Damascus). PHP 7.4 / Laravel 7.30.6.
Scope: Slice 2A only, following [the approved roadmap](gradebook-phase2-readiness-and-roadmap-2026-10-29.md).

## Result and activation boundary

A new **opt-in, read-only inspection contract** now describes academic scope, legacy configuration/status observations, source fingerprints and future-backend limitations.

**Existing application consumers are deliberately not rewired.** GradebookConfigService, GradebookStatusService, GradebookReadService, calculations, controllers, routes, views, model guards, timetable synchronization, assignments, membership, authorization and persistence behavior are unchanged. Two-argument getConfig still means **subject + academic year**, never a chosen section/term template.

No template model/table, application lookup, publishing/import, migration, configuration/status write or academic correction was introduced. The new reader is metadata/compatibility infrastructure, **not authorization**. Callers retain their existing permission and roster checks.

## Files changed

New application classes:
- app/Services/Gradebook/GradebookContext.php
- app/Services/Gradebook/GradebookReadSnapshot.php
- app/Services/Gradebook/GradebookContextReader.php

Tests:
- tests/Unit/GradebookContextReaderTest.php (new)
- tests/Feature/GradebookSafetyTest.php (one additional reader-agreement regression)
- tests/CreatesApplication.php (guarded, opt-in temporary test-storage isolation)

Documentation:
- This report.

The pre-existing untracked Phase 2 roadmap is preserved, not edited by this slice. No existing application PHP/Blade/JS/lang file was changed.

## Public contract

### GradebookContext

Final immutable value object with private scalar state:
- Required positive year and subject IDs.
- Optional actual term ID, class ID, section/room ID.
- Optional configuration source and revision identity.

It retains actual term IDs; duplicate term types are not collapsed. The reader validates subject/class, term/year and section/year/class relationships. A missing term remains missing; it does not silently select current_term. A broad subject/year lookup remains broad; it never chooses a section.

Supported source requests: legacy_json, legacy_defaults, versioned_template. IDs cannot contain path segments, floats or non-positive values.

Class is inferred from the actual subject only when absent, never from a subject name or arbitrary first section.

### GradebookContextReader

Usage for a future explicit consumer:

```php
use App\Services\Gradebook\GradebookContext;
use App\Services\Gradebook\GradebookContextReader;

$snapshot = app(GradebookContextReader::class)->resolve(
    new GradebookContext($yearId, $subjectId, $termId, $classId, $roomId)
);
$metadata = $snapshot->toArray();
$components = $snapshot->components();
```

The reader takes an optional Filesystem dependency, otherwise the existing default Storage disk. It exposes no write operation and never calls saveConfig, setStatus, a migration, an application backend or an assignment synchronizer.

Its legacy inspection performs one exists/get snapshot per available file. This deliberately avoids calling the old reader a second time after reading diagnostic bytes: that would duplicate I/O and could combine components from one revision with another revision's hash. It reuses GradebookConfigService::getDefaults; agreement tests pin the independent file-decoding/status compatibility behavior against both unchanged services.

No schema probe or persistent cache is used. The captured object is a point-in-time read, not an atomic filesystem+database transaction or a write authorization token.

### GradebookReadSnapshot

Final immutable read DTO containing:
- Resolved GradebookContext.
- timeline: current, historical, future or unresolved.
- configuration: state, source, revision, relative path, raw-byte SHA-256, warnings and usable flag.
- Exact component objects, including numeric/string source distinctions and explicit maxima.
- status: state, original value, class/term path and SHA-256.
- versioned_backend: unavailable_not_implemented.
- Explicit configuration_scope and status_scope.

components() and toArray() return defensive copies. Changing a returned Collection, nested object or array cannot mutate the snapshot or context.

A hash is a **content revision fingerprint**, not a published template version or evidence of the original historical grading policy.

## State and compatibility semantics

| Observation | New contract | Existing behavior preserved |
|---|---|---|
| Existing decodable component JSON | configuration.state=valid, source=legacy_json; raw-content hash and exact objects | Existing getConfig objects/IDs/sources/order/values retained |
| No file | state=missing, source=legacy_defaults; fingerprint of the current default payload | Existing three defaults, including zero weights |
| Malformed JSON or missing component payload | state=invalid; fallback payload remains observable as defaults | Same malformed-JSON fallback as getConfig; invalid is not mislabeled as a genuine default |
| Structurally incomplete component rows | state=invalid, usable=false; original returned component fields retained where iterable | No repair of existing components; existing readers remain untouched |
| Unreadable config | state=unreadable, usable=false; current defaults exposed diagnostically | Existing getConfig get-exception fallback remains unchanged |
| Missing status | state=missing, value=LOCKED | Existing default LOCKED |
| Malformed status JSON | state=invalid, value=LOCKED | Existing decode fallback |
| Unknown stored status, e.g. lowercase open | state=invalid, original value retained | No uppercase normalization or newly granted OPEN state |
| Unreadable status | state=unreadable, value=null | Diagnostic observation only: old getStatus can throw on read failure and is NOT changed to suppress it |
| Term not supplied | status.state=not_applicable, value=null | Does not invent the globally current term for a broad lookup |
| Explicit versioned_template request | configuration.state=backend_unavailable, no components, usable=false, configuration scope unresolved | Never falls back to legacy data while pretending it resolved a requested version |

The usable flag concerns the inspected legacy payload, not academic validity, authorization or readiness for template adoption. A valid legacy file can carry warnings. In particular legacy_id_source_mismatch does not normalize a mapping or authorize importing it.

Additional diagnostics:
- Duplicate component IDs are reported as duplicate_component_id.
- Envelope lesson/year mismatch is reported as envelope_context_mismatch.
- A component labelled legacy_homework but pointing to 100 stays exactly that way. Missing core components are not manufactured.

Timeline classification uses one uniquely current year and validated consecutive YYYY/YYYY or YYYY-YYYY labels. It does not assume ascending database IDs imply chronology. Nonstandard/ambiguous labels, multiple current years or no current year produce unresolved. This is read metadata, not a replacement year/placement resolver or Student Portal future-visibility rule.

Invalid academic relationships throw InvalidArgumentException. An explicitly captured legacy source/revision that no longer matches throws DomainException instead of falling back to another revision.

## Ambiguous legacy lookup boundary

```php
$snapshot = $reader->resolveLegacy($subjectId, $yearId);

// Future caller may supply independently established contextual evidence:
$snapshot = $reader->resolveLegacy($subjectId, $yearId, $candidateContexts);
```

With no candidates this inspects the **existing legacy subject/year file only**. It does not discover Gradebook application rows.

Candidate evidence must identify the same subject/year and an explicit source/revision:
- Different identities -> DomainException: ambiguous legacy lookup.
- Reversing candidate order has the same rejection; no first/latest winner.
- One identical identity shared by several contexts may produce a broad subject/year snapshot; no section or term is claimed.
- Identical versioned-template evidence still returns backend_unavailable, never legacy components.
- Wrong subject/year, missing identity or malformed evidence is rejected.
- Captured legacy revisions are checked against the actual file snapshot.

This is a contract for future contextual callers, **not** a change to the long-established two-argument getConfig method. Slice 2C must supply validated application evidence and implement the future backend explicitly. Merely creating application tables will not activate it.

## Existing reader/writer inventory

Static inventory includes direct service calls, direct paths, shared consumers and separate legacy models. No caller below was migrated in 2A.

| Caller | Reads | Writes / scope boundary |
|---|---|---|
| Admin GradebookSettingsController::edit/update | getConfig(subject, year); subject overview also uses Storage::exists on gradebook/subject_year.json | update calls saveConfig, preserving legacy context and safeguards |
| GradebookReadService::read / assessment | Config by exact source subject/year; dynamic component label lookup; original results and all selected actual term IDs | Pure read; algorithms and componentMaximum unchanged |
| Admin GradebookController::viewGridSimple | Shared reader with stored room/year, all terms | No calculation/config persistence |
| Admin GradebookController::viewStudentCard | Current resolved placement, then shared reader for each subject | Current default unchanged; not converted to an arbitrary historical-year lookup |
| Admin GradebookController::toggleStatus | Validates class/term/current-year context | setStatus(class, term), existing POST authorization unchanged |
| Advanced TeacherGradebookController::index | Shared current-term reader + getStatus(class, term) | No new writer or authority from the DTO |
| Advanced TeacherGradebookController::saveMark | getStatus and getConfig; current timetable/membership checks; exact component/maximum | Existing original dynamic assessment/result write path unchanged |
| Admin gradebook/view_subjects.blade.php | Inline getStatus for actual class/current term within the room year | Existing AJAX status action; no new UI |
| GradebookAggregationService | Shared reader, existing config/result interpretation | Explicit derived students_marks write; NOT called by the new reader |
| TeacherController_New legacy exam/quiz screens, filters and mark writers | Original definitions/results; continuity/GradebookReadService numeric helpers and existing current context | Existing validated result writer/import behavior unchanged; no new config-dependent mutation |
| Student Academic Record (studentscontroller::academic_record_show) | Separate marks/report/definition/result/file/certificate mapper scoped to selected owned placement | No direct getConfig/getStatus call. It remains independent; not rewired to current-year config |
| AssessmentContinuityService / EquivalenceService / result traits | Explicit mapping/identity/context/provenance and numeric maximum checks | Existing activation/retention gates unchanged; no template equivalence inferred |
| Old newcontroller / teacherscontroller | Separate GradebookConfig model queries under legacy fallback handling | Do not confuse these old DB-model paths with the active JSON reader or a versioned backend |
| GradebookConfig / GradebookComponent models and January migrations | Earlier DB configuration design | No new use, recreation, migration-ledger edits or activation |
| Other report/marks/lifecycle/assignment consumers | Continue existing source/context adapters | No finance, report, membership, transfer or assignment behavior changed |
| Tests and existing frontend harnesses | Agreement with all the above surfaces | Only isolated fixture persistence is allowed |

Existing config/status file writers remain **saveConfig and setStatus**, reached by their existing Admin operations; tests also invoke them only on fake storage. Presence checks are not proof a file is semantically valid, and this slice does not change that old UI behavior.

## Agreement and regression coverage

New unit fixtures:
- Valid JSON and OPEN status agreement.
- Missing, malformed, structurally incomplete and unreadable configuration.
- Missing/malformed/unknown/unreadable status semantics.
- Exact legacy defaults; no automatic additional core components.
- Known legacy_homework -> numeric 100 mismatch retained and warned.
- Numeric 100 vs string 101 preserved, zero weight and maxima.
- Multiple sections, Term 1/2 and a second actual Term-1 ID.
- Historical/future years whose numeric IDs deliberately run opposite to chronology.
- Missing/multiple current year and nonstandard year labels -> unresolved.
- Wrong year/term/room/class/subject rejection.
- Immutable context and defensive component/array copies.
- Explicit unavailable versioned backend, reversed conflicting candidate lists, matching identity and stale content-hash rejection.
- Filesystem mutation methods forbidden by mocks; all resolver SQL verified SELECT-only.

New feature agreement test uses the real existing Admin grid controller, Teacher Gradebook controller and Student Academic Record controller/view:
- Two quizzes in term 20 (0 and 10), an exam (30), term-21 quiz (14), a separate term-22 quiz (0), and an unearned dynamic result.
- Compares complete rendered child-view output before/after contextual inspection plus original assessment rows, actual term IDs, source keys, result IDs, null/zero behavior, maxima and raw rows.
- Existing summaries remain 35 for term 20 and 14 for term 21; quiz average remains 5.
- Teacher reader remains term-20-only, Admin raw reader retains IDs 20/21/22.
- Original JSON/status bytes and result rows stay unchanged.

This is isolated controller/render verification, **not an authenticated real-browser acceptance test**. Existing fixture shell isolation remains in use.

## Read/query and performance baseline

Fixed isolated fixture: 2 students, 6 modern assessment definitions, 3 actual term IDs.

- Full exact contextual resolve: **6 SELECTs** (selected year, subject, class existence, exact term/year, exact section/year/class, uniquely-current-year list).
- Existing config and status files: **4 filesystem calls total**, one exists + get for each; no repeated getConfig/getStatus I/O.
- Broad subject/year resolve omits term/section/status access; no current-term fallback or future-schema probe.
- Two explicit contextual resolves plus two explicit Lesson lookups in the agreement test: **14 SELECTs**.
- Unchanged shared Gradebook reader fixture baseline: **16 queries**, measured **13.631 ms** in one local isolated run. Timing is illustrative, not a production SLA or optimization claim.
- No shared-reader query optimization, index or migration was introduced. File/status reads are fresh per resolve; captured snapshots remain fixed. No global cache can silently survive an activation or file change.

## Isolated verification setup

tests/CreatesApplication has a guarded test-only ALADHAM_TEST_STORAGE override. It is accepted only for CLI + PHPUnit testing environment + sqlite/:memory: + an existing uniquely named temporary QA root. Otherwise it fails before framework bootstrap. With no override its previous behavior is unchanged.

The verification runner:
1. Refuses cached application config.
2. Creates a unique system-temp aladham-gradebook-2a-<32 hex> root.
3. Sets process-only ALADHAM_TEST_STORAGE, VIEW_COMPILED_PATH, PHP_INI_SCAN_DIR, TEMP/TMP. SQLite extensions and sys_temp_dir are enabled only for these PHP processes.
4. Uses --process-isolation and --do-not-cache-result. The legacy paginate_num route constant otherwise collides between tests; no application route was edited to hide this.
5. Keeps fake storage, logs, sessions, compiled fixture views and generated continuity HTML under the temporary root; runs Node harnesses against that newly generated fixture HTML.
6. Restores environment variables afterward. Temporary QA artifacts remain outside the project for inspection; no project Gradebook files were used as fixture destinations.

No .env, .env.example, production PHP configuration, school schema or project view cache was changed. SQLite fixture schema/migration tests are isolated; no migration was run against the school database.

## 2B/2C integration and unresolved boundaries

Ready integration points:
- Context is the explicit academic input contract; no template grants authorization.
- Snapshot distinguishes legacy source/fallback/error from future backend capability.
- Source identity is bound to raw content/default fingerprint, without invented publication history.
- resolveLegacy candidate validation is the no-arbitrary-version selection boundary.
- Existing service signatures remain a stable compatibility API.

Deferred:
- Actual template/application/version schemas, repository and selection policy.
- Section/term-divergent configurations and adaptation of every existing caller.
- Atomic application/config/status cutover and writable revision protocol.
- School decisions on weighting, maxima, locks, approval and editing after marks.
- Repair or adoption of ambiguous legacy configuration/source mappings.
- Phase 1 mapping activation; it remains independently controlled.
- Production load, browser/mobile acceptance and true versioned-backend behavior.

The DTO does not authorize import of a warning-bearing config, fix unreadable legacy status handling, infer timeline for arbitrary year names, or make an unavailable backend operational.

## Closure

Slice 2A is complete as an **opt-in contextual compatibility foundation**, not an application cutover. Ready for **Slice 2B design approval**, subject to the roadmap's policy decisions; no 2B work is authorized or started.

Final verification:
- Focused isolated suite: **91 tests, 1,549 assertions passed**, including Gradebook safety, timetable authority, follow-up eligibility, contextual reader and multi-section timetable-view regressions.
- All three Node harnesses passed: Gradebook save, Gradebook status and continuity/legacy filters (including four rendered scripts).
- All six added/modified PHP files passed PHP 7.4 lint. All seven slice files are valid UTF-8 without BOM.
- **28 Gradebook/Academic Record Blade views** compiled and parsed in memory, without project view-cache writes. The isolated controller agreement test also rendered the existing Admin, Teacher and Academic Record child views before and after contextual reads.
- git diff --check passed. Existing changes consist only of the test harness and added agreement test; application integration remains opt-in through the three new classes.
- Before/after SELECT-only fingerprints match for all **20 inspected school tables**. All **six existing Gradebook config/status files** are byte-identical.
- Existing ConfigService, StatusService, ReadService, CurrentTeacherAssignments, CurrentStudentMembership and .env.example hashes match their captured baselines.
- No school database write, migration, real configuration/status write, authorization change, commit, push or deployment occurred.

Browser acceptance and production-scale load were not performed: this slice changes no UI and uses disposable controller/render fixtures for compatibility verification. Phase 1 activation and production-readiness gates remain separate.

