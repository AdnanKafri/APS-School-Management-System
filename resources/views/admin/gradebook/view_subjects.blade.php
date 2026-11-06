@extends('admin.gradebook.layout')
@section('page_title', __('gradebook_ui.choose_subject'))
@section('page_subtitle', __('gradebook_ui.by_subject'))

@section('js')
@include('admin.gradebook.partials.status_script')
@endsection

@section('breadcrumbs')
    @include('admin.gradebook.partials.breadcrumbs', ['items'=>[['label'=>__('gradebook_ui.review'), 'url'=>route('admin.gradebook.view_options')], ['label'=>__('gradebook_ui.classes'), 'url'=>route('admin.gradebook.view_classes_subject')], ['label'=>__('gradebook_ui.sections'), 'url'=>route('admin.gradebook.view_rooms', $room->class_id)], ['label'=>$room->name]]])
@endsection

@section('gradebook-content')
<div class="card" >
    
    <div class="card-header border-0 d-flex justify-content-between align-items-center">
        <h3 class="mb-0">
             علامات: {{ $room->name }}
             <span class="text-muted small mr-2" style="font-size: 14px;">( {{ $room->classes->name }} )</span>
        </h3>

        {{-- Status Toggle --}}
        <div class="gb-status">
             @php
                  // Determine current status
                  $year = \App\Year::where('current_year', '1')->first();
                  $term = $year && (int) $year->id === (int) $room->year_id
                      ? \App\Term_year::where('current_term', '1')->where('year_id', $year->id)->first() : null;
                  $status = $term ? \App\Services\GradebookStatusService::getStatus($room->class_id, $term->id) : 'LOCKED';
                  $isLocked = $status !== 'OPEN';
             @endphp
            
            @if($term)
            <button type="button" id="statusToggle" class="btn gb-entry-switch" role="switch" aria-checked="{{ $isLocked ? 'false' : 'true' }}"
                       aria-label="{{ __('gradebook.status_confirm') }}" data-accepted="{{ $status }}"
                       onclick="toggleGradebookStatus({{ $room->class_id }}, {{ $term->id }}, this)">
                <i class="fas fa-power-off" aria-hidden="true"></i><span data-status-label>{{ __('gradebook_ux.'.($isLocked ? 'locked' : 'open')) }}</span>
            </button>
            @else
                <small>{{ __('gradebook.term_missing') }}</small>
            @endif
        </div>
    </div>
    <div class="px-3" id="gradebook-status-feedback" role="status" aria-live="polite"></div>

    <div class="table-responsive" tabindex="0" role="region" aria-label="{{ __('gradebook_ui.subjects') }}">
        <table class="table align-items-center table-flush">
            <thead class="thead-light">
                <tr>
                    <th scope="col">{{ __('gradebook_ui.subject') }}</th>
                    <th scope="col">{{ __('gradebook_ui.class') }}</th>
                    <th scope="col">{{ __('gradebook_ui.actions') }}</th>
                </tr>
            </thead>
            <tbody class="list">
                @forelse ($subjects as $item)
                <tr>
                    <td class="budget font-weight-bold">
                        {{$item->name}}
                    </td>
                    <td class="budget">
                        {{$room->classes->name}}
                    </td>
                    <td>
                        <a class="btn btn-outline-primary" href="{{ route('admin.gradebook.view_grid_simple', ['room_id' => $room->id, 'subject_id' => $item->id])}}">
                           {{ __('gradebook_ui.open') }}
                        </a>
                    </td>
                </tr>
                @empty
                    <tr><td colspan="3">{{ __('gradebook_ui.empty') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
