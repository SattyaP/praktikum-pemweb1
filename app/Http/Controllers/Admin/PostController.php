<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $collections = Post::with('postCategories', 'categories')
                ->orderBy('created_at', 'asc')
                ->paginate(10);
        } else {
            $collections = Post::with('postCategories', 'categories')
                ->whereHas('postCategories', function ($query) {
                    $query->where('user_id', auth()->user()->id);
                })
                ->orderBy('created_at', 'asc')
                ->paginate(10);
        }
        return view('admin.posts.index', compact('collections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'contents' => 'required',
            'category_id' => 'required|array',
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ], [
            'title.required' => 'Judul harus diisi',
            'contents.required' => 'Konten harus diisi',
            'category_id.required' => 'Kategori harus dipilih',
            'category_id.array' => 'Kategori harus dipilih',
            'image.required' => 'Gambar harus diisi',
        ]);

        $request['slug'] = Str::slug($request->title);
        $request['code_post'] = 'POST-' . time();
        $request['excerpt'] = Str::limit(strip_tags($request->contents), 200);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/posts', $image->hashName());
        }

        $post = Post::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'code_post' => $request->code_post,
            'contents' => $request->contents,
            'excerpt' => $request->excerpt,
            'image' => $image->hashName(),
            'user_id' => auth()->user()->id,
        ]);

        $postCategories = [];

        foreach ($request->input('category_id') as $category) {
            $postCategories[] = [
                'post_id' => $post->id,
                'category_id' => $category,
                'user_id' => auth()->user()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        PostCategory::insert($postCategories);

        return redirect()->route('admin.posts.index')->with('success', 'Post berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::with('categories')->findOrFail($id);
        $categories = Category::all();

        return view('admin.posts.show', compact('post', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::with('categories')->findOrFail($id);
        $categories = Category::all();

        return view('admin.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'title' => 'required',
                'contents' => 'required',
                'category_id' => 'required|array',
                'image' => 'image|mimes:jpeg,jpg,png|max:2048',
            ], [
                'title.required' => 'Judul harus diisi',
                'contents.required' => 'Konten harus diisi',
                'category_id.required' => 'Kategori harus dipilih',
                'category_id.array' => 'Kategori harus dipilih',
            ]);

            $request['slug'] = Str::slug($request->title);
            $request['excerpt'] = Str::limit(strip_tags($request->contents), 200);

            $post = Post::findOrFail($id);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $image->storeAs('public/posts', $image->hashName());
            }

            $post->update([
                'title' => $request->title,
                'slug' => $request->slug,
                'contents' => $request->contents,
                'excerpt' => $request->excerpt,
                'image' => $request->hasFile('image') ? $image->hashName() : $post->image,
                'user_id' => auth()->user()->id,
            ]);

            $post->categories()->detach();
            foreach ($request->category_id as $category) {
                $post->categories()->attach($category, ['user_id' => auth()->user()->id]);
            }

            return redirect()->route('admin.posts.index')->with('success', 'Post berhasil diubah');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $post = Post::findOrFail($id);
            $post->categories()->detach();
            $post->delete();

            return redirect()->route('admin.posts.index')->with('success', 'Post berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
