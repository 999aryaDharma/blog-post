<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    @section('tittle', $title)

    {{-- searching for --}}
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-14">
        @if (request('search'))
            <div class=" border border-blue-200 text-gray-600 rounded-lg p-4 flex items-center space-x-2 mt-4 shadow-md">
                <!-- Icon Search -->
                <svg class="w-5 h-5 text-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                    fill="currentColor">
                    <path
                        d="M21 21l-4.35-4.35a7.5 7.5 0 10-1.06 1.06L21 21zM10.5 17a6.5 6.5 0 110-13 6.5 6.5 0 010 13z" />
                </svg>
                <!-- Text -->
                <p class="text-lg font-semibold">Searching for "<span class="font-bold">{{ request('search') }}</span>"
                </p>
            </div>
        @endif
    </div>


    <div class="py-2 mx-auto max-w-screen-xl lg:py-10 p-6">
        {{-- Carousel (Featured Post) --}}
        <div id="controls-carousel" class="relative w-full md:px-10 my-14" data-carousel="static">
            <div class="absolute flex -translate-y-11 font-semibold font-headline text-xl">Most Popular</div>
            <!-- Carousel wrapper -->
            <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                <!-- Item 1 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img src="/storage/profile_photos/default.jpeg"
                        class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="Gambar 1">
                </div>
                <!-- Item 2 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item="active">
                    <img src="/storage/profile_photos/aryaakk.jpg"
                        class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="Gambar 2">
                </div>
                <!-- Item 3 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img src="/docs/images/carousel/carousel-3.svg"
                        class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="Gambar 3">
                </div>
                <!-- Item 4 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img src="/docs/images/carousel/carousel-4.svg"
                        class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
                </div>
                <!-- Item 5 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img src="/docs/images/carousel/carousel-5.svg"
                        class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
                </div>
            </div>
            <!-- Slider controls -->
            <button type="button"
                class="absolute pl-8 ml-5 top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                data-carousel-prev>
                <span
                    class="inline-flex items-center justify-center w-12 h-12 rounded-full  dark:bg-gray-800/30 dark:group-hover:bg-gray-800/60  dark:group-focus:ring-gray-800/70">
                    <svg class="w-4 h-4 text-black dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 1 1 5l4 4" />
                    </svg>
                    <span class="sr-only">Previous</span>
                </span>
            </button>
            <button type="button"
                class="absolute pr-8 mr-5 top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                data-carousel-next>
                <span
                    class="inline-flex items-center justify-center w-14 h-14 rounded-full  dark:bg-gray-800/30 dark:group-hover:bg-gray-800/60  dark:group-focus:ring-gray-800/70 ">
                    <svg class="w-4 h-4 text-black dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                    <span class="sr-only">Next</span>
                </span>

            </button>
        </div>

        {{-- Latest Post (ambil 3) --}}
        @isset($latestPosts)
            <div class="grid gap-8 grid-cols-1 px-4 py-16 sm:px-8 sm:py-8 md:grid-cols-2 lg:grid-cols-3 mt-48 mb-44">
                <div class="absolute z-30 flex translate-x- -translate-y-12 font-semibold font-headline text-xl">
                    Latest Post
                </div>
                @forelse ($latestPosts as $post)
                    <article
                        class="flex flex-col justify-between p-4 bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700 sm:p-6">
                        <div class="relative">
                            @if (Auth::check() && Auth::user()->id === $post->author_id && request()->is('my-posts/*'))
                                <div id="dropdownButton-{{ $post->id }}" class="mb-1 absolute right-0 -top-2">
                                    <button type="button"
                                        class="flex items-center justify-center w-8 h-8 text-gray-500 hover:text-gray-700 focus:outline-none">
                                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 20 20">
                                            <circle cx="10" cy="10" r="2"></circle>
                                            <circle cx="10" cy="5" r="2"></circle>
                                            <circle cx="10" cy="15" r="2"></circle>
                                        </svg>
                                    </button>

                                    <!-- Dropdown menu -->
                                    <div id="dropdownMenu-{{ $post->id }}"
                                        class="absolute right-0 z-10 mt-2 w-36 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none hidden transition transform scale-95 opacity-0 duration-300 ease-out">
                                        <div class="py-1">
                                            <a href="{{ route('posts.edit', $post->id) }}"
                                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit</a>
                                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this post?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Categories -->
                        <div class="flex flex-wrap gap-2 mb-4 relative justify">
                            <img src="{{$post->thumbnailUrl}}" alt="" class="items-cente">
                            @foreach ($post->categories as $category)
                                <a href="/categories/{{ $category->slug }}" class="text-md">
                                    <span
                                        class="bg-{{ $category->color }}-100 text-primary-800 justify-between top-2 left-1 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded dark:bg-primary-200 dark:text-primary-800">
                                        {{ $category->name }}
                                    </span>
                                </a>
                            @endforeach
                        </div>

                        <!-- Post title and date -->
                        <div class=" gap-2 mb-3 items-center">
                            <a href="/posts/{{ $post['slug'] }}" class="group">
                                <h2
                                    class="text-2xl font-body font-extrabold tracking-tight text-gray-900 dark:text-white line-clamp-2">
                                    {{ $post['title'] }}
                                </h2>
                            </a>
                            {{-- <div class="hidden sm:block mt-1">|</div> --}}
                            <div class="items-center text-gray-400 text-xs mt-1">
                                <p>{{ $post->created_at->format('M d') }}</p>
                            </div>
                        </div>


                        <p class="font-[Segoe UI] mb-5 font-light text-gray-500 dark:text-gray-400 line-clamp-4">
                            {{ $post->excerpt }}</p>

                        <!-- Author info -->
                        <div class="flex flex-col justify-between items-start mt-auto">
                            <a href="/authors/{{ $post->author->username }}" class="flex items-center space-x-3">
                                <img src="{{ Storage::url($post->author->profile_photo) }}"
                                    alt="{{ $post->author->name }}" class="w-8 h-8 rounded-full object-cover">
                                <span class="font-medium text-sm dark:text-white">{{ $post->author->name }}</span>
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="fixed inset-0 flex items-center justify-center p-4">
                        <div
                            class="bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700 p-6 text-center">
                            <p class="font-semibold text-xl sm:text-2xl mb-4">Article not found!</p>
                            <a href="/" class="font-medium text-sm text-blue-600 hover:underline">&laquo; Back to
                                all posts</a>
                        </div>
                    </div>
                @endforelse
            </div>
        @endisset


        <!-- Regular Post -->
        <div class="flex flex-col md:flex-row px-2 py-4 md:px-8 md:py-4 lg:space-x-8">
            <div class="flex-1 space-y-6">
                @foreach ($posts as $post)
                    <!-- Postingan -->
                    <div class="border-b border-gray-200 py-6 flex flex-col md:flex-row items-start gap-6">
                        <!-- Wrapper untuk konten teks -->
                        <div class="flex-1">
                            <div class="flex items-center space-x-2">
                                <a href="/authors/{{ $post->author->username }}">
                                    <img src="{{ Storage::url($post->author->profile_photo) }}"
                                        alt="{{ $post->author->name }}" class="rounded-full w-8 h-8 object-cover" />
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
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                        fill="#5C5C5C" viewBox="0 0 256 256" class="mx-1">
                                        <path
                                            d="M178,40c-20.65,0-38.73,8.88-50,23.89C116.73,48.88,98.65,40,78,40a62.07,62.07,0,0,0-62,62c0,70,103.79,126.66,108.21,129a8,8,0,0,0,7.58,0C136.21,228.66,240,172,240,102A62.07,62.07,0,0,0,178,40ZM128,214.8C109.74,204.16,32,155.69,32,102A46.06,46.06,0,0,1,78,56c19.45,0,35.78,10.36,42.6,27a8,8,0,0,0,14.8,0c6.82-16.67,23.15-27,42.6-27a46.06,46.06,0,0,1,46,46C224,155.61,146.24,204.15,128,214.8Z">
                                        </path>
                                    </svg>
                                    <span class="text-muted mx-2">💬179</span>
                                </span>

                            </div>
                        </div>

                        <!-- Gambar Blog -->
                        <div class="w-full md:w-1/4 h-32 flex-shrink-0 order-last md:order-none md:mt-0">
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
    </div>

    <!-- Floating action button with better mobile positioning -->
    @auth
        <button><a href="{{ route('posts.create') }}"
                class="fixed bottom-4 right-4 sm:bottom-6 sm:right-6 bg-[#373737] text-white rounded-full p-3 sm:p-4 shadow-lg hover:bg-[#272727] focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </a></button>
    @else
        <button onclick="openModal('loginModal')"
            class="fixed bottom-4 right-4 sm:bottom-6 sm:right-6 bg-[#373737] text-white rounded-full p-3 sm:p-4 shadow-lg hover:bg-[#272727] focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
        </button>
    @endauth



