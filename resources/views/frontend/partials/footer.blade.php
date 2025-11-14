<section class="call_area style_three">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-4 col-md-6">
			    @if(!empty($setting->phone))
				<div class="call-do-action-info">
					<div class="call-do-social_icon">
						<i class="fas fa-phone-alt"></i>
					</div>
					<div class="call_info">
					    {{--<p>Call Now</p>--}}
						<h3>{{ $setting->phone ?? '' }}</h3>
					</div>
				</div>
                @endif				
			</div>
			<div class="col-lg-4 col-md-6">
			{{--
				<div class="footer_logo">
					<a href="index.html"><img src="assets/images/logo.png" alt=""></a>
				</div>
			--}}
			
			@if(!empty($setting->email))
			   <div class="call-do-action-info">
					<div class="call-do-social_icon">
						<i class="fas fa-envelope"></i>
					</div>
					<div class="call_info">
					    {{--<p>Email Us</p>--}}
						<h3>{{ $setting->email ?? '' }}</h3>
					</div>
				</div>
			@endif
			</div>

			<div class="col-lg-4 col-md-6">
				<div class="call_social_icon">
					<ul>
					
	@if(!empty($setting->facebook))
        <li><a href="{{ $setting->facebook }}" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
    @endif
    @if(!empty($setting->twitter))
        <li><a href="{{ $setting->twitter }}" target="_blank"><i class="fab fa-twitter"></i></a></li>
    @endif
    @if(!empty($setting->linkedin))
        <li><a href="{{ $setting->linkedin }}" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
    @endif
    @if(!empty($setting->instagram))
        <li><a href="{{ $setting->instagram }}" target="_blank"><i class="fab fa-instagram"></i></a></li>
    @endif
	@if(!empty($setting->youtube))
        <li><a href="{{ $setting->youtube }}" target="_blank"><i class="fab fa-youtube"></i></a></li>
    @endif

					</ul>
				</div>
			</div>
		</div>

	</div>
</section>

<section class="footer_area style_two">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-md-6">
				<div class="footer-widget-title">
				{{--<h4>About Us</h4>--}}
				@if($setting->hasMedia('logo'))
				<div class="company-logo">              
		         <img src="{{ $setting->getFirstMediaUrl('logo', 'full') }}" alt="{{ $setting->site_name ?? '' }}" />   
                </div>
				@endif
				</div>
				<p class="footer_desc">SEPCO was established after the bifurcation of HESCO to serve its designated regions independently.</p>
				{{--
				<form action="https://formspree.io/f/myyleorq" method="POST" id="dreamit-form">
					<div class="subscribe_form">
						<input type="email" name="email" id="email" class="form-control" required="" data-error="Please enter your email" placeholder="Your E-Mail">
						<button type="submit" class="btn"><i class="bi bi-send-fill"></i></button>
					</div>
				</form>
				--}}
			</div>
			<div class="col-lg-1"></div>
			<div class="col-lg-2 col-md-6">
				<div class="footer-widget-content">
					<div class="footer-widget-title">
						<h4>Use Links</h4>
					</div>
					<div class="footer-widget-menu">
						<ul>
						   <x-frontend.simple-menu :items="$footer_menus['footer_menu_2']" />
						   {{--
							<li><a href="#"><i class="bi bi-chevron-double-right"></i> Organization</a></li>
							<li><a href="#"><i class="bi bi-chevron-double-right"></i> Downloads</a></li>
							<li><a href="#"><i class="bi bi-chevron-double-right"></i> News</a></li>
							<li><a href="#"><i class="bi bi-chevron-double-right"></i> Tenders</a></li>
							<li><a href="#"><i class="bi bi-chevron-double-right"></i> Careers</a></li>
						   --}}
						</ul>
					</div>
				</div>
			</div>
			<div class="col-lg-2 col-md-6">
				<div class="footer-widget-content">
					<div class="footer-widget-title">
						<h4>Our Services</h4>
					</div>
					<div class="footer-widget-menu">
						<ul>
						<x-frontend.simple-menu :items="$footer_menus['footer_menu_3']" />
						{{--
							<li><a href="#"><i class="bi bi-chevron-double-right"></i> Load Management</a></li>
							<li><a href="#"><i class="bi bi-chevron-double-right"></i> Billing</a></li>
							<li><a href="#"><i class="bi bi-chevron-double-right"></i> Quarterly Reports</a></li>
							<li><a href="#"><i class="bi bi-chevron-double-right"></i> Tariff Guide</a></li>
							<li><a href="#"><i class="bi bi-chevron-double-right"></i> Complaint</a></li>
						--}}
						</ul>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-6">
			@if(!empty($setting->location_map))
				<div class="footer-widget-contact">
					<div class="footer-widget-title">
						<h4>Our Locations</h4>
					</div>
					{!! $setting->location_map !!}
				</div>
				@endif
			</div>
			
		</div>
		<div class="row add-border align-items-center">
			<div class="col-md-7">
				<div class="footer-bottom-content">
				    @if(!empty($setting->copyright_text))
					<div class="footer-bottom-content-copy">
						<p>{{ $setting->copyright_text }}</p>
					</div>
					@endif
				</div>
			</div>
			<div class="col-md-5 text-right">
				<div class="footer-bottom-content">
					<div class="footer-bottom-menu">
						<ul>{{--
							<li><a href="#">FACEBOOK</a></li>
							<li><a href="#">TWITTER</a></li>
							<li><a href="#">INSTAGRAM</a></li>
						    --}}
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="footer_all_shape">
		<div class="footer_shape_one dance">
			<img src="{{ asset('frontend/assets/images/choose_rotete.png') }}" alt="">
		</div>
		<div class="footer_shape_two bounce-animate">
			<img src="{{ asset('frontend/assets/images/footer_shape.png') }}" alt="">
		</div>
	</div>
