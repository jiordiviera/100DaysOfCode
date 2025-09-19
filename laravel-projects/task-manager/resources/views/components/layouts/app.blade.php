<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Suivez votre progression du défi 100 Days of Code en gérant vos projets et tâches quotidiennes.">
        <meta name="keywords" content="100DaysOfCode, programmation, codage, défi de codage, développement">

        <title>{{ $title ?? config('app.name', '100DaysOfCode') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" href="/favicon.svg">
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700|inter:300,400,500,600,700" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased min-h-screen !overflow-x-hidden flex flex-col bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100">
        <livewire:partials.header />

        <main class="flex-1 w-full">
            {{ $slot }}
        </main>

        <livewire:partials.footer />

        <!-- Scripts -->
        @livewireScripts
    </body>
</html>
