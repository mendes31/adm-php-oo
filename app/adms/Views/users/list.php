<?php

echo "<h3>Listar Usuários</h3>";



// Acessa o IF quando encontrar o elemento no array users
if($this->data['users']){
    foreach($this->data['users'] as $user){

        // Extrair o array para imprimir o elemento do array através do nome
        extract($user);

        // Imprimir as informações do registro
        echo "ID: $id<br>";
        echo "Nome: $name<br>";
        echo "Email: $email<br>";
        // echo "Usuário: $username<br>";
        echo "<a href='{$_ENV['URL_ADM']}view-user/$id'>Visualizar</a>";

        echo "<hr>";


        // echo "ID: " . $user['id'] . "<br>";
        // echo "Nome: " . $user['name'] . "<br>";
        // echo "Email: " . $user['email'] . "<br>";
        // echo "Usuário: " . $user['username'] . "<br>";
    }
}else{
    echo "<p style='color: #f00;'>Nenhum usuário encontrado.</p>";
}

// var_dump($this->data);