@extends('backend.layout.master')
@section('content')
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-3">
                    <h1>Edit Tab Item</h1>
                </div>
                <div class="col-sm-9">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/manager') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('manager.cms.products.edit', [$tab_item->productTab->product]) }}">
                                Product: {{ $tab_item->productTab->product->name ?? '' }} </a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('manager.cms.product-tabs.edit', [$tab_item->productTab->product, $tab_item->productTab]) }}">
                                Product Tab: {{ $tab_item->productTab->title ?? '' }} </a></li>

                        <li class="breadcrumb-item active">Edit Tab Item</li>
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
                            <h3 class="card-title">Edit Tab Item</h3>
                        </div>
                        <form action="{{ route('manager.cms.tab-items.update', $tab_item) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <input type="hidden" value="{{ $tab_item->productTab->id }}" name="tab_id">
                                <div class="form-group mb-3">
                                    <label>Tab Item Name:</label>
                                    <input type="text" class="form-control" name="item_name"
                                        value="{{ old('item_name', $tab_item->item_name) }}" placeholder="Tab item Name">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Content:</label>
                                    <textarea class="form-control advance-editor" name="content">{!! $tab_item->content !!}</textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Image:</label>
                                    <input type="file" class="form-control" name="image">
                                </div>
                                @if ($tab_item->image)
                                    @php
                                        $mediaFile = $tab_item->image;
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
                                                <a href="{{ route('manager.cms.tab-items.media-remove', [$tab_item->id, 'image']) }}"
                                                    class="btn btn-sm btn-outline-danger" title="Remove Image"
                                                    onclick="submitMediaRemoveForm('{{ $tab_item->id }}', 'image')">
                                                    <i class="fas fa-trash-alt"></i> Remove
                                                </a>
                                            </div>
                                            <div class="card-body text-center">
                                                @if ($mediaType === 'image')
                                                    <img src="{{ $mediaPath }}" alt="Submitted Image"
                                                        class="img-fluid rounded" style="max-height: 250px;">
                                                @elseif($mediaType === 'video')
                                                    <video controls class="w-100 rounded" style="max-height: 250px;">
                                                        <source src="{{ $mediaPath }}"
                                                            type="video/{{ $extension }}">
                                                    </video>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                @endif
                                <div class="form-group mb-3">
                                    <label>Sorting:</label>
                                    <input type="number" class="form-control" name="sorting"
                                        value="{{ old('sorting', $tab_item->sorting) }}">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-dark">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
                @can('tab-item-content-list')
                    <div class="col-md-12 mt-5">
                        <div class="card card-dark">
                            <div class="card-header">
                                @can('tab-items-create')
                                    <a class="btn btn-xs btn-dark float-end"
                                        href="{{ route('manager.cms.tab-item-content.create', $tab_item) }}">Add Item Content</a>
                                @endcan
                                <h3 class="mb-3"><strong>Item Content List</strong></h3>
                            </div>
                            <div class="card-body">
                                <table id="product-tab-table" class="table table-striped table-bordered dt-responsive nowrap"
                                    cellspacing="0" width="100%">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Content Title</th>
                                            <th>Sorting</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tab_item->tabItemContents as $key => $content)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $content->title }}</td>
                                                <td>{{ $content->sorting }}</td>
                                                <td>
                                                    @can('tab-item-content-edit')
                                                        <a class="btn btn-xs btn-dark"
                                                            href="{{ route('manager.cms.tab-item-content.edit', [$content]) }}"><i
                                                                class="fa-solid fa-pen-to-square"></i></a>
                                                    @endcan
                                                    <form id="deleteTabItemContentForm{{ $key }}" method="POST"
                                                        action="{{ route('manager.cms.tab-item-content.destroy', [$content]) }}"
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
            var editors = [].slice.call(document.querySelectorAll('.advance-editor'));
            editors.forEach(function(textarea) {
                var editor = Jodit.make(textarea, {
                    height: 500,
                    allowResizeX: true,
                    allowResizeY: true
                });
            });
        });
        $(document).ready(function() {
            $("#product-tab-table").dataTable();
        });
    </script>
@endpush
