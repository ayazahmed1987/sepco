<div class="modal fade" id="tenderDetailModal" tabindex="-1" aria-labelledby="tenderDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tenderDetailModalLabel">Tender Attachments</h5>
                <a type="a" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="modal-body">
                <h6 class="fw-bold">Tender No. {{ $tender->ref_no }}</h6>
                <h6 class="text-dark mb-3 fw-medium">{{ $tender->title }}</h6>
                <div class="row mb-3">
                    <div class="col-12">
                        <span class="bid-evaluation-badge bgc-purple">Tender</span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="table-responsive table-bordered table-striped">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">#</th>
                                        <th scope="col" class="text-center">Name</th>
                                        <th scope="col" class="text-center">File Download</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($tender->tenderAttachments) > 0)
                                        @foreach ($tender->tenderAttachments as $key => $attachment)
                                            <tr>
                                                <th scope="row" class="text-center">{{ ++$key }}</th>
                                                <td class="text-center">{{ $attachment->file_title }}</td>
                                                <td class="text-center">
                                                    <a href="{{ asset(Storage::url($attachment->file)) }}"
                                                        class="btn btn-success">
                                                        <i class="fas fa-download me-1"></i> File Download
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="3">
                                                <center>No attachments available</center>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a type="a" class="btn btn-secondary" data-bs-dismiss="modal">Close</a>
            </div>
        </div>
    </div>
</div>
