<tr data-continuity-row="{{ $item->user_id }}">
    <td>{{ $item->student->id }}</td>
    <td>{{ $item->student->first_name }} {{ $item->student->last_name }}</td>
    @if($continuityFile) <td>-</td> @endif
    <td>{{ $item->continuity['value'] ?? '-' }}
        @include('gradebook.continuity_badge', ['resolved' => $item->continuity])
    </td>
    @if($continuityFile) <td>-</td> @endif
    <td>{{ ($item->continuity['state'] ?? null) === 'carried' ? __('gradebook.carried_read_only') : __('assessment_entry.conflict_read_only') }}</td>
</tr>
