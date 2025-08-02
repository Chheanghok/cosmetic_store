<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div x-data="{ isSidebarOpen: false }" class="min-h-screen bg-gray-100">

            @if(Auth::check() && Auth::user()->is_admin)
                <aside 
                    class="fixed top-0 left-0 w-64 h-screen bg-white shadow-md z-20 pt-16 transform transition-transform duration-300 ease-in-out"
                    :class="{'translate-x-0': isSidebarOpen, '-translate-x-full': !isSidebarOpen}"
                    @click.away="isSidebarOpen = false"
                    x-show="isSidebarOpen"
                    x-cloak
                >
                    <div class="py-4 px-2">
                        <h2 class="text-lg font-semibold text-gray-700 px-4">Admin Menu</h2>
                        <div class="mt-4">
                            <x-nav-link-vertical :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                                {{ __('Admin Dashboard') }}
                            </x-nav-link-vertical>

                            <x-nav-link-vertical :href="route('products.index')" :active="request()->routeIs('products.*')">
                                {{ __('Products') }}
                            </x-nav-link-vertical>

                            <x-nav-link-vertical :href="route('categories.index')" :active="request()->routeIs('categories.*')">
                                {{ __('Categories') }}
                            </x-nav-link-vertical>

                            <x-nav-link-vertical :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.index')">
                                {{ __('Orders') }}
                            </x-nav-link-vertical>

                            <x-nav-link-vertical :href="route('coupons.index')" :active="request()->routeIs('coupons.*')">
                                {{ __('Coupons') }}
                            </x-nav-link-vertical>

                            <x-nav-link-vertical :href="route('admin.pages.index')" :active="request()->routeIs('admin.pages.*')">
                                {{ __('Pages') }}
                            </x-nav-link-vertical>
                        </div>
                    </div>
                </aside>

                <aside class="hidden lg:block fixed top-0 left-0 w-64 h-screen bg-white shadow-md z-10 pt-16">
                    <div class="py-4 px-2">
                        <h2 class="text-lg font-semibold text-gray-700 px-4">Admin Menu</h2>
                        <div class="mt-4">
                            <x-nav-link-vertical :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                                {{ __('Admin Dashboard') }}
                            </x-nav-link-vertical>

                            <x-nav-link-vertical :href="route('products.index')" :active="request()->routeIs('products.*')">
                                {{ __('Products') }}
                            </x-nav-link-vertical>

                            <x-nav-link-vertical :href="route('categories.index')" :active="request()->routeIs('categories.*')">
                                {{ __('Categories') }}
                            </x-nav-link-vertical>

                            <x-nav-link-vertical :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.index')">
                                {{ __('Orders') }}
                            </x-nav-link-vertical>

                            <x-nav-link-vertical :href="route('coupons.index')" :active="request()->routeIs('coupons.*')">
                                {{ __('Coupons') }}
                            </x-nav-link-vertical>

                            <x-nav-link-vertical :href="route('admin.pages.index')" :active="request()->routeIs('admin.pages.*')">
                                {{ __('Pages') }}
                            </x-nav-link-vertical>
                        </div>
                    </div>
                </aside>
            @endif

            <div class="{{ (Auth::check() && Auth::user()->is_admin) ? 'lg:ml-64' : '' }}">
                @include('layouts.navigation')

                @if (isset($header))
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <main>
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
