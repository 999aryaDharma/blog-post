<h1>Blog Posts dari {{ $user->name }}</h1>

@foreach ($posts as $post)
    <div>
        <h2>{{ $post->title }}</h2>
        <p>{{ $post->content }}</p>
    </div>
@endforeach
