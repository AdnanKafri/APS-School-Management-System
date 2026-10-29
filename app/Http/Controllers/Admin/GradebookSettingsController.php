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
        return view('admin.gradebook.settings.index', compact('classes', 'year'));
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

        return view('admin.gradebook.settings.edit_json', compact('subject', 'components'));
    }

    /**
     * Update Config
     */
    public function update(Request $request, $subjectId)
    {
        $year = Year::where('current_year', '1')->firstOrFail();
        $subject = Lesson::findOrFail($subjectId);
        
        // Validation for Weights (Percentages)
        $request->validate([
            'components' => 'required|array',
            'components.*.name' => 'required|string|max:191',
            'components.*.weight' => 'required|integer|min:0|max:100',
            'components.*.id' => 'nullable|string|distinct',
            'components.*.data_source' => 'nullable',
        ]);

        $previous = \App\Services\GradebookConfigService::getConfig($subjectId, $year->id)->keyBy('id');
        $submitted = collect($request->components)->keyBy('id');
        $reserved = \App\Exams2::where('lesson_id', $subjectId)
            ->whereIn('term_id', \App\Term_year::where('year_id', $year->id)->select('id'))
            ->where('name', 'like', 'Dynamic_Section_%')->get();
        foreach ($previous as $id => $old) {
            $new = $submitted->get($id);
            $containers = $reserved->where('name', 'Dynamic_Section_'.$old->data_source);
            $used = $containers->contains(function ($exam) { return \App\Services\AssessmentResultSafety::hasRecords($exam); });
            if ($used && (!$new || (float) $new['weight'] !== (float) $old->weight)) {
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

        // 1. Collect Valid Integer IDs already in use (to prevent overwriting existing mappings)
        foreach($request->components as $comp) {
            if (isset($comp['data_source']) && is_numeric($comp['data_source'])) {
                $usedIds[] = (int)$comp['data_source'];
            }
        }

        $nextId = 100; // Start of Dynamic Range

        foreach($request->components as $idx => $comp) {
            // Ensure ID is set
            $id = !empty($comp['id']) ? $comp['id'] : uniqid('comp_');
            $source = $comp['data_source'] ?? null;
            $finalSource = $source;

            // --- IMMUTABLE LEGACY CORE LOGIC ---
            // If the section is one of the original 3, FORCE its source to legacy.
            // This prevents "Homework" from accidentally becoming Type 100.
            if ($id === 'legacy_oral') {
                $finalSource = 'LEGACY_ORAL';
            } elseif ($id === 'legacy_homework') {
                $finalSource = 'LEGACY_HOMEWORK';
            } elseif ($id === 'legacy_exam') {
                $finalSource = 'LEGACY_EXAM';
            } else {
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
    }
}
