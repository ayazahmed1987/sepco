@extends('backend.layout.master')
@section('content')
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Menu</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/manager') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Edit Menu</li>
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
                            <h3 class="card-title">Edit Menu</h3>
                        </div>
                        <form action="{{ route('manager.cms.menus.update', $menu) }}" method="POST"
                            enctype="multipart/form-data" id="myForm">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label>Menu Type:</label>
                                    <select class="form-control" id="type" name="type" required>
                                        <option selected disabled value="">Select Menu Type</option>
                                        <option value="1" {{ $menu->type == 1 ? 'selected' : '' }}>Header Menu</option>
                                        <option value="2" {{ $menu->type == 2 ? 'selected' : '' }}>Use Links Footer Menu</option>
										<option value="3" {{ $menu->type == 3 ? 'selected' : '' }}>Our Services Footer Menu</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Parent ID:</label>
                                    <select class="form-control" id="parent_id" name="parent_id">
                                        <option value="">Select Parent</option>
                                        @foreach ($parents as $parent)	
									   <option value="{{ $parent->id }}"
                                                {{ $menu->parent_id == $parent->id ? 'selected' : '' }}>{{ $parent->title }} - ({{ $parent->type == 1 ? 'Header Menu' :
                                       ($parent->type == 2 ? 'Use Links Footer Menu' :
                                       ($parent->type == 3 ? 'Our Services Footer Menu' : 'Unknown Menu')) }})
                                       </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Menu Title:</label>
                                    <input type="text" name="title" placeholder="Menu Title" class="form-control"
                                        value="{{ old('title', $menu->title) }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Menu Title Urdu:</label>
                                    <input type="text" name="title_ur" placeholder="Menu Title Urdu" class="form-control"
                                        value="{{ old('title_ur', $menu->title_ur) }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Redirection Type:</label>
                                    <select name="redirection_type" class="form-control" id="redirection_type">
                                        <option value="">Select Redirection Type</option>
                                        @foreach (\App\Enums\MenuRedirectionType::cases() as $type)
                                            <option value="{{ $type->value }}"
                                                {{ $menu->redirection_type->value == $type->value ? 'selected' : '' }}>
                                                {{ $type->label() }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3"
                                    style="{{ $menu->redirection_type->value == 1 ? '' : 'display:none' }}">
                                    <label>Page ID:</label>
                                    <select class="form-control" id="page_id" name="page_id">
                                        <option value="">Select Page</option>
                                        @foreach ($pages as $page)
                                            <option value="{{ $page->id }}"
                                                {{ $menu->page_id == $page->id ? 'selected' : '' }}>
                                                {{ $page->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3"
                                    style="{{ $menu->redirection_type->value == 2 ? '' : 'display:none' }}">
                                    <label>Route:</label>
                                    <input type="text" name="route" placeholder="Custom route" class="form-control"
                                        value="{{ old('route', $menu->route) }}" id="route">
                                </div>
                                <div class="form-group mb-3"
                                    style="{{ $menu->redirection_type->value == 3 ? '' : 'display:none' }}">
                                    <label>URL:</label>
                                    <input type="text" name="url" placeholder="Custom URL" class="form-control"
                                        value="{{ old('url', $menu->url) }}" id="url">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Status:</label>
                                    <select name="status" class="form-control" required>
                                        <option value="">Select Status</option>
                                        <option value="1" {{ $menu->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $menu->status == 0 ? 'selected' : '' }}>Non-Active
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Sorting:</label>
                                    <input type="number" name="sorting" placeholder="Custom Sorting" class="form-control"
                                        value="{{ old('sorting', $menu->sorting) }}" id="sorting">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-dark">Update</button>
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
