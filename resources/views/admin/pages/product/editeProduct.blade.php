@extends('admin.layouts.app')
@section('admin_contant')
    <div class="p-3">
        <div>
            <h4>Product Edit</h4>
        </div>
        <form action="{{ route('editeProduct', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-10 m-3">
                            <div class="row mb-2">
                                <div class="col-3">
                                    <label class="text-muted" for="title">Title*</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        id="title" name="title" value="{{ old('title', $product->title) }}">
                                    @error('title')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <small class="form-text text-muted">This is your main category</small>
                                </div>
                            </div>


                            <div class="row my-4">
                                <div class="col-3">
                                    <label class="text-muted" for="product_id">Product Id* (unique)</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" class="form-control @error('product_id') is-invalid @enderror"
                                        id="product_id" name="product_id"
                                        value="{{ old('product_id', $product->product_id) }}">
                                    @error('product_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <small id="emailHelp" class="form-text text-muted">This is your main category</small>
                                </div>
                            </div>


                            <div class="row my-4">
                                <div class="col-3">
                                    <label class="text-muted" for="weight">Weight</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="weight" name="weight"
                                        value="{{ old('weight', $product->weight) }}">
                                    <small id="emailHelp" class="form-text text-muted">This is your main weight</small>
                                </div>
                            </div>


                            <div class="row my-4">
                                <div class="col-3">
                                    <label class="text-muted" for="minimum_purchase">Minimum Purchase*</label>
                                </div>
                                <div class="col-9">
                                    <input type="text"
                                        class="form-control @error('minimum_purchase') is-invalid @enderror"
                                        id="minimum_purchase" name="minimum_purchase"
                                        value="{{ old('minimum_purchase', $product->minimum_purchase) }}">
                                    @error('minimum_purchase')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>


                            <div class="row my-4">
                                <div class="col-3">
                                    <label class="text-muted" for="tags">Tags*</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" class="form-control @error('tags') is-invalid @enderror"
                                        id="tags" name="tags" value="{{ old('tags', $product->tags) }}">
                                    @error('tags')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>


                            <div class="row my-4">
                                <div class="col-3">
                                    <label class="text-muted" for="barcode">Barcode</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="barcode" name="barcode"
                                        value="{{ old('barcode', $product->barcode) }}">
                                </div>
                            </div>


                            <div class="row my-4">
                                <div class="col-3">
                                    <label class="text-muted" for="thum_img">Thum Img*</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" value="{{ $product->thum_img }}" name="oldThum">
                                    <input type="file" class="form-control @error('thum_img') is-invalid @enderror"
                                        id="thum_img" name="thum_img">
                                    @error('thum_img')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row my-4">
                                <div class="col-3">
                                    <label class="text-muted" for="description">Description*</label>
                                </div>
                                <div class="col-9">
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description"
                                        rows="5">{{ old('description', $product->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            {{-- {{ old('related_product', $product->related_product) }} --}}
                            <div class="row my-4">
                                <div class="col-3">
                                    <label class="text-muted" for="related_product">Related Product</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="related_product"
                                        name="related_product[]" value="">
                                </div>
                            </div>


                        </div>
                    </div>
                    <hr>
                    <hr>
                    <div>
                        <h3>----SEO Meta Tags</h3>
                        <div class="row">
                            <div class="col-10 m-3">
                                <div class="row mb-4">
                                    <div class="col-3">
                                        <label class="text-muted" for="meta_title">Meta Title</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text"
                                            class="form-control @error('meta_title') is-invalid @enderror" id="meta_title"
                                            name="meta_title" value="{{ old('meta_title', $seoProperty->meta_title) }}">
                                        @error('meta_title')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="row mb-4">
                                    <div class="col-3">
                                        <label class="text-muted" for="meta_slug">Meta slug</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" class="form-control" id="meta_slug" name="meta_slug"
                                            value="{{ old('meta_slug', $seoProperty->meta_slug) }}">
                                    </div>
                                </div>

                                <div class="row my-4">
                                    <div class="col-3 my-auto">
                                        <label class="text-muted" for="meta_des">Meta Description</label>
                                    </div>
                                    <div class="col-9">
                                        <textarea class="form-control" name="meta_des" rows="5" cols="10" id="meta_des">{{ old('meta_des', $seoProperty->meta_des) }}</textarea>
                                    </div>
                                </div>


                                <div class="row my-4">
                                    <div class="col-3">
                                        <label class="text-muted" for="meta_img">Meta Images</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" name="oldMeta_img" value="{{ $seoProperty->meta_img }}">
                                        <input type="file" class="form-control" id="meta_img" name="meta_img">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-4">
                                <div class="form-group">
                                    <label class="text-muted" for="category_id">Category</label>/{{ $product->cat_id }}
                                    <select class="form-control" name="category_id" id="category_id"
                                        style="width: 100%;">
                                        <option disabled>Select One</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $category->id == $product->cat_id ? 'selected' : '' }}>
                                                {{ $category->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>


                            </div>

                            <div class="my-4">
                                <div class="form-group">
                                    <label class="text-muted" for="subCat_id">Sub
                                        Category</label>/{{ $product->subCat_id }}
                                    <select class="form-control" name="subCat_id" id="subCat_id" style="width: 100%;">
                                        <!-- Sub Category options will be dynamically populated here -->
                                    </select>
                                </div>
                            </div>

                            <div class="my-4">
                                <div class="form-group">
                                    <label class="text-muted" for="childCat_id">Child
                                        Category</label>/{{ $product->childCat_id }}
                                    <select class="form-control" id="childCat_id" name="childCat_id"
                                        style="width: 100%;">
                                        <!-- Child Category options will be dynamically populated here -->
                                    </select>
                                </div>
                            </div>

                            <div class="my-4">
                                <div class="form-group">
                                    <label class="text-muted" for="brand_id">Brand</label>
                                    <select class="form-control" id="brand_id" name="brand_id" style="width: 100%;">
                                        <option selected disabled>Select One</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}"
                                                {{ $brand->id == $product->brand_id ? 'selected' : '' }}>
                                                {{ $brand->brand_name }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="row my-4">
                                <div class="">
                                    <label class="text-muted" for="refundable">Refundable</label>
                                </div>
                                <div class="custom-control custom-switch ml-4">
                                    <input type="checkbox" class="custom-control-input" id="refundable"
                                        name="refundable" {{ $product->refundable == 1 ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="refundable"></label>
                                </div>
                            </div>
                            <div class="row my-4">
                                <div class="">
                                    <label class="text-muted" for="cash_on_delivary">Cash On Delivery</label>
                                </div>

                                <div class="custom-control custom-switch ml-4">
                                    <input type="checkbox" class="custom-control-input" id="cash_on_delivary"
                                        name="cash_on_delivary" {{ $product->cash_on_delivary == 1 ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="cash_on_delivary"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-right mb-5">
                <button type="submit" class="btn btn-primary btn-lg">Submit</button>
            </div>
        </form>
    </div>
@endsection

@section('custom_js')
    <script>
        $(document).ready(function() {
            loadSubCategories();
            loadChildCategories();
        });

        $('#category_id').change(function() {
            loadSubCategories();
        });

        $('#subCat_id').change(function() {
            // var selectedSubCategoryId = $('#subCat_id').val();
            // console.log("Selected SubCategory ID:", selectedSubCategoryId);
            loadChildCategories();
        });

        function loadSubCategories() {
            var selectedCategoryId = $('#category_id').val();
            var subCategorySelect = $('#subCat_id');
            subCategorySelect.html('<option value="" selected disabled>Loading...</option>');

            $.ajax({
                url: '/admin/sabCategoryByCategoyId/' + selectedCategoryId,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    subCategorySelect.empty();
                    subCategorySelect.append('<option value="" selected disabled>Select One</option>');

                    $.each(response.data, function(index, subcategory) {
                        var isSelected = subcategory.id == {{ $product->subCat_id }} ? 'selected' : '';
                        var option =
                            `<option value="${subcategory.id}" ${isSelected}>${subcategory.subcategory_name}</option>`;
                        subCategorySelect.append(option);
                    });
                    loadChildCategories();
                },
                error: function(error) {
                    subCategorySelect.html(
                        '<option value="" selected disabled>Error loading subcategories</option>');
                }
            });
        }

        function loadChildCategories() {
            var selectedSubCategoryId = $('#subCat_id').val();
            // console.log(selectedSubCategoryId);
            var childCategorySelect = $('#childCat_id');
            childCategorySelect.html('<option value="" selected disabled>Loading...</option>');

            $.ajax({
                url: '/admin/chlidCategoryBySabCategoyId/' + selectedSubCategoryId,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    childCategorySelect.empty();
                    childCategorySelect.append('<option value="" selected disabled>Select One</option>');

                    if (response.childCat && response.childCat.length > 0) {
                        $.each(response.childCat, function(key, value) {
                            var childSelected = value.id == "{{ $product->childCat_id }}" ?
                                'selected' : '';
                            var childOption =
                                `<option value="${value.id}" ${childSelected}>${value.childcategory_name}</option>`;
                            childCategorySelect.append(childOption);
                        });
                    } else {
                        childCategorySelect.append(
                            '<option value="" disabled>No child categories found</option>');
                    }
                    childCategorySelect.closest('.form-group').find('.loading-indicator').hide();
                },
                error: function() {
                    childCategorySelect.html(
                        '<option value="" selected disabled>Error loading child categories</option>');
                    childCategorySelect.closest('.form-group').find('.loading-indicator').hide();
                }
            });
        }
    </script>
@endsection
