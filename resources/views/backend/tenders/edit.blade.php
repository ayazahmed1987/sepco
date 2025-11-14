@extends('backend.layout.master')
@section('content')
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Tender</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/manager') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Edit Tender</li>
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
                            <h3 class="card-title">Edit Tender</h3>
                        </div>
                        <form action="{{ route('manager.tenders.update', $tender) }}" method="POST"
                            enctype="multipart/form-data" id="myForm">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label>Tender Category:</label>
                                    <select name="type" class="form-control">
                                        <option selected disabled value="">Select Type</option>
                                        @foreach (\App\Enums\TenderCategoryType::options() as $type)
                                            <option value="{{ $type['value'] }}"
                                                {{ old('type', $tender->type?->value) == $type['value'] ? 'selected' : '' }}>
                                                {{ $type['label'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Tender Ref No:</label>
                                    <input type="text" name="ref_no" placeholder="Tender Ref No" class="form-control"
                                        value="{{ old('ref_no', $tender->ref_no) }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Tender Title:</label>
                                    <input type="text" name="title" placeholder="Tender Title" class="form-control"
                                        value="{{ old('title', $tender->title) }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Published Date:</label>
                                    <input type="text" name="published_date" id="published_date"
                                        placeholder="Published Date" class="form-control"
                                        value="{{ old('published_date', $tender->published_date) }}" required
                                        autocomplete="off">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Participation Closing Date:</label>
                                    <input type="text" name="participation_closing_date" id="participation_closing_date"
                                        placeholder="Participation Closing Date" class="form-control"
                                        value="{{ old('participation_closing_date', $tender->participation_closing_date) }}"
                                        required autocomplete="off">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Participation Closing Time:</label>
                                    <input type="time" name="participation_closing_time"
                                        placeholder="Participation Closing Time" class="form-control"
                                        value="{{ old('participation_closing_time', \Carbon\Carbon::parse($tender->participation_closing_time)->format('H:i')) }}"
                                        required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Bids Opening Date:</label>
                                    <input type="text" name="bids_opening_date" id="bids_opening_date"
                                        placeholder="Bids Opening Date" class="form-control"
                                        value="{{ old('bids_opening_date', $tender->bids_opening_date) }}" required
                                        autocomplete="off">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Bids Opening Time:</label>
                                    <input type="time" name="bids_opening_time" placeholder="Bids Opening Time"
                                        class="form-control"
                                        value="{{ old('bids_opening_time', \Carbon\Carbon::parse($tender->bids_opening_time)->format('H:i')) }}"
                                        required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Tender Person:</label>
                                    <select class="form-control" name="tender_person_id">
                                        <option selected disabled value="">Select Tender Person</option>
                                        @foreach ($tender_persons as $person)
                                            <option value="{{ $person->id }}" @selected($tender->tender_person_id == $person->id)>
                                                {{ $person->name }}</option>
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
                <div class="col-md-12 mt-4">
                    <div class="card card-dark">
                        <div class="card-header">
                            <h3 class="card-title">Tender Attachments</h3>
                            @can('tender-attachment-create')
                                <a class="btn btn-xs btn-dark float-end"
                                    href="{{ route('manager.tender-attachments.create', $tender) }}">Add Attachment</a>
                            @endcan
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                                width="100%" id="tender-attachments-table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Type</th>
                                        <th>Title</th>
                                        {{-- <th>Sorting</th> --}}
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tender->tenderAttachments as $key => $attachment)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $attachment->type->label() }}</td>
                                            <td>{{ $attachment->file_title }}</td>
                                            {{-- <td>{{ $attachment->sorting }}</td> --}}
                                            <td>
                                                @can('tender-attachment-edit')
                                                    <a class="btn btn-xs btn-dark"
                                                        href="{{ route('manager.tender-attachments.edit', $attachment) }}"><i
                                                            class="fa-solid fa-pen-to-square"></i></a>
                                                @endcan
                                                @can('tender-attachment-delete')
                                                    <form id="deleteTenderForm{{ $key }}" method="POST"
                                                        action="{{ route('manager.tender-attachments.destroy', $attachment) }}"
                                                        style="display:inline">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <button type="submit" class="btn btn-xs btn-danger"
                                                            onclick="deleteFunction({{ $key }})"><i
                                                                class="fa fa-trash"></i></button>
                                                    </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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
                    $("#bids_opening_date").datepicker("option", "minDate", minDate);
                }
            });
            $("#participation_closing_date").datepicker({
                dateFormat: 'yy-mm-dd'
            });
            $("#bids_opening_date").datepicker({
                dateFormat: 'yy-mm-dd'
            });
            $("#tender-attachments-table").dataTable();
        });
    </script>
@endpush
