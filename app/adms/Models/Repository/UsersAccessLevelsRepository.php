<?php

namespace App\adms\Models\Repository;

use App\adms\Models\Services\DbConnection;
use PDO;

class UsersAccessLevelsRepository extends DbConnection
{
    public function getUserAccessLevel(int $id) : array|bool
    {
        // QUERY para recuperar o registro do banco de dados
        $sql ='SELECT 
        lev.name
        FROM adms_users_access_levels AS usr_lev
        INNER JOIN adms_access_levels AS lev ON lev.id = usr_lev.adms_access_level_id
        WHERE usr_lev.adms_user_id = :adms_user_id
        ORDER BY usr_lev.id DESC';

        // Preparar a quey
        $stmt = $this->getConnection()->prepare($sql);

        // Substituir o link pelo valor
        $stmt->bindValue(':adms_user_id', $id, PDO::PARAM_INT);

        // Executar a query
        $stmt->execute();
        
        // Ler os registros e retornar
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}