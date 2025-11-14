@extends('backend.layout.master')
@section('content')
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Permissions List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/manager') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Permissions List</li>
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
                <table id="dataTable" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                    width="100%">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $key => $permission)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $permission->name }}</td>
                                <td>
                                    @can('permission-edit')
                                        <a class="btn btn-xs btn-dark"
                                            href="{{ route('manager.permissions.edit', $permission) }}"><i
                                                class="fa-solid fa-pen-to-square"></i></a>
                                    @endcan
                                    @can('permission-delete')
                                        <form id="deletePermissionForm{{ $key }}" method="POST"
                                            action="{{ route('manager.permissions.destroy', $permission->id) }}"
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
    </section>
@endsection

@push('specific_css')
@endpush

@push('specific_js')
    <script>
        function deleteFunction(key) {
            event.preventDefault(); // prevent form submit
            var form = $("#deletePermissionForm" + key);
            Swal.fire({
                title: "Are you sure, you want to delete this permission?",
                text: "You won't be able to revert this, All the users containing this permission will be deleted!",
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
                        text: "Permission has been deleted.",
                        icon: "success"
                    });
                }
            });
        }
        $(document).ready(function() {
            $("#dataTable").dataTable();
        });
    </script>
@endpush
