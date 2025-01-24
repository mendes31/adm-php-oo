<?php

namespace App\adms\Controllers\Services;

use App\adms\Helpers\ClearUrl;

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
       echo "Carregar a página.<br><br>";

       // Verificar se tem valor na variável url enviada pelo .htaccess
       if(!empty(filter_input(INPUT_GET, 'url', FILTER_DEFAULT))){

        // Recebe o valor da variável url
        $this->url = filter_input(INPUT_GET, 'url', FILTER_DEFAULT);

        echo "Acessar o endereço: <br>" . $this->url . "<br><br>";

        // Chamar um classe helper para limpar a URL
        $this->url = ClearUrl::clearUrl($this->url);
        var_dump($this->url);

        // Converter a string da URL em array
        $this->urlArray = explode("/", $this->url);
        var_dump($this->urlArray);

        // Verificar se existe a controller na URL
        if(isset($this->urlArray[0])){
            $this->urlController = $this->urlArray[0];
        }else{
            $this->urlController = "Login";
        }
        // Verificar se existe o parametro na URL
        if(isset($this->urlArray[1])){
            $this->urlParameter = $this->urlArray[1];
        }

       }else{
        $this->urlController = "Login";
       }
       var_dump($this->urlController);
       var_dump($this->urlParameter);
    }
}