# Advanced Gradebook Phase 2: readiness and implementation roadmap

Date: 2026-10-29, Asia/Damascus.
Project: `C:\Users\Lenovo\Desktop\aladhamedu`.
Mode: read-only architecture/planning review; **not implementation or deployment approval**.

## 1. Baseline, evidence and current status

### Baseline reviewed

Read these seven reports against current routes, controllers, services, models/traits, Blade views, configuration files and SELECT-only local schema/data inspection:

1. [Admin V2 / Template UI plan](gradebook-admin-ui-redesign-plan-2026-10-23.md).
2. [Original architecture audit](advanced-gradebook-audit-2026-10-22.md).
3. [Phase 0A implementation](gradebook-phase0a-implementation-2026-10-23.md).
4. [Phase 0B implementation](gradebook-phase0b-implementation-2026-10-23.md).
5. [Phase 1 completion](gradebook-phase1-implementation-2026-10-23.md).
6. [Timetable authority implementation](teacher-assignment-timetable-consistency-2026-10-29.md).
7. [Predeployment readiness audit](predeployment-403-gradebook-timetable-readiness-2026-10-29.md).

Current HEAD is **f8f90e5257f98685c560777fb9a3f19fd74cf561** (`updates`). The working tree was clean at the start of this review. The previous readiness report's 81 changed/untracked files described an earlier snapshot; it is not the current Git state. Committing that work does not establish activation, production deployment or school acceptance. All existing implementation remains the baseline.

Local database: **aladham_oct / MariaDB 10.4.32**. Active year **6 / 2026/2027**; its current term **20 / فصل أول 26-27**. No production connection, migration, application request or write test was performed. Prior reports' test results are identified below as prior evidence, not rerun acceptance.

### Status classification

| Area | Actual status | Evidence and remaining boundary |
|---|---|---|
| Phase 0A safety | Implemented; previously verified in isolated tests and selected local read-only renders | Admin role/capability checks; precise Teacher context and roster; numeric/maximum validation; earned-result/definition retention; guarded participation/deletion; protected imports; shared original-result reader. Not certification of every raw-SQL/API writer. |
| Phase 0B acceptance fixes | Implemented; previously fixture-tested | Transactional multi-section assessment creation, settings round-trip preservation/errors, current-context display, zero handling, status/save feedback. Full Admin V2 redesign was deliberately not completed. |
| Shared calculation/read layer | Implemented and used | GradebookReadService serves Admin, Advanced Teacher and aggregation. Source assessment occurrences/terms remain separate; summaries preserve legacy behavior, not a newly approved weighted policy. |
| Phase 1 identity/continuity | Implemented and fixture-tested, **not activated locally** | Equivalence/continuity services, explicit mapping UI, receiving legacy/Advanced reads, write protection and model saving guard exist. Missing table prevents real local mapping/continuity activation. |
| Original-result preservation | Implemented safeguards | Original exam_result2/exam_result rows stay authoritative; carried results are read-only projections, not receiving copies. Model traits protect earned context and deletion. Ordinary permitted corrections can still change values; comprehensive historical revision/publication snapshots do not yet exist. |
| Timetable-authoritative responsibility | Implemented; prior resolver, concurrency and display regression evidence | CurrentTeacherAssignments, currentTimetable scope, current Teacher guards and period tracking are contracts. Phase 2 must consume them, not replace or reconcile them. Production acceptance remains separate. |
| Current configuration | Implemented legacy adapter, incomplete versioning | Mutable lesson/year JSON; existing component IDs/sources; no reusable template identity, immutable versions or explicit application records. |
| OPEN/LOCKED | Implemented legacy operational control | Class + actual term ID file, default LOCKED. Enforced for Advanced dynamic entry; not a universal lock on all legacy assessments, reports or Student visibility. |
| Admin/Teacher UI | Functional baseline, incomplete UX phase | Admin Gradebook uses admin.master; Teacher Advanced page extends teachers2.layouts.app. Admin Beta/settings/equivalence routes are exposed, not dormant. |
| Templates/applications | Planned, **not implemented** | No draft/published template repository, copy/version/apply lifecycle, impact preview, immutable maximum/config snapshots or publication workflow. |
| Legacy history/data quality | Existing technical debt | Orphans, mutable historical config, ambiguous old maxima/authorship, repeat-visit scoping and duplicate term definitions require truthful warnings and separately approved handling. |
| Production readiness | **Unverified; earlier as-is upload NO-GO is not superseded** | No production schema, browser, environment, activation or deployment verification in this task. |

The original audit's broader Phase 1 target included more provenance/revision infrastructure than the delivered Phase 1 slice. The completion report explicitly limits delivery to modern exam/quiz identity and continuity. Do not assume every foundation shown in the original diagram is already implemented.

### Fresh schema/configuration findings

