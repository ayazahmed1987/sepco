@extends('backend.layout.master')
@section('content')
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit {{ $custompostdata->custompost->title ?? '' }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/manager') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Edit {{ $custompostdata->custompost->title ?? '' }}</li>
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
                            <h3 class="card-title">Edit {{ $custompostdata->custompost->title ?? '' }}</h3>
                        </div>
						
						
{{ html()->form('PUT', route('manager.cms.custompostdata.update', $custompostdata->id))->id('myForm')->attribute('enctype', 'multipart/form-data')->open() }}
{{ html()->hidden('custom_post_id')->value($custompostdata->custom_post_id) }}						

                            <div class="card-body">
<x-backend.custompost.render-fields :fields="$fields" :existingData="$existingData" :custompostdata="$custompostdata" />                                
								
								
                                <div class="form-group mb-3">
                                    <label>Status:</label>
                                    <select name="status" class="form-control" required>
                                        <option value="1" {{ $custompostdata->status == 1 ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="0" {{ $custompostdata->status == 0 ? 'selected' : '' }}>Non-Active
                                        </option>
                                    </select>
                                </div>
								<div class="form-group mb-3">
                                    <label>Sorting:</label>
                                    <input type="text" name="sorting" placeholder="Sorting" class="form-control"
                                        value="{{ old('sorting', $custompostdata->sorting) }}" required>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-dark">Update</button>
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
      {!! $custompostdata->custompost->javascript ?? '' !!}  
    </script>
@endpush
