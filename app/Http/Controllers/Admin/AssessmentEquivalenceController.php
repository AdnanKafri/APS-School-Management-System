<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Lesson;
use App\Year;
use App\Services\AssessmentEquivalenceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AssessmentEquivalenceController extends Controller
{
    public function index(Request $request)
    {
        $available = Schema::hasTable('assessment_equivalence_members');
        $years = Year::orderByDesc('id')->get();
        $subjects = Lesson::with('classes')->orderBy('name')->get();
        $assessments = collect();
        if ($available && $request->filled('year_id') && $request->filled('lesson_id')) {
            $request->validate(['year_id' => 'integer|exists:years,id', 'lesson_id' => 'integer|exists:lessons,id']);
            $assessments = DB::table('exams2 as e')->join('rooms as r', 'r.id', '=', 'e.room_id')
                ->join('term_years as t', 't.id', '=', 'e.term_id')
                ->where('r.year_id', $request->year_id)->where('t.year_id', $request->year_id)
                ->where('e.lesson_id', $request->lesson_id)->whereIn('e.type', [1, 2])
                ->where('e.name', 'not like', 'Dynamic_Section_%')
                ->whereNotIn('e.id', DB::table('assessment_equivalence_members')->select('exam_id'))
                ->orderBy('e.term_id')->orderBy('e.id')
                ->get(['e.id', 'e.name', 'e.type', 'e.mark', 'r.name as room_name', 't.term']);
        }
        return view('admin.gradebook.equivalence', compact('available', 'years', 'subjects', 'assessments'));
    }

    public function store(Request $request)
    {
        abort_unless(Schema::hasTable('assessment_equivalence_members'), 503, __('gradebook.equivalence_unavailable'));
        $data = $request->validate([
            'exam_ids' => 'required|array|min:2|max:50', 'exam_ids.*' => 'required|integer|distinct|exists:exams2,id',
            'evidence' => 'required|string|max:2000', 'confirmed' => 'accepted',
        ]);
        app(AssessmentEquivalenceService::class)->verify($data['exam_ids'], $data['evidence']);
        return redirect()->route('admin.gradebook.equivalence')->with('success', __('gradebook.equivalence_saved'));
    }
}
