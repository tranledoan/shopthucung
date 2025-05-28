@extends('admin_layout')
@section('admin_content')

<h1 class="h3 mb-3"><strong>Sửa quyền user</strong></h1>

@if(session('error'))
    <div class="alert alert-warning">{{ session('error') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('adminUpdateUser', $khachhang->id_kh) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Chọn quyền:</label>
        <select name="id_phanquyen" class="form-select" required>
            <option value="" disabled>-- Chọn quyền --</option>
            <option value="1" {{ $khachhang->id_phanquyen == 1 ? 'selected' : '' }}>Admin</option>
            <option value="2" {{ $khachhang->id_phanquyen == 2 ? 'selected' : '' }}>User</option>
           
        </select>
    </div>

    <div>
        <input type="submit" class="btn btn-primary" value="Cập nhật">
        <a class="btn btn-secondary" href="{{ route('khachhang.index') }}">Hủy</a>
    </div>
</form>

@endsection
