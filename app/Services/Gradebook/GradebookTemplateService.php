<?php

namespace App\Services\Gradebook;

use App\GradebookEvent;
use App\GradebookTemplate;
use App\GradebookTemplateVersion;
use App\Lesson;
use App\Year;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/** Inactive definitions only. Never calls config/status, assessment or mark writers. */
class GradebookTemplateService
{
    const POLICY = 'legacy_read_v1_unchanged';

    public function authorize()
    {
        abort_unless(auth()->check() && (string) auth()->user()->type === '2'
            && auth()->user()->can('student_marks'), 403);
        abort_unless($this->available(), 503, __('gradebook_templates.unavailable'));
    }

    public function available()
    {
        foreach (['gradebook_templates', 'gradebook_template_versions', 'gradebook_events'] as $table) {
            if (!Schema::hasTable($table)) return false;
        }
        // MySQL DDL is not transactional: an interrupted trigger installation must fail closed.
        $required = ['gb_version_update_immutable', 'gb_version_delete_immutable',
            'gb_event_update_immutable', 'gb_event_delete_immutable'];
        if (DB::getDriverName() === 'mysql') {
            $installed = DB::table('information_schema.TRIGGERS')
                ->where('TRIGGER_SCHEMA', DB::connection()->getDatabaseName())
                ->whereIn('TRIGGER_NAME', $required)->pluck('TRIGGER_NAME')->all();
        } elseif (DB::getDriverName() === 'sqlite') {
            $installed = DB::table('sqlite_master')->where('type', 'trigger')
                ->whereIn('name', $required)->pluck('name')->all();
        } else {
            return false;
        }
        return count(array_diff($required, $installed)) === 0;
    }

    private function reject($key, $field = 'template')
    {
        throw ValidationException::withMessages([$field=>__('gradebook_templates.'.$key)]);
    }

    private function scope($yearId, $lessonId)
    {
        Validator::make(['year_id'=>$yearId, 'lesson_id'=>$lessonId], [
            'year_id'=>'required|integer|exists:years,id', 'lesson_id'=>'required|integer|exists:lessons,id',
        ])->validate();
        $subject = Lesson::findOrFail($lessonId);
        if (!$subject->class_id || !\App\Classe::whereKey($subject->class_id)->exists()) $this->reject('scope');
        return $subject;
    }

    private function revision(GradebookTemplate $template, $revision)
    {
        if ((!is_int($revision) && !is_string($revision)) || !preg_match('/^[1-9][0-9]*$/D', (string) $revision)
            || (string) $template->draft_revision !== (string) $revision) $this->reject('stale');
    }

    private function payload(array $input, array $allowedIds)
    {
        Validator::make($input, [
            'name_ar'=>'required|string|max:200', 'name_en'=>'nullable|string|max:200',
            'components'=>'required|array|min:1|max:100', 'components.*'=>'required|array',
            'components.*.name_ar'=>'required|string|max:200', 'components.*.name_en'=>'nullable|string|max:200',
            'components.*.maximum'=>'required|integer|min:1|max:2147483647',
            'components.*.id'=>'nullable|string',
        ])->validate();
        $seen = [];
        $rows = [];
        foreach (array_values($input['components']) as $index=>$component) {
            if (!is_int($component['maximum']) && !is_string($component['maximum'])) $this->reject('invalid_maximum');
            if (!preg_match('/^[1-9][0-9]*$/D', (string) $component['maximum'])) $this->reject('invalid_maximum');
            $id = $component['id'] ?? '';
            if ($id === '' || $id === null) $id = (string) Str::uuid();
            elseif (!preg_match('/^[a-f0-9]{8}-[a-f0-9]{4}-4[a-f0-9]{3}-[89ab][a-f0-9]{3}-[a-f0-9]{12}$/D', $id)
                || !in_array($id, $allowedIds, true)) $this->reject('identity');
            if (isset($seen[$id])) $this->reject('identity');
            $seen[$id] = true;
            if (trim($component['name_ar']) === '') $this->reject('invalid');
            $rows[] = ['id'=>$id, 'name_ar'=>trim($component['name_ar']),
                'name_en'=>trim($component['name_en'] ?? ''), 'maximum'=>(int) $component['maximum'], 'order'=>$index + 1];
        }
        if (trim($input['name_ar']) === '') $this->reject('invalid');
        return ['format'=>1, 'calculation_policy'=>self::POLICY, 'name_ar'=>trim($input['name_ar']),
            'name_en'=>trim($input['name_en'] ?? ''), 'components'=>$rows];
    }

    private function json(array $payload)
    {
        return json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
    }

    private function event(GradebookTemplate $template, $action, array $metadata, $versionId = null)
    {
        $event = new GradebookEvent();
        $event->forceFill(['template_id'=>$template->id, 'version_id'=>$versionId,
            'actor_id'=>auth()->id(), 'action'=>$action, 'metadata'=>$metadata, 'created_at'=>now()])->save();
    }

