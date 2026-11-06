<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Classe;
use App\Lesson;
use App\Room;
use App\Year;
use App\GradebookConfig;

class GradebookSettingsController extends Controller
{
    /**
     * Show selection screen (Classes)
     */
    public function index()
    {
        $year = Year::where('current_year', '1')->first();
        if (!$year) {
            return redirect()->route('admin.gradebook.index')->with('error', __('gradebook.year_missing'));
        }
        $classes = Classe::withCount(['room' => function ($query) use ($year) {
            $query->where('year_id', $year->id);
        }])->paginate(10);
        $term = \App\Term_year::where('year_id', $year->id)->where('current_term', 1)->first();
        $classStatuses = $classes->getCollection()->mapWithKeys(function ($class) use ($term) {
            return [$class->id => $term ? \App\Services\GradebookStatusService::getStatus($class->id, $term->id) : 'LOCKED'];
        });
        return view('admin.gradebook.settings.index', compact('classes', 'year', 'term', 'classStatuses'));
    }

    /**
     * Show rooms for a class
     */
    public function viewRooms($classId)
    {
        $year = Year::where('current_year', '1')->first();
        if (!$year) {
            return redirect()->route('admin.gradebook.index')->with('error', __('gradebook.year_missing'));
        }
        $rooms = Room::where('class_id', $classId)
                     ->where('year_id', $year->id)
                     ->with('student')
                     ->paginate(10);
        return view('admin.gradebook.settings.rooms', compact('rooms'));
    }

    /**
     * Show subjects for a room (to configure)
     */
    /**
     * Show subjects for a room (to configure)
     */
    public function viewSubjects($roomId)
    {
        $year = Year::where('current_year', '1')->first();
        if (!$year) {
            return redirect()->route('admin.gradebook.index')->with('error', __('gradebook.year_missing'));
        }
        $room = Room::where('year_id', $year->id)->findOrFail($roomId);
        $subjects = Lesson::where('class_id', $room->class_id)->with(['teachers' => function ($query) use ($room, $year) {
            $query->where('teacher_room_lesson.room_id', $room->id)
                ->whereIn('teacher_room_lesson.id', \App\Teacher_room_lesson::currentTimetable()->select('teacher_room_lesson.id'))
                ->where('teacher_room_lesson.class_id', $room->class_id)
                ->where('teacher_room_lesson.year_id', $year->id);
        }])->get();
        $configuredSubjects = $subjects->filter(function ($subject) use ($year) {
            return \Illuminate\Support\Facades\Storage::exists("gradebook/{$subject->id}_{$year->id}.json");
        })->pluck('id')->all();
        return view('admin.gradebook.settings.subjects', compact('room', 'subjects', 'configuredSubjects'));
    }

    /**
     * Show Edit Config Form
     */
    public function edit($subjectId)
    {
        $subject = Lesson::findOrFail($subjectId);
        $year = Year::where('current_year', '1')->first();
        if (!$year) {
            return redirect()->route('admin.gradebook.index')->with('error', __('gradebook.year_missing'));
        }
        
        // Load JSON Config
        $components = \App\Services\GradebookConfigService::getConfig($subjectId, $year->id);
        $configurationInfo = app(\App\Services\Gradebook\GradebookContextReader::class)
            ->resolveLegacy($subjectId, $year->id)->toArray()['configuration'];
        $usedSources = \App\Services\GradebookDistributionImpact::usedSources($subjectId, $year->id);

        return view('admin.gradebook.settings.edit_json', compact('subject', 'components', 'year', 'configurationInfo', 'usedSources'));
    }

    /**
     * Update Config
     */
    public function update(Request $request, $subjectId)
    {
        return \Illuminate\Support\Facades\DB::transaction(function () use ($request, $subjectId) {
        $subject = Lesson::whereKey($subjectId)->lockForUpdate()->firstOrFail();
        // Acquire the shared configuration lock before any snapshot reads.
        $year = Year::where('current_year', '1')->firstOrFail();
        if ($request->input('_components_present') === '1' && !$request->has('components')) $request->merge(['components'=>[]]);
        
        // Validation for Weights (Percentages)
        $request->validate([
            'components' => 'present|array|max:100',
            'components.*.name' => 'required|string|max:191',
            'components.*.weight' => 'required|integer|min:0|max:100',
            'components.*.id' => 'nullable|string|distinct',
            'components.*.data_source' => ['nullable', function ($attribute, $value, $fail) {
                if (!is_string($value) && !is_int($value) && !is_float($value)) $fail(__('gradebook.context_invalid'));
            }],
            '_allocation_subject_total' => 'sometimes|required|integer|min:1',
            '_configuration_revision' => ['sometimes','required','regex:/^(missing|[a-f0-9]{64})$/D'],
            '_configuration_year' => 'sometimes|required|integer',
        ]);
        $request->merge(['components'=>array_values($request->components)]);
        abort_if($request->has('_configuration_year') && (int) $request->_configuration_year !== (int) $year->id, 422, __('gradebook.context_invalid'));
        $configuration = app(\App\Services\Gradebook\GradebookContextReader::class)
            ->resolveLegacy($subjectId, $year->id)->toArray()['configuration'];
        if (!in_array($configuration['state'], ['valid','missing'], true)) {
            throw \Illuminate\Validation\ValidationException::withMessages(['components'=>__('gradebook_ux.invalid_config')]);
        }
        $revision = $configuration['sha256'] ?? 'missing';
        if ($request->has('_configuration_revision') && $request->_configuration_revision !== $revision) {
            throw \Illuminate\Validation\ValidationException::withMessages(['components'=>__('gradebook_editor.stale')]);
        }

        if ($request->has('_allocation_subject_total')
            && (string)$request->_allocation_subject_total !== (string)$subject->max_mark) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                '_allocation_subject_total'=>__('gradebook_distribution.maximum_changed'),
            ]);
        }

