@php
    $manual = \App\Services\GradebookComponentEntry::manual($comp) || empty($comp->data_source);
    $used = isset($usedSources[(string)($comp->data_source ?? '')]);
@endphp
<tr class="component-row" data-used="{{ $used ? '1' : '0' }}" data-explicit="{{ property_exists($comp, 'max_mark') ? '1' : '0' }}">
    <td class="align-middle">
        <input type="hidden" name="components[{{ $index }}][id]" value="{{ $comp->id ?? '' }}">
        <input type="hidden" name="components[{{ $index }}][data_source]" value="{{ $comp->data_source ?? '' }}">
        <span class="index-cell">{{ is_numeric($index) ? $index + 1 : '' }}</span>
    </td>
    <td>
        <input type="text" name="components[{{ $index }}][name]" class="form-control component-name" value="{{ $comp->name ?? '' }}" maxlength="191" required aria-label="{{ __('gradebook_editor.name') }}">
        <small class="d-block mt-1 {{ $manual ? 'text-primary' : 'text-muted' }}">{{ __('gradebook_ux.'.($manual ? 'manual' : 'summary')) }}</small>
        @if($used)<small class="d-block text-muted">{{ __('gradebook_editor.used') }}</small>@endif
    </td>
    <td>
        <div class="input-group allocation-percent-group">
            <input type="number" name="components[{{ $index }}][weight]" class="form-control text-center weight-input" value="{{ $comp->weight ?? 0 }}" min="0" max="100" step="1" required aria-label="{{ __('gradebook_distribution.percentage') }}">
            <div class="input-group-append"><span class="input-group-text">%</span></div>
        </div>
        <div class="allocation-mark-group" hidden><input type="number" class="form-control allocation-mark-input" inputmode="numeric" min="0" step="1" disabled aria-label="{{ __('gradebook_distribution.maximum') }}"></div>
        @if(property_exists($comp, 'max_mark'))<small>{{ __('gradebook_ux.explicit_maximum') }}: {{ $comp->max_mark }}</small>@endif
    </td>
    <td>
        <div class="gb-component-actions">
            <button type="button" class="btn btn-outline-primary component-edit">{{ __('gradebook_editor.edit') }}</button>
            <button type="button" class="btn btn-light component-up" aria-label="{{ __('gradebook_editor.up') }}">&#8593;</button>
            <button type="button" class="btn btn-light component-down" aria-label="{{ __('gradebook_editor.down') }}">&#8595;</button>
            <button type="button" class="btn btn-outline-danger delete-row" @if($used) disabled @endif>{{ __('gradebook_editor.remove') }}</button>
        </div>
    </td>
</tr>
