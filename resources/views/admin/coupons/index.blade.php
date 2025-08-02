<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Coupons') }}
            </h2>
            <a href="{{ route('coupons.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-2 sm:mt-0">
                Add New Coupon
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if (session('success'))
                        <div x-data="{ show: true }"
                            x-init="setTimeout(() => show = false, 2000)"
                            x-show="show"
                            x-transition
                            class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <form method="GET" action="{{ route('coupons.index') }}" class="mb-4">
                        <div class="flex flex-col sm:flex-row gap-4">
                            <div class="flex-grow">
                                <input type="text" name="search" placeholder="Search by code..." value="{{ request('search') }}" class="w-full rounded-md shadow-sm border-gray-300">
                            </div>
                            <div>
                                <button type="submit" class="w-full bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">Filter</button>
                            </div>
                            <div>
                                <a href="{{ route('coupons.index') }}" class="w-full block text-center bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Clear</a>
                            </div>
                        </div>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Code</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Value</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Used / Limit</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Expires At</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($coupons as $coupon)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $coupon->code }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($coupon->type) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($coupon->type == 'percent')
                                                {{ $coupon->value }}%
                                            @else
                                                ${{ number_format($coupon->value, 2) }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $coupon->times_used }} / {{ $coupon->usage_limit ?? '∞' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $coupon->expires_at ? $coupon->expires_at->format('M d, Y') : 'Never' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
                                            <a href="{{ route('coupons.edit', $coupon) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="px-6 py-4 text-center">No coupons found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $coupons->appends(request()->query())->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>