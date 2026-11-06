<div class="gbt-component">
    <input type="hidden" data-field="id" name="components[{{ $index }}][id]" value="{{ $component['id'] }}">
    <div class="form-row">
        <div class="form-group col-md-5"><label>{{ __('gradebook_templates.component') }}<input data-field="name_ar" class="form-control" name="components[{{ $index }}][name_ar]" value="{{ $component['name_ar'] }}" maxlength="200" required></label></div>
        <div class="form-group col-md-4"><label>{{ __('gradebook_templates.name_en') }}<input data-field="name_en" class="form-control" name="components[{{ $index }}][name_en]" value="{{ $component['name_en'] }}" maxlength="200"></label></div>
        <div class="form-group col-md-3"><label>{{ __('gradebook_templates.maximum') }}<input data-field="maximum" class="form-control" type="number" inputmode="numeric" min="1" max="2147483647" step="1" name="components[{{ $index }}][maximum]" value="{{ $component['maximum'] }}" required></label></div>
    </div>
    <div class="gbt-actions"><button class="btn btn-sm btn-outline-secondary" type="button" data-move="up">{{ __('gradebook_templates.up') }}</button><button class="btn btn-sm btn-outline-secondary" type="button" data-move="down">{{ __('gradebook_templates.down') }}</button><button class="btn btn-sm btn-outline-danger" type="button" data-remove>{{ __('gradebook_templates.remove') }}</button></div>
</div>
