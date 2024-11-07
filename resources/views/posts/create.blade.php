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

    <div class="container mx-auto max-w-screen-xl lg:px-0">
        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Input Title --}}
            <div class="my-6 px-5">
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <x-text-input type="text" id="title" name="title"
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    value="{{ old('title') }}" required />
                @error('title')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Input Slug --}}
            <div class="my-6 px-5">
                <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
                <x-text-input type="text" id="slug" name="slug"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    value="{{ old('slug') }}" required autocomplete="off" />
                @error('slug')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Input Excerpt --}}
            <div class="my-6 px-5">
                <label for="excerpt" class="block text-sm font-medium text-gray-700">Excerpt</label>
                <x-text-input type="text" id="excerpt" name="excerpt"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    value="{{ old('excerpt') }}" required autocomplete="off" />
                @error('excerpt')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Input Categories --}}
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

            {{-- Input Thumbnail --}}
            <div class="my-6 px-5">
                <label for="thumbnail" class="block text-sm font-medium text-gray-700">Thumbnail</label>
                <x-text-input type="file" id="thumbnail" name="thumbnail"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    accept="image/*" onchange="previewImage(event)" required />

                {{-- Preview Gambar yang Dipilih --}}
                <div class="mt-2">
                    <img id="imagePreview" src="" alt="Image Preview" class="hidden w-32 h-32 object-cover" />
                </div>
            </div>

            {{-- Input Body --}}
            <div class="my-6 px-5">
                <label for="body" class="block text-sm font-medium text-gray-700">Body</label>
                <input type="hidden" id="body" name="body" value="{{ old('body') }}">
                <textarea id="editor" name="body"></textarea>
                @error('body')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Button Submit --}}
            <x-primary-button type="submit" class="ml-6 my-6">Create Post</x-primary-button>
        </form>

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
                    ImageToolbar,
                    ImageUpload,
                    ImageResize,
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
                            Heading, List, Link, BlockQuote, // Tambahkan plugin tambahan
                            Image, ImageToolbar, ImageUpload, ImageResize, SimpleUploadAdapter, CodeBlock, HorizontalLine,
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
                        image: {
                            resizeOptions: [{
                                    name: 'resizeImage:original',
                                    label: 'Original',
                                    value: null
                                },
                                {
                                    name: 'resizeImage:50',
                                    label: '50%',
                                    value: '50'
                                },
                                {
                                    name: 'resizeImage:75',
                                    label: '75%',
                                    value: '75'
                                }
                            ],
                            toolbar: ['resizeImage', 'resizeImage:50', 'resizeImage:75']
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
                    const imagePreview = document.getElementById('imagePreview');
                    const file = event.target.files[0];

                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            imagePreview.src = e.target.result;
                            imagePreview.classList.remove('hidden');
                        }
                        reader.readAsDataURL(file);
                    } else {
                        imagePreview.classList.add('hidden');
                    }
                }
            </script>
        @endpush
    </div>
</x-layout>
