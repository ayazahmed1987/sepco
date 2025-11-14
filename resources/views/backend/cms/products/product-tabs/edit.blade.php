@extends('backend.layout.master')
@section('content')
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Product Tab</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/manager') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('manager.cms.products.edit', [$product]) }}">Product:
                                {{ $product->name }}</a></li>
                        <li class="breadcrumb-item active">Edit Product Tab</li>
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
                            <h3 class="card-title">Edit Product Tab</h3>
                        </div>
                        <form action="{{ route('manager.cms.product-tabs.update', $product_tab) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label>Products:</label>
                                    <select name="product_id" class="form-control" id="product_id">
                                        <option selected disabled value="">Select Product</option>
                                        @foreach ($productsOptions as $productsOption)
                                            <option value="{{ $productsOption->id }}" @selected(old('product_id', $product_tab->product_id) == $productsOption->id)>
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
                                            <option value="{{ $option['id'] }}" @selected(old('type', $product_tab->type) == $option['id'])>
                                                {{ $option['label'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Product Tab Title:</label>
                                    <input type="text" class="form-control" name="title"
                                        value="{{ old('title', $product_tab->title) }}" placeholder="Product tab title">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-dark">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
                @can('tab-items-list')
                    <div class="col-md-12 mt-5">
                        <div class="card card-dark">
                            <div class="card-header">
                                @can('tab-items-create')
                                    <a class="btn btn-xs btn-dark float-end"
                                        href="{{ route('manager.cms.tab-items.create', $product_tab) }}">Add Tab Item</a>
                                @endcan
                                <h3 class="mb-3"><strong>Tab Items</strong></h3>
                            </div>
                            <div class="card-body">
                                <table id="product-tab-table" class="table table-striped table-bordered dt-responsive nowrap"
                                    cellspacing="0" width="100%">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Item Name</th>
                                            <th>Sorting</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($product_tab->tabItems as $key => $tab_item)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $tab_item->item_name }}</td>
                                                <td>{{ $tab_item->sorting }}</td>
                                                <td>
                                                    @can('tab-items-edit')
                                                        <a class="btn btn-xs btn-dark"
                                                            href="{{ route('manager.cms.tab-items.edit', [$tab_item]) }}"><i
                                                                class="fa-solid fa-pen-to-square"></i></a>
                                                    @endcan
                                                    <form id="deleteTabItemForm{{ $key }}" method="POST"
                                                        action="{{ route('manager.cms.tab-items.destroy', [$tab_item]) }}"
                                                        style="display:inline">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <button type="submit" class="btn btn-xs btn-danger"
                                                            onclick="deleteFunction({{ $key }})"><i
                                                                class="fa fa-trash"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endcan
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
        $(document).ready(function() {
            $("#product-tab-table").dataTable();
        });
    </script>
@endpush
