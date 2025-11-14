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
                <td><a href="{{ asset(Storage::url($final_evaluation->file)) }}" class="btn btn-dark"><i
                            class="fa fa-download"></i></a>
                </td>
                <td>{{ \Carbon\Carbon::parse($tender->bids_opening_date)->format('d-m-Y') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">No Final Evaluations available.</td>
            </tr>
        @endforelse
    </tbody>
</table>
{{ $final_evaluations->links('pagination::bootstrap-5') }}
