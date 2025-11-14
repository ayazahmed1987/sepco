<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <thead class="thead-dark">
        <tr>
            <th>No</th>
            <th>Ref No</th>
            <th>Title</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse  ($tenders as $key => $tender)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{ $tender->ref_no }}</td>
                <td>{{ $tender->title }}</td>
                <td>
                    @can('tender-create')
                        <a class="btn btn-xs btn-dark" href="{{ route('manager.tenders.edit', $tender) }}"><i
                                class="fa-solid fa-pen-to-square"></i></a>
                    @endcan
                    @can('tender-delete')
                        <form id="deleteTenderForm{{ $key }}" method="POST"
                            action="{{ route('manager.tenders.destroy', $tender) }}" style="display:inline">
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
                <td colspan="5" class="text-center">No Tenders available.</td>
            </tr>
        @endforelse
    </tbody>
</table>
{{ $tenders->links('pagination::bootstrap-5') }}
