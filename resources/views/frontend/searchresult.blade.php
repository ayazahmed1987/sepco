@extends('frontend.layouts.master')
@section('content')
    <div class="breadcumb-area d-flex" style="background-image: url('{{ asset('frontend/assets/images/slider-2.png') }}');">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12 text-center">
                    <div class="breadcumb-content">
                        <div class="breadcumb-title">
                            @if(!empty($query ?? request('q')))
                            <h4>Search results for "{{ e($query ?? request('q')) }}"</h4><br />
						    <h4>We have found {{ $results->count() }} Results for you</h4>
							@else
							<h4>We have found 0 Results for you</h4>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="contact_area inner_section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    
					
					
					
					
					


<form action="{{ route('website.search') }}" method="GET">
        <div class="row">
            <div class="col-lg-8"><input class="form-control" type="search" name="q" value="{{ request('q') ?? '' }}" placeholder="Search Here" ></div>
            <div class="col-lg-4 btn-group"><button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button></div>
        </div>
</form>




@if(!empty($query ?? request('q')))
    <h2 class="my-4">Search results for "{{ e($query ?? request('q')) }}"</h2>
	<ul>
	@forelse ($results as $item)
	    {{--
		<div style="margin-bottom: 1rem;">
			<h4><a href="{{ $item->url }}">{{ $item->title }}</a></h4>
				<small>{{ ucfirst($item->type) }}</small>
			<p>{{ Str::limit(strip_tags($item->description), 90) }}</p>
		</div>
		--}}
		
		<li>
                <a href="{{ $item->url }}" class="d-flex align-items-center justify-content-between p-2 my-3 border hover:border-blue-500 rounded">
                    <div class="d-flex flex-column gap-1">
                        <div class="d-flex align-items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text w-5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg><span>{{ $item->title }} (<small>{{ ucfirst($item->type) }}</small>)</span></div>
                        <span class="text-black-50 mx-4 text-sm font-light break-all">{{ $item->url }}</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-external-link w-5 text-blue-500 lg:block md:block sm:block hidden"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                </a>
        </li>
	@empty
	</ul>


			<div class="row">
				<div class="col-lg-12">
				<div style="margin:30px 0px; background:#2c5aa0; border-radius:20px; padding:15px;">
					<div class="section_title style_two">
						<h1>Sorry </h1>
						<h4>We can't find, what you are looking for</h4>
					</div>
					</div>
				</div>
				
			</div>

	@endforelse
		
@else
	
@endif



	








					
					
					
                </div>
                
            </div>
        </div>

    </section>
@endsection
@push('custom-css')
@endpush
@push('custom-js')
@endpush
