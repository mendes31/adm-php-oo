<?php

namespace App\adms\Models\Repository;

use App\adms\Models\Services\DbConnection;
use PDO;

/**
 * Repository responsável em buscar os usuários no banco de dados
 * 
 * @return Rafael Mendes
 */
class UsersRepository extends DbConnection
{
    /**
     * Recuperar os registros
     * @return array Usuários reguperados do banco de dados
     */
    public function getAllUsers()
    {
        // QUERY para recuperar os registros do banco de dados
        $sql = 'SELECT 
                    id, 
                    name, 
                    email,
                    username
                FROM adms_users 
                ORDER BY 
                    id DESC';

        // Preparar a QUERY
        $stmt = $this->getConnection()->prepare($sql);

        // Executar a QUERY
        $stmt->execute();

        // Ler os registros e retornar
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Recuperar o usuário seleionado
     * @return array|bool  Usuário recuperado do banco de dados
     */
    public function getUser(int $id): array|bool
    {
        // QUERY para recuperar o registro selecionado do banco de dados
        $sql = 'SELECT 
                    id, 
                    name, 
                    email, 
                    username,
                    created_at,
                    updated_at 
                FROM adms_users
                WHERE id = :id
                ORDER BY 
                    id DESC';

        // Preparar a QUERY
        $stmt = $this->getConnection()->prepare($sql);

        // Substituir o link da QUERY pelo valor / Evita SQL INJECTION
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        // Executar a QUERY
        $stmt->execute();

        // Ler o registro e retornar
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
