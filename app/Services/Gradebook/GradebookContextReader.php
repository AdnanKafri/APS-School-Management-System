<?php

namespace App\Services\Gradebook;

use App\Classe;
use App\Lesson;
use App\Room;
use App\Term_year;
use App\Year;
use App\Services\GradebookConfigService;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

/** Opt-in inspection adapter. Existing Gradebook services remain authoritative. */
final class GradebookContextReader
{
    private $files;

    public function __construct(Filesystem $files = null)
    {
        $this->files = $files ?: Storage::disk();
    }

    public function resolve(GradebookContext $requested)
    {
        $year = Year::find($requested->yearId());
        $subject = Lesson::find($requested->subjectId());
        if (!$year || !$subject || !Classe::whereKey($subject->class_id)->exists()
            || ($requested->classId() !== null && (int) $subject->class_id !== $requested->classId())) {
            throw new \InvalidArgumentException('Gradebook year/subject/class context does not exist or match.');
        }
        if ($requested->termId() !== null && !Term_year::whereKey($requested->termId())
            ->where('year_id', $year->id)->exists()) {
            throw new \InvalidArgumentException('The selected term does not belong to the selected year.');
        }
        if ($requested->roomId() !== null && !Room::whereKey($requested->roomId())
            ->where('year_id', $year->id)->where('class_id', $subject->class_id)->exists()) {
            throw new \InvalidArgumentException('The selected section does not belong to the selected year/class.');
        }
        $current = Year::where('current_year', 1)->get(['id', 'name']);
        $timeline = $this->timeline($year, $current);
        $status = $requested->termId() === null
            ? ['state'=>'not_applicable', 'value'=>null, 'path'=>null, 'sha256'=>null]
            : $this->status($subject->class_id, $requested->termId());

        // No future application table is queried or inferred in Slice 2A.
        if ($requested->configurationSource() === 'versioned_template') {
            $configuration = ['state'=>'backend_unavailable', 'source'=>'versioned_template',
                'revision'=>$requested->configurationVersion(), 'path'=>null, 'sha256'=>null,
                'warnings'=>[], 'usable'=>false];
            $components = [];
        } else {
            [$configuration, $components] = $this->configuration($subject->id, $year->id);
            if (($requested->configurationSource() !== null
                    && $requested->configurationSource() !== $configuration['source'])
                || ($requested->configurationVersion() !== null
                    && $requested->configurationVersion() !== $configuration['revision'])) {
                throw new \DomainException('The requested configuration source/revision is no longer available.');
            }
        }
        $context = new GradebookContext($year->id, $subject->id, $requested->termId(),
            $subject->class_id, $requested->roomId(), $configuration['source'], $configuration['revision']);
        return new GradebookReadSnapshot($context, [
            'timeline'=>$timeline, 'configuration'=>$configuration, 'components'=>$components,
            'status'=>$status, 'versioned_backend'=>'unavailable_not_implemented',
            'configuration_scope'=>$configuration['source'] === 'versioned_template' ? 'unresolved' : 'subject_year',
            'status_scope'=>'class_term',
        ]);
    }

    /** Candidates are supplied evidence, not applications fetched or selected here. */
    public function resolveLegacy($subjectId, $yearId, array $candidates = [])
    {
        $scope = new GradebookContext($yearId, $subjectId);
        $identities = [];
        foreach ($candidates as $candidate) {
            if (!$candidate instanceof GradebookContext || $candidate->subjectId() !== $scope->subjectId()
                || $candidate->yearId() !== $scope->yearId() || $candidate->configurationSource() === null
                || $candidate->configurationVersion() === null) {
                throw new \InvalidArgumentException('Legacy candidate evidence must identify the same subject/year and a revision.');
            }
            $identities[json_encode([$candidate->configurationSource(), $candidate->configurationVersion()])] = true;
        }
        if (count($identities) > 1) {
            throw new \DomainException('Ambiguous legacy lookup: exact contextual configuration is required.');
        }
        if ($identities) {
            [$source, $revision] = json_decode(array_keys($identities)[0], true);
            $scope = new GradebookContext($yearId, $subjectId, null, null, null, $source, $revision);
        }
        return $this->resolve($scope);
    }

