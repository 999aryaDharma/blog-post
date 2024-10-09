<x-layout>
  <x-slot:title>{{ $title }}</x-slot:title>

  @section('tittle', $title)

    <div class="py-4 px-4 mx-auto max-w-screen-xl lg:px-6">
      <div class="mx-auto max-w-screen-md sm:text-center">
          <form>
            @if (request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
             @if (request('author'))
                <input type="hidden" name="author" value="{{ request('author') }}">
            @endif
            <div class="items-center mx-auto mb-3 space-y-4 max-w-screen-sm sm:flex sm:space-y-0">
                <div class="relative w-full">
                    <label for="search" class="hidden mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Search</label>
                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input class="block p-3 pl-10 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 sm:rounded-none sm:rounded-l-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" autocomplete="off" placeholder="Search for article" type="search" id="search" name="search" value="{{ request('search') }}">
                </div>
                <div>
                    <button type="submit" class="py-3 px-5 w-full text-sm font-medium text-center text-white rounded-lg border cursor-pointer bg-primary-700 border-primary-600 sm:rounded-none sm:rounded-r-lg hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Search</button>
                </div>
            </div>
          </form>
      </div>
    </div>

  <div class="py-2 px-2 mx-auto max-w-screen-xl lg:py-10 lg:px-0">
    <div class="grid gap-10 lg:grid-cols-3 md:grid-cols-2 px-4">
        @forelse ($posts as $post)
        <article class="flex flex-col justify-between p-6 bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
            <div class="relative">
            @if (Auth::check() && Auth::user()->id === $post->author_id && request()->is('my-posts/*'))
                <div id="dropdownButton-{{ $post->id }}" class="mb-1 absolute -right-3 -top-3">
                    <button type="button" class="flex items-center justify-center w-8 h-8 text-gray-500 hover:text-gray-700 focus:outline-none">
                    <!-- Icon titik tiga -->
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <circle cx="10" cy="10" r="2"></circle>
                        <circle cx="10" cy="5" r="2"></circle>
                        <circle cx="10" cy="15" r="2"></circle>
                    </svg>
                    </button>

                    <!-- Dropdown menu -->
                    <div id="dropdownMenu-{{ $post->id }}" class="absolute -right-12 z-10 mt-2 w-30 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none hidden transition transform scale-95 opacity-0 duration-300 ease-out">
                        <div class="py-1">
                            <a href="{{ route('posts.edit', $post->id) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit</a>
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="flex justify-start space-x-1.5 items-center mb-5 text-gray-500">
                @foreach ($post->categories as $category)
                    <a href="/?category={{ $category->slug }}" class="text-md">
                        <span class="bg-{{ $category->color }}-100 text-primary-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded dark:bg-primary-200 dark:text-primary-800">
                            {{ $category->name }}
                        </span>
                    </a>
                @endforeach
            </div>
                
            <a href="/posts/{{ $post['slug'] }}" class="flex items-center  space-x-3">
                <h2 class="font-headline mb-2 text-2xl font-bold tracking-tight hover:underline text-gray-900 dark:text-white">{{ $post['title'] }}  </h2>
                <p class="mb-2 text-gray-700"> | </p>
                <p class="text-xs mb-1 items-center text-gray-400 no-underline">{{ $post->created_at->format('d M Y') }}</p> 
            </a>
            <p class="font-[Segoe UI] mb-5 font-light text-gray-500 dark:text-gray-400">{{ $post->body }}.</p>

            <!-- Element ini diatur untuk berada di bagian paling bawah -->
            <div class="flex justify-between items-center mt-auto">
                <a href="/?author={{ $post->author->username }}">
                    <div class="flex items-center space-x-3">
                        <img src="{{ Storage::url($post->author->profile_photo) }}" alt="{{ $post->author->name }}" class="w-10 h-10 rounded-full object-cover">
                        <span class="font-medium text-sm dark:text-white">{{ $post->author->name }}</span>
                    </div>
                </a>
                <a href="/posts/{{ $post['slug'] }}" class="inline-flex items-center font-medium text-blue-400 dark:text-primary-500 hover:underline text-sm">
                    Read more
                    <svg class="ml-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </a>
            </div>
        </article>
        @empty
            <div style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);" class="flex flex-col justify-between px-16 py-8 bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700 mt-12">
                <p class="font-semibold text-2xl mb-4">Article not found!</p>
                <a href="/" class="font-medium text-sm text-blue-600 hover:underline">&laquo; Back to all posts</a>
            </div>
        @endforelse
    </div>  
  </div>

  <!-- Button to create new post -->
  <a href="/posts/create" class="fixed bottom-6 right-6 bg-blue-500 text-white rounded-full p-4 shadow-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
    </svg>
  </a>

</x-layout>

<script>
// Toggle visibility of dropdown menus with animation
document.querySelectorAll('[id^=dropdownButton-]').forEach(button => {
    button.addEventListener('click', (event) => {
        event.stopPropagation(); // Prevent closing when clicking the button
        const dropdownId = button.id.replace('Button', 'Menu');
        const dropdownMenu = document.getElementById(dropdownId);

        // Toggle show class to add/remove animation
        if (dropdownMenu.classList.contains('hidden')) {
            // Show the dropdown with animation
            dropdownMenu.classList.remove('hidden');
            dropdownMenu.classList.remove('scale-95', 'opacity-0');
            dropdownMenu.classList.add('scale-100', 'opacity-100');
        } else {
            // Hide the dropdown with animation
            dropdownMenu.classList.remove('scale-100', 'opacity-100');
            dropdownMenu.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                dropdownMenu.classList.add('hidden');
            }, 300); // Match the transition duration in Tailwind
        }
    });
});

// Optional: Close dropdowns when clicking outside
document.addEventListener('click', function(event) {
    document.querySelectorAll('[id^=dropdownMenu-]').forEach(menu => {
        if (!menu.classList.contains('hidden')) {
            menu.classList.remove('scale-100', 'opacity-100');
            menu.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                menu.classList.add('hidden');
            }, 300); // Match the transition duration
        }
    });
});
;
</script>
