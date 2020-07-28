@if($categories->count() > 0)
    @foreach ($categories as $category)
    <tr>
        <th scope="row">
            {{ $loop->iteration }}
        </th>
        <td class="budget">
            {{ $category->category_name}}
        </td>
        <td>
            <span class="badge badge-dot mr-4">
                <img src="{{ Storage::disk('s3')->url($category->image->url) }}" height="100px" width="100px">
            </span>
        </td>
        <td class="actions">
            <a href="{{ route('categories.edit', ['category' => $category]) }}">
                <i class="ni ni-ruler-pencil" title="Edit Category"></i>
            </a>
            <i class="ni ni-fat-remove ask-before-delete" type="submit" title="Delete Category"></i>
            <form action="{{ route('categories.destroy', ['category' => $category]) }}" method="POST">
                @csrf
                @method('DELETE')
            </form>
        </td>
    </tr>
    @endforeach
@else
<tr colspan="4">
    <td>
        <b>No Category Available</b>
    </td>
</tr>
@endif

