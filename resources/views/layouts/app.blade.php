<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-gray-100">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="/img/favicon.png">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="{{ asset('js/jquery.min.js') }}"></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen">
            <?php
            $staffRight = Auth::user()->staff_right;
            $kitchenWatchRight = Auth::user()->kitchen_watch_right;
            $kitchenEditRight = Auth::user()->kitchen_edit_right;
            $stocktakingRight = Auth::user()->stocktaking_right;
            $warehouseRight = Auth::user()->warehouse_right;
            $orderRight = Auth::user()->order_right;
            ?>
            @include('layouts.navigation')

            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                    {{ $header }}
                </div>
            </header>

            <!-- Page Content -->
            <main>
                @include('layouts.messages')
                {{ $slot }}
            </main>
        </div>

        <script src="/js/message.custom.js"></script>
        @stack('js_after')

        @yield('js_after')
    </body>
</html>
