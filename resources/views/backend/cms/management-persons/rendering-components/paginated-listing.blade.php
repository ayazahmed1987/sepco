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
                        <input type="checkbox" class="status-switch" data-id="{{ $management_person->id }}"
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
                            onclick="deleteFunction({{ $key }})"><i class="fa fa-trash"></i></button>
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
