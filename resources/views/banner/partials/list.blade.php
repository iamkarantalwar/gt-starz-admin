@if($banners->count() > 0)
    @foreach ($banners as $banner)
    <tr>
        <th scope="row">
            {{ $loop->iteration }}
        </th>
        <td class="budget">
            {{ $banner->description}}
        </td>
        <td>
            <span class="badge badge-dot mr-4">
                <img src="{{ Storage::disk(env('STORAGE_ENGINE'))->url($banner->image->url) }}" class="banner-table-image">
            </span>
        </td>
        <td class="actions">
            <a href="{{ route('banners.edit', ['banner' => $banner]) }}">
                <i class="ni ni-ruler-pencil" title="Edit Banner"></i>
            </a>
            <i class="ni ni-fat-remove ask-before-delete" type="submit" title="Delete Banner"></i>
            <form action="{{ route('banners.destroy', ['banner' => $banner]) }}" method="POST">
                @csrf
                @method('DELETE')
            </form>
        </td>
    </tr>
    @endforeach
@else
<tr colspan="4">
    <td>
        <b>No Banner Available</b>
    </td>
</tr>
@endif

