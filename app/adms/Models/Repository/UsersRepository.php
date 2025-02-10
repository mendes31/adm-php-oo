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
    public function getAllUsers(int $page = 1, int $limitResult = 10)
    {
        // Calcular o registro inicial, função max para garantir valor minimo 0
        $offset = max(0, ($page - 1) * $limitResult);

        // QUERY para recuperar os registros do banco de dados
        $sql = 'SELECT id, name, email, username
                FROM adms_users 
                ORDER BY id DESC
                LIMIT :limit OFFSET :offset';

        // Preparar a QUERY
        $stmt = $this->getConnection()->prepare($sql);

        // Substituir o link da QUERY pelo valor / Evita SQL INJECTION
        $stmt->bindValue(':limit', $limitResult, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        // Executar a QUERY
        $stmt->execute();

        // Ler os registros e retornar
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Recuperar a quantidade de usuários para paginação
     * @return int|bool Quantidade de usuários encontrados no banco de dados
     */
    public function getAmountUsers(): int|bool
    {
        // Query para recuperar quantiade de registros
        $sql = 'SELECT COUNT(id) as amount_records 
        FROM adms_users';

        // Preparar a QUERY
        $stmt = $this->getConnection()->prepare($sql);

        // Executar a QUERY
        $stmt->execute();

        // Ler os registros e retornar
        return ($stmt->fetch(PDO::FETCH_ASSOC)['amount_records']) ?? 0;


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
     * @return bool|int Sucesso ou falha
     */
    public function createUser(array $data): bool|int
    {
        // Usar o try e catch para gerenciar exeções/erro
        try { // Permanece no try se não houver erro

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
            $stmt->execute();

            // Retornar o ID do usuário recém cadastrado
            return $this->getConnection()->lastInsertId();
        } catch (Exception $e) { // Acessa o catch quando houver erro no try

            // Chamar o método para salvar o log
            GenerateLog::generateLog("error", "Usuário não cadastrado.", ['username' => $data['username'], 'email' => $data['email'], 'error' => $e->getMessage()]);

            return false;
        }
    }

    /**
     * Editar os dados do usuário
     * @param array $data Dados atualizados do usuário
     * @return bool Sucesso ou falha
     */
    public function updateUser(array $data): bool
    {
        // Usar try e catch para gerenciar exceção/erro

        try { // Permanece no try se não houver nenhum erro

            // QUERY para atualizar o usuário
            $sql = 'UPDATE adms_users SET name = :name, email = :email, username = :username, updated_at = :updated_at';

            // Verificar se a senha está incluida nos dados e, se sim, adicionar ao SQL
            if (!empty($data['password'])) {
                $sql .= ', password = :password';
            }

            // Condição para indicar qual registro editar
            $sql .= ' WHERE id = :id';

            // Preparar a QUERY
            $stmt = $this->getConnection()->prepare($sql);

            // Substituir os links da QUERY pelo valor
            $stmt->bindValue(':name', $data['name'], PDO::PARAM_STR);
            $stmt->bindValue(':email', $data['email'], PDO::PARAM_STR);
            $stmt->bindValue(':username', $data['username'], PDO::PARAM_STR);
            $stmt->bindValue(':updated_at', date("Y-m-d H:i:s"));
            $stmt->bindValue(':id', $data['id'], PDO::PARAM_INT);

            // Substituir o link da senha se a mesma estiver presente
            if (!empty($data['password'])) {
                $stmt->bindValue(':password', password_hash($data['password'], PASSWORD_DEFAULT));
            }

            // Retornar TRUE quando conseguir executar a QUERY SQL, não considerando se alterou dados do registro
            return $stmt->execute();

            // // Retornar TRUE quando conseguir executar a QUERY SQL e alterou dados do registro, se não alterar nenhuma informação do registro, retorna FALSE indicando que o registro não foi alterado/editdo.
            // // Executar a QUERY
            // $stmt->execute();

            // // Receber a quantidade de linhas afetadas
            // $affectedRows = $stmt->rowCount();

            // // Verificar o número de linhas afetadas
            // if ($affectedRows > 0) {
            //     return true;

            // } else {
            //     // Chamar o método para salvar o log
            //     GenerateLog::generateLog("error", "Usuário não editado, nenhum valor foi alterado.", ['id' => $data['id'], 'email' => $data['email'], 'username' => $data['username']]);

            //     return false;
            // }

        } catch (Exception $e) { // Acessa o catch quando houver erro no try

            // Chamar o método para salvar o log
            GenerateLog::generateLog("error", "Usuário não editado, nenhum valor foi alterado.", ['id' => $data['id'], 'email' => $data['email'], 'username' => $data['username'], 'error' => $e->getMessage()]);

            return false;
        }
    }

    /**
     * Editar senha do usuário
     * @param array $data Dados atualizados do usuário
     * @return bool Sucesso ou falha
     */
    public function updatePasswordUser(array $data): bool
    {

        // Usar try e catch para gerenciar exceção/erro
        try {  // Permanece no try se não houver nenhum erro

            // QUERY para atualizar usuário
            // Condição para indicar qual registro editar
            $sql = 'UPDATE adms_users SET password = :password, updated_at = :updated_at WHERE id = :id';

            // Preparar a QUERY
            $stmt = $this->getConnection()->prepare($sql);

            // Substituir os links da QUERY pelo valor
            $stmt->bindValue(':password', password_hash($data['password'], PASSWORD_DEFAULT));
            $stmt->bindValue(':updated_at', date("Y-m-d H:i:s"));
            $stmt->bindValue(':id', $data['id'], PDO::PARAM_INT);

            // Retornar TRUE quando conseguir executar a QUERY SQL, não considerando se alterou dados do registro
            return $stmt->execute();
        } catch (Exception $e) { // Acessa o catch quando houver erro no try

            // Chamar o método para salvar o log
            GenerateLog::generateLog("error", "Senha não editada.", ['id' => $data['id'], 'error' => $e->getMessage()]);

            return false;
        }
    }

    /**
     * Deletar usuário pelo ID
     * @param int $id
     * @return bool Sucesso ou falha
     */
    public function deleteUser(int $id): bool
    {
        // Usar try e catch para gerenciar exceção/erro
        try {
            // QUERY para deletar usuário
            $sql = 'DELETE FROM adms_users WHERE id = :id LIMIT 1';

            // Preparar a QUERY
            $stms = $this->getConnection()->prepare($sql);

            // Substituir o link da QUERY pelo valor 
            $stms->bindValue(':id', $id, PDO::PARAM_INT);

            // Executar a QUERY
            $stms->execute();

            // Verificar o número de linhas afetadas
            $affectedRows = $stms->rowCount();

            // Verificar o número de linhas afetadas
            if ($affectedRows > 0) {
                return true;
            } else {

                // Chamar o método para salvar o log
                GenerateLog::generateLog("error", "Usuário não apagado.", ['id' => $id]);

                return false;
            }
        } catch (Exception $e) {

            // Chamar o método para salvar o log
            GenerateLog::generateLog("error", "Usuário não apagado.", ['id' => $id, 'error' => $e->getMessage()]);

            return false;
        }
    }
}
