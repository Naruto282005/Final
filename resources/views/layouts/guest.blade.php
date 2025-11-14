<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TechForum') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <!-- Logo -->
        <div class="mb-6">
            <a href="/" class="flex items-center">
                <span class="text-3xl font-bold text-blue-600">Tech</span>
                <span class="text-3xl font-bold text-gray-800">Forum</span>
            </a>
        </div>

        <div class="w-full sm:max-w-md px-6 py-8 bg-white shadow-md rounded-lg">
            {{ $slot }}
        </div>

        <div class="mt-4 text-center text-sm text-gray-600">
            <a href="{{ route('home') }}" class="hover:text-blue-600">
                Back to Home
            </a>
        </div>
    </div>
</body>
</html>