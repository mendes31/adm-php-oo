<?php

namespace App\adms\Models\Repository;

use App\adms\Models\Services\DbConnection;

class UsersRepository extends DbConnection
{

    public function getAllUsers()
    {
    //    $conexao = new DbConnection();
    //    $conexao->getConnection();
    $this->getConnection();
    }
}