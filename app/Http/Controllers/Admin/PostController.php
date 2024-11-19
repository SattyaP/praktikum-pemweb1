<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $collections = Post::with('user', 'categories')->orderBy('created_at', 'asc')->paginate(10);

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
        try {
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
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}