<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\BrandRequest; // Lab 09
use Illuminate\Support\Str; // Lab 10
use Illuminate\Support\Facades\Storage; // Lab 10
// use Illuminate\Support\Facades\DB; // Lab 06 - Query Builder
use App\Models\Brand; // Lab 07 - Eloquent ORM

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // ===================== LAB 06 - Query Builder =====================
        // $list = DB::table('brands')
        //     ->select('id', 'brandname', 'slug', 'image', 'status')
        //     ->where('status', 1)
        //     ->orderBy('brandname')
        //     ->get();
        // ==================================================================

        // ===================== LAB 07 - Eloquent ORM =====================
        $limit = $request->input('limit', 10);
        $list = Brand::where('status', 1)->orderBy('brandname')->paginate($limit);
        // =================================================================

        return view('admin.brands.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(BrandRequest $request)
    {
        // ===================== LAB 06 - Query Builder =====================
        // DB::table('brands')->insert([
        //     'brandname'  => $request->brandname,
        //     'slug'       => $request->slug,
        //     'created_at' => now(),
        //     'updated_at' => now()
        // ]);
        // ==================================================================

        // ===================== LAB 07 - Eloquent ORM =====================
        try {
            // Upload hình ảnh (nếu có)
            $fileName = null;
            if ($request->hasFile('img')) {
                $file = $request->file('img');
                $fileName = Str::slug($request->brandname)
                    . '-' . time()
                    . '.' . $file->extension();
                // hình ảnh được lưu vào thư mục storage/app/public/brands
                $file->storeAs('brands', $fileName, 'public');
            }

            Brand::create([
                'brandname'   => $request->brandname,
                'slug'        => $request->slug,
                'status'      => $request->input('status', 1),
                'sort_order'  => $request->input('sort_order', 0),
                'description' => $request->input('description'),
                'image'       => $fileName,
            ]);
            return redirect()->route('admin.brands.index')->with('success', 'Thêm thương hiệu thành công!');
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
        $brand = Brand::find($id);
        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandRequest $request, string $id)
    {
        try {
            $brand = Brand::findOrFail($id);
            $fileName = $brand->image;

            if ($request->hasFile('img')) {
                // Xóa hình ảnh cũ
                if ($fileName) {
                    Storage::disk('public')->delete('brands/' . $brand->image);
                }
                // Upload hình ảnh mới
                $file = $request->file('img');
                $fileName = Str::slug($request->brandname)
                            . '-' . time()
                            . '.' . $file->extension();
                $file->storeAs('brands', $fileName, 'public');
            }

            $brand->update([
                'brandname'   => $request->brandname,
                'slug'        => $request->slug,
                'status'      => $request->input('status', 1),
                'sort_order'  => $request->input('sort_order', 0),
                'description' => $request->input('description'),
                'image'       => $fileName,
            ]);
            return redirect()->route('admin.brands.index')->with('success', 'Sửa thương hiệu thành công!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Lỗi cập nhật: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Brand::findOrFail($id)->delete();
            return redirect()->route('admin.brands.index')->with('success', 'Xóa mềm thương hiệu thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Thực hiện xóa mềm thất bại: ' . $e->getMessage());
        }
    }

    public function trash(Request $request)
    {
        $limit = $request->input('limit', 10);
        $list = Brand::onlyTrashed()->orderBy('brandname')->paginate($limit);
        return view('admin.brands.trash', compact('list'));
    }

    public function restore($id)
    {
        try {
            Brand::onlyTrashed()->findOrFail($id)->restore();
            return redirect()->route('admin.brands.trash')->with('success', 'Khôi phục thương hiệu thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Khôi phục thất bại: ' . $e->getMessage());
        }
    }

    public function forceDelete($id)
    {
        try {
            $brand = Brand::onlyTrashed()->findOrFail($id);
            if ($brand->image) {
                Storage::disk('public')->delete('brands/' . $brand->image);
            }
            $brand->forceDelete();
            return redirect()->route('admin.brands.trash')->with('success', 'Xóa vĩnh viễn thương hiệu thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xóa vĩnh viễn thất bại: ' . $e->getMessage());
        }
    }
}
