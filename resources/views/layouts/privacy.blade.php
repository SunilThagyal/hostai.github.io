<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title> @yield('title', config('app.name', 'Teeqode'))</title>
    <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}">
    <link rel="stylesheet" href=" {{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-social.css') }}">
    <link rel="stylesheet" href=" {{ asset('assets/css/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    <link rel='shortcut icon' type='image/x-icon' href=" {{ asset('assets/img/teeqode.png') }}" />
    <script>
        const APP_URL = '{{ url('') }}';
    </script>
    @stack('styles')
</head>

<body>
    <div class="loader"></div>
    <div id="app">
        @yield('content')
    </div>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src=" {{ asset('assets/js/jquery.pwstrength.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('assets/js/auth-register.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    @stack('scripts')
    @yield('modal')
</body>
</html>
