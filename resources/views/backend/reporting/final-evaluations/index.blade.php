@extends('backend.layout.master')
@section('content')
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Final Evaluation Reporting</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/manager') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Final Evaluation Reporting</li>
                    </ol>
                </div>
            </div>
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ $message }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @elseif ($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $message }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="col-md-12">
                <div class="card-header bg-white py-3">
                    <form id="searchForm" class="row align-items-end">
                        {{-- Search --}}
                        <div class="col-md-4 mb-2">
                            <label for="search">Search by Ref No or Title</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0">
                                        <i class="fas fa-search text-muted"></i>
                                    </span>
                                </div>
                                <input type="text" name="search" id="search"
                                    class="form-control border-left-0 bg-light" value="{{ request('search') }}">
                            </div>
                        </div>

                        {{-- Start Date --}}
                        <div class="col-md-4 mb-2">
                            <label for="start_date">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control bg-light"
                                value="{{ request('start_date') }}">
                        </div>

                        {{-- End Date --}}
                        <div class="col-md-4 mb-2">
                            <label for="end_date">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control bg-light"
                                value="{{ request('end_date') }}">
                        </div>

                        {{-- Start Date --}}
                        <div class="col-md-4 mb-2">
                            <label for="po_issuance_start_date">PO Issuance Start Date</label>
                            <input type="date" name="po_issuance_start_date" id="po_issuance_start_date"
                                class="form-control bg-light" value="{{ request('po_issuance_start_date') }}">
                        </div>

                        {{-- End Date --}}
                        <div class="col-md-4 mb-2">
                            <label for="po_issuance_end_date">PO Issuance End Date</label>
                            <input type="date" name="po_issuance_end_date" id="po_issuance_end_date"
                                class="form-control bg-light" value="{{ request('po_issuance_end_date') }}">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label for="end_date">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="" selected>Select Status</option>
                                <option value="1">Active</option>
                                <option value="2">Archive</option>
                            </select>
                        </div>

                        {{-- Submit Button --}}
                        <div class="col-md-12 text-end">
                            <button type="submit" class="btn btn-primary px-5">
                                <i class="fas fa-search me-1"></i> Search
                            </button>
                        </div>
                    </form>
                </div>

                <div id="loader" class="text-center d-none">
                    <img src="{{ asset('frontend/assets/images/pspc-logo.png') }}" alt="PSPC Logo"
                        style="width: 100px; margin: 20px;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div id="tender-table-container" class="table-responsive">
                    <table class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Ref No</th>
                                <th>Title</th>
                                <th>Published Date</th>
                                <th>PO Issuance Date</th>
                                <th>File</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse  ($final_evaluations as $key => $final_evaluation)
                                @php
                                    $tender = $final_evaluation->tender;
                                @endphp
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $tender->ref_no }}</td>
                                    <td>{{ $tender->title }}</td>
                                    <td>{{ \Carbon\Carbon::parse($final_evaluation->published_date)->format('d-m-Y') }}
                                    </td>
                                    <td>
                                        {{ $final_evaluation->po_issuance_date ? \Carbon\Carbon::parse($final_evaluation->po_issuance_date)->format('d-m-Y') : 'N/A' }}
                                    </td>
                                    <td><a href="{{ asset(Storage::url($final_evaluation->file)) }}"
                                            class="btn btn-dark"><i class="fa fa-download"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No Final Evaluations available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $final_evaluations->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </section>
@endsection

@push('specific_css')
    <style>
        #loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.95);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            backdrop-filter: blur(5px);
        }

        .table th {
            font-weight: 600;
            color: #4a5568;
        }

        .table td {
            color: #2d3748;
        }

        .badge {
            font-weight: 500;
        }

        .pagination {
            margin-bottom: 0;
        }

        .page-link {
            color: #4a5568;
            border: none;
            padding: 0.5rem 1rem;
            margin: 0 0.25rem;
            border-radius: 0.375rem;
        }

        .page-item.active .page-link {
            background-color: #4299e1;
            border-color: #4299e1;
        }

        .input-group-text {
            border-right: none;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #4299e1;
        }

        .btn-primary {
            background-color: #4299e1;
            border-color: #4299e1;
        }

        .btn-primary:hover {
            background-color: #3182ce;
            border-color: #3182ce;
        }

        .btn-outline-primary {
            color: #4299e1;
            border-color: #4299e1;
        }

        .btn-outline-primary:hover {
            background-color: #4299e1;
            border-color: #4299e1;
        }

        table th,
        table td {
            white-space: nowrap;
        }
    </style>
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 26px;
        }

        .switch input {
            display: none;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #dc3545;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #28a745;
        }

        input:checked+.slider:before {
            transform: translateX(24px);
        }
    </style>
@endpush

@push('specific_js')
    <script>
        $(document).ready(function() {
            $('#searchForm').on('submit', function(e) {
                e.preventDefault();
                loadTenders(1);
            });

            $(document).on('click', '#tender-table-container .pagination a', function(e) {
                e.preventDefault();
                let page = $(this).attr('href').split('page=')[1];
                loadTenders(page);
            });

            function loadTenders(page) {
                $('#loader').removeClass('d-none');
                let searchParams = $('#searchForm').serialize();
                let url = '{{ route('manager.reporting.final-evaluations') }}?page=' + page + '&' +
                    searchParams;
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        $('#tender-table-container').html(response);
                        $('#loader').addClass('d-none');
                    },
                    error: function() {
                        $('#loader').addClass('d-none');
                        alert('Error loading data. Please try again.');
                    }
                });
            }
        });
    </script>
@endpush
