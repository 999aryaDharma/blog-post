<div class="flex flex-col md:flex-row px-2 py-2 md:px-8 md:py-4 lg:space-x-8">
    <div class="flex-1 space-y-6">
        @foreach ($posts as $post)
            <!-- Postingan -->
            <div class="border-b border-gray-200 py-6 flex flex-col md:flex-row items-start gap-6">
                <!-- Wrapper untuk konten teks -->
                <div class="flex-1">
                    <div class="flex items-center space-x-2">
                        <a href="/authors/{{ $post->author->username }}">
                            <img src="{{ Storage::url($post->author->profile_photo) }}" alt="{{ $post->author->name }}"
                                class="rounded-full w-8 h-8 object-cover" />
                        </a>
                        <span class="text-primary font-thin text-sm">{{ $post->author->name }}</span>
                    </div>
                    <a href="/posts/{{ $post['slug'] }}">
                        <h2 class="text-2xl font-extrabold mt-3 font-body">{{ $post->title }}</h2>
                    </a>

                    <!-- Categories -->
                    <div class="flex flex-wrap gap-2 mb-4 mt-1">
                        @foreach ($post->categories as $category)
                            <a href="/categories/{{ $category->slug }}" class="text-md">
                                <span
                                    class="bg-{{ $category->color }}-100 text-primary-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded">
                                    {{ $category->name }}
                                </span>
                            </a>
                        @endforeach
                    </div>

                    <p class="text-gray-500 text-thin mt-1.5">{{ $post->excerpt }}</p>
                    <div class="flex space-x-4 items-center mt-4 text-xs text-gray-600">
                        <span class="text-muted">{{ $post->created_at->format('M d') }}</span>
                        <span class="text-muted flex items-center">{{ $post->upvotes() }}
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#5C5C5C"
                                viewBox="0 0 256 256" class="mx-1">
                                <path
                                    d="M178,40c-20.65,0-38.73,8.88-50,23.89C116.73,48.88,98.65,40,78,40a62.07,62.07,0,0,0-62,62c0,70,103.79,126.66,108.21,129a8,8,0,0,0,7.58,0C136.21,228.66,240,172,240,102A62.07,62.07,0,0,0,178,40ZM128,214.8C109.74,204.16,32,155.69,32,102A46.06,46.06,0,0,1,78,56c19.45,0,35.78,10.36,42.6,27a8,8,0,0,0,14.8,0c6.82-16.67,23.15-27,42.6-27a46.06,46.06,0,0,1,46,46C224,155.61,146.24,204.15,128,214.8Z">
                                </path>
                            </svg>
                            <span class="text-muted mx-2">💬179</span>
                        </span>

                    </div>
                </div>

                <!-- Gambar Blog -->
                <div class="w-full md:w-1/4 h-32 flex-shrink-0 order-last md:order-none md:mt-8 mt-8">
                    @if ($post->thumbnail)
                        <img src="{{ $post->thumbnailUrl }}" alt="Thumbnail of {{ $post->title }}"
                            class="w-full h-full object-cover rounded-md" />
                    @else
                        <div class="bg-gray-200 w-full h-full flex items-center justify-center rounded-md">
                            <span class="text-gray-400">No Image</span>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Garis vertikal -->
    <div class="relative hidden md:block border-r-[1px] border-gray-100 -right-10"></div>

    <!-- Sidebar Widgets (hanya muncul di desktop) -->
    <div class="hidden md:block w-1/4 space-y-6 pl-6 sticky h-[calc(100vh-2rem)] top-10 pb-4">
        <!-- Rekomendasi Topik -->
        <div class="px-3.5 py-2 mt-20">
            <h3 class="text-lg font-semibold mb-4">Explore Topics</h3>
            <div class="flex flex-wrap gap-2">
                <!-- Menampilkan kategori yang terlihat -->
                @foreach ($visibleCategories as $category)
                    <a href="/categories/{{ $category->slug }}" class="text-md mt-2">
                        <span
                            class="px-4 py-2 text-xs rounded-3xl font-semibold text-primary-800 bg-{{ $category->color }}-100">
                            {{ $category->name }}
                            <span
                                class="p-1 text-xs font-semibold text-primary-800 bg-{{ $category->color }}-100 rounded-md">
                                ({{ $category->posts->count() }})
                            </span>
                        </span>
                    </a>
                @endforeach

            </div>
            <!-- Accordion untuk kategori yang tidak terlihat -->
            <div class="mt-6 relative">
                <!-- Tombol Accordion -->
                <button id="accordionButton" class="rounded-md px-2 py-2 text-sm font-medium text-gray-800">
                    See more topics
                </button>

                <!-- Konten Accordion -->
                <div id="accordionContent"
                    class="hidden max-h-0 overflow-hidden transition-all duration-300 ease-in-out transform scale-95 opacity-0">
                    @foreach ($sisaCategories as $category)
                        <a href="/categories/{{ $category->slug }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            {{ $category->name }} ({{ $category->posts->count() }})
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Rekomendasi Penulis -->
        <div class="p-5">
            <h3 class="text-lg font-semibold mb-6">Explore Authors</h3>
            <ul class="text-muted-foreground space-y-5">
                @foreach ($users as $user)
                    <li class="flex items-center space-x-2">
                        <a href="/authors/{{ $user->username }}" class="flex items-center">
                            <img src="{{ Storage::url($user->profile_photo) }}" alt="{{ $user->name }}"
                                class="rounded-full w-6 h-6 object-cover">
                            <span class="ml-2">{{ $user->name }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
