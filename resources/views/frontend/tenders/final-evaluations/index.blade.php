@extends('frontend.layouts.master')
@section('content')
    @foreach ($renderedComponents as $html)
        {!! $html !!}
    @endforeach
    <div class="search-section">
        <div class="container-fluid">
            <div class="row justify-content-center mt-4">
                <div class="col-md-10 w-75">
                    <form method="GET" action="{{ url()->current() }}">
                        <div class="row g-2 align-items-center">
                            {{-- Search --}}
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search final evaluations..."
                                        id="search" name="search" value="{{ request('search') }}">
                                    <a class="btn btn-primary btn-color" type="submit">
                                        <i class="fas fa-search"></i>
                                    </a>
                                </div>
                            </div>

                            {{-- Status Dropdown --}}
                            <div class="col-md-2">
                                <select class="form-select" id="statusFilter" name="status">
                                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>
                                        Archived</option>
                                </select>
                            </div>

                            {{-- Year Dropdown (Hardcoded) --}}
                            <div class="col-md-2">
                                @php
                                    $selectedYear = request('year') ?: $years[0] ?? '';
                                @endphp
                                <select class="form-select" id="yearFilter" name="year">
                                    @foreach ($years as $year)
                                        <option value="{{ $year }}" {{ $year === $selectedYear ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container ">
        <div class="container-custom" id="tenders-container">
            @include('frontend.tenders.final-evaluations.partials.final-evaluations', [
                'final_evaluations' => $final_evaluations,
            ])
        </div>
    </div>
@endsection
@push('custom-css')
    <style>
        .tender-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 10px;
            background-color: #fff;
        }

        .tender-card:hover {
            transform: scale(1.03);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            z-index: 10;
        }

        .bg--ground {
            background-color: #f8f9fa;
            /* Light gray background */
        }

        .tender-card:hover .bg--ground {
            background-color: #f1f1f1;
        }

        a.btn.btn-primary.btn-color {
            border: 1px solid #1d6a3e !important;
            background: #1d6a3e17;
            color: #000000;
        }

        a.btn.btn-primary.btn-color:hover {

            background: #1d6a3e;
            color: #ffffff;
        }

        .row.bg--ground.p-2.rounded-3 {
            background-color: #44444417;
        }

        .tender-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background: #f8f9fa;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin: 20px 0;
        }

        .tender-icon {
            background: linear-gradient(45deg, #1D5A6A, #123840);
            color: white;
            width: 145px;
            padding: 9px 15px 0 15px;
            height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-size: 50px;
        }

        .bid-evaluation-badge {
            background: #1D5A6A;
            color: white;
            padding: 5px 12px;
            border-radius: 3px;
            font-size: 15px;
            text-transform: uppercase;
            display: inline-block;
            margin-bottom: 8px;
        }

        .tender-title {
            color: #333;
            font-weight: 600;
            font-size: 18px;
            margin-bottom: 8px;
            line-height: 1.4;
        }

        .rule-text {
            color: #666;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .publish-info {
            color: #666;
            font-size: 13px;
        }

        .view-detail-btn {
            border: 1px solid #1d6a3e !important;
            background: #1d6a3e17;
            color: #000000;
            padding: 8px 20px;
            border-radius: 4px;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }

        .view-detail-btn:hover {
            background: #1d6a3e;
            color: rgb(255, 255, 255);
        }

        .container-custom {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .bgc-purple {
            background-color: #594ca6 !important;
        }

        .bid-evaluation-badge.bgc-orange {
            background: #cf5630;
        }

        @media screen and (max-width: 767px) {
            .bid-evaluation-badge {
                width: 250px;
            }
        }
    </style>
@endpush
@push('custom-js')
    <script>
        function fetchTenders(url = "{{ route('website.final-evaluations.index') }}") {
            let search = $('#search').val();
            let status = $('#statusFilter').val();
            let year = $('#yearFilter').val();

            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    search: search,
                    status: status,
                    year: year
                },
                success: function(data) {
                    $('#tenders-container').html(data);
                }
            });
        }

        // Live search
        $('#search').on('keyup', function() {
            fetchTenders();
        });

        // Filter changes
        $('#statusFilter, #yearFilter').on('change', function() {
            fetchTenders();
        });

        // Pagination click
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');
            fetchTenders(url);
        });
    </script>
@endpush
