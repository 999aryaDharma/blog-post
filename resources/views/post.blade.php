<x-layout>
  <x-slot:title>{{ $title }}</x-slot:title>

  {{-- <article class="py-8 max-w-screen-md border-b ">
   <h2 class="mb-1 text-3xl tracking-light font-bold text-gray-800 hover:underline">{{ $post['title'] }}</h2>
    <div>
      By
      <a href="/authors/{{ $post->author->username }}" class="text-base text-gray-500 hover:underline">{{ $post->author->name }}</a> 
      in
      <a href="/categories/{{ $post->category->slug }}" class="text-base text-gray-500 hover:underline">{{ $post->category->name }}</a>
      | {{ $post->created_at->diffForHumans
      () }}
    </div>
    <p class="my-4 font-light">{{ ($post['body']) }}.</p>
    <a href="/posts" class="font-medium text-blue-600 hover:underline">&laquo; Back to post </a>
  </article> --}}


<article class="pt-4 pb-16 lg:pt-8 lg:pb-24 bg-white antialiased">
  <div class="flex justify-between px-4 mx-auto max-w-screen-xl ">
    <article class="mx-auto w-full max-w-5xl format format-sm sm:format-base lg:format-lg format-blue">
        <header class="mb-4 lg:mb-6 not-format">
          <a href="/" class="font-medium text-sm text-blue-600 hover:underline" >&laquo; Back to all posts </a>
            <address class="flex items-center my-6 not-italic">
                <div class="inline-flex items-center mr-3 text-sm text-gray-900">
                    <img src="{{ $post->author->profile_photo ? asset('storage/' . $post->author->profile_photo) : asset('images/default.png') }}" alt="{{ $post->author->name }}" class="w-14 h-14 rounded-full object-cover">
                    <div class="ml-2">
                        <a href="{{ '/authors/' . $post->author->username }}" rel="author" class="text-xl font-bold text-gray-900">{{ $post->author->name }}</a>
                        <p class="text-base text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                          @foreach ($post->categories as $category)
                          <span class="bg-{{ $category->color }}-100 text-gray-500 text-xs inline-flex items-center rounded mb-1 mt-3 -ml-0.5 p-1">
                              <a href="/categories/{{ $category->slug }}" class="text-primary-800 ">
                                {{ $category->name }} 
                              </a>
                          </span>
                          @if (!$loop->last)
                            |&nbsp;
                          @endif
                          @endforeach
                        </a>
                    </div>
                </div>
            </address>
            <h3 class="mb-4 text-xl font-extrabold leading-tight text-gray-900 lg:mb-6 lg:text-4xl">{{ $post['title'] }}</h3>
        </header>          
        <p class="font-[Segoe UI]">{!! ($post['body']) !!}</p>
    </article>
  </div>
</article>

</x-layout>

{{-- @if ($post->image)
    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="rounded-lg">
@endif --}}
