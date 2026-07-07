<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\ProductRequest; // Lab 09
use Illuminate\Support\Str; // Lab 10
use Illuminate\Support\Facades\Storage; // Lab 10
use App\Models\Product; // Lab 07 - Eloquent ORM
use App\Models\ProductImage; // Lab 10
use App\Models\Category; // Lab 10
use App\Models\Brand; // Lab 10

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
    public function store(ProductRequest $request)
    {
        try {
            // Upload hình ảnh chính
            $fileName = null;
            if ($request->hasFile('img')) {
                $file = $request->file('img');
                $fileName = Str::slug($request->productname)
                    . '-' . time()
                    . '.' . $file->extension();
                $file->storeAs('products', $fileName, 'public');
            }

            // Lưu sản phẩm
            $product = Product::create([
                'productname'   => $request->productname,
                'slug'          => $request->slug,
                'price'         => $request->price,
                'pricediscount' => $request->pricediscount ?? 0,
                'description'   => $request->description,
                'status'        => $request->status,
                'cateid'        => $request->cateid,
                'brandid'       => $request->brandid,
                'image'         => $fileName,
            ]);

            // Upload hình ảnh phụ
            if ($request->hasFile('imgs')) {
                $i = 1;
                $time = time(); // cùng timestamp
                foreach ($request->file('imgs') as $file) {
                    $subFileName = $product->id . '_' . $time . '_' . $i . '.' . $file->extension();
                    $file->storeAs('products', $subFileName, 'public');
                    
                    // Lưu vào bảng product_images
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image'      => $subFileName,
                    ]);
                    $i++;
                }
            }

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
        $product = Product::with('images')->findOrFail($id);
        $categories = Category::select('cateid', 'catename')
            ->where('status', 1)
            ->orderBy('catename')
            ->get();
        $brands = Brand::select('id', 'brandname')
            ->where('status', 1)
            ->orderBy('brandname')
            ->get();
        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        try {
            $product = Product::findOrFail($id);
            $fileName = $product->image;

            // Cập nhật ảnh chính (nếu có chọn ảnh mới)
            if ($request->hasFile('img')) {
                if ($fileName) {
                    Storage::disk('public')->delete('products/' . $product->image);
                }
                $file = $request->file('img');
                $fileName = Str::slug($request->productname)
                    . '-' . time()
                    . '.' . $file->extension();
                $file->storeAs('products', $fileName, 'public');
            }

            $product->update([
                'productname'   => $request->productname,
                'slug'          => $request->slug,
                'price'         => $request->price,
                'pricediscount' => $request->pricediscount ?? 0,
                'description'   => $request->description,
                'status'        => $request->status,
                'cateid'        => $request->cateid,
                'brandid'       => $request->brandid,
                'image'         => $fileName,
            ]);

            // Thêm các ảnh phụ mới (nếu có chọn thêm)
            if ($request->hasFile('imgs')) {
                $i = 1;
                $time = time();
                foreach ($request->file('imgs') as $file) {
                    $subFileName = $product->id . '_' . $time . '_' . $i . '.' . $file->extension();
                    $file->storeAs('products', $subFileName, 'public');

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image'      => $subFileName,
                    ]);
                    $i++;
                }
            }

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

    /**
     * Delete secondary image via AJAX
     */
    public function deleteImage(string $id)
    {
        try {
            $image = ProductImage::findOrFail($id);
            if ($image->image) {
                Storage::disk('public')->delete('products/' . $image->image);
            }
            $image->delete();
            return response()->json([
                'success' => true,
                'message' => 'Xóa hình ảnh phụ thành công!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ], 500);
        }
    }
}
