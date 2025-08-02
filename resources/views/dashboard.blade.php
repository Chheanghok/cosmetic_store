<x-shop-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="p-6 text-gray-900">
        <p class="mb-4">Welcome to your dashboard!</p>
        <a href="{{ route('user.orders.index') }}" class="text-indigo-600 hover:text-indigo-900 font-semibold">
            View My Orders
        </a>
    </div>
</x-shop-layout>
