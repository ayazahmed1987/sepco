@extends('backend.layout.master')
@section('content')
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Menus List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/manager') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Add Menu</li>
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
                            <h3 class="card-title">Create New Menu</h3>
                        </div>
                        <form action="{{ route('manager.cms.menus.store') }}" method="POST" enctype="multipart/form-data"
                            id="myForm">
                            @csrf
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label>Menu Type:</label>
                                    <select class="form-control" id="type" name="type" required>
                                        <option selected disabled value="">Select Menu Type</option>
                                        <option value="1">Header Menu</option>
                                        <option value="2">Use Links Footer Menu</option>
										<option value="3">Our Services Footer Menu</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Parent ID:</label>
                                    <select class="form-control" id="parent_id" name="parent_id">
                                        <option selected disabled value="">Select Parent</option>
                                        @foreach ($parents as $parent)	
										<option value="{{ $parent->id }}">{{ $parent->title }} - ({{ $parent->type == 1 ? 'Header Menu' :
                                       ($parent->type == 2 ? 'Use Links Footer Menu' :
                                       ($parent->type == 3 ? 'Our Services Footer Menu' : 'Unknown Menu')) }})
                                       </option>	
												
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Menu Title:</label>
                                    <input type="text" name="title" placeholder="Menu Title" class="form-control"
                                        value="{{ old('title') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Menu Title Urdu:</label>
                                    <input type="text" name="title_ur" placeholder="Menu Title Urdu" class="form-control"
                                        value="{{ old('title_ur') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Redirection Type:</label>
                                    <select name="redirection_type" class="form-control" id="redirection_type">
                                        <option selected disabled value="">Select Redirection Type</option>
                                        @foreach (\App\Enums\MenuRedirectionType::cases() as $type)
                                            <option value="{{ $type->value }}"
                                                {{ old('redirection_type') == $type->value ? 'selected' : '' }}>
                                                {{ $type->label() }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3" style="display:none">
                                    <label>Page ID:</label>
                                    <select class="form-control" id="page_id" name="page_id">
                                        <option selected disabled value="">Select Page</option>
                                        @foreach ($pages as $page)
                                            <option value="{{ $page->id }}">{{ $page->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3" style="display:none">
                                    <label>Route:</label>
                                    <input type="text" name="route" placeholder="Custom route" class="form-control"
                                        value="{{ old('route') }}" id="route">
                                </div>
                                <div class="form-group mb-3" style="display:none">
                                    <label>URL:</label>
                                    <input type="text" name="url" placeholder="Custom URL" class="form-control"
                                        value="{{ old('url') }}" id="url">
                                </div>
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
                                    <input type="number" name="sorting" placeholder="Custom Sorting" class="form-control"
                                        value="{{ old('sorting') }}" id="sorting">
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
        #codeEditor {
            width: 100%;
            height: 200px;
            border: 1px solid #ccc;
        }
    </style>
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
        $(document).ready(function() {
            const fields = {
                'PAGE': '#page_id',
                'ROUTE': '#route',
                'URL': '#url'
            };

            function hideAllAndClear() {
                $.each(fields, function(type, selector) {
                    const $el = $(selector);
                    $el.closest('div').hide(); // Hide the wrapper
                    if ($el.is('select')) {
                        $el.prop('selectedIndex', 0); // Reset select
                    } else {
                        $el.val(''); // Clear text input
                    }
                });
            }
            $('#redirection_type').on('change', function() {
                hideAllAndClear();
                switch ($(this).val()) {
                    case '1':
                        $('#page_id').closest('div').show();
                        break;

                    case '2':
                        $('#route').closest('div').show();
                        break;

                    case '3':
                        $('#url').closest('div').show();
                        break;

                    default:
                        break;
                }

            });
        });
    </script>
@endpush