- Only pending filesystem migration: `2026_10_23_000001_create_assessment_equivalence_members`.
- Physical **assessment_equivalence_members is absent**. No Gradebook template/version/application tables exist.
- Ledger records January gradebook_configs and gradebook_components migrations, but both physical tables are absent. Their PHP models/files are not a functioning versioned-template foundation. Do not rerun/recreate them blindly.
- Source exams2 is InnoDB; its ID is signed `int(11)`, and `mark` is **integer**. Raw result values are `varchar(15)`; result IDs are signed bigint. Historical raw timestamps use `Created_at` on result tables. New FK types/precision must follow actual source types, not generic Laravel assumptions.
- Four JSON configurations exist, all year 5: lessons **158, 31, 49, 50**. Two status files exist: class 3 / term 17 OPEN, class 4 / term 17 LOCKED. No active-year custom config/status file was found; current config therefore uses defaults and current Advanced entry defaults LOCKED.
- Config 49_5 maps component ID `legacy_homework` to dynamic source **100**, despite its label. Config 158_5 has no legacy_oral component. Preserve these exact facts in an import review; neither an ID nor translated name justifies silently rebuilding the intended structure.
- Local modern definitions: **2,255**; modern result rows: **27,318**; lesson-system result rows: **0**; modern results lacking a surviving definition: **42**. None of the surviving modern definitions is in active year 6 or uses the Dynamic_Section_ prefix. Active-year custom-component and continuity manual QA therefore needs legitimate data later or isolated staging fixtures, not fabricated school records.
- Year 5 has **two term definitions of type 1 and two of type 2**. Type 1/2 is not a unique semester identity.
- exams2, exam_result2 and exam_result currently have only their primary-key index locally. This is a concrete scale risk for context/result reads, not authorization to add uniqueness or repair duplicates.

These are local observations, not statements about production or permission to normalize data.

### Source anchors

- `GradebookConfigService.php:17,49`: lesson/year file reads and whole-file writes.
- `GradebookReadService.php:29,35`: maximum fallback and exact contextual original-result reads.
- `GradebookStatusService.php:22,39`: class/term status persistence and default.
- `AssessmentEquivalenceService.php:22`: explicit, audited modern assessment equivalence.
- `AssessmentContinuityService.php:15`: mapping/context/membership/interval checks.
- `TeacherGradebookController.php:24,64`: current timetable context and dynamic save.
- `Admin/GradebookSettingsController.php:91`: legacy mutable editor and component protections.
- `Admin/GradebookController.php:34,201`: status and current-year Student card.
- `routes/gradebook.php`, `routes/teacher.php`, model preservation traits, and existing Gradebook/continuity partials remain integration boundaries.

## 2. Assessment of the approved Phase 2 plan

### Retain the plan, update its sequencing and coverage

The approved V2 plan is sound: context first; review separate from configuration and administrative writes; existing Cairo/V2 tokens and Bootstrap infrastructure; all internal pages included; no independent grade store or guessed academic rules. Continue it rather than build a parallel Gradebook product.

Two updates are necessary:

1. **Foundation precedes template mutation and styling.** Context/version contracts, legacy adapter behavior and concurrency rules must be agreed first. This is a sequencing refinement of the approved architecture, not a restart.
2. Phase 1 adds equivalence GET/POST. Existing Admin coverage is now **15 GET screens + 4 POST actions**, not only the older 14 + 3 inventory. Include the equivalence screen and its unavailable-schema state in V2 acceptance.

Current 15 GET screens: landing, review choice, subject classes/sections/subjects/grid, Student classes/sections/students/card, settings classes/sections/subjects/editor, equivalence. The four POST actions are settings update, class/term status, explicit aggregation and equivalence. New template screens are additional; they do not justify leaving any existing chain half-migrated.

### UX and academic behavior review

| Topic | Phase 2 recommendation | Boundary |
|---|---|---|
| Dashboard/navigation | One V2 Gradebook entry with clear review, configuration/templates and controlled operations; existing URLs preserved | No misleading analytics, duplicate banners or second portal shell |
| Year/term selection | Explicit read context: year, actual term ID(s), class, section, subject, version and status | Browsing must never activate the global year/term. Current Teacher entry still uses global active context |
| Selectors | Dependent class -> active-year sections -> class-specific subject; clear missing-year/term/section states | Subject names do not identify curriculum equivalence; future configuration is not current teaching authority |
| Assessment categories | Ordered categories/columns with stable identities; legacy oral, quiz, exam and dynamic sources visibly distinguished | A category is a calculation/display bucket, not a shared assessment or attempt identity |
| Maxima and weights | Separate explicit maximum from any weighting; display existing compatible semantics honestly | Current weights partly derive capacity; existing raw averages/maxima are not normalized percentages |
| Template lifecycle | Draft, validate/preview, publish immutable version, explicitly apply; duplicate as draft; retire without deleting history | Publication of a template is not publication of Student marks/report cards |
| Application scope | Target model uses explicit year/term/section/subject context and pins a version | Initial compatibility scope requires approval; existing readers know lesson/year only |
| Teacher experience | Keep legacy exam/quiz routes, current roster, keyboard/numeric entry and pending/error/retry behavior; improve Advanced page within current shell | Template assignment cannot grant Teacher access; carried/conflicting marks remain read-only |
| OPEN/LOCKED | Label the existing class/term scope and affected contexts; keep distinct from published/finalized reports | Do not silently make the new control lock every legacy writer |
| Approval | Authorized Admin explicit publish/apply with actor/reason/impact confirmation | Genuine two-person approval is not implemented by adding a can check under the existing type-2 Gate override |
| History/transfers | Original assessment/result context, interval checks and verified equivalence remain authoritative | No template-based automatic carry, cross-grade carry, new-year carry or unblocking A -> B -> A |
| Arabic/responsive | Existing V2 typography/tokens; شعبة/الشعب; scoped styles, clear controls, accessible status/error text | No new design system, global table/modal overrides or duplicated plugin bundles |

