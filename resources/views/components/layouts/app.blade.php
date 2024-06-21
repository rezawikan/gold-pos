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

<body class="font-inter dashcode-app bg-black" id="body_class">
<div class="app-wrapper">

    <!-- BEGIN: Sidebar Navigation -->
    <x-sidebar-menu/>
    <!-- End: Sidebar -->

    <!-- BEGIN: Settings -->
    <x-header.settings/>
    <!-- End: Settings -->

    <div class="flex flex-col justify-between min-h-screen">
        <div>
            <!-- BEGIN: header -->
            <x-layouts.header/>
            <!-- BEGIN: header -->

            <div class="content-wrapper transition-all duration-150 ltr:ml-0 xl:ltr:ml-[248px] rtl:mr-0 xl:rtl:mr-[248px]"
                 id="content_wrapper">
                <div class="page-content">
                    <div class="transition-all duration-150 container-fluid" id="page_layout">
                        <main id="content_layout">
                            <!-- Page Content -->
                            {{ $slot }}
                        </main>
                    </div>
                </div>
            </div>
        </div>

        <!-- BEGIN: footer -->
        <x-layouts.footer/>
        <!-- BEGIN: footer -->

    </div>
</div>

<script
        type="text/javascript"
        src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/index.min.js"></script>

@livewireScriptConfig

</body>

</html>