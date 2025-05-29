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

        $validatedData = $request->validate([
            'ten_danhmuc' => 'required',
        ]);

        $this->DanhmucRepository->storeDanhmuc($validatedData);

        return redirect()->route('danhmuc.index');
    }

    public function edit($id)
    {
        $danhmuc = $this->DanhmucRepository->findDanhmuc($id);
        return view('admin.danhmucs.edit', ['danhmuc' => $danhmuc]);
    }

    public function update($id, Request $request)
    {
        $validatedData = $request->validate([
            'ten_danhmuc' => 'required',
        ]);
        $this->DanhmucRepository->updateDanhmuc($validatedData, $id);

        return redirect()->route('danhmuc.index')->with('success', 'Cập nhập danh mục thành công');
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
