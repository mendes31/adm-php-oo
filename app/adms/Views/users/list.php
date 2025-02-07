<?php

echo "<h3>Listar Usuários</h3>";

echo "<a href='{$_ENV['URL_ADM']}create-user'>Cadastrar Usuários</a><br><br>";

// Apresentar mensagem de sucesso e erro
include './app/adms/Views/partials/alerts.php';

// Destruir o que estiver dentro dessas sessões
unset($_SESSION['success'], $_SESSION['error']);

// Acessa o IF quando encontrar o elemento no array users
if(isset($this->data['users'])){

    //Perceorre o array de usuários
    foreach($this->data['users'] as $user){

        // Extrair o array para imprimir o elemento do array através do nome
        extract($user);

        // Imprimir as informações do registro
        echo "ID: $id<br>";
        echo "Nome: $name<br>";
        echo "Email: $email<br><br>";
        // echo "Usuário: $username<br>";
        echo "<a href='{$_ENV['URL_ADM']}view-user/$id'>Visualizar</a><br>";
        echo "<a href='{$_ENV['URL_ADM']}update-user/$id'>Editar</a><br>";

        echo "<hr>";


        // echo "ID: " . $user['id'] . "<br>";
        // echo "Nome: " . $user['name'] . "<br>";
        // echo "Email: " . $user['email'] . "<br>";
        // echo "Usuário: " . $user['username'] . "<br>";
    }
}else{
    // Acessa o ELSE quando o elemento não existir registros
    echo "<p style='color: #f00;'>Nenhum usuário encontrado.</p>";
}

// var_dump($this->data);