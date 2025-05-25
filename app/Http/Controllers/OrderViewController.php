<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\IOrderRepository;

use Illuminate\Support\Facades\Auth;

class OrderViewController extends Controller
{

    private $OrderRepository;

    public function __construct(IOrderRepository $OrderRepository) {
        $this->OrderRepository = $OrderRepository;
    }

    public function donhang(){

        $user = Auth::user();
        if($user){
            $orders = $this->OrderRepository->orderView($user->id_kh);
            return view('pages.dathang', ['orders' => $orders]);
        }else{
            return redirect('/');
        }
        
    }

    public function edit($id){
        $order = $this->OrderRepository->findOrder($id);
        $orderdetails = $this->OrderRepository->findDetailProduct($id);
        $showusers = $this->OrderRepository->findUser($id);
        return view('pages.donhangdetail', ['order' => $order, 'orderdetails' => $orderdetails, 'showusers' => $showusers]);
    }

    public function update(Request $request, $id) {
        $order = $this->OrderRepository->findOrder($id);
        
        if ($order->trangthai == 'đang xử lý') {
            $this->OrderRepository->updateOrder($id, [
                'trangthai' => $request->trangthai,
                'ngaygiaohang' => $request->ngaygiaohang
            ]);
            return redirect()->back()->with('success', 'Cập nhật đơn hàng thành công');
        }
        
        return redirect()->back()->with('error', 'Không thể cập nhật đơn hàng này');
    }

}
