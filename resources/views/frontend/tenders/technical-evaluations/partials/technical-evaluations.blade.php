@if (count($technical_evaluations) > 0)
    @foreach ($technical_evaluations as $technical_evaluation)
        <div class="tender-card p-4">
            <div class="row align-items-center">
                <div class="col-auto">
                    <div class="tender-icon">
                        @php
                            $tender = $technical_evaluation->tender;
                            $datetime = Carbon\Carbon::parse(
                                $tender->participation_closing_date . ' ' . $tender->participation_closing_time,
                            );

                            $formattedDate = $datetime->format('l, d F Y');
                            $formattedTime = $datetime->format('h:i A');
                        @endphp
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                </div>
                <div class="col">
                    <div class="tender-title py-2 fs-4">
                        {{ $tender->ref_no }}: {{ $tender->title }}
                    </div>

                    <div class="bid-evaluation-badge">Technical Evaluation</div>
                    <span class="py-1 text-75 mx-1 rule-text"><i class="fas fa-clock pr-1 text-dark"></i>
                        Category:</span>
                    <span class="py-1 text-75 rule-text"><span>{{ $tender->type->label() }}</span>
                    </span>
                </div>
                <div class="col-auto">
                    <a href="{{ asset(Storage::url($technical_evaluation->file)) }}" class="view-detail-btn">
                        Download Attachment
                    </a>
                </div>
            </div>
            <div class="col mt-3">
                <div class="row bg--ground p-2 rounded-3">
                    <div class="col-md-6">
                        <div class="publish-info">
                            <i class="fas fa-calendar-alt me-1 text-black"></i>
                            Published On:
                            {{ \Carbon\Carbon::parse($technical_evaluation->published_date)->format('d-M-Y') }}
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <div class="publish-info">
                            <i class="fas fa-clock me-1 text-black"></i>
                            Published
                            {{ \Carbon\Carbon::parse($technical_evaluation->published_date)->diffForHumans() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="text-sucess text-center">
        No data found!
    </div>
@endif
<div class="mt-3">
    {!! $technical_evaluations->links('pagination::bootstrap-5') !!}
</div>
