<?php

namespace App\adms\Controllers\departments;

use App\adms\Controllers\Services\PageLayoutService;
use App\adms\Controllers\Services\PaginationService;
use App\adms\Models\Repository\DepartmentsRepository;
use App\adms\Models\Repository\MenuPermissionUserRepository;
use App\adms\Views\Services\LoadViewService;

/**
 * Controller para listar departamentos
 *
 * Esta classe é responsável por recuperar e exibir uma lista de departamentos no sistema. Utiliza um repositório
 * para obter dados dos departamentos e um serviço de paginação para gerenciar a navegação entre páginas de resultados.
 * Em seguida, carrega a visualização correspondente com os dados recuperados.
 * 
 * @package App\adms\Controllers\departments
 * @author Rafael Mendes
 */
class ListDepartments
{
    /** @var array|string|null $data Dados que devem ser enviados para a VIEW */
    private array|string|null $data = null;

    /** @var int $limitResult Limite de registros por página */
    private int $limitResult = 10; // Ajuste conforme necessário

    /**
     * Recuperar e listar departamentos com paginação.
     * 
     * Este método recupera os departamentos a partir do repositório de departamentos com base na página atual e no limite
     * de registros por página. Gera os dados de paginação e carrega a visualização para exibir a lista de departamentos.
     * 
     * @param string|int $page Página atual para a exibição dos resultados. O padrão é 1.
     * 
     * @return void
     */
    public function index(string|int $page = 1): void
    {
        // Instanciar o Repository para recuperar os registros do banco de dados
        $listDepartments = new DepartmentsRepository();

        // Recuperar os departamentos para a página atual
        $this->data['departments'] = $listDepartments->getAllDepartments((int) $page, (int) $this->limitResult);

        // Gerar dados de paginação
        $this->data['pagination'] = PaginationService::generatePagination(
            (int) $listDepartments->getAmountDepartments(), 
            (int) $this->limitResult, 
            (int) $page, 
            'list-departments'
        );

        // Definir o título da página
        // Ativar o item de menu
        // Apresentar ou ocultar botão 
        $pageElements = [
            'title_head' => 'Listar Departmantos',
            'menu' => 'list-departments',
            'buttonPermission' => ['CreateDepartment', 'ViewDepartment', 'UpdateDepartments', 'DeleteDepartment'],
        ];
        $pageLayoutService = new PageLayoutService();
        $pageLayoutService->configurePageElements($pageElements);
        $this->data = array_merge($this->data, $pageLayoutService->configurePageElements($pageElements));

        // Apresentar ou ocultar item de menu
        // $menu = ['Dashboard', 'ListUsers', 'ListDepartments', 'ListPositions', 'ListAccessLevels', 'ListPackages', 'ListGroupsPages', 'ListPages'];
        // $menuPermission = new MenuPermissionUserRepository();
        // $this->data['menuPermission'] = $menuPermission->menuPermission($menu);

        // Carregar a VIEW com os dados
        $loadView = new LoadViewService("adms/Views/departments/list", $this->data);
        $loadView->loadView();
    }
}
