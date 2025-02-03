<?php

use App\adms\Helpers\CSRFHelper;

echo "<h3>Cadastrar Usuário</h3>";

echo "<a href='{$_ENV['URL_ADM']}list-users'>Listar Usuários</a><br>";

// Usar operador ternário para verificar se existe a mensagem de sucesso e erro
echo isset($_SESSION['success']) ? "<p style='color: #086;'>{$_SESSION['success']}</p>" : "";

echo isset($_SESSION['error']) ? "<p style='color: #f00;'>{$_SESSION['error']}</p>" : "";

?>

<form action="" method="POST">
    <input type="hidden" name="csrf_token" value="<?php echo CSRFHelper::generateCSRFToken('form_create_user'); ?>"><br><br>

    <label for="name">Nome: </label>
    <input type="text" name="name" id="name" placeholder="Nome completo"><br><br>

    <label for="email">Email: </label>
    <input type="email" name="email" id="email" placeholder="Digite o email"><br><br>

    <label for="username">Usuário: </label>
    <input type="text" name="username" id="username" placeholder="Digite o usuário"><br><br>

    <label for="password">Senha: </label>
    <input type="password" name="password" id="password" placeholder="Senha minímo 6 caracteres"><br><br>

    <button type="submit">Cadastrar</button>

</form>

