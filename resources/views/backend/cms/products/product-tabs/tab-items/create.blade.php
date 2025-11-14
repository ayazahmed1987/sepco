@extends('backend.layout.master')
@section('content')
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-3">
                    <h1>Add Tab Item</h1>
                </div>
                <div class="col-sm-9">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/manager') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('manager.cms.products.edit', [$product_tab->product]) }}">
                                Product: {{ $product_tab->product->name ?? '' }} </a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('manager.cms.product-tabs.edit', [$product_tab->product, $product_tab]) }}">
                                Product Tab: {{ $product_tab->title ?? '' }} </a></li>

                        <li class="breadcrumb-item active">Add Tab Item</li>
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
                            <h3 class="card-title">Create New Tab Item</h3>
                        </div>
                        <form action="{{ route('manager.cms.tab-items.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <input type="hidden" value="{{ $product_tab->id }}" name="tab_id">
                                <div class="form-group mb-3">
                                    <label>Tab Item Name:</label>
                                    <input type="text" class="form-control" name="item_name"
                                        value="{{ old('item_name') }}" placeholder="Tab item Name">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Content:</label>
                                    <textarea class="form-control advance-editor" name="content">{!! old('content') !!}</textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Image:</label>
                                    <input type="file" class="form-control" name="image">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Sorting:</label>
                                    <input type="number" class="form-control" name="sorting" value="0">
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
        $(document).ready(function() {
            var editors = [].slice.call(document.querySelectorAll('.advance-editor'));
            editors.forEach(function(textarea) {
                var editor = Jodit.make(textarea, {
                    height: 500,
                    allowResizeX: true,
                    allowResizeY: true
                });
            });
        });
    </script>
@endpush
