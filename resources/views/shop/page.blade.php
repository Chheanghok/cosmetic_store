<x-shop-layout>
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-12 text-gray-900">
                    <h1 class="text-4xl font-bold mb-6">{{ $page->title }}</h1>
                    <div class="prose max-w-none">
                        {!! $page->content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-shop-layout>