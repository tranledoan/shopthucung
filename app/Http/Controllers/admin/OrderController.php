<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Repositories\IOrderRepository;
use App\Models\Dathang;

class OrderController extends Controller
{

    private $OrderRepository;

    public function __construct(IOrderRepository $OrderRepository)
    {
        $this->OrderRepository = $OrderRepository;
    }

    public function index()
    {
        $orders = $this->OrderRepository->allOrder();
        return view('admin.orders.index', ['orders' => $orders]);
    }
    public function edit($id)
    {
        $order = $this->OrderRepository->findOrder($id);
        $orderdetails = $this->OrderRepository->findDetailProduct($id);
        $showusers = $this->OrderRepository->findUser($id);
        return view('admin.orders.edit', ['order' => $order, 'orderdetails' => $orderdetails, 'showusers' => $showusers]);
    }

    public function update($id, Request $request)
{
    // Lấy đơn hàng
    $order = Dathang::findOrFail($id);

    // Không cho chỉnh nếu đã giao thành công
    if ($order->trangthai === 'giao thành công') {
        return redirect()->route('orders.index')
            ->with('error', 'Đơn hàng đã giao thành công, không thể chỉnh sửa.');
    }

    // Validate trước khi cập nhật
    $validatedData = $request->validate([
        'ngaygiaohang' => 'nullable|date',
        'diachigiaohang' => 'required|string|max:255',
        'trangthai' => 'required|string|in:đang xử lý,chờ lấy hàng,đang giao hàng,giao thành công',
        
    ]);
     if ($request->ngaygiaohang && $request->ngaygiaohang < $order->ngaydathang) {
        return redirect()->back()->withInput()->withErrors([
            'ngaygiaohang' => 'Ngày giao hàng không được nhỏ hơn ngày đặt hàng.',
        ]);
    }

    // Cập nhật dữ liệu
    $order->update($validatedData);

    return redirect()->route('orders.index')->with('success', 'Cập nhật đơn hàng thành công.');
}


}
