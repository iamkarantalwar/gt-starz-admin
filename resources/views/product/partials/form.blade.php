{!! Form::model($product, ((!empty($product)) ?
    ['method' => 'PATCH', 'route' => ['products.update', ['product' => $product]],
    'enctype' => 'multipart/form-data'] :
    ['method' => 'POST',
    'route' => ['products.store'],
    'enctype' => 'multipart/form-data'])) !!}
        <div class="form-group row">
            <label for="productCategory" class="col-sm-2 col-form-label">Product Category</label>
            <div class="col-sm-10">
                <select class="form-control" name="category_id" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option @if($product && $product->category_id == $category->id) selected @endif value="{{$category->id}}">{{$category->category_name}}</option>
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
        <?php
            if($product) {
                $variation = $product->skus->first()->productValues->first()->productOption;
                $variationType = $variation->option_name;
                $variationId = $variation->id;
            }
        ?>
        <div class="form-group row">
            <label for="categoryName" class="col-sm-2 col-form-label">Select Option</label>
            <div class="col-sm-2">
              <select class="form-control" id="add-variation-select">
                  <option value="">Select The Variation</option>
                  @foreach ($options as $option)
                    @if($product)
                        @if($option->id != $variationId && $product)
                            <option value="{{$option->id}}">{{$option->option_name}}</option>
                        @endif
                    @else
                        <option value="{{$option->id}}">{{$option->option_name}}</option>
                    @endif
                  @endforeach
              </select>
            </div>
            <div class="col-sm-2">
                <button type="button" class="btn btn-default" id="add-variation-btn">Add</button>
            </div>
            <div class="col-sm-4"></div>
            <div class="col-sm-2">
                <button type="button" class="btn btn-default" @if(!$product) style="display: none;" @endif id="add-more">Add More</button>
            </div>
        </div>
        <div class="card">

            <!-- Light table -->
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr id="product-variation-thead">
                    @if($product != null)
                        <th scope="col">
                            {{$variationType}}
                        </th>
                    @endif
                    <th scope="col">Price</th>
                    <th scope="col">Discount</th>
                    <th scope="col">Image</th>
                    <th style="width: 5% !important;">Remove</th>
                  </tr>
                </thead>
                <tbody class="list" id='product-variation-tbody'>
                    @if(isset($product))
                        @foreach ($product->skus as $item)
                        <tr>
                            <td>
                                <input type="hidden" name="ids[]" value="{{$item->id}}">
                                <input
                                    required=""
                                    @if($variationType == "COLOR" || $variationType== "COLOUR")
                                        type="color"
                                    @else
                                        type="text"
                                    @endif
                                    name="variant-{{$item->productValues()->first()->product_option_id}}[]"
                                    class="form-control"
                                    value="{{$item->productValues()->first()->product_value_id}}">
                            </td>
                            <td>
                            <input required="" name="price[]" class="form-control" type="number" value="{{$item->price}}" placeholder="Enter Price">
                            </td>
                            <td>
                                <input required="" name="discount[]" class="form-control" type="number" value="{{$item->discount}}" placeholder="Enter Discount">
                            </td>
                            <td class="">
                                <div class="card" style="width: 11rem;">
                                <img class="card-img-top" src="{{ Storage::disk(env('STORAGE_ENGINE'))->url($item->image->url) }}" alt="Card image cap">
                                    <div class="card-body">
                                        <input type="file" name="image-{{$item->id}}" onchange="selectImage(this);" @if(!$product) required="" @endif class="select-variant-image-file" style="display:none;">
                                        <a href="javascript:void(0);" onclick="openDialogBox();" class="btn btn-primary select-variant-image">Select Image</a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <i class="ni ni-fat-remove remove-variation-row" onclick="removeRow(this)" title="Remove Whole Row"></i>
                            </td>
                        </tr>
                        @endforeach
                    @endif
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
    @if($product)
    <script>
        selectedVariants.push({
                variant: '{{$variationType}}',
                value:  '{{$variationId}}'
        })
    </script>
    @endif
