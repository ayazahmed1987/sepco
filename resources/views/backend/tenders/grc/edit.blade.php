@extends('backend.layout.master')
@section('content')
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit GRC</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/manager') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Edit GRC</li>
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
                            <h3 class="card-title">Edit GRC</h3>
                        </div>
                        <form action="{{ route('manager.grcs.update', $grc) }}" method="POST" enctype="multipart/form-data"
                            id="myForm">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label>Name:</label>
                                    <input type="text" class="form-control" name="name" placeholder="Name"
                                        value="{{ $grc->name }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Email:</label>
                                    <input type="email" class="form-control" name="email" placeholder="Email"
                                        value="{{ $grc->email }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Designation:</label>
                                    <input type="text" class="form-control" name="designation" placeholder="Designation"
                                        value="{{ $grc->designation }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Status:</label>
                                    <select name="status" class="form-control">
                                        <option value="" selected disabled>Select Status</option>
                                        <option value="1" @selected($grc->status == 1)>Active</option>
                                        <option value="2" @selected($grc->status == 2)>Non-Active</option>
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
@endpush

@push('specific_js')
    <script>
        $(document).ready(function() {
            $("#tender_id").select2();
            $("#published_date").datepicker({
                dateFormat: 'yy-mm-dd',
            });
            $("#po_issuance_date").datepicker({
                dateFormat: 'yy-mm-dd',
            });
        });
    </script>
@endpush
