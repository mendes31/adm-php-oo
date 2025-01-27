<?php

namespace App\adms\Controllers\Services;

use App\adms\Helpers\ClearUrl;
use App\adms\Helpers\SlugController;

/**
 * Recebe a URL e manipula
 * 
 * @author Rafael Mendes <raffaell_mendez@hotmail.com>
 */
class PageController
{
    /** @var string $url Receber a URL do .htaccess */
    private string $url;

    /** @var array $urlArray Recebe a URL convertida para um array */
    private array $urlArray;

    /** @var string $urlController Recebe da URL o nome da controller */
    private string $urlController = "";

     /** @var string $urlParameter Recebe da URL o parametro */
    private string $urlParameter = "";


    /**
     * Recebe a URL do .htaccess
     */

    public function __construct()
    {
   
       // Verificar se tem valor na variável url enviada pelo .htaccess
       if(!empty(filter_input(INPUT_GET, 'url', FILTER_DEFAULT))){

        // Recebe o valor da variável url
        $this->url = filter_input(INPUT_GET, 'url', FILTER_DEFAULT);

    

        // Chamar um classe helper para limpar a URL
        $this->url = ClearUrl::clearUrl($this->url);
        // var_dump($this->url);

        // Converter a string da URL em array
        $this->urlArray = explode("/", $this->url);
        // var_dump($this->urlArray);

        // Verificar se existe a controller na URL
        if(isset($this->urlArray[0])){
            // Chamar uma classe helper para converter a controller enviada na URL para o formato da classe

            $this->urlController = SlugController::slugController($this->urlArray[0]);
        }else{
            $this->urlController = SlugController::slugController("Login");
        }
        // Verificar se existe o parametro na URL
        if(isset($this->urlArray[1])){
            $this->urlParameter = $this->urlArray[1];
        }

       }else{
        $this->urlController = SlugController::slugController("Login");
       }
    //    var_dump($this->urlController);
    //    var_dump($this->urlParameter);
    }

    /**
     * Carregar página/controller 
     * Instanciar a classe para validar e carregar pagina/controller 
     *
     * @return void
     */
    public function loadPage(): void
    {        
        // Instanciar a classe para validar e carrega a pagina/controller
        $loadPageAdm = new LoadPageAdm();

        // Chamar o método e enviar como paametro a controller e o parametro da URL
        $loadPageAdm->loadPageAdm($this->urlController, $this->urlParameter);

    }
}