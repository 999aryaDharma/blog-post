<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        
        // Mengambil 3 post dengan views terbanyak untuk most popular
        $mostPopularPosts = Post::withCount(['votes as upvotes' => function ($query) {
            $query->where('vote', 'up');
        }])
        ->orderByDesc('upvotes')
        ->take(5)
        ->get();

        // Mengambil 3 post terbaru berdasarkan created_at
        $latestPosts = Post::latest()->take(3)->get();

        # Mengambil semua post kecuali yang ada di most popular dan latest
        // $excludedPostIds = $mostPopularPosts->pluck('id')->merge($latestPosts->pluck('id'));
        // $regularPosts = Post::whereNotIn('id', $excludedPostIds)->paginate(10);

        // Mengambil post dengan filter yang diterapkan
        $posts = Post::filter(request(['search', 'category', 'author']))->latest()->take(10)->get();

        $title = 'All Posts';

        $users = User::inRandomOrder()->take(3)->get();

        // Ambil semua kategori
        $categories = Category::all()->shuffle();
        
        // Ambil hanya 4 kategori untuk ditampilkan di index
        $visibleCategories = $categories->take(4);
        
        // Ambil sisa kategori yang tidak ditampilkan
        $sisaCategories = $categories->slice(4);

        return view('posts', compact('title', 'posts', 'categories', 'users', 'latestPosts', 'visibleCategories', 'sisaCategories', 'mostPopularPosts'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        // Pass categories to the view
        
        return view('posts.create', [
            'categories' => $categories,
            'title' => request()->route()->getName() === 'posts.edit' ? 'Edit Post' : 'Create Post'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->all();
        
        // Validasi data yang diinput oleh pengguna
        $validatedData = $request->validate([
            'title' => 'required|max:150',
            'excerpt' => 'required|max:100',
            'slug' => 'required|unique:posts,slug',
            'categories' => 'required|array', // Pastikan categories sebagai array
            'body' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Tambahkan ukuran maksimal
        ]);

        // Tambahkan ID penulis (user yang sedang login)
        $validatedData['author_id'] = auth()->user()->id;

        // Simpan gambar thumbnail jika ada
        if ($request->hasFile('thumbnail')) {
            // Buat nama file berdasarkan judul post, dengan format yang aman
            $titleSlug = Str::slug($validatedData['title']);
            $extension = $request->file('thumbnail')->getClientOriginalExtension();
            $thumbnailName = "{$titleSlug}.{$extension}";

            // Simpan gambar dengan nama baru
            $thumbnailPath = $request->file('thumbnail')->storeAs('images/thumbnails', $thumbnailName, 'public');
            $validatedData['thumbnail'] = $thumbnailPath;
        } else {
            // Jika tidak ada gambar, set thumbnail ke null (atau bisa juga ke default image)
            $validatedData['thumbnail'] = null; // Atau Anda bisa mengatur default path
        }

        // Buat post baru dengan data yang divalidasi
        $post = Post::create([
            'title' => $validatedData['title'],
            'excerpt' => $validatedData['excerpt'],
            'slug' => $validatedData['slug'],
            'author_id' => $validatedData['author_id'],
            'body' => $validatedData['body'],
            'thumbnail' => $validatedData['thumbnail'],
        ]);
        
        // Sinkronisasi kategori yang dipilih
        $post->categories()->sync($validatedData['categories']);

        // Redirect dengan pesan sukses
        return redirect('/')->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
     
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $categories = Category::all();
        $post = Post::findOrFail($id);

        // Pengecekan apakah user yang sedang login adalah pemilik post
        if (Auth::user()->id !== $post->author_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('posts.edit', [
            'title' => request()->route()->getName() === 'posts.edit' ? 'Edit Post' : 'Create Post',
            'categories' => $categories,
        ])->with(compact('post'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        // Validasi data yang diinput oleh pengguna
        $validatedData = $request->validate([
            'title' => 'required|max:150',
            'excerpt' => 'required|max:100',
            'slug' => 'required|unique:posts,slug,' . $post->id, // Update slug harus unik kecuali untuk post yang sedang diupdate
            'categories' => 'required|array', // Pastikan categories sebagai array
            'body' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Tambahkan ukuran maksimal
        ]);

        // Tambahkan ID penulis (user yang sedang login)
        $validatedData['author_id'] = auth()->user()->id;

        // Simpan gambar thumbnail baru jika ada
        if ($request->hasFile('thumbnail')) {
            // Buat nama file berdasarkan judul post, dengan format yang aman
            $titleSlug = Str::slug($validatedData['title']);
            $extension = $request->file('thumbnail')->getClientOriginalExtension();
            $thumbnailName = "{$titleSlug}.{$extension}";

            // Simpan gambar dengan nama baru
            $thumbnailPath = $request->file('thumbnail')->storeAs('images/thumbnails', $thumbnailName, 'public');
            $validatedData['thumbnail'] = $thumbnailPath;

            // Hapus thumbnail lama jika ada
            if ($post->thumbnail) {
                Storage::disk('public')->delete($post->thumbnail);
            }
        } else {
            // Jika tidak ada gambar baru, gunakan thumbnail lama
            $validatedData['thumbnail'] = $post->thumbnail; // Pertahankan thumbnail lama
        }

        // Perbarui post dengan data yang divalidasi
        $post->update([
            'title' => $validatedData['title'],
            'excerpt' => $validatedData['excerpt'],
            'slug' => $validatedData['slug'],
            'author_id' => $validatedData['author_id'],
            'body' => $validatedData['body'],
            'thumbnail' => $validatedData['thumbnail'],
        ]);
        
        // Sinkronisasi kategori yang dipilih
        $post->categories()->sync($validatedData['categories']);

        // Redirect dengan pesan sukses
        return redirect()->route('my-posts')->with('success', 'Post updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Temukan post berdasarkan ID
        $post = Post::findOrFail($id);
        
        $post->delete();

        return back()->with('success', 'Post deleted successfully.');
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Post::class, 'slug', $request->title);
        return response()->json(['slug' => $slug]);
    }

    public function userPosts(User $user)
    {
        $posts = Post::where('author_id', $user->id)->get();
        $categories = Category::all();
        $users = User::all();

        // Kirim data ke view
        return view('user-posts', [
            'title' => $user->username . "'s Posts" ,
            'posts' => $posts,
            'categories' => $categories,
            'users' => $users

        ]);
    }


}
