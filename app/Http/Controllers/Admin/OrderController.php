<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Customer;

class OrderController extends Controller
{
    // Hiển thị danh sách đơn hàng
    public function index(Request $request)
    {
        $query = $request->query('q');
        $statusFilter = $request->query('status');

        $ordersQuery = Order::with('customer');

        // Tìm kiếm theo mã đơn hàng hoặc tên/sđt khách hàng
        if ($query) {
            $ordersQuery->where(function ($q) use ($query) {
                $q->where('order_code', 'like', '%' . $query . '%')
                  ->orWhereHas('customer', function ($sq) use ($query) {
                      $sq->where('fullname', 'like', '%' . $query . '%')
                        ->orWhere('phone', 'like', '%' . $query . '%');
                  });
            });
        }

        // Lọc theo trạng thái
        if ($statusFilter) {
            $ordersQuery->where('status', $statusFilter);
        }

        $orders = $ordersQuery->orderByDesc('created_at')->paginate(10);

        // Thống kê tổng số đơn hàng
        $totalOrders = Order::count();

        // Thống kê tổng doanh thu (chỉ tính đơn hàng đã hoàn thành)
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');

        return view('admin.orders.index', compact(
            'orders', 'query', 'statusFilter', 'totalOrders', 'totalRevenue'
        ));
    }

    // Xem chi tiết đơn hàng
    public function show($id)
    {
        $order = Order::with(['customer', 'items.product'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    // Cập nhật trạng thái đơn hàng
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'status' => 'required|string|in:pending,confirmed,shipping,completed,cancelled',
            'payment_status' => 'required|string|in:unpaid,paid',
        ]);

        $order->update([
            'status' => $request->status,
            'payment_status' => $request->payment_status,
        ]);

        return redirect()->route('admin.orders.show', $id)
            ->with('success', 'Cập nhật trạng thái đơn hàng thành công.');
    }

    /**
     * Cập nhật trạng thái hàng loạt thông qua Checkbox
     */
    public function bulkStatus(Request $request)
    {
        $request->validate([
            'order_ids' => 'required|array|min:1',
            'status'    => 'required|string|in:pending,confirmed,shipping,completed,cancelled',
        ], [
            'order_ids.required' => 'Vui lòng tích chọn ít nhất 1 đơn hàng!',
            'status.required'    => 'Vui lòng chọn trạng thái cần cập nhật!',
        ]);

        $updateData = ['status' => $request->status];
        
        // Nếu chọn chuyển sang Đã hoàn thành -> Tự động chuyển trạng thái thanh toán sang Đã thanh toán
        if ($request->status === 'completed') {
            $updateData['payment_status'] = 'paid';
        }

        $count = Order::whereIn('id', $request->order_ids)->update($updateData);

        return redirect()->back()->with('success', "Đã duyệt và cập nhật thành công {$count} đơn hàng!");
    }
}
