@extends('frontend.layouts.master')
@section('content')

@if(isset($renderedCustomposts['hero_slider']))
{!! $renderedCustomposts['hero_slider'] !!}
@endif


	{{-- @dump($renderedCustomposts) --}}	
	
	@foreach ($renderedComponents as $html)
        {!! $html !!}
    @endforeach











{{--
<section class="tab_slider home_five section_title pb-13" style="background: url({{asset('frontend/assets/images/accordion-background-img.png')}});">
    <div class="container">
	<div class="row my-5">
          <div class="col-md-6">
            <h4>What’s New</h4>
            <h2>Explore the Latest from Sukkur Electric Power Company</h2>
          </div>
        </div>
	
      <div class="row">
        <div class="col-md-3">

          <!-- Vertical Tabs -->
          <ul class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <li class="nav-item">
              <a class="nav-link active" id="tab-1" data-bs-toggle="pill" href="#content-1" role="tab"
                aria-controls="content-1" aria-selected="true">Orders & Notifications</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="tab-2" data-bs-toggle="pill" href="#content-2" role="tab"
                aria-controls="content-2" aria-selected="false">Theft FIRs</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="tab-3" data-bs-toggle="pill" href="#content-3" role="tab"
                aria-controls="content-3" aria-selected="false">Careers</a>
            </li>
          </ul>
        </div>
        <div class="col-md-9">
          <!-- Tab Content -->
          <div class="tab-content" id="v-pills-tabContent">
            <!-- Tab 1 Content -->
            <div class="tab-pane fade show active" id="content-1" role="tabpanel" aria-labelledby="tab-1">
              <div class="row">
                <div class="col-md-12">
                  <div class="container">
				  <div class="row">
				  <div class="tab_slider_list owl-carousel owl-loaded owl-drag">
					<div class="owl-item">
						<div class="col-lg-12">
							<div class="single-blog-box">
								<div class="blog-content">
								  <div class="meta-blog"><p><span class="solution">2025</span></p></div>
								  <div class="blog-title"><h3><a href="#">Orders & Notifications</a></h3></div>
								  <div class="text-content"><p class="pt-10">Closing Date 02 Jan, 2025</p></div>
								  <div class="consalt_btn style_two five"><a href="#">Download</a></div>
								</div>
							</div>
						</div>
					</div>
					<div class="owl-item">
						<div class="col-lg-12">
							<div class="single-blog-box">
								<div class="blog-content">
								  <div class="meta-blog"><p><span class="solution">2025</span></p></div>
								  <div class="blog-title"><h3><a href="#">Orders & Notifications</a></h3></div>
								  <div class="text-content"><p class="pt-10">Closing Date 02 Jan, 2025</p></div>
								  <div class="consalt_btn style_two five"><a href="#">Download</a></div>
								</div>
							</div>
						</div>
					</div>
					<div class="owl-item">
						<div class="col-lg-12">
							<div class="single-blog-box">
								<div class="blog-content">
								  <div class="meta-blog"><p><span class="solution">2025</span></p></div>
								  <div class="blog-title"><h3><a href="#">Orders & Notifications</a></h3></div>
								  <div class="text-content"><p class="pt-10">Closing Date 02 Jan, 2025</p></div>
								  <div class="consalt_btn style_two five"><a href="#">Download</a></div>
								</div>
							</div>
						</div>
					</div>
					<div class="owl-item">
						<div class="col-lg-12">
							<div class="single-blog-box">
								<div class="blog-content">
								  <div class="meta-blog"><p><span class="solution">2025</span></p></div>
								  <div class="blog-title"><h3><a href="#">Orders & Notifications</a></h3></div>
								  <div class="text-content"><p class="pt-10">Closing Date 02 Jan, 2025</p></div>
								  <div class="consalt_btn style_two five"><a href="#">Download</a></div>
								</div>
							</div>
						</div>
					</div>
					</div>
      </div>
	  </div>
                </div>
              </div>

            </div>
            <!-- Tab 2 Content -->
            <div class="tab-pane fade" id="content-2" role="tabpanel" aria-labelledby="tab-2">
<div class="row">
                <div class="col-md-12">
                  <div class="container">
				  <div class="row">
				  <div class="tab_slider_list owl-carousel owl-loaded owl-drag">
					<div class="owl-item">
						<div class="col-lg-12">
							<div class="single-blog-box">
								<div class="blog-content">
								  <div class="meta-blog"><p><span class="solution">2025</span></p></div>
								  <div class="blog-title"><h3><a href="#">Theft FIRs</a></h3></div>
								  <div class="text-content"><p class="pt-10">Closing Date 02 Jan, 2025</p></div>
								  <div class="consalt_btn style_two five"><a href="#">Download</a></div>
								</div>
							</div>
						</div>
					</div>
					<div class="owl-item">
						<div class="col-lg-12">
							<div class="single-blog-box">
								<div class="blog-content">
								  <div class="meta-blog"><p><span class="solution">2025</span></p></div>
								  <div class="blog-title"><h3><a href="#">Theft FIRs</a></h3></div>
								  <div class="text-content"><p class="pt-10">Closing Date 02 Jan, 2025</p></div>
								  <div class="consalt_btn style_two five"><a href="#">Download</a></div>
								</div>
							</div>
						</div>
					</div>
					<div class="owl-item">
						<div class="col-lg-12">
							<div class="single-blog-box">
								<div class="blog-content">
								  <div class="meta-blog"><p><span class="solution">2025</span></p></div>
								  <div class="blog-title"><h3><a href="#">Theft FIRs</a></h3></div>
								  <div class="text-content"><p class="pt-10">Closing Date 02 Jan, 2025</p></div>
								  <div class="consalt_btn style_two five"><a href="#">Download</a></div>
								</div>
							</div>
						</div>
					</div>
					<div class="owl-item">
						<div class="col-lg-12">
							<div class="single-blog-box">
								<div class="blog-content">
								  <div class="meta-blog"><p><span class="solution">2025</span></p></div>
								  <div class="blog-title"><h3><a href="#">Theft FIRs</a></h3></div>
								  <div class="text-content"><p class="pt-10">Closing Date 02 Jan, 2025</p></div>
								  <div class="consalt_btn style_two five"><a href="#">Download</a></div>
								</div>
							</div>
						</div>
					</div>
					</div>
      </div>
	  </div>
                </div>
              </div>
            </div>
            <!-- Tab 3 Content -->
            <div class="tab-pane fade" id="content-3" role="tabpanel" aria-labelledby="tab-3">
<div class="row">
                <div class="col-md-12">
                  <div class="container">
				  <div class="row">
				  <div class="tab_slider_list owl-carousel owl-loaded owl-drag">
					<div class="owl-item">
						<div class="col-lg-12">
							<div class="single-blog-box">
								<div class="blog-content">
								  <div class="meta-blog"><p><span class="solution">2025</span></p></div>
								  <div class="blog-title"><h3><a href="#">Career</a></h3></div>
								  <div class="text-content"><p class="pt-10">Closing Date 02 Jan, 2025</p></div>
								  <div class="consalt_btn style_two five"><a href="#">Download</a></div>
								</div>
							</div>
						</div>
					</div>
					<div class="owl-item">
						<div class="col-lg-12">
							<div class="single-blog-box">
								<div class="blog-content">
								  <div class="meta-blog"><p><span class="solution">2025</span></p></div>
								  <div class="blog-title"><h3><a href="#">Career</a></h3></div>
								  <div class="text-content"><p class="pt-10">Closing Date 02 Jan, 2025</p></div>
								  <div class="consalt_btn style_two five"><a href="#">Download</a></div>
								</div>
							</div>
						</div>
					</div>
					<div class="owl-item">
						<div class="col-lg-12">
							<div class="single-blog-box">
								<div class="blog-content">
								  <div class="meta-blog"><p><span class="solution">2025</span></p></div>
								  <div class="blog-title"><h3><a href="#">Career</a></h3></div>
								  <div class="text-content"><p class="pt-10">Closing Date 02 Jan, 2025</p></div>
								  <div class="consalt_btn style_two five"><a href="#">Download</a></div>
								</div>
							</div>
						</div>
					</div>
					<div class="owl-item">
						<div class="col-lg-12">
							<div class="single-blog-box">
								<div class="blog-content">
								  <div class="meta-blog"><p><span class="solution">2025</span></p></div>
								  <div class="blog-title"><h3><a href="#">Career</a></h3></div>
								  <div class="text-content"><p class="pt-10">Closing Date 02 Jan, 2025</p></div>
								  <div class="consalt_btn style_two five"><a href="#">Download</a></div>
								</div>
							</div>
						</div>
					</div>
					</div>
      </div>
	  </div>
                </div>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </section>
--}}
 

@if(isset($renderedCustomposts['teams']))
{!! $renderedCustomposts['teams'] !!} 
@endif
	
@if(isset($renderedCustomposts['news_events']))
{!! $renderedCustomposts['news_events'] !!} 
@endif
	
@endsection
@push('custom-css')
@endpush
@push('custom-js')
@endpush



