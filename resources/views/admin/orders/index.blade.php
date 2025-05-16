@extends('admin_layout')
@section('admin_content')

<h1 class="h3 mb-3"><strong>Danh sách đơn hàng</strong></h1>

<div class="">
  @if(session()->has('success'))
      <div class="alert alert-success mb-3">
          {{session('success')}}
      </div>
  @endif
</div>

<div class="card flex-fill">

  <table class="table table-hover my-0">
    <thead>
      <tr>
        <th>ID</th>
        <th>Phương thức tt</th>
        <th>Ngày đặt</th>
        <th>Ngày giao</th>
        <th>Trạng thái</th>
        <th>Địa chỉ giao hàng</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($orders as $order)
      <tr>
        <td>{{$order->id_dathang}}</td>

        @if ($order->phuongthucthanhtoan == "COD")
          <td class="d-none d-xl-table-cell"><div class="badge bg-secondary">{{$order->phuongthucthanhtoan}}</div></td>
        @elseif ($order->phuongthucthanhtoan == "VNPAY")
          <td class="d-none d-xl-table-cell"><div class="badge bg-primary">{{$order->phuongthucthanhtoan}}</div></td>
        @else
        <td class="d-none d-xl-table-cell">{{$order->phuongthucthanhtoan}}</td>
        @endif

        <td class="d-none d-xl-table-cell">{{$order->ngaydathang}}</td>
          @if ($order->ngaygiaohang)
            <td class="d-none d-xl-table-cell">{{ date('d/m/Y', strtotime($order->ngaygiaohang)) }}</td>
          @else
            <td></td>
          @endif
        <td>
       
            <span class="badge bg-primary"></span>
        
            <span class="badge bg-warning"></span>
         
            <span class="badge bg-success"></span>
         
            <span class="badge bg-success"></span>
          
            <span class="badge bg-danger"></span>
         
        </td>
        <td class="d-none d-md-table-cell"></td>
        <td class="d-none d-md-table-cell"><a href="" class="btn btn-primary">Edit</a></td>
      </tr>
      <tr>
      @endforeach
    </tbody>
  </table>

</div>



@endsection