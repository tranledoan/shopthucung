@extends('admin_layout')
@section('admin_content')

<h1 class="h3 mb-3"><strong>Từ khóa đã tìm kiếm: {{ $tukhoa }}</strong></h1>

<div class="d-flex justify-content-between">


    <form action="{{ route('adminSearchUser') }}" method="GET" class="d-flex">
        <input type="text" value="{{ request('tukhoa') }}" placeholder="Nhập để tìm kiếm..." name="tukhoa"
            class="form-control" style="width: unset;" required>
        <button class="btn btn-primary" type="submit">
            <i class="align-middle" data-feather="search"></i>
        </button>
    </form>
</div>
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên khách hàng</th>
            <th>Email</th>
            <th>SĐT</th>
            <th>Địa chỉ</th>
            <th>Quyền</th>
            <th colspan="2">Actions</th>
        </tr>
    </thead>
    <tbody>
        @if($searchs->isEmpty())
            <tr>
                <td colspan="6" class="text-center" style="color: red; font-weight: bold;">
                    Không tìm thấy sản phẩm nào với từ khóa "{{ $tukhoa }}"
                </td>
            </tr>
        @else
            @foreach ($searchs as $khachhang)
                <tr>
                    <td>{{ $khachhang->id_kh }}</td>
                    <td>{{ $khachhang->hoten }}</td>
                    <td>{{ $khachhang->email }}</td>
                    <td>{{ $khachhang->sdt }}</td>
                    <td>{{ $khachhang->diachi }}</td>
                    <td>
                        @if($khachhang->id_phanquyen == 1)
                            admin
                        @elseif($khachhang->id_phanquyen == 2)
                            user
                        @elseif($khachhang->id_phanquyen == 3)
                            staff
                        @else
                            khác
                        @endif
                    </td>
                    <td colspan="2">
                        <a href="#" class="btn btn-warning mb-2">Edit</a>
                        <form method="post" action="#">
                            @csrf
                            @method('delete')
                            <input type="submit" class="btn btn-danger" value="Delete"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa user này không?')">
                        </form>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
    </div>
</table>
@endsection