<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'My Page' }}</title>
    <link rel="icon" href="{{ asset('images/alumni-logo.png') }}" type="image/png">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="overflow-x-hidden font-sans antialiased text-gray-900">
    <div class="min-h-screen bg-gray-100">
        @if (isset($navType) && $navType === 'admin')
            @include('layouts.admin-navigation')
        @else
            @include('layouts.alumni-navigation')
        @endif

        <!-- Page Heading -->
        @isset($header)
            <header>
                <div class="ml-64 flex-1 px-8 pt-6 mb-6">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="ml-64 flex-1 px-8 pb-4">
            {{ $slot }}
        </main>
    </div>
</body>

</html>
