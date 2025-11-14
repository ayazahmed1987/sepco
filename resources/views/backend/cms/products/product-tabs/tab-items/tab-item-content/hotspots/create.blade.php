@extends('backend.layout.master')
@section('content')
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-3">
                    <h1>Add Hotspot</h1>
                </div>
                <div class="col-sm-9">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/manager') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('manager.cms.tab-item-content.edit', [$tab_item_content]) }}">
                                Item Content: {{ $tab_item_content->title ?? '' }} </a></li>

                        <li class="breadcrumb-item active">Add Hotspot</li>
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
                            <h3 class="card-title">Create New Hotspot</h3>
                        </div>
                        <form action="{{ route('manager.cms.hotspots.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <input type="hidden" value="{{ $tab_item_content->id }}" name="tab_item_content_id">
                                <div class="form-group mb-3">
                                    <label>Type:</label>
                                    <select class="form-control" name="type">
                                        <option selected disabled value="">Select Type</option>
                                        <option value="front">Front</option>
                                        <option value="back">Back</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Hotspot Feature:</label>
                                    <input type="text" class="form-control" name="feature" value="{{ old('feature') }}"
                                        placeholder="Hotspot Feature">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Hotspot Detail:</label>
                                    <textarea class="form-control" name="detail">{{ old('detail') }}</textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Top Position:</label>
                                    <input type="text" class="form-control" name="top" value="{{ old('top') }}"
                                        placeholder="Hotspot Top Position">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Left Position:</label>
                                    <input type="text" class="form-control" name="left" value="{{ old('left') }}"
                                        placeholder="Hotspot Left Position">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Image:</label>
                                    <input type="file" class="form-control" name="image">
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