### Include now versus defer

**Phase 2:** contextual reader contract; versioned reusable definitions; safe draft/copy/publish/apply; immutable config/source snapshots; legacy adapter and reviewed import; class/term status concurrency; complete Admin V2 chain; bounded Advanced Teacher entry improvements; provenance for new managed writes; all-context parity and release acceptance.

**Defer unless separately approved:** general formulas/weighting engine; automatic assessment equivalence; make-up/absence/exemption policy; report designer; new transcript/publication system; broad Student/Parent Portal redesign; cross-grade/year result carry; return-transfer enablement; historical data repairs; reconstructing old grader identities; rewriting legacy marks into a new result table. API authentication and unrelated deployment/403 issues remain separate workstreams.

## 3. Proposed target architecture: extend the existing services

### Non-negotiable contracts

1. Permanent students/users, room_student projection, dated placements, transfer events and financial records retain their existing identities.
2. CurrentTeacherAssignments + CurrentStudentMembership remain the current authorization sources. A template, annual pivot, old open period or prior grade never independently grants entry.
3. GradebookReadService stays the shared read/calculation entry point. Extend its inputs/adapters, not duplicate formulas in V2 views.
4. Original exam_result2/exam_result rows remain authoritative. Do not make template adoption, transfer or browsing copy earned marks.
5. Schema absence has a truthful compatibility/unavailable state, not an implicit migration, fake mapping or read-time repair.
6. Historical context is selected/stored context, never global current_term. Current Teacher writes remain active-year/current-term operations.
7. Definition/config version, shared assessment identity, result provenance, OPEN/LOCKED and report publication are separate concepts.

### Minimal versioned model

Proposed names are design labels, **not existing tables or authorized migrations**. Reuse existing services around these concepts:

| Additive entity | Minimum purpose and invariants |
|---|---|
| gradebook_templates | Reusable identity; Arabic name, optional English name/description, applicability metadata, creator and retirement metadata. Applicability is a validated rule, not responsibility/authorization. |
| gradebook_template_versions | Template ID/version number; draft revision; validated definition payload; calculation-policy version; canonical content hash; created/published actor/time. Published content immutable. Categories/columns can live in one validated LONGTEXT JSON payload initially rather than several speculative category tables. |
| gradebook_applications | Exact year, actual term, class, room and lesson; pinned version; effective interval; actor/reason; legacy snapshot/hash and adoption mode when relevant. One effective application per exact context at a given instant. End/supersede through audited transitions; never overwrite old context. |
| gradebook_assessment_bindings | Exact allowed source table + definition ID -> its native application and stable component identity; maximum/creation snapshot where reliably known. Many assessments may belong to one component. No positional or name-based equivalence. Source identity is uniquely owned; contextual/version history is preserved rather than rebinding earned definitions. |
| gradebook_context_states | Transactional equivalent of existing class + actual term OPEN/LOCKED, revision and updater. Default LOCKED; no read-time row creation. This is operational locking, not report finalization. |
| gradebook_events | Append-only actor/action/reason and immutable transition payloads for draft/publish/apply/lock/import and future managed grade-write provenance. Source references and before/after evidence, not a second authoritative grade store. |

Use validated JSON/text compatible with the actual hosting DB, not an assumed native JSON feature. External FK widths/signedness must match source tables; polymorphic source-table references need a strict whitelist and service checks, not a fictitious cross-table FK. Restrict deletion of used versions/applications/bindings; no academic cascade deletes.

Definition payload: stable category/component IDs, Arabic/optional English labels, order, category membership, exact source adapter, explicit maximum when supported, legacy source mapping, policy code and bounded parameters. Draft edits retain a revision token. New versions keep a component ID only when its meaning is unchanged; a genuinely new component or duplicated independent template receives new identity. Never recycle a retired dynamic source number for another meaning.

This implements the earlier template/version/application architecture with limited schema. A new canonical StudentResult/attempt engine, universal assessment registry replacement and immutable transcript snapshots are **not prerequisites for the first Phase 2 slices**; Phase 1 already supplies explicit identity for modern exams/quizzes.

### Compatibility and application granularity

Current `getConfig(lessonId, yearId)` cannot distinguish sections or terms. This is the most important compatibility decision.

Recommended initial policy, **subject to approval**:
- Store exact application contexts, but initially apply one compatible published definition to all relevant sections/terms of the same lesson/year.
- A class/subject batch action expands into explicit validated contexts and an impact preview; it is not a hidden class-wide inheritance rule.
- Do not enable different section/term versions for the same lesson/year until every affected consumer accepts explicit context.
- Extend the existing config service through a contextual resolver/adapter. A two-argument legacy call must resolve a single unambiguous compatible definition or remain on the original file path. It must never choose the latest/first conflicting application.
- Application presence, not an invisible file overwrite, selects the authoritative backend. Before pinning: legacy file remains authoritative. After pinning: immutable version is authoritative and the old editor must route to an explicit new-draft workflow or reject stale direct writes.
- No dual authoritative DB+file writes. Preserve source JSON and hash; import is a reviewed command, never a GET side effect.
- A term-specific template upgrade is technically possible later, but must not silently change the other term's labels, maxima or totals through the old lesson/year interface.

