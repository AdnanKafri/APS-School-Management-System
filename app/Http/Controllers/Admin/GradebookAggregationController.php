<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\GradebookAggregationService;

class GradebookAggregationController extends Controller
{
    protected $service;

    public function __construct(GradebookAggregationService $service)
    {
        $this->service = $service;
    }

    public function aggregateContext(Request $request)
    {
        $request->validate([
            'room_id' => 'required|integer',
            'lesson_id' => 'required|integer',
        ]);

        $roomId = $request->room_id;
        $lessonId = $request->lesson_id;

        // Fetch Current Year
        $year = \App\Year::where('current_year', '1')->first();
        if (!$year) {
            return redirect()->back()->with('error', 'السنة الحالية غير محددة');
        }

        $result = $this->service->aggregateRoomSubject($roomId, $lessonId, $year->id);

        if ($result['status'] === 'success') {
            return redirect()->back()->with('success', 'تم تحديث دفتر العلامات بنجاح للمادة المختارة.');
        } else {
            return redirect()->back()->with('error', 'حدث خطأ أثناء التحديث: ' . $result['message']);
        }
    }
}
