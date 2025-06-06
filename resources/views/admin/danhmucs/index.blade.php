@extends('admin_layout')
@section('admin_content')

<h1 class="h3 mb-3"><strong>Danh sách danh mục</strong></h1>


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

<a class="btn btn-primary" href="{{route('danhmuc.create')}}">Thêm danh mục</a>

  <table class="table">
    <thead>
      <tr>
        <th>Id</th>
        <th>Tên danh mục</th>
        <th colspan="2">Actions</th>
      </tr>
    </thead>

    <tbody>
      @foreach($Danhmucs as $danhmuc)
      <tr>
        <td>{{$danhmuc->id_danhmuc}}</td>
        <td>{{$danhmuc->ten_danhmuc}}</td>
        <td colspan="2">
          <a href="{{ route('danhmuc.edit', ['danhmuc' => $danhmuc]) }}" class="btn btn-warning mb-2">Edit</a>
          <form method="post" action="{{route('danhmuc.destroy', ['danhmuc' => $danhmuc])}}">
              @csrf
              @method('delete')
              <input type="submit" class="btn btn-danger" value="Delete"
              onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này không?')">
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <nav aria-label="Page navigation example">
  <ul class="pagination">
      <li class="page-item @if($Danhmucs->currentPage() === 1) disabled @endif">
          <a class="page-link" href="{{ $Danhmucs->previousPageUrl() }}">Previous</a>
      </li>
      @for ($i = 1; $i <= $Danhmucs->lastPage(); $i++)
          <li class="page-item @if($Danhmucs->currentPage() === $i) active @endif">
              <a class="page-link" href="{{ $Danhmucs->url($i) }}">{{ $i }}</a>
          </li>
      @endfor
      <li class="page-item @if($Danhmucs->currentPage() === $Danhmucs->lastPage()) disabled @endif">
          <a class="page-link" href="{{ $Danhmucs->nextPageUrl() }}">Next</a>
      </li>
  </ul>
</nav>
@endsection