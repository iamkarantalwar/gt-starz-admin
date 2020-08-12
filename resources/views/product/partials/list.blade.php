
@if($products->count() > 0)
    @foreach ($products as $product)
    <tr>
        <th scope="row">
            {{ $loop->iteration }}
        </th>
        <td class="budget">
            <span class="badge badge-dot mr-4">
                <img src="{{ Storage::disk(env('STORAGE_ENGINE'))->url($product->skus->first()->image->url) }}" height="100px" width="100px">
            </span>
        </td>
        <td class="budget">
            {{ $product->product_name}}
        </td>
        <td class="budget">
            {{ $product->description}}
        </td>
        <td class="budget">
            {{ $product->category->category_name}}
        </td>


    </tr>
    @endforeach
@else
<tr colspan="4">
    <td>
        <b>No Products Available</b>
    </td>
</tr>
@endif