A stricter term/section-specific MVP is a realistic alternative, but requires upgrading all config readers/writers before allowing the first divergent application. Do not imply this is a front-end-only choice.

### Legacy snapshot/import rules

- Snapshot all four source files **exactly**, including missing components, actual IDs, dynamic numbers, labels, maxima/weight fields and hash.
- Snapshot generated defaults as "observed defaults at adoption," not as proven historical distributions. Absence of a file is different from invalid/unreadable JSON.
- Config 49_5's ID/source mismatch needs a flagged import preview. Do not run the existing editor's forced legacy remapping as an import. Quarantine unresolved contexts from new template activation; keep legacy reads intact.
- A new class-specific lesson ID does not automatically share the legacy dynamic source mapping of a same-named lesson.
- Published version labels/maxima are reliable from capture onward only. Old files and mutable definition maxima do not establish the original historical grading rule.
- Freeze existing result-bearing structural applications in the MVP. Copy/publish a new version for unused/future contexts instead. Adding/removing columns or changing maxima after marks needs a separate approved effective-version and impact policy; a new version alone is not permission to reinterpret earned data.
- Presentation-only changes still version published metadata; existing applications remain pinned until an explicit permitted upgrade.

### Calculations, maxima and multiple assessments

Initial policy recommendation: encode the existing behavior as a named compatibility policy, not a new grading rule:
- Confirmed lesson/oral average; modern quiz average; modern final-exam maximum; dynamic component existing averaging; current one-decimal summary rounding.
- Preserve raw values/maxima/occurrences and all actual term IDs. Zero is earned zero; missing remains missing; an all-missing total remains null.
- Preserve current partial-summary behavior but label it provisional/incomplete rather than a finalized result.
- Separate legacy capacity fallback (`subject.max_mark * weight / 100`) from genuine weighted calculation. Do not enforce 100% or normalize scores merely because the current editor says "%".
- A component can contain multiple independent quizzes/exams in one term. Definition bindings must not impose one-assessment-per-component/term uniqueness.
- Existing Admin summary selects one representative term per type; the raw matrix covers all terms. Do not silently sum duplicate type-1 terms or invent a "final" semester.
- exams2.mark is integer: recommend integer maxima for initially materialized legacy containers. Decimal earned marks already exist as strings; decimal **maximum** support requires an explicitly reviewed adapter/schema decision, not implicit truncation.
- Source definition maximum remains the earned assessment's bound. A new template maximum cannot rewrite it or rescale its results.

Preserve old summary values during compatibility rollout. New weighting, precision, pass thresholds and publication must be approved and tested as separate policies. The current Admin final tab's simple sum / 50-threshold badges must not be presented as certified promotion decisions during V2 work.

### Continuity, provenance and historical safety

Continue AssessmentEquivalenceService / AssessmentContinuityService unchanged in meaning:
- Explicit equivalent modern assessments only; same class/year/term/lesson/type/maximum, distinct section registrations, verified evidence.
- Same template/category/name/maximum does **not** create equivalence. New template bindings are not a replacement for the Phase 1 mapping.
- Receiving Teacher sees relevant authorized current-roster history without gaining the former section's roster or correction rights.
- Carried/conflicting records have no editable inputs; all mutation paths keep server-side protection.
- Unmapped history stays separate and excluded from new totals; no automatic cross-grade/new-year transfer of marks.
- Operational A -> B -> A remains blocked by StudentTransferService even though the continuity resolver has a synthetic interval test. Phase 2 must not change that rule.

For new managed writes, capture actual actor, native source result/definition, exact context, pinned config/binding and observed maximum atomically in events. Keep placement/Teacher period links only when independently valid; an operational membership fallback is not proof of an exact historical interval. Preserve reliable room/year/term evidence and explicitly unresolved provenance, or block a conflicting managed context under a defined validation rule. Never guess a placement or old grader from today's assignment; creator is not necessarily evaluator.

Versioning configuration alone does not reconstruct an old corrected mark or an issued transcript. Going-forward write events can preserve revisions; historic unlogged authors/corrections remain unknown. Finalized transcript snapshots and a broader correction workflow remain later scope.

### OPEN/LOCKED, permissions and concurrency

- Preserve current **class + actual term** scope, displayed with affected sections/subjects. Term implies its year; validate it against context.
- Lock/unlock must be revision-checked, actor-attributed and serialized with managed grade saves. A stale form cannot reopen a newly locked context.
- Template draft/published state is separate from class entry OPEN/LOCKED; both are separate from legacy report adjustable/finalized protection.
- Do not make an OPEN file authorize ordinary exams, or make a new lock silently block all legacy marking. Harmonization requires D4 below.
- Existing Admin capability `student_marks` and type/role boundaries remain the starting point. Publishing/applying needs explicit confirmation/reason/impact review. Real dual approval requires additional actor-separation rules; the global Admin Gate override means new ability names alone do not enforce it.
- Teacher current authority is always revalidated through the timetable resolver, including after replacements/term changes; templates do not assign Teachers.
- Preserve existing transactions and establish one documented lock order after inspecting transfer/timetable/grading writers. Add optimistic revisions for drafts, applications, status and managed result edits; row locks alone do not prevent a stale browser overwrite.
- Retention/model traits stay in place. Every live mutation path capable of editing a managed binding must either participate in version/context checks or safely reject that managed operation. Do not leave a legacy AJAX/raw-query bypass.
- Read requests must not publish, pin, import, scaffold marks or synchronize assignments.

