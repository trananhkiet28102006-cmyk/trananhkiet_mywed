<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Lab 09 - Validation
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
    public function store(Request $request)
    {
        // ===================== LAB 06 - Query Builder =====================
        // DB::table('categories')->insert([
        //     'catename'   => $request->catename,
        //     'slug'       => $request->slug,
        //     'created_at' => now(),
        //     'updated_at' => now()
        // ]);
        // ==================================================================

        // ===================== LAB 09 - Validation =====================
        $request->validate(
            // Param 1: Rules
            [
                'catename' => 'required|min:3|max:100|unique:categories,catename',
                'slug'     => [
                    'required',
                    'min:5',
                    'max:150',
                    'unique:categories,slug',
                    'regex:/^[a-z0-9-]+$/'
                ],
                'status'   => 'required|in:0,1'
            ],
            // Param 2: Messages
            [
                'required'   => ':attribute không được để trống.',
                'min'        => ':attribute phải từ :min ký tự trở lên.',
                'max'        => ':attribute không vượt quá :max ký tự.',
                'unique'     => ':attribute đã tồn tại.',
                'slug.regex' => ':attribute chỉ được chứa chữ thường, số và dấu gạch ngang (-).',
                'status.in'  => ':attribute không hợp lệ.'
            ],
            // Param 3: Attributes
            [
                'catename' => 'Tên loại',
                'slug'     => 'Đường dẫn (Slug)',
                'status'   => 'Trạng thái'
            ]
        );
        // ==================================================================

        // ===================== LAB 07 - Eloquent ORM =====================
        try {
            Category::create([
                'catename'    => $request->catename,
                'slug'        => $request->slug,
                'status'      => $request->input('status', 1),
                'sort_order'  => $request->input('sort_order', 0),
                'description' => $request->input('description'),
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
    public function update(Request $request, string $id)
    {
        // ===================== LAB 06 - Query Builder =====================
        // DB::table('categories')
        //     ->where('cateid', $id)
        //     ->update([
        //         'catename'   => $request->catename,
        //         'slug'       => $request->slug,
        //         'updated_at' => now()
        //     ]);
        // ==================================================================

        // ===================== LAB 09 - Validation =====================
        $request->validate(
            // Param 1: Rules
            [
                'catename' => 'required|min:3|max:100|unique:categories,catename,' . $id . ',cateid',
                'slug'     => [
                    'required',
                    'min:5',
                    'max:150',
                    'regex:/^[a-z0-9-]+$/',
                    Rule::unique('categories', 'slug')->ignore($id, 'cateid'),
                ],
                'status'   => 'required|in:0,1'
            ],
            // Param 2: Messages
            [
                'required'   => ':attribute không được để trống.',
                'min'        => ':attribute phải từ :min ký tự trở lên.',
                'max'        => ':attribute không vượt quá :max ký tự.',
                'unique'     => ':attribute đã tồn tại.',
                'slug.regex' => ':attribute chỉ được chứa chữ thường, số và dấu gạch ngang (-).',
                'status.in'  => ':attribute không hợp lệ.'
            ],
            // Param 3: Attributes
            [
                'catename' => 'Tên loại',
                'slug'     => 'Đường dẫn (Slug)',
                'status'   => 'Trạng thái'
            ]
        );
        // ==================================================================

        // ===================== LAB 07 - Eloquent ORM =====================
        try {
            Category::find($id)->update([
                'catename' => $request->catename,
                'slug'     => $request->slug,
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
        // ===================== LAB 06 - Query Builder =====================
        // DB::table('categories')->where('cateid', $id)->delete();
        // ==================================================================

        // ===================== LAB 07 - Eloquent ORM =====================
        Category::destroy($id);
        // =================================================================

        return redirect()->route('admin.categories.index');
    }
}