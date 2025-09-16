<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? '100DaysOfCode' }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased min-h-screen !overflow-x-hidden">
        <livewire:partials.header />
        <main class="flex-1">
        {{ $slot }}
        </main>
        <livewire:partials.footer />
        <!-- Scripts -->
        @livewireScripts
    </body>
</html>
