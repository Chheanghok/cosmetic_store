<x-shop-layout>
    <div class="bg-primary-500 text-white text-center py-20">
        <h1 class="text-5xl font-bold">Welcome to Our Cosmetic Store</h1>
        <p class="text-xl mt-4">Discover the best products for your beauty routine.</p>
        <a href="{{ route('shop.index') }}" class="mt-8 inline-block bg-white text-primary-600 font-bold py-3 px-6 rounded-lg hover:bg-gray-200">Shop Now</a>
    </div>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-8">Featured Products</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($featuredProducts as $product)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <a href="{{ route('product.show', $product) }}">
                            @if($product->images->isNotEmpty())
                                <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}" class="w-full h-56 object-cover">
                            @endif
                            <div class="p-4">
                                <h3 class="font-semibold text-lg text-gray-900">{{ $product->name }}</h3>
                                <p class="mt-2 text-md text-gray-700">${{ number_format($product->price, 2) }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <h2 class="text-3xl font-bold text-gray-800 mt-16 mb-8">New Arrivals</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                 @foreach ($newArrivals as $product)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <a href="{{ route('product.show', $product) }}">
                            @if($product->images->isNotEmpty())
                                <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}" class="w-full h-56 object-cover">
                            @endif
                            <div class="p-4">
                                <h3 class="font-semibold text-lg text-gray-900">{{ $product->name }}</h3>
                                <p class="mt-2 text-md text-gray-700">${{ number_format($product->price, 2) }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-shop-layout>