@if($orders->count() > 0)
    @foreach ($orders as $order)
    <tr>
        <th scope="row">
            {{ $loop->iteration }}
        </th>
        <th>
            {{ $order->id }}
        </th>
        <th>
            {{ $order->user()->first()->name }}
        </th>
        <th>
            {{$order->created_at->format('Y-m-d')}}
        </th>
        <th>
            {{strtoupper($order->order_status)}}
        </th>
        <th>
            <a href="{{ route('orders.show', ['order' => $order ]) }}">
                <button class="btn btn-sm btn-primary">View Order</button>
            </a>
        </th>
    </tr>
    @endforeach
@else
<tr colspan="4">
    <td>
        <b>No Orders Available</b>
    </td>
</tr>
@endif

