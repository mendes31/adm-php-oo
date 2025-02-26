<?php

namespace App\adms\Models\Repository;

use App\adms\Helpers\GenerateLog;
use App\adms\Models\Services\DbConnection;
use Exception;
use PDO;

/**
 * Repository responsável em buscar e manipular usuários no banco de dados.
 *
 * Esta classe fornece métodos para recuperar, criar, atualizar e deletar usuários no banco de dados.
 * Ela estende a classe `DbConnection` para gerenciar conexões com o banco de dados e utiliza o `GenerateLog`
 * para registrar erros que ocorrem durante as operações.
 *
 * @package App\adms\Models\Repository
 * @return Rafael Mendes
 */
class UsersRepository extends DbConnection
{
    /**
     * Recuperar todos os usuários com paginação.
     *
     * Este método retorna uma lista de usuários da tabela `adms_users`, com suporte à paginação.
     *
     * @param int $page Número da página para recuperação de usuários (começa do 1).
     * @param int $limitResult Número máximo de resultados por página.
     * @return array Lista de usuários recuperados do banco de dados.
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
     * Recuperar a quantidade total de usuários para paginação.
     *
     * Este método retorna a quantidade total de usuários na tabela `adms_users`, útil para a paginação.
     *
     * @return int Quantidade total de usuários encontrados no banco de dados.
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
     * Recuperar um usuário específico pelo ID.
     *
     * Este método retorna os detalhes de um usuário específico identificado pelo ID.
     *
     * @param int $id ID do usuário a ser recuperado.
     * @return array|bool Detalhes do usuário recuperado ou `false` se não encontrado.
     */
    public function getUser(int $id): array|bool
    {
        // QUERY para recuperar o registro selecionado do banco de dados
        $sql = 'SELECT id, name, email, username, created_at, updated_at 
                FROM adms_users
                WHERE id = :id
                ORDER BY id DESC';

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
     * Cadastrar um novo usuário.
     *
     * Este método insere um novo usuário na tabela `adms_users`. Em caso de erro, um log é gerado.
     *
     * @param array $data Dados do usuário a ser cadastrado, incluindo `name`, `email`, `username`, `password`.
     * @return bool|int `true` se o usuário foi criado com sucesso ou `false` em caso de erro.
     */
    public function createUser(array $data): bool|int
    {
        // Usar o try e catch para gerenciar exeções/erro
        try { // Permanece no try se não houver erro

            // QUERY cadastrar usuários
            $sql = 'INSERT INTO adms_users (name, email, username, user_department_id, user_position_id,  password, created_at ) VALUES (:name, :email, :username, user_department_id = :user_department_id, user_position_id = :user_position_id, :password, :created_at)';

            // Preparar a QUERY
            $stmt = $this->getConnection()->prepare($sql);

            // Substituir os links da QUERY pelo valor
            $stmt->bindValue(':name', $data['name'], PDO::PARAM_STR);
            $stmt->bindValue(':email', $data['email'], PDO::PARAM_STR);
            $stmt->bindValue(':username', $data['username'], PDO::PARAM_STR);
            $stmt->bindValue(':user_department_id', $data['user_department_id'], PDO::PARAM_INT);
            $stmt->bindValue(':user_position_id', $data['user_position_id'], PDO::PARAM_INT);
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
     * Atualizar os dados de um usuário existente.
     *
     * Este método atualiza as informações de um usuário existente. Se a senha for fornecida, ela também será atualizada.
     * Em caso de erro, um log é gerado.
     *
     * @param array $data Dados atualizados do usuário, incluindo `id`, `name`, `email`, `username`, e opcionalmente `password`.
     * @return bool `true` se a atualização foi bem-sucedida ou `false` em caso de erro.
     */
    public function updateUser(array $data): bool
    {
        // Usar try e catch para gerenciar exceção/erro

        try { // Permanece no try se não houver nenhum erro

            // QUERY para atualizar o usuário
            $sql = 'UPDATE adms_users SET name = :name, email = :email, username = :username, user_department_id = :user_department_id, user_position_id = :user_position_id, updated_at = :updated_at';

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
            $stmt->bindValue(':user_department_id', $data['user_department_id'], PDO::PARAM_INT);
            $stmt->bindValue(':user_position_id', $data['user_position_id'], PDO::PARAM_INT);
            $stmt->bindValue(':updated_at', date("Y-m-d H:i:s"));
            $stmt->bindValue(':id', $data['id'], PDO::PARAM_INT);

            // Substituir o link da senha se a mesma estiver presente
            if (!empty($data['password'])) {
                $stmt->bindValue(':password', password_hash($data['password'], PASSWORD_DEFAULT));
            }

            // Retornar TRUE quando conseguir executar a QUERY SQL, não considerando se alterou dados do registro
            return $stmt->execute();

        } catch (Exception $e) { // Acessa o catch quando houver erro no try

            // Chamar o método para salvar o log
            GenerateLog::generateLog("error", "Usuário não editado, nenhum valor foi alterado.", ['id' => $data['id'], 'email' => $data['email'], 'username' => $data['username'], 'error' => $e->getMessage()]);

            return false;
        }
    }

   /**
     * Atualizar a senha de um usuário.
     *
     * Este método atualiza a senha de um usuário específico. Em caso de erro, um log é gerado.
     *
     * @param array $data Dados atualizados do usuário, incluindo `id` e `password`.
     * @return bool `true` se a atualização foi bem-sucedida ou `false` em caso de erro.
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
     * Deletar um usuário pelo ID.
     *
     * Este método remove um usuário específico da tabela `adms_users`. Em caso de erro, um log é gerado.
     *
     * @param int $id ID do usuário a ser deletado.
     * @return bool `true` se o usuário foi deletado com sucesso ou `false` em caso de erro.
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
