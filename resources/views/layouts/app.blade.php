<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'APP MANTENIMIENTO') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">

    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css','resources/js/app.js'])

</head>

<body class="bg-slate-100 font-sans antialiased">

<div class="flex h-screen">

    @include('layouts.sidebar')

    <div class="flex flex-col flex-1 overflow-hidden">

        @include('layouts.navbar')

        <main class="flex-1 overflow-y-auto p-8">

            {{ $slot }}

        </main>

    </div>

</div>

</body>

</html>