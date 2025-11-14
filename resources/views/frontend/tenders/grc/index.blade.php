@extends('frontend.layouts.master')
@section('content')
    @foreach ($renderedComponents as $html)
        {!! $html !!}
    @endforeach
    <section class="team_area ">
        <div class="container">
            <div class="row">
                @foreach ($grcs as $grc)
                    <div class="col-lg-3 col-md-6">
                        <div class="single-team_item">
                            <div class="team-content">
                                <h3>{{ $grc->name }}</h3>
                                <span>{{ $grc->email }}</span><br>
                                <span>{{ $grc->designation }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
@push('custom-css')
@endpush
@push('custom-js')
@endpush
