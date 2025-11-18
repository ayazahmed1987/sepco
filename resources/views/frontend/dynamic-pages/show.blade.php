@extends('frontend.layouts.master')
@section('content')
@if(isset($page->title))
<div class="breadcumb-area d-flex" style="background-image: url('{{ !empty($page->image) 
    ? asset(Storage::url($page->image)) 
    : asset('frontend/assets/images/default-banner.png') }}');">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-12 text-center">
				<div class="breadcumb-content">
					<div class="breadcumb-title">
						<h4>{{ $page->title ?? '' }}</h4>
					</div>
					<ul>
						<li><a href="#"><i class="bi bi-house-door-fill"></i> Home</a></li>
						<li class="rotates"><i class="bi bi-slash-lg"></i>
						{{ $page->title ?? '' }}
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
@endif
@if(isset($page->description))
@php $desc = trim($page->description ?? ''); @endphp
@if ($desc === '' || $desc === '.' || $desc === 'no' || $desc === 'null'|| $desc === 'none')
@else
<section class="py-5">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="section_title text-center">
				{!! $page->description ?? '' !!}
				</div>
			</div>		
		</div>
	</div>
</section>
@endif
@endif


    @foreach ($renderedComponents as $html)
        {!! $html !!}
    @endforeach
	
{{-- @dump($renderedCustomposts['hero_slider']) --}}
@foreach ($renderedCustomposts as $renderedCustompost)
	@if($renderedCustompost)
	  {!! $renderedCustompost !!}
	@endif
@endforeach
	
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
            border: 1px solid #0E2458 !important;
            background: #0E245817;
            color: #000000;
        }

        a.btn.btn-primary.btn-color:hover {

            background: #0E2458;
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
            background: linear-gradient(135deg, #2c5aa0, #0E2458);
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
            background: #0E2458;
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
            border: 1px solid #0E2458 !important;
            background: #0E245817;
            color: #000000;
            padding: 8px 20px;
            border-radius: 4px;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }

        .view-detail-btn:hover {
            background: #0E2458;
            color: rgb(255, 255, 255);
        }

        .container-custom {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .bgc-purple {
            background-color: #e22e3a !important;
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
@endpush
