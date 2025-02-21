<?php

namespace App\adms\Controllers\accessLevels;

use App\adms\Controllers\Services\PaginationService;
use App\adms\Models\Repository\AccessLevelsRepository;
use App\adms\Views\Services\LoadViewService;

/**
 * Controller para listar níveis de acesso
 *
 * Esta classe é responsável por recuperar e exibir uma lista de níveis de acesso no sistema. Utiliza um repositório
 * para obter dados dos níveis de acesso e um serviço de paginação para gerenciar a navegação entre páginas de resultados.
 * Em seguida, carrega a visualização correspondente com os dados recuperados.
 * 
 * @package App\adms\Controllers\acessLevels
 * @author Rafael Mendes
 */
class ListAccessLevels
{
    /** @var array|string|null $data Dados que devem ser enviados para a VIEW */
    private array|string|null $data = null;

    /** @var int $limitResult Limite de registros por página */
    private int $limitResult = 10; // Ajuste conforme necessário

    /**
     * Recuperar e listar níveis de acesso com paginação.
     * 
     * Este método recupera os níveis de acesso a partir do repositório de níveis de acesso com base na página atual e no limite
     * de registros por página. Gera os dados de paginação e carrega a visualização para exibir a lista de níveis de acesso.
     * 
     * @param string|int $page Página atual para a exibição dos resultados. O padrão é 1.
     * 
     * @return void
     */
    public function index(string|int $page = 1): void
    {
        // Instanciar o Repository para recuperar os registros do banco de dados
        $listAccessLevels = new AccessLevelsRepository();

        // Recuperar os níveis de acesso para a página atual
        $this->data['accessLevels'] = $listAccessLevels->getAllAccessLevels((int) $page, (int) $this->limitResult);

        // Gerar dados de paginação
        $this->data['pagination'] = PaginationService::generatePagination(
            (int) $listAccessLevels->getAmountAccessLevels(), 
            (int) $this->limitResult, 
            (int) $page, 
            'list-access-levels'
        );

        // Definir o título da página
        $this->data['title_head'] = "Listar Níveis de Acesso";

        // Ativar o item de menu
        $this->data['menu'] = "list-access-levels";

        // Carregar a VIEW com os dados
        $loadView = new LoadViewService("adms/Views/accessLevels/list", $this->data);
        $loadView->loadView();
    }
}
