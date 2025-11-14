@extends('backend.layout.master')
@section('content')
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Attachment</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/manager') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('manager.tenders.edit', $tender) }}">Tender:
                                {{ $tender->ref_no }}</a></li>
                        <li class="breadcrumb-item active">Add Attachment</li>
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
                            <h3 class="card-title">Create New Attachment</h3>
                        </div>
                        <form action="{{ route('manager.tender-attachments.store') }}" method="POST"
                            enctype="multipart/form-data" id="myForm">
                            @csrf
                            <div class="card-body">
                                <input type="hidden" name="tender_id" value="{{ $tender->id }}">
                                <div class="form-group mb-3">
                                    <label>Attachment Type:</label>
                                    <select name="type" class="form-control">
                                        <option selected disabled value="">Select Type</option>
                                        @foreach (\App\Enums\TenderAttachmentType::options() as $type)
                                            <option value="{{ $type['value'] }}"
                                                {{ old('type') == $type['value'] ? 'selected' : '' }}>
                                                {{ $type['label'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Attachment Title:</label>
                                    <input type="text" name="file_title" placeholder="Attachment Title"
                                        class="form-control" value="{{ old('file_title') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Attachment:</label>
                                    <input type="file" name="file" class="form-control">
                                </div>
                                <div class="form-group mb-3 d-none">
                                    <label>Sorting:</label>
                                    <input type="number" name="sorting" placeholder="Sorting" class="form-control"
                                        value="{{ old('sorting', 1) }}" required>
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
            $("#participation_closing_date").datepicker({
                dateFormat: 'yy-mm-dd',
                onSelect: function(selectedDate) {
                    console.log(1);
                    const minDate = new Date(selectedDate);
                    minDate.setDate(minDate.getDate() + 15);
                    $("#bids_opening_date").datepicker("option", "minDate", minDate);
                }
            });
            $("#bids_opening_date").datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });
    </script>
@endpush
