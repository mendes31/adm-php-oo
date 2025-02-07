<?php

use App\adms\Helpers\CSRFHelper;

echo "<h3>Editar Usuário</h3>";

echo "<a href='{$_ENV['URL_ADM']}list-users'>Listar Usuários</a><br>";

echo "<a href='{$_ENV['URL_ADM']}view-user/". ($this->data['form']['id'] ?? '')."'>Visualizar</a><br><br>";

// Apresentar mensagem de sucesso e erro
include './app/adms/Views/partials/alerts.php';



?>

<form action="" method="POST">
    <input type="hidden" name="csrf_token" value="<?php echo CSRFHelper::generateCSRFToken('form_create_user'); ?>"><br><br>
 
    <input type="hidden" name="id" id="id" value="<?php echo $this->data['form']['id'] ?? ''; ?>">

    <label for="name">Nome: </label>
    <input type="text" name="name" id="name" placeholder="Nome completo" value="<?php echo $this->data['form']['name'] ?? ''; ?>"><br><br>

    <label for="email">Email: </label>
    <input type="email" name="email" id="email" placeholder="Digite o email" value="<?php echo $this->data['form']['email'] ?? ''; ?>"><br><br>

    <label for="username">Usuário: </label>
    <input type="text" name="username" id="username" placeholder="Digite o usuário" value="<?php echo $this->data['form']['username'] ?? ''; ?>"><br><br>
    

    <button type="submit">Editar</button>

</form>

