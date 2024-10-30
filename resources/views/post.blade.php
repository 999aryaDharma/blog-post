<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <article class="pb-20 px-4 sm:px-8 lg:px-16 xl:px-72 bg-white antialiased">
        <div class="flex flex-col lg:flex-row justify-between mx-auto max-w-screen-xl">
            <article class="w-full pr-2 sm:px-6 lg:px-8 mx-auto max-w-5xl format format-sm sm:format-base lg:format-lg">
                <header class="mb-4 lg:mb-6 not-format">
                    <a href="/" class="pl-2 sm:pl-4 lg:pl-10 font-medium text-sm text-gr-600 hover:underline">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                        </svg>
                    </a>
                    <div class="pl-2 sm:pl-4 lg:pl-11">
                        <!-- Title Section -->
                        <h3
                            class="text-3xl md:text-5xl font-nunito sm:text-4xl lg:text-5xl font-extrabold text-gray-900 lg:mb-6 mt-2 sm:mt-4 md:leading-[4rem] sm:leding-8 lg:leading-[3.5rem]">
                            {{ $post['title'] }}
                        </h3>


                        <!-- Author Section -->
                        <address class="flex items-center my-4 sm:my-6 not-italic">
                            <div class="inline-flex items-center mr-3 text-sm text-gray-900">
                                <img src="{{ $post->author->profile_photo ? asset('storage/' . $post->author->profile_photo) : asset('images/default.png') }}"
                                    alt="{{ $post->author->name }}"
                                    class="w-8 sm:w-10 h-8 sm:h-10 rounded-full object-cover">
                                <div class="ml-2 sm:ml-3">
                                    <a href="{{ '/authors/' . $post->author->username }}" rel="author"
                                        class="text-sm font-bold text-gray-900">{{ $post->author->name }}</a>
                                    <p class="text-xs sm:text-md text-gray-500">{{ $post->created_at->format('M d') }}
                                    </p>
                                </div>
                            </div>
                        </address>

                        <!-- Category Section -->
                        <div class="mt-4 lg:mt-8 flex items-center flex-wrap gap-2">
                            @foreach ($post->categories as $category)
                                <span
                                    class="bg-{{ $category->color }}-100 text-gray-500 text-xs rounded mb-1 py-1 px-2">
                                    <a href="/categories/{{ $category->slug }}" class="text-primary-800">
                                        {{ $category->name }}
                                    </a>
                                </span>
                            @endforeach
                        </div>

                        {{-- Excerpt --}}
                        <p class="mt-6 text-xl font-serif flex-shrink-0">
                            {{ $post->excerpt }}</p>
                    </div>

                    <div
                        class="ml-2 sm:ml-4 lg:ml-11 max-w-full h-auto flex-shrink-0 order-last md:order-none mt-4 md:mt-10">
                        <img src="https://placehold.co/300x200" alt="Blog Image"
                            class="w-full md:w-[750px] h-48 sm:h-60 md:h-80 object-cover shadow-md" />
                    </div>
                </header>

                <!-- Content Section -->
                <p class="px-2 sm:px-4 lg:px-11 font-lora text-base sm:text-lg lg:text-xl text-gray-700 leading-10">
                    {{ $post->body }}
                </p>
            </article>
        </div>
    </article>
</x-layout>
