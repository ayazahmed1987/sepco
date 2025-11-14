@extends('backend.layout.master')
@section('content')
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Website Settings</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/manager') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Edit Website Settings</li>
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
                            <h3 class="card-title">Edit Website Settings</h3>
                        </div>
                        <form action="{{ route('manager.cms.settings.update') }}" method="POST" enctype="multipart/form-data" id="myForm">
                            @csrf
							
							
							
	<div class="card-body">
							    
	<div class="form-group mb-3">
		<label>Site Name:</label>
		<input type="text" name="site_name" placeholder="Site Name" class="form-control" value="{{ old('site_name', $setting->site_name) }}" required>
	</div>
	
	<div class="form-group mb-3">
		<label>Email:</label>
		<input type="text" name="email" placeholder="Email" class="form-control" value="{{ old('email', $setting->email) }}" required>
	</div>
	
	<div class="form-group mb-3">
		<label>Phone:</label>
		<input type="text" name="phone" placeholder="Phone" class="form-control" value="{{ old('phone', $setting->phone) }}" required>
	</div>
	
	<div class="form-group mb-3">
		<label>Address:</label>
		<input type="text" name="address" placeholder="Address" class="form-control" value="{{ old('address', $setting->address) }}" required>
	</div>
	
	<div class="form-group mb-3">
		<label>Logo:</label>
		@if ($setting->hasMedia('logo'))
		<img src="{{ $setting->getFirstMediaUrl('logo', 'full') }}" width="100" alt="logo" class="mb-2"><br>
        @endif
		<input type="file" name="logo" placeholder="Logo" class="form-control" >
	</div>
	
	<div class="form-group mb-3">
		<label>Favicon:</label>
		@if ($setting->hasMedia('favicon'))
		<img src="{{ $setting->getFirstMediaUrl('favicon', 'full') }}" width="25" alt="favicon" class="mb-2"><br>
        @endif
		<input type="file" name="favicon" placeholder="Favicon" class="form-control" >
	</div>
	
	
	<div class="form-group mb-3">
		<label>Facebook:</label>
		<input type="text" name="facebook" placeholder="Facebook" class="form-control" value="{{ old('facebook', $setting->facebook) }}" >
	</div>
	
	<div class="form-group mb-3">
		<label>Twitter:</label>
		<input type="text" name="twitter" placeholder="Twitter" class="form-control" value="{{ old('twitter', $setting->twitter) }}" >
	</div>
	
	<div class="form-group mb-3">
		<label>LinkedIn:</label>
		<input type="text" name="linkedin" placeholder="LinkedIn" class="form-control" value="{{ old('linkedin', $setting->linkedin) }}" >
	</div>
	
	<div class="form-group mb-3">
		<label>Instagram:</label>
		<input type="text" name="instagram" placeholder="Instagram" class="form-control" value="{{ old('instagram', $setting->instagram) }}" >
	</div>
	
	<div class="form-group mb-3">
		<label>YouTube:</label>
		<input type="text" name="youtube" placeholder="YouTube" class="form-control" value="{{ old('youtube', $setting->youtube) }}" >
	</div>
	
	<div class="form-group mb-3">
		<label>Copyright Text:</label>
		<input type="text" name="copyright_text" placeholder="Copyright Text" class="form-control" value="{{ old('copyright_text', $setting->copyright_text) }}" >
	</div>
	
	<div class="form-group mb-3">
		<label>Location Map:</label>
		<div id="codeEditor"></div>
		<input type="hidden" name="location_map" id="hidden_code_editor">
	</div>

	<div class="form-group mb-3">
		<label>Google Analytic Code:</label>
		<div id="javascriptEditor"></div>
		<input type="hidden" name="google_analytic" id="hidden_js_editor">
	</div>
                                


							
							</div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-dark">Update Settings</button>
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
            height: 100px;
            border: 1px solid #ccc;
        }
    </style>
@endpush

@push('specific_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jodit/4.2.47/es2021/jodit.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.34.1/min/vs/loader.min.js"></script>
    <script>
	$('.select2').select2({
    placeholder: 'Select Option',
    allowClear: true
    });
	
        var codeEditorInstance;
        var javascriptEditorInstance;
        $(document).ready(function() {
            require.config({
                paths: {
                    vs: "https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.34.1/min/vs"
                }
            });
            require(["vs/editor/editor.main"], function() {
                codeEditorInstance = monaco.editor.create(document.getElementById("codeEditor"), {
                    value: {!! json_encode($setting->location_map) !!},
                    language: "html",
                    theme: "vs-dark"
                });
                javascriptEditorInstance = monaco.editor.create(document.getElementById(
                    "javascriptEditor"), {
                    value: {!! json_encode($setting->google_analytic) !!},
                    language: "javascript",
                    theme: "vs-dark"
                });
            });
            $('#myForm').on('submit', function(e) {
                $('#hidden_code_editor').val(codeEditorInstance.getValue());
                $('#hidden_js_editor').val(javascriptEditorInstance.getValue());
            });
			
			
        });
		
					
    </script>
@endpush
