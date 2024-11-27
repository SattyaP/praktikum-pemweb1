<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
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
        $post = Post::where('code_post', $code_post)->with('postCategories')->first();
        $totalLikes = $post->likes()->where('like', 1)->count();
        $totalDislikes = $post->likes()->where('like', 0)->count();
        return view('posts.show', compact('post', 'totalLikes', 'totalDislikes'));
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

    public function search(Request $request)
    {
        $posts = Post::where('title', 'like', "%$request->q%")->paginate(10);
        $allPosts = Post::all();
        $categories = Category::all();
        return view('posts.search', compact('posts', 'allPosts', 'categories'));
    }

    public function like(Request $request, string $code_post)
    {
        $post = Post::where('code_post', $code_post)->first();
        $like = $post->likes()->user(auth()->id())->first();
        if ($like) {
            $like->update([
                'like' => 1
            ]);
        } else {
            $post->likes()->create([
                'user_id' => auth()->id(),
                'like' => 1
            ]);
        }
        return redirect()->back();
    }

    public function dislike(Request $request, string $code_post)
    {
        $post = Post::where('code_post', $code_post)->first();
        $like = $post->likes()->user(auth()->id())->first();
        if ($like) {
            $like->update([
                'like' => 0
            ]);
        } else {
            $post->likes()->create([
                'user_id' => auth()->id(),
                'like' => 0
            ]);
        }
        return redirect()->back();
    }

    public function approve(Request $request, int $id)
    {
        $comment = Comment::find($id);
        $comment->update([
            'status' => Comment::STATUS_APPROVED
        ]);
        return redirect()->back();
    }

    public function reject(Request $request, int $id)
    {
        $comment = Comment::find($id);
        $comment->update([
            'status' => Comment::STATUS_REJECTED
        ]);
        return redirect()->back();
    }
}
