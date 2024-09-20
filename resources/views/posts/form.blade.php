<x-layout>
<x-slot:title>{{ isset($post) ? 'Edit Post' : 'Create Post' }}</x-slot:title>

<div class="container mx-auto max-w-screen-xl lg:px-0">
    <form action="{{ isset($post) ? route('posts.update', $post->id) : route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($post))
            @method('PATCH')
        @endif
        
        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
            <input type="text" id="title" name="title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('title', $post->title ?? '') }}" required>
        </div>

        <div class="mb-4">
            <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
            <input type="text" id="slug" name="slug" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('slug', $post->slug ?? '') }}" required>
        </div>
        
        <div class="mb-4">
            <label for="body" class="block text-sm font-medium text-gray-700">Body</label>
            <input type="hidden" id="body" name="body" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('body', $post->body ?? '') }}">
            <trix-editor input="body"></trix-editor>
        </div>

        <div class="mb-4">
            <label for="categories" class="block text-sm font-medium text-gray-700">Select Categories</label>
            <div class="mt-2.5">
                @foreach ($categories as $category)
                    <div class="flex items-center mt-1.5">
                        <input type="checkbox" name="categories[]" id="category-{{ $category->id }}" value="{{ $category->id }}"
                        {{ isset($post) && $post->categories->contains($category->id) ? 'checked' : '' }}
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="category-{{ $category->id }}" class="ml-2 block text-sm text-gray-900">{{ $category->name }}</label>
                    </div>
                @endforeach
            </div>
        </div>
        
        <button type="submit" class="mt-2 inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            {{ isset($post) ? 'Update Post' : 'Create Post' }}
        </button>
    </form>
</div>

</x-layout>


<script>
    const title = document.querySelector('#title');
    const slug = document.querySelector('#slug');

    title.addEventListener('change', function() {
        fetch('/posts/checkSlug?title=' + title.value)
            .then(response => response.json())
            .then(data => slug.value = data.slug)
    });

    document.addEventListener('trix-file-accept', function(e) {
        e.preventDefault();
    })

</script>
