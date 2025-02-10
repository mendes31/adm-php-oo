<?php

namespace App\adms\Controllers\users;

use App\adms\Controllers\Services\PageController;
use App\adms\Controllers\Services\PaginationService;
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

    /** @var int $limitResult Recebe a quantidade de registros que deve retornar do banco de dados */
    private int $limitResult = 2;

    /**
     * Recuperar os últimos usuários
     * 
     * @return void
     */
    public function index(string|int $page = 1)
    {
        // Instanciar o Repository para recuperar os registros do banco de dados
        $listUsers = new UsersRepository();
        $this->data['users'] = $listUsers->getAllUsers((int) $page, (int) $this->limitResult);
        $this->data['pagination'] = PaginationService::generatePagination((int) $listUsers->getAmountUsers(), (int) $this->limitResult, (int) $page, 'list-users');

        // Criar o título da página
        $this->data['title_head'] =  "Listar Usuários";

        // Carregar a VIEW
        $loadView = new LoadViewService("adms/Views/users/list", $this->data);
        $loadView->loadView();
    }
}
