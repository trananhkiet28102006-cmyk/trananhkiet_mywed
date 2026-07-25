<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Hiển thị danh sách Tin Tức / Bài viết
     */
    public function index()
    {
        $posts = Post::with('user')
            ->where('status', 1)
            ->latest('created_at')
            ->paginate(9);

        return view('client.post.index', compact('posts'));
    }

    /**
     * Hiển thị Chi Tiết Bài viết Tin Tức
     */
    public function show($slug)
    {
        $post = Post::with('user')
            ->where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        // Lấy 4 bài viết liên quan khác
        $relatedPosts = Post::where('status', 1)
            ->where('id', '!=', $post->id)
            ->latest('created_at')
            ->take(4)
            ->get();

        return view('client.post.show', compact('post', 'relatedPosts'));
    }
}
