<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>SEPCO (Sukkur Electric Power Company)</title>
    <link rel="icon" href="{{ asset('backend/assets/images/favicon.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="SEPCO">
    <meta name="author" content="SEPCO">
    <meta name="description" content="SEPCO (Sukkur Electric Power Company)">
    <meta name="keywords" content="SEPCO (Sukkur Electric Power Company)">
    @include('backend.partials.head')
    @stack('specific_css')
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        @include('backend.partials.header')
        @include('backend.partials.sidebar')
        <main class="app-main">
            @yield('content')
        </main>
        @include('backend.partials.footer')
    </div>
    @include('backend.partials.scripts')
    @stack('specific_js')
</body>

</html>
