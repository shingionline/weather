<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
@yield('title_description')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="{{ mix('js/app.js') }}" defer></script>
<link href="{{ mix('css/app.css') }}" rel="stylesheet">
<link rel="icon" href="/favicon.ico" type="image/x-icon"/>
<link href="{{ asset('fontawesome/css/fontawesome.css') }}" rel="stylesheet">
<link href="{{ asset('fontawesome/css/brands.css') }}" rel="stylesheet">
<link href="{{ asset('fontawesome/css/solid.css') }}" rel="stylesheet">

</head>
<body class="d-flex flex-column min-vh-100">
<script>0</script>

<div id="app">
    @include('layouts.top-menu')
    <div>@yield('content')</div>
</div>

@include('layouts.footer')

</body>
</html>
