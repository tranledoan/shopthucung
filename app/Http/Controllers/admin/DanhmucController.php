<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Danhmuc;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Repositories\IDanhmucRepository;

class DanhmucController extends Controller
{

    private $DanhmucRepository;

    public function __construct(IDanhmucRepository $DanhmucRepository)
    {
        $this->DanhmucRepository = $DanhmucRepository;
    }

    //  public function index()
    // {
    //     $Danhmucs = Danhmuc::all();
    //     return view('admin.danhmuc.index', compact('Danhmucs'));
    // }
    public function index(Request $request)
    {
        // Lấy phân trang danh mục (ví dụ 10 bản ghi/trang)
        $Danhmucs = $this->DanhmucRepository->allDanhmuc();

        $currentPage = $Danhmucs->currentPage();
        $lastPage = $Danhmucs->lastPage();

        $pageParam = $request->query('page');

        // Kiểm tra page truyền vào có hợp lệ không
        if (!is_null($pageParam) && (!ctype_digit($pageParam) || (int) $pageParam > $lastPage)) {
            // Chuyển hướng về trang cuối hợp lệ, kèm thông báo lỗi
            return redirect()->route('danhmuc.index', ['page' => $lastPage])
                ->with('error', 'Trang không hợp lệ, đã chuyển về trang hợp lệ gần nhất.');
        }

        // Trả về view với dữ liệu phân trang
        return view('admin.danhmucs.index', ['Danhmucs' => $Danhmucs]);
    }


    public function create()
    {
        return view('admin.danhmucs.create');
    }

    public function store(Request $request)
    {
        // Validate dữ liệu nhập vào với quy tắc `unique` để kiểm tra trùng lặp
        $validatedData = $request->validate([
            'ten_danhmuc' => 'required|unique:danhmuc,ten_danhmuc|max:255',  // Kiểm tra trùng lặp tên danh mục
        ], [
            'ten_danhmuc.unique' => 'Tên danh mục này đã tồn tại. Vui lòng chọn tên khác.',  // Thông báo lỗi nếu trùng lặp
            'ten_danhmuc.required' => 'Tên danh mục không được để trống.',
            'ten_danhmuc.max' => 'Tên danh mục không được dài quá 255 ký tự.',
        ]);

        // Nếu không có lỗi validation, tiếp tục lưu danh mục
        $this->DanhmucRepository->storeDanhmuc($validatedData);

        return redirect()->route('danhmuc.index')->with('success', 'Danh mục đã được thêm thành công!');
    }


    public function edit($id)
    {
        // Lấy danh mục theo ID
        $danhmuc = Danhmuc::findOrFail($id);

        // Trả về view với danh mục và thông tin phiên bản
        return view('admin.danhmucs.edit', [
            'danhmuc' => $danhmuc,
            'version' => $danhmuc->version, // Gửi thông tin version
        ]);
        // $danhmuc = $this->DanhmucRepository->findDanhmuc($id);
        // return view('admin.danhmucs.edit', ['danhmuc' => $danhmuc]);
    }

    public function update(Request $request, $id)
    {
        // Lấy danh mục theo ID
        $danhmuc = Danhmuc::findOrFail($id);

        // Kiểm tra nếu phiên bản trong cơ sở dữ liệu không khớp với phiên bản mà người dùng gửi
        if ($danhmuc->version != $request->input('version')) {
            // Nếu không khớp, thông báo lỗi và yêu cầu tải lại trang
            return redirect()->route('danhmuc.edit', $id)
                ->with('error', 'Dữ liệu đã thay đổi, vui lòng tải lại trang trước khi cập nhật.');
        }

        // Cập nhật các trường dữ liệu mới
        $danhmuc->update($request->all());

        // Tăng phiên bản lên 1
        $danhmuc->version += 1;
        $danhmuc->save();

        return redirect()->route('danhmuc.index')->with('success', 'Cập nhật danh mục thành công!');
    }

    public function destroy($id)
    {
        try {
            $item = Danhmuc::findOrFail($id);
            $item->delete();

            return redirect()->back()->with('success', 'Xóa thành công.');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Bản ghi không tồn tại hoặc đã bị xóa.');
        }
        // $this->DanhmucRepository->deleteDanhmuc($id);

        // return redirect()->route('danhmuc.index')->with('success', 'Xóa danh mục thành công');
    }
}
