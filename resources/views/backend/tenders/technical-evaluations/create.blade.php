@extends('backend.layout.master')
@section('content')
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Technical Evaluation</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/manager') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Add Technical Evaluation</li>
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
                            <h3 class="card-title">Create New Technical Evaluation</h3>
                        </div>
                        <form action="{{ route('manager.technical-evaluations.store') }}" method="POST"
                            enctype="multipart/form-data" id="myForm">
                            @csrf
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label>Tender:</label>
                                    <select name="tender_id" class="form-control" id="tender_id">
                                        <option selected disabled value="">Select Tender</option>
                                        @foreach ($tenders as $tender)
                                            <option value="{{ $tender->id }}"
                                                {{ old('tender_id') == $tender->id ? 'selected' : '' }}>
                                                {{ $tender->ref_no }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Published Date:</label>
                                    <input type="text" name="published_date" id="published_date"
                                        placeholder="Published Date" class="form-control"
                                        value="{{ old('published_date') }}" required autocomplete="off">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Financial Opening Date:</label>
                                    <input type="text" name="financial_opening_date" id="financial_opening_date"
                                        placeholder="Financial Opening Date" class="form-control"
                                        value="{{ old('financial_opening_date') }}" required autocomplete="off">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Technical Evaluation File:</label>
                                    <input type="file" name="file" class="form-control">
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
            $("#financial_opening_date").datepicker({
                dateFormat: 'yy-mm-dd',
            });
        });
    </script>
@endpush
