@extends('backend.layout.master')
@section('content')
    {{-- @dd($tab_item_content->tabItem->productTab->product) --}}
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
                                href="{{ route('manager.cms.products.edit', [$tab_item_content->tabItem->productTab->product]) }}">
                                Product: {{ $tab_item_content->tabItem->productTab->product->name ?? '' }} </a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('manager.cms.product-tabs.edit', [$tab_item_content->tabItem->productTab->product, $tab_item_content->tabItem->productTab]) }}">
                                Product Tab: {{ $tab_item_content->tabItem->productTab->title ?? '' }} </a></li>

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
                        <form action="{{ route('manager.cms.tab-item-content.update', $tab_item_content) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <input type="hidden" value="{{ $tab_item_content->tabItem->id }}" name="tab_item_id">
                                <div class="form-group mb-3">
                                    <label>Content Title:</label>
                                    <input type="text" class="form-control" name="title"
                                        value="{{ old('title', $tab_item_content->title) }}" placeholder="Content Title">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Content:</label>
                                    <textarea class="form-control advance-editor" name="content">{!! $tab_item_content->content !!}</textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Image:</label>
                                    <input type="file" class="form-control" name="image">
                                </div>
                                @if ($tab_item_content->image)
                                    @php
                                        $mediaFile = $tab_item_content->image;
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
                                                <a href="{{ route('manager.cms.tab-item-content.media-remove', [$tab_item_content->id, 'image']) }}"
                                                    class="btn btn-sm btn-outline-danger" title="Remove Image"
                                                    onclick="submitMediaRemoveForm('{{ $tab_item_content->id }}', 'image')">
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
                                    <label>Is Reversed:</label>
                                    <select class="form-control" name="is_reversed">
                                        <option selected disabled value="">Is this content reversed?</option>
                                        <option value="1" {{ $tab_item_content->is_reversed == 1 ? 'selected' : '' }}>
                                            Yes</option>
                                        <option value="0" {{ $tab_item_content->is_reversed == 0 ? 'selected' : '' }}>
                                            No</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Sorting:</label>
                                    <input type="number" class="form-control" name="sorting"
                                        value="{{ $tab_item_content->sorting }}">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-dark">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
                @can('hotspots-list')
                    <div class="col-md-12 mt-5">
                        <div class="card card-dark">
                            <div class="card-header">
                                @can('tab-items-create')
                                    <a class="btn btn-xs btn-dark float-end"
                                        href="{{ route('manager.cms.hotspots.create', $tab_item_content) }}">Add Hotspot</a>
                                @endcan
                                <h3 class="mb-3"><strong>Hotspot List</strong></h3>
                            </div>
                            <div class="card-body">
                                <table id="product-tab-table" class="table table-striped table-bordered dt-responsive nowrap"
                                    cellspacing="0" width="100%">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Type</th>
                                            <th>Feature</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tab_item_content->hotspots as $key => $hotspot)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $hotspot->type }}</td>
                                                <td>{{ $hotspot->feature }}</td>
                                                <td>
                                                    @can('hotspots-edit')
                                                        <a class="btn btn-xs btn-dark"
                                                            href="{{ route('manager.cms.hotspots.edit', [$hotspot]) }}"><i
                                                                class="fa-solid fa-pen-to-square"></i></a>
                                                    @endcan
                                                    <form id="deleteHotspotForm{{ $key }}" method="POST"
                                                        action="{{ route('manager.cms.hotspots.destroy', [$hotspot]) }}"
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
            $("#product-tab-table").dataTable();
        });
    </script>
@endpush