</section>























{{--
<!-- Footer -->
    <footer class="footer">
        <!-- Top Section: Social & Newsletter -->
        <div class="footer-top">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <div class="social-icons">
                            <a href="#" title="Facebook" aria-label="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" title="X (Twitter)" aria-label="X">
                                <i class="fa-brands fa-x-twitter"></i>
                            </a>
                            <a href="#" title="LinkedIn" aria-label="LinkedIn">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="newsletter-section">
                            <label for="email">Join Newsletter</label>
                            <input type="email" id="email" placeholder="Email" required>
                            <button type="submit">Send</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Divider -->
        <!-- <div class="footer-divider"></div> -->

        <!-- Main Content -->
        <div class="footer-content">
            <div class="container">
                <div class="row">
                    <!-- Company Info -->
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-column">
                            <div class="company-logo">
                                <img src="{{ asset('frontend/assets/images/sepco-logo.png') }}" alt="">
                            </div>
                            <p class="company-description">
                                SEPCO was established after the bifurcation of HESCO to serve its designated regions
                                independently.
                            </p>
                            <div class="contact-info">
                                <a href="tel:+92213545353501" class="contact-item">
                                    <i class="fas fa-phone"></i>
                                    021-35453501-7
                                </a>
                                <a href="mailto:sepco@email.com" class="contact-item">
                                    <i class="fas fa-envelope"></i>
                                    sepco@email.com
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Use Links -->
                    <div class="col-lg-2 col-md-6">
                        <div class="footer-column">
                            <h5>Use Links</h5>
                            <ul class="footer-links">
                                <li><a href="#">Organization</a></li>
                                <li><a href="#">Downloads</a></li>
                                <li><a href="#">News</a></li>
                                <li><a href="#">Additional</a></li>
                                <li><a href="#">Tenders</a></li>
                                <li><a href="#">Careers</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Our Services -->
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-column">
                            <h5>Our Services</h5>
                            <ul class="footer-links">
                                <li><a href="#">Load Management Schedule</a></li>
                                <li><a href="#">Tariff-Wise Billing & Collection</a></li>
                                <li><a href="#">Daily, Monthly & Quarterly Reports</a></li>
                                <li><a href="#">Tariff Guide</a></li>
                                <li><a href="#">Complaint Management Cell</a></li>
                                <li><a href="#">Bill Estimator</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Our Locations -->
                    <div class="col-lg-4 col-md-6">
                        <div class="footer-column">
                            <h5>Our Locations</h5>
                            <div class="map-container">
                                <div class="map-placeholder">
                                    <iframe
                                        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d113040.59929952188!2d68.88655!3d27.701266!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3935d575f61877b1%3A0x8a08a3bcc7f98987!2sSEPCO%20Headquarters%20Rd%2C%20Old%20Sukkur%2C%20Sukkur%2C%20Pakistan!5e0!3m2!1sen!2sus!4v1761218381966!5m2!1sen!2sus"
                                        width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
--}}
{{--
<section class="footer_area style_two">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="footer-widget-title">
                    <h4>About Our Company</h4>
                </div>
                <p class="footer_desc">The Sukkur Electric Power Company (SEPCO) is a vital public utility company serving the electricity needs of the Sukkur region in Pakistan. Established in July 2010, SEPCO operates under the jurisdiction of the Pakistan Electric Power Company (PEPCO) and adheres to regulations set by the National Electric Power Regulatory Authority (NEPRA).</p>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="footer-widget-content">
                    @foreach ($menus as $menu)
                        <div class="footer-widget-title">
                            <h4>{{ $menu->title }}</h4>
                        </div>
                        <div class="footer-widget-menu">
                            <ul class="footer-ul-columns">
                                <x-frontend.menu :items="$menu->children" />
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-5 col-md-6">
                <div class="footer-widget-contact">
                    <img class="img-fluid" src="{{ asset('frontend/assets/images/banner-22-v2.png') }}" alt="">

                </div>
            </div>

        </div>
        <div class="row add-border align-items-center">
            <div class="col-md-7">
                <div class="footer-bottom-content">
                    <div class="footer-bottom-content-copy">
                        <p>Copyright © 2025 SEPCO. Designed &amp; Developed by A2Z Creatorz</p>
                    </div>
                </div>
            </div>
            <div class="col-md-5 text-right">
                <div class="footer-bottom-content">
                    <div class="footer-bottom-menu">
                        <!-- <ul>
        <li><a href="#">FACEBOOK</a></li>
        <li><a href="#">TWITTER</a></li>
        <li><a href="#">INSTAGRAM</a></li>
       </ul> -->
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
--}}
<!--==================================================-->
<!-- End Footer Area Style Five-->
<!--==================================================-->


<!--==================================================-->
<!-- Start Search Popup Section -->
<!--==================================================-->
<div class="search-popup">
    <button class="close-search style-two"><span class="flaticon-multiply"><i
                class="far fa-times-circle"></i></span></button>
    <button class="close-search"><i class="bi bi-arrow-up"></i></button>
    <form action="{{ route('website.search') }}" method="GET">
        <div class="form-group">
            <input type="search" name="q" placeholder="Search Here" >
            <button type="submit"><i class="fa fa-search"></i></button>
        </div>
    </form>
</div>
<!--==================================================-->
<!-- Start Search Popup Section -->
<!--==================================================-->


<!--==================================================-->
<!-- Start Scroll Up-->
<!--==================================================-->
<div class="prgoress_indicator active-progress">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"
            style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 212.78;">
        </path>
    </svg>
</div>
<!--==================================================-->
<!-- End Scroll Up-->
<!--==================================================-->
