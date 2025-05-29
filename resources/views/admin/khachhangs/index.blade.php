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
@if(session('error'))
    <div class="alert alert-warning">
        {{ session('error') }}
    </div>
@endif
  <form action="{{Route('adminSearchUser')}}" method="GET" class="d-flex">
      <input type="text" value="{{ request('tukhoa') }}" placeholder="Nhập để tìm kiếm..." name="tukhoa" class="form-control" style="width: unset;" required>
      <button class="btn btn-primary" type="submit">
        <i class="align-middle" data-feather="search"></i> 
      </button>
  </form>

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

        <!-- @if($khachhang->id_phanquyen == 1)
          <td colspan="2"></td>
        @else
          <td colspan="2">
            <a href="{{ route('adminEditUser', $khachhang->id_kh) }}" class="btn btn-warning mb-2">Edit</a>
            <form method="post" action="{{ route('adminDeleteUser', $khachhang->id_kh) }}">
                @csrf
                @method('delete')
                <input type="submit" class="btn btn-danger" value="Delete"
                onclick="return confirm('Bạn có chắc chắn muốn xóa user này không?')">
            </form>
          </td>
        @endif -->
        @php
    $currentUser = auth()->user();
@endphp

@if($khachhang->id_phanquyen == 1 && $khachhang->is_superadmin)
    {{-- Đây là super admin --}}
    @if($currentUser->is_superadmin && $currentUser->id_kh != $khachhang->id_kh)
        {{-- Super admin không sửa/xóa super admin khác --}}
        <td colspan="2"></td>
    @else
        <td colspan="2"></td>
    @endif
@elseif($khachhang->id_phanquyen == 1 && !$khachhang->is_superadmin)
    {{-- Admin thường --}}
    @if($currentUser->is_superadmin)
        {{-- Super admin có thể sửa/xóa admin thường --}}
        <td colspan="2">
            <a href="{{ route('adminEditUser', $khachhang->id_kh) }}" class="btn btn-warning mb-2">Edit</a>
            <form method="post" action="{{ route('adminDeleteUser', $khachhang->id_kh) }}" style="display:inline;">
                @csrf
                @method('delete')
                <input type="submit" class="btn btn-danger" value="Delete"
                onclick="return confirm('Bạn có chắc chắn muốn xóa user này không?')">
            </form>
        </td>
    @else
        {{-- Admin thường và user khác không được sửa/xóa admin --}}
        <td colspan="2"></td>
    @endif
@else
    {{-- User hoặc staff --}}
    @if($currentUser->is_superadmin || ($currentUser->id_phanquyen == 1 && !$currentUser->is_superadmin))
        {{-- Super admin hoặc admin thường được sửa/xóa user và staff --}}
        <td colspan="2">
            <a href="{{ route('adminEditUser', $khachhang->id_kh) }}" class="btn btn-warning mb-2">Edit</a>
            <form method="post" action="{{ route('adminDeleteUser', $khachhang->id_kh) }}" style="display:inline;">
                @csrf
                @method('delete')
                <input type="submit" class="btn btn-danger" value="Delete"
                onclick="return confirm('Bạn có chắc chắn muốn xóa user này không?')">
            </form>
        </td>
    @else
        {{-- User thường không được sửa/xóa ai cả --}}
        <td colspan="2"></td>
    @endif
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