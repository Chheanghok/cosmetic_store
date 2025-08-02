<x-shop-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-8">Our Products</h2>

            <form method="GET" action="{{ route('shop.index') }}" class="mb-8 bg-white p-4 rounded-lg shadow-sm">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <input type="text" name="search" placeholder="Search by name..." value="{{ request('search') }}" class="w-full rounded-md shadow-sm border-gray-300">
                    </div>
                    <div>
                        <select id='category_id' name="category" class="w-full rounded-md shadow-sm border-gray-300">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(request('category') == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex space-x-2">
                        <button type="submit" class="w-full bg-primary-500 hover:bg-primary-700 text-white font-bold py-2 px-4 rounded-lg">Filter</button>
                        <a href="{{ route('shop.index') }}" class="w-full block text-center bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg">Clear</a>
                    </div>
                </div>
            </form>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($products as $product)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <a href="{{ route('product.show', $product) }}">
                            @if($product->images->isNotEmpty())
                                <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}" class="w-full h-56 object-cover">
                            @else
                                <div class="w-full h-56 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-500">No Image</span>
                                </div>
                            @endif
                            <div class="p-4">
                                @if($product->category)
                                    <span class="text-xs text-gray-500">{{ $product->category->name }}</span>
                                @endif
                                <h3 class="mt-1 font-semibold text-lg text-gray-900">{{ $product->name }}</h3>
                                <p class="mt-2 text-md text-gray-700">${{ number_format($product->price, 2) }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-shop-layout>