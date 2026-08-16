<?php

namespace App\Http\Controllers\Admin;

use App\Classe;
use App\Http\Controllers\Controller;
use App\Room;
use App\Room_student;
use App\Student;
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
        $enrollments = $sourceYear ? Room_student::where('year_id', $sourceYear->id)->with(['student'])->get(['id', 'student_id', 'room_id', 'year_id']) : collect();
        $sourceRooms = $sourceYear ? Room::where('year_id', $sourceYear->id)->with('classes')->get(['id', 'name', 'class_id', 'year_id'])->keyBy('id') : collect();
        foreach ($enrollments as $enrollment) {
            $enrollment->sourceRoom = $sourceRooms->get($enrollment->room_id);
        }
        return view('admin.year_end_promotion', compact('sourceYear', 'configuredTargetYear', 'targetYear', 'yearConfigurationError', 'classes', 'rooms', 'enrollments'));
    }

    public function cloneRooms(Request $request, YearEndPromotionService $service)
    {
        $source = Year::where('current_year', '1')->first();
        $target = $source && $source->next_year ? Year::find($source->next_year) : null;
        if (!$this->validTargetYear($source, $target)) {
            return back()->with('error', $source && $target ? __('year_end.validation.year_invalid') : __('year_end.validation.year_missing'));
        }
        $created = $service->cloneRooms($source, $target);
        return back()->with('success', __('year_end.messages.rooms_cloned', ['count' => $created]));
    }

    public function process(Request $request, YearEndPromotionService $service)
    {
        $request->validate(['student_id' => 'required|integer', 'outcome' => 'required|in:promote,repeat,manual', 'class_id' => 'required|integer', 'room_id' => 'required|integer'], ['required' => __('year_end.validation.required'), 'integer' => __('year_end.validation.integer'), 'in' => __('year_end.validation.in')]);
        $source = Year::where('current_year', '1')->first();
        $target = $source && $source->next_year ? Year::find($source->next_year) : null;
        $student = Student::find($request->student_id);
        if (!$this->validTargetYear($source, $target)) return back()->with('error', $source && $target ? __('year_end.validation.year_invalid') : __('year_end.validation.year_missing'));
        if (!$student) return back()->with('error', __('student_transfer.validation.transfer_student_missing'));
        try {
            $service->process($student, $source, $target, $request->outcome, (int) $request->class_id, (int) $request->room_id);
        } catch (\Throwable $e) {
            report($e);
            return back()->with('error', __($e->getMessage()) === $e->getMessage() ? __('year_end.errors.failed') : __($e->getMessage()));
        }
        return back()->with('success', __('year_end.messages.prepared'));
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
        foreach ($items as $item) {
            try {
                $student = Student::find((int) ($item['student_id'] ?? 0));
                if (!$student) throw new \RuntimeException('year_end.validation.selected_student');
                $service->process($student, $source, $target, (string) ($item['outcome'] ?? ''), (int) ($item['class_id'] ?? 0), (int) ($item['room_id'] ?? 0));
                $successes++;
            } catch (\Throwable $e) {
                report($e);
                $failures++;
            }
        }
        return back()->with($failures ? 'warning' : 'success', __('year_end.messages.bulk_result', ['success' => $successes, 'failed' => $failures]));
    }

    private function validTargetYear($source, $target): bool
    {
        return $source && $target && (int) $source->id !== (int) $target->id;
    }
}
