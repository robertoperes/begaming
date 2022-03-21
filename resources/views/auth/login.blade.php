<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>BeGaming - Login</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>


<div class="app">
    <div class="div-center">
        <div class="content">
            <div class="text-center">
                <img src="/images/logo.svg" alt="Logo BeGaming" width="200"/>
            </div>
            <hr>
            <div class="text-center">
                <div>Para acessar é necessário utilizar a sua conta Before.</div>
                <a href="{{route('login-google')}}" class="btn btn-light">
                    <img src="/images/google.svg" width="50" alt="Logo Google"/>Logar usando sua conta Google</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<style>
    .app {
        background: #333333;
        width: 100%;
        position: absolute;
        top: 0;
        bottom: 0;
    }

    .div-center {
        width: 400px;
        height: 400px;
        background-color: #fff;
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        margin: auto;
        max-width: 100%;
        max-height: 100%;
        overflow: auto;
        padding: 1em 2em;
        border-bottom: 2px solid #ccc;
        display: table;
    }

    div.content {
        display: table-cell;
        vertical-align: middle;
    }
</style>