## 4. Phase 2 slices and review gates

These are independently reviewable implementation authorizations, not one bundled rewrite. Labels below are local Phase 2 slices, not a renumbering of completed phases.

### 2A. Context and compatibility contract — recommended first

**Goal:** give existing readers one explicit, testable context/version boundary before any template writes.

**User-visible scope:** no new academic operation or redesigned screen; preserve current pages and results. If added, an informational backend/config availability label must be truthful and read-only.

**Code:** small contextual value object/resolver, immutable read DTO/legacy adapter around existing config/status services, dry-run config/schema inventory, agreement tests for GradebookReadService and all known config callers. Distinguish absent/default, valid legacy config, invalid config, future context and unavailable version backend. No new live backend/cutover.

**Schema/migration:** none.

**Dependencies/preservation:** current services, timetable and membership contracts, fixture suite. Keep exact legacy output/mappings, originals and files byte-identical. Do not "fix" config 49_5 or add missing cores.

**Acceptance/tests:** default/configured/malformed/missing cases; all terms/occurrences; numeric zero/null; exact subject/room/year; ambiguous two-argument resolution rejected by the proposed contextual contract rather than guessed; no GET writes; legacy Admin/Teacher/Academic Record parity. Tests use disposable fixtures and fake storage outside school runtime. Establish query-count/performance baselines and a source-reference manifest.

**Gate:** approve this technical contract. New academic-policy decisions do not block 2A if it remains read-only and behavior-preserving.

### 2A-P. Bounded query/index support — optional separate review

**Goal/UI:** avoid slow rosters/history when scaling the agreed readers; no changed results/UI.

**Code/schema:** batch repeated schema/mapping/config reads per request, avoid per-Student/assessment repeated work, inspect EXPLAIN. Candidate nonunique indexes: result definition/student lookup and definition room/lesson/term context. Choose actual column order from measured queries.

**Migration:** only if EXPLAIN justifies new nonunique indexes; separate additive migration and engine/lock preflight. Never add earned-result uniqueness by deleting duplicates.

**Acceptance/tests:** identical source IDs/results; realistic large roster/multiple-term timing and bounded query counts; production-like MySQL execution plan and index-build impact. Dependencies: 2A baselines. This can proceed independently of visual work after approval.

### 2B. Reusable templates, drafts and immutable versions

**Goal/UI:** authorized Admin lists templates, creates/edits a draft, duplicates as draft, previews validation and publishes a version. No application to live marks yet.

**Code/schema:** template/version/event entities and repository/service; stable category/component IDs, bilingual metadata, explicit compatibility-policy definition, revision tokens. Proposed first additive migration creates those three entities only.

**Dependencies/preservation:** 2A; D1/D2/D3/D5/D6 decisions as applicable before publishing a usable version. Does not replace JSON, create exams or touch old results. No destructive delete of published/used versions.

**Acceptance/tests:** stale draft save rejects; published payload/hash immutable; duplication creates independent draft/component identity where appropriate; no source-number recycling; invalid/unsupported rules fail; publish is idempotent and recorded; unauthorized Teacher/Student/Officer requests denied. Pure draft validation can use neutral fixtures before academic choices are settled.

**Migration:** yes, additive foundation; actual DDL/FKs reviewed later.

### 2C. Explicit application, legacy adoption and operational state

**Goal/UI:** Admin selects compatible year/term/class/section/subject contexts, previews exact version/affected scope, then confirms adoption. Clear existing/default/unavailable/conflicting states; obvious class/term lock action.

**Code/schema:** application, exact source-binding and class/term-state entities; reviewed JSON/status import service; contextual config/status adapters; draft-only route from old editor for adopted contexts. Proposed additive migration creates these three entities. Record all transitions in events from 2B.

**Dependencies/preservation:** 2B, D1/D3/D4/D5. Future-context preparation is not active Teacher access. Import exact source files/hashes; do not create old bindings or historical applications from guessed dates. Legacy mode remains authoritative until explicit adoption succeeds.

**Acceptance/tests:** wrong-year/room/lesson/version tampering rejected; one effective application, no duplicate pins; concurrent apply/lock/stale editor requests handled atomically; no DB/file dual authority; previously earned definitions/results unchanged; unknown source config safely blocks adoption but not legitimate legacy reads; failed batch rolls back completely. Status defaults LOCKED without GET writes. Fixture tests prove same lesson/year sections cannot diverge while old callers remain ambiguous.

**Migration:** yes; no old result/scaffold/financial migration. Schema installation and adoption/import are separate approvals.

### 2D. Complete Admin V2 navigation and read surfaces

