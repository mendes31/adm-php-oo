<?php

use App\adms\Helpers\CSRFHelper;

// Gera o token CSRF para proteger o formulário de deleção
$csrf_token = CSRFHelper::generateCSRFToken('form_delete_bank');

?>

<div class="container-fluid px-4">

    <div class="mb-1 hstack gap-2">
        <h2 class="mt-3">Bancos</h2>

        <ol class="breadcrumb mb-3 mt-3 ms-auto">
            <li class="breadcrumb-item">
                <a href="<?php echo $_ENV['URL_ADM']; ?>dashboard" class="text-decoration-none">Dashboard</a>
            </li>
            <li class="breadcrumb-item">Bancos</li>

        </ol>

    </div>

    <div class="card mb-4 border-light shadow">

        <div class="card-header hstack gap-2">
            <span>Listar</span>

            <span class="ms-auto">
            <?php
                if (in_array('CreateBank', $this->data['buttonPermission'])) {
                    echo "<a href='{$_ENV['URL_ADM']}create-bank' class='btn btn-success btn-sm'><i class='fa-regular fa-square-plus'></i> Cadastrar</a> ";
                }
                ?>
            </span>
        </div>

        <div class="card-body">

            <?php // Inclui o arquivo que exibe mensagens de sucesso e erro
            include './app/adms/Views/partials/alerts.php';

            // Verifica se há departamento no array
            if ($this->data['banks'] ?? false) {
            ?>

                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Banco</th>
                            <th scope="col">Conta</th>
                            <th scope="col">Agência</th>
                            <th scope="col" class="text-center">Ações</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php
                        // Percorre o array de cargo
                        foreach ($this->data['banks'] as $bank) {

                            // Extrai variáveis do array de cargos
                            extract($bank); ?>
                            <tr>
                                <td><?php echo $id; ?></td>
                                <td><?php echo $bank_name; ?></td>
                                <td><?php echo $bank; ?></td>
                                <td><?php echo $account; ?></td>
                                <td><?php echo $agency; ?></td>

                                <td class="d-md-flex flex-row justify-content-center">

                                    <a href='<?php echo "{$_ENV['URL_ADM']}view-bank/$id"; ?>' class="btn btn-primary btn-sm me-1 mb-1"><i class="fa-regular fa-eye"></i> Visualizar</a>

                                    <a href='<?php echo "{$_ENV['URL_ADM']}update-bank/$id"; ?>' class="btn btn-warning btn-sm me-1 mb-1"><i class="fa-solid fa-pen-to-square"></i> Editar</a>

                                    <form id="formDelete<?php echo $id; ?>" action="<?php echo $_ENV['URL_ADM']; ?>delete-bank" method="POST">

                                        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">

                                        <input type="hidden" name="id" id="id" value="<?php echo $id ?? ''; ?>">

                                        <input type="hidden" name="bank_name" id="bank_name" value="<?php echo $bank_name ?? ''; ?>">

                                        <button type="submit" class="btn btn-danger btn-sm me-1 mb-1" onclick="confirmDeletion(event, <?php echo $id; ?>)"><i class="fa-regular fa-trash-can"></i> Apagar</button>

                                    </form>

                                </td>
                            </tr>

                        <?php } ?>

                    </tbody>
                </table>


            <?php
                // Inclui o arquivo de paginação
                include_once './app/adms/Views/partials/pagination.php';
            } else { // Exibe mensagem se nenhum nível de acesso for encontrado
                echo "<div class='alert alert-danger' role='alert'>Nenhum cargo encontrado!</div>";
            } ?>

        </div>

    </div>
</div>