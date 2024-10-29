<?php

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Helpers\TextHelper;
use App\Http\Middleware\SearchFilter;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', [PostController::class, 'index'])->name('posts');

Route::get('/posts/{post:slug}', function (Post $post) {
    return view('post', ['title' => $post->title, 'post' => $post]);
});

Route::get('checkSlug', [PostController::class, 'checkSlug']);


Route::middleware(['auth'])->group(function () {

    Route::get('/post/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/post/create', [PostController::class, 'store'])->name('posts.store');

    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::patch('/posts/{post}/edit', [PostController::class, 'update'])->name('posts.update');

    Route::delete('/posts/{post}/delete', [PostController::class, 'destroy'])->name('posts.destroy');

    Route::get('/my-posts/{user:username}', [PostController::class, 'userPosts'])->name('my-posts');

    Route::get('/posts/{title}', [PostController::class, 'show'])->name('posts.show');

    

});


Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'], ['title' => 'Profile'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});



Route::get('/categories/{category:slug}', function (Category $category) {
    // Batasi body untuk setiap postingan di dalam rute
    $posts = TextHelper::limitBodyContent($category->posts);
    
    // Kirim data ke view
    return view('posts', [
        'title' => 'Articles in: ' . $category->name,
        'posts' => $posts
    ]);
})->name('categories.show');


Route::get('/authors/{user:username}', function (User $user) {
    // Dapatkan semua post berdasarkan author_id
    $posts = TextHelper::limitBodyContent($user->posts);
    
    // Tampilkan view dengan data
    return view('posts', [
        'title' => 'Articles by: ' . $user->username,
        'posts' => $posts
    ]);
});


require __DIR__.'/auth.php';
