<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Customer;

class OrderHistoryController extends Controller
{
    /**
     * Hiển thị trang Tra cứu / Lịch sử đơn hàng của Khách hàng
     */
    public function history(Request $request)
    {
        $search = $request->query('search');
        $orders = collect();

        if ($search) {
            $orders = Order::with(['customer', 'items.product'])
                ->where(function ($q) use ($search) {
                    $q->where('order_code', 'like', '%' . $search . '%')
                      ->orWhereHas('customer', function ($sq) use ($search) {
                          $sq->where('phone', 'like', '%' . $search . '%')
                            ->orWhere('fullname', 'like', '%' . $search . '%');
                      });
                })
                ->orderByDesc('created_at')
                ->get();
        }

        return view('client.order.history', compact('orders', 'search'));
    }

    /**
     * API kiểm tra trạng thái đơn hàng thời gian thực (AJAX Polling Real-time)
     */
    public function checkStatus($id)
    {
        $order = Order::select('id', 'order_code', 'status', 'payment_status', 'updated_at')->find($id);

        if (!$order) {
            return response()->json(['status' => false, 'message' => 'Không tìm thấy đơn hàng']);
        }

        // Định dạng tên tiếng Việt và màu sắc badge
        $statusLabels = [
            'pending'   => ['label' => 'Chờ xử lý', 'color' => 'warning', 'step' => 1],
            'confirmed' => ['label' => 'Đã xác nhận', 'color' => 'info', 'step' => 2],
            'shipping'  => ['label' => 'Đang giao hàng', 'color' => 'primary', 'step' => 3],
            'completed' => ['label' => 'Đã hoàn thành', 'color' => 'success', 'step' => 4],
            'cancelled' => ['label' => 'Đã hủy đơn', 'color' => 'danger', 'step' => 0],
        ];

        $info = $statusLabels[$order->status] ?? ['label' => $order->status, 'color' => 'secondary', 'step' => 1];

        return response()->json([
            'status'         => true,
            'order_id'       => $order->id,
            'order_code'     => $order->order_code,
            'order_status'   => $order->status,
            'status_label'   => $info['label'],
            'status_color'   => $info['color'],
            'step'           => $info['step'],
            'payment_status' => $order->payment_status === 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán',
            'updated_at'     => $order->updated_at->format('H:i - d/m/Y'),
        ]);
    }
}
