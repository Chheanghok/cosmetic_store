<x-shop-layout>
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
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
            <h2 class="text-3xl font-bold text-gray-800 mb-8">Contact Us</h2>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <p class="mb-6 text-gray-600">Have a question or feedback? Fill out the form below to get in touch with us.</p>
                    <form action="{{ route('contact.submit') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block font-medium text-sm text-gray-700">Name</label>
                                <input id="name" name="name" type="text" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required>
                            </div>
                            <div>
                                <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                                <input id="email" name="email" type="email" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required>
                            </div>
                        </div>
                        <div class="mt-4">
                            <label for="message" class="block font-medium text-sm text-gray-700">Message</label>
                            <textarea id="message" name="message" rows="5" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required></textarea>
                        </div>
                        <div class="flex items-center justify-end mt-6">
                            <button type="submit" class="bg-primary-500 hover:bg-primary-700 text-white font-bold py-3 px-6 rounded-lg">
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-shop-layout>