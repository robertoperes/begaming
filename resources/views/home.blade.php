<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>BeGaming</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-token" content="{{ auth()->user()->api_token }}">
</head>
<body>
<div class="container">
    <div id="app"></div>
</div>
</body>
<script src="{{ asset('js/manifest.js') }}"></script>
<script src="{{ asset('js/vendor.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
</html>
