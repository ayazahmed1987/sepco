@extends('frontend.layouts.master')
@section('content')
    <div class="breadcumb-area d-flex" style="background-image: url('{{ asset('frontend/assets/images/default-banner.png') }}');">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12 text-center">
                    <div class="breadcumb-content">
                        <div class="breadcumb-title">
                            <h4>Contact Us</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="contact_area inner_section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="section_title style_three style_four text-center ">
                        <h4>GET IN TOUCH</h4>
                        <h1>Contact Info</h1>
                    </div>
                    <div class="contact_main_info">

					@if(!empty($setting->phone))
                        <div class="call-do-action-info">
                            <div class="call-do-social_icon">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div class="call_info">
                                <p>Call us Anytime</p>
                                <h3>{{ $setting->phone }}</h3>
                            </div>
                        </div>
						@endif
						@if(!empty($setting->email))
                        <div class="call-do-action-info">
                            <div class="call-do-social_icon">
                                <i class="fas fa-envelope-open"></i>
                            </div>
                            <div class="call_info">
                                <p>Our Email</p>
                                <h3>{{ $setting->email }}</h3>
                            </div>
                        </div>
						@endif
						@if(!empty($setting->address))
                        <div class="call-do-action-info">
                            <div class="call-do-social_icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="call_info">
                                <p>Our Locations</p>
                                <span>{{ $setting->address }}</span>
                            </div>
                        </div>
						@endif
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="contact-form-box style_two">
                        <div class="section_title style_three style_four text-center ">
                            <h4>CONTACT US</h4>
                            <h1>Get In Touch with SEPCO</h1>
                        </div>
                        
            
            
            
            
@if ($message = Session::get('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
{{ $message }}
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@elseif ($message = Session::get('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
{{ $message }}
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif


@if (count($errors) > 0)
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
@endif
                        
                        
                        <form action="{{ route('website.contact.post') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-box">
                                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Your Name">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-box">
                                        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Phone No">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-box">
                                        <input type="email" name="email" value="{{ old('email') }}" placeholder="E-Mail Address">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-box">
                                        <input type="text" name="subject" value="{{ old('subject') }}" placeholder="Subject">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-box">
                                        <select class="w-100" name="type">
                                            <option>Select an Option</option>
                                            <option value="Query">Query</option>
                                            <option value="Feedback">Feedback</option>
                                            <option value="Complaint">Complaint</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-box message">
                                        <textarea name="message" id="message" cols="30" rows="10" placeholder="Write Message">{{ old('message') }}</textarea>
                                    </div>
                                </div>
                                <div class="contact-form">
                                    <button type="submit"><i class="far fa-thumbs-up"></i> Submit </button>
                                </div>
                            </div>
                        </form>
                        <div id="status"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="contact_shape2 dance2">
            <img src="assets/images/service_shpe2.png" alt="">
        </div>
    </section>
@endsection
@push('custom-css')
@endpush
@push('custom-js')
@endpush
