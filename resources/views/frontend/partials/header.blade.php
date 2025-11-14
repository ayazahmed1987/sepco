@if(isset($renderedCustomposts['schedules']))
{!! $renderedCustomposts['schedules'] !!}
@endif

<!-- START HEADER AREA -->
<div class="consalt-header-area style_two" id="sticky-header">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-1 p-0">
			
			    @if($setting->hasMedia('logo'))
                <div class="header-logo my-logo">
                    <a href="{{ url('/') }}"><img width="110" src="{{ $setting->getFirstMediaUrl('logo', 'full') }}" alt="{{ $setting->site_name ?? '' }}"></a>
                </div>
                <div class="header-logo my-hide-logo">
                    <a href="{{ url('/') }}"><img width="90" src="{{ $setting->getFirstMediaUrl('logo', 'full') }}" alt="{{ $setting->site_name ?? '' }}"></a>
                </div>
				@endif
            </div>
            <div class="col-md-10">
			{{--
				<div class="text-center">
                    <h3 class="pspc-textt">Sukkur Electric Power Company (SEPCO)</h3>
                </div>
			--}}
                <nav class="navbar">
                    <ul class="nav-list">
                        <x-frontend.menu :items="$menus" />
                    </ul>
                </nav>
            </div>
            <div class="col-md-1 p-0">
                <div class="consalt_header-right">
                     <div class="header-search-button search-box-outer">
                        <a><i class="fas fa-search"></i></a>
                    </div> 
                    <div class="sidebar-btn">
                        <div class="nav-btn navSidebar-button"><span><i class="bi bi-filter-left"></i></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END HEADER AREA -->

<!-- START MOBILE MENU -->
<div class="mobile-menu-area d-lg-none" id="mobileMenu">
    @if($setting->hasMedia('logo'))
		<img class="mobile-logo" src="{{ $setting->getFirstMediaUrl('logo', 'full') }}" alt="{{ $setting->site_name ?? '' }}" />
	@endif
    <div class="mobile-menu">

        <nav class="header-menu">
            <ul class="nav_scroll">
                <x-frontend.mobile-menu :items="$menus" />
            </ul>
        </nav>
    </div>
</div>
<!-- End MOBILE MENU -->

<!-- SIDEBAR CART ITEM -->
<div class="xs-sidebar-group info-group">
    <div class="xs-overlay xs-bg-black"></div>
    <div class="xs-sidebar-widget">
        <div class="sidebar-widget-container">
            <div class="widget-heading">
                <a href="#" class="close-side-widget">
                    <i class="far fa-times-circle"></i>
                </a>
            </div>
            <div class="sidebar-textwidget">
                <div class="sidebar-info-contents">
                    <div class="content-inner">
					@if($setting->hasMedia('logo'))
                        <div class="nav-logo">
                            <a href="#"><img width="100" src="{{ $setting->getFirstMediaUrl('logo', 'full') }}" alt="{{ $setting->site_name ?? '' }}"></a>
                        </div>
						@endif
                        <div class="contact-info">
                            <h2>Contact Info Test 14-11-2025 2025</h2>
                            <ul class="list-style-one">
                                @if(!empty($setting->phone))<li><i class="bi bi-phone"></i>{{ $setting->phone }}</li>@endif
                                @if(!empty($setting->email))<li><i class="bi bi-envelope"></i>{{ $setting->email }}</li>@endif
                                @if(!empty($setting->address))<li><i class="bi bi-map"></i>{{ $setting->address }}</li>@endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End SIDEBAR CART ITEM -->
