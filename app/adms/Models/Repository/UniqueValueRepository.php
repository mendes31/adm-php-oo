<?php

namespace App\adms\Models\Repository;

use App\adms\Models\Services\DbConnection;
use PDO;

/**
 * Repository responsável em verificar se existe um registro com dados fornecidos
 * 
 * @author Rafael Mendes
 */
class UniqueValueRepository extends DbConnection
{

    /**
     * Recuperar o registro com o dado fornecido
     * 
     * @return bool Retornar falso se o valor fornecido já estiver cadastrado, verdadeiro caso contrário 
     */
    public function getRecord($table, $column, $value)
    {
        // QUERY para recuperar o registro do baco de dados
        $sql = "SELECT count(id) as count FROM `{$table}` WHERE `{$column}` = :value";

        // Preparar a QUERY
        $stmt = $this->getConnection()->prepare($sql);

        // Substituir os links da QUERY pelo valor
        $stmt->bindParam(':value', $value, PDO::PARAM_STR);

        // Executar a QUERY
        $stmt->execute();

        // Retornar falso se o valor fornecido já estiver cadastrado e verdadeiro caso contrário
        return $stmt->fetchColumn() === 0;
    }
}
