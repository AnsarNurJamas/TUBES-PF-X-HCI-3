{{-- @extends('layouts.app')

@section('content') --}}
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Login</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    {{-- <link rel="stylesheet" href="/css/style.css"> --}}
    @vite(['resources/css/login.css'])
</head>

<body style="background: #000000;">
    <div class="login-dark" style="height: 695px;">
        <form  method="POST" action="{{ route('login') }}">
            @csrf
            <h2 class="sr-only">Login Form</h2>
            <div class="illustration"><img src="{{ Vite::asset('resources/images/LOGO.png') }}" style="width:150px"></div>
            <div class="form-group">
                <input class="form-control @error('email') is-invalid @enderror" id="email" type="email" name="email" placeholder="Email">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
            </div>

            <div class="form-group">
                <input class="form-control @error('password') is-invalid @enderror" id="password" type="password" name="password" placeholder="Password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Log In</button></div><a class="forgot" href="#">Forgot your email or password?</a>
            </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>
{{-- @endsection --}}
