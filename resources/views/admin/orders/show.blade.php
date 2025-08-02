<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order Details') }} #{{ $order->id }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-1">
                        <h3 class="text-lg font-semibold border-b pb-2">Customer Details</h3>
                        <p class="mt-4"><strong>Name:</strong> {{ $order->customer_name }}</p>
                        <p><strong>Email:</strong> {{ $order->customer_email }}</p>
                        <p class="mt-2"><strong>Shipping Address:</strong><br>{{ $order->shipping_address }}</p>
                    </div>

                    <div class="md:col-span-2">
                        <h3 class="text-lg font-semibold border-b pb-2">Order Summary</h3>
                        <p class="mt-4"><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y') }}</p>
                        <p><strong>Total:</strong> ${{ number_format($order->total, 2) }}</p>
                        <p><strong>Status:</strong> <span class="font-semibold">{{ ucfirst($order->status) }}</span></p>

                        <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="mt-4 flex items-center gap-4">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="rounded-md shadow-sm border-gray-300">
                                <option value="pending" @selected($order->status == 'pending')>Pending</option>
                                <option value="processing" @selected($order->status == 'processing')>Processing</option>
                                <option value="shipped" @selected($order->status == 'shipped')>Shipped</option>
                                <option value="cancelled" @selected($order->status == 'cancelled')>Cancelled</option>
                            </select>
                            <button type="submit" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">Update Status</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="mt-8 bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold border-b pb-2 mb-4">Items Ordered</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td class="px-4 py-2 whitespace-nowrap">{{ $item->product->name ?? 'Product not found' }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">{{ $item->quantity }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">${{ number_format($item->price, 2) }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">${{ number_format($item->price * $item->quantity, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>