**Goal/UI:** migrate the entire existing 15-GET chain and 4 POST feedback surfaces coherently to the existing V2 shell, plus template screens already introduced. Clear review/configuration/operational hierarchy, contextual selectors, source matrices and explicit warnings.

**Code/schema:** Gradebook controllers/view models as needed, V2 partials, translations and scoped feature CSS; preserve routes. Consolidate selector components without changing authorization/queries. Read-only historical selection uses stored room/year/term; current Student card defaults remain current unless an explicit authorized historical context is selected.

**Dependencies/preservation:** stable 2A contracts; new backend UI uses 2B/2C only after their gates. Existing legacy-mode review pages can be modernized earlier as a cohesive sub-release. No formula changes, source writes, year activation or automatic aggregation.

**Acceptance/tests:** all existing routes including equivalence/unavailable state; exact raw IDs/all terms/multiple assessments; coherent default/missing/conflict/locked states; one search; accurate pagination/counts; no final-policy claims; keyboard/RTL/print. Browser widths 280, 320, 360, 375, 390, 430, 768, 1024 and desktop, short-height/landscape, long Arabic names. No page-level overflow; contained focusable matrix scrolling allowed. Real V2 shell tests, not child-only fixture screenshots.

**Migration:** none for layout. New backend screens depend on already installed 2B/2C schema.

### 2E. Teacher managed-entry integration and forward provenance

**Goal/UI:** existing Advanced Teacher entry shows exact applied version, original legacy sources, editable current dynamic components, maximum/state and reliable pending/success/error/conflict feedback. Keep normal legacy exam/quiz workflows intact.

**Code/schema:** contextual binding-aware dynamic writer/reader and optimistic save protocol; existing transactional services/traits remain. Append real actor/context/before-after evidence to gradebook_events for managed writes; no new result table. Preserve original source definition/result IDs and compatibility container names where required.

**Dependencies/preservation:** 2C, adopted-context schema, D2/D4/D6. Strict live timetable/student membership revalidation. Separate original lesson-system and modern source discriminators. No fabricated old provenance; carried/conflicting/closed context remains read-only.

**Acceptance/tests:** valid current Teacher and co-teaching; replacement/term switch revokes current access; zero/missing; source maximum enforcement; original marked definition unchanged; concurrent same-cell edits/stale token/duplicate submit/retry; lock during pending save; legacy request against managed binding cannot bypass checks; notifications preserved. A -> B verified carry remains one original result; unmapped history separate. No whole-grid rewrite for one-cell save.

**Migration:** no additional table if events support reviewed write provenance/revision references; any later source-column addition requires separate schema approval. Do not claim full revision coverage for external/raw-SQL writers.

### 2F. Phase 1 activation and continuity acceptance track

**Goal/UI:** make already implemented modern equivalence/continuity genuinely available and verify its existing UI across legacy/Advanced routes; do not reinvent it.

**Code/schema:** only confirmed compatibility defects found during staging acceptance. Apply the **existing** mapping migration only after source-engine/signed-ID preflight, backup and explicit approval; review explicit new multi-section creation/mapping. No historical automatic backfill.

**Dependencies/preservation:** D8; disposable production-like staging. Can run alongside 2A/2B rather than block drafting; required before claiming activated continuity for adopted applications.

**Acceptance/tests:** schema absent behavior; empty up/down/up on disposable data; populated rollback refusal; exact original results/maximum/context; multiple quizzes/exams/terms; single carried value; conflicts denied; original/correct receiving Teacher boundaries; real transfer preservation. Operational return transfers remain blocked. MySQL concurrency/FK and real authenticated browser acceptance are mandatory.

**Migration:** yes, the existing Phase 1 mapping migration for activation, not a new copy.

### 2G. End-to-end release and staff handover

**Goal/UI:** one coherent Admin/Teacher operational experience and exact staff guide for review, drafts, publish/apply, locks and unavailable/conflict states.

**Code/schema:** only confirmed focused regressions; no new academic policy engine. Finish browser, performance, localization and route parity. Keep aggregation explicitly separate/unexposed unless its report semantics are approved.

**Dependencies/preservation:** approved slices; 2F only when continuity is part of release claims. Production preflight/restore rehearsal separate from this planning task.

**Acceptance/tests:** shared-shell real sessions; authorization/tampered IDs; current/historical/future contexts; all 15 existing GETs/4 POSTs + new template flows; legacy exam/quiz/report/Academic Record regressions; all roster/transfer/assignment tests; unchanged original account/history/files/invoices fingerprints in fixtures/staging except intentional test writes. Verify rollback preserves accepted results/config versions.

**Migration:** none beyond individually approved prior slices. No release GO from syntax alone.

## 5. Prioritized decisions requiring owner approval

The following are recommendations, not adopted policies. The next slice 2A deliberately avoids choosing new academic rules.

