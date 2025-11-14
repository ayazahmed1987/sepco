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
@endpush
@push('custom-js')
@endpush
