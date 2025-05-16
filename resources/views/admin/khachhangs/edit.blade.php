@extends('admin_layout')
@section('admin_content')
<h1 class="h3 mb-3"><strong>Sửa quyền user</strong></h1>

    <div class="err">
        @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
        @endif
    </div>


    <form method="POST" action="" enctype="multipart/form-data">
        @csrf
        @method('put')

        <div class="mb-3">
            <label for="name" class="form-label">Chọn quyền:</label>
            <select name="id_phanquyen" class="form-select">
                <option value="" selected>
                    
                </option>

                <option disabled>-----------------------</option>

                
            </select>
        </div>

        <div>
            <input type="submit" class="btn btn-primary" value="Update">
            &nbsp;<a class="btn btn-secondary" href="">Hủy</a>
        </div>
    </form>

@endsection