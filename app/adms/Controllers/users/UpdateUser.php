<?php

namespace App\adms\Controllers\users;

use App\adms\Helpers\CSRFHelper;
use App\adms\Helpers\GenerateLog;
use App\adms\Models\Repository\UsersRepository;
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

    /**
     * Editar os detalhes do usuário
     *      *
     * @param integer|string $id id do usuário
     * @return void
     */
    public function index(int|string $id): void
    {

        // REceber os dados
        $this->data['form'] = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        // Acessar o IF se existir o CSRF e for valido o CSRF
        if (isset($this->data['form']['csrf_token']) and CSRFHelper::validateCSRFToken('form_create_user', $this->data['form']['csrf_token'])) {

            // Chamar o método editar
            $this->editUser();
           

        } else {
            
            // Instanciar o Repository para recuperar o registro do banco de dados
            $viewUser = new UsersRepository();
            $this->data['form'] = $viewUser->getUser((int) $id);

            // Verificar se existe o registro no banco de dados
            if (!$this->data['form']) {

                // Chamar o método para salvar o log
                GenerateLog::generateLog("error", "Usuário não encontrado.", ['id' => (int) $id]);

                // Criar a mensagem de erro 
                $_SESSION['error'] = "Usuário não encontrado.";

                // Redirecionar o usuário para página listar
                header("Location: {$_ENV['URL_ADM']}list-users");
                return;
            }

            // Chamar método carregar a view
            $this->viewUser();
        }
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

    /**
     * Editar usuário
     * 
     * Este método realiza a edição de um usuário existente nos sistema. Ele valida os dados do formulário usando a classe `ValidationUserRakitService`, exibe a view com os erros caso existam campos com dados incorretos.
     * Chama o repositório para atualizar o usuário e, dependendo do resultado, redireciona o usuario ou exibe uma mensagem de erro.
     * 
     * @return void
     */
    private function editUser(): void 
    {
        echo "Editar";
        var_dump($this->data);

    }
}
