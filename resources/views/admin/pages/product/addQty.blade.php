@extends('admin.layouts.app')

@section('admin_contant')
    <div class="p-3">
        <div class="row px-4">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-10 m-3">
                        <h3>{{ $product->title }} # {{ $product->product_id }}</h3>
                        <hr>
                        <h3>Product price + stock</h3>
                        <div class="row">
                            <div class="col-10 m-3">
                                <div class="row mb-2">
                                    <div class="col-3">
                                        <label class="text-muted" for="unit_price">Unit price</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" class="form-control" id="unit_price" name="unit_price"
                                            required="">
                                    </div>
                                </div>

                                <div class="row my-4">
                                    <div class="col-3">
                                        <label class="text-muted" for="e_category_name">Discount Date Start</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" class="form-control" id="e_category_name" name="category_name"
                                            required="">

                                    </div>
                                </div>

                                <div class="row my-4">
                                    <div class="col-3">
                                        <label class="text-muted" for="e_category_name">Discount Date End</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" class="form-control" id="e_category_name" name="category_name"
                                            required="">
                                    </div>
                                </div>

                                <div class="row my-4">
                                    <div class="col-3">
                                        <label class="text-muted" for="e_category_name">Discount</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" class="form-control" id="e_category_name" name="category_name"
                                            required="">
                                    </div>
                                </div>

                                <div class="row my-4">
                                    <div class="col-3">
                                        <label class="text-muted" for="e_category_name">Total Quantity</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" class="form-control" id="e_category_name" name="category_name"
                                            required="">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <hr>
                <hr>
                <div>

                </div>

            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h4>Product Atributes</h4>
                        <div class="mb-4">
                            <div class="form-group">
                                <label class="text-muted" for="disabledSelect">Size</label>
                                <select class="form-control" id="disabledSelect" style="width: 100%;">
                                    <option selected disabled>Select One</option>
                                    @foreach ($sizes as $size)
                                        <option value="{{ $size->id }}">{{ $size->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="text-muted" for="disabledSelect">Color</label>
                            <select class="form-control" id="disabledSelect" style="width: 100%;">
                                <option selected disabled>Select One</option>
                                @foreach ($colors as $color)
                                    <option value="{{ $color->id }}" style="color: {{ $color->color_code }};">
                                        &#9632;{{ $color->color }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
