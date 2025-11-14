@extends('backend.layout.master')
@section('content')
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Components List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/manager') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Add Component</li>
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
                            <h3 class="card-title">Create New Component</h3>
                        </div>
                        <form action="{{ route('manager.cms.components.store') }}" method="POST"
                            enctype="multipart/form-data" id="myForm">
                            @csrf
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label>Component Name:</label>
                                    <input type="text" name="component_name" placeholder="Component Title"
                                        class="form-control" value="{{ old('component_name') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Type:</label>
                                    <select name="type" class="form-control" id="type">
                                        <option selected disabled value="">Select Type</option>
                                        @foreach (\App\Enums\PageComponentType::options() as $option)
                                            <option value="{{ $option['id'] }}"
                                                {{ old('type', $selectedType ?? null) == $option['id'] ? 'selected' : '' }}>
                                                {{ $option['label'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Fields:</label>
                                    <div id="jsonEditor"></div>
                                    <input type="hidden" name="fields" id="hidden_json_editor">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Design:</label>
                                    <div id="codeEditor"></div>
                                    <input type="hidden" name="design" id="hidden_code_editor">
                                </div>
                                <div class="form-group mb-3">
                                    <label>CSS:</label>
                                    <div id="cssEditor"></div>
                                    <input type="hidden" name="css" id="hidden_css_editor">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Javascript:</label>
                                    <div id="javascriptEditor"></div>
                                    <input type="hidden" name="javascript" id="hidden_js_editor">
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
    <style>
        #jsonEditor,
        #codeEditor,
        #cssEditor,
        #javascriptEditor {
            width: 100%;
            height: 200px;
            border: 1px solid #ccc;
        }
    </style>
@endpush

@push('specific_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jodit/4.2.47/es2021/jodit.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.34.1/min/vs/loader.min.js"></script>
    <script>
        var jsonEditorInstance;
        var codeEditorInstance;
        var cssEditorInstance;
        var javascriptEditorInstance;
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
            require.config({
                paths: {
                    vs: "https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.34.1/min/vs"
                }
            });
            require(["vs/editor/editor.main"], function() {
                jsonEditorInstance = monaco.editor.create(document.getElementById("jsonEditor"), {
                    value: '{\n  "key": "value"\n}',
                    language: "json",
                    theme: "vs-dark"
                });
                codeEditorInstance = monaco.editor.create(document.getElementById("codeEditor"), {
                    value: "// Write your code here",
                    language: "html",
                    theme: "vs-dark"
                });
                cssEditorInstance = monaco.editor.create(document.getElementById("cssEditor"), {
                    value: "",
                    language: "css",
                    theme: "vs-dark"
                });
                monaco.languages.typescript.javascriptDefaults.addExtraLib(`
                    declare var $: any;
                    declare var jQuery: any;
                `);
                javascriptEditorInstance = monaco.editor.create(document.getElementById(
                    "javascriptEditor"), {
                    value: "",
                    language: "javascript",
                    theme: "vs-dark"
                });
            });
            $('#myForm').on('submit', function(e) {
                $('#hidden_json_editor').val(jsonEditorInstance.getValue());
                $('#hidden_code_editor').val(codeEditorInstance.getValue());
                $('#hidden_css_editor').val(cssEditorInstance.getValue());
                $('#hidden_js_editor').val(javascriptEditorInstance.getValue());
            });
            $('#type').change(function() {
                var type = $(this).val();
                if (type == 2) {
                    jsonEditorInstance.setValue('');
                    jsonEditorInstance.updateOptions({
                        readOnly: true
                    });
                } else {
                    jsonEditorInstance.updateOptions({
                        readOnly: false
                    });
                }
            });
        });
    </script>
@endpush
