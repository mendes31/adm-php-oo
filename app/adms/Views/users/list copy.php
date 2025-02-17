<?php

use App\adms\Helpers\CSRFHelper;

// Exibe o título da página
echo "<h3>Listar Usuários</h3>";

// Exibe link para criar um novo usuário
echo "<a href='{$_ENV['URL_ADM']}create-user'>Cadastrar Usuários</a><br><br>";

// Inclui o arquivo que exibe mensagens de sucesso e erro
include './app/adms/Views/partials/alerts.php';

// Verifica se há usuários no array
if ($this->data['users'] ?? false) {

    // Gera o token CSRF para proteger o formulário de deleção
    $csrf_token = CSRFHelper::generateCSRFToken('form_delete_user');

    //Perceorre o array de usuários
    foreach ($this->data['users'] as $user) {

        // Extrai variáveis do array de usuário
        extract($user);

        // Exibe as informações do usuário
        echo "ID: $id<br>";
        echo "Nome: $name<br>";
        echo "Email: $email<br><br>";
        // echo "Usuário: $username<br>";

        // Exibe links para visualizar, editar e editar senha do usuário
        echo "<a href='{$_ENV['URL_ADM']}view-user/$id'>Visualizar</a><br>";
        echo "<a href='{$_ENV['URL_ADM']}update-user/$id'>Editar</a><br>";
?>
        <!-- Formulário para deletar usuário -->
        <form action="delete-user" method="POST">

            <!-- Campo oculto para o token CSRF -->
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">

            <!-- Campo oculto para o ID do usuário -->
            <input type="hidden" name="id" id="id" value="<?php echo $id ?? ''; ?>">

            <!-- Botão para submeter o formulário -->
            <button type="submit" onclick="return confirm('Tem certeza que deseja apagar este registro?')">Apagar</button>

        </form>

<?php

        // Exibe uma linha horizontal para separar os registros
        echo "<hr>";
    }

    // Inclui o arquivo de paginação
    include_once './app/adms/Views/partials/pagination.php';
} else {
    // Acessa o ELSE quando o elemento não existir registros
    echo "<p style='color: #f00;'>Nenhum usuário encontrado.</p>";
}
