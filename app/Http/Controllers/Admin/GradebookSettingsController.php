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
            return redirect()->back()->with('error', 'لا يوجد سنة دراسية حالية مفعلة');
        }
        $classes = Classe::with('room')->paginate(10);
        return view('admin.gradebook.settings.index', compact('classes', 'year'));
    }

    /**
     * Show rooms for a class
     */
    public function viewRooms($classId)
    {
        $year = Year::where('current_year', '1')->first();
        if (!$year) {
            return redirect()->back()->with('error', 'لا يوجد سنة دراسية حالية مفعلة');
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
        $room = Room::findOrFail($roomId);
        $subjects = Lesson::where('class_id', $room->class_id)->with('teacher')->get();
        $year = Year::where('current_year', '1')->first();
        
        // Pass JSON configs or status
        // For the overview list, we just want to know if it's "Default" vs "Custom"
        // But for simplicity, we can just show "Manage" button.
        
        return view('admin.gradebook.settings.subjects', compact('room', 'subjects'));
    }

    /**
     * Show Edit Config Form
     */
    public function edit($subjectId)
    {
        $subject = Lesson::findOrFail($subjectId);
        $year = Year::where('current_year', '1')->first();
        
        // Load JSON Config
        $components = \App\Services\GradebookConfigService::getConfig($subjectId, $year->id);

        return view('admin.gradebook.settings.edit_json', compact('subject', 'components'));
    }

    /**
     * Update Config
     */
    public function update(Request $request, $subjectId)
    {
        $year = Year::where('current_year', '1')->first();
        
        // Validation for Weights (Percentages)
        $request->validate([
            'components' => 'required|array',
            'components.*.name' => 'required|string',
            'components.*.weight' => 'required|integer|min:0|max:100',
        ]);

        $components = [];
        $usedIds = [];

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

            $components[] = [
                'id' => $id,
                'name' => $comp['name'],
                'weight' => $comp['weight'],
                'data_source' => $finalSource,
                'sort_order' => $idx + 1
            ];
        }

        \App\Services\GradebookConfigService::saveConfig($subjectId, $year->id, $components);

        return redirect()->back()->with('success', 'تم حفظ إعدادات توزيع العلامات بنجاح');
    }
}
