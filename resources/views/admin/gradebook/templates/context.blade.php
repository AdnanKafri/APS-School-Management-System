<dl class="row gbt-context mb-0">
    <div class="col-sm-4"><dt>{{ __('gradebook_templates.year') }}</dt><dd>{{ $year->name }} @if($currentYear && (int)$year->id === (int)$currentYear->id)<span class="badge badge-light">{{ __('gradebook_templates.current') }}</span>@endif</dd></div>
    @if($grade)<div class="col-sm-4"><dt>{{ __('gradebook_templates.class') }}</dt><dd>{{ $grade->name }}</dd></div>@endif
    @if($subject)<div class="col-sm-4"><dt>{{ __('gradebook_templates.subject_only') }}</dt><dd>{{ $subject->name }}</dd></div>@endif
</dl>
