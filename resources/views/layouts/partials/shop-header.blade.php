<nav class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex-shrink-0">
                <a href="{{ route('shop.index') }}">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                </a>
            </div>

            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('shop.index') }}" class="text-gray-600 hover:text-primary-500 font-semibold">Shop</a>
                {{-- We can add category links here later --}}
                <a href="#" class="text-gray-600 hover:text-primary-500 font-semibold">About Us</a>
                <a href="#" class="text-gray-600 hover:text-primary-500 font-semibold">Contact</a>
            </div>

            <div class="flex items-center space-x-4">
                <a href="{{ route('cart.index') }}" class="mr-4 text-sm text-gray-600 hover:text-gray-900 relative">
                    <svg class="h-6 w-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    @if(session('cart') && count(session('cart')) > 0)
                        <span class="absolute -top-2 -right-3 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">
                            {{ count(session('cart')) }}
                        </span>
                    @endif
                </a>
                @auth
                     <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-primary-500 font-semibold">Dashboard</a>
                @else
                     <a href="{{ route('login') }}" class="text-gray-600 hover:text-primary-500 font-semibold">Login</a>
                @endauth
            </div>
        </div>
    </div>
</nav>