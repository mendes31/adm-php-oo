<?php

namespace App\adms\Controllers\permission;

use App\adms\Helpers\CSRFHelper;
use App\adms\Helpers\GenerateLog;
use App\adms\Models\Repository\AccessLevelsPagesRepository;
use App\adms\Models\Repository\AccessLevelsRepository;
use App\adms\Models\Repository\PagesRepository;
use App\adms\Views\Services\LoadViewService;

class ListAccessLevelsPermissions
{
    /** @var array|string|null $data Dados que devem ser enviados para a VIEW */
    private array|string|null $data = null;

    /** 
     * @var int $id ID do nível de acesso 
     */
    private int $id;

    public function index(string|int $id): void
    {

        $this->id = $id;

        // Receber os dados do formulário
        $this->data['form'] = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        // Validar o CSRF token e a existência do ID do nível de acesso
        if (
            isset($this->data['form']['csrf_token']) &&
            CSRFHelper::validateCSRFToken('form_update_access_level_permissions', $this->data['form']['csrf_token'])
        ) {
            // Editar o nível de acesso
            //$this->editAccessLevelPermissions();
        } else {
            // Carregar a visualização para edição do nível de acesso
            $this->viewAccessLevelPermissions();
        }
        
    }

    private function viewAccessLevelPermissions(): void
    {     

        // Recuperar o registro do nível de acesso
        $viewAccessLevel = new AccessLevelsRepository();
        $this->data['accessLevel'] = $viewAccessLevel->getAccessLevel($this->id);

        // Verificar se o nível de acesso foi encontrado
        if (!$this->data['accessLevel']) {
            // Registrar o erro e redirecionar
            GenerateLog::generateLog("error", "Nível de acesso não encontrado", ['id' => (int) $this->id]);
            $_SESSION['error'] = "Nível de acesso não encontrado!";
            header("Location: {$_ENV['URL_ADM']}list-access-levels");
            return;
        }

        // Recuperar as páginas associadas ao nível de acesso
        $listPages = new PagesRepository();
        $this->data['pages'] = $listPages->getAllPagesFull();
        
        $listAccessLevelsPages = new AccessLevelsPagesRepository();
        $this->data['accessLevelsPages'] = $listAccessLevelsPages->getPagesAccessLevelsArray($this->id, true);
        
        // Definir o título da página
        $this->data['title_head'] = "Editar Permissão do Nível de Acesso";

        // Ativar o item de menu
        $this->data['menu'] = "list-access-levels";

        // Carregar a VIEW
        $loadView = new LoadViewService("adms/Views/permission/list", $this->data);
        $loadView->loadView();
    }
}
