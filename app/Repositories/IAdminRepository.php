<?php
namespace App\Repositories;

interface IAdminRepository{
    public function signIn($data);
    public function logOut();
}