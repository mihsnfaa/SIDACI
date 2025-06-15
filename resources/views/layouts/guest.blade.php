<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', ' Sistem Informasi Data Dinkes Cimahi')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logocimahi.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex flex-col min-h-screen font-sans antialiased bg-gray-200">

    {{-- Main content area --}}
    <main class="flex items-center justify-center flex-grow">
        @yield('content')

        {{-- Flash messages --}}
    </main>

    {{-- Footer --}}
    @include('layouts.footer')

</body>
</html>