    public function create($yearId, $lessonId, $name)
    {
        $this->authorize();
        $this->scope($yearId, $lessonId);
        Validator::make(['name'=>$name], ['name'=>'required|string|max:200'])->validate();
        if (trim($name) === '') $this->reject('invalid');
        return DB::transaction(function () use ($yearId, $lessonId, $name) {
            // Serialize scope creation using the existing subject; unique scope is the final arbiter.
            $subject = Lesson::whereKey($lessonId)->lockForUpdate()->firstOrFail();
            if (!$subject->class_id || !\App\Classe::whereKey($subject->class_id)->exists()) $this->reject('scope');
            if (GradebookTemplate::where('year_id', $yearId)->where('lesson_id', $lessonId)->exists()) $this->reject('scope_exists');
            $template = new GradebookTemplate();
            $template->forceFill(['identity'=>(string) Str::uuid(), 'year_id'=>$yearId, 'lesson_id'=>$lessonId,
                'class_id'=>$subject->class_id, 'created_by'=>auth()->id(), 'name'=>trim($name), 'draft_revision'=>1,
                'draft_payload'=>['format'=>1, 'calculation_policy'=>self::POLICY,
                    'name_ar'=>trim($name), 'name_en'=>'', 'components'=>[]], 'last_version'=>0])->save();
            $this->event($template, 'template_created', ['revision'=>1]);
            return $template;
        }, 3);
    }

    public function save($id, $revision, array $input)
    {
        $this->authorize();
        return DB::transaction(function () use ($id, $revision, $input) {
            $template = GradebookTemplate::whereKey($id)->lockForUpdate()->firstOrFail();
            $this->revision($template, $revision);
            if ($template->draft_payload === null) $this->reject('no_draft');
            // Scope cannot be changed by forged form fields.
            foreach (['year_id', 'lesson_id', 'class_id'] as $key) {
                if (array_key_exists($key, $input) && (!is_scalar($input[$key])
                    || (string) $input[$key] !== (string) $template->$key)) $this->reject('scope');
            }
            $before = $template->draft_payload;
            $payload = $this->payload($input, array_column($before['components'], 'id'));
            $template->forceFill(['draft_payload'=>$payload, 'name'=>$payload['name_ar'],
                'draft_revision'=>$template->draft_revision + 1])->save();
            $this->event($template, 'draft_updated', ['revision'=>$template->draft_revision,
                'before_hash'=>hash('sha256', $this->json($before)), 'after_hash'=>hash('sha256', $this->json($payload)),
                'changes'=>$this->diff($before, $payload)]);
            return $template;
        }, 3);
    }

    public function discard($id, $revision, $reason)
    {
        $this->authorize();
        Validator::make(['reason'=>$reason], ['reason'=>'required|string|min:3|max:1000'])->validate();
        if (mb_strlen(trim($reason)) < 3) $this->reject('invalid');
        return DB::transaction(function () use ($id, $revision, $reason) {
            $template = GradebookTemplate::whereKey($id)->lockForUpdate()->firstOrFail();
            $this->revision($template, $revision);
            if ($template->draft_payload === null) $this->reject('no_draft');
            $snapshot = $template->draft_payload;
            $template->forceFill(['draft_payload'=>null, 'draft_base_version'=>null,
                'draft_revision'=>$template->draft_revision + 1])->save();
            $this->event($template, 'draft_discarded', ['revision'=>$template->draft_revision,
                'reason'=>trim($reason), 'discarded_payload'=>$snapshot]);
            return $template;
        }, 3);
    }

    public function startDraft($id, $revision, $versionId = null)
    {
        $this->authorize();
        return DB::transaction(function () use ($id, $revision, $versionId) {
            $template = GradebookTemplate::whereKey($id)->lockForUpdate()->firstOrFail();
            $this->revision($template, $revision);
            if ($template->draft_payload !== null) $this->reject('draft_exists');
            $source = $versionId === null ? null : $template->versions()->whereKey($versionId)->firstOrFail();
            $payload = $source ? $source->payload['definition'] : ['format'=>1, 'calculation_policy'=>self::POLICY,
                'name_ar'=>$template->name, 'name_en'=>'', 'components'=>[]];
            $template->forceFill(['draft_payload'=>$payload, 'draft_base_version'=>$source ? $source->number : null,
                'draft_revision'=>$template->draft_revision + 1])->save();
            $this->event($template, $source ? 'draft_from_version' : 'draft_started',
                ['revision'=>$template->draft_revision, 'source_version_id'=>$source ? $source->id : null], $source ? $source->id : null);
            return $template;
        }, 3);
    }

