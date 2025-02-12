<?php

namespace App\adms\Models\Repository;

use App\adms\Helpers\GenerateLog;
use App\adms\Models\Services\DbConnection;
use Exception;
use PDO;


class ResetPasswordRepository extends DbConnection
{


    public function getUser(string $email)
    {
        // QUERY para recuperar o registro do baco de dados
        $sql = "SELECT id/*, recover_password, validate_recover_password*/ FROM adms_users WHERE email = :email";


        // Preparar a QUERY
        $stmt = $this->getConnection()->prepare($sql);

        // Substituir os links da QUERY pelo valor
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        // Executar a QUERY
        $stmt->execute();

        // Ler o registro e retornar
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateForgotPassword(array $data): bool
    {
        // Usar try e catch para gerenciar exceção/erro

        try { // Permanece no try se não houver nenhum erro

            // QUERY para atualizar o usuário
            $sql = 'UPDATE adms_users SET recover_password = :recover_password, validate_recover_password = :validate_recover_password,  updated_at = :updated_at';

            // Condição para indicar qual registro editar
            $sql .= ' WHERE email = :email LIMIT 1';

            // Preparar a QUERY
            $stmt = $this->getConnection()->prepare($sql);

            // Substituir os links da QUERY pelo valor
            $stmt->bindValue(':recover_password', $data['recover_password'], PDO::PARAM_STR);
            $stmt->bindValue(':validate_recover_password', date("Y-m-d H:i:s", strtotime('+1hour')));
            $stmt->bindValue(':updated_at', date("Y-m-d H:i:s"));
            $stmt->bindValue(':email', $data['email'], PDO::PARAM_STR);


            // Retornar TRUE quando conseguir executar a QUERY SQL, não considerando se alterou dados do registro
            return $stmt->execute();

        } catch (Exception $e) { // Acessa o catch quando houver erro no try

            // Chamar o método para salvar o log
            GenerateLog::generateLog("error", "Email para recuperar senha não encontrado.", ['email' => $data['email'], 'error' => $e->getMessage()]);

            return false;
        }
    }
}
