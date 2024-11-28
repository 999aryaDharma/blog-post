<div id="default-carousel" class="relative w-full h-full mt-20" data-carousel="slide">
    <!-- Carousel wrapper -->
    <h3 class="text-xl font-semibold mb-4">Most Popular</h3>
    <div class="relative h-96 overflow-hidden rounded-lg md:h-96">
        <!-- Item 1 -->
        @foreach ($popularPosts as $posts)
            <div class="hidden duration-500 ease-in-out" data-carousel-item>
                <a href="{{ route('posts.show', $posts->slug) }}">
                    <div class="absolute bottom-16 left-8 transform text-start text-white font-body">
                        <p class="text-3xl font-extrabold ">{{ $posts->title }}</p>
                        <p class="text-lg">{{ $posts->created_at->format('M d, Y') }}
                            @if ($posts->categories->isNotEmpty())
                                <span>| {{ $posts->categories->first()->name }}</span>
                            @endif
                        </p>
                    </div>

                    <img src="{{ $posts->thumbnailUrl }}" class="block w-full h-full object-cover shadow-inner"
                        alt="{{ $posts->title }}">
                </a>
            </div>
        @endforeach
    </div>
    
    <!-- Slider controls -->
    <button type="button"
        class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
        data-carousel-prev>
        <span
            class="inline-flex items-center justify-center w-10 h-10 rounded-full  dark:bg-gray-800/30  dark:group-hover:bg-gray-800/60 dark:group-focus:ring-gray-800/70 ">
            <svg class="w-4 h-4 text-black dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 1 1 5l4 4" />
            </svg>
            <span class="sr-only">Previous</span>
        </span>
    </button>
    <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer"
        data-carousel-next>
        <span
            class="inline-flex items-center justify-center w-10 h-10 rounded-full  dark:bg-gray-800/30  dark:group-hover:bg-gray-800/60  dark:group-focus:ring-gray-800/70 group-focus:outline-none">
            <svg class="w-4 h-4 text-black dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 9 4-4-4-4" />
            </svg>
            <span class="sr-only">Next</span>
        </span>
    </button>
</div>
