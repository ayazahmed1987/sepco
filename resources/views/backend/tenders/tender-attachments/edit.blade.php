@extends('backend.layout.master')
@section('content')
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Attachment</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/manager') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('manager.tenders.edit', $tender_attachment->tender) }}">Tender:
                                {{ $tender_attachment->tender->ref_no }}</a></li>
                        <li class="breadcrumb-item active">Edit Attachment</li>
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
                            <h3 class="card-title">Edit Attachment</h3>
                        </div>
                        <form action="{{ route('manager.tender-attachments.update', $tender_attachment) }}" method="POST"
                            enctype="multipart/form-data" id="myForm">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <input type="hidden" name="tender_id" value="{{ $tender_attachment->tender->id }}">
                                <div class="form-group mb-3">
                                    <label>Attachment Type:</label>
                                    <select name="type" class="form-control">
                                        <option selected disabled value="">Select Type</option>
                                        @foreach (\App\Enums\TenderAttachmentType::options() as $type)
                                            <option value="{{ $type['value'] }}"
                                                {{ old('type', $tender_attachment->type?->value) == $type['value'] ? 'selected' : '' }}>
                                                {{ $type['label'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Attachment Title:</label>
                                    <input type="text" name="file_title" placeholder="Attachment Title"
                                        class="form-control" value="{{ old('file_title', $tender_attachment->file_title) }}"
                                        required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Attachment:</label>
                                    <input type="file" name="file" class="form-control">
                                </div>
                                @if ($tender_attachment->file)
                                    @php
                                        $mediaFile = $tender_attachment->file;
                                        $mediaPath = asset(Storage::url($mediaFile));
                                        $extension = strtolower(pathinfo($mediaFile, PATHINFO_EXTENSION));

                                        $mediaType = match (true) {
                                            in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']) => 'image',
                                            in_array($extension, ['mp4', 'webm', 'ogg']) => 'video',
                                            in_array($extension, ['pdf']) => 'pdf',
                                            in_array($extension, ['doc', 'docx']) => 'word',
                                            in_array($extension, ['xls', 'xlsx']) => 'excel',
                                            default => 'file',
                                        };
                                    @endphp

                                    @if ($mediaPath)
                                        <div class="card mb-3 mt-3 shadow-sm" style="max-width: 400px;">
                                            <div
                                                class="card-header d-flex justify-content-between align-items-center bg-light">
                                                <strong>Submitted {{ ucfirst($mediaType) }}</strong>
                                                <a href="{{ route('manager.tender-attachments.media-remove', [$tender_attachment->id, 'file']) }}"
                                                    class="btn btn-sm btn-outline-danger"
                                                    onclick="submitMediaRemoveForm('{{ $tender_attachment->id }}', 'file')">
                                                    <i class="fas fa-trash-alt"></i> Remove
                                                </a>
                                            </div>

                                            <div class="card-body text-center">
                                                @if ($mediaType === 'image')
                                                    <img src="{{ $mediaPath }}" alt="Submitted Image"
                                                        class="img-fluid rounded" style="max-height: 250px;">
                                                @elseif ($mediaType === 'video')
                                                    <video controls class="w-100 rounded" style="max-height: 250px;">
                                                        <source src="{{ $mediaPath }}"
                                                            type="video/{{ $extension }}">
                                                    </video>
                                                @elseif ($mediaType === 'pdf')
                                                    <iframe src="{{ $mediaPath }}" class="w-100 rounded"
                                                        style="height: 250px;" frameborder="0"></iframe>
                                                @else
                                                    <a href="{{ $mediaPath }}" target="_blank"
                                                        class="btn btn-outline-primary">
                                                        <i class="fas fa-file-alt"></i> Download
                                                        {{ strtoupper($extension) }}
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                @endif
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
