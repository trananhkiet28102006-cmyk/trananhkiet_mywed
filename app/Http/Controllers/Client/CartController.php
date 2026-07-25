<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    // Thêm vào giỏ hàng (Ajax)
    public function addToCart(Request $request, $id)
    {
        $product = Product::select(
            'id',
            'productname',
            'slug',
            'price',
            'pricediscount',
            'image'
        )->findOrFail($id);

        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'productid' => $product->id,
                'productname' => $product->productname,
                'slug' => $product->slug,
                'image' => $product->image,
                'price' => $product->pricediscount ?: $product->price,
                'quantity' => 1,
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'status' => true,
            'message' => 'Đã thêm sản phẩm vào giỏ hàng.',
            'cartCount' => collect($cart)->sum('quantity'),
        ]);
    }

    // Hiển thị giỏ hàng
    public function show()
    {
        return view('client.cart.show');
    }

    // Xóa giỏ hàng (AJAX)
    public function removeCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
        }

        if (empty($cart)) {
            session()->forget('cart');
        } else {
            session()->put('cart', $cart);
        }

        // Tổng tiền
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        return response()->json([
            'status' => true,
            'message' => 'Đã xóa sản phẩm.',
            'cartCount' => collect($cart)->sum('quantity'),
            'total' => $total,
            'isEmpty' => empty($cart),
        ]);
    }

    // Xác nhận đặt hàng
    public function checkout(Request $request)
    {
        // Validate dữ liệu khách nhận hàng
        $request->validate([
            'fullname' => 'required|string|max:255',
            'phone'    => ['required', 'string', 'regex:/^(0)[0-9]{9,10}$/'],
            'email'    => 'nullable|email|max:255',
            'address'  => 'required|string|max:500',
            'note'     => 'nullable|string|max:1000',
        ], [
            'fullname.required' => 'Vui lòng nhập Họ và tên người nhận!',
            'fullname.max'      => 'Họ và tên không được dài quá 255 ký tự!',
            'phone.required'    => 'Vui lòng nhập Số điện thoại liên hệ!',
            'phone.regex'       => 'Số điện thoại không hợp lệ (ví dụ: 0901234567 từ 10-11 chữ số)!',
            'email.email'       => 'Địa chỉ Email không đúng định dạng (ví dụ: name@gmail.com)!',
            'address.required'  => 'Vui lòng nhập Địa chỉ giao hàng chi tiết!',
        ]);

        // Lấy giỏ hàng từ Session
        $cart = session()->get('cart', []);

        // Kiểm tra nếu giỏ hàng trống thì không cho đặt hàng
        if (empty($cart)) {
            return back()->with('error', 'Giỏ hàng đang trống.');
        }

        // Bắt đầu Transaction để chèn an toàn sang 3 bảng
        DB::beginTransaction();
        try {
            // Kiểm tra số điện thoại khách hàng đã tồn tại trong bảng chưa
            $customer = Customer::where('phone', $request->phone)->first();
            $customerid = null;

            if (empty($customer)) {
                // Thêm khách hàng mới
                $cus_afterinsert = Customer::create([
                    'fullname' => $request->fullname,
                    'phone'    => $request->phone,
                    'address'  => $request->address,
                    'email'    => $request->email
                ]);
                $customerid = $cus_afterinsert->id;
            } else {
                // Nếu khách đã tồn tại, dùng lại id và cập nhật địa chỉ/email mới nhất
                $customer->update([
                    'fullname' => $request->fullname,
                    'address'  => $request->address,
                    'email'    => $request->email
                ]);
                $customerid = $customer->id;
            }

            // Tính tổng đơn hàng
            $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

            // Tạo hóa đơn mới
            $order = Order::create([
                'order_code' => 'DH' . time(),
                'customer_id' => $customerid,
                'total_amount' => $total,
                'status'      => 'pending', // Sử dụng mặc định là pending đúng thiết kế cột
                'note'        => $request->note
            ]);

            // Lưu chi tiết sản phẩm đơn hàng
            $orderItems = [];
            foreach ($cart as $item) {
                $orderItems[] = [
                    'order_id'   => $order->id,
                    'product_id' => $item['productid'],
                    'price'      => $item['price'],
                    'quantity'   => $item['quantity'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            OrderItem::insert($orderItems);

            // Xác nhận transaction
            DB::commit();

            // Xóa sạch giỏ hàng session
            session()->forget('cart');

            return back()->with('success', 'Đặt hàng thành công.');
        } catch (\Exception $e) {
            // Hủy giao dịch nếu có lỗi xảy ra
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
