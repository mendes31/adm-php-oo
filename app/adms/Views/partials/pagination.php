<?php

// var_dump($this->data['pagination']);

if (($this->data['pagination']['last_page'] ?? false) and ($this->data['pagination']['last_page'] != 1)) {

    

    if($this->data['pagination']['current_page'] > 1){

        echo "<a href='" . $_ENV['URL_ADM'] . ($this->data['pagination']['url_controller'] ?? '') . "/1'>Primeira</a> ";

        $beforePage = $this->data['pagination']['current_page'] - 1;

        echo "<a href='" . $_ENV['URL_ADM'] . ($this->data['pagination']['url_controller'] ?? '') . "/" . $beforePage . "'>$beforePage</a> ";
    }

    echo "<a href='#'>" . ($this->data['pagination']['current_page'] ?? 1) . "</a> ";

    if($this->data['pagination']['current_page'] < $this->data['pagination']['last_page']){

        
        $afterPage = $this->data['pagination']['current_page'] + 1;

        echo "<a href='" . $_ENV['URL_ADM'] . ($this->data['pagination']['url_controller'] ?? '') . "/" . $afterPage . "'>$afterPage</a> ";

        echo "<a href='" . $_ENV['URL_ADM'] . ($this->data['pagination']['url_controller'] ?? '') . "/" .($this->data['pagination']['last_page'] ?? ''). "'> Última</a> ";
    }

    
}
