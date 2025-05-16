<?php
namespace App\Repositories;

use App\Repositories\IUserRepository;
use App\Models\Khachhang;

class UserRepository implements IUserRepository
{
    public function allKhachhang($keyword = null)
    {
        // return Khachhang::paginate(5);
        $query = Khachhang::query();

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('hoten', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%")
                    ->orWhere('sdt', 'like', "%{$keyword}%");
            });
        }

        return $query->paginate(5)->appends(['tukhoa' => $keyword]);
    }

}