@if($users->count() > 0)
    @foreach ($users as $user)
    <tr>
        <th scope="row">
            {{ $loop->iteration }}
        </th>
        <td class="budget">
            {{ $user->name}}
        </td>
        <td class="budget">
            {{ $user->username}}
        </td>
        <td class="budget">
            {{ $user->email}}
        </td>
        <td class="budget">
            {{ $user->phone_number}}
        </td>
        <td class="budget">
            {{ $user->address}}
        </td>
        <td>
            @if($user->approved == "0")
                <b>Not Approved</b>
            @elseif($user->approved == "1")
                <b>Approved</b>
            @elseif($user->approved == null)
                <b>New User</b>
            @endif
        </td>
        <td class="actions">
            <a href="{{ route('users.changestatus', ['status' => 1, 'user' =>  $user]) }}"
                class="confirm-approval-change" title="Approve User">
                <i class="ni ni-check-bold" ></i>
            </a>
            <a href="{{ route('users.changestatus', ['status' => 0, 'user' =>  $user]) }}"
                class="confirm-approval-change" title="Disapprove User">
                <i class="ni ni-fat-remove"></i>
            </a>
        </td>
    </tr>
    @endforeach
@else
<tr colspan="4">
    <td>
        <b>No Users Available</b>
    </td>
</tr>
@endif

