<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Product') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                            <strong class="font-bold">Whoops! Something went wrong.</strong>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="name" class="block font-medium text-sm text-gray-700">Name</label>
                            <input id="name" name="name" type="text" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" value="{{ old('name', $product->name) }}" required autofocus>
                        </div>

                        <div class="mt-4">
                            <label for="description" class="block font-medium text-sm text-gray-700">Description</label>
                            <textarea id="description" name="description" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required>{{ old('description', $product->description) }}</textarea>
                        </div>

                        <div class="mt-4">
                            <label for="category_id" class="block mb-1 font-medium text-sm text-gray-700">Category</label>
                            <select name="category_id" id="category_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 items-center" required>
                                <option value="">Select a Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id ?? '') == $category->id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-4">
                            <label for="price" class="block font-medium text-sm text-gray-700">Price</label>
                            <input id="price" name="price" type="number" step="0.01" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" value="{{ old('price', $product->price) }}" required>
                        </div>

                        <div class="mt-4">
                            <label for="stock_quantity" class="block font-medium text-sm text-gray-700">Stock Quantity</label>
                            <input id="stock_quantity" name="stock_quantity" type="number" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" value="{{ old('stock_quantity', $product->stock_quantity) }}" required>
                        </div>

                        <div class="mt-4">
                            <span class="block font-medium text-sm text-gray-700">Current Images</span>
                            @if ($product->images->isNotEmpty())
                                <div class="mt-2 grid grid-cols-1 sm:grid-cols-3 md:grid-cols-4 gap-4">
                                    @foreach ($product->images as $image)
                                        <div class="relative">
                                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                                            <div class="mt-1">
                                                <input type="checkbox" name="delete_images[]" value="{{ $image->id }}" id="delete_image_{{ $image->id }}" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                                <label for="delete_image_{{ $image->id }}" class="ml-2 text-xs text-red-600 font-semibold uppercase">Delete</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="mt-2 text-gray-500">
                                    <p>No images available for this product.</p>
                                </div>
                            @endif
                        </div>

                        <div class="mt-4">
                            <label for="is_featured" class="flex items-center">
                                <input id="is_featured" name="is_featured" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm" value="1"
                                    @if(isset($product) && $product->is_featured) checked @endif>
                                <span class="ms-2 text-sm text-gray-600">Featured Product</span>
                            </label>
                        </div>

                        <div class="mt-4">
                            <label for="images" class="block font-medium text-sm text-gray-700">Add More Images</label>
                            <input id="images" name="images[]" type="file" class="block mt-1 w-full" multiple>
                        </div>

                        <div class="flex items-center justify-end mt-4 space-x-4">
                            <a href="{{ route('products.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Back
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>