| Priority / decision | Realistic alternatives | Recommendation and consequence | Blocks next 2A? / later gate |
|---|---|---|---|
| D1. Application granularity | Preserve lesson/year-compatible distribution; or enable section/term variation immediately | Preserve one compatible version across lesson/year initially, with exact target-context records. Less flexibility, smallest legacy risk; divergence waits for full contextual-consumer coverage. | No; blocks usable application contract in 2B/2C |
| D2. Meaning of maximum/weight/total | Existing raw average/max + sum; fixed-point contributions; normalized weighted categories | Freeze named legacy-compatible calculations first. Separate max from weight; design new policy only after school supplies examples. No invented 100% normalization or pass/fail rule. | No; blocks new calculation policy and publication of weighted templates |
| D3. Editing after earned activity | Freeze structural applications; allow reviewed effective-version upgrades; permit destructive in-place edits | Freeze structural changes after activity for MVP. Duplicate/version for unused/future contexts. A later approved impact/correction workflow can permit bounded upgrades. Protects old columns/maxima without inventing midterm redistribution. | No; blocks application-upgrade rules in 2C |
| D4. Lock semantics | Existing Advanced dynamic-only class/term gate; unified all-assessment lock; finer subject/section lock | Preserve existing operational scope and separate report finalization first. A universal/finer lock would change legitimate legacy workflows and needs explicit authorization. | No; blocks status cutover/acceptance |
| D5. Who publishes/applies/corrects | Current authorized Admin with recorded confirmation; narrower designated roles; mandatory second approver | MVP current authorized Admin + actor/reason/preview; no Teacher publishing. If dual approval is required, add explicit independent-actor checks rather than rely on can under Admin override. | No; blocks publish/apply UX and permission implementation |
| D6. Precision and missing-result states | Integer maxima with existing decimal score support; schema-backed decimal maxima; broad absent/exempt/make-up taxonomy | Initially retain integer materialized maxima and exact existing raw scores. Keep zero/missing/conflict/provenance distinct; no guessed absent/exempt values. Choose rounding/decimal precision with worked examples before expanding. | No; blocks new decimal-max/advanced state features |
| D7. Terms, final result and publication | Exact term-instance review; representative legacy type summary; merge duplicate term types and publish a new final formula | Raw exact-term review + labeled compatibility summary; no automatic duplicate-term merge or newly authoritative 50-threshold/final result. Transcript publication belongs to a later approved slice. | No; blocks final-calculation/publication changes, not read UI |
| D8. Phase 1 activation and carry policy | Activate explicit modern mapping after staging approval; keep unavailable until legitimate QA; infer equivalence automatically | Activate only through approved migration and explicit verified identity. Preserve same-grade/current-year/term scope and no automatic cross-grade/year carry. Can be independent of template drafting. | No; blocks live continuity acceptance in 2F |

Also confirm bilingual MVP scope (Arabic required, optional English labels), whether future-year *configuration* is allowed, and the retention/correction owner. Existing stale data is not repaired as an implicit answer to these questions.

No user approval is needed to invent historical facts: **that must never be done**. Separate reconciliation, data correction, make-up policy and return transfers require their own specifications.

## 6. Dependencies, migration and activation strategy

1. Inventory production independently before any future activation; local missing-table/ledger facts do not establish hosting state. Never reuse the absent January tables just because models exist.
2. No migration for 2A; optional measured nonunique index migration is independent. Phase 1 activation uses its existing reviewed migration.
3. Introduce only approved additive template/version/event schema in 2B, then application/binding/status schema in 2C. No result store replacement, mass source FK rewrites or blanket unique constraints on old rows.
4. Validate hosting MySQL/MariaDB engine/types/JSON support and PHP 7.4/Laravel 7 compatibility; use actual source signedness. Test schema absence and partial installation deterministically; never run migrations in a provider/request.
5. Back up DB plus all Gradebook config/status files. Schema installation is not import, import is not activation, and activation is not report publication.
6. Import snapshots idempotently with source hash, original context and explicit review. A changed file/hash or unresolved mapping aborts adoption rather than overwriting the newer source. No broad "fix legacy IDs" step.
7. Before adopting a context, all its live readers/writers must agree on the single authority. Direct old settings POSTs must not overwrite the pinned context; no fallback to a different version after malformed/unavailable managed data.
8. Historical legacy contexts stay on an explicit legacy adapter until verified adoption. Do not label a new capture as the template originally used to earn old marks.
9. Stage shadow comparisons before cutover. Named compatibility policy must match the current shared reader on resolved fixtures/real read-only samples; discrepancy blocks activation, not prompts automatic clipping/scaling.
10. Rollback keeps published versions, bindings, audit events and any accepted source results. Roll back code only to a version that can read adopted contexts; do not drop used tables or restore an entire old DB over newer school work.
11. The earlier production-readiness NO-GO, legacy API authentication limitation and unresolved hosting/public 403 diagnosis remain separate release gates/owner decisions; Phase 2 planning is not a bypass.

### Likely affected areas when implementation is later approved

- Existing GradebookConfigService, GradebookStatusService and GradebookReadService; bounded new context/template/application repositories and events.
- Admin GradebookController, GradebookSettingsController and existing equivalence controller; TeacherGradebookController; relevant managed legacy adapters only where required.
- Existing preservation traits, AssessmentResultSafety and TeacherAssessmentService as compatibility constraints; no removal/replacement of timetable authority.
- Existing gradebook.php/Teacher route contracts plus narrowly added template routes under reviewed Admin authorization.
- All active Admin Gradebook views, shared assessment/continuity partials, Advanced Teacher view, translations and V2 feature-scoped styles.
- Approved additive migrations, fixture schema and Gradebook/timetable/membership/transfer/frontend tests.

