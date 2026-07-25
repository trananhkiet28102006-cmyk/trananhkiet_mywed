<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ProductController extends Controller
{
    // Chi tiết sản phẩm
    public function show($slug)
    {
        $product = Product::with(['category', 'brand', 'images'])->where('slug', $slug)->where('status', 1)->firstOrFail();
        
        // Lấy danh sách sản phẩm liên quan (cùng danh mục hoặc cùng thương hiệu, loại trừ sản phẩm hiện tại)
        $relatedProducts = Product::where('status', 1)
            ->where('id', '!=', $product->id)
            ->where(function ($query) use ($product) {
                $query->where('cateid', $product->cateid)
                      ->orWhere('brandid', $product->brandid);
            })
            ->take(4)
            ->get();

        return view('client.product.show', compact('product', 'relatedProducts'));
    }

    // Lọc theo danh mục
    public function category($slug)
    {
        $category = Category::where('slug', $slug)->where('status', 1)->firstOrFail();
        
        $products = Product::where('cateid', $category->cateid)
            ->where('status', 1)
            ->paginate(12);

        return view('client.product.category', compact('category', 'products'));
    }

    // Lọc theo thương hiệu
    public function brand($slug)
    {
        $brand = Brand::where('slug', $slug)->where('status', 1)->firstOrFail();
        
        $products = Product::where('brandid', $brand->id)
            ->where('status', 1)
            ->paginate(12);

        return view('client.product.brand', compact('brand', 'products'));
    }

    // Tìm kiếm sản phẩm (nâng cao)
    public function search(Request $request)
    {
        $query = $request->query('q');
        $minPrice = $request->query('min_price');
        $maxPrice = $request->query('max_price');
        $sortBy = $request->query('sort_by');

        $productsQuery = Product::where('status', 1);

        // Lọc theo tên sản phẩm
        if ($query) {
            $productsQuery->where('productname', 'like', '%' . $query . '%');
        }

        // Lọc theo khoảng giá
        if ($minPrice !== null && $minPrice !== '') {
            $productsQuery->where(function ($q) use ($minPrice) {
                $q->where(function ($sq) use ($minPrice) {
                    $sq->where('pricediscount', '>', 0)->where('pricediscount', '>=', $minPrice);
                })->orWhere(function ($sq) use ($minPrice) {
                    $sq->where('pricediscount', 0)->where('price', '>=', $minPrice);
                });
            });
        }

        if ($maxPrice !== null && $maxPrice !== '') {
            $productsQuery->where(function ($q) use ($maxPrice) {
                $q->where(function ($sq) use ($maxPrice) {
                    $sq->where('pricediscount', '>', 0)->where('pricediscount', '<=', $maxPrice);
                })->orWhere(function ($sq) use ($maxPrice) {
                    $sq->where('pricediscount', 0)->where('price', '<=', $maxPrice);
                });
            });
        }

        // Sắp xếp
        if ($sortBy === 'price_asc') {
            $productsQuery->orderByRaw('CASE WHEN pricediscount > 0 THEN pricediscount ELSE price END ASC');
        } elseif ($sortBy === 'price_desc') {
            $productsQuery->orderByRaw('CASE WHEN pricediscount > 0 THEN pricediscount ELSE price END DESC');
        } elseif ($sortBy === 'name_asc') {
            $productsQuery->orderBy('productname', 'asc');
        } elseif ($sortBy === 'name_desc') {
            $productsQuery->orderBy('productname', 'desc');
        } else {
            $productsQuery->orderByDesc('created_at');
        }

        $products = $productsQuery->paginate(12);

        return view('client.product.search', compact('products', 'query', 'minPrice', 'maxPrice', 'sortBy'));
    }
}
