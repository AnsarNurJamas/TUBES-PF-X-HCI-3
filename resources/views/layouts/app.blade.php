<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title> {{ $pageTitle }} </title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('public/fontawesome/css/all.css')}}">

    {{-- JavaScript Jquery --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    {{-- Vite --}}
    @vite(['/resources/css/style.css'])
    @vite(['js/app.js'])
    @vite(['/resources/css/bootstrap.min.css'])
    @vite(['/resources/sass/app.scss'])

    {{-- Script Togler --}}
    <script>
        jQuery(document).ready(function($){
            $(".sidebar-toggler").click(function(e) {
            e.preventDefault();
            $(".sidebar, .content").toggleClass("open");
            });
        })
        
    </script>
</head>
<body>
@yield('content')
@include('sweetalert::alert')
@stack('scripts')
</body>
</html>