Not in scope: finance, lifecycle redesign, timetable reconciliation, new Student Portal design, complaints, attendance or a generalized school authorization rewrite.

## 7. Risks and safeguards

| Risk | Required safeguard / acceptance |
|---|---|
| Template application treated as Teacher responsibility | Always query current timetable + current Student membership; no template-based access, no previous-term/year fallback, no assignment synchronization on GET |
| Two-argument legacy config lookup versus divergent applications | Keep initial compatibility restriction; contextual adapter everywhere before divergence; reject ambiguity instead of first/latest |
| File/DB split authority and concurrent edits | Explicit per-context adoption state, source hash/revision, one writer/backend, stale request conflict and transaction/event record |
| Existing config mismatch or missing core | Exact snapshot + review warning; no forced name/ID/source normalization or implicit default repair |
| New template changes old maxima/scores | Immutable pins and original definition bounds; used binding cannot be rebound; freeze structural upgrades pending approved policy |
| Percent labels mistaken for approved weighting | Preserve named compatibility policy; separate raw score/max/weight; policy examples approved before changes |
| Phase 1 table missing or mapping incomplete | Explicit unavailable/unmapped state; no copied marks, guessed equivalence or runtime migration |
| Multiple occurrences reduced to one | Original source table + definition/result IDs retained; many-to-one component binding; fixtures for multiple quizzes/exams in each term |
| Repeat term definitions and history | Actual term IDs, selected room/year/placement; never global current term for history or silent type merge |
| Transfer/replacement leaks or ownership rewrite | Receiving current-roster projection only; former sources remain native; no old Teacher ownership reassignment; unknown grader remains unknown |
| OPEN/LOCKED confused with finalization | Separate scope/labels/services; no unauthorized universal locking or report republishing |
| Lost saves and mixed writer races | Managed source row/context/state lock order, optimistic revision and server-revalidated maxima; all known managed mutation paths covered |
| Immutable template mistaken for immutable transcript | Capture going-forward revisions; do not claim old authorship or issued result reproducibility without evidence/snapshot foundation |
| Orphan/above-bound/missing legacy context | Flag unresolved data, preserve rows and block unsafe writes; no bulk normalization, inferred enrollment or repaired totals |
| Query scale | Batch per-context reads, bounded roster rendering/pagination, EXPLAIN-led nonunique indexes and representative MySQL load tests |
| V2 CSS/plugin collision | Reuse one Admin shell and dependencies; scoped Gradebook root; whole-chain RTL/mobile/keyboard tests |
| Partial migration/deployment | Schema capability checks, dependency-complete artifact, staging activation and forward-compatible rollback |

### Read-only verification and limitations of this planning pass

Reviewed actual source contracts and existing test coverage; made fresh SELECT-only schema/context/config/data/index checks. Did not rerun school-backed controllers, write/transfer tests, HTTP logins, migrations, cache commands or full feature suites. Existing reports' fixture results remain prior evidence, not current browser/production acceptance.

No application code or academic policy was changed. Only this report is created. A final preservation check compares existing source files and paired school/config snapshots; it does not claim a production backup or full database atomic audit.

Final check: all 20 paired school-table fingerprints and all six Gradebook config/status file hashes match. Existing inspected source/report hashes are unchanged; Git shows only this new report. git diff --check passes, and this report is UTF-8 without BOM. No migration, cache operation, application implementation, commit or deployment occurred.

## 8. Recommended first implementation authorization

Approve **Slice 2A only: contextual configuration/status contract, immutable read DTO/legacy adapter and agreement/dry-run tests**.

Deliverable should be a small code-only foundation with **no migration, config adoption, calculation change, Teacher assignment change, template publication or UI overhaul**. It should make later template scope choices explicit, identify ambiguous legacy contexts honestly and prove that current source results still match.

Then review the 2A contract and D1-D6 decisions before authorizing draft/version schema. Phase 1 migration/continuity acceptance can be separately prepared on disposable staging; it must not be silently folded into a UI task.

## Executive summary for the project owner

- **Continue, do not restart.** Phases 0A/0B and the bounded Phase 1 implementation are the foundation; timetable authority remains unchanged.
- **Implemented is not activated.** Modern continuity code exists, but its mapping migration/table is still absent locally. Production readiness remains unverified.
- **The next foundation is configuration identity, not another grade database.** Add reusable immutable template versions and explicit applications around the existing original results and shared reader.
- **The main compatibility decision is scope.** Recommend preserving lesson/year-compatible distribution first; section/term differences require every legacy consumer to understand exact context.
- **The first task should be small and read-only in behavior.** Slice 2A needs no migration and makes the later template work testable.
- **School decisions precede new academic behavior.** Agree weighting/maxima, edits after marks, lock scope, approvers, precision/states and final-term/publication rules. No destructive legacy repair or inferred carry-forward is authorized.
- **Full V2 remains part of Phase 2.** Migrate every active Admin screen and preserve legacy Teacher entry; visual completion follows safe contracts and is accepted in real browsers.
- **Approval requested next:** review this roadmap, authorize 2A, and decide D1-D6 before publishing/applying templates. No Phase 2 feature or deployment has been implemented by this review.

