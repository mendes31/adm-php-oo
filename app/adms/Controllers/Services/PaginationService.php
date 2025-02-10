<?php

namespace App\adms\Controllers\Services;

class PaginationService
{
    /**
     * Gerar os dados de  paginação
     *
     * @param integer $totalRecords Total de registros
     * @param integer $limitResult Registros por página
     * @param integer $currentPage Página atual
     * @param string $urlController URL do controller
     * @return array Dados da paginação
     */
    public static function generatePagination(int $totalRecords, int $limitResult, int $currentPage, string $urlController): array
    {
        // Calcular o numero total de páginas
        $lastPage = (int) ceil($totalRecords / $limitResult);

        // Retornar os dados da paginação
        return [
            'amount_records' => $totalRecords,
            'last_page' => $lastPage,
            'current_page' => $currentPage == 0 ? 1 :$currentPage,
            'url_controller' => $urlController

        ];
    }
}
