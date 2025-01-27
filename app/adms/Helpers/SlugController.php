<?php

namespace App\adms\Helpers;

/**
 * Converter a controller enviada na URL para o formato da classe
 * 
 * @author Rafael Mendes <raffaell_mendez@hotmail.com>
 */
class SlugController
{
    /**
     * Método estático pode ser chamado diretamente na classe, sem a necessidade de criar uma instância (objeto) da classe.
     * Converter o valor obtido da URL, por exemplo "sobre-empresa", para o formato da classe "SobreEmpresa". 
     * Utilizado as funções para converter tudo para minpusculo, converter o traço pelo espaço, converter cada letra da primeira palavra para maiúsculo e remover os espaços em branço.
     * 
     * @param string $slugController Nome da classe
     * @return string Retorna a controller, por exemplo "sobre-empresa" convertido para o nome da Classe "SobreEmpresa"
     */
    public static function slugController(string $slugController) : string
    {
        // Converter para minusculo
        $slugController = strtolower($slugController);

        // Converter o traço para espaço em branço
        $slugController = str_replace("-"," ", $slugController);

        // COnverter a primeira letra de cada palavra para maiusculo
        $slugController = ucwords($slugController);

        // Retirar espaço em braco
        $slugController = str_replace(" ", "",  $slugController);

        // Retorna a controller convertida

        return  $slugController;
    }
}