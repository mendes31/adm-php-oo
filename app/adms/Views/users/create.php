<?php

use App\adms\Helpers\CSRFHelper;

// Exibe o título da página de cadastro de usuário
echo "<h3>Cadastrar Usuário</h3>";

// Exibe um link para listar usuários
echo "<a href='{$_ENV['URL_ADM']}list-users'>Listar Usuários</a><br><br>";

// Inclui o arquivo que exibe mensagens de sucesso e erro
include './app/adms/Views/partials/alerts.php';

?>

<!-- Formulário para cadastrar um novo usuário -->
<form action="" method="POST">

    <!-- Campo oculto para o token CSRF para proteger o formulário contra ataques de falsificação de solicitação entre sites -->
    <input type="hidden" name="csrf_token" value="<?php echo CSRFHelper::generateCSRFToken('form_create_user'); ?>">

    <!-- Operador de coalescência nula em PHP (??) - Serve para fornecer um valor padrão se uma determinada chave não estiver presente ou for nula. -->
    <!-- Campo para o nome do usuário -->
    <label for="name">Nome: </label>
    <input type="text" name="name" id="name" placeholder="Nome completo" value="<?php echo $this->data['form']['name'] ?? ''; ?>"><br><br>

    <!-- Campo para o e-mail do usuário -->
    <label for="email">Email: </label>
    <input type="email" name="email" id="email" placeholder="Digite o email" value="<?php echo $this->data['form']['email'] ?? ''; ?>"><br><br>

    <!-- Campo para a senha do usuário -->
    <label for="username">Usuário: </label>
    <input type="text" name="username" id="username" placeholder="Digite o usuário" value="<?php echo $this->data['form']['username'] ?? ''; ?>"><br><br>

    <!-- Campo para a senha do usuário -->
    <label for="password">Senha: </label>
    <input type="password" name="password" id="password" placeholder="Senha minímo 6 caracteres" value="<?php echo $this->data['form']['password'] ?? ''; ?>"><br><br>

    <!-- Campo para confirmar a senha -->
    <label for="confirm_password">Confirmar Senha: </label>
    <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirmar a senha." value="<?php echo $this->data['form']['confirm_password'] ?? ''; ?>"><br><br>

    <!-- Botão para submeter o formulário -->
    <button type="submit">Cadastrar</button>

</form>

