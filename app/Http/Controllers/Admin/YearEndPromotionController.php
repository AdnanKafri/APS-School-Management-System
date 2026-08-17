<?php

namespace App\Http\Controllers\Admin;

use App\Classe;
use App\Http\Controllers\Controller;
use App\Room;
use App\Room_student;
use App\Student;
use App\StudentAcademicPlacement;
use App\Services\YearEndPromotionService;
use App\Year;
use Illuminate\Http\Request;

class YearEndPromotionController extends Controller
{
    public function index()
    {
        $sourceYear = Year::where('current_year', '1')->first();
        $configuredTargetYear = $sourceYear && $sourceYear->next_year ? Year::find($sourceYear->next_year) : null;
        $targetYear = $this->validTargetYear($sourceYear, $configuredTargetYear) ? $configuredTargetYear : null;
        $yearConfigurationError = !$sourceYear || !$configuredTargetYear
            ? __('year_end.validation.year_missing')
            : (!$targetYear ? __('year_end.validation.year_invalid') : null);
        $classes = Classe::orderBy('id')->get();
        $rooms = $targetYear ? Room::where('year_id', $targetYear->id)->orderBy('class_id')->orderBy('id')->get(['id', 'name', 'class_id']) : collect();
        $roomCatalog = $rooms->map(function ($room) {
            return ['id' => $room->id, 'name' => $room->name, 'class_id' => $room->class_id];
        })->values();
        $enrollments = $sourceYear ? Room_student::where('year_id', $sourceYear->id)->with(['student'])->get(['id', 'student_id', 'room_id', 'year_id']) : collect();
        $sourceRooms = $sourceYear ? Room::where('year_id', $sourceYear->id)->with('classes')->get(['id', 'name', 'class_id', 'year_id'])->keyBy('id') : collect();
        $currentSectionCatalog = $sourceRooms->values()->map(function ($room) {
            return ['id' => $room->id, 'name' => $room->name, 'class_id' => $room->class_id];
        })->values();
        foreach ($enrollments as $enrollment) {
            $enrollment->sourceRoom = $sourceRooms->get($enrollment->room_id);
        }
        $targetRoomLookup = $rooms->keyBy(function ($room) {
            return $room->class_id . ':' . $room->name;
        });
        $rolloverPreview = $enrollments->filter(function ($enrollment) {
            return $enrollment->student && $enrollment->sourceRoom;
        })->map(function ($enrollment) use ($targetRoomLookup) {
            $key = $enrollment->sourceRoom->class_id . ':' . $enrollment->sourceRoom->name;
            $enrollment->targetRoom = $targetRoomLookup->get($key);
            return $enrollment;
        })->values();
        $preparedPlacements = $targetYear
            ? StudentAcademicPlacement::where('year_id', $targetYear->id)->where('status', 'active')->with(['room', 'classRoom'])->get()->keyBy('student_id')
            : collect();
        return view('admin.year_end_promotion', compact('sourceYear', 'configuredTargetYear', 'targetYear', 'yearConfigurationError', 'classes', 'rooms', 'roomCatalog', 'currentSectionCatalog', 'enrollments', 'preparedPlacements', 'rolloverPreview'));
    }

    public function cloneRooms(Request $request, YearEndPromotionService $service)
    {
        $source = Year::where('current_year', '1')->first();
        $target = $source && $source->next_year ? Year::find($source->next_year) : null;
        if (!$this->validTargetYear($source, $target)) {
            return back()->with('error', $source && $target ? __('year_end.validation.year_invalid') : __('year_end.validation.year_missing'));
        }
        try {
            $result = $service->prepareAcademicYear($source, $target);
        } catch (\Throwable $e) {
            report($e);
            $key = $e->getMessage();
            return back()->with('error', __($key) === $key ? __('year_end.errors.failed') : __($key));
        }

        $failureDetails = array_map(function ($failure) {
            $key = $failure['reason'];
            $translated = __($key);
            $failure['reason'] = $translated === $key ? __('year_end.errors.failed') : $translated;
            return $failure;
        }, $result['failures']);
        $message = __('year_end.messages.rollover_result', [
            'created' => $result['sections_created'],
            'existing' => $result['sections_existing'],
            'carried' => $result['students_carried'],
            'skipped' => $result['students_skipped'],
            'year' => $target->name,
        ]);
        return back()->with($failureDetails ? 'warning' : 'success', $message)->with('year_end_failures', $failureDetails);
    }

    public function process(Request $request, YearEndPromotionService $service)
    {
        $request->validate(['student_id' => 'required|integer', 'class_id' => 'required|integer', 'room_id' => 'required|integer'], ['required' => __('year_end.validation.required'), 'integer' => __('year_end.validation.integer')]);
        $source = Year::where('current_year', '1')->first();
        $target = $source && $source->next_year ? Year::find($source->next_year) : null;
        $student = Student::find($request->student_id);
        if (!$this->validTargetYear($source, $target)) return back()->with('error', $source && $target ? __('year_end.validation.year_invalid') : __('year_end.validation.year_missing'));
        if (!$student) return back()->with('error', __('student_transfer.validation.transfer_student_missing'));
        try {
            $service->process($student, $source, $target, (int) $request->class_id, (int) $request->room_id);
        } catch (\Throwable $e) {
            report($e);
            return back()->with('error', __($e->getMessage()) === $e->getMessage() ? __('year_end.errors.failed') : __($e->getMessage()));
        }
        return back()->with('success', __('year_end.messages.prepared', ['year' => $target->name]));
    }

    public function processBulk(Request $request, YearEndPromotionService $service)
    {
        $request->validate(['items' => 'required|string']);
        $items = json_decode($request->items, true);
        if (!is_array($items) || !$items) {
            return back()->with('error', __('year_end.validation.selected_student'));
        }

        $source = Year::where('current_year', '1')->first();
        $target = $source && $source->next_year ? Year::find($source->next_year) : null;
        if (!$this->validTargetYear($source, $target)) return back()->with('error', $source && $target ? __('year_end.validation.year_invalid') : __('year_end.validation.year_missing'));
        $successes = 0;
        $failures = 0;
        $failureDetails = [];
        foreach ($items as $item) {
            $student = Student::find((int) ($item['student_id'] ?? 0));
            try {
                if (!$student) throw new \RuntimeException('year_end.validation.selected_student');
                $service->process($student, $source, $target, (int) ($item['class_id'] ?? 0), (int) ($item['room_id'] ?? 0));
                $successes++;
            } catch (\Throwable $e) {
                report($e);
                $failures++;
                $key = $e->getMessage();
                $translated = __($key);
                $failureDetails[] = [
                    'student_id' => $student ? $student->id : ($item['student_id'] ?? null),
                    'student_name' => $student ? trim($student->first_name . ' ' . $student->last_name) : __('year_end.validation.selected_student'),
                    'reason' => $translated === $key ? __('year_end.errors.failed') : $translated,
                ];
            }
        }
        $message = __('year_end.messages.bulk_result', ['success' => $successes, 'failed' => $failures, 'year' => $target->name]);
        if ($failures) $message .= ' ' . __('year_end.messages.bulk_failure_hint');
        return back()->with($failures ? 'warning' : 'success', $message)->with('year_end_failures', $failureDetails);
    }

    private function validTargetYear($source, $target): bool
    {
        return $source && $target && (int) $source->id !== (int) $target->id;
    }
}
