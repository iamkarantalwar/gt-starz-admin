{!! Form::model($category, ((!empty($category)) ?
['method' => 'PATCH', 'route' => ['categories.update', ['category' => $category]],
'enctype' => 'multipart/form-data'] :
['method' => 'POST',
'route' => ['categories.store'],
'enctype' => 'multipart/form-data'])) !!}
    <div class="form-group row">
        <label for="categoryName" class="col-sm-2 col-form-label">Category Name</label>
        <div class="col-sm-10">
            {{Form::text('category_name', null, ['class' => 'form-control '.($errors->has('category_name') ? 'is-invalid':''),
                                        'id'=>'categoryName', 'placeholder' => 'Category Name.']) }}
            @if ($errors->has('category_name'))
            <span class="invalid-feedback" style="display: block;" role="alert">
                <strong>{{ $errors->first('category_name') }}</strong>
            </span>
            @endif
        </div>
    </div>
    <div class="form-group row">
        <label for="categoryImage" class="col-sm-2 col-form-label">Category Image</label>
        <div class="col-sm-4">
            <input type="file" name="image" class="upload-image-input @php ($errors->has('image') ? 'is-invalid':'') @endphp">
            @if ($errors->has('image'))
            <span class="invalid-feedback" style="display: block;" role="alert">
                <strong>{{ $errors->first('image') }}</strong>
            </span>
            @endif
            <br/>
            <b>Image Format allowed are :</b> gif, png, jpeg, jpg
        </div>
        <div class="col-sm-4" >
            <div class="border border-primary rounded" style="height: 200px; width:217px;overflow:hidden;">
            <img class="uploaded-image" src="@if($category){{ Storage::disk(env('STORAGE_ENGINE'))->url($category->image->url) }}@endif" alt="Please Upload Image..." height="203px" width="215px"/>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-12 text-right">
            <button type="submit" class="btn btn-primary">{{ isset($category) ? 'Update' : 'Save'}} Category</button>
        </div>
    </div>
{!! Form::close() !!}
