<?php

namespace App\adms\Controllers\users;

use App\adms\Models\Repository\UsersRepository;

class ListUsers
{
    public function index()
    {
        echo "Listar Usuários<br>";

        $listUsers = new UsersRepository();
        $listUsers->getAllUsers();
    }
      
}