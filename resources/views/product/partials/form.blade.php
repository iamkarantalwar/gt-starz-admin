{!! Form::model($product, ((!empty($product)) ?
    ['method' => 'PATCH', 'route' => ['products.update', ['product' => $product]],
    'enctype' => 'multipart/form-data'] :
    ['method' => 'POST',
    'route' => ['products.store'],
    'enctype' => 'multipart/form-data'])) !!}
        <div class="form-group row">
            <label for="productCategory" class="col-sm-2 col-form-label">Product Category</label>
            <div class="col-sm-10">
                <select class="form-control" name="category_id">
                    @foreach($categories as $category)
                        <option value="">Select Category</option>
                        <option value="{{$category->id}}">{{$category->category_name}}</option>
                    @endforeach
                </select>
                @if ($errors->has('category_id'))
                <span class="invalid-feedback" style="display: block;" role="alert">
                    <strong>{{ $errors->first('category_id') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label for="productName" class="col-sm-2 col-form-label">Product Name</label>
            <div class="col-sm-10">
                {{Form::text('product_name', null, ['class' => 'form-control '.($errors->has('product_name') ? 'is-invalid':''),
                                            'id'=>'productName', 'required' => 'required', 'placeholder' => 'Product Name......']) }}
                @if ($errors->has('product_name'))
                <span class="invalid-feedback" style="display: block;" role="alert">
                    <strong>{{ $errors->first('product_name') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label for="categoryName" class="col-sm-2 col-form-label">Description</label>
            <div class="col-sm-10">
                {{Form::textarea('description', null, ['class' => 'form-control '.($errors->has('description') ? 'is-invalid':''),
                                            'id'=>'categoryName', 'required' => 'required', 'placeholder' => 'Product Description.......']) }}
                @if ($errors->has('description'))
                <span class="invalid-feedback" style="display: block;" role="alert">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <hr/>
        <h3 class="my-1">Product Variations and Pricing</h3>
        <hr/>
        <div class="form-group row">
            <label for="categoryName" class="col-sm-2 col-form-label">Select Option</label>
            <div class="col-sm-2">
              <select class="form-control" id="add-variation-select">
                  <option value="">Select The Variation</option>
                  @foreach ($options as $option)
                    <option value="{{$option->id}}">{{$option->option_name}}</option>
                  @endforeach
              </select>
            </div>
            <div class="col-sm-2">
                <button type="button" class="btn btn-default" id="add-variation-btn">Add</button>
            </div>
            <div class="col-sm-4"></div>
            <div class="col-sm-2">
                <button type="button" class="btn btn-default" style="display: none;" id="add-more">Add More</button>
            </div>
        </div>
        <div class="card">

            <!-- Light table -->
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr id="product-variation-thead">
                    <th scope="col">Price</th>
                    <th scope="col">Discount</th>
                    <th scope="col">Image</th>
                    <th style="width: 5% !important;">Remove</th>
                  </tr>
                </thead>
                <tbody class="list" id='product-variation-tbody'>

                </tbody>
              </table>
            </div>
          </div>


        <div class="form-group row">
            <div class="col-sm-12 text-right">
                <button type="submit" class="btn btn-default">{{ isset($product) ? 'Update' : 'Save'}} Product</button>
            </div>
        </div>
    {!! Form::close() !!}

    <script src="{{ asset('product.js')}}"></script>
