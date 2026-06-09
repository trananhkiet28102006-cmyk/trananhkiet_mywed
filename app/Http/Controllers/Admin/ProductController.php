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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
