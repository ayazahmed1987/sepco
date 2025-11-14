@extends('backend.layout.master')
@section('content')
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Technical Evaluation Reporting</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/manager') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Technical Evaluation Reporting</li>
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
                    <form id="searchForm" class="row g-3 align-items-end">

                        {{-- Search --}}
                        <div class="col-md-4">
                            <label for="search" class="fw-bold">Ref No / Title</label>
                            <input type="text" name="search" id="search" class="form-control bg-light"
                                placeholder="Enter Ref No or Title" value="{{ request('search') }}">
                        </div>

                        {{-- Publish Date Range --}}
                        <div class="col-md-4">
                            <label for="start_date" class="fw-bold">Publish Start</label>
                            <input type="date" name="start_date" id="start_date" class="form-control bg-light"
                                value="{{ request('start_date') }}">
                        </div>

                        <div class="col-md-4">
                            <label for="end_date" class="fw-bold">Publish End</label>
                            <input type="date" name="end_date" id="end_date" class="form-control bg-light"
                                value="{{ request('end_date') }}">
                        </div>

                        {{-- Opening Date Range --}}
                        <div class="col-md-3">
                            <label for="opening_start_date" class="fw-bold">Opening Start</label>
                            <input type="date" name="opening_start_date" id="opening_start_date"
                                class="form-control bg-light" value="{{ request('opening_start_date') }}">
                        </div>

                        <div class="col-md-3">
                            <label for="opening_end_date" class="fw-bold">Opening End</label>
                            <input type="date" name="opening_end_date" id="opening_end_date"
                                class="form-control bg-light" value="{{ request('opening_end_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="tender_person_id" class="fw-bold">Tender Persons</label>
                            <select class="form-control bg-light" id="tender_person_id" name="tender_person_id">
                                <option value="">Select Tender Person</option>
                                @foreach (App\Models\TenderPerson::all() as $person)
                                    <option value="{{ $person->id }}">{{ $person->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Status --}}
                        <div class="col-md-3">
                            <label for="status" class="fw-bold">Status</label>
                            <select class="form-control bg-light" id="status" name="status">
                                <option value="">All Status</option>
                                <option value="1" {{ request('status') == 1 ? 'selected' : '' }}>Active</option>
                                <option value="2" {{ request('status') == 2 ? 'selected' : '' }}>Archive</option>
                            </select>
                        </div>

                        {{-- Submit --}}
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
                                <th>Financial Opening Date</th>
                                <th>Technical Evaluation File</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse  ($technical_evaluations as $key => $technical_evaluation)
                                @php
                                    $tender = $technical_evaluation->tender;
                                @endphp
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $tender->ref_no }}</td>
                                    <td>{{ $tender->title }}</td>
                                    <td>{{ \Carbon\Carbon::parse($technical_evaluation->published_date)->format('d-m-Y') }}
                                    </td>
                                    <td>
                                        {{ $technical_evaluation->financial_opening_date ? \Carbon\Carbon::parse($technical_evaluation->financial_opening_date)->format('d-m-Y') : 'N/A' }}
                                    </td>
                                    <td><a href="{{ asset(Storage::url($technical_evaluation->file)) }}"
                                            class="btn btn-dark"><i class="fa fa-download"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No Technical Evaluations available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $technical_evaluations->links('pagination::bootstrap-5') }}
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
                let url = '{{ route('manager.reporting.technical-evaluations') }}?page=' + page + '&' +
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
