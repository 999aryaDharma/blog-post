<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    @section('tittle', $title)

    <div class="py-2 mx-auto max-w-screen-xl lg:py-10">

        {{-- Carousel (Featured Post) --}}
        <div id="controls-carousel" class="relative w-full md:px-24 mb-20" data-carousel="static">
            <!-- Carousel wrapper -->
            <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                <!-- Item 1 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img src="/docs/images/carousel/carousel-1.svg"
                        class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
                </div>
                <!-- Item 2 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item="active">
                    <img src="/docs/images/carousel/carousel-2.svg"
                        class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
                </div>
                <!-- Item 3 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img src="/docs/images/carousel/carousel-3.svg"
                        class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
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
                class="absolute pl-20 ml-10 top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                data-carousel-prev>
                <span
                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg class="w-4 h-4 text-black dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 1 1 5l4 4" />
                    </svg>
                    <span class="sr-only">Previous</span>
                </span>
            </button>
            <button type="button"
                class="absolute pr-20 mr-10 top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                data-carousel-next>
                <span
                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
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
        <div class="grid gap-6 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($posts as $post)
                <article
                    class="flex flex-col justify-between p-4 sm:p-6 bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
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

                                <!-- Dropdown menu with improved mobile positioning -->
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

                    <!-- Categories with improved wrapping -->
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

                    <!-- Post title and date with better spacing -->
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 mb-3">
                        <a href="/posts/{{ $post['slug'] }}" class="group">
                            <h2 class="text-xl sm:text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                {{ $post['title'] }}</h2>
                        </a>
                        <div class="flex items-center text-gray-400">
                            <span class="hidden sm:inline mx-2">|</span>
                            <p class="text-xs">{{ $post->created_at->format('d M Y') }}</p>
                        </div>
                    </div>

                    <p class="font-[Segoe UI] mb-5 font-light text-gray-500 dark:text-gray-400 line-clamp-4">
                        {{ $post->body }}</p>

                    <!-- Author info and read more with improved mobile layout -->
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 mt-auto">
                        <a href="/authors/{{ $post->author->username }}" class="flex items-center space-x-3">
                            <img src="{{ Storage::url($post->author->profile_photo) }}"
                                alt="{{ $post->author->name }}"
                                class="w-8 h-8 sm:w-10 sm:h-10 rounded-full object-cover">
                            <span class="font-medium text-sm dark:text-white">{{ $post->author->name }}</span>
                        </a>
                        <a href="/posts/{{ $post['slug'] }}"
                            class="inline-flex items-end font-medium text-blue-400 dark:text-primary-500 hover:underline text-sm">
                            Read more
                            <svg class="ml-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </a>
                    </div>
                </article>
            @empty
                <div class="fixed inset-0 flex items-center justify-center p-4">
                    <div
                        class="bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700 p-6 text-center">
                        <p class="font-semibold text-xl sm:text-2xl mb-4">Article not found!</p>
                        <a href="/" class="font-medium text-sm text-blue-600 hover:underline">&laquo; Back to
                            all
                            posts</a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Bagian Post (Post Biasa) -->
        <div class="flex flex-col md:flex-row px-8 py-4 md:p-16 lg:space-x-28">
            <div class="flex-1 space-y-3">
                <!-- Postingan 2 -->
                <div class="border-b-[1px] border-gray-300 px-1.5 py-10 flex flex-col md:flex-row items-start w-full">
                    <div class="flex-1">
                        <div class="flex items-center space-x-2">
                            <img src="https://placehold.co/24x24" alt="Author Avatar" class="rounded-full" />
                            <span class="text-primary font-thin text-sm">Michael Lim in Practice in Public</span>
                        </div>
                        <h2 class="text-2xl font-extrabold mt-4 font-body">If You Only Have 1 Hour A Day To Build A
                            One-Person Business,
                            Do This.</h2>
                        <p class="text-muted-foreground mt-1.5 text-gray-500">Rather than make excuses, I’ve adapted to
                            them.</p>
                        <div class="flex space-x-4 items-center mt-4">
                            <span class="text-muted">Jun 19</span>
                            <span class="text-muted">7.6K 💬 179</span>
                        </div>
                    </div>
                    <!-- Gambar Blog -->
                    <div class="w-full md:w-1/5 h-40 md:h-auto flex-shrink-0 order-last md:order-none mt-8 md:mt-10">
                        <img src="https://placehold.co/300x200" alt="Blog Image"
                            class="w-full h-full object-cover shadow-md" />
                    </div>
                </div>
            </div>

            <!-- Sidebar Widgets (hanya muncul di desktop) -->
            <div class="hidden md:block w-1/4 space-y-6 pl-6">
                <!-- Rekomendasi Topik -->
                <div class=" px-3.5 py-2">
                    <h3 class="text-lg font-semibold mb-4">Rekomendasi Topik</h3>
                    <div class="flex flex-wrap gap-2">
                        <!-- Badge dari Flowbite untuk kategori -->
                        <span class="px-2 py-1 text-xs font-semibold text-gray-800 bg-gray-200 rounded-md">Personal
                            (80)</span>
                        <span class="px-2 py-1 text-xs font-semibold text-gray-800 bg-gray-200 rounded-md">Work
                            (45)</span>
                        <span class="px-2 py-1 text-xs font-semibold text-gray-800 bg-gray-200 rounded-md">Lifestyle
                            (30)</span>
                    </div>
                </div>

                <!-- Rekomendasi Penulis -->
                <div class="border border-black px-3.5 py-2">
                    <h3 class="text-lg font-semibold mb-2">Rekomendasi Penulis</h3>
                    <ul class="text-muted-foreground space-y-2">
                        <li>John Doe</li>
                        <li>Jane Smith</li>
                        <li>Michael Lim</li>
                    </ul>
                </div>
            </div>
        </div>


    </div>

    <!-- Floating action button with better mobile positioning -->
    @auth
        <button><a href="/posts/create"
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


<script>
    document.querySelectorAll('[id^=dropdownButton-]').forEach(button => {
        button.addEventListener('click', (event) => {
            event.stopPropagation();
            const dropdownId = button.id.replace('Button', 'Menu');
            const dropdownMenu = document.getElementById(dropdownId);

            // Close other dropdowns
            document.querySelectorAll('[id^=dropdownMenu-]').forEach(menu => {
                if (menu !== dropdownMenu && !menu.classList.contains('hidden')) {
                    menu.classList.remove('scale-100', 'opacity-100');
                    menu.classList.add('scale-95', 'opacity-0');
                    setTimeout(() => {
                        menu.classList.add('hidden');
                    }, 300);
                }
            });

            if (dropdownMenu.classList.contains('hidden')) {
                dropdownMenu.classList.remove('hidden');
                requestAnimationFrame(() => {
                    dropdownMenu.classList.remove('scale-95', 'opacity-0');
                    dropdownMenu.classList.add('scale-100', 'opacity-100');
                });
            } else {
                dropdownMenu.classList.remove('scale-100', 'opacity-100');
                dropdownMenu.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    dropdownMenu.classList.add('hidden');
                }, 300);
            }
        });
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        document.querySelectorAll('[id^=dropdownMenu-]').forEach(menu => {
            if (!menu.classList.contains('hidden')) {
                menu.classList.remove('scale-100', 'opacity-100');
                menu.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    menu.classList.add('hidden');
                }, 300);
            }
        });
    });
</script>
