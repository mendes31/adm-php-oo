<?php

use App\adms\Helpers\CSRFHelper;

// Gera o token CSRF para proteger o formulário de deleção
$csrf_token = CSRFHelper::generateCSRFToken('form_delete_user');

?>

<div class="container-fluid px-4">
    <div class="mb-1 hstack gap-2">
        <h2 class="mt-3">Usuários</h2>

        <ol class="breadcrumb  mb-3 ms-auto">
            <li class="breadcrumb-item"><a href="<?php echo $_ENV['URL_ADM']; ?>dashboard" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?php echo $_ENV['URL_ADM']; ?>list-users" class="text-decoration-none">Usuários</a></li>
            <li class="breadcrumb-item">Visualizar</li>
        </ol>
    </div>

    <div class="card mb-4 border-light shadow">
        <div class="card-header hstack gap-2">
            <span>
                Visulaizar
            </span>

            <span class="ms-auto d-sm-flex flex-row">
                <a href="<?php echo $_ENV['URL_ADM']; ?>list-users" class="btn btn-info btn-sm me-1 mb-1"><i class="fa-solid fa-list-ul"></i> Listar</a>

                <a href="<?php echo $_ENV['URL_ADM'] . 'update-user/' . ($this->data['user']['id'] ?? ''); ?>" class="btn btn-warning btn-sm me-1 mb-1"><i class="fa-regular fa-pen-to-square"></i> Editar</a>

                <a href="<?php echo $_ENV['URL_ADM'] . 'update-password-user/' . ($this->data['user']['id'] ?? ''); ?>" class="btn btn-warning btn-sm me-1 mb-1"><i class="fa-solid fa-key"></i> Editar Senha</a>

                <!-- Formulário para deletar usuário -->
                <form action="<?php echo $_ENV['URL_ADM']; ?>delete-user" method="POST">

                    <!-- Campo oculto para o token CSRF -->
                    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">

                    <!-- Campo oculto para o ID do usuário -->
                    <input type="hidden" name="id" id="id" value="<?php echo ($this->data['user']['id'] ?? ''); ?>">

                    <!-- Botão para submeter o formulário -->
                    <button type="submit" class="btn btn-danger btn-sm me-1 mb-1" onclick="return confirm('Tem certeza que deseja apagar este registro?')"><i class="fa-regular fa-trash-can"></i> Apagar</button>

                </form>

            </span>
        </div>


        <div class="card-body">
            <?php
            // Inclui o arquivo que exibe mensagens de sucesso e erro
            include './app/adms/Views/partials/alerts.php';

            // Verifica se há usuários no array
            if (isset($this->data['user'])) {

                // Extrai variáveis do array $this->data['user'] para fácil acesso
                extract($this->data['user']);
            ?>

                <dl class="row">
                    <dt class="col-sm-3">ID: </dt>
                    <dd class="col-sm-9"><?php echo $id; ?></dd>

                    <dt class="col-sm-3">Nome: </dt>
                    <dd class="col-sm-9"><?php echo $name; ?></dd>

                    <dt class="col-sm-3">Email: </dt>
                    <dd class="col-sm-9"><?php echo $email; ?></dd>

                    <dt class="col-sm-3">Usuário: </dt>
                    <dd class="col-sm-9"><?php echo $username; ?></dd>

                    <dt class="col-sm-3">Cadastrado: </dt>
                    <dd class="col-sm-9"><?php echo ($created_at ? date('d/m/Y H:i:s', strtotime($created_at)) : ""); ?></dd>

                    <dt class="col-sm-3">Aeditado: </dt>
                    <dd class="col-sm-9"><?php echo ($updated_at ? date('d/m/Y H:i:s', strtotime($updated_at)) : ""); ?></dd>
                </dl>


            <?php
            } else {
                // Acessa o ELSE quando o elemento não existir registros
                echo "<div class='alert alert-danger' role='alert'>Usuário não encontrado.</div>";
            }
            ?>
        </div>

    </div>

</div>