<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Khachhang;
use App\Models\Phanquyen;

use App\Repositories\IUserRepository;

class UserController extends Controller
{

    private $UserRepository;

    public function __construct(IUserRepository $UserRepository)
    {
        $this->UserRepository = $UserRepository;
    }

    public function index(Request $request)
    {
        $keyword = $request->input('tukhoa');

        // Lấy dữ liệu Khachhang phân trang (ví dụ 10 bản ghi / trang), truyền keyword nếu có để lọc
        $Khachhangs = $this->UserRepository->allKhachhang();

        $currentPage = $Khachhangs->currentPage();
        $lastPage = $Khachhangs->lastPage();

        $pageParam = $request->query('page');

        // Kiểm tra page truyền vào có hợp lệ không
        if (!is_null($pageParam) && (!ctype_digit($pageParam) || (int) $pageParam > $lastPage)) {
            return redirect()->route('khachhang.index', ['page' => $lastPage, 'tukhoa' => $keyword])
                ->with('error', 'Trang không hợp lệ, đã chuyển về trang hợp lệ gần nhất.');
        }

        return view('admin.khachhangs.index', [
            'Khachhangs' => $Khachhangs,
            'keyword' => $keyword
        ]);
    }

    public function search(Request $request)
    {
        $tukhoa = $request->tukhoa;
        $searchs = Khachhang::where('hoten', 'like', "%$tukhoa%")
            ->orWhere('email', 'like', "%$tukhoa%")
            ->orWhere('sdt', 'like', "%$tukhoa%")
            ->paginate(10);

        return view('admin.khachhangs.search', compact('searchs', 'tukhoa'));
    }
   public function destroy($id)
{
    $khachhang = Khachhang::find($id);
    $currentUser = auth()->user(); // người dùng đang đăng nhập

    if (!$khachhang) {
        return redirect()->back()->with('error', 'User không tồn tại.');
    }

    // Nếu tài khoản muốn xóa là super admin
    if ($khachhang->is_superadmin) {
        return redirect()->back()->with('error', 'Không thể xóa Super Admin.');
    }

    // Nếu người đăng nhập không phải super admin mà muốn xóa admin thường
    if (!$currentUser->is_superadmin && $khachhang->id_phanquyen == 1) {
        return redirect()->back()->with('error', 'Bạn không có quyền xóa Admin.');
    }

    $khachhang->delete();

    return redirect()->back()->with('success', 'Xóa user thành công.');
}

    public function editUser($id)
    {
        $khachhang = Khachhang::findOrFail($id);
        return view('admin.khachhangs.edit', compact('khachhang'));
    }

 public function updateUser(Request $request, $id)
{
    $khachhang = Khachhang::findOrFail($id);
    $currentUser = auth()->user();

    // Không cho sửa super admin
    if ($khachhang->is_superadmin) {
        return redirect()->back()->with('error', 'Không thể sửa Super Admin.');
    }

    // Nếu user thường muốn sửa admin thì cấm
    if (!$currentUser->is_superadmin && $khachhang->id_phanquyen == 1) {
        return redirect()->back()->with('error', 'Bạn không có quyền sửa Admin.');
    }

    $request->validate([
        'id_phanquyen' => 'required|in:1,2,3',
    ]);

    $khachhang->id_phanquyen = $request->id_phanquyen;
    $khachhang->save();

    return redirect()->route('khachhang.index')->with('success', 'Cập nhật quyền thành công!');
}



}