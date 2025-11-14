@extends('backend.layout.master')
@section('content')
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Person List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/manager') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Add Person</li>
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
                            <h3 class="card-title">Create New Person</h3>
                        </div>
                        <form action="{{ route('manager.cms.management-persons.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label>Type:</label>
                                    <select name="type" class="form-control" required>
                                        <option selected disabled value="">Select Type</option>
                                        <option value="1">Board Of Directors</option>
                                        <option value="2">Management Team</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Name:</label>
                                    <input class="form-control" name="name" value="{{ old('name') }}"
                                        placeholder="Name">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Desgination:</label>
                                    <input class="form-control" name="designation" value="{{ old('designation') }}"
                                        placeholder="Desgination">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Description:</label>
                                    <textarea class="form-control advance-editor" name="description" required>{!! old('description') !!}</textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Image:</label>
                                    <input type="file" class="form-control" name="image">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Sorting:</label>
                                    <input type="number" class="form-control" name="sorting" value="{{ old('sorting') }}"
                                        placeholder="Sorting">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Status:</label>
                                    <select name="status" class="form-control" required>
                                        <option selected disabled value="">Select Status</option>
                                        <option value="1">Active</option>
                                        <option value="0">Non-Active</option>
                                    </select>
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
