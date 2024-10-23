<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        $title = 'All Posts';
        $posts = auth()->user()->posts()->get();

        return view('posts', ['posts' => $posts])->with('title', $title);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        // Pass categories to the view
        
        return view('posts.form', [
            'categories' => $categories,
            'title' => 'Create New Post'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data yang diinput oleh pengguna
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|unique:posts,slug',
            'categories' => 'required|array',  // Pastikan categories sebagai array
            'body' => 'required',
            'images' => 'array',
        ]);

        // Tambahkan ID penulis (user yang sedang login)
        $validatedData['author_id'] = auth()->user()->id;

        // Buat post baru dengan data yang divalidasi
        $post = Post::create([
            'title' => $validatedData['title'],
            'slug' => $validatedData['slug'],
            'author_id' => $validatedData['author_id'],
            'body' =>  $validatedData['body'],
            'images' => $validatedData['images'],
        ]);

        // Simpan setiap gambar ke dalam tabel post_images
        if ($request->has('images')) {
            foreach ($request->images as $image) {
                $post->images()->create(['image_url' => $image]);
            }
        }
        
        // Sinkronisasi kategori yang dipilih
        $post->categories()->sync($validatedData['categories']);

        $posts = Post::where('author_id', auth()->id())->get();


        // Redirect dengan pesan sukses
        return redirect('/')->with('success', 'Post created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::with('categories')->find($id);
        return view('posts', compact('post'));
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

        return view('posts.form', ['title' => 'Edit Post', 'categories' => $categories,])->with(compact('post'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::findOrFail($id);

        $validatedData = $request->validate([
        'title' => 'required|max:255',
        'body' => 'required',
        'categories' => 'required|array',
        ]);

        $post->update([
            'title' => $request->title,
            'body' => $request->body,
            'categories' => $request->categories,
        ]);

        // Sinkronisasi kategori yang dipilih
        $post->categories()->sync($validatedData['categories']);

        return redirect()->route('posts')->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Temukan post berdasarkan ID
        $post = Post::findOrFail($id);
        
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Post::class, 'slug', $request->title);
        return response()->json(['slug' => $slug]);
    }

    public function userPosts(User $user)
    {
        // Dapatkan semua post berdasarkan author_id dan batasi body di controller
        $posts = Post::where('author_id', $user->id)->get()->map(function ($post) {
            $post->body = Str::limit($post->body, 80, '...');
            return $post;
        });

        // Kirim data ke view
        return view('posts', [
            'title' => $user->username . "'s Posts" ,
            'posts' => $posts,
        ]);
    }


}
