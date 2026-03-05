<!-- resources/views/partials/student_table.blade.php -->
     @foreach ($students as $item)
        <tr>
            <td class="budget" style="font-weight:bold;font-size:15px">{{ $item->first_name }}</td>
            <td class="budget" style="font-weight:bold;font-size:15px">{{ $item->last_name }}</td>
            <td class="budget" style="font-weight:bold;font-size:15px">{{ $item->details->phone }}</td>
            <td class="budget" style="font-weight:bold;font-size:15px">{{ $item->details->address }}</td>
            <td class="budget" style="font-weight:bold;font-size:15px">{{ $item->bus->bus_lines->name }}</td>
            <td class="budget" style="font-weight:bold;font-size:15px">{{ $item->bus->name }}</td>
            <td class="budget" style="font-weight:bold;font-size:15px">{{ $item->bus->bus_lines->annual_cost }}</td>
            <td class="budget" style="font-weight:bold;font-size:15px">{{ $item->bus->bus_lines->annual_cost }}</td>
            <td class="budget" style="font-weight:bold;font-size:15px">
                @if(count($item->room)>0)
                    {{ $item->room[0]->classes->name }}
                @endif
            </td>
            <td class="budget" style="font-weight:bold;font-size:15px">
                @if(count($item->room)>0)
                    {{ $item->room[0]->name }}
                @endif
            </td>
            <td class="text-right">
                <a href="{{ route('transport_invoices', $item->id) }}" class="delete2 btn btn-warning text-light" style="color: white !important; background: #4e90aa  !important; border-color: #008CC4 !important; margin-right: 10px">
                    الفواتير
                </a>
            </td>
        </tr>
    @endforeach
 