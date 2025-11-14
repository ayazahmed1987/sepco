@extends('backend.layout.master')
@section('content')
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Page Component</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/manager') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Add Page Component</li>
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
            <div id="loader" class="text-center d-none">
                <img src="{{ asset('frontend/assets/images/pspc-logo.png') }}" alt="PSPC Logo"
                    style="width: 100px; margin: 20px;">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-dark">
                        <div class="card-header">
                            <h3 class="card-title">Create New Page Component</h3>
                        </div>
                        <form action="{{ route('manager.cms.page-components.store', $page) }}" method="POST"
                            enctype="multipart/form-data" id="myForm">
                            @csrf
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label>Parent Component:</label>
                                    <select name="parent_id" class="form-control" id="parent_id">
                                        <option selected disabled value="">Select Parent Component</option>
                                        @foreach ($pageComponents as $pageComponent)
                                            <option value="{{ $pageComponent->id }}" @selected(old('parent_id') == $pageComponent->id)
                                                data-component="{{ $pageComponent->component_id }}">
                                                {{ $pageComponent->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Page Component Name:</label>
                                    <input type="text" name="title" placeholder="Page Component Name"
                                        class="form-control" value="{{ old('title') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Type:</label>
                                    <select name="type" class="form-control" id="type">
                                        <option selected disabled value="">Select Type</option>
                                        @foreach (\App\Enums\PageComponentType::options() as $option)
                                            <option value="{{ $option['id'] }}" @selected(old('type') == $option['id'])>
                                                {{ $option['label'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3" id="related-type-div" style="display: none">
                                    <label>Related Type:</label>
                                    <select name="related_type" class="form-control" id="related_type">
                                        <option selected disabled value="">Select Type</option>
                                        @foreach (\App\Enums\ComponentModelList::options() as $option)
                                            <option value="{{ $option['id'] }}" @selected(old('related_type') == $option['id'])>
                                                {{ $option['label'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3" id="component-design-div" style="display: none">
                                    <label>Page Component Design:</label>
                                    <select name="component_id" class="form-control" id="component_id">
                                        <option selected disabled value="">Select Page Component Type</option>
                                        @foreach ($components as $component)
                                            <option value="{{ $component->id }}" @selected(old('component_id') == $component->id)>
                                                {{ $component->component_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="dynamic-fields-container"></div>
                                <div class="form-group mb-3">
                                    <label>Status:</label>
                                    <select name="status" class="form-control" required>
                                        <option selected disabled value="">Select Status</option>
                                        <option value="1">Active</option>
                                        <option value="0">Non-Active</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Sorting:</label>
                                    <input type="text" name="sorting" placeholder="Sorting" class="form-control"
                                        value="{{ old('sorting') }}" required>
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
            $("#component_id").change(function() {
                var parent_id = $("#parent_id").val();
                var component_id = $("#component_id").val();
                $.ajax({
                    url: "{{ route('manager.cms.components.fields-render') }}",
                    method: 'GET',
                    data: {
                        component_id: component_id,
                        is_children: parent_id ? 1 : 0,
                    },
                    success: function(response) {
                        $('#dynamic-fields-container').html(response);
                    },
                    error: function(xhr) {
                        let message = xhr.responseJSON?.message ?? 'Fields rendering failed.';
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
                $("#parent_id").change(function() {
                    var component_id = $(this).find('option:selected').data('component');
                    $("#type").val(1);
                    $("#type").trigger("change");
                    $("#component_id").val(component_id).trigger('change');
                });
            });
        });
    </script>
@endpush
