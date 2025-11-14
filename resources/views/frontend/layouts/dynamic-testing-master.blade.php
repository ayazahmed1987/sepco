<!doctype html>
<html lang="en-US">

<head>
    @include('frontend.partials.meta-files')
    @include('frontend.partials.css')
    @stack('custom-css')
</head>

<body>
    @include('frontend.partials.dynamic-header')
    <main>
        @yield('content')
    </main>
    @include('frontend.partials.footer')
    @include('frontend.partials.scripts')
    @stack('custom-js')
</body>

</html>
