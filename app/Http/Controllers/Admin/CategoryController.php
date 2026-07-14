<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Lab 09 - Validation
use App\Http\Requests\Admin\CategoryRequest; // Lab 10
use Illuminate\Support\Str; // Lab 10
use Illuminate\Support\Facades\Storage; // Lab 10
// use Illuminate\Support\Facades\DB; // Lab 06 - Query Builder
use App\Models\Category; // Lab 07 - Eloquent ORM

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // ===================== LAB 06 - Query Builder =====================
        // $list = DB::table('categories')
        //     ->select('cateid', 'catename', 'slug', 'image', 'status')
        //     ->where('status', 1)
        //     ->orderBy('catename')
        //     ->get();
        // ==================================================================

        // ===================== LAB 07 - Eloquent ORM =====================
        $limit = $request->input('limit', 10);
        $list = Category::where('status', 1)->orderBy('catename')->paginate($limit);
        // =================================================================

        return view('admin.categories.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        // ===================== LAB 07 - Eloquent ORM & LAB 10 Image Upload =====================
        try {
            // Upload hình ảnh (nếu có)
            $fileName = null;
            if ($request->hasFile('img')) {
                $file = $request->file('img');
                $fileName = Str::slug($request->catename)
                    . '-' . time()
                    . '.' . $file->extension();
                // hình ảnh được lưu vào thư mục storage/app/public/categories
                $file->storeAs('categories', $fileName, 'public');
            }

            Category::create([
                'catename'    => $request->catename,
                'slug'        => $request->slug,
                'status'      => $request->input('status', 1),
                'sort_order'  => $request->input('sort_order', 0),
                'description' => $request->input('description'),
                'image'       => $fileName,
            ]);
            return redirect()->route('admin.categories.index')->with('success', 'Thêm danh mục thành công!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Lỗi thêm mới: ' . $e->getMessage());
        }
        // =================================================================
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
        // ===================== LAB 06 - Query Builder =====================
        // $category = DB::table('categories')->where('cateid', $id)->first();
        // ==================================================================

        // ===================== LAB 07 - Eloquent ORM =====================
        $category = Category::find($id);
        // =================================================================

        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        // ===================== LAB 07 - Eloquent ORM & LAB 10 Image Upload =====================
        try {
            $category = Category::findOrFail($id);
            $fileName = $category->image;

            if ($request->hasFile('img')) {
                // Xóa hình ảnh cũ
                if ($fileName) {
                    Storage::disk('public')->delete('categories/' . $category->image);
                }
                // Upload hình ảnh mới
                $file = $request->file('img');
                $fileName = Str::slug($request->catename)
                            . '-' . time()
                            . '.' . $file->extension();
                $file->storeAs('categories', $fileName, 'public');
            }

            $category->update([
                'catename' => $request->catename,
                'slug'     => $request->slug,
                'status'   => $request->status,
                'image'    => $fileName,
            ]);
            return redirect()->route('admin.categories.index')->with('success', 'Sửa danh mục thành công!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Lỗi cập nhật: ' . $e->getMessage());
        }
        // =================================================================
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Category::findOrFail($id)->delete();
            return redirect()
                ->route('admin.categories.index')
                ->with('success', 'Xóa mềm danh mục thành công.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Thực hiện xóa mềm thất bại: ' . $e->getMessage());
        }
    }

    // Hiển thị danh sách các bản ghi đã xóa mềm (Thùng rác)
    public function trash(Request $request)
    {
        $limit = $request->input('limit', 10);
        $list = Category::onlyTrashed()->orderBy('catename')->paginate($limit);
        return view('admin.categories.trash', compact('list'));
    }

    // Khôi phục dữ liệu đã xóa mềm
    public function restore($id)
    {
        try {
            Category::onlyTrashed()->findOrFail($id)->restore();
            return redirect()
                ->route('admin.categories.trash')
                ->with('success', 'Khôi phục danh mục thành công.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Khôi phục thất bại.');
        }
    }

    // Xóa vĩnh viễn dữ liệu khỏi cơ sở dữ liệu
    public function forceDelete($id)
    {
        try {
            Category::onlyTrashed()->findOrFail($id)->forceDelete();
            return redirect()
                ->route('admin.categories.trash')
                ->with('success', 'Xóa vĩnh viễn danh mục thành công.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Xóa vĩnh viễn thất bại.');
        }
    }
}