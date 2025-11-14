@extends('backend.layout.master')
@section('content')
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-3">
                    <h1>Edit Hotspot</h1>
                </div>
                <div class="col-sm-9">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/manager') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('manager.cms.tab-item-content.edit', [$hotspot->tabItemContent]) }}">
                                Item Content: {{ $hotspot->tabItemContent->title ?? '' }} </a></li>

                        <li class="breadcrumb-item active">Edit Hotspot</li>
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
                            <h3 class="card-title">Edit New Hotspot</h3>
                        </div>
                        <form action="{{ route('manager.cms.hotspots.update', $hotspot) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <input type="hidden" value="{{ $hotspot->tabItemContent->id }}" name="tab_item_content_id">
                                <div class="form-group mb-3">
                                    <label>Type:</label>
                                    <select class="form-control" name="type">
                                        <option selected disabled value="">Select Type</option>
                                        <option value="front" @selected($hotspot->type === 'front')>Front</option>
                                        <option value="back" @selected($hotspot->type === 'back')>Back</option>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Hotspot Feature:</label>
                                    <input type="text" class="form-control" name="feature"
                                        value="{{ old('feature', $hotspot->feature) }}" placeholder="Hotspot Feature">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Hotspot Detail:</label>
                                    <textarea class="form-control" name="detail">{{ old('detail', $hotspot->detail) }}</textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Top Position:</label>
                                    <input type="text" class="form-control" name="top"
                                        value="{{ old('top', $hotspot->top) }}" placeholder="Hotspot Top Position">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Left Position:</label>
                                    <input type="text" class="form-control" name="left"
                                        value="{{ old('left', $hotspot->left) }}" placeholder="Hotspot Left Position">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Image:</label>
                                    <input type="file" class="form-control" name="image">
                                </div>
                                @if ($hotspot->image)
                                    @php
                                        $mediaFile = $hotspot->image;
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
                                                <a href="{{ route('manager.cms.hotspots.media-remove', [$hotspot->id, 'image']) }}"
                                                    class="btn btn-sm btn-outline-danger" title="Remove Image"
                                                    onclick="submitMediaRemoveForm('{{ $hotspot->id }}', 'image')">
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
