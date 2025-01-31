<?php

namespace App\adms\Controllers\users;

use App\adms\Helpers\CSRFHelper;
use App\adms\Views\Services\LoadViewService;

/**
 * Controller cadastrar usuário
 * 
 * @author Rafael Mendes <raffaell_mendez@hotmail.com>
 */
class CreateUser
{
    /** @var array|null $dataForm Recebe os dados do FORMULARIO */
    private array|null $dataForm;

    /** @var array|string|null $data Recebe os dados que devem ser enviados para a VIEW */
    private array|string|null $data = null;

    public function index(): void
    {
        // REceber os dados
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);


        // Acessar o IF se existir o CSRF e for valido o CSRF
        if (isset($this->dataForm['csrf_token']) and CSRFHelper::validateCSRFToken('form_create_user', $this->dataForm['csrf_token'])) {
            var_dump($this->dataForm);
        }

        // Carregar a VIEW
        $loadView = new LoadViewService("adms/Views/users/create", $this->data);
        $loadView->loadView();
    }
}
