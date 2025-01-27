<?php

namespace App\adms\Models\Services;

use App\adms\Helpers\GenerateLog;
use PDO;
use PDOException;

/**
 * COnexão com o banco de dados
 * 
 * @author Rafael Mendes <raffaell_mendez@hotmail.com>
 */
abstract class DbConnection
{
    /** @var object $connect Recebe a conexão com o banco de dados */
    private object $connect;

    /**
     * Realiza a conexão com o banco de dados.
     * Não realizando a conexão corretamente, para o processamento da pagina e apresenta a mensagem de erro, com o e-mail de contato do adminstrador.
     * @return object retorna a conexão com o banco de dados.
     */
    public function getConnection(): object
    {
        try {

            // Conexão com a porta
            // $this->connect = new PDO("mysql:host={$_ENV['DB_HOST']};port={$_ENV['DB_PORT']};dbname=" . $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASS']);

            // Conexão sem a porta
            $this->connect = new PDO("mysql:host={$_ENV['DB_HOST']};dbname=" . $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASS']);

            // echo "Conexão realizada com sucesso!<br>";

            return $this->connect;
        } catch (PDOException $err) {
            // Chamar o método para salvar log
            GenerateLog::generateLog("alert", "Conexão com o Banco de Dados não realizada.", ['error' =>  $err->getMessage()]);

            die("Erro 001: Por favor tente novamente. Caso o problema persista, entre em contato com o adminstrador {$_ENV['EMAIL_ADM']}");
        }
    }
}
