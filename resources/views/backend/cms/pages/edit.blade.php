@extends('backend.layout.master')
@section('content')
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pages Edit</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/manager') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Edit Page</li>
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
                            <h3 class="card-title">Edit Page</h3>
                        </div>
                        <form action="{{ route('manager.cms.pages.update', $page) }}" method="POST"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label>Page Title:</label>
                                    <input type="text" name="title" class="form-control" placeholder="Page Title"
                                        value="{{ old('title', $page->title) }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Page Title Urdu:</label>
                                    <input type="text" name="title_ur" class="form-control" placeholder="Page Title Urdu"
                                        value="{{ old('title_ur', $page->title_ur) }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Description:</label>
                                    <textarea class="form-control advance-editor" name="description" required>
                                        {!! old('description', $page->description) !!}
                                    </textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Description Urdu:</label>
                                    <textarea class="form-control advance-editor" name="description_ur" required>
                                        {!! old('description_ur', $page->description_ur) !!}
                                    </textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Banner:</label>
									@if ($page->image && file_exists(public_path('storage/' . str_replace('/', DIRECTORY_SEPARATOR, $page->image))))
                                     <img src="{{ asset(Storage::url($page->image)) }}" alt="Page Banner Image" width="50" class="mb-2"><br>
                                    @endif
                                    <input type="file" class="form-control" name="image">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Meta Title:</label>
                                    <input type="text" name="meta_title" placeholder="Meta Title" class="form-control"
                                        value="{{ old('meta_title', $page->meta_title) }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Meta Description:</label>
                                    <input type="text" name="meta_description" placeholder="Meta Description"
                                        class="form-control" value="{{ old('meta_description', $page->meta_description) }}"
                                        required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Meta Keywords:</label>
                                    <input type="text" name="meta_keywords" placeholder="Meta Keywords"
                                        class="form-control" value="{{ old('meta_keywords', $page->meta_keywords) }}"
                                        required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Status:</label>
                                    <select name="status" class="form-control" required>
                                        <option disabled value="">Select Status</option>
                                        <option value="1" {{ old('status', $page->status) == '1' ? 'selected' : '' }}>
                                            Active</option>
                                        <option value="0" {{ old('status', $page->status) == '0' ? 'selected' : '' }}>
                                            Non-Active</option>
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
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card card-dark p-3">
                        <div class="col-md-12 table-responsive mt-3">
                            @can('page-component-create')
                                <a class="btn btn-xs btn-dark float-end"
                                    href="{{ route('manager.cms.page-components.create', $page) }}">Add Components</a>
                            @endcan
                            <h3 class="mb-3"><strong>Page Components</strong></h3>
                            <div id="page-components-table-container">
                                <table id="page-components-table"
                                    class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                                    width="100%">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Title</th>
                                            <th>Status</th>
                                            <th>Sorting</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($page->components as $key => $component)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $component->title }}</td>
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" class="status-switch"
                                                            data-id="{{ $component->id }}"
                                                            {{ $component->status ? 'checked' : '' }}>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                                <td>{{ $component->sorting }}</td>
                                                <td>
                                                    @can('page-component-edit')
                                                        <a class="btn btn-xs btn-dark"
                                                            href="{{ route('manager.cms.page-components.edit', [$page, $component]) }}"><i
                                                                class="fa-solid fa-pen-to-square"></i></a>
                                                    @endcan
                                                    @can('page-component-delete')
                                                        <form id="deletePageComponentForm{{ $key }}" method="POST"
                                                            action="{{ route('manager.cms.page-components.destroy', [$page, $component]) }}"
                                                            style="display:inline">
                                                            {{ csrf_field() }}
                                                            {{ method_field('DELETE') }}
                                                            <button type="submit" class="btn btn-xs btn-danger"
                                                                onclick="deleteFunction({{ $key }})"><i
                                                                    class="fa fa-trash"></i></button>
                                                        </form>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('specific_css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jodit/4.2.47/es2021/jodit.min.css" />
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 26px;
        }

        .switch input {
            display: none;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #dc3545;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #28a745;
        }

        input:checked+.slider:before {
            transform: translateX(24px);
        }
    </style>
@endpush

@push('specific_js')
    <script>
        function deleteFunction(key) {
            event.preventDefault();
            var form = $("#deletePageComponentForm" + key);
            Swal.fire({
                title: "Are you sure, you want to delete this page component?",
                text: "You won't be able to revert this, This page component will be deleted!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                    Swal.fire({
                        title: "Deleted!",
                        text: "page component has been deleted.",
                        icon: "success"
                    });
                }
            });
        }
    </script>
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
            $("#page-components-table").DataTable();
        });
    </script>
@endpush
