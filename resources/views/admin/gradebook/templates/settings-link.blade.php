@if($year && $currentYear && (int)$year->id === (int)$currentYear->id)
    <a class="btn btn-outline-secondary btn-sm" href="{{ $subject && $grade && (int)$subject->class_id === (int)$grade->id ? route('admin.gradebook.settings.edit', $subject->id) : ($grade ? route('admin.gradebook.settings.rooms', $grade->id) : route('admin.gradebook.settings')) }}">{{ __('gradebook_templates.back_settings') }}</a>
@else
    <a class="btn btn-outline-secondary btn-sm" href="{{ route('admin.gradebook.settings') }}">{{ __('gradebook_templates.active_settings') }}</a>
@endif