    public function duplicate($versionId, $yearId, $lessonId, $name)
    {
        $this->authorize();
        return DB::transaction(function () use ($versionId, $yearId, $lessonId, $name) {
            $source = GradebookTemplateVersion::findOrFail($versionId);
            $template = $this->create($yearId, $lessonId, $name);
            $payload = $source->payload['definition'];
            $payload['name_ar'] = $name;
            foreach ($payload['components'] as &$component) $component['id'] = '';
            unset($component);
            $template = $this->save($template->id, $template->draft_revision, $payload);
            $this->event($template, 'template_duplicated', ['source_version_id'=>$source->id]);
            return $template;
        }, 3);
    }

    public function diff(array $before, array $after)
    {
        $old = array_column($before['components'], null, 'id');
        $new = array_column($after['components'], null, 'id');
        $changes = ['added'=>[], 'removed'=>[], 'renamed'=>[], 'maximum_changed'=>[], 'reordered'=>[]];
        foreach ($new as $id=>$row) {
            if (!isset($old[$id])) { $changes['added'][] = $row; continue; }
            foreach (['renamed'=>['name_ar','name_en'], 'maximum_changed'=>['maximum'], 'reordered'=>['order']] as $kind=>$keys) {
                foreach ($keys as $key) {
                    if ($old[$id][$key] !== $row[$key]) { $changes[$kind][] = ['id'=>$id, 'before'=>$old[$id], 'after'=>$row]; break; }
                }
            }
        }
        foreach ($old as $id=>$row) if (!isset($new[$id])) $changes['removed'][] = $row;
        return $changes;
    }

    private function review(GradebookTemplate $template)
    {
        if ($template->draft_payload === null) $this->reject('no_draft');
        $subject = $this->scope($template->year_id, $template->lesson_id);
        if ((int) $subject->class_id !== (int) $template->class_id) $this->reject('scope');
        $payload = $this->payload($template->draft_payload, array_column($template->draft_payload['components'], 'id'));
        $previous = $template->versions()->where('number', $template->last_version)->first();
        $scope = ['year_id'=>(int) $template->year_id, 'lesson_id'=>(int) $template->lesson_id,
            'class_id'=>(int) $template->class_id, 'year_name'=>Year::findOrFail($template->year_id)->name,
            'lesson_name'=>$subject->name, 'class_name'=>\App\Classe::findOrFail($template->class_id)->name];
        $snapshot = ['scope'=>$scope, 'definition'=>$payload];
        $hash = hash('sha256', $this->json($snapshot));
        $token = hash_hmac('sha256', $this->json([$template->identity, $template->draft_revision,
            $template->last_version, $hash]), (string) config('app.key'));
        return ['payload'=>$snapshot, 'content_hash'=>$hash, 'preview_token'=>$token,
            'revision'=>$template->draft_revision, 'total'=>array_sum(array_column($payload['components'], 'maximum')),
            'previous'=>$previous, 'changes'=>$this->diff($previous ? $previous->payload['definition'] : ['components'=>[]], $payload)];
    }

    public function preview($id)
    {
        $this->authorize();
        return DB::transaction(function () use ($id) {
            return $this->review(GradebookTemplate::whereKey($id)->lockForUpdate()->firstOrFail());
        });
    }

    public function publish($id, $revision, $token, $confirmed)
    {
        $this->authorize();
        Validator::make(['confirmed'=>$confirmed, 'preview_token'=>$token, 'revision'=>$revision], [
            'confirmed'=>'accepted', 'preview_token'=>'required|string|size:64', 'revision'=>'required|integer|min:1',
        ])->validate();
        return DB::transaction(function () use ($id, $revision, $token) {
            $template = GradebookTemplate::whereKey($id)->lockForUpdate()->firstOrFail();
            $published = $template->versions()->where('draft_revision', $revision)->first();
            if ($published) {
                if (!hash_equals($published->preview_token, $token)) $this->reject('stale');
                return $published; // Idempotent retry: no extra version/event and no effect on a newer draft.
            }
            $this->revision($template, $revision);
            $review = $this->review($template);
            if (!hash_equals($review['preview_token'], $token)) $this->reject('stale');
            $version = new GradebookTemplateVersion();
            $version->forceFill(['template_id'=>$template->id, 'number'=>$template->last_version + 1,
                'draft_revision'=>$template->draft_revision, 'base_version'=>$template->draft_base_version,
                'payload'=>$review['payload'], 'content_hash'=>$review['content_hash'], 'preview_token'=>$token,
                'published_by'=>auth()->id(), 'published_at'=>now()])->save();
            $template->forceFill(['last_version'=>$version->number, 'draft_payload'=>null,
                'draft_base_version'=>null, 'draft_revision'=>$template->draft_revision + 1])->save();
            $this->event($template, 'version_published', ['number'=>$version->number,
                'content_hash'=>$review['content_hash'], 'changes'=>$review['changes']], $version->id);
            return $version;
        }, 3);
    }
}
