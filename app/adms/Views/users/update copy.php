<?php

use App\adms\Helpers\CSRFHelper;

// Exibe o título da página de edição de usuário
echo "<h3>Editar Usuário</h3>";

// Exibe links para listar usuários e visualizar o usuário atual
echo "<a href='{$_ENV['URL_ADM']}list-users'>Listar Usuários</a><br>";
echo "<a href='{$_ENV['URL_ADM']}view-user/" . ($this->data['form']['id'] ?? '') . "'>Visualizar</a><br><br>";

// Inclui o arquivo que exibe mensagens de sucesso e erro
include './app/adms/Views/partials/alerts.php';

?>

<!-- Formulário para editar as informações do usuário -->
<form action="" method="POST">

    <!-- Campo oculto para o token CSRF para proteger o formulário -->
    <input type="hidden" name="csrf_token" value="<?php echo CSRFHelper::generateCSRFToken('form_create_user'); ?>"><br><br>

    <!-- Campo oculto para o ID do usuário -->
    <input type="hidden" name="id" id="id" value="<?php echo $this->data['form']['id'] ?? ''; ?>">

    <!-- Campo para o nome do usuário -->
    <label for="name">Nome: </label>
    <input type="text" name="name" id="name" placeholder="Nome completo" value="<?php echo $this->data['form']['name'] ?? ''; ?>"><br><br>

    <!-- Campo para o e-mail do usuário -->
    <label for="email">Email: </label>
    <input type="email" name="email" id="email" placeholder="Digite o email" value="<?php echo $this->data['form']['email'] ?? ''; ?>"><br><br>

    <!-- Campo para o nome de usuário -->
    <label for="username">Usuário: </label>
    <input type="text" name="username" id="username" placeholder="Digite o usuário" value="<?php echo $this->data['form']['username'] ?? ''; ?>"><br><br>

    <!-- Botão para submeter o formulário -->
    <button type="submit">Editar</button>

</form>