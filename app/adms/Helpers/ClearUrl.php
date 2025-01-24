<?php

namespace App\adms\Helpers;

/**
 * Limpar URL
 * @author Rafael Mendes <raffaell_mendez@hotmail.com>
 */
class ClearUrl
{
    /**
     * O método estático pode ser chamado diretamente na classe, sem a necessidade de criar uma instância (objeto) da classe.
     * Limpará a URL, eliminando as TAG, os espaços em branco, retirar a barra no final da URLe retirar os caracteres especiais.
     * 
     * @return string
     */
    
     public static function clearUrl(string $url): string
     {
 
         // Eliminar a barra no final da URL
         $url = rtrim($url, "/");
 
         // Arrays de caracteres não aceitos
         $unaccepted_characters = [
             'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'ü', 'Ý', 'Þ', 'ß',
             'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ý', 'ý', 'þ', 'ÿ', 
             '"', "'", '!', '@', '#', '$', '%', '&', '*', '(', ')', '_', '+', '=', '{', '[', '}', ']', '?', ';', ':', '.', ',', '\\', '\'', '<', '>', '°', 'º', 'ª', ' '
         ];
 
         // Arrays de caracteres aceitos
         $accepted_characters = [
             'a', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'd', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'u', 'y', 'b', 's',
             'a', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'd', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'y', 'y', 'y', 'y',
             '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''
         ];
 
         // Substituir os caracteres não aceitos pelos caracteres aceitos
         return str_replace(mb_convert_encoding($unaccepted_characters, 'ISO-8859-1', 'UTF-8'), $accepted_characters, mb_convert_encoding($url, 'ISO-8859-1', 'UTF-8'));
         
     }
 
 }