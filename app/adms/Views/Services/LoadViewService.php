<?php

namespace App\adms\Views\Services;

/**
 * Carregar as páginas da View
 * 
 * @author Rafael Mendes <raffaell_mendez@hotmail.com>
 */
class LoadViewService
{
    /**
     * REceber o endereço da VIEW e os dados.
     * @param string $nameView Endereço da VIEW que deve ser carregada
     * @param array|string|null $data Dados que a VIEW deve receber
     */
    public function __construct(private string $nameView, private array|string|null $data) {}

    /**
     * Carregar a VIEW.
     * Verificar se o arquivo existe, e carregar caso exista, não existindo parar o carregamento
     * 
     * @return void 
     */
    public function loadView(): void
    {
        if (file_exists('./app/' . $this->nameView . '.php')) {
            include './app/' . $this->nameView . '.php';
        } else {
            die("Erro 005: Por favor tente novamente. Caso o problema persista, entre em contato com o adminstrador {$_ENV['EMAIL_ADM']}");
        }
    }
}
