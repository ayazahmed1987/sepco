@extends('frontend.layouts.master')
@section('content')
    @foreach ($renderedComponents as $html)
        {!! $html !!}
    @endforeach
    <section class="why_choose_us">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 col-md-12">
                    <div class="">
                        <img src="{{ asset(Storage::url($director->image)) }}" class="img-fluid w-100" alt="">
                    </div>
                </div>
                <div class="col-lg-8 col-md-12">
                    <h1>{{ $director->designation }} - {{ $director->name }}</h1>
                    <div class="choose_right scroll-box">
                        <div class="section_title pb-13">
                            {!! $director->description !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('custom-css')
    <style>
        .scroll-box {
            height: 279px;
            overflow-y: scroll;
            padding: 15px;
        }

        /* Custom Scrollbar - For WebKit Browsers */
        .scroll-box::-webkit-scrollbar {
            width: 10px;
        }

        .scroll-box::-webkit-scrollbar-track {
            background: #eee;
        }

        .scroll-box::-webkit-scrollbar-thumb {
            background-color: #888;
            border-radius: 10px;
            border: 2px solid #eee;
        }

        .scroll-box::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Optional: Firefox (limited support) */
        .scroll-box {
            scrollbar-width: thin;
            scrollbar-color: #1b793d #eee;
        }
    </style>
@endpush
@push('custom-js')
@endpush
