<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'dashcode') }}</title>

    {{-- Livewire --}}
    @livewireStyles

    {{-- Vite --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>

<div class="loginwrapper">
    <div class="lg-inner-column">
        <div class="left-column relative z-[1]">
            <div class="max-w-[520px] pt-20 ltr:pl-20 rtl:pr-20">
                <!-- APPLICATION LOGO -->
                <div class="mb-6">
                    <x-application-logo/>
                </div>
                <h4>
                    {{ __('Unlock your project') }}
                    <span class="text-slate-800 dark:text-slate-400 font-bold">
                                {{ __('Performance') }}
                            </span>
                </h4>
            </div>
            <div class="absolute left-0 2xl:bottom-[-160px] bottom-[-130px] h-full w-full z-[-1]">
                <img class="h-full w-full object-contain"
                     src="{{ Vite::asset('resources/assets/images/guest-background.svg') }}"
                     alt="image">
            </div>
        </div>
        <div class="right-column  relative">
            <div class="inner-content h-full flex flex-col bg-white dark:bg-slate-800">
                {{ $slot }}
                <div class="auth-footer text-center">
                    {{ __('Copyright') }}
                    <script>
                        document.write(new Date().getFullYear())
                    </script>
                    , <a href="#">{{ __('Dashcode') }}</a>
                    {{ __('All Rights Reserved.') }}
                </div>
            </div>
        </div>
    </div>
</div>

<script
        type="text/javascript"
        src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/index.min.js"></script>

@livewireScriptConfig

</body>

</html>
