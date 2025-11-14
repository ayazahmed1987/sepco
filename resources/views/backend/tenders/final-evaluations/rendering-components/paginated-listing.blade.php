<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <thead class="thead-dark">
        <tr>
            <th>No</th>
            <th>Ref No</th>
            <th>File</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse  ($final_evaluations as $key => $final_evaluation)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{ $final_evaluation->tender->ref_no ?? ''}}</td>
                <td><a class="btn btn-dark" href="{{ asset(Storage::url($final_evaluation->file)) }}"><i
                            class="fa fa-download"></i></a></td>
                <td>
                    @can('tender-create')
                        <a class="btn btn-xs btn-dark"
                            href="{{ route('manager.final-evaluations.edit', $final_evaluation) }}"><i
                                class="fa-solid fa-pen-to-square"></i></a>
                    @endcan
                    @can('tender-delete')
                        <form id="deleteFinalEvaluationForm{{ $key }}" method="POST"
                            action="{{ route('manager.final-evaluations.destroy', $final_evaluation) }}"
                            style="display:inline">
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
                <td colspan="5" class="text-center">No Final Evaluation available.</td>
            </tr>
        @endforelse
    </tbody>
</table>
{{ $final_evaluations->links('pagination::bootstrap-5') }}
