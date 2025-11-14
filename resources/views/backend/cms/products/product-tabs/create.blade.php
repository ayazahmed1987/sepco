@extends('backend.layout.master')
@section('content')
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Product Tab</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/manager') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('manager.cms.products.edit', [$product]) }}">Product:
                                {{ $product->name }}</a></li>
                        <li class="breadcrumb-item active">Add Product Tab</li>
                    </ol>
                </div>
            </div>
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-dark">
                        <div class="card-header">
                            <h3 class="card-title">Create New Product Tab</h3>
                        </div>
                        <form action="{{ route('manager.cms.product-tabs.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label>Products:</label>
                                    <select name="product_id" class="form-control" id="product_id">
                                        <option selected disabled value="">Select Product</option>
                                        @foreach ($productsOptions as $productsOption)
                                            <option value="{{ $productsOption->id }}" @selected(old('product_id') == $productsOption->id)>
                                                {{ $productsOption->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Product Tab Type:</label>
                                    <select name="type" class="form-control" id="type">
                                        <option selected disabled value="">Select Type</option>
                                        @foreach (\App\Enums\ProductTabType::options() as $option)
                                            <option value="{{ $option['id'] }}" @selected(old('type') == $option['id'])>
                                                {{ $option['label'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Product Tab Title:</label>
                                    <input type="text" class="form-control" name="title" value="{{ old('title') }}"
                                        placeholder="Product tab title">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-dark">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('specific_css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jodit/4.2.47/es2021/jodit.min.css" />
@endpush

@push('specific_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jodit/4.2.47/es2021/jodit.min.js"></script>
    <script>
        $(document).ready(function() {});
    </script>
@endpush
