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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    @stack('specific_css')
</head>

<body>
    @yield('content')
    @stack('specific_js')
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha256-YMa+wAM6QkVyz999odX7lPRxkoYAan8suedu4k2Zur8=" crossorigin="anonymous"></script> <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            var success = "{{ session('success') }}";
            if (success) {
                console.log('success');
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: "success",
                    title: success
                });
            }
            var error = "{{ session('error') }}";
            if (error) {
                console.log('error');
                Swal.fire({
                    icon: 'error',
                    title: error,
                    text: "{{ session('error') }}",
                    toast: true, // This enables the toast mode
                    position: 'top-end', // Position of the toast
                    showConfirmButton: false, // Hides the confirm button
                    timer: 3000 // Time to show the toast in milliseconds
                });
            }
            console.log(error);
        });
    </script>
</body>

</html>
