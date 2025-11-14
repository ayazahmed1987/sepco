@extends('backend.layout.master')
@section('content')
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Page Component Edit</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/manager') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Edit Page Component</li>
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
                            <h3 class="card-title">Edit Page Component</h3>
                        </div>
                        <form action="{{ route('manager.cms.page-components.update', [$page, $component]) }}" method="POST"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label>Parent Component:</label>
                                    <select name="parent_id" class="form-control" id="parent_id">
                                        <option selected disabled value="">Select Parent Component</option>
                                        @foreach ($pageComponentsList as $pageComponentItem)
                                            <option value="{{ $pageComponentItem->id }}" @selected(old('parent_id', $component->parent_id) == $pageComponentItem->id)>
                                                {{ $pageComponentItem->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Page Component Name:</label>
                                    <input type="text" name="title" placeholder="Page Component Name"
                                        class="form-control" value="{{ old('title', $component->title) }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Type:</label>
                                    <select name="type" class="form-control" id="type">
                                        <option selected disabled value="">Select Type</option>
                                        @foreach (\App\Enums\PageComponentType::options() as $option)
                                            <option value="{{ $option['id'] }}" @selected(old('type', $component->type) == $option['id'])>
                                                {{ $option['label'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3" id="related-type-div"
                                    style="{{ $component->type == 2 ? '' : 'display: none' }}">
                                    <label>Related Type:</label>
                                    <select name="related_type" class="form-control" id="related_type">
                                        <option selected disabled value="">Select Type</option>
                                        @foreach (\App\Enums\ComponentModelList::options() as $option)
                                            <option value="{{ $option['id'] }}" @selected(old('related_type', $component->related_type) == $option['id'])>
                                                {{ $option['label'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3" id="component-design-div"
                                    style="{{ $component->type == 1 ? '' : 'display: none' }}">
                                    <label>Page Component Design:</label>
                                    <select name="component_id" class="form-control" id="component_id">
                                        <option selected disabled value="">Select Page Component Type</option>
                                        @foreach ($componentsList as $componentsItem)
                                            <option value="{{ $componentsItem->id }}" @selected(old('component_id', $component->component_id) == $componentsItem->id)>
                                                {{ $componentsItem->component_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="dynamic-fields-container">
                                    {!! $html !!}
                                </div>
                                <div class="form-group mb-3">
                                    <label>Status:</label>
                                    <select name="status" class="form-control" required>
                                        <option selected disabled value="">Select Status</option>
                                        <option value="1" @selected(old('status', $component->status) == 1)>Active</option>
                                        <option value="0" @selected(old('status', $component->status) == 0)>Non-Active</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Sorting:</label>
                                    <input type="text" name="sorting" placeholder="Sorting" class="form-control"
                                        value="{{ old('sorting', $component->sorting) }}" required>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-dark">Submit</button>
                            </div>
                        </form>
                        <div class="col-md-12 table-responsive mt-3">
                            <a class="btn btn-xs btn-dark float-end"
                                href="{{ route('manager.cms.page-components.create', $page) }}">Add Components</a>

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
                                        @foreach ($component->children as $key => $component)
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
                                                        <form id="deletepage-componentForm{{ $key }}" method="POST"
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
    <style>
        #jsonEditor,
        #codeEditor,
        #cssEditor,
        #javascriptEditor {
            width: 100%;
            height: 200px;
            border: 1px solid #ccc;
        }

        #loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.95);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            backdrop-filter: blur(5px);
        }
    </style>
@endpush

@push('specific_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jodit/4.2.47/es2021/jodit.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.34.1/min/vs/loader.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#page-components-table").DataTable();
            $("#component_id").change(function() {
                var component_id = $("#component_id").val();
                $.ajax({
                    url: "{{ route('manager.cms.components.fields-render') }}",
                    method: 'GET',
                    data: {
                        component_id: component_id,
                    },
                    success: function(response) {
                        console.log(response);
                        $('#dynamic-fields-container').html(response);
                    },
                    error: function(xhr) {
                        let message = xhr.responseJSON?.message ?? 'Status update failed.';
                        alert(message);
                    }
                });
            });
            $(document).ready(function() {
                $('#type').on('change', function() {
                    let selectedType = parseInt($(this).val());
                    $("#dynamic-fields-container").html('');
                    $('#component_id').val('');
                    $('#related_type').val('');
                    if (selectedType === {{ \App\Enums\PageComponentType::DYNAMIC->value }}) {
                        $('#component-design-div').show();
                        $('#related-type-div').hide();
                    } else if (selectedType ===
                        {{ \App\Enums\PageComponentType::STATIC->value }}) {
                        $('#component-design-div').hide();
                        $('#related-type-div').show();
                    } else {
                        $('#component-design-div, #related-type-div').hide();
                    }
                });
            });
        });
        {!! $dataComponent->javascript !!}
    </script>
@endpush
