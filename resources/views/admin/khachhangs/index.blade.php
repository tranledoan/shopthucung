@extends('admin_layout')
@section('admin_content')

<h1 class="h3 mb-3"><strong>Danh sách user</strong></h1>

<div class="">
  @if(session()->has('success'))
      <div class="alert alert-success mb-3">
          {{session('success')}}
      </div>
  @endif
</div>

  <table class="table">
    <thead>
      <tr>
        <th>Id</th>
        <th>Tên khách hàng</th>
        <th>Email</th>
        <th>Sđt</th>
        <th>Địa chỉ</th>
        <th>Quyền</th>
        <th colspan="2">Actions</th>
      </tr>
    </thead>

    <tbody>
      @foreach($Khachhangs as $khachhang)
      <tr>
        <td>{{$khachhang->id_kh}}</td>
        <td>{{$khachhang->hoten}}</td>
        <td>{{$khachhang->email}}</td>
        <td>{{$khachhang->sdt}}</td>
        <td>{{$khachhang->diachi}}</td>

        @if($khachhang->id_phanquyen == 1)
          <td>admin</td>
        @elseif ($khachhang->id_phanquyen == 2)
          <td>user</td>
        @elseif ($khachhang->id_phanquyen == 3)
          <td>staff</td>
        @else
          <td></td>
        @endif

        @if($khachhang->id_phanquyen == 1)
          <td colspan="2"></td>
        @else
          <td colspan="2">
            <a href="" class="btn btn-warning mb-2">Edit</a>
            <form method="post" action="">
                @csrf
                @method('delete')
                <input type="submit" class="btn btn-danger" value="Delete"
                onclick="return confirm('Bạn có chắc chắn muốn xóa user này không?')">
            </form>
          </td>
        @endif

      </tr>
      @endforeach
    </tbody>
  </table>
  <ul class="pagination">
  <li class="page-item @if($Khachhangs->currentPage() === 1) disabled @endif">
      <a class="page-link" href="{{ $Khachhangs->previousPageUrl() }}">Previous</a>
  </li>
  @for ($i = 1; $i <= $Khachhangs->lastPage(); $i++)
      <li class="page-item @if($Khachhangs->currentPage() === $i) active @endif">
          <a class="page-link" href="{{ $Khachhangs->url($i) }}">{{ $i }}</a>
      </li>
  @endfor
  <li class="page-item @if($Khachhangs->currentPage() === $Khachhangs->lastPage()) disabled @endif">
      <a class="page-link" href="{{ $Khachhangs->nextPageUrl() }}">Next</a>
  </li>
</ul>
@endsection