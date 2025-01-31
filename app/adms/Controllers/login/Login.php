<?php

namespace App\adms\Controllers\login;

use App\adms\Views\Services\LoadViewService;

/**
 * Controller login
 * 
 * @author Rafael Mendes <raffaell_mendez@hotmail.com>
 */
class Login
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para a VIEW */
    private array|string|null $data = null;
    /**
     * Pagian login
     * 
     * @return void
     */
    public function index(): void
    {

        // Carregar a VIEW
        $loadView = new LoadViewService("adms/Views/login/login", $this->data);
        $loadView->loadView();
    }
}
