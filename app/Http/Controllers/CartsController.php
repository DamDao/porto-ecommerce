<?php

namespace App\Http\Controllers;

use App\Models\Carts;
use App\Models\OrderItems;
use App\Models\Orders;
use App\Models\Payments;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Nette\Schema\Expect;

class CartsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $user_id = Auth()->user()->id;
        // $product = Product::where('id', $id)->firstOrFail();
        $carts = Carts::where('user_id', $user_id)->with('product')->get();
        // $cart = Carts::where('')->with('product')->get();
        // $cart = DB::table('carts')->where('id',$id)->get();
        // dd($carts->product->name);
        $totalPrice = 0;

        // dd($carts);

        // Assuming $cartItems is an array of items in the cart with 'price' field.
        foreach ($carts as $item) {
            $totalPrice += $item->product->sale_price * $item->quantity;
        }
        // dd($totalPrice);

        // Now $totalPrice contains the total price of all items in the cart.

        return view('clinet.cart', compact('carts', 'totalPrice'));
    }

    public function checkout()
    {
        $user_id = Auth()->user()->id;
        $carts = Carts::where('user_id', $user_id)->with('product')->get();
        $total = 0;
        // Assuming $cartItems is an array of items in the cart with 'price' field.
        foreach ($carts as $item) {
            $total += $item->product->sale_price * $item->quantity;
        }
        $user_id = Auth::user()->id;
        $cart = Carts::where('user_id', $user_id)->with('product')->get();
        // dd($cart);
        return view('clinet.checkout', compact('cart', 'total'));
    }


    public function vnpay_payment()
    {
        // date_default_timezone_set('Asia/Ho_Chi_Minh');
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "https://localhost/vnpay_php/vnpay_return.php";
        $vnp_TmnCode = "Z0J3M349"; //Mã website tại VNPAY 
        $vnp_HashSecret = "PRPIRKNOCOZVZSTYARFSTPWTVUPTPACD"; //Chuỗi bí mật

        $vnp_TxnRef = "10000"; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này 
        // sang VNPAY
        $vnp_OrderInfo = "Thanh toán hóa đơn";
        $vnp_OrderType = "BarBer Shop";
        $vnp_Amount = 10000 * 100;
        $vnp_Locale = "VND";
        $vnp_BankCode = "NCB";
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array(
            'code' => '00', 'message' => 'success', 'data' => $vnp_Url
        );
        if (isset($_POST['redirect'])) {
            header('Location: ' . $vnp_Url);
            die();
        } else {
            echo json_encode($returnData);
        }
        // vui lòng tham khảo thêm tại code demo
    }


    public function Storecheckout(Request $request)
    {
        $user_id = Auth::user()->id;
        $cart = Carts::where('user_id', $user_id)->with('product')->get();
        $pay = $request->except('_token', '_method');

        $order = Orders::create(['user_id' => $user_id, 'order_date' => now()] + $pay);
        // dd($pay);

        $total = 0;
        foreach ($cart as $item) {
            OrderItems::create([
                'product_id' => $item->product_id,
                'orders_id' => $order->id, // Liên kết với đơn hàng vừa tạo
                'quantity' => $item->quantity,
                'price_per_unit' => $item->product->sale_price,
            ]);

            $total += $item->product->sale_price * $item->quantity;
        }

        // Tạo thanh toán cho đơn hàng
        $payment_date = ($pay['radio'] == 1) ? now() : null;
        // dd($payment_date);
        Payments::create([
            'orders_id' => $order->id,
            'amount' => $total,
            'payment_date' => $payment_date,
            'payment_method' => $pay['radio']
            // Bổ sung các trường thông tin thanh toán khác nếu cần
        ]);

        Carts::where('user_id', $user_id)->delete();

        if ($pay['radio'] == 1) {
            // Thực hiện thanh toán VNPay và chuyển hướng người dùng đến trang thanh toán VNPay
            return $this->vnpay_payment();
        } else {
            // Thực hiện các bước xử lý khác nếu có
            // Trả về view hoặc chuyển hướng người dùng đến trang khác tùy thuộc vào quy trình của bạn
            return redirect()->route('order.complete',['orderId' => $order->id]);
        }
    }


    public function complete($orderId)
    {
        $order = Orders::with('orderItems.product')->find($orderId);
        // dd($order);

        if (!$order) {
            return redirect()->route('home')->with('error', 'Order not found.');
        }

        return view('clinet.order_complete', compact('order'));
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
        $user_id = Auth::user()->id;
        $product_id = $request->id;
        $quantity = $request->quantity;
        $product = Product::find($product_id);
        // dd($product);
        if (!$product) {
            return back()->with('error', 'Product not found.');
        }

        $existing_cart_item = Carts::where('user_id', $user_id)->where('product_id', $product_id)->first();
        if ($existing_cart_item) {
            // Nếu sản phẩm đã tồn tại trong giỏ hàng, cập nhật số lượng
            $existing_cart_item->quantity += $quantity;
            $existing_cart_item->save();
        } else {
            // Nếu sản phẩm chưa tồn tại trong giỏ hàng, tạo một bản ghi mới
            Carts::create([
                'product_id' => $product_id,
                'quantity' => $quantity,
                // Bạn cũng có thể cung cấp user_id nếu bạn đã đăng nhập người dùng
                'user_id' => $user_id
            ]);
        }

        return back()->with('success', 'Product added to cart successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Carts $carts)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Carts $carts)
    {
        //
        $user_id = Auth::user()->id;
        // $product = Product::where('id', $id)->firstOrFail();
        $carts = Carts::where('user_id', $user_id)->with('product')->get();
        // $cart = Carts::where('')->with('product')->get();
        // $cart = DB::table('carts')->where('id',$id)->get();
        $carts->toArray();
        // dd($carts->product->name);
        // foreach ($carts as $it) {
        //     # code...
        //     dd($it->id);
        // }
        return view('clinet.edit_cart', compact('carts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Carts $carts)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Carts $cart)
    {
        //
        // dd($cart);
        // $cart=Carts::find($carts);
        $cart->delete();

        return redirect()->back();
    }
}
