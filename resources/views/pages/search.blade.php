@extends('layout')
@section('content')
<!-- Tất cả sản phẩm -->
<div class="body">

    <div class="body__mainTitle">
        <h2>Từ khóa đã tìm kiếm: {{ $tukhoa }}</h2>
    </div>    

    <div>
        <div class="row">
            @foreach ($searchs as $search)
            <div class="col-lg-2_5 col-md-4 col-6 post2">
                <a href="{{ route('detail', ['id' => $search->id_sanpham]) }}">
                    <div class="product">
                        <div class="product__img">
                            <img src="{{$search->anhsp}}" alt="">
                        </div>
                        <div class="product__sale">
                            <div>
                                @if($search->giamgia)
                                    -{{$search->giamgia}}%
                                @else Mới
                                @endif
                            </div>
                        </div>

                        <div class="product__content">
                            <div class="product__title">
                                {{$search->tensp}}
                            </div>

                            <div class="product__pride-oldPride">
                                <span class="Price">
                                    <bdi>
                                        {{ number_format($search->giasp, 0, ',', '.') }}
                                        <span class="currencySymbol">₫</span>
                                    </bdi>
                                </span>
                            </div>

                            <div class="product__pride-newPride">
                                <span class="Price">
                                    <bdi>
                                        {{ number_format($search->giakhuyenmai, 0, ',', '.') }}
                                        <span class="currencySymbol">₫</span>
                                    </bdi>
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>      
            @endforeach
        </div>
       <nav aria-label="Pagination">
    <ul class="pagination justify-content-center">

        {{-- Nút "First" --}}
        <li class="page-item {{ $searchs->onFirstPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $searchs->url(1) }}&tukhoa={{ $tukhoa }}" tabindex="-1">First</a>
        </li>

        <!-- {{-- Nút "Previous" --}}
        <li class="page-item {{ $searchs->onFirstPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $searchs->previousPageUrl() }}&tukhoa={{ $tukhoa }}" tabindex="-1">Previous</a>
        </li> -->

        {{-- Vòng lặp số trang --}}
        @for ($i = 1; $i <= $searchs->lastPage(); $i++)
            <li class="page-item {{ $searchs->currentPage() == $i ? 'active' : '' }}">
                <a class="page-link" href="{{ $searchs->url($i) }}&tukhoa={{ $tukhoa }}">{{ $i }}</a>
            </li>
        @endfor

        <!-- {{-- Nút "Next" --}}
        <li class="page-item {{ $searchs->currentPage() == $searchs->lastPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $searchs->nextPageUrl() }}&tukhoa={{ $tukhoa }}">Next</a>
        </li> -->

        {{-- Nút "Last" --}}
        <li class="page-item {{ $searchs->currentPage() == $searchs->lastPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $searchs->url($searchs->lastPage()) }}&tukhoa={{ $tukhoa }}">Last</a>
        </li>

    </ul>
</nav>

        
    </div>

</div>
@endsection