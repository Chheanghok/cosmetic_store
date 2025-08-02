<x-shop-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        @if($product->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}" class="w-full h-auto object-cover rounded-lg">
                            @else
                            <div class="w-full h-96 bg-gray-200 flex items-center justify-center rounded-lg">
                                <span class="text-gray-500">No Image</span>
                            </div>
                        @endif
                    </div>

                    <div>
                        @if($product->category)
                            <span class="text-sm text-gray-500">{{ $product->category->name }}</span>
                        @endif
                        <h1 class="text-4xl font-bold text-gray-900 mt-1">{{ $product->name }}</h1>
                        <p class="mt-4 text-3xl text-gray-800">${{ number_format($product->price, 2) }}</p>

                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900">Description</h3>
                            <div class="mt-2 text-base text-gray-600 space-y-4">
                                {!! nl2br(e($product->description)) !!}
                            </div>
                        </div>

                        <div class="mt-8">
                            <form action="{{ route('cart.add', $product) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-primary-500 hover:bg-primary-700 text-white font-bold py-3 px-6 rounded-lg">
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-shop-layout>