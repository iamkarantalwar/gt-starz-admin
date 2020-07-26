@if($drivers->count() > 0)
    @foreach ($drivers as $driver)
    <tr>
        <th scope="row">
            {{ $loop->iteration }}
        </th>
        <td class="budget">
            {{ $driver->name}}
        </td>
        <td class="budget">
            {{ $driver->username}}
        </td>
        <td class="budget">
            {{ $driver->email}}
        </td>
        <td class="budget">
            {{ $driver->phone_number}}
        </td>
        <td class="budget">
            {{ $driver->address}}
        </td>
        <td class="budget">
            @if($driver->rating)
                {{ $driver->rating}}
            @else
                <a href="javascript::void(0);" data-toggle="popover" title="Rating Not Available" data-content="No one given rating to this driver yet.">Not Available</a>
            @endif
        </td>
        <td>
            @if($driver->approved == "0")
                <b>Not Approved</b>
            @elseif($driver->approved == "1")
                <b>Approved</b>
            @elseif($driver->approved == null)
                <b>New driver</b>
            @endif
        </td>
        <td class="actions">
            @if($driver->approved == "0" || $driver->approved == null)
            <a href="{{ route('drivers.changestatus', ['status' => 1, 'driver' =>  $driver]) }}"
                class="confirm-approval-change" title="Approve driver">
                <i class="ni ni-check-bold" ></i>
            </a>
            @endif
            @if($driver->approved == "1" || is_null($driver->approved))
            <a href="{{ route('drivers.changestatus', ['status' => 0, 'driver' =>  $driver]) }}"
                class="confirm-approval-change" title="Disapprove driver">
                <i class="ni ni-fat-remove"></i>
            </a>
            @endif
            <a href="{{ route('drivers.edit', ['driver' => $driver]) }}">
                <i class="ni ni-ruler-pencil" title="Edit Driver"></i>
            </a>
            <i class="ni ni-fat-remove ask-before-delete" type="submit" title="Delete Driver"></i>
            <form action="{{ route('drivers.destroy', ['driver' => $driver]) }}" method="POST">
                @csrf
                @method('DELETE')
            </form>
        </td>
    </tr>
    @endforeach
@else
<tr colspan="4">
    <td>
        <b>No Drivers Available</b>
    </td>
</tr>
@endif