    private function readFile($path)
    {
        try {
            if (!$this->files->exists($path)) return ['state'=>'missing', 'bytes'=>null];
            $bytes = $this->files->get($path);
            if (!is_string($bytes)) return ['state'=>'unreadable', 'bytes'=>null];
            return ['state'=>'present', 'bytes'=>$bytes];
        } catch (\Exception $e) {
            return ['state'=>'unreadable', 'bytes'=>null];
        }
    }

    private function configuration($subjectId, $yearId)
    {
        $path = 'gradebook/'.$subjectId.'_'.$yearId.'.json';
        $file = $this->readFile($path);
        $components = GradebookConfigService::getDefaults()->all();
        $state = $file['state'];
        $source = 'legacy_defaults';
        $warnings = [];
        if ($state === 'present') {
            $json = json_decode($file['bytes'], true);
            $state = 'invalid';
            if (json_last_error() === JSON_ERROR_NONE && is_array($json) && isset($json['components'])
                && is_array($json['components'])) {
                $state = 'valid';
                $source = 'legacy_json';
                $components = [];
                $seen = [];
                foreach ($json['components'] as $row) {
                    $components[] = (object) $row;
                    if (!is_array($row) || !isset($row['id'], $row['name'], $row['weight'], $row['data_source'])
                        || !is_scalar($row['id']) || !is_scalar($row['name']) || !is_scalar($row['data_source'])
                        || !is_numeric($row['weight'])) {
                        $state = 'invalid';
                        continue;
                    }
                    if (isset($seen[(string) $row['id']])) $warnings[] = 'duplicate_component_id';
                    $seen[(string) $row['id']] = true;
                    $reserved = ['legacy_oral'=>'LEGACY_ORAL', 'legacy_homework'=>'LEGACY_HOMEWORK', 'legacy_exam'=>'LEGACY_EXAM'];
                    if (isset($reserved[$row['id']]) && (string) $row['data_source'] !== $reserved[$row['id']]) {
                        $warnings[] = 'legacy_id_source_mismatch';
                    }
                }
                foreach (['lesson_id'=>$subjectId, 'year_id'=>$yearId] as $key=>$value) {
                    if (isset($json[$key]) && (!is_scalar($json[$key])
                        || (string) $json[$key] !== (string) $value)) $warnings[] = 'envelope_context_mismatch';
                }
            }
        }
        $revisionBytes = $source === 'legacy_json' ? $file['bytes']
            : json_encode($components, JSON_PRESERVE_ZERO_FRACTION | JSON_THROW_ON_ERROR);
        return [[
            'state'=>$state, 'source'=>$source, 'revision'=>'sha256:'.hash('sha256', $revisionBytes),
            'path'=>$path, 'sha256'=>$file['bytes'] === null ? null : hash('sha256', $file['bytes']),
            'warnings'=>array_values(array_unique($warnings)), 'usable'=>in_array($state, ['valid', 'missing'], true),
        ], $components];
    }

    private function status($classId, $termId)
    {
        $path = 'gradebook_status/'.$classId.'_'.$termId.'.json';
        $file = $this->readFile($path);
        $state = $file['state'];
        $value = $state === 'unreadable' ? null : 'LOCKED';
        if ($state === 'present') {
            $json = json_decode($file['bytes'], true);
            $state = 'invalid';
            if (json_last_error() === JSON_ERROR_NONE && is_array($json) && isset($json['status'])) {
                $value = $json['status'];
                if (in_array($value, ['OPEN', 'LOCKED'], true)) $state = 'valid';
            }
        }
        return ['state'=>$state, 'value'=>$value, 'path'=>$path,
            'sha256'=>$file['bytes'] === null ? null : hash('sha256', $file['bytes'])];
    }

    private function timeline($year, $current)
    {
        if ($current->count() !== 1) return 'unresolved';
        $active = $current->first();
        if ((int) $year->id === (int) $active->id) return 'current';
        $pattern = '/^\s*(\d{4})\s*[\/-]\s*(\d{4})\s*$/D';
        if (!preg_match($pattern, $year->name, $selected) || !preg_match($pattern, $active->name, $present)
            || (int) $selected[2] !== (int) $selected[1] + 1 || (int) $present[2] !== (int) $present[1] + 1
            || (int) $selected[1] === (int) $present[1]) return 'unresolved';
        return (int) $selected[1] < (int) $present[1] ? 'historical' : 'future';
    }
}
