<x-shop-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-8">Your Shopping Cart</h2>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if (session('success'))
                        <div x-data="{ show: true }"
                            x-init="setTimeout(() => show = false, 3000)"
                            x-show="show"
                            x-transition
                            class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div x-data="{ show: true }"
                            x-init="setTimeout(() => show = false, 3000)"
                            x-show="show"
                            x-transition
                            class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if (count($cart) > 0)
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @php $total = 0 @endphp
                                @foreach ($cart as $id => $details)
                                    @php $total += $details['price'] * $details['quantity'] @endphp
                                    <tr>
                                        <td class="px-6 py-4 flex items-center">
                                            @if($details['image_path'])
                                                <img src="{{ asset('storage/' . $details['image_path']) }}" alt="{{ $details['name'] }}" class="w-16 h-16 object-cover mr-4">
                                            @endif
                                            <span>{{ $details['name'] }}</span>
                                        </td>
                                        <td class="px-6 py-4">${{ number_format($details['price'], 2) }}</td>
                                        <td class="px-6 py-4">
                                            <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center">
                                                @csrf
                                                @method('PATCH')
                                                <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1" class="w-16 rounded-md border-gray-300">
                                                <button type="submit" class="ml-2 text-xs text-indigo-600 hover:text-indigo-900">Update</button>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4">${{ number_format($details['price'] * $details['quantity'], 2) }}</td>
                                        <td class="px-6 py-4">
                                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Remove</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="flex justify-between items-start mt-6">
                            <form action="{{ route('cart.coupon.apply') }}" method="POST" class="w-full max-w-sm">
                                @csrf
                                <label for="coupon_code" class="block font-medium text-sm text-gray-700">Have a Coupon?</label>
                                <div class="flex items-center mt-1">
                                    <input type="text" name="coupon_code" id="coupon_code" class="block w-full rounded-md shadow-sm border-gray-300">
                                    <button type="submit" class="ml-2 bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-4 rounded">Apply</button>
                                </div>
                            </form>

                            <div class="text-right">
                                <p class="text-xl">Subtotal: ${{ number_format($subtotal, 2) }}</p>
                                @if(session('coupon'))
                                    <div class="flex justify-end items-center mt-2">
                                        <p class="text-lg text-green-600">
                                            Discount ({{ session('coupon')['code'] }}): -${{ number_format($discount, 2) }}
                                        </p>
                                        <form action="{{ route('cart.coupon.remove') }}" method="POST" class="ml-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs text-red-500 hover:text-red-700">[Remove]</button>
                                        </form>
                                    </div>
                                @endif
                                <p class="text-2xl font-bold mt-2">Total: ${{ number_format($total, 2) }}</p>
                                
                                <div class="mt-4 flex flex-wrap justify-end space-x-4">
                                    <a href="{{ route('shop.index') }}" class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg">Continue Shopping</a>
                                    <a href="{{ route('checkout.create') }}" class="inline-block bg-primary-500 hover:bg-primary-700 text-white font-bold py-3 px-6 rounded-lg">Proceed to Checkout</a>
                                </div>
                            </div>
                        </div>
                    @else
                        <p class="text-center text-gray-500">Your cart is empty.</p>
                        <div class="text-center mt-4">
                            <a href="{{ route('shop.index') }}" class="text-indigo-600 hover:text-indigo-900">Continue Shopping</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-shop-layout>