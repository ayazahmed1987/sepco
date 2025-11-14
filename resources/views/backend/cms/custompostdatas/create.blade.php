@extends('backend.layout.master')
@section('content')
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add {{ $custompost->title ?? '' }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/manager') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Add {{ $custompost->title ?? '' }}</li>
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
                            <h3 class="card-title">Create New {{ $custompost->title ?? '' }}</h3>
                        </div>
						{{--						

{{ html()->label('Email Address', 'email')->class('form-label') }}
{{ html()->email('email')->class('form-control')->placeholder('Your e-mail address')->required() }}

--}}


					
                        
<div class="card-body">
{{ html()->form('POST', route('manager.cms.custompostdata.store'))->id('myForm')->attribute('enctype', 'multipart/form-data')->open() }}
{{ html()->hidden('custom_post_id')->value($custompost->id) }}

<x-backend.custompost.render-fields :fields="$fields" />

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
                       {{ html()->form()->close() }}
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
			/*
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
			*/
        });
    </script>
@endpush
