<?php

namespace App\adms\Controllers\dashboard;

use App\adms\Views\Services\LoadViewService;

class Dashboard
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para a VIEW */
    private array|string|null $data = null;

    public function index()
    {
        // Criar o título da página
        $this->data['title_head'] =  "Dashboard";

        // Carregar a VIEW
        $loadView = new LoadViewService("adms/Views/dashboard/dashboard", $this->data);
        $loadView->loadView();
    }
      
}