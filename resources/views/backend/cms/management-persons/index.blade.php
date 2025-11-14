@extends('backend.layout.master')
@section('content')
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Management Persons List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/manager') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Management Persons List</li>
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
            <div class="col-md-12 text-right">
                <a href="{{ route('manager.cms.management-persons.create') }}" class="btn btn-dark mb-3">
                    Add new Person
                </a>
            </div>
            <div class="col-md-12">
                <div class="card-header bg-white py-3">
                    <form id="searchForm" class="row align-items-center">
                        <div class="col-md-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0">
                                        <i class="fas fa-search text-muted"></i>
                                    </span>
                                </div>
                                <input type="text" name="search" class="form-control border-left-0 bg-light"
                                    placeholder="Search name" value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-search mr-1"></i> Search
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
                <div id="management-persons-table-container">
                    <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse  ($management_persons as $key => $management_person)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $management_person->name }}</td>
                                    <td>{{ $management_person->designation }}</td>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" class="status-switch"
                                                data-id="{{ $management_person->id }}"
                                                {{ $management_person->status ? 'checked' : '' }}>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <a class="btn btn-xs btn-dark"
                                            href="{{ route('manager.cms.management-persons.edit', $management_person) }}"><i
                                                class="fa-solid fa-pen-to-square"></i></a>
                                        <form id="deleteManagementPersonForm{{ $key }}" method="POST"
                                            action="{{ route('manager.cms.management-persons.destroy', $management_person) }}"
                                            style="display:inline">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-xs btn-danger"
                                                onclick="deleteFunction({{ $key }})"><i
                                                    class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No Persons available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $management_persons->links('pagination::bootstrap-5') }}
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
        function deleteFunction(key) {
            event.preventDefault(); // prevent form submit
            var form = $("#deleteManagementPersonForm" + key);
            Swal.fire({
                title: "Are you sure, you want to delete this Management Person?",
                text: "You won't be able to revert this, This Management Person will be deleted!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                    Swal.fire({
                        title: "Deleted!",
                        text: "Management Person has been deleted.",
                        icon: "success"
                    });
                }
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#searchForm').on('submit', function(e) {
                e.preventDefault();
                loadPersons(1);
            });

            $(document).on('click', '#management-persons-table-container .pagination a', function(e) {
                e.preventDefault();
                let page = $(this).attr('href').split('page=')[1];
                loadPersons(page);
            });

            function loadPersons(page) {
                $('#loader').removeClass('d-none');
                let searchParams = $('#searchForm').serialize();
                let url = '{{ route('manager.cms.management-persons.index') }}?page=' + page + '&' + searchParams;
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        $('#management-persons-table-container').html(response);
                        $('#loader').addClass('d-none');
                    },
                    error: function() {
                        // Hide loader
                        $('#loader').addClass('d-none');
                        alert('Error loading data. Please try again.');
                    }
                });
            }
        });
        $(document).ready(function() {
            $(document).on('change', '.status-switch', function() {
                var person_id = $(this).data('id');
                let status = $(this).is(':checked') ? 1 : 0;
                $.ajax({
                    url: "{{ route('manager.cms.management-persons.toggle-status') }}",
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: person_id,
                        status: status
                    },
                    success: function(response) {
                        console.log(response);
                        alert('Management Person status updated successfully.');
                    },
                    error: function(xhr) {
                        let message = xhr.responseJSON?.error ?? 'Status update failed.';
                        alert(message);
                    }
                });
            });
        });
    </script>
@endpush
