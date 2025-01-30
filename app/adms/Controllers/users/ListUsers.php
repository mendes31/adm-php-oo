<?php

namespace App\adms\Controllers\users;

use App\adms\Models\Repository\UsersRepository;

/**
 * Controller listar usuários
 * 
 * @author Rfael Mendes <raffaell_mendez@hotmail.com>
 */
class ListUsers
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para a VIEW */
    private array|string|null $data = null;

    /**
     * Recuperar os últimos usuários
     * 
     * @return void
     */
    public function index()
    {
        echo "Listar Usuários<br>";

        // Instanciar o Repository para recuperar os registros do banco de dados
        $listUsers = new UsersRepository();
        $this->data['users'] = $listUsers->getAllUsers();

        var_dump($this->data);
    }
      
}