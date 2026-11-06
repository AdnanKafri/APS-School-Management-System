<?php

namespace App\Http\Controllers\Admin;

use App\GradebookTemplate;
use App\GradebookTemplateVersion;
use App\Classe;
use App\Http\Controllers\Controller;
use App\Lesson;
use App\Year;
use App\Services\Gradebook\GradebookTemplateService;
use Illuminate\Http\Request;

class GradebookTemplateController extends Controller
{
    public function index(Request $request, GradebookTemplateService $service)
    {
        $available = $service->available();
        $request->validate(['year_id'=>'nullable|integer|exists:years,id', 'class_id'=>'nullable|integer|exists:classes,id',
            'lesson_id'=>'nullable|integer|exists:lessons,id', 'source_version_id'=>'nullable|integer']);
        $years = Year::orderByDesc('id')->get();
        $active = $years->where('current_year', 1);
        $currentYear = $active->count() === 1 ? $active->first() : null;
        $year = $request->filled('year_id') ? $years->firstWhere('id', $request->year_id) : $currentYear;
        $grade = $request->filled('class_id') ? Classe::findOrFail($request->class_id) : null;
        $subject = $request->filled('lesson_id') ? Lesson::findOrFail($request->lesson_id) : null;
        if ($subject && (!$grade || (int)$subject->class_id !== (int)$grade->id)) {
            throw \Illuminate\Validation\ValidationException::withMessages(['lesson_id'=>__('gradebook_templates.scope')]);
        }
        $source = null;
        if ($request->filled('source_version_id')) {
            $service->authorize();
            $source = GradebookTemplateVersion::with('template')->findOrFail($request->source_version_id);
        }
        $context = array_filter(['year_id'=>$year ? $year->id : null, 'class_id'=>$grade ? $grade->id : null,
            'source_version_id'=>$source ? $source->id : null]);
        $existing = $available && $year && $subject ? GradebookTemplate::where('year_id',$year->id)->where('lesson_id',$subject->id)->first() : null;
        if ($existing) return redirect()->route('admin.gradebook.templates.show',$existing->id)->with('success',__('gradebook_templates.opened_existing'));
        $classes = $year && !$grade ? Classe::withCount('lessons')->orderBy('id')->paginate(15)->appends($context) : null;
        // Same class/subject relationship as GradebookSettingsController::viewSubjects; lessons have no year column.
        $subjects = $year && $grade && !$subject ? Lesson::where('class_id',$grade->id)->orderBy('name')->paginate(20)->appends($context) : null;
        $templates = $available && $subjects ? GradebookTemplate::where('year_id',$year->id)
            ->whereIn('lesson_id',$subjects->pluck('id'))->get()->keyBy('lesson_id') : collect();
        return view('admin.gradebook.templates.index', compact('available','years','currentYear','year','grade','subject','source','context','classes','subjects','templates'));
    }

    public function store(Request $request, GradebookTemplateService $service)
    {
        $service->authorize();
        $this->validateDestination($request);
        $existing = GradebookTemplate::where('year_id',$request->year_id)->where('lesson_id',$request->lesson_id)->first();
        if ($existing) return redirect()->route('admin.gradebook.templates.show',$existing->id)->with('success',__('gradebook_templates.opened_existing'));
        $template = $service->create($request->input('year_id'), $request->input('lesson_id'), $request->input('name_ar'));
        return $this->backTo($template->id);
    }

    public function show($template, GradebookTemplateService $service)
    {
        $service->authorize();
        $template = GradebookTemplate::with(['year', 'lesson', 'grade'])->findOrFail($template);
        $versions = $template->versions()->orderByDesc('number')->get();
        $events = $template->events()->orderByDesc('id')->paginate(20);
        return view('admin.gradebook.templates.show', array_merge(compact('template','versions','events'),$this->navigation($template)));
    }

    public function save(Request $request, $template, GradebookTemplateService $service)
    {
        $service->save($template, $request->input('revision'), $request->only([
            'name_ar', 'name_en', 'components', 'year_id', 'lesson_id', 'class_id',
        ]));
        return $this->backTo($template);
    }

    public function discard(Request $request, $template, GradebookTemplateService $service)
    {
        $service->discard($template, $request->input('revision'), $request->input('reason'));
        return $this->backTo($template);
    }

    public function start(Request $request, $template, GradebookTemplateService $service)
    {
        $service->startDraft($template, $request->input('revision'), $request->filled('version_id') ? $request->input('version_id') : null);
        return $this->backTo($template);
    }

    public function preview($template, GradebookTemplateService $service)
    {
        $review = $service->preview($template);
        $template = GradebookTemplate::with(['year', 'lesson', 'grade'])->findOrFail($template);
        return view('admin.gradebook.templates.preview', array_merge(compact('template','review'),$this->navigation($template)));
    }

    public function publish(Request $request, $template, GradebookTemplateService $service)
    {
        $version = $service->publish($template, $request->input('revision'), $request->input('preview_token'), $request->input('confirmed'));
        return redirect()->route('admin.gradebook.templates.version', [$template, $version->id])
            ->with('success', __('gradebook_templates.published'));
    }

    public function version($template, $version, GradebookTemplateService $service)
    {
        $service->authorize();
        $template = GradebookTemplate::with(['year', 'lesson', 'grade'])->findOrFail($template);
        $version = $template->versions()->whereKey($version)->firstOrFail();
        return view('admin.gradebook.templates.version', array_merge(compact('template','version'),$this->navigation($template)));
    }

    public function duplicate(Request $request, $template, $version, GradebookTemplateService $service)
    {
        $service->authorize();
        GradebookTemplateVersion::where('template_id', $template)->whereKey($version)->firstOrFail();
        $this->validateDestination($request);
        $copy = $service->duplicate($version, $request->input('year_id'), $request->input('lesson_id'), $request->input('name_ar'));
        return $this->backTo($copy->id);
    }

    private function backTo($id)
    {
        return redirect()->route('admin.gradebook.templates.show', $id)->with('success', __('gradebook_templates.saved'));
    }

    private function validateDestination(Request $request)
    {
        $request->validate(['year_id'=>'required|integer|exists:years,id','lesson_id'=>'required|integer|exists:lessons,id',
            'class_id'=>'sometimes|required|integer|exists:classes,id']);
        if ($request->has('class_id') && !Lesson::whereKey($request->lesson_id)->where('class_id',$request->class_id)->exists()) {
            throw \Illuminate\Validation\ValidationException::withMessages(['lesson_id'=>__('gradebook_templates.scope')]);
        }
    }

    private function navigation(GradebookTemplate $template)
    {
        $active = Year::where('current_year',1)->get();
        return ['year'=>$template->year,'grade'=>$template->grade,'subject'=>$template->lesson,
            'currentYear'=>$active->count()===1 ? $active->first() : null, 'source'=>null];
    }
}
