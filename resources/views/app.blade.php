<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">
        <link rel="manifest" href="/manifest.webmanifest">
        <meta name="theme-color" content="#ffffff">
        @routes
        @vite(['resources/vue/app.ts'])
        <x-inertia::head />
    </head>
    <body class="antialiased h-full text-sm bg-[#F5F7FA] dark:bg-stone-800">
        <x-inertia::app />
    </body>
</html>
