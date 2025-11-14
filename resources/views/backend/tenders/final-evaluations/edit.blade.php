@extends('backend.layout.master')
@section('content')
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Final Evaluation</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/manager') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Edit Final Evaluation</li>
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
                            <h3 class="card-title">Edit Final Evaluation</h3>
                        </div>
                        <form action="{{ route('manager.final-evaluations.update', $final_evaluation) }}" method="POST"
                            enctype="multipart/form-data" id="myForm">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label>Tender:</label>
                                    <select name="tender_id" class="form-control" id="tender_id">
                                        <option selected disabled value="">Select Tender</option>
                                        @foreach ($tenders as $tender)
                                            <option value="{{ $tender->id }}"
                                                {{ old('tender_id', $final_evaluation->tender_id) == $tender->id ? 'selected' : '' }}>
                                                {{ $tender->ref_no }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Published Date:</label>
                                    <input type="text" name="published_date" id="published_date"
                                        placeholder="Published Date" class="form-control"
                                        value="{{ old('published_date', $final_evaluation->published_date) }}" required
                                        autocomplete="off">
                                </div>
                                <div class="form-group mb-3">
                                    <label>PO Issuance Date:</label>
                                    <input type="text" name="po_issuance_date" id="po_issuance_date"
                                        placeholder="PO Issuance Date" class="form-control"
                                        value="{{ old('po_issuance_date', $final_evaluation->po_issuance_date) }}" required
                                        autocomplete="off">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Final Evaluation File:</label>
                                    <input type="file" name="file" class="form-control">
                                </div>
                                @if ($final_evaluation->file)
                                    @php
                                        $mediaFile = $final_evaluation->file;
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
                                                <a href="{{ route('manager.final-evaluations.media-remove', [$final_evaluation->id, 'file']) }}"
                                                    class="btn btn-sm btn-outline-danger"
                                                    onclick="submitMediaRemoveForm('{{ $final_evaluation->id }}', 'file')">
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
