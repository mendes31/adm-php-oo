<?php

namespace App\adms\Helpers;

/**
 * Gerar e validar CSRF
 * 
 * @author Rafael Mendes <raffaell_mendez@hotmail.com>
 */
class CSRFHelper
{
    /**
     * Gerar um token CSRF único
     * 
     * @param string $formIdentifier Identificador do formulário
     * @return string Token CSRF gerado.
     */
    public static function generateCSRFToken(string $formIdentifier): string
    {
        // A função random_bytes gera uma sequência de 32 bytes aleatórios.
        // A função bin2hex converte os bytes binários gerados pela random_bytes em uma representação hexadecimal.
        $token = bin2hex(random_bytes(32));

        // Salvar o TOKEN CSRF na sessão
        $_SESSION['csrf_tokens'][$formIdentifier] = $token;

        // Retornar o token gerado
        return $token;
    }

    /**
     * Validar um token CSRF.
     * 
     * @param string $formIdentfier Identificador do feormulário.
     * @param string $token TOken CSRF para validar
     * @return bool True se o token for válido, False caso contrário.
     */
     public static function validateCSRFToken(string $formIdentifier, string $token)
     {
        // Verificar se existe o csrf_token e se o valor que vem do formulário é igual ao csrf salvo na sessão.
        if(isset($_SESSION['csrf_tokens'][$formIdentifier]) && hash_equals($_SESSION['csrf_tokens'][$formIdentifier], $token)){

            // Token usado deve se rinvalidado.
            unset($_SESSION['csrf_tokens'][$formIdentifier]);

            return true;
        }
        return false;
     }

}