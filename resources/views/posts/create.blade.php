<x-layout>
    <x-slot:title>Create Post</x-slot:title>
    <style>
        .ck-editor__editable[role="textbox"] {
            min-height: 300px;
            min-width: 900px;
        }

        .ck.ck-toolbar .ck.ck-toolbar__items {
            margin-right: 20px;
            /* Jarak antar tombol toolbar */
        }
    </style>

    <div class="container mx-auto max-w-screen-xl lg:px-0 flex justify-center">
        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="w-full lg:w-2/3">
            @csrf

            <!-- Flex container for left and right columns -->
            <h1 class="my-10 text-4xl font-bold font-[Noto] text-gray-800">Create a new Story!</h1>
            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Left Column: Title, Slug, Excerpt, and Categories -->
                <div class="flex-1 space-y-12">
                    {{-- Input Title --}}
                    <div class="relative z-0">
                        <input value="{{ old('title') }}" required name="title" type="text" id="title"
                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-gray-600 peer"
                            placeholder=" " />
                        <label for="title"
                            class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-black peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Title</label>
                        @error('title')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Input Slug --}}
                    <div class="relative z-0">
                        <input value="{{ old('slug') }}" required name="slug" type="text" id="slug"
                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-gray-600 peer"
                            placeholder=" " />
                        <label for="slug"
                            class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-black peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Slug</label>
                        @error('slug')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Input Excerpt --}}
                    <div class="relative z-0">
                        <input value="{{ old('excerpt') }}" required name="excerpt" type="text" id="excerpt"
                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-gray-600 peer"
                            placeholder=" " />
                        <label for="excerpt"
                            class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-black peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Excerpt</label>
                        @error('excerpt')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <!-- Right Column: Dropzone for Thumbnail -->
                <div class="sticky w-full lg:w-1/3 flex items-center justify-center">
                    <label for="thumbnail"
                        class="flex flex-col items-center justify-center w-full h-52 mt-4 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500">

                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-6 h-6 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                            </svg>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click
                                    to upload</span> or drag and drop</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)
                            </p>
                            <div class="mt-2 ">
                                <img id="imagePreview" src="" alt="Image Preview"
                                    class="hidden w-[70%] max-h-[70%] object-contain absolute inset-0 top-3 bottom-0 left-0 right-0 m-auto" />
                            </div>
                        </div>

                        <input id="thumbnail" type="file" class="hidden" name="thumbnail" accept="image/*"
                            onchange="previewImage(event)" required />
                    </label>
                </div>

            </div>
            {{-- Input Categories --}}
            <div class="my-12">
                <label for="categories" class="block mb-2 text-sm font-medium text-gray-700"></label>
                <button id="dropdownSearchButton"
                    class="inline-flex items-center px-3 py-3 text-sm font-medium text-center text-white bg-gray-700 rounded-lg hover:bg-black focus:ring-4 focus:outline-none focus:ring-slate-700"
                    type="button" onclick="toggleDropdown()">
                    Select Category(s)
                    <svg class="w-2.5 h-2.5 ml-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 1l4 4 4-4" />
                    </svg>
                </button>
                <div id="dropdownSearch" class="z-10 hidden bg-white rounded-lg shadow w-60 mt-2">
                    <ul class="h-48 px-3 pb-3 overflow-y-auto text-sm text-gray-700">
                        @foreach ($categories as $category)
                        <li>
                            <div class="flex items-center p-2 rounded hover:bg-gray-100">
                                <input id="checkbox-item-{{ $category->id }}" type="checkbox" name="categories[]"
                                    value="{{ $category->id }}"
                                    class="w-4 h-4 text-gray-800 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                <label for="checkbox-item-{{ $category->id }}"
                                    class="w-full ms-2 text-sm font-medium text-gray-900 rounded">{{ $category->name }}</label>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- Input Body --}}
            <div class="my-6">
                <label for="body" class="block text-sm font-medium text-gray-700">Body</label>
                <input type="hidden" id="body" name="body" value="{{ old('body') }}">
                <textarea name="body" id="editor" cols="30" rows="10"></textarea>
                @error('body')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Button Submit --}}
            <x-primary-button type="submit" class="ml-6 my-6">Create Post</x-primary-button>
        </form>
    </div>


    @push('scripts')
        <script src="https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.umd.js"></script>

        <script>
            const {
                ClassicEditor,
                Essentials,
                Bold,
                Italic,
                Font,
                Link,
                List,
                Heading, // Tambahkan plugin Heading
                BlockQuote, // Tambahkan plugin BlockQuote
                Paragraph,
                Image,
                ImageUpload,
                SimpleUploadAdapter,
                CodeBlock,
                HorizontalLine,
                Alignment,
                SpecialCharacters,
            } = CKEDITOR;

            ClassicEditor
                .create(document.querySelector('#editor'), {
                    plugins: [
                        Essentials, Bold, Italic, Font, Paragraph,
                        Heading, List, Link, BlockQuote,
                        Image, ImageUpload, SimpleUploadAdapter, CodeBlock, HorizontalLine,
                        Alignment, SpecialCharacters
                    ],
                    toolbar: [
                        'undo', 'redo', '|', 'heading', 'alignment', '|', 'bold', 'italic', '|',
                        'fontSize', 'fontFamily', 'fontColor', '|', 'link', '|',
                        'blockQuote', 'CodeBlock', '|', 'numberedList', 'bulletedList', '|',
                        'fontBackgroundColor', 'HorizontalLine', '|', 'specialCharacters', '|', 'imageUpload'
                    ],
                    heading: {
                        options: [{
                                model: 'paragraph',
                                title: 'Paragraph',
                                class: 'ck-heading_paragraph'
                            },
                            {
                                model: 'heading1',
                                view: 'h1',
                                title: 'Heading 1',
                                class: 'ck-heading_heading1'
                            },
                            {
                                model: 'heading2',
                                view: 'h2',
                                title: 'Heading 2',
                                class: 'ck-heading_heading2'
                            },
                            {
                                model: 'heading3',
                                view: 'h3',
                                title: 'Heading 3',
                                class: 'ck-heading_heading3'
                            }
                        ]
                    },
                    simpleUpload: {
                        uploadUrl: '/upload-image', // Sesuaikan dengan route Laravel Anda
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }
                })
                .then(editor => {
                    console.log('Editor berhasil diinisialisasi:', editor);

                })
                .catch(error => {
                    console.error('Terjadi error saat inisialisasi CKEditor:', error);
                });
        </script>


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

            // Fitur Pratinjau Gambar
            function previewImage(event) {
                const input = event.target;
                const preview = document.getElementById('imagePreview');

                if (input.files && input.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.classList.remove('hidden'); // Tampilkan gambar setelah diunggah
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
    @endpush
    </div>
</x-layout>