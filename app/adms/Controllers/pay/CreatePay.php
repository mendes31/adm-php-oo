<?php

namespace App\adms\Controllers\pay;

use App\adms\Controllers\Services\PageLayoutService;
use App\adms\Controllers\Services\Validation\ValidationPaymentsService;
use App\adms\Helpers\CSRFHelper;
use App\adms\Models\Repository\LogsRepository;
use App\adms\Models\Repository\PaymentsRepository;
use App\adms\Views\Services\LoadViewService;

/**
 * Controller para criação de Conta à Pagar
 *
 * Esta classe é responsável pelo processo de criação de novos Conta à Pagars. Ela lida com a recepção dos dados do
 * formulário, validação dos mesmos, e criação do Conta à Pagars no sistema. Além disso, é responsável por carregar
 * a visualização apropriada com mensagens de sucesso ou erro.
 * 
 * @package App\adms\Controllers\pay
 * @author Rafael Mendes
 */
class CreatePay
{
    /** @var array|string|null $data Dados que serão enviados para a VIEW */
    private array|string|null $data = null;

    /**
     * Método principal que gerencia a criação do Conta à Pagar.
     *
     * Este método é chamado para processar a criação de um novo departamento. Ele verifica a validade do token CSRF,
     * valida os dados do formulário e, se tudo estiver correto, cria o Conta à Pagar. Caso contrário, carrega a
     * visualização de criação do Conta à Pagar com mensagens de erro.
     * 
     * @return void
     */
    public function index(): void
    {
        // Receber os dados do formulário
        $this->data['form'] = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        // var_dump($this->data['form']);
        // exit;

        // Verificar se o token CSRF é válido
        if (isset($this->data['form']['csrf_token']) && CSRFHelper::validateCSRFToken('form_create_pay', $this->data['form']['csrf_token'])) {
            // Chamar o método para adicionar o Departamento
            $this->addPay();
        } else {
            // Chamar o método para carregar a view de criação de Departamento
            $this->viewPay();
        }
    }

    /**
     * Carregar a visualização de criação do Conta à Pagar.
     * 
     * Este método configura os dados necessários e carrega a view para a criação de um novo Conta à Pagar.
     * 
     * @return void
     */
    private function viewPay(): void
    {
        // Definir o título da página
        // Ativar o item de menu
        // Apresentar ou ocultar botão 
        $pageElements = [
            'title_head' => 'Cadastrar Conta à Pagar',
            'menu' => 'list-payments',
            'buttonPermission' => ['ListPayments'],
        ];
        $pageLayoutService = new PageLayoutService();
        $pageLayoutService->configurePageElements($pageElements);
        $this->data = array_merge($this->data, $pageLayoutService->configurePageElements($pageElements));

        // Carregar a VIEW
        $loadView = new LoadViewService("adms/Views/pay/create", $this->data);
        $loadView->loadView();
    }

    /**
     * Adicionar um novo Conta à Pagar ao sistema.
     * 
     * Este método valida os dados do formulário usando a classe de validação `ValidationPaymentsService` e,
     * se não houver erros, cria o Conta à Pagar no Conta à Pagar de dados usando o `PaymentsRepository`. Caso contrário, ele
     * recarrega a visualização de criação com mensagens de erro.
     * 
     * @return void
     */
    private function addPay(): void
    {
        // Instanciar a classe de validação dos dados do formulário
        $validationPayments = new ValidationPaymentsService();
        $this->data['errors'] = $validationPayments->validate($this->data['form']);

        // Se houver erros, recarregar a view com erros
        if (!empty($this->data['errors'])) {
            $this->viewPay();
            return;
        }

        // Instanciar o Repository para criar o Conta à Pagar
        $payCreate = new PaymentsRepository();
        $result = $payCreate->createPay($this->data['form']);

        // Se a criação do Conta à Pagar for bem-sucedida
        if ($result) {

            // gravar logs na tabela adms-logs
            if ($_ENV['APP_LOGS'] == 'Sim') {
                $dataLogs = [
                    'table_name' => 'adms_pay',
                    'action' => 'inserção',
                    'record_id' => $result,
                    'description' => $this->data['form']['partner_id'],
    
                ];
                // Instanciar a classe validar  o usuário
                $insertLogs = new LogsRepository();
                $insertLogs->insertLogs($dataLogs);
            }
            
            // Mensagem de sucesso
            $_SESSION['success'] = "Conta à Pagar cadastrado com sucesso!";

            // Redirecionar para a página de visualização do Conta à Pagar recém-criado
            header("Location: {$_ENV['URL_ADM']}view-pay/$result");
            return;
        } else {
            // Mensagem de erro
            $this->data['errors'][] = "Conta à Pagar não cadastrado!";

            // Recarregar a view com erro
            $this->viewPay();
        }
    }
}
