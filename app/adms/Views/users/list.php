<?php

use App\adms\Helpers\CSRFHelper;

echo "<h3>Listar Usuários</h3>";

echo "<a href='{$_ENV['URL_ADM']}create-user'>Cadastrar Usuários</a><br><br>";

// Apresentar mensagem de sucesso e erro
include './app/adms/Views/partials/alerts.php';

// // Destruir o que estiver dentro dessas sessões
// unset($_SESSION['success'], $_SESSION['error']);

// Acessa o IF quando encontrar o elemento no array users
if($this->data['users'] ?? false){

    // Gerar o  token CSRF
     $csrf_token = CSRFHelper::generateCSRFToken('form_delete_user');

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
        ?>
        
        <form action="delete-user" method="POST">
            
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">

        <input type="hidden" name="id" id="id" value="<?php echo $id ?? ''; ?>">

        <button type="submit">Apagar</button>

        </form>

        <?php

        echo "<hr>";

    }

    // Apresentar a paginação
    include_once './app/adms/Views/partials/pagination.php';

}else{
    // Acessa o ELSE quando o elemento não existir registros
    echo "<p style='color: #f00;'>Nenhum usuário encontrado.</p>";
}

// var_dump($this->data);