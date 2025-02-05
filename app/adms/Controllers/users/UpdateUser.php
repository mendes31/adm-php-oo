<?php

namespace App\adms\Controllers\users;

use App\adms\Views\Services\LoadViewService;

/**
 * Controller editae usuário
 * 
 * @author Rafael Mendes <raffaell_mendez@hotmail.com>
 */
class UpdateUser
{
    // /** @var array|null $dataForm Recebe os dados do FORMULARIO */
    // private array|null $dataForm;

    /** @var array|string|null $data Recebe os dados que devem ser enviados para a VIEW */
    private array|string|null $data = null;

    public function index(): void
    {
        // Chamar método carregar a view
        $this->viewUser();
    }

    /**
     * Instanciar a classe responsável em carregar a VIEW e enviar os dados para a VIEW.
     *
     * @return void
     */
    private function viewUser(): void
    {
        // Criar o título da página
        $this->data['title_head'] =  "Editar Usuário";

        // Carregar a VIEW
        $loadView = new LoadViewService("adms/Views/users/update", $this->data);
        $loadView->loadView();
    }
}
