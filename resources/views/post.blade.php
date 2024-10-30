<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <article class=" pt-8 pb-20 px-72 lg:pt-8 lg:pb-24 bg-white antialiased">
        <div class="flex justify-between mx-auto max-w-screen-xl">
            <article class="px-12 mx-auto w-full max-w-5xl format format-sm sm:format-base lg:format-lg place-content-center">
                <header class="mb-4 lg:mb-6 not-format">
                    <a href="/" class="pl-10 font-medium text-sm text-blue-600 hover:underline">
                        &laquo; Back to all posts
                    </a>
                    <div class="pl-11">
                        <!-- Category Section with no gap above title -->
                        <div class="mt-8 relative top-3 flex items-center">
                            @foreach ($post->categories as $category)
                                <span class="bg-{{ $category->color }}-100 text-gray-500 text-xs rounded mb-1 mt-1 mx-1 py-1 px-2">
                                    <a href="/categories/{{ $category->slug }}" class="text-primary-800">
                                        {{ $category->name }}
                                    </a>
                                </span>
                            @endforeach
                        </div>

                        <!-- Title Section directly below categories -->
                        <h3 class="text-xl font-bold leading-tight text-gray-900 lg:mb-6 lg:text-4xl mt-2">
                            {{ $post['title'] }}
                        </h3>

                        <!-- Author Section -->
                        <address class="flex items-center my-6 not-italic">
                            <div class="inline-flex items-center mr-3 text-sm text-gray-900">
                                <img src="{{ $post->author->profile_photo ? asset('storage/' . $post->author->profile_photo) : asset('images/default.png') }}" 
                                    alt="{{ $post->author->name }}" class="w-10 h-10 rounded-full object-cover">
                                <div class="ml-3">
                                    <a href="{{ '/authors/' . $post->author->username }}" rel="author" 
                                        class="text-sm font-bold text-gray-900">{{ $post->author->name }}</a>
                                    <p class="text-md text-gray-500">{{ $post->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                        </address>
                    </div>
                </header>

                <!-- Content Section -->
                <p class="pl-11 font-[Roboto] text-xl text-thin text-gray-700">{{ $post->body }}</p>

                <div class="ml-11 max-w-4xl h-auto md:h-auto flex-shrink-0 order-last md:order-none mt-8 md:mt-10 ">
                            <img src="https://placehold.co/300x200" alt="Blog Image"
                                class="w-[750px] h-80 object-cover shadow-md" />
                </div>
            </article>
        </div>
    </article>
</x-layout>

{{-- Optional image section if the post has an image --}}
{{-- @if ($post->image) --}}
{{--     <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="rounded-lg"> --}}
{{-- @endif --}}
