<?php

use App\adms\Helpers\CSRFHelper;

echo "<h3>Editar a Senha do Usuário</h3>";

echo "<a href='{$_ENV['URL_ADM']}list-users'>Listar Usuários</a><br>";
echo "<a href='{$_ENV['URL_ADM']}view-user/". ($this->data['form']['id'] ?? '')."'>Visualizar</a><br><br>";

// Apresentar mensagem de sucesso e erro
include './app/adms/Views/partials/alerts.php';



?>

<form action="" method="POST">
    <input type="hidden" name="csrf_token" value="<?php echo CSRFHelper::generateCSRFToken('form_update_password_user'); ?>"><br><br>
 
    <input type="hidden" name="id" id="id" value="<?php echo $this->data['form']['id'] ?? ''; ?>">

    <label for="password">Senha: </label>
    <input type="password" name="password" id="password" placeholder="Senha com mínimo 6 caracteres" value="<?php echo $this->data['form']['password'] ?? ''; ?>"><br><br>

    <label for="confirm_password">Confirmar a Senha: </label>
    <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirmar a senha" value="<?php echo $this->data['form']['confirm_password'] ?? ''; ?>"><br><br>

    <button type="submit">Salvar</button>

</form>

