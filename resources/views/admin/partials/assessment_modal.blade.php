@php
    $modalId = $assessmentEdit ? 'assessment-edit' : 'assessment-create';
    $restore = old('_assessment_modal') === $modalId;
    $values = $restore ? session()->getOldInput() : [];
    $fieldId = function ($name) use ($modalId) { return $modalId.'-'.$name; };
    $selectedRooms = array_map('strval', (array) ($values['room_id'] ?? [$room_id]));
    $allRoomsSelected = in_array('0', $selectedRooms, true);
@endphp
<div id="{{ $modalId }}" class="modal fade {{ $assessmentEdit ? 'updateContentModal' : 'createRoomModal' }} assessment-editor"
    tabindex="-1" role="dialog" aria-labelledby="{{ $modalId }}-title" aria-hidden="true" data-restore="{{ $restore ? '1' : '0' }}" dir="rtl">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="post" action="{{ route($assessmentKind.'.'.($assessmentEdit ? 'update' : 'store')) }}" data-assessment-form>
                @csrf
                <input type="hidden" name="_assessment_modal" value="{{ $modalId }}">
                <input type="hidden" name="class_id" value="{{ $class_id }}">
                <input type="hidden" name="my_room_id" value="{{ $room_id }}">
                <input type="hidden" name="question_picker" value="{{ $values['question_picker'] ?? 2 }}">
                @if($assessmentEdit)
                    <input type="hidden" name="room_id" value="{{ $room_id }}">
                    <input type="hidden" name="confirm_window_change" value="0">
                    <input type="hidden" name="{{ $assessmentKind === 'quize' ? 'quize_id' : 'exam_id' }}" value="{{ $values[$assessmentKind === 'quize' ? 'quize_id' : 'exam_id'] ?? '' }}">
                @endif
                <div class="modal-header">
                    <h4 id="{{ $modalId }}-title" class="modal-title">{{ __('assessment_entry.'.($assessmentEdit ? 'edit_' : 'create_').($assessmentKind === 'quize' ? 'quiz' : 'exam')) }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('assessment_entry.close') }}">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" data-assessment-errors data-validation="{{ json_encode($restore ? $errors->messages() : []) }}" role="alert" @if(!$restore || !$errors->any()) hidden @endif>
                        @if($restore) @foreach($errors->all() as $error)<p class="mb-1">{{ $error }}</p>@endforeach @endif
                    </div>
                    <p class="text-muted small">{{ __('assessment_entry.window_help') }}</p>
                    <div class="form-group">
                        <label for="{{ $fieldId('content_name') }}">{{ __('assessment_entry.name') }}</label>
                        <input id="{{ $fieldId('content_name') }}" name="content_name" class="form-control" value="{{ $values['content_name'] ?? '' }}" required>
                    </div>
                    <div class="form-group">
                        <label for="{{ $fieldId('lesson_id') }}">{{ __('assessment_entry.subject') }}</label>
                        <select id="{{ $fieldId('lesson_id') }}" name="lesson_id" class="form-control" required>
                            <option value="">{{ __('assessment_entry.choose') }}</option>
                            @foreach($lessons as $lesson)<option value="{{ $lesson->id }}" @if((string)($values['lesson_id'] ?? '') === (string)$lesson->id) selected @endif>{{ $lesson->name }}</option>@endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="{{ $fieldId('is_file') }}">{{ __('assessment_entry.mode') }}</label>
                        <select id="{{ $fieldId('is_file') }}" name="is_file" class="form-control" required>
                            <option value="">{{ __('assessment_entry.choose') }}</option>
                            @foreach([0=>'automated',1=>'traditional'] as $mode=>$label)<option value="{{ $mode }}" @if((string)($values['is_file'] ?? '') === (string)$mode) selected @endif>{{ __('assessment_entry.'.$label) }}</option>@endforeach
                        </select>
                    </div>
                    @unless($assessmentEdit)
                        <div class="form-group" data-section-choice data-all-count="{{ $assessmentAllowedAllRooms->count() }}"
                            data-count-label="{{ __('assessment_entry.sections_count', ['count'=>':count']) }}">
                            <p class="small mb-2">{{ __('assessment_entry.current_section') }}: <strong>{{ $room->name }}</strong></p>
                            <label class="assessment-all-sections" for="{{ $fieldId('all_sections') }}">
                                <input id="{{ $fieldId('all_sections') }}" type="checkbox" name="room_id[]" value="0" data-all-sections
                                    @if($allRoomsSelected) checked @endif @if($assessmentAllowedAllRooms->isEmpty()) disabled @endif>
                                <span>{{ __('assessment_entry.all_sections') }} ({{ $assessmentAllowedAllRooms->count() }})</span>
                            </label>
                            @if($assessmentAllowedAllRooms->isEmpty())<p class="small text-muted">{{ __('assessment_entry.no_allowed_sections') }}</p>@endif
                            <label for="{{ $fieldId('rooms') }}">{{ __('assessment_entry.sections') }}</label>
                            <select id="{{ $fieldId('rooms') }}" name="room_id[]" data-specific-sections class="form-control" multiple required size="3"
                                aria-describedby="{{ $fieldId('rooms-help') }}" @if($allRoomsSelected && $assessmentAllowedAllRooms->isNotEmpty()) disabled @endif>
                                @foreach($rooms as $section)<option value="{{ $section->id }}" @if(in_array((string)$section->id,$selectedRooms,true)) selected @endif>{{ $section->name }}{{ (int)$section->id === (int)$room_id ? ' - '.__('assessment_entry.current_section') : '' }}</option>@endforeach
                            </select>
                            <small id="{{ $fieldId('rooms-help') }}" class="text-muted d-block mt-2">{{ __('assessment_entry.sections_help') }}</small>
                            <p class="small mt-2 mb-0" data-section-summary role="status" aria-live="polite"></p>
                        </div>
                    @endunless
                    @foreach(['start_date'=>'start','end_date'=>'end'] as $name=>$label)
                        <div class="form-group">
                            <label for="{{ $fieldId($name) }}">{{ __('gradebook_occurrences.'.$label) }}</label>
                            <input id="{{ $fieldId($name) }}" type="datetime-local" step="1" name="{{ $name }}" class="form-control" dir="ltr" value="{{ isset($values[$name]) ? str_replace(' ','T',$values[$name]) : '' }}" required>
                        </div>
                    @endforeach
                    @foreach(['mark'=>'maximum','period'=>'duration'] as $name=>$label)
                        <div class="form-group">
                            <label for="{{ $fieldId($name) }}">{{ __('assessment_entry.'.$label) }}</label>
                            <input id="{{ $fieldId($name) }}" type="number" step="1" min="{{ $name === 'mark' ? 1 : 0 }}" max="2147483647" name="{{ $name }}" class="form-control" value="{{ $values[$name] ?? '' }}" required>
                        </div>
                    @endforeach
                    <div class="form-group">
                        <label for="{{ $fieldId('required_lectures') }}">{{ __('assessment_entry.required') }}</label>
                        <textarea id="{{ $fieldId('required_lectures') }}" name="required_lectures" class="form-control" rows="3" required>{{ $values['required_lectures'] ?? '' }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="{{ $fieldId('notes') }}">{{ __('assessment_entry.notes') }}</label>
                        <textarea id="{{ $fieldId('notes') }}" name="notes" class="form-control" maxlength="99" rows="2">{{ $values['notes'] ?? '' }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">{{ __('assessment_entry.cancel') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('assessment_entry.save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
