<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\PostView;
use Illuminate\View\View;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $posts = Post::query()
            ->where('active', '=', 1)
            ->where('published_at',  '!=', 'NULL')
            ->orderBy('published_at', 'desc')
            ->paginate(2);

        return view('home', ['posts' => $posts]);
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post, Request $request)
    {
        if (!$post->active || $post->published_at == 'NULL') {
            throw new NotFoundHttpException();
        }

        $next = Post::query()
            ->where('active', true)
            ->whereDate('published_at', '!=', 'NULL')
            ->whereDate('published_at', '<', $post->published_at)
            ->orderBy('published_at', 'desc')
            ->limit(1)
            ->first();

        $prev = Post::query()
            ->where('active', true)
            ->whereDate('published_at', '!=', 'NULL')
            ->whereDate('published_at', '>', $post->published_at)
            ->orderBy('published_at', 'asc')
            ->limit(1)
            ->first();

        $user = $request->user();

        PostView::create([
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'post_id' => $post->id,
            'user_id' => $user?->id
        ]);

        return view('post.view', ['post' => $post, 'prev' => $prev, 'next' => $next]);
    }

    public function byCategory(Category $category) {

        $posts = Post::query()
        ->join('category_post', 'posts.id', '=', 'category_post.post_id')
        ->where('category_post.category_id', '=', $category->id)
        ->where('active', '=', true)
        ->whereDate('published_at', '!=', 'NULL')
        ->orderBy('published_at', 'desc')
        ->paginate(10);

        return view('post.index', ['posts' => $posts, 'category' => $category]);
    }
}
