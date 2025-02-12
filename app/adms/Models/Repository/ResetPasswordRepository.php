<?php

namespace App\adms\Models\Repository;

use App\adms\Models\Services\DbConnection;
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
}
