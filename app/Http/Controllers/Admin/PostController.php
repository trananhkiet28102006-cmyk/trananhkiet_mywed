<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB; // Lab 06 - Query Builder
use App\Models\Post; // Lab 07 - Eloquent ORM

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // ===================== LAB 06 - Query Builder =====================
        // $list = DB::table('posts')
        //     ->join('users', 'posts.user_id', '=', 'users.id')
        //     ->select(
        //         'posts.id',
        //         'posts.title',
        //         'posts.slug',
        //         'posts.image',
        //         'posts.status',
        //         'users.fullname'
        //     )
        //     ->where('posts.status', 1)
        //     ->orderBy('posts.title')
        //     ->get();
        // ==================================================================

        // ===================== LAB 07 - Eloquent ORM =====================
        $limit = $request->input('limit', 10);
        $list = Post::select('id', 'title', 'slug', 'image', 'status', 'user_id')
                    ->with('user:id,fullname')
                    ->where('status', 1)
                    ->orderBy('title')
                    ->paginate($limit);
        // =================================================================

        return view('admin.posts.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = \App\Models\User::select('id', 'fullname')
            ->where('status', 1)
            ->orderBy('fullname')
            ->get();
        return view('admin.posts.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            Post::create([
                'title'   => $request->title,
                'slug'    => $request->slug,
                'content' => $request->content,
                'status'  => $request->input('status', 1),
                'user_id' => $request->user_id,
            ]);
            return redirect()->route('admin.posts.index')->with('success', 'Thêm bài viết thành công!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Lỗi thêm mới: ' . $e->getMessage());
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
        $post = Post::find($id);
        $users = \App\Models\User::select('id', 'fullname')
            ->where('status', 1)
            ->orderBy('fullname')
            ->get();
        return view('admin.posts.edit', compact('post', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            Post::find($id)->update([
                'title'   => $request->title,
                'slug'    => $request->slug,
                'content' => $request->content,
                'status'  => $request->input('status', 1),
                'user_id' => $request->user_id,
            ]);
            return redirect()->route('admin.posts.index')->with('success', 'Sửa bài viết thành công!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Lỗi cập nhật: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
