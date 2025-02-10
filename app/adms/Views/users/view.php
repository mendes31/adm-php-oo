<?php

echo "<h3>Visualizar Usuário</h3>";

// Exibe links para listar usuários, editar o usuário e editar a senha do usuário
echo "<a href='{$_ENV['URL_ADM']}list-users'>Listar Usuários</a><br>";
echo "<a href='{$_ENV['URL_ADM']}update-user/". ($this->data['user']['id'] ?? '')."'>Editar</a><br>";
echo "<a href='{$_ENV['URL_ADM']}update-password-user/" . ($this->data['user']['id'] ?? '') . "'>Editar Senha</a><br><br>";

// Inclui o arquivo que exibe mensagens de sucesso e erro
include './app/adms/Views/partials/alerts.php';

// Verifica se o array de dados do usuário está presente
if(isset($this->data['user'])){
    
    // Extrai variáveis do array $this->data['user'] para fácil acesso
    extract($this->data['user']);

    // Exibe as informações do usuário
    echo "ID: $id<br>";
    echo "Nome: $name<br>";
    echo "Email: $email<br>";
    echo "Usuário: $username<br>";

    // Exibe as datas de criação e edição do usuário, formatadas, se disponíveis
    // Utiliza o operador ternário para verificar se as datas não são nulas antes de aplicar a formatação 
    echo "Cadastrado: " . ($created_at ? date('d/m/Y H:i:s', strtotime($created_at)) : "") ." <br>";
    echo "Editado: " . ($updated_at ? date('d/m/Y H:i:s', strtotime($updated_at)) : "") ." <br>";

}else{
    // Acessa o ELSE quando o elemento não existir registros
    echo "<p style='color: #f00;'>Usuário não encontrado.</p>";
}