</x-layout>

<!-- Toastr Notifications -->
@if (Session::has('success'))
    <script>
        $(document).ready(function() {
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": true,
                "onclick": null,
                "showDuration": "5000",
                "hideDuration": "5000",
                "timeOut": "5000",
                "extendedTimeOut": "3000",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            toastr.success("{{ Session::get('success') }}");
        });
    </script>
@endif



{{-- dropdwon category --}}
<script>
    // Ambil elemen tombol dan konten accordion
    const accordionButton = document.getElementById('accordionButton');
    const accordionContent = document.getElementById('accordionContent');

    // Fungsi untuk toggle konten
    function toggleAccordion() {
        const isHidden = accordionContent.classList.contains('hidden');
        if (isHidden) {
            accordionContent.classList.remove('hidden');
            requestAnimationFrame(() => {
                accordionContent.classList.add('max-h-screen', 'opacity-100', 'scale-100');
                accordionContent.classList.remove('max-h-0', 'opacity-0', 'scale-95');
            });
        } else {
            accordionContent.classList.add('max-h-0', 'opacity-0', 'scale-95');
            accordionContent.classList.remove('max-h-screen', 'opacity-100', 'scale-100');
            setTimeout(() => {
                accordionContent.classList.add('hidden');
            }, 200); // Waktu sesuai dengan duration di Tailwind (300ms)
        }
    }

    // Event listener untuk tombol
    accordionButton.addEventListener('click', (event) => {
        event.stopPropagation(); // Mencegah event bubble saat klik pada tombol
        toggleAccordion();
    });

    // Menutup accordion jika mengklik di luar elemen
    document.addEventListener('click', (event) => {
        if (!accordionContent.classList.contains('hidden') && !accordionButton.contains(event.target)) {
            toggleAccordion();
        }
    });
</script>
