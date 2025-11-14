@extends('backend.layout.master')
@section('content')
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Tender</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/manager') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Add Tender</li>
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
                            <h3 class="card-title">Create New Tender</h3>
                        </div>
                        <form action="{{ route('manager.tenders.store') }}" method="POST" enctype="multipart/form-data"
                            id="myForm">
                            @csrf
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label>Tender Category:</label>
                                    <select name="type" class="form-control">
                                        <option selected disabled value="">Select Type</option>
                                        @foreach (\App\Enums\TenderCategoryType::options() as $type)
                                            <option value="{{ $type['value'] }}"
                                                {{ old('type') == $type['value'] ? 'selected' : '' }}>
                                                {{ $type['label'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Tender Ref No:</label>
                                    <input type="text" name="ref_no" placeholder="Tender Ref No" class="form-control"
                                        value="{{ old('ref_no') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Tender Title:</label>
                                    <input type="text" name="title" placeholder="Tender Title" class="form-control"
                                        value="{{ old('title') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Published Date:</label>
                                    <input type="text" name="published_date" id="published_date"
                                        placeholder="Published Date" class="form-control"
                                        value="{{ old('published_date') }}" required autocomplete="off">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Participation Closing Date:</label>
                                    <input type="text" name="participation_closing_date" id="participation_closing_date"
                                        placeholder="Participation Closing Date" class="form-control"
                                        value="{{ old('participation_closing_date') }}" required autocomplete="off">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Participation Closing Time:</label>
                                    <input type="time" name="participation_closing_time"
                                        placeholder="Participation Closing Time" class="form-control"
                                        value="{{ old('participation_closing_time') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Bids Opening Date:</label>
                                    <input type="text" name="bids_opening_date" id="bids_opening_date"
                                        placeholder="Bids Opening Date" class="form-control"
                                        value="{{ old('bids_opening_date') }}" required autocomplete="off">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Bids Opening Time:</label>
                                    <input type="time" name="bids_opening_time" placeholder="Bids Opening Time"
                                        class="form-control" value="{{ old('bids_opening_time') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Tender Person:</label>
                                    <select class="form-control" name="tender_person_id">
                                        <option selected disabled value="">Select Tender Person</option>
                                        @foreach ($tender_persons as $person)
                                            <option value="{{ $person->id }}">{{ $person->name }}</option>
                                        @endforeach
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
            $("#published_date").datepicker({
                dateFormat: 'yy-mm-dd',
                onSelect: function(selectedDate) {
                    const minDate = new Date(selectedDate);
                    minDate.setDate(minDate.getDate() + 15);
                    $("#participation_closing_date").datepicker("option", "minDate", minDate);
                    $("#bids_opening_date").datepicker("option", "minDate",
                        minDate);
                }
            });
            $("#participation_closing_date").datepicker({
                dateFormat: 'yy-mm-dd'
            });
            $("#bids_opening_date").datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });
    </script>
@endpush
