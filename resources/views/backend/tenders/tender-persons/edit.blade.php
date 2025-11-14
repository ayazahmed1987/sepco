@extends('backend.layout.master')
@section('content')
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tender Person Edit</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/manager') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Tender Person Edit</li>
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
                            <h3 class="card-title">Tender Person Edit</h3>
                        </div>
                        <form action="{{ route('manager.tender-persons.update', $tender_person) }}" method="POST"
                            enctype="multipart/form-data" id="myForm">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label>Tender Person Name:</label>
                                    <input type="text" name="name" placeholder="Tender Person Name"
                                        class="form-control" value="{{ old('name', $tender_person->name ?? '') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Email:</label>
                                    <input type="text" name="email" placeholder="Email" class="form-control"
                                        value="{{ old('email', $tender_person->email ?? '') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Phone Number:</label>
                                    <input type="text" name="phone" placeholder="Phone Number" class="form-control"
                                        value="{{ old('phone', $tender_person->phone ?? '') }}">
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
@endpush
