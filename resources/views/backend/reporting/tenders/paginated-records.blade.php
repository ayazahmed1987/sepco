<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <thead class="thead-dark">
        <tr>
            <th>No</th>
            <th>Ref No</th>
            <th>Title</th>
            <th>Tender Person</th>
            <th>Published Date</th>
            <th>Opening Date</th>
        </tr>
    </thead>
    <tbody>
        @forelse  ($tenders as $key => $tender)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{ $tender->ref_no }}</td>
                <td>{{ $tender->title }}</td>
                <td>{{ $tender->tenderPerson->name ?? '' }}</td>
                <td>{{ \Carbon\Carbon::parse($tender->published_date)->format('d-m-Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($tender->bids_opening_date)->format('d-m-Y') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">No Tenders available.</td>
            </tr>
        @endforelse
    </tbody>
</table>
<div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
    <div class="mb-2 text-muted">
        Showing <strong>{{ $tenders->firstItem() }}</strong> to <strong>{{ $tenders->lastItem() }}</strong> of
        <strong>{{ $tenders->total() }}</strong> entries
    </div>
    <div>
        {{ $tenders->links('pagination::bootstrap-4') }}
    </div>
</div>
