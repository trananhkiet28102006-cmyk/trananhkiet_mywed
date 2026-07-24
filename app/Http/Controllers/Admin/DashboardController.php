<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\User;
use App\Models\Post;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $countCategories = Category::count();
        $countBrands = Brand::count();
        $countProducts = Product::count();
        $countUsers = User::count();
        $countPosts = Post::count();
        $countOrders = Order::count();
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');

        return view('admin.dashboard', compact(
            'countCategories',
            'countBrands',
            'countProducts',
            'countUsers',
            'countPosts',
            'countOrders',
            'totalRevenue'
        ));
    }
}
