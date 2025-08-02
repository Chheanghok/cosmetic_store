<x-shop-layout>
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-8">Checkout</h2>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('checkout.store') }}" method="POST">
                        @csrf
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Shipping Information</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="customer_name" class="block font-medium text-sm text-gray-700">Full Name</label>
                                <input id="customer_name" name="customer_name" type="text" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" value="{{ auth()->user()?->name ?? old('customer_name') }}" required>
                            </div>

                            <div>
                                <label for="customer_email" class="block font-medium text-sm text-gray-700">Email Address</label>
                                <input id="customer_email" name="customer_email" type="email" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" value="{{ auth()->user()?->email ?? old('customer_email') }}" required>
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="shipping_address" class="block font-medium text-sm text-gray-700">Shipping Address</label>
                            <textarea id="shipping_address" name="shipping_address" rows="4" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required>{{ old('shipping_address') }}</textarea>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <button type="submit" class="bg-primary-500 hover:bg-primary-700 text-white font-bold py-3 px-6 rounded-lg">
                                Place Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-shop-layout>