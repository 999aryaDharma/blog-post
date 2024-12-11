<?php

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Http\Middleware\SearchFilter;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', [PostController::class, 'index'])->name('posts');

Route::get('/posts/{post:slug}', [PostController::class, 'show'])->name('posts.show');

Route::get('checkSlug', [PostController::class, 'checkSlug']);


Route::middleware(['auth'])->group(function () {

    Route::get('/post/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/post/create', [PostController::class, 'store'])->name('posts.store');

    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::patch('/posts/{post}/edit', [PostController::class, 'update'])->name('posts.update');

    Route::delete('/posts/{post}/delete', [PostController::class, 'destroy'])->name('posts.destroy');

    Route::get('/my-posts/{user:username}', [PostController::class, 'userPosts'])->name('my-posts');
    
    Route::post('/posts/{post}/vote', [VoteController::class, 'vote'])->name('posts.vote');

    Route::post('/upload-image', [PostController::class, 'upload'])->name('ckeditor.upload');

    

});


Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'], ['title' => 'Profile'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});



Route::get('/categories/{category:slug}', [PostController::class, 'index'])->name('categories.show');



Route::get('/authors/{user:username}', function (User $user) {
    // Ambil semua post yang terfilter berdasarkan kategori
    $posts = Post::filter(request(['search'])) // Menggunakan scope filter
            ->whereHas('author', function ($query) use ($user) {
                $query->where('author_id', $user->id); // Pastikan kita memfilter berdasarkan ID penulis
            })
            ->latest() // Mengurutkan berdasarkan waktu terbaru
            ->take(10)
            ->get();

    // dd($posts);

    // \DB::enableQueryLog(); // Mengaktifkan log query

    // Melihat query yang dijalankan di log
    // dd(\DB::getQueryLog());

    // Tampilkan view dengan data
    return view('posts', [
        'title' => 'Articles by: ' . $user->username,
        'posts' => $posts,
    ]);
});


require __DIR__.'/auth.php';