        $previousRows = \App\Services\GradebookConfigService::getConfig($subjectId, $year->id);
        $previous = $previousRows->keyBy('id');
        if ($previous->count() !== $previousRows->count()) \App\Services\AssessmentResultSafety::reject('ambiguous_result', 'components');
        $submitted = collect($request->components)->keyBy('id');
        $reserved = \App\Exams2::where('lesson_id', $subjectId)
            ->whereIn('term_id', \App\Term_year::where('year_id', $year->id)->select('id'))
            ->where('name', 'like', 'Dynamic_Section_%')->get();
        $usedSources = \App\Services\GradebookDistributionImpact::usedSources($subjectId, $year->id);
        foreach ($previous as $id => $old) {
            $new = $submitted->get($id);
            $used = isset($usedSources[(string) $old->data_source]);
            if ($used && (!$new || !property_exists($old, 'weight') || (float) $new['weight'] !== (float) $old->weight)) {
                \App\Services\AssessmentResultSafety::reject('retained_results', 'components');
            }
        }
        foreach ($request->components as $row) {
            $old = $previous->get($row['id'] ?? '');
            if ($old && (string) ($row['data_source'] ?? '') !== (string) $old->data_source) {
                \App\Services\AssessmentResultSafety::reject('context_invalid', 'components');
            }
            if (!$old && !empty($row['data_source']) && $row['data_source'] !== 'LEGACY_HOMEWORK') {
                \App\Services\AssessmentResultSafety::reject('context_invalid', 'components');
            }
        }
        $components = [];
        $usedIds = $reserved->map(function ($exam) {
            return (int) substr($exam->name, strlen('Dynamic_Section_'));
        })->all();
        foreach ($previous as $old) if (is_numeric($old->data_source)) $usedIds[] = (int) $old->data_source;

        // 1. Collect Valid Integer IDs already in use (to prevent overwriting existing mappings)
        foreach($request->components as $comp) {
            if (isset($comp['data_source']) && is_numeric($comp['data_source'])) {
                $usedIds[] = (int)$comp['data_source'];
            }
        }

        $nextId = 100; // Start of Dynamic Range

        foreach($request->components as $idx => $comp) {
            // Ensure ID is set
            $id = isset($comp['id']) && (string) $comp['id'] !== '' ? $comp['id'] : uniqid('comp_');
            $source = $comp['data_source'] ?? null;
            $finalSource = $source;

            $old = $previous->get($id);
            if ($old) {
                // Preserve even nonstandard historical ID/source pairs; labels are not identities.
                $finalSource = $old->data_source;
            } else {
                if (in_array($id, ['legacy_oral','legacy_homework','legacy_exam'], true)) {
                    \App\Services\AssessmentResultSafety::reject('context_invalid', 'components');
                }
                // --- DYNAMIC LOGIC FOR NEW SECTIONS ---
                // Only generic/empty sources get a new Dynamic ID.
                $needsId = ($source === 'LEGACY_HOMEWORK' || empty($source));

                if ($needsId) {
                    // Find next available ID
                    while(in_array($nextId, $usedIds)) {
                        $nextId++;
                    }
                    $finalSource = $nextId;
                    $usedIds[] = $nextId; // Mark as used
                }
            }

            $component = [
                'id' => $id,
                'name' => $comp['name'],
                'weight' => $comp['weight'],
                'data_source' => $finalSource,
                'sort_order' => $idx + 1
            ];
            // This editor does not edit explicit maxima. Preserve the stored bound.
            $old = $previous->get($id);
            if ($old && property_exists($old, 'max_mark')) {
                $component['max_mark'] = $old->max_mark;
            }
            $components[] = $component;
        }

        abort_unless(\App\Services\GradebookConfigService::saveConfig($subjectId, $year->id, $components),
            500, __('gradebook.write_failed'));

        return redirect()->back()->with('success', 'تم حفظ إعدادات توزيع العلامات بنجاح');
        });
    }
}
