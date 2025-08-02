<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Coupon') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
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
                    
                    <form method="POST" action="{{ route('coupons.update', $coupon) }}">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="code" class="block font-medium text-sm text-gray-700">Coupon Code</label>
                            <input id="code" name="code" type="text" class="block mt-1 w-full" value="{{ old('code', $coupon->code) }}" required>
                        </div>

                        <div class="mt-4">
                            <label for="type" class="block font-medium text-sm text-gray-700">Type</label>
                            <select name="type" id="type" class="block mt-1 w-full">
                               <option value="fixed" @selected(old('type', $coupon->type) == 'fixed')>Fixed Amount</option>
                                <option value="percent" @selected(old('type', $coupon->type) == 'percent')>Percentage</option>
                            </select>
                        </div>

                        <div class="mt-4">
                            <label for="value" class="block font-medium text-sm text-gray-700">Value (Amount or %)</label>
                            <input id="value" name="value" type="number" step="0.01" class="block mt-1 w-full" value="{{ old('value', $coupon->value) }}" required>
                        </div>

                        <div class="mt-4">
                            <label for="usage_limit" class="block font-medium text-sm text-gray-700">Usage Limit (Optional)</label>
                            <input id="usage_limit" name="usage_limit" type="number" class="block mt-1 w-full" value="{{ old('usage_limit', $coupon->usage_limit ?? '') }}">
                        </div>

                        <div class="mt-4">
                            <label for="expires_at" class="block font-medium text-sm text-gray-700">Expiration Date (Optional)</label>
                            <input id="expires_at" name="expires_at" type="date" class="block mt-1 w-full" value="{{ old('expires_at', $coupon->expires_at ? \Carbon\Carbon::parse($coupon->expires_at)->format('Y-m-d') : '') }}">
                        </div>

                        <div class="flex items-center justify-end mt-4 space-x-4">
                            <a href="{{ route('coupons.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Back
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Save Coupon
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>