<x-shop-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Order Details <span class="text-gray-500">#{{ $order->id }}</span>
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 border-b">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-semibold">Order Summary</h3>
                            <p><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y') }}</p>
                            <p><strong>Total:</strong> ${{ number_format($order->total, 2) }}</p>
                            <p><strong>Status:</strong> <span class="font-semibold">{{ ucfirst($order->status) }}</span></p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Shipping To</h3>
                            <p>{{ $order->customer_name }}</p>
                            <p>{{ $order->shipping_address }}</p>
                        </div>
                    </div>
                </div>

                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Items Ordered</h3>
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <img src="{{ asset('storage/' . ($item->product->images->first()->image_path ?? '')) }}" alt="{{ $item->product->name ?? '' }}" class="w-16 h-16 object-cover rounded-md mr-4">
                                    <div>
                                        <p class="font-semibold">{{ $item->product->name ?? 'Product not found' }}</p>
                                        <p class="text-sm text-gray-600">Qty: {{ $item->quantity }}</p>
                                    </div>
                                </div>
                                <p class="font-semibold">${{ number_format($item->price * $item->quantity, 2) }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-shop-layout>