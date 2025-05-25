@extends('admin_layout')
@section('admin_content')
<h1 class="h3 mb-3"><strong>Sửa đơn hàng</strong></h1>


@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@foreach ($showusers as $showuser)
    <div class="mb-3 bg-light p-3 my-3">
        <h4>Thông tin khách hàng</h4>
        <div class="d-flex">
            <div class="mr-4">
                <div style="font-size: 18px;"><strong>Khách hàng:</strong> {{$showuser->hoten}}</div>
                <div style="font-size: 18px;"><strong>Email:</strong> {{$showuser->email}}</div>
            </div>
            <div class="">
                <div style="font-size: 18px;"><strong>Số điện thoại:</strong> {{$showuser->sdt}}</div>
                <div style="font-size: 18px;"><strong>Địa chỉ:</strong> {{$showuser->diachi}}</div>
            </div>
        </div>
    </div>
@endforeach


<form method="POST" action="{{ route('orders.update', ['orders' => $order->id_dathang]) }}"
    enctype="multipart/form-data">
    @csrf
    @method('put')

    <div class="mb-3">
        <label for="id_dathang" class="form-label">ID đơn hàng</label>
        <input type="text" class="form-control" id="id_dathang" name="id_dathang" value="{{$order->id_dathang}}"
            disabled>
    </div>

    <div class="mb-3">
        <label for="ngaydathang" class="form-label">Ngày đặt</label>
        <input type="text" class="form-control" id="ngaydathang" name="ngaydathang" value="{{$order->ngaydathang}}"
            disabled>
    </div>

    <div class="mb-3">
        <label for="ngaygiaohang" class="form-label">Ngày giao</label>
        @if($order->ngaygiaohang)
            <input type="date" class="form-control" id="ngaygiaohang" name="ngaygiaohang"
                value="{{ date('Y-m-d', strtotime($order->ngaygiaohang)) }}">
        @else
            <input type="date" class="form-control" id="ngaygiaohang" name="ngaygiaohang" value="{{ date('Y-m-d') }}">
        @endif
        @error('ngaygiaohang')
        <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
    </div>

    <div class="mb-3">
        <label for="phuongthucthanhtoan" class="form-label">Phương thức thanh toán</label>
        <input type="text" class="form-control" id="phuongthucthanhtoan" name="phuongthucthanhtoan"
            value="{{$order->phuongthucthanhtoan}}" disabled>
    </div>

    <div class="mb-3">
        <label for="diachigiaohang" class="form-label">Địa chỉ giao hàng</label>
        <input type="text" class="form-control" id="diachigiaohang" name="diachigiaohang"
            value="{{$order->diachigiaohang}}" required>
    </div>

    <div class="mb-3">

        <label for="trangthai" class="form-label">Trạng thái</label>
        <select class="form-select" id="trangthai" name="trangthai" {{ $order->trangthai == 'Giao thành công' ? 'disabled' : '' }} required>
            <option value="đang xử lý" {{ $order->trangthai == 'đang xử lý' ? 'selected' : '' }}>Đang xử lý</option>
            <option value="chờ lấy hàng" {{ $order->trangthai == 'chờ lấy hàng' ? 'selected' : '' }}>Chờ lấy hàng</option>
            <option value="đang giao hàng" {{ $order->trangthai == 'đang giao hàng' ? 'selected' : '' }}>Đang giao hàng
            </option>
            <option value="giao thành công" {{ $order->trangthai == 'giao thành công' ? 'selected' : '' }}>Giao thành công
            </option>
        </select>
        <div class="err">
            @if($errors->any())
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{'Trang Thai Khong Hop Le'}}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    <div class="mb-3">
        <table class="table table-hover my-0">
            <thead>
                <th>Tên sản phẩm</th>
                <th>Số lượng</th>
                <th>Giá gốc</th>
                <th>Giảm giá</th>
                <th>Giá khuyến mại</th>
                <th>tổng tiền</th>
            </thead>
            <tbody>
                @php
                    $totalPrice = 0; // Khởi tạo biến tổng tiền
                @endphp
                @foreach ($orderdetails as $orderdetail)
                                <tr>
                                    <td>{{$orderdetail->tensp}}</td>
                                    <td>{{$orderdetail->soluong}}</td>
                                    <td>{{$orderdetail->giatien}}</td>
                                    <td>{{$orderdetail->giamgia}}%</td>
                                    <td>{{$orderdetail->giakhuyenmai}}</td>
                                    <td>{{$orderdetail->giakhuyenmai * $orderdetail->soluong}}</td>
                                </tr>

                                @php
                                    $totalPrice += $orderdetail->giakhuyenmai * $orderdetail->soluong; // Cộng giá trị tổng tiền
                                @endphp

                @endforeach

            </tbody>
        </table>
    </div>

    <div class="mb-3">
        <label for="tongiten" class="form-label">Tiền ước tính</label>
        <input type="text" class="form-control" id="tongiten" name="tongiten" value="{{$totalPrice}}" disabled>
    </div>



    @if($order->trangthai != 'giao thành công')
        <input type="submit" class="btn btn-primary" value="Update">
    @endif

    &nbsp;<a class="btn btn-secondary" href="{{URL::to('/admin/orders')}}">Hủy</a>

</form>

@endsection