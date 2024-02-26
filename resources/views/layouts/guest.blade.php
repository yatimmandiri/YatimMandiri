<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('images/AdminLTELogo.png') }}" />

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="/">{{ config('app.name', 'Laravel') }}</a>
        </div>
        <div class="card">
            @yield('content')
        </div>
    </div>

    <!-- AdminLTE App -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js" defer></script>
</body>

</html>