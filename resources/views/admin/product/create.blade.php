@extends('admin.master')
@section('title')
    Thêm sản phẩm
@endsection
@section('main-content')
    <div class="main-content">
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form id="createproduct-form" autocomplete="off" class="needs-validation" novalidate method="POST"
                        action="{{ route('product.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mt-3">
                                            <a href="{{ route('product.index') }}"><svg xmlns="http://www.w3.org/2000/svg"
                                                    height="20" width="17.5"
                                                    viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                    <path
                                                        d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z" />
                                                </svg></a>
                                            <div class="mb-3">
                                                <label class="form-label" for="product-title-input">
                                                    Product Name</label>
                                                <input type="text" class="form-control" name="name"
                                                    id="product-title-input" value="{{ old('name') }}"
                                                    placeholder="Enter product title">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="product-title-input">
                                                    Product Price</label>
                                                <input type="text" class="form-control" name="price"
                                                    id="product-title-input" value="{{ old('price') }}"
                                                    placeholder="Enter product title">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="product-title-input">
                                                    Product Price Sale</label>
                                                <input type="text" class="form-control" name="sale_price"
                                                    id="product-title-input" value="{{ old('sale_price') ?: 0 }}"
                                                    placeholder="Enter product title">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="product-title-input">
                                                    Product Slug</label>
                                                <input type="text" class="form-control" name="slug"
                                                    id="product-title-input" value="{{ old('slug') }}"
                                                    placeholder="Enter product title">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="product-title-input">
                                                    stock quantity</label>
                                                <input type="text" class="form-control" name="stock_quantity"
                                                    id="product-title-input" value="{{ old('stock_quantity') }}"
                                                    placeholder="Enter product title">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="product-title-input">
                                                    Product Category</label>
                                                <select class="form-control" name="category_id" id="">
                                                    @foreach ($categories as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="product-title-input">
                                                    Product Image</label>
                                                <input type="file" class="form-control" name="image"
                                                    id="product-title-input" value="{{ old('image') }}"
                                                    placeholder="Enter product title">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="product-title-input">
                                                    Product Image Thumbnail</label>
                                                <input type="file" class="form-control" name="images[]"
                                                    id="product-title-input" value="{{ old('images[]') }}"
                                                    placeholder="Enter product title" multiple>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="product-title-input">
                                                    Product Description</label>
                                                <input type="text" class="form-control" name="description"
                                                    id="product-title-input" value="{{ old('description') }}"
                                                    placeholder="Enter product title">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="product-title-input">
                                                    Product Trending
                                                </label>
                                                <input type="radio" id="is_trending"
                                                    value="{{ old('is_trending') ? old('is_trending') : 1 }} "
                                                    name="is_trending">
                                                <label class="form-label" for="product-title-input">
                                                    Not Product Trending
                                                </label>
                                                <input type="radio" id="is_trending"
                                                    value="{{ old('is_trending') ? old('is_trending') : 0 }} "
                                                    name="is_trending" checked>
                                            </div>
                                            <div>
                                                <label>Product Description</label>

                                                <div id="ckeditor-classic">
                                                    <p>Tommy Hilfiger men striped pink sweatshirt. Crafted with cotton.
                                                        Material
                                                        composition is
                                                        100% organic cotton. This is one of the world’s leading designer
                                                        lifestyle
                                                        brands and is
                                                        internationally recognized for celebrating the essence of classic
                                                        American
                                                        cool style,
                                                        featuring preppy with a twist designs.</p>
                                                    <ul>
                                                        <li>Full Sleeve</li>
                                                        <li>Cotton</li>
                                                        <li>All Sizes available</li>
                                                        <li>4 Different Color</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="text-end mb-3">
                                                <button type="submit" class="btn btn-success w-sm">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end card -->
@endsection