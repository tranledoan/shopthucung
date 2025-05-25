<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Repositories\IOrderRepository;
use App\Models\Dathang;

class OrderController extends Controller
{

    private $OrderRepository;

    public function __construct(IOrderRepository $OrderRepository) {
        $this->OrderRepository = $OrderRepository;
    }

    public function index(){
        $orders = $this->OrderRepository->allOrder();
        return view('admin.orders.index', ['orders' => $orders]);
    }
  public function edit($id){
        $order = $this->OrderRepository->findOrder($id);
        $orderdetails = $this->OrderRepository->findDetailProduct($id);
        $showusers = $this->OrderRepository->findUser($id);
        return view('admin.orders.edit', ['order' => $order, 'orderdetails' => $orderdetails, 'showusers' => $showusers]);
    }

    public function update($id, Request $request){
    //    $validatedData = $request->validate([
    //     'ngaygiaohang' => 'required',
    //     'trangthai' => 'required',
    //     'diachigiaohang' => 'required|string|max:255', 
    // ]);
    // $this->OrderRepository->updateOrder($validatedData, $id);

    // return redirect()->route('orders.index')->with('success', 'Cập nhập đơn hàng thành công');
    // }
     // Lấy đơn hàng từ database
    $order = Dathang::findOrFail($id);

    // Nếu đơn hàng đã giao thành công rồi → không cho cập nhật
    if ($order->trangthai === 'giao thành công') {
        return redirect()->route('orders.index')
                         ->with('error', 'Đơn hàng đã giao thành công, không thể chỉnh sửa.');
    }

    // Tiếp tục cập nhật nếu hợp lệ
    $validatedData = $request->validate([
        'ngaygiaohang' => 'nullable|date',
        'diachigiaohang' => 'required|string',
        'trangthai' => 'required|string',
    ]);

    $order->update([
        'ngaygiaohang' => $request->ngaygiaohang,
        'diachigiaohang' => $request->diachigiaohang,
        'trangthai' => $request->trangthai,
    ]);

    return redirect()->route('orders.index')->with('success', 'Cập nhật đơn hàng thành công.');
    }
   

}
