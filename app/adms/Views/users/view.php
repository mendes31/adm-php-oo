<?php

echo "<h3>Visualizar Usuário</h3>";

echo "<a href='{$_ENV['URL_ADM']}list-users'>Listar Usuários</a><br><br>";

// Acessa o IF quando encontrar o elemento no array user
if(isset($this->data['user'])){
    
    // Extrair o array para imprimir o elemento do array através do nome
    extract($this->data['user']);

    // Imprimir as informações do registro
    echo "ID: $id<br>";
    echo "Nome: $name<br>";
    echo "Email: $email<br>";
    echo "Usuário: $username<br>";

    // O operador ternário (?) verifica se $created_at não é null antes de chamar strtotime(). Se $created_at for null retorna uma string vazia. 
    echo "Cadastrado: " . ($created_at ? date('d/m/Y H:i:s', strtotime($created_at)) : "") ." <br>";
    echo "Editado: " . ($updated_at ? date('d/m/Y H:i:s', strtotime($updated_at)) : "") ." <br>";

    // var_dump($this->data['user']);

}else{
    // Acessa o ELSE quando o elemento não existir registros
    echo "<p style='color: #f00;'>Usuário não encontrado.</p>";
}