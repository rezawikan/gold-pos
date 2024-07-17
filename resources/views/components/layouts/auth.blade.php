<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr" class="light nav-floating">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'dashcode') }}</title>

    {{-- Livewire --}}
    @livewireStyles

    {{-- Vite --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/js/main.js'])
</head>

<body class="min-h-screen font-sans antialiased bg-base-200/50 dark:bg-base-200">
{{-- MAIN --}}
<x-main>

    {{-- The `$slot` goes here --}}
    <x-slot:content>
        {{ $slot }}
    </x-slot:content>
</x-main>

{{-- Toast --}}
<x-toast/>
@livewireScriptConfig

</body>

</html>