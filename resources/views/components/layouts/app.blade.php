<!DOCTYPE html>
<html
    lang="{{ str_replace("_", "-", app()->getLocale()) }}"
    dir="ltr"
    data-theme="light"
    class="light">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config("app.name", "dashcode") }}</title>

    {{-- Livewire --}}
    @livewireStyles

    {{-- Vite --}}
    @vite(["resources/sass/app.scss", "resources/js/app.js", "resources/js/main.js"])
</head>

<body
    class="min-h-screen bg-base-200/50 font-sans antialiased dark:bg-base-200">
{{-- NAVBAR mobile only --}}
<x-nav sticky class="lg:hidden">
    <x-slot:brand>
        <div class="ml-5 pt-5">App</div>
    </x-slot>
    <x-slot:actions>
        <label for="main-drawer" class="mr-3 lg:hidden">
            <x-icon name="o-bars-3" class="cursor-pointer" />
        </label>
    </x-slot>
</x-nav>

{{-- MAIN --}}
<x-main>
    {{-- SIDEBAR --}}
    <x-slot:sidebar
        drawer="main-drawer"
        collapsible
        class="bg-base-100 lg:bg-inherit">
        {{-- BRAND --}}
        <div class="ml-5 pt-5">App</div>

        {{-- MENU --}}
        <x-menu activate-by-route>
            {{-- User --}}
            @if (($user = auth()->user()))
                <x-menu-separator />

                <x-list-item
                    :item="$user"
                    value="name"
                    sub-value="email"
                    no-separator
                    no-hover
                    class="!-my-2 -mx-2 rounded">
                    <x-slot:actions>
                        <x-button
                            icon="o-power"
                            class="btn-circle btn-ghost btn-xs"
                            tooltip-left="logoff"
                            no-wire-navigate
                            link="/logout" />
                    </x-slot>
                </x-list-item>

                <x-menu-separator />
            @endif

            <x-menu-item
                title="Dashboard"
                icon="o-chart-pie"
                link="/" />
            <x-menu-item
                title="Gold Stock"
                icon="o-cube"
                link="{{ route('gold-stock') }}" />
            <x-menu-item
                title="Customers"
                icon="o-user"
                link="{{ route('customers') }}" />
            <x-menu-item
                title="Orders"
                icon="o-sparkles"
                link="{{ route('orders') }}" />
            <x-menu-item
                title="Savings"
                icon="o-banknotes"
                link="#" />
            <x-menu-sub
                title="Warehouse"
                icon="o-building-storefront">
                <x-menu-item title="Brand" icon="o-swatch" link="####" />
                <x-menu-item
                    title="Types"
                    icon="m-list-bullet"
                    link="####" />
            </x-menu-sub>
            <x-menu-sub title="Settings" icon="o-cog-6-tooth">
                <x-menu-item
                    title="General"
                    icon="o-wifi"
                    link="####" />
                <x-menu-item
                    title="Account"
                    icon="o-archive-box"
                    link="####" />
            </x-menu-sub>
        </x-menu>
    </x-slot>

    {{-- The `$slot` goes here --}}
    <x-slot:content>
        {{ $slot }}
    </x-slot>
</x-main>

{{-- Toast --}}
<x-toast />
@livewireScriptConfig
</body>
</html>
