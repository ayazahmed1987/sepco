@extends('frontend.layouts.master')
@section('content')
<div class="breadcumb-area d-flex" style="background-image: url('{{ !empty($post->fields_data['banner']) 
    ? asset(Storage::url($post->fields_data['banner'])) 
    : asset('frontend/assets/images/default-banner.png') }}');">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-12 text-center">
				<div class="breadcumb-content">
					<div class="breadcumb-title">
						<h4>{{ $post->custompost->title ?? '' }}</h4>
					</div>
					<ul>
						<li><a href="#"><i class="bi bi-house-door-fill"></i> Home</a></li>
						<li class="rotates"><i class="bi bi-slash-lg"></i>
						@if($post->custompost->table_name == 'news_events')
						{{$post->fields_data['title']}}
					    @endif
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

@if($post->custompost->table_name == 'news_events')
<section class="portfolio_details">
	<div class="container">
		<div class="port_main style_two">
			<div class="row">
				<div class="col-lg-12">
					<div class="port_details_content style_two">
					<h2 class="pb-15">{{$post->fields_data['title'] ?? '' }}</h2>
                    {!! $post->fields_data['description'] ?? '' !!}
					</div>
				</div>
			</div>
			
<div class="row">
@if(is_array($post->fields_data['image'] ?? null))
			<div class="col-lg-12"><span style="border-top:1px solid #ddd; display:block; padding:10px 0px;"></span></div>	
		
            @foreach($post->fields_data['image'] as $img)
		      <div class="col-lg-4">
                <img src="{{ asset('storage/'.$img) }}" width="100%" alt="{{ $post->custompost->title ?? '' }}">
			  </div>
            @endforeach
			@endif
</div>
			
			
			
			
		</div>
	</div>
</section>
@endif








@if($post->custompost->table_name != 'news_events' && $post->custompost->table_name != 'teams')			
@if($post->fields_data)
<table class="table table-sm">
<tbody>								
@foreach($post->fields_data as $kkey => $value)
<tr>
{{-- ucfirst($kkey) --}}																			
    @switch($kkey)
            @case('image')
			<td>
			@if(is_array($value))
            @foreach($value as $img)
                <img src="{{ asset('storage/'.$img) }}" width="200">
            @endforeach
			@else
			<img src="{{ asset('storage/'.$value) }}" width="200">							
			@endif
			</td>
            @break

            @case('banner')
            <td><img src="{{ asset('storage/'.$value) }}" width="100"></td>
            @break
            @case('description')
			<td>{!! $value !!}</td>
			@break
			@case('content')
			<td>{!! $value !!}</td>
			@break
             @default
			<td>{{ $value }}</td>
    @endswitch
</tr>
@endforeach
</tbody>
</table>
@else
Not Data
@endif
@endif









			
			
										
			



@if($post->custompost->table_name == 'teams')
<section class="teams py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 col-md-12">
                    <div class="">
                        <img src="{{ asset('storage/'.$post->fields_data['image']) }}" class="img-fluid w-100" alt="{{ $post->custompost->name ?? '' }}">
                    </div>
                </div>
                <div class="col-lg-8 col-md-12">
                    <h1>{{$post->fields_data['designation'] ?? '' }} - {{$post->fields_data['name'] ?? '' }}</h1>
                    <div class="choose_right scroll-box">
                        <div class="section_title pb-13">
                            <p>{!! $post->fields_data['content'] ?? '' !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif





{{-- @dump($post) --}}
	
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
            scrollbar-color: #0E2458 #eee;
        }
    </style>
@endpush
@push('custom-js')
@endpush
