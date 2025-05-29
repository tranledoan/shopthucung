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
        $request->merge([
            'tensp' => trim($request->input('tensp')),
        ]);
        $validatedData = $request->validate([
            'tensp' => 'required|max:255',
            'anhsp' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'giasp' => 'required|decimal:0,2',
            'mota' => 'nullable',
            'giamgia' => 'nullable|numeric|min:0|max:100',
            'giakhuyenmai' => 'nullable|decimal:0,2',
            'soluong' => 'required|numeric',
            'id_danhmuc' => 'required',
        ], [
            'tensp.required' => 'Tên sản phẩm không được để trống.',
            'tensp.max' => 'Chiều dài tên sản phẩm không được vượt quá 255 ký tự.',
            'giamgia.max' => 'Chiều dài tên sản phẩm không được vượt quá 100 ký tự.',
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
        if (!$product) {
            return redirect()->route('product.index')->with('error', 'Sản phẩm không tồn tại');
        }
        return view('admin.products.edit', ['product' => $product, 'list_danhmucs' => $list_danhmucs]);
    }

    public function update($id, Request $request)
    {
        $validatedData = $request->validate([
            'tensp' => 'required',
            'anhsp' => 'nullable|image', // Nên thêm validate ảnh
            'giasp' => 'required|numeric', // decimal validator Laravel chưa hỗ trợ sẵn, dùng numeric
            'mota' => 'nullable',
            'giamgia' => 'nullable|numeric',
            'giakhuyenmai' => 'nullable|numeric',
            'soluong' => 'required|numeric',
            'id_danhmuc' => 'required',
            'version' => 'required|integer', // Thêm validate version
        ]);

        // Lấy sản phẩm hiện tại
        $product = $this->productRepository->findProduct($id);
        if (!$product) {
            return redirect()->back()->with('error', 'Sản phẩm không tồn tại');
        }

        // Kiểm tra version
        if ($request->version != $product->version) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Sản phẩm đã được cập nhật ở trước đó. Vui lòng tải lại trang trước khi cập nhật.');
        }

        // Xử lý upload ảnh nếu có
        if ($request->hasFile('anhsp')) {
            $file = $request->file('anhsp');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('frontend_storage/upload'), $filename);
            $validatedData['anhsp'] = 'frontend_storage/upload/' . $filename;
        } else {
            // Nếu không upload ảnh mới, giữ lại ảnh cũ
            $validatedData['anhsp'] = $product->anhsp;
        }

        // Tính giá khuyến mãi
        $giagoc = $validatedData['giasp'];
        $giamgia = $validatedData['giamgia'] ?? 0;

        $tinh = ($giagoc * $giamgia) / 100;
        $validatedData['giakhuyenmai'] = $giagoc - $tinh;

        // Tăng version lên 1
        $validatedData['version'] = $product->version + 1;

        // Cập nhật sản phẩm qua repository
        $this->productRepository->updateProduct($validatedData, $id);

        return redirect()->route('product.index')->with('success', 'Cập nhật sản phẩm thành công');
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
