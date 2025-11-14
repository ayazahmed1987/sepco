<div class="consalt-header-area style_two" id="sticky-header">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-1 p-0">
                <div class="header-logo my-logo">
                    <a href="index"><img width="110" src="{{ asset('frontend/assets/images/sepco-logo.png') }}"
                            alt="logo"></a>
                </div>
                <div class="header-logo my-hide-logo">
                    <a href="index"><img width="90" src="{{ asset('frontend/assets/images/sepco-logo.png') }}"
                            alt="logo"></a>
                </div>
            </div>
            <div class="col-md-10">
                <div class="text-center">
                    <h3 class="pspc-textt">Sukkur Electric Power Company (SEPCO)</h3>
                </div>
                <nav class="navbar">
                    <ul class="nav-list">
                        <x-frontend.menu :items="$menus" />
                    </ul>
                </nav>
            </div>
            <div class="col-md-1 p-0">
                <div class="consalt_header-right">
                    <div class="header-search-button search-box-outer">
                        <a href="#"><i class="fas fa-search"></i></a>
                    </div>
                    <div class="sidebar-btn">
                        <div class="nav-btn navSidebar-button"><span><i class="bi bi-filter-left"></i></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--==================================================-->
<!-- End Header Area -->
<!--==================================================-->

<!--========= Start Mobile Memu========== -->

<div class="mobile-menu-area d-lg-none" id="mobileMenu">
    <img class="mobile-logo" src="{{ asset('frontend/assets/images/sepco-logo.png') }}" />
    <div class="mobile-menu">

        <nav class="header-menu">
            <ul class="nav_scroll">
                <x-frontend.mobile-menu :items="$menus" />
            </ul>
        </nav>
    </div>
</div>
<!--========= End Mobile Memu========== -->

<!-- Sidebar Cart Item -->
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
                <!-- Sidebar Info Content -->
                <div class="sidebar-info-contents">
                    <div class="content-inner">
                        <div class="nav-logo">
                            <a href="#"><img width="100" src="{{ asset('frontend/assets/images/sepco-logo.png') }}"
                                    alt="sid img"></a>
                        </div>

                        <div class="contact-info">
                            <h2>Contact Info</h2>
                            <ul class="list-style-one">
                                <li><i class="bi bi-phone"></i>0800-63726</li>
                                <li><i class="bi bi-envelope"></i>info@sepco.com.pk</li>
                                <li><i class="bi bi-map"></i>MEPCO Complex near Chowk Rasheedabad, Khanewal Road, Multan, Pakistan</li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
