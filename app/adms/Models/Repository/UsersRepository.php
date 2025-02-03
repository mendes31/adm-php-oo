<?php

namespace App\adms\Models\Repository;

use App\adms\Helpers\GenerateLog;
use App\adms\Models\Services\DbConnection;
use Exception;
use Generator;
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

    /**
     * Cadastrar novo usuário
     * @param array $data Dados do usuário
     * @return bool Sucesso ou falha
     */
    public function createUser(array $data): bool
    {
        // Usar o try e catch para gerenciar exeções/erro
        try{ // Permanece no try se não houver erro

            // QUERY cadastrar usuários
            $sql = 'INSERT INTO adms_users (name, email, username, password, created_at ) VALUES (:name, :email, :username, :password, :created_at)';

            // Preparar a QUERY
            $stmt = $this->getConnection()->prepare($sql);

            // Substituir os links da QUERY pelo valor
            $stmt->bindValue(':name', $data['name'], PDO::PARAM_STR);
            $stmt->bindValue(':email', $data['email'], PDO::PARAM_STR);
            $stmt->bindValue(':username', $data['username'], PDO::PARAM_STR);
            $stmt->bindValue(':password', password_hash($data['password'], PASSWORD_DEFAULT));
            $stmt->bindValue(':created_at', date("Y-m-d H:i:s"));

            // Executar a QUERY
            return $stmt->execute();
        } catch(Exception $e){ // Acessa o catch quando houver erro no try

            // Chamar o método para salvar o log
            GenerateLog::generateLog("error", "Usuário não cadastrado.", ['username' => $data['username'], 'email' => $data['email']]);

            return false;
        }

    }
}
