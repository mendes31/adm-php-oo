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
            <li class="breadcrumb-item">Usuários</li>
        </ol>

    </div>
    <div class="card mb-4 border-light shadow">
        <div class="card-header hstack gap-2">
            <span>
                Listar
            </span>

            <span class="ms-auto">
                <a href="<?php echo $_ENV['URL_ADM']; ?>create-user" class="btn btn-success btn-sm"><i class="fa-regular fa-square-plus"></i> Cadastrar</a>
            </span>
        </div>

        <div class="card-body">

            <?php
            // Inclui o arquivo que exibe mensagens de sucesso e erro
            include './app/adms/Views/partials/alerts.php';

            // Verifica se há usuários no array
            if ($this->data['users'] ?? false) {
            ?>

                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nome</th>
                            <th scope="col" class="d-none d-md-table-cell">E-mail</th>
                            <th scope="col" class="d-none d-md-table-cell">Usuário</th>
                            <th scope="col" class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        //Perceorre o array de usuários
                        foreach ($this->data['users'] as $user) {
                            // Extrai variáveis do array de usuário
                            extract($user);
                        ?>
                            <tr>
                                <th><?php echo $id; ?></th>
                                <td><?php echo $name; ?></td>
                                <td class="d-none d-md-table-cell"><?php echo $email; ?></td>
                                <td class="d-none d-md-table-cell"><?php echo $username ?></td>
                                <td class="d-md-flex flex-row justify-content-center">
                                    <a href='<?php echo "{$_ENV['URL_ADM']}view-user/$id"; ?>' class="btn btn-info btn-sm me-1 mb-1"><i class="fa-regular fa-eye"></i> Visualizar</a>

                                    <a href='<?php echo "{$_ENV['URL_ADM']}update-user/$id"; ?>' class="btn btn-warning btn-sm me-1 mb-1"><i class="fa-regular fa-pen-to-square"></i> Editar</a>

                                    <!-- Formulário para deletar usuário -->
                                    <form action="delete-user" method="POST">

                                        <!-- Campo oculto para o token CSRF -->
                                        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">

                                        <!-- Campo oculto para o ID do usuário -->
                                        <input type="hidden" name="id" id="id" value="<?php echo $id ?? ''; ?>">

                                        <!-- Botão para submeter o formulário -->
                                        <button type="submit" class="btn btn-danger btn-sm me-1 mb-1" onclick="return confirm('Tem certeza que deseja apagar este registro?')"><i class="fa-regular fa-trash-can"></i> Apagar</button>

                                    </form>

                                </td>
                            </tr>

                        <?php
                        } ?>


                    </tbody>

                </table>

            <?php
                // Inclui o arquivo de paginação
                include_once './app/adms/Views/partials/pagination.php';
            } else {
                // Acessa o ELSE quando o elemento não existir registros
                echo "<div class='alert alert-danger' role='alert'>Nenhum usuário encontrado.</div>";
            } ?>

        </div>

    </div>
</div>