<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB; // Lab 06 - Query Builder
use App\Models\Product; // Lab 07 - Eloquent ORM

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // ===================== LAB 06 - Query Builder =====================
        // $list = DB::table('products')
        //     ->join('categories', 'products.cateid', '=', 'categories.cateid')
        //     ->leftJoin('brands', 'products.brandid', '=', 'brands.id')
        //     ->select(
        //         'products.id',
        //         'products.productname',
        //         'products.price',
        //         'products.pricediscount',
        //         'products.image',
        //         'products.status',
        //         'categories.catename',
        //         'brands.brandname'
        //     )
        //     ->where('products.status', 1)
        //     ->orderBy('products.productname')
        //     ->get();
        // ==================================================================

        // ===================== LAB 07 - Eloquent ORM =====================
        $limit = $request->input('limit', 10);
        $list = Product::select('id', 'productname', 'price', 'pricediscount', 'image', 'status', 'cateid', 'brandid')
                    ->with([
                        'category:cateid,catename',
                        'brand:id,brandname'
                    ])
                    ->where('status', 1)
                    ->orderBy('productname')
                    ->paginate($limit);
        // =================================================================

        return view('admin.products.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = \App\Models\Category::select('cateid', 'catename')
            ->where('status', 1)
            ->orderBy('catename')
            ->get();
        $brands = \App\Models\Brand::select('id', 'brandname')
            ->where('status', 1)
            ->orderBy('brandname')
            ->get();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            Product::create([
                'productname'   => $request->productname,
                'slug'          => $request->slug,
                'price'         => $request->price,
                'pricediscount' => $request->input('pricediscount', 0),
                'description'   => $request->description,
                'status'        => $request->input('status', 1),
                'cateid'        => $request->cateid,
                'brandid'       => $request->brandid,
            ]);
            return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công!');
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
        $product = Product::find($id);
        $categories = \App\Models\Category::select('cateid', 'catename')
            ->where('status', 1)
            ->orderBy('catename')
            ->get();
        $brands = \App\Models\Brand::select('id', 'brandname')
            ->where('status', 1)
            ->orderBy('brandname')
            ->get();
        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            Product::find($id)->update([
                'productname'   => $request->productname,
                'slug'          => $request->slug,
                'price'         => $request->price,
                'pricediscount' => $request->input('pricediscount', 0),
                'description'   => $request->description,
                'status'        => $request->input('status', 1),
                'cateid'        => $request->cateid,
                'brandid'       => $request->brandid,
            ]);
            return redirect()->route('admin.products.index')->with('success', 'Sửa sản phẩm thành công!');
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
