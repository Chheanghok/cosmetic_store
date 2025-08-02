<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Page: {{ $page->title }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.pages.update', $page) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        <div>
                            <label for="title" class="block font-medium text-sm text-gray-700">Title</label>
                            <input id="title" name="title" type="text" class="block mt-1 w-full" value="{{ old('title', $page->title) }}" required>
                        </div>

                        <div class="mt-4">
                            <label for="content" class="block font-medium text-sm text-gray-700">Content</label>
                            <textarea id="content" name="content" rows="15" class="block mt-1 w-full rounded-md shadow-sm border-gray-300">{{ old('content', $page->content) }}</textarea>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Page
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>