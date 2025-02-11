<?php

namespace App\adms\Controllers\login;

class Logout
{

    public function index(): void 
    {
        // Eliminar os valores da sessão
        unset($_SESSION['user_id'], $_SESSION['user_name'], $_SESSION['user_email'], $_SESSION['user_username']);

        // Criar a mensagem de sucesso
        $_SESSION['success'] = "Usuário deslogado com suscesso!";

        // Redirecionar o usuário para a pagina listar
        header("Location: {$_ENV['URL_ADM']}login");
    }

}