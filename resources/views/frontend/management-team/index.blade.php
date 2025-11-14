@extends('frontend.layouts.master')
@section('content')
    @foreach ($renderedComponents as $html)
        {!! $html !!}
    @endforeach
    <section class="team_area ">
        <div class="container">
            <div class="row">
                @foreach ($directors as $director)
                    <div class="col-lg-3 col-md-6">
                        <div class="single-team_item">
                            <div class="team_thumb">
                                <img src="{{ asset(Storage::url($director->image)) }}" alt="">
                            </div>
                            <div class="team-content">
                                <h3><a
                                        href="{{ route('website.management-team.detail', $director->slug) }}">{{ $director->name }}</a>
                                </h3>
                                <span>{{ $director->designation }}</span>
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
