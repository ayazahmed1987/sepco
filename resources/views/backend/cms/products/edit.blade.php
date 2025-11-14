@extends('backend.layout.master')
@section('content')
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Product</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/manager') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Edit Product</li>
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
                            <h3 class="card-title">Edit Product</h3>
                        </div>
                        <form action="{{ route('manager.cms.products.update', $product) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label>Product Name:</label>
                                    <input type="text" name="name" placeholder="Product" class="form-control"
                                        value="{{ old('name', $product->name) }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Thumbnail:</label>
                                    <input type="file" class="form-control" name="thumbnail">
                                </div>
                                @if ($product->thumbnail)
                                    @php
                                        $mediaFile = $product->thumbnail;
                                        $mediaPath = asset(Storage::url($mediaFile));
                                        $extension = strtolower(pathinfo($mediaFile, PATHINFO_EXTENSION));

                                        $mediaType = match (true) {
                                            in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']) => 'image',
                                            in_array($extension, ['mp4', 'webm', 'ogg']) => 'video',
                                            default => null,
                                        };
                                    @endphp

                                    @if ($mediaType && $mediaPath)
                                        <div class="card mb-3 mt-3 shadow-sm" style="max-width: 400px;">
                                            <div
                                                class="card-header d-flex justify-content-between align-items-center bg-light">
                                                <strong>Submitted {{ ucfirst($mediaType) }}</strong>
                                                <a href="{{ route('manager.cms.products.media-remove', [$product->id, 'thumbnail']) }}"
                                                    class="btn btn-sm btn-outline-danger" title="Remove Thumbnail"
                                                    onclick="submitMediaRemoveForm('{{ $product->id }}', 'thumbnail')">
                                                    <i class="fas fa-trash-alt"></i> Remove
                                                </a>
                                            </div>
                                            <div class="card-body text-center">
                                                @if ($mediaType === 'image')
                                                    <img src="{{ $mediaPath }}" alt="Submitted Image"
                                                        class="img-fluid rounded" style="max-height: 250px;">
                                                @elseif($mediaType === 'video')
                                                    <video controls class="w-100 rounded" style="max-height: 250px;">
                                                        <source src="{{ $mediaPath }}" type="video/{{ $extension }}">
                                                    </video>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-dark">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
                @can('product-tab-list')
                    <div class="col-md-12 mt-5">
                        <div class="card card-dark">
                            <div class="card-header">
                                @can('product-tab-create')
                                    <a class="btn btn-xs btn-dark float-end"
                                        href="{{ route('manager.cms.product-tabs.create', $product) }}">Add Product Tab</a>
                                @endcan
                                <h3 class="mb-3"><strong>Product Tabs</strong></h3>
                            </div>
                            <div class="card-body">
                                <table id="product-tab-table" class="table table-striped table-bordered dt-responsive nowrap"
                                    cellspacing="0" width="100%">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Title</th>
                                            <th>Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tabs as $key => $tab)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $tab->title }}</td>
                                                <td>{{ \App\Enums\ProductTabType::from($tab->type)->label() }}</td>
                                                <td>
                                                    @can('product-tab-edit')
                                                        <a class="btn btn-xs btn-dark"
                                                            href="{{ route('manager.cms.product-tabs.edit', [$product, $tab]) }}"><i
                                                                class="fa-solid fa-pen-to-square"></i></a>
                                                    @endcan
                                                    <form id="deleteProducTabForm{{ $key }}" method="POST"
                                                        action="{{ route('manager.cms.product-tabs.destroy', [$tab]) }}"
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
