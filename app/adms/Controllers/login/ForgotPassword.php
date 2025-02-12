<?php

namespace App\adms\Controllers\login;

use App\adms\Controllers\Services\Validation\ValidationEmailService;
use App\adms\Helpers\CSRFHelper;
use App\adms\Helpers\GenerateLog;
use App\adms\Models\Repository\ResetPasswordRepository;
use App\adms\Models\Repository\UsersRepository;
use App\adms\Views\Services\LoadViewService;

class ForgotPassword
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para a VIEW */
    private array|string|null $data = null;

    public function index(): void
    {
        // Receber os dados do formulário
        $this->data['form'] = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        // Verificar se o token CSRF é valido
        if (isset($this->data['form']['csrf_token']) and CSRFHelper::validateCSRFToken('form_forgot_password', $this->data['form']['csrf_token'])) {

            // Chamar o método esqueceu a senha 
            $this->forgotPassword();
        } else {
            // Chamar método carregar a view de criação de usuário
            $this->viewForgotPassword();
        }
    }

    private function viewForgotPassword(): void
    {
        // Criar o título da página
        $this->data['title_head'] =  "Recuperar Senha";

        // Carregar a VIEW
        $loadView = new LoadViewService("adms/Views/login/forgotPassword", $this->data);
        $loadView->loadView();
    }
    


    private function forgotPassword(): void 
    {
        // Instanciar a classe validar os dados do fromuláriose com Rakit
        $validationUser = new ValidationEmailService();
        $this->data['errors'] = $validationUser->validate($this->data['form']);

        // Acessa o IF quando existir campo com dados incorretos
        if (!empty($this->data['errors'])) {
            // Chamar método carregar a view
            $this->viewForgotPassword();
            return;
        }

        // Instanciar o Repository para recuperar o registro do banco de dados
        $viewUser = new ResetPasswordRepository();
        $this->data['user'] = $viewUser->getUser((string) $this->data['form']['email']);


        // Verificar se existe o registro no banco de dados
        if (!$this->data['user']) {

            // Chamar o método para salvar o log
            GenerateLog::generateLog("error", "Usuário não encontrado.", ['email' => $this->data['form']['email']]);

            // Criar a mensagem de erro 
            $_SESSION['error'] = "Usuário não encontrado.";

            $this->viewForgotPassword();

            return;
        }

    }
}
