<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

    public function store(Request $request)
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
            Brand::create([
                'brandname'   => $request->brandname,
                'slug'        => $request->slug,
                'status'      => $request->input('status', 1),
                'sort_order'  => $request->input('sort_order', 0),
                'description' => $request->input('description'),
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
    public function update(Request $request, string $id)
    {
        try {
            Brand::find($id)->update([
                'brandname'   => $request->brandname,
                'slug'        => $request->slug,
                'status'      => $request->input('status', 1),
                'sort_order'  => $request->input('sort_order', 0),
                'description' => $request->input('description'),
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
        //
    }
}
