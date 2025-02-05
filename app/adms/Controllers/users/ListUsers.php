<?php

namespace App\adms\Controllers\users;

use App\adms\Models\Repository\UsersRepository;
use App\adms\Views\Services\LoadViewService;

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
        // Instanciar o Repository para recuperar os registros do banco de dados
        $listUsers = new UsersRepository();
        $this->data['users'] = $listUsers->getAllUsers();

        // Criar o título da página
        $this->data['title_head'] =  "Listar Usuários";

        // Carregar a VIEW
        $loadView = new LoadViewService("adms/Views/users/list", $this->data);
        $loadView->loadView();
    }
      
}