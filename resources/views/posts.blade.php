<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    @section('tittle', $title)

    <div class="py-2 mx-auto max-w-screen-xl lg:py-10 p-6">

        {{-- Carousel (Featured Post) --}}
        <div id="controls-carousel" class="relative w-full md:px-10 my-10" data-carousel="static">
            <div class="absolute flex -translate-y-11 font-semibold font-headline text-xl">Most Popular</div>
            <!-- Carousel wrapper -->
            <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                <!-- Item 1 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img src="/storage/profile_photos/aryaakk.jpg"
                        class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="Gambar 1">
                </div>
                <!-- Item 2 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item="active">
                    <img src="/storage/profile_photos/default.jpeg"
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
                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
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
                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
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
        <div class="grid gap-8 grid-cols-1 px-4 py-16 sm:px-8 sm:py-8 md:grid-cols-2 lg:grid-cols-3 mt-44 mb-32">
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
                    <div class="flex flex-wrap gap-2 mb-4">
                        @foreach ($post->categories as $category)
                            <a href="/categories/{{ $category->slug }}" class="text-md">
                                <span
                                    class="bg-{{ $category->color }}-100 text-primary-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded dark:bg-primary-200 dark:text-primary-800">
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


        <!-- Regular Post -->
        <div class="flex flex-col md:flex-row px-2 py-4 md:px-8 md:py-4 lg:space-x-8 ">
            <div class="flex-1 space-y-3">
                @foreach ($posts as $post)
                    <!-- Postingan -->
                    <div
                        class="border-b-[1px] border-gray-200 px-1.5 py-8 flex flex-col md:flex-row items-start w-full gap-x-6">
                        <!-- Wrapper untuk konten teks -->
                        <div class="flex-1">
                            <div class="flex items-center space-x-2">
                                <a href="/authors/{{ $post->author->username }}">
                                    <img src="{{ Storage::url($post->author->profile_photo) }}"
                                        alt="{{ $post->author->name }}"
                                        class="rounded-full w-6 h-6 sm:w-8 sm:h-8 object-cover" />
                                </a>
                                <span class="text-primary font-thin text-sm">{{ $post->author->name }}</span>
                            </div>
                            <a href="/posts/{{ $post['slug'] }}">
                                <h2 class="text-2xl font-extrabold mt-3 font-body">{{ $post->title }}
                                </h2>
                            </a>

                            <!-- Categories -->
                            <div class="flex flex-wrap gap-2 mb-4 mt-1">
                                @foreach ($post->categories as $category)
                                    <a href="/categories/{{ $category->slug }}" class="text-md">
                                        <span
                                            class="bg-{{ $category->color }}-100 text-primary-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded dark:bg-primary-200 dark:text-primary-800">
                                            {{ $category->name }}
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                            <p class="text-gray-500 text-thin mt-1.5 flex-shrink-0">
                                {{ $post->excerpt }}</p>
                            <div class="flex space-x-4 items-center mt-4 text-xs text-gray-600">
                                <span class="text-muted">{{ $post->created_at->format('M d ') }}</span>
                                <span class="text-muted">7.6K 💬 179</span>
                            </div>
                        </div>
                        <!-- Gambar Blog -->
                        <div
                            class="w-full md:w-1/4 h-40 md:h-auto flex-shrink-0 order-last md:order-none mt-8 md:mt-10 ">
                            <img src="https://placehold.co/300x200" alt="Blog Image"
                                class="w-full h-full object-cover shadow-md" />
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Garis vertikal -->
            <div class="relative hidden md:block border-r-[1px] bg-gray-100 -right-6"></div>

            <!-- Sidebar Widgets (hanya muncul di desktop) -->
            <div class="hidden md:block w-1/4 space-y-6 pl-6 h-[calc(100vh-64px)] sticky top-16">
                <!-- Rekomendasi Topik -->
                <div class=" px-3.5 py-2 mt-12">
                    <h3 class="text-lg font-semibold mb-4">Rekomendasi Topik</h3>
                    <div class="flex flex-wrap gap-2">
                        <!-- Badge dari Flowbite untuk kategori -->
                        @foreach ($categories as $category)
                            <a href="/categories/{{ $category->slug }}" class="text-md mt-2">
                                <span
                                    class="px-4 py-2 text-xs rounded-3xl font-semibold text-primary-800 bg-{{ $category->color }}-100 rounded-md">
                                    {{ $category->name }}
                                    <span
                                        class="p-1 text-xs font-semibold text-primary-800 bg-{{ $category->color }}-100 rounded-md">
                                        ({{ $category->posts->count() }})
                                    </span>
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Rekomendasi Penulis -->
                <div class=" p-5">
                    <h3 class="text-lg font-semibold mb-4">Rekomendasi Penulis</h3>
                    <ul class="text-muted-foreground space-y-5">
                        @foreach ($users as $user)
                            <li class="flex items-center space-x-2">
                                <a href="/authors/{{ $user->username }}" class="flex items-center">
                                    <img src="{{ Storage::url($user->profile_photo) }}" alt="{{ $user->name }}"
                                        class="rounded-full w-4 h-4 sm:w-6 sm:h-6 object-cover">
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


    <x-modal name="loginModal">
        @include('auth.login')
    </x-modal>

    <x-modal name="registerModal">
        @include('auth.register')
    </x-modal>
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

<script>
    function openModal(modalName) {
        window.dispatchEvent(new CustomEvent('open-modal', {
            detail: modalName
        }));
    }
</script>
