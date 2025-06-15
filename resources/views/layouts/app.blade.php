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

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans antialiased bg-gray-100">
    <div
        x-data="{
            sidebarOpen: window.innerWidth >= 1024,
            isDesktop: window.innerWidth >= 1024,
        }"
        x-init="
            window.addEventListener('resize', () => {
                isDesktop = window.innerWidth >= 1024;
                if (isDesktop) {
                    sidebarOpen = true;
                } else {
                    sidebarOpen = false;
                }
            });
        "
        class="flex min-h-screen overflow-hidden"
    >
        {{-- Backdrop for mobile --}}
        <div
            x-show="sidebarOpen && !isDesktop"
            @click="sidebarOpen = false"
            class="fixed inset-0 z-30 bg-black bg-opacity-50 lg:hidden"
            x-transition:enter="transition ease-out duration-200"
            x-transition:leave="transition ease-in duration-150"
        ></div>

        {{-- Sidebar --}}
        @include('layouts.sidebar')

        {{-- Main Content --}}
        <div class="flex flex-col flex-1 overflow-hidden">
            @include('layouts.navigation')

            <main class="flex-1 p-6 overflow-y-auto">
                @yield('content')
            </main>

            @include('layouts.footer')
              @stack('scripts')
        </div>
    </div>
</body>

</html>
