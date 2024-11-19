<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function posts()
    {
        $posts = Post::with('comments', 'categories')->orderBy('created_at', 'desc')->paginate(10);
        $allPosts = Post::all();
        $categories = Category::all();
        return view('posts.index', compact('posts', 'allPosts', 'categories'));
    }

    public function postShow(string $code_post)
    {
        $post = Post::where('code_post', $code_post)->first();
        return view('posts.show', compact('post'));
    }

    public function postComment(Request $request, string $code_post)
    {
        $post = Post::where('code_post', $code_post)->first();
        $post->comments()->create([
            'user_id' => auth()->id(),
            'contents' => $request->contents
        ]);
        return redirect()->back();
    }
}
