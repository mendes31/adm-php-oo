<?php

namespace App\adms\Views\Services;

/**
 * Carregar as páginas da View
 * 
 * @author Rafael Mendes <raffaell_mendez@hotmail.com>
 */
class LoadViewService
{
     /** @var string $view Recebe o endereço da VIEW */
    private string $view;

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
        //Definir o caminho da VIEW
        $this->view = './app/' . $this->nameView . '.php';

        if (file_exists($this->view)) {

            // Incluir o layout
            include'./app/adms/Views/layouts/main.php';
        } else {
            die("Erro 005: Por favor tente novamente. Caso o problema persista, entre em contato com o adminstrador {$_ENV['EMAIL_ADM']}");
        }
    }
}
