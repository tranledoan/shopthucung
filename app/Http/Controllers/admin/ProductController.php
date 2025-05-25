<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\Sanpham;
use App\Models\Danhmuc;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Repositories\IProductRepository;

class ProductController extends Controller
{

    private $productRepository;

    public function __construct(IProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

   public function index(Request $request)
{
    $products = $this->productRepository->allProduct();

    // Kiểm tra số trang hợp lệ
    $currentPage = $products->currentPage();
    $lastPage = $products->lastPage();

    // Nếu `page` truyền vào không hợp lệ (chữ) hoặc vượt quá `lastPage`
    $pageParam = $request->query('page');
    if (!is_null($pageParam) && (!ctype_digit($pageParam) || $pageParam > $lastPage)) {
        return redirect()->route('product.index', ['page' => $lastPage])
                         ->with('error', 'Trang không hợp lệ, đã chuyển về trang hợp lệ gần nhất.');
    }

    return view('admin.products.index', ['products' => $products]);
}

    public function create()
    {
        $list_danhmucs = Danhmuc::all();
        return view('admin.products.create', ['list_danhmucs' => $list_danhmucs]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tensp' => 'required',
            'anhsp' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'giasp' => 'required|decimal:0,2',
            'mota' => 'nullable',
            'giamgia' => 'nullable|numeric|min:0|max:100',
            'giakhuyenmai' => 'nullable|decimal:0,2',
            'soluong' => 'required|numeric',
            'id_danhmuc' => 'required'
        ]);

        // Xử lý upload hình ảnh
        if ($request->hasFile('anhsp')) {
            $file = $request->file('anhsp');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('frontend_storage/upload'), $filename);
            $validatedData['anhsp'] = 'frontend_storage/upload/' . $filename;
        }

        // Tính giá khuyến mãi nếu có giảm giá
        $giagoc = $validatedData['giasp'];
        $giamgia = $validatedData['giamgia'] ?? 0;
        $tinh = ($giagoc * $giamgia) / 100;
        $validatedData['giakhuyenmai'] = $giagoc - $tinh;

        // Lưu sản phẩm
        $this->productRepository->storeProduct($validatedData);

        return redirect()->route('product.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    public function edit($id)
    {
        $list_danhmucs = Danhmuc::all();
        $product = $this->productRepository->findProduct($id);
        return view('admin.products.edit', ['product' => $product, 'list_danhmucs' => $list_danhmucs]);
    }

    public function update($id, Request $request)
    {
        $validatedData = $request->validate([
            'tensp' => 'required',
            'anhsp' => 'nullable',
            'giasp' => 'required|decimal:0,2',
            'mota' => 'nullable',
            'giamgia' => 'nullable',
            'giakhuyenmai' => 'nullable|decimal:0,2',
            'soluong' => 'required|numeric',
            'id_danhmuc' => 'required'
        ]);

        // Lưu hình ảnh vào thư mục frontend/uploads
         if ($request->hasFile('anhsp')) {
            $file = $request->file('anhsp');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('frontend_storage/upload'), $filename);
            $validatedData['anhsp'] = 'frontend_storage/upload/' . $filename;
        }

        //tinh giam gia
        $giagoc = $validatedData['giasp'];
        $giamgia = $validatedData['giamgia'];

        $tinh = ($giagoc * $giamgia) / 100;
        $validatedData['giakhuyenmai'] = $giagoc - $tinh;

        $this->productRepository->updateProduct($validatedData, $id);

        return redirect()->route('product.index')->with('success', 'Cập nhập sản phẩm thành công');
    }
    public function destroy($id)
    {
        try {
            $item = Sanpham::findOrFail($id);
            $item->delete();

            return redirect()->back()->with('success', 'Xóa thành công.');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Bản ghi không tồn tại hoặc đã bị xóa.');
        }
    }

}
