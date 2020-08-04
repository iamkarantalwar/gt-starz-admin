{!! Form::model($banner, ((!empty($banner)) ?
    ['method' => 'PATCH', 'route' => ['banners.update', ['banner' => $banner]],
    'enctype' => 'multipart/form-data'] :
    ['method' => 'POST',
    'route' => ['banners.store'],
    'enctype' => 'multipart/form-data'])) !!}
        <div class="form-group row">
            <label for="bannerDescription" class="col-sm-2 col-form-label">Banner Description</label>
            <div class="col-sm-10">
                {{Form::text('description', null, ['class' => 'form-control '.($errors->has('description') ? 'is-invalid':''),
                                            'id'=>'bannerDescription', 'placeholder' => 'Banner Description.']) }}
                @if ($errors->has('description'))
                <span class="invalid-feedback" style="display: block;" role="alert">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label for="bannerPriority" class="col-sm-2 col-form-label">Banner Priority</label>
            <div class="col-sm-10">
                {{Form::number('priority', null, ['class' => 'form-control '.($errors->has('priority') ? 'is-invalid':''),
                                            'id'=>'bannerPriority', 'placeholder' => 'Enter Priority.']) }}
                @if ($errors->has('priority'))
                <span class="invalid-feedback" style="display: block;" role="alert">
                    <strong>{{ $errors->first('priotity') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label for="bannerImage" class="col-sm-2 col-form-label">Banner Image</label>
            <div class="col-sm-4">
                <input type="file" id="bannerImage" name="image" class="upload-image-input @php ($errors->has('image') ? 'is-invalid':'') @endphp">
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
                <img class="uploaded-image" src="@if($banner){{ Storage::disk(env('STORAGE_ENGINE'))->url($banner->image->url) }}@endif" alt="Please Upload Image..." />
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-12 text-right">
                <button type="submit" class="btn btn-primary">{{ isset($banner) ? 'Update' : 'Save'}} Banner</button>
            </div>
        </div>
    {!! Form::close() !!}
