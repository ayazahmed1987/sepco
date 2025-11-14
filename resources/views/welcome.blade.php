@extends('frontend.layouts.master')
@section('content')
    <section class="video-background">
        <video autoplay muted loop>
            <source src="{{ asset('frontend/assets/images/main-banner-main-video.mp4') }}" type="video/mp4">
        </video>
        <div class="overlay"></div>
        <div class="video-overlay">
            <h1 class="banner-heading wow animate__animated animate__fadeInUp">Pakistan Security Printing Corporation
                (Pvt.) Ltd</h1>
            <p class="banner-content wow animate__animated animate__fadeInUp my-pera-home">Upholding trust and security
                with decades
                of expertise, delivering innovative and
                reliable printing solutions.</p>
        </div>
    </section>
    <section class="aboutus-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h4 class="green-heading wow animate__animated animate__fadeInUp">About Us</h4>
                    <h2 class="wow animate__animated animate__fadeInUp my-h2">Trusted, Secure, Innovative <br></h2>
                    <p class="mb-4 mt-3 about-pera wow animate__animated animate__fadeInUp my-pera-home">With over 75
                        years of
                        excellence, Pakistan Security Printing
                        Corporation stands
                        as the leading
                        and sole organization of its kind in the country. Leveraging cutting-edge technology and
                        unmatched expertise, we specialize in producing a wide range of security products for Pakistan
                        and have also provided currency printing Products for international clients in the past. Our
                        commitment to security and quality ensures trusted solutions for our valued partners. </p>
                    <div class="about_btn style_two wow animate__animated animate__fadeInUp">
                        <a href="./who-we-are">Read More<span></span></a>
                    </div>
                </div>
                <div class="col-md-6 position-relative">
                    <img src="{{ asset('frontend/assets/images/shape-1.png') }}" alt=""
                        class="aboutus-background-shap">
                    <div class="d-flex justify-content-between">
                        <div class="image-one-abt" data-aos="fade-right" data-aos-offset="300"
                            data-aos-easing="ease-in-sine">
                            <img src="{{ asset('frontend/assets/images/image-one-abt.png') }}" class="img-fluid"
                                alt="Responsive image">
                        </div>
                        <div class="image-two-abt mt-5" data-aos="fade-left" data-aos-offset="300"
                            data-aos-easing="ease-in-sine">
                            <img src="{{ asset('frontend/assets/images/image-two-abt.png') }}" class="img-fluid"
                                alt="Responsive image">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <section class="blog_area">
        <div class="service-bgg">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="green-heading wow animate__animated animate__fadeInUp">What We Offer</h4>
                        <h2 class="wow animate__animated animate__fadeInUp my-h2">Delivering Innovative Solutions
                            Tailored to
                            Your Needs</h2>
                        <p class="mt-3 mb-3 wow animate__animated animate__fadeInUp my-pera-home">We offer a wide range
                            of Products
                            designed to meet the evolving demands of our clients. From concept to execution, we ensure
                            quality, efficiency, and satisfaction at every step.
                        </p>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="about_btn style_two wow animate__animated animate__fadeInUp">
                            <a href="#" target="_blank">Read More<span></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="blog_list owl-carousel serviceeee">
                    <div class="col-lg-12">
                        <div class="single-blog-box">
                            <div class="single-blog-thumb">
                                <img src="{{ asset('frontend/assets/images/banknote-home.jpg') }}" alt="Banknote/Currency">
                            </div>
                            <div class="blog-content">
                                <div class="blog-title">
                                    <h3><a href="./products/banknote-currency">Banknote/Currency</a></h3>
                                </div>
                                <div class="blog_btn">
                                    <a href="./products/banknote-currency">Read More <i
                                            class="flaticon flaticon-right-arrow"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="single-blog-box">
                            <div class="single-blog-thumb">
                                <img src="{{ asset('frontend/assets/images/prize-bound-home.jpg') }}" alt="Prize Bonds">
                            </div>
                            <div class="blog-content">

                                <div class="blog-title">
                                    <h3><a href="./products/prize-bonds">Prize Bonds</a></h3>
                                </div>
                                <div class="blog_btn">
                                    <a href="./products/prize-bonds">Read More <i
                                            class="flaticon flaticon-right-arrow"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="single-blog-box">
                            <div class="single-blog-thumb">
                                <img src="{{ asset('frontend/assets/images/passport-home.jpg') }}" alt="Passports">
                            </div>
                            <div class="blog-content">

                                <div class="blog-title">
                                    <h3><a href="./products/passports">Passports</a></h3>
                                </div>
                                <div class="blog_btn">
                                    <a href="./products/passports">Read More <i
                                            class="flaticon flaticon-right-arrow"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="single-blog-box">
                            <div class="single-blog-thumb">
                                <img src="{{ asset('frontend/assets/images/Degrees-home.jpg') }}"
                                    alt="Degrees and Transcripts">
                            </div>
                            <div class="blog-content">
                                <div class="blog-title">
                                    <h3><a href="./products/degrees-transcripts">Degrees and Transcripts</a>
                                    </h3>
                                </div>
                                <div class="blog_btn">
                                    <a href="./products/degrees-transcripts">Read More <i
                                            class="flaticon flaticon-right-arrow"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="single-blog-box">
                            <div class="single-blog-thumb">
                                <img src="{{ asset('frontend/assets/images/Bank-Cheques-home.jpg') }}" alt="Bank Cheques">
                            </div>
                            <div class="blog-content">

                                <div class="blog-title">
                                    <h3><a href="./products/bank-cheques">Bank Cheques</a></h3>
                                </div>
                                <div class="blog_btn">
                                    <a href="./products/bank-cheques">Read More <i
                                            class="flaticon flaticon-right-arrow"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="single-blog-box">
                            <div class="single-blog-thumb">
                                <img src="{{ asset('frontend/assets/images/postal-stamps-home.jpg') }}"
                                    alt="Postal Stamps">
                            </div>
                            <div class="blog-content">

                                <div class="blog-title">
                                    <h3><a href="./products/postal-stamps">Postal Stamps</a></h3>
                                </div>
                                <div class="blog_btn">
                                    <a href="./products/postal-stamps">Read More <i
                                            class="flaticon flaticon-right-arrow"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="single-blog-box">
                            <div class="single-blog-thumb">
                                <img src="{{ asset('frontend/assets/images/ser7.png') }}" alt="Real State Documents">
                            </div>
                            <div class="blog-content">

                                <div class="blog-title">
                                    <h3><a href="./products/real-state-documents">Real State Documents</a>
                                    </h3>
                                </div>
                                <div class="blog_btn">
                                    <a href="./products/real-state-documents">Read More <i
                                            class="flaticon flaticon-right-arrow"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <section class="stakeholders-new">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="green-heading wow animate__animated animate__fadeInUp">Our Stakeholders</h4>
                    <h2 class="wow animate__animated animate__fadeInUp my-h2">Building Strong Relationships with Our
                        Valued
                        Stakeholders</h2>
                </div>
                <div class="col-md-6">
                    <p class="wow animate__animated animate__fadeInUp my-pera-home">We believe in fostering long-term
                        partnerships
                        with our stakeholders based on trust,
                        transparency, and mutual respect. Their continued support plays a vital role in achieving our
                        mission and delivering excellence.</p>
                    <div class="about_btn style_two wow animate__animated animate__fadeInUp">
                        <a href="./stakeholders">View More<span></span></a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="case_study2 owl-carousel">
                    <div class="col-lg-12 pdn_0">
                        <div class="case-study-single-box style_two stakeholders-logos">
                            <div class="stakeholders-box">
                                <a href="https://www.sbp.org.pk/about/index.asp" target="_blank">
                                    <img src="{{ asset('frontend/assets/images/Stakeholders-01.png') }}" />
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 pdn_0">
                        <div class="case-study-single-box style_two stakeholders-logos">
                            <div class="stakeholders-box">
                                <a href="https://www.sbp.org.pk/sbp_bsc/index.asp" target="_blank">
                                    <img src="{{ asset('frontend/assets/images/Stakeholders-02.png') }}" />
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 pdn_0">
                        <div class="case-study-single-box style_two stakeholders-logos">
                            <div class="stakeholders-box">
                                <a href="https://nibaf.sbp.org.pk/about" target="_blank">
                                    <img src="{{ asset('frontend/assets/images/Stakeholders-03.png') }}" />
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 pdn_0">
                        <div class="case-study-single-box style_two stakeholders-logos">
                            <div class="stakeholders-box">
                                <a href="https://www.sicpa.com/offices/pakistan-karachi" target="_blank">
                                    <img src="{{ asset('frontend/assets/images/Stakeholders-05.png') }}" />
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 pdn_0">
                        <div class="case-study-single-box style_two stakeholders-logos">
                            <div class="stakeholders-box">
                                <a href="https://security-papers.com/" target="_blank">
                                    <img src="{{ asset('frontend/assets/images/Stakeholders-06.png') }}" />
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <section class="our-culture glance">
        <div class="container">
            <div class="row align-items-center pb-5">
                <div class="col-md-6">

                    <h2 class="culture-heading wow animate__ animate__fadeInUp my-h2 animated animated"
                        style="visibility: visible;">Our Culture at a Glance</h2>
                    <p class="culture-pera my-pera-home wow animate__ animate__fadeInUp animated animated"
                        style="visibility: visible;">At PSPC, we foster a
                        culture of continuous learning and
                        development, where
                        employees are
                        empowered to grow and excel.</p>
                </div>
                <div class="col-md-6 text-end">
                    <div class="about_btn style_two">
                        <a href="#" target="_blank">Read More<span></span></a>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-4 col-md-2">
                    <div class="custom-card">
                        <div class="single-blog-box">
                            <div class="single-blog-thumb">
                                <img src="{{ asset('frontend/assets/images/event-d8.jpg') }}" alt="Banknote/Currency">
                                <div class="overlay"></div>
                                <div class="text-content">
                                    <h5>Life at PSPC</h5>
                                    <p>A peek into our everyday office vibe — collaborative spaces, friendly faces, and a
                                        culture that balances productivity with positivity.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-2">
                    <div class="custom-card">
                        <div class="single-blog-box">
                            <div class="single-blog-thumb">
                                <img src="{{ asset('frontend/assets/images/event-b4.jpg') }}" alt="Banknote/Currency">
                                <div class="overlay"></div>
                                <div class="text-content">
                                    <h5>What We Believe In</h5>
                                    <p>
                                    <p>Our values aren't just words on a wall — they guide how we work, interact, and grow
                                    </p>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-2">
                    <div class="custom-card">
                        <div class="single-blog-box">
                            <div class="single-blog-thumb">
                                <img src="{{ asset('frontend/assets/images/event-b4.jpg') }}" alt="Banknote/Currency">
                                <div class="overlay"></div>
                                <div class="text-content">
                                    <h5>Moments That Matter / Celebrations/ Inclusive always</h5>
                                    <p>From birthdays to big wins, we celebrate everything together.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-2">
                    <div class="custom-card">
                        <div class="single-blog-box">
                            <div class="single-blog-thumb">
                                <img src="{{ asset('frontend/assets/images/event-b10.jpg') }}" alt="Banknote/Currency">
                                <div class="overlay"></div>
                                <div class="text-content">
                                    <h5>Moments That Matter / Celebrations/ Inclusive always</h5>
                                    <p>From birthdays to big wins, we celebrate everything together.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-2">
                    <div class="custom-card">
                        <div class="single-blog-box">
                            <div class="single-blog-thumb">
                                <img src="{{ asset('frontend/assets/images/event-g2.jpg') }}" alt="Banknote/Currency">
                                <div class="overlay"></div>
                                <div class="text-content">
                                    <h5>Growth & Learning</h5>
                                    <p>Work is just one part of our journey — growth is another.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-2">
                    <div class="custom-card">
                        <div class="single-blog-box">
                            <div class="single-blog-thumb">
                                <img src="{{ asset('frontend/assets/images/event-g12.jpg') }}" alt="Banknote/Currency">
                                <div class="overlay"></div>
                                <div class="text-content">
                                    <h5>Doing Meaningful Work</h5>
                                    <p>We’re not just building products — we’re building impact.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <section class="blog_area style_two esg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section_title text-center">
                        <h2 class="wow animate__animated animate__fadeInUp my-h2">ESG</h2>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-lg-4 col-md-6">
                    <div class="single-blog-box" data-aos="fade-down" data-aos-offset="300"
                        data-aos-easing="ease-in-sine">
                        <div class="single-blog-thumb">
                            <img src="{{ asset('frontend/assets/images/enviorment.jpg') }}" alt="">
                        </div>
                        <div class="blog-content">
                            <!--<div class="meta-blog">-->
                            <!--  <p><span class="solution">PSPC</span>02 Jan, 2025</p>-->
                            <!--</div>-->
                            <div class="blog-title">
                                <h3><a href="https://wpstaging.a2zcreatorz.com/pspc/web/esg#content-3">Environmental
                                        Stewardship</a></h3>
                            </div>
                            <div class="blog_btn">
                                <a href="https://wpstaging.a2zcreatorz.com/pspc/web/esg#content-3">Read More <i
                                        class="flaticon flaticon-right-arrow"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="single-blog-box" data-aos="fade-left" data-aos-offset="300"
                        data-aos-easing="ease-in-sine">
                        <div class="single-blog-thumb">
                            <img src="{{ asset('frontend/assets/images/responsibilty.jpg') }}" alt="">
                        </div>
                        <div class="blog-content">
                            <div class="blog-title">
                                <h3><a href="https://wpstaging.a2zcreatorz.com/pspc/web/esg#content-4">Social
                                        Responsibility</a></h3>
                            </div>
                            <div class="blog_btn">
                                <a href="https://wpstaging.a2zcreatorz.com/pspc/web/esg#content-4">Read More <i
                                        class="flaticon flaticon-right-arrow"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-blog-box" data-aos="fade-right" data-aos-offset="300"
                        data-aos-easing="ease-in-sine">
                        <div class="single-blog-thumb">
                            <img src="{{ asset('frontend/assets/images/IntaglioPrinting.png') }}" alt="">

                        </div>
                        <div class="blog-content">
                            <div class="blog-title">
                                <h3><a href="https://wpstaging.a2zcreatorz.com/pspc/web/esg#content-2">Governance &
                                        Administration</a>
                                </h3>
                            </div>
                            <div class="blog_btn">
                                <a href="https://wpstaging.a2zcreatorz.com/pspc/web/esg#content-2">Read More <i
                                        class="flaticon flaticon-right-arrow"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="certificates-area">
        <div class="service-bgg">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="green-heading wow animate__animated animate__fadeInUp">Our Certificates</h4>
                        <h2 class="wow animate__animated animate__fadeInUp my-h2">QHSE Awards and Certificates</h2>
                        <p class="mt-3 mb-3 wow animate__animated animate__fadeInUp my-pera-home">We have earned a
                            distinguished portfolio of QHSE Awards and Certifications that reflect our unwavering commitment
                            to quality, health, safety, and environmental excellence.</p>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="about_btn style_two wow animate__animated animate__fadeInUp">
                            <a href="#" target="_blank">Read More<span></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row certiii justify-content-center">
                <div class="col-md-4">
                    <img class="img-fluid" src="{{ asset('frontend/assets/images/certification-01.png') }}" />
                </div>
                <div class="col-md-4">
                    <img class="img-fluid" src="{{ asset('frontend/assets/images/certification-02.png') }}" />
                </div>

            </div>
        </div>
    </section>
@endsection
@push('custom-css')
@endpush
@push('custom-js')
@endpush
