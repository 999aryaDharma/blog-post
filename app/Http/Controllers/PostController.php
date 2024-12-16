<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Category $category = null)
    {
        // Mengambil 3 post dengan views terbanyak untuk most popular
        $popularPosts = Post::withCount(['votes as upvotes' => function ($query) {
            $query->where('vote', 'up');
        }])
        ->orderByDesc('upvotes')
        ->take(5)
        ->get();

        // Mengambil 3 post terbaru berdasarkan created_at
        $latestPosts = Post::latest()->take(3)->get();

        // Filter berdasarkan kategori jika parameter kategori ada
        $postsQuery = Post::filter($request->only(['search', 'author']))->with('votes');
        if ($category) {
            $postsQuery->whereHas('categories', function ($query) use ($category) {
                $query->where('slug', $category->slug);
            });
            $title = 'Articles in: ' . $category->name;
        } else {
            $title = 'All Posts';
        }

        $posts = $postsQuery->latest()->take(10)->get();

        $users = User::inRandomOrder()->take(3)->get();

        // Ambil semua kategori
        $categories = Category::all()->shuffle();

        // Ambil hanya 4 kategori untuk ditampilkan di index
        $visibleCategories = $categories->take(4);

        // Ambil sisa kategori yang tidak ditampilkan
        $sisaCategories = $categories->slice(4);

        return view('posts', compact(
            'title', 
            'posts', 
            'categories', 
            'users', 
            'latestPosts', 
            'visibleCategories', 
            'sisaCategories', 
            'popularPosts'
        ));
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
            // Jika tidak ada gambar, set thumbnail ke null
            $validatedData['thumbnail'] = null;
        }

        // Menangani gambar yang di-upload melalui CKEditor (pastikan data gambar ada dalam body)
        $bodyContent = $validatedData['body'];

        // Temukan semua tag gambar <img> dalam body content
        preg_match_all('/<img[^>]+src="([^">]+)"/', $bodyContent, $matches);
        $imageUrls = $matches[1];

        foreach ($imageUrls as $imageUrl) {
            // Periksa apakah URL gambar valid (misalnya, gambar diupload melalui CKEditor)
            if (strpos($imageUrl, 'storage') !== false) {
                // Simpan gambar ke dalam folder yang sesuai dan perbarui URL
                $imagePath = Storage::disk('public')->path($imageUrl);

                // Pindahkan atau simpan ulang gambar sesuai kebutuhan
                $newImagePath = 'images/uploads/' . basename($imagePath);
                Storage::disk('public')->move($imagePath, $newImagePath);

                // Perbarui URL gambar dalam konten
                $bodyContent = str_replace($imageUrl, Storage::url($newImagePath), $bodyContent);
            }
        }

        // Update body content dengan gambar yang sudah dipindahkan
        $validatedData['body'] = $bodyContent;

        // Buat post baru dengan data yang divalidasi
        $post = Post::create($validatedData);

        // Sinkronisasi kategori yang dipilih
        $post->categories()->sync($validatedData['categories']);

        // Redirect dengan pesan sukses
        return redirect('/')->with('success', 'Post created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('single-post', ['title' => $post->title, 'post' => $post]);
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
        $validatedData = $request->validate([
            'title' => 'required|max:150',
            'excerpt' => 'required|max:100',
            'slug' => 'required|unique:posts,slug,' . $post->id,
            'categories' => 'required|array',
            'body' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        $validatedData['author_id'] = auth()->user()->id;

        if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
            $titleSlug = Str::slug($validatedData['title']);
            $extension = $request->file('thumbnail')->getClientOriginalExtension();
            $thumbnailName = "{$titleSlug}_" . time() . ".{$extension}";

            $thumbnailPath = $request->file('thumbnail')->storeAs('images/thumbnails', $thumbnailName, 'public');
            $validatedData['thumbnail'] = $thumbnailPath;

            if ($post->thumbnail) {
                Storage::disk('public')->delete($post->thumbnail);
            }
        } else {
            $validatedData['thumbnail'] = $post->thumbnail; // Pertahankan thumbnail lama
        }

        $bodyContent = $validatedData['body'];
        preg_match_all('/<img[^>]+src="([^">]+)"/', $bodyContent, $matches);
        $imageUrls = $matches[1];

        foreach ($imageUrls as $imageUrl) {
            if (strpos($imageUrl, 'storage') !== false) {
                $imagePath = Storage::disk('public')->path($imageUrl);
                $newImagePath = 'images/uploads/' . basename($imagePath);
                Storage::disk('public')->move($imagePath, $newImagePath);

                $bodyContent = str_replace($imageUrl, Storage::url($newImagePath), $bodyContent);
            }
        }

        $post->update([
            'title' => $validatedData['title'],
            'excerpt' => $validatedData['excerpt'],
            'slug' => $validatedData['slug'],
            'author_id' => $validatedData['author_id'],
            'body' => $bodyContent,
            'thumbnail' => $validatedData['thumbnail'],
        ]);

        $post->categories()->sync($validatedData['categories']);

        return redirect('/my-posts/' . $post->author->username)->with('success', 'Post updated successfully.');
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

    public function userPosts(User $user, Request $request)
    {
        $posts = Post::where('author_id', $user->id)
            ->filter($request->only(['search', 'category', 'author']))
            ->latest()
            ->get();
        $categories = Category::all();
        $users = User::all();
        

        // Kirim data ke view
        return view('user-posts', [
            'title' => $user->username . "'s Posts" ,
            'posts' => $posts,
            'categories' => $categories,
            'users' => $users

        ], compact('user'));
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $path = $file->store('images/uploads', 'public'); // Menyimpan di public storage

            // Mendapatkan URL lengkap untuk gambar yang diunggah
            $url = Storage::url($path);

            return response()->json([
                'url' => $url
            ]);
        }

        return response()->json(['error' => 'Upload failed'], 400);
    }





}
