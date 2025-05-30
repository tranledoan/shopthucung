<?php

namespace App\Http\Controllers;

use App\Models\ChitietDonhang;
use App\Models\Dathang;
use App\Models\Sanpham;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function index()
    {
        $products = Sanpham::all();
        return view('products', compact('products'));
    }

    public function cart()
    {
        return view('pages.cart');
    }
    public function addToCart($id)
    {
        $product = Sanpham::findOrFail($id);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "id_sanpham" => $product->id_sanpham,
                "tensp" => $product->tensp,
                "anhsp" => $product->anhsp,
                "giasp" => $product->giasp,
                "giamgia" => $product->giamgia,
                "giakhuyenmai" => $product->giakhuyenmai,
                "quantity" => 1
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Thêm vào giỏ hàng thành công!');
    }
    public function addGoToCart($id)
{
    $product = Sanpham::find($id); // dùng find thay vì findOrFail

    // Nếu không tìm thấy sản phẩm
    if (!$product) {
        return redirect()->back()->with('error', 'Sản phẩm không tồn tại hoặc đã bị xóa.');
    }

    // Lấy giỏ hàng từ session
    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {
        $cart[$id]['quantity']++;
    } else {
        $cart[$id] = [
            "id_sanpham" => $product->id_sanpham,
            "tensp" => $product->tensp,
            "anhsp" => $product->anhsp,
            "giasp" => $product->giasp,
            "giamgia" => $product->giamgia,
            "giakhuyenmai" => $product->giakhuyenmai,
            "quantity" => 1
        ];
    }

    // Cập nhật lại session
    session()->put('cart', $cart);

    // Nếu giỏ hàng rỗng thì không chuyển trang
    if (empty($cart)) {
        return redirect()->back()->with('error', 'Hiện không có sản phẩm nào trong giỏ hàng.');
    }
    return redirect('/cart')->with('success', 'Đã thêm vào giỏ hàng.');
}


    public function update(Request $request)
    {
        if ($request->id && $request->quantity) {
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Cập nhật giỏ hàng thành công!');
        }
    }

public function remove(Request $request)
{
    $cart = session()->get('cart', []);

    if ($request->id && isset($cart[$request->id])) {
        unset($cart[$request->id]);
        session()->put('cart', $cart);

        return response()->json(['success' => true, 'message' => 'Đã xóa sản phẩm.']);
    }

    return response()->json(['success' => false, 'message' => 'Sản phẩm không tồn tại trong giỏ hàng.']);
}


    public function checkout()
    {
        if (Auth::check()) {
            if (Auth::user()) {
                $showusers = DB::table('khachhang')
                    ->join('dathang', 'khachhang.id_kh', '=', 'dathang.id_kh')
                    ->select('khachhang.*')
                    ->where('khachhang.id_kh', Auth::user()->id_kh)
                    ->get();

                return view('pages.checkout', ['showusers' => $showusers]);
            }
        }
        return redirect('/login');
    }


    public function dathang(Request $request)
    {

        $validatedDataDatHang = $request->validate([]);

        $validatedDataDatHang['ngaydathang'] = Carbon::now();
        $validatedDataDatHang['ngaygiaohang'] = null;
        $validatedDataDatHang['tongtien'] = $request->tongtien;
        $validatedDataDatHang['phuongthucthanhtoan'] = $request->redirect;
        $validatedDataDatHang['diachigiaohang'] = $request->diachigiaohang;
        $validatedDataDatHang['trangthai'] = "đang xử lý";
        $validatedDataDatHang['id_kh'] = Auth::user()->id_kh;

        $dathangCre = Dathang::create($validatedDataDatHang);


        $validatedDataCTDatHang = $request->validate([]);

        foreach (session('cart') as $item) {
            $validatedDataCTDatHang['tensp'] = $item['tensp'];
            $validatedDataCTDatHang['soluong'] = $item['quantity'];
            $validatedDataCTDatHang['giamgia'] = $item['giamgia'];
            $validatedDataCTDatHang['giatien'] = $item['giasp'];
            $validatedDataCTDatHang['giakhuyenmai'] = $item['giakhuyenmai'];
            $validatedDataCTDatHang['id_sanpham'] = $item['id_sanpham'];
            $validatedDataCTDatHang['id_dathang'] = $dathangCre->id_dathang;

            $validatedDataCTDatHang['id_kh'] = Auth::user()->id_kh;

            ChitietDonhang::create($validatedDataCTDatHang);
        }

        $request->session()->forget('cart');

        return view('pages.thongbaodathang');
    }

    public function thongbaodathang(Request $request)
    {
        if ($request->has('vnp_ResponseCode') && $request->has('vnp_TransactionNo')) {
            $responseCode = $request->input('vnp_ResponseCode');

            //if the payment successful
            if ($responseCode == '00') {
                return view('pages.thongbaodathang');
            } else {
                // Payment failed ;1.
                return redirect('/cart');
            }
        } else {
            // Invalid request
            return redirect('/cart');
        }
    }

    public function vnpay(Request $request)
    {
        $vnp_TmnCode = "GHHNT2HB"; //Mã website tại VNPAY 
        $vnp_HashSecret = "BAGAOHAPRHKQZASKQZASVPRSAKPXNYXS"; //Chuỗi bí mật

        $vnp_Url = "http://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://127.0.0.1:8000/thongbaodathang";
        $vnp_TxnRef = date("YmdHis"); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = "Thanh toán hóa đơn phí dich vụ";
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $request->tongtien * 100;
        $vnp_Locale = 'vn';
        $vnp_IpAddr = request()->ip();

        $inputData = array(
            "vnp_Version" => "2.0.0",
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
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . $key . "=" . $value;
            } else {
                $hashdata .= $key . "=" . $value;
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            // $vnpSecureHash = md5($vnp_HashSecret . $hashdata);
            $vnpSecureHash = hash('sha256', $vnp_HashSecret . $hashdata);
            $vnp_Url .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;
        }

        //--------------------------------------------------------------
        $this->dathang($request);

        return redirect($vnp_Url);
    }
}
