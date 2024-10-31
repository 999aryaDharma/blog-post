<x-layout>
    <x-slot:title>Create Post</x-slot:title>

    <div class="container mx-auto max-w-screen-xl lg:px-0">
        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Input Title --}}
            <div class="my-6 px-5">
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <x-text-input type="text" id="title" name="title"
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    value="{{ old('title') }}" required />
            </div>

            {{-- Input Slug --}}
            <div class="my-6 px-5">
                <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
                <x-text-input type="text" id="slug" name="slug"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    value="{{ old('slug') }}" required autocomplete="off" />
            </div>

            {{-- Input Excerpt --}}
            <div class="my-6 px-5">
                <label for="excerpt" class="block text-sm font-medium text-gray-700">Excerpt</label>
                <x-text-input type="text" id="excerpt" name="excerpt"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    value="{{ old('excerpt') }}" required autocomplete="off" />
            </div>

            {{-- Input Categories --}}
            <div class="my-6 px-5">
                <label for="categories" class="block mb-2 text-sm font-medium text-gray-700">Select Category(s)</label>
                <!-- Dropdown Categories -->
                <button id="dropdownSearchButton"
                    class="inline-flex items-center px-4 py-3 text-sm font-medium text-center text-white bg-gray-700 rounded-lg hover:bg-black focus:ring-4 focus:outline-none focus:ring-slate-700"
                    type="button">
                    Select Category(s)
                    <svg class="w-2.5 h-2.5 ml-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 1l4 4 4-4" />
                    </svg>
                </button>
                <!-- Content Dropdown Categories -->
                <div id="dropdownSearch" class="z-10 hidden bg-white rounded-lg shadow w-60 mt-2">
                    <ul class="h-48 px-3 pb-3 overflow-y-auto text-sm text-gray-700">
                        @foreach ($categories as $category)
                            <li>
                                <div class="flex items-center p-2 rounded hover:bg-gray-100">
                                    <input id="checkbox-item-{{ $category->id }}" type="checkbox" name="categories[]"
                                        value="{{ $category->id }}"
                                        class="w-4 h-4 text-gray-800 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                    <label for="category-{{ $category->id }}"
                                        class="w-full ms-2 text-sm font-medium text-gray-900 rounded">{{ $category->name }}</label>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- Input Body --}}
            <div class="my-6 px-5">
                <label for="body" class="block text-sm font-medium text-gray-700">Body</label>
                <input type="hidden" id="body" name="body" value="{{ old('body') }}">
                <trix-editor input="body"></trix-editor>
            </div>

            {{-- Button Submit --}}
            <x-primary-button type="submit" class="ml-6 my-6">Create Post</x-primary-button>
        </form>

        @push('scripts')
            <script>
                const title = document.querySelector('#title');
                const slug = document.querySelector('#slug');

                title.addEventListener('change', function() {
                    fetch('/checkSlug?title=' + encodeURIComponent(title.value))
                        .then(response => response.json())
                        .then(data => slug.value = data.slug)
                        .catch(error => console.error('Error:', error));
                });

                const dropdownButton = document.getElementById('dropdownSearchButton');
                const dropdownMenu = document.getElementById('dropdownSearch');

                dropdownButton.addEventListener('click', function(event) {
                    dropdownMenu.classList.toggle('hidden');
                });

                document.addEventListener('click', function(event) {
                    if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                        dropdownMenu.classList.add('hidden');
                    }
                });
            </script>
        @endpush
    </div>
</x-layout>
