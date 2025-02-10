<?php

use App\adms\Helpers\CSRFHelper;

// Exibe o título da página para edição da senha do usuário
echo "<h3>Editar a Senha do Usuário</h3>";

// Exibe links para listar usuários e visualizar o usuário específico
echo "<a href='{$_ENV['URL_ADM']}list-users'>Listar Usuários</a><br>";
echo "<a href='{$_ENV['URL_ADM']}view-user/". ($this->data['form']['id'] ?? '')."'>Visualizar</a><br><br>";

// Inclui o arquivo que exibe mensagens de sucesso e erro
include './app/adms/Views/partials/alerts.php';

?>

<!-- Formulário para editar a senha do usuário -->
<form action="" method="POST">
    <!-- Campo oculto para o token CSRF para proteger o formulário contra ataques de falsificação de solicitação entre sites -->
    <input type="hidden" name="csrf_token" value="<?php echo CSRFHelper::generateCSRFToken('form_update_password_user'); ?>"><br><br>
 
    <!-- Campo oculto para o ID do usuário que está editando a senha -->
    <input type="hidden" name="id" id="id" value="<?php echo $this->data['form']['id'] ?? ''; ?>">

    <!-- Campo para a nova senha do usuário -->
    <label for="password">Senha: </label>
    <input type="password" name="password" id="password" placeholder="Senha com mínimo 6 caracteres" value="<?php echo $this->data['form']['password'] ?? ''; ?>"><br><br>

    <!-- Campo para confirmar a nova senha -->
    <label for="confirm_password">Confirmar a Senha: </label>
    <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirmar a senha" value="<?php echo $this->data['form']['confirm_password'] ?? ''; ?>"><br><br>

    <!-- Botão para submeter o formulário e salvar a nova senha -->
    <button type="submit">Salvar</button>

</form>

