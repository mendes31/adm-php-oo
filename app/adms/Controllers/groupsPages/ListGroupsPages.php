<?php

namespace App\adms\Controllers\groupsPages;

use App\adms\Controllers\Services\PaginationService;
use App\adms\Models\Repository\GroupsPagesRepository;
use App\adms\Models\Repository\PackagesRepository;
use App\adms\Views\Services\LoadViewService;

/**
 * Controller para listar grupos de página
 *
 * Esta classe é responsável por recuperar e exibir uma lista de grupos de página no sistema. Utiliza um repositório
 * para obter dados dos grupos de página e um serviço de paginação para gerenciar a navegação entre páginas de resultados.
 * Em seguida, carrega a visualização correspondente com os dados recuperados.
 * 
 * @package App\adms\Controllers\groups
 * @author Rafael Mendes
 */
class ListGroupsPages
{
    /** @var array|string|null $data Dados que devem ser enviados para a VIEW */
    private array|string|null $data = null;

    /** @var int $limitResult Limite de registros por página */
    private int $limitResult = 10; // Ajuste conforme necessário

    /**
     * Recuperar e listar grupos de página com paginação.
     * 
     * Este método recupera os grupos de página a partir do repositório de grupos de página com base na página atual e no limite
     * de registros por página. Gera os dados de paginação e carrega a visualização para exibir a lista de grupos de página.
     * 
     * @param string|int $page Página atual para a exibição dos resultados. O padrão é 1.
     * 
     * @return void
     */
    public function index(string|int $page = 1): void
    {
        // Instanciar o Repository para recuperar os registros do banco de dados
        $listGroupsPages = new GroupsPagesRepository();

        // Recuperar os grupos de página para a página atual
        $this->data['groupsPages'] = $listGroupsPages->getAllGroupsPages((int) $page, (int) $this->limitResult);

        // Gerar dados de paginação
        $this->data['pagination'] = PaginationService::generatePagination(
            (int) $listGroupsPages->getAmountGroupsPages(), 
            (int) $this->limitResult, 
            (int) $page, 
            'list-groups'
        );

        // Definir o título da página
        $this->data['title_head'] = "Listar Grupos de Páginas";

        // Ativar o item de menu
        $this->data['menu'] = "list-groups-pages";

        // Carregar a VIEW com os dados
        $loadView = new LoadViewService("adms/Views/groupsPages/list", $this->data);
        $loadView->loadView();
    }
}
