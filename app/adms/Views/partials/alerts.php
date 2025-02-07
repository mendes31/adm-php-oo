<?php

// Usar operador ternário para verificar se existe a mensagem de sucesso e erro
echo isset($_SESSION['success']) ? "<p style='color: #086;'>{$_SESSION['success']}</p>" : "";

echo isset($_SESSION['error']) ? "<p style='color: #f00;'>{$_SESSION['error']}</p>" : "";

// Destruir o que estiver dentro dessas sessões
unset($_SESSION['success'], $_SESSION['error']);

// Acessa o IF quando encontrar elementos no array errors
if(isset($this->data['errors'])){

    foreach($this->data['errors'] as $error){

        echo "<p style='color: #f00;'>$error</p>";
    }
}