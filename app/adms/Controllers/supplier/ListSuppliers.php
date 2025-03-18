<?php

namespace App\adms\Controllers\supplier;

use App\adms\Controllers\Services\PageLayoutService;
use App\adms\Controllers\Services\PaginationService;
use App\adms\Models\Repository\CustomerRepository;
use App\adms\Models\Repository\FrequencyRepository;
use App\adms\Models\Repository\SupplierRepository;
use App\adms\Views\Services\LoadViewService;

/**
 * Controller para listar Fornecedores
 *
 * Esta classe é responsável por recuperar e exibir uma lista de Fornecedores no sistema. Utiliza um repositório
 * para obter dados dos Fornecedores e um serviço de paginação para gerenciar a navegação entre páginas de resultados.
 * Em seguida, carrega a visualização correspondente com os dados recuperados.
 * 
 * @package App\adms\Controllers\supplier
 * @author Rafael Mendes
 */
class ListSuppliers
{
    /** @var array|string|null $data Dados que devem ser enviados para a VIEW */
    private array|string|null $data = null;

    /** @var int $limitResult Limite de registros por página */
    private int $limitResult = 10000; // Ajuste conforme necessário

    /**
     * Recuperar e listar Fornecedores com paginação.
     * 
     * Este método recupera os Fornecedores a partir do repositório de Fornecedores com base na página atual e no limite
     * de registros por página. Gera os dados de paginação e carrega a visualização para exibir a lista de Fornecedores.
     * 
     * @param string|int $page Página atual para a exibição dos resultados. O padrão é 1.
     * 
     * @return void
     */
    public function index(string|int $page = 1): void
    {
        // Instanciar o Repository para recuperar os registros do banco de dados
        $listSuppliers = new SupplierRepository();

        // Recuperar os Fornecedores para a página atual
        $this->data['suppliers'] = $listSuppliers->getAllSuppliers((int) $page, (int) $this->limitResult);

        // Gerar dados de paginação
        $this->data['pagination'] = PaginationService::generatePagination(
            (int) $listSuppliers->getAmountSuppliers(), 
            (int) $this->limitResult, 
            (int) $page, 
            'list-suppliers'
        );

        // Definir o título da página
        // Ativar o item de menu
        // Apresentar ou ocultar botão 
        $pageElements = [
            'title_head' => 'Listar Fornecedores',
            'menu' => 'list-suppliers',
            'buttonPermission' => ['CreateSupplier', 'ViewSupplier', 'UpdateSupplier', 'DeleteSupplier'],
        ];
        $pageLayoutService = new PageLayoutService();
        $pageLayoutService->configurePageElements($pageElements);
        $this->data = array_merge($this->data, $pageLayoutService->configurePageElements($pageElements));

        // Carregar a VIEW com os dados
        $loadView = new LoadViewService("adms/Views/supplier/list", $this->data);
        $loadView->loadView();
    }
}
