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

            <div class="flex flex-wrap mb-2">
                <!-- Left section for Title and Slug -->
                <div class="flex flex-col w-full lg:w-1/2 px-5">
                    <!-- Title Input -->
                    <div class="mb-4">
                        <div class="relative z-0">
                            <input type="text" id="title" name="title" value="{{ old('title', $post->title ?? '') }}" required
                                class="block w-full px-0 py-2 text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300
                   appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500
                   focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                            <label for="title" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform
                   -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600
                   peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0
                   peer-focus:scale-75 peer-focus:-translate-y-6">Title</label>
                        </div>
                    </div>

                    <!-- Slug Input -->
                    <div class="mb-4">
                        <div class="relative z-0">
                            <input type="text" id="slug" name="slug" value="{{ old('slug', $post->slug ?? '') }}" required autocomplete="off"
                                class="block w-full px-0 py-2 text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300
                   appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500
                   focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                            <label for="slug" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform
                   -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600
                   peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0
                   peer-focus:scale-75 peer-focus:-translate-y-6">Slug</label>
                        </div>
                    </div>

                    <!-- Select Categories Button -->
                    <div class="mb-4">
                        <div class="relative z-0">
                            <button id="dropdownCheckboxButton"
                                data-dropdown-toggle="dropdownDefaultCheckbox"
                                class=" w-full px-0 py-2 text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-300
                   appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500
                   focus:outline-none focus:ring-0 focus:border-blue-600 peer text-left flex items-center justify-between"
                                type="button">
                                Select Categories
                                <svg class="w-4 h-4 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </button>
                        </div>

                        <!-- Dropdown menu -->
                        <div id="dropdownDefaultCheckbox" class="absolute z-10 hidden w-48 mt-2 bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600">
                            <div class="px-4 py-2 text-gray-700 dark:text-gray-300">
                                @foreach ($categories as $category)
                                <div class="flex items-center mt-1.5">
                                    <input type="checkbox" name="categories[]" id="category-{{ $category->id }}" value="{{ $category->id }}"
                                        {{ isset($post) && $post->categories->contains($category->id) ? 'checked' : '' }}
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="category-{{ $category->id }}" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                                        {{ $category->name }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right section for Dropzone -->
                <div class="w-full pt-8 lg:w-1/2 flex justify-center items-center px-5">
                    <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                            </svg>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                        </div>
                        <input id="dropzone-file" type="file" class="hidden" />
                    </label>
                </div>
            </div>

            <div class="mb-4 px-5">
                <label for="body" class=" text-sm text-gray-500 dark:text-gray-400">Body</label>
                <input type="hidden" id="body" name="body"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                    value="{{ old('body', $post->body ?? '') }}">
                <trix-editor input="body" class="h-56"></trix-editor>
            </div>

            <button type="submit" class="ml-5 mt-5 py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800
             dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                {{ isset($post) ? 'Update Post' : 'Create Post' }}
            </button>
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

            document.getElementById('dropdownCheckboxButton').addEventListener('click', function() {
                const dropdown = document.getElementById('dropdownDefaultCheckbox');
                dropdown.classList.toggle('hidden');
            });
        </script>
        @endpush

    </div>

</x-layout>

<!-- Taruh script di bagian bawah form atau dalam section scripts -->