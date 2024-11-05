<x-layout>
    <x-slot:title>{{ isset($post) ? 'Edit Post' : 'Create Post' }}</x-slot:title>


    <div class="container mx-auto max-w-screen-xl lg:px-0 ">
        <h1 class="pl-3 mb-4 text-4xl font-bold font-[Noto] text-gray-800">Create a new Story!</h1>
        <form action="{{ isset($post) ? route('posts.update', $post->id) : route('posts.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @if (isset($post))
            @method('PATCH')
            @endif

            {{-- Input Title --}}
            <div class="my-6 px-5">
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <x-text-input type="text" id="title" name="title"
                    class=" block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    value="{{ old('title', $post->title ?? '') }}" required />
            </div>

            {{-- Input Slug --}}
            <div class="my-6 px-5">
                <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
                <x-text-input type="text" id="slug" name="slug"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    value="{{ old('slug', $post->slug ?? '') }}" required autocomplete="off" />
            </div>

            {{-- Input Excerpt --}}
            <div class="my-6 px-5">
                <label for="slug" class="block text-sm font-medium text-gray-700">Excerpt</label>
                <x-text-input type="text" id="excerpt" name="excerpt"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    value="{{ old('excerpt', $post->excerpt ?? '') }}" required autocomplete="off" />
            </div>

            {{-- Input Categories --}}
            <!-- Button untuk mengaktifkan dropdown -->
            <div class="my-6 px-5">
                <label for="categories" class="block mb-2 text-sm font-medium text-gray-700">Select Category(s)</label>
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

                <!-- Dropdown menu -->
                <div id="dropdownSearch" class="z-10 hidden bg-white rounded-lg shadow w-60 mt-2">
                    <div class="p-3">
                        <label for="input-group-search" class="sr-only">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M19 19l-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>
                            <input type="text" id="input-group-search"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5"
                                placeholder="Search user">
                        </div>
                    </div>

                    <!-- Konten Dropdown Category -->
                    <ul class="h-48 px-3 pb-3 overflow-y-auto text-sm text-gray-700 dark:text-gray-200">
                        @foreach ($categories as $category)
                        <li>
                            <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                <input id="checkbox-item-11" type="checkbox" name="categories[]" value="{{ $category->id }}"
                                {{ isset($post) && $post->categories->contains($category->id) ? 'checked' : '' }}
                                    class="w-4 h-4 text-gray-800 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label for="category-{{ $category->id }}"
                                    class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">{{ $category->name }}</label>
                            </div>
                        @endforeach
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Input Body --}}
            <div class="my-6 px-5">
                <label for="body" class="block text-sm font-medium text-gray-700">Body</label>
                <input type="hidden" id="body" name="body"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                    value="{{ old('body', $post->body ?? '') }}">
                <trix-editor input="body" class="h-56"></trix-editor>
            </div>

            {{-- Button Submit --}}
            <x-primary-button type="submit" class="ml-6 my-6">
                {{ isset($post) ? 'Update Post' : 'Create Post' }}
            </x-primary-button>
        </form>


        @push('scripts')
        <script>
            const title = document.querySelector('#title');
            const slug = document.querySelector('#slug');

                title.addEventListener('change', function() {
                    fetch('/checkSlug?title=' + encodeURIComponent(title.value)) // hapus '/posts' 
                        .then(response => response.json())
                        .then(data => slug.value = data.slug)
                        .catch(error => console.error('Error:', error));
                });
            </script>

            <script>
                // Toggle dropdown category visibility
                const dropdownButton = document.getElementById('dropdownSearchButton');
                const dropdownMenu = document.getElementById('dropdownSearch');

                dropdownButton.addEventListener('click', function(event) {
                    dropdownMenu.classList.toggle('hidden');
                });

                // Close dropdown when clicking outside of it
                document.addEventListener('click', function(event) {
                    if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                        dropdownMenu.classList.add('hidden');
                    }
                });
            </script>
        @endpush

    </div>

</x-layout>

<!-- Taruh script di bagian bawah form atau dalam section scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.4.1/flowbite.min.js"></script>
