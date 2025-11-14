<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <thead class="thead-dark">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse  ($tender_persons as $key => $tender_person)
            <tr>
                <td>{{ $tender_persons->firstItem() + $key }}</td>
                <td>{{ $tender_person->name }}</td>
                <td>{{ $tender_person->email }}</td>
                <td>{{ $tender_person->phone }}</td>
                <td>
                    @can('tender-person-create')
                        <a class="btn btn-xs btn-dark" href="{{ route('manager.tender-persons.edit', $tender_person) }}"><i
                                class="fa-solid fa-pen-to-square"></i></a>
                    @endcan
                    @can('tender-person-delete')
                        <form id="deleteTenderPersonForm{{ $key }}" method="POST"
                            action="{{ route('manager.tender-persons.destroy', $tender_person) }}" style="display:inline">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-xs btn-danger"
                                onclick="deleteFunction({{ $key }})"><i class="fa fa-trash"></i></button>
                        </form>
                    @endcan
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">No Tender Persons available.</td>
            </tr>
        @endforelse
    </tbody>
</table>
{{ $tender_persons->links('pagination::bootstrap-5') }}
