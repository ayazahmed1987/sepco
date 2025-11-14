<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"
    integrity="sha512-Eak/29OTpb36LLo2r47IpVzPBLXnAMPAVypbSZiZ4Qkf8p/7S/XRG5xp7OKWPPYfJT6metI+IORkR5G8F900+g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    new WOW().init();
    AOS.init();

    // Lightbox functionality
    document.querySelectorAll('.gallery img').forEach(image => {
        image.addEventListener('click', function() {
            const lightboxImage = document.getElementById('lightboxImage');
            lightboxImage.src = this.getAttribute('data-bs-image');
        });
    });
</script>

<script src="{{ asset('frontend/assets/js/jquery-3.6.2.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/popper.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/waypoints.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/wow.js') }}"></script>
<script src="{{ asset('frontend/assets/js/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/venobox.js') }}"></script>
<script src="{{ asset('frontend/assets/js/animated-text.js') }}"></script>
<script src="{{ asset('frontend/assets/js/venobox.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/jquery.meanmenu.js') }}"></script>
<script src="{{ asset('frontend/assets/js/jquery.scrollUp.js') }}"></script>
<script src="{{ asset('frontend/assets/js/theme.js') }}"></script>
<script src="{{ asset('frontend/assets/js/jquery.barfiller.js') }}"></script>
<script src="{{ asset('frontend/assets/js/swiper-bundle.js') }}"></script>
<script src="{{ asset('frontend/assets/js/magnific-popup-js') }}"></script>
<script src="{{ asset('frontend/assets/js/custom.js') }}"></script>
<script src="{{ asset('frontend/assets/js/service.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous">
</script>
