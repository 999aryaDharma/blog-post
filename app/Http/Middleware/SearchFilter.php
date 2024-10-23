<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Post;

class SearchFilter
{
    public function handle(Request $request, Closure $next)
    {
        // Ambil parameter filter dari request
        $filters = $request->only(['search', 'category', 'author']);

        // Mengambil post dengan filter yang diterapkan
        $posts = Post::filter($filters)->latest()->get();

        // Simpan hasil ke dalam request untuk digunakan di route berikutnya
        $request->attributes->set('posts', $posts);

        return $next($request);
    }
}
