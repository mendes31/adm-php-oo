<?php

//carregr o composer 

use App\adms\Controllers\Services\PageController;

require './vendor/autoload.php';

//Instanciar a classe PageController, responsável em tratar a URL
$url = new PageController();