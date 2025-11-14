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
        @forelse  ($technical_evaluations as $key => $technical_evaluation)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{ $technical_evaluation->tender->ref_no ?? '' }}</td>
                <td><a class="btn btn-dark" href="{{ asset(Storage::url($technical_evaluation->file)) }}"><i
                            class="fa fa-download"></i></a></td>
                <td>
                    @can('tender-create')
                        <a class="btn btn-xs btn-dark"
                            href="{{ route('manager.technical-evaluations.edit', $technical_evaluation) }}"><i
                                class="fa-solid fa-pen-to-square"></i></a>
                    @endcan
                    @can('tender-delete')
                        <form id="deleteTechnicalEvaluationForm{{ $key }}" method="POST"
                            action="{{ route('manager.technical-evaluations.destroy', $technical_evaluation) }}"
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
                <td colspan="5" class="text-center">No Technical Evaluation available.</td>
            </tr>
        @endforelse
    </tbody>
</table>
{{ $technical_evaluations->links('pagination::bootstrap-5') }}
