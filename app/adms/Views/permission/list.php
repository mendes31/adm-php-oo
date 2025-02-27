<?php

use App\adms\Helpers\CSRFHelper;

// Gera o token CSRF para proteger o formulário de deleção
$csrf_token = CSRFHelper::generateCSRFToken('form_update_access_level_permissions');

?>

<div class="container-fluid px-4">

    <div class="mb-1 hstack gap-2">
        <h2 class="mt-3">Permissões</h2>

        <ol class="breadcrumb mb-3 mt-3 ms-auto">
            <li class="breadcrumb-item">
                <a href="<?php echo $_ENV['URL_ADM']; ?>dashboard" class="text-decoration-none">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?php echo $_ENV['URL_ADM']; ?>list-access-levels" class="text-decoration-none">Níveis de Acesso</a>
            </li>
            <li class="breadcrumb-item">Permissões</li>

        </ol>

    </div>

    <div class="card mb-4 border-light shadow">

        <div class="card-header hstack gap-2">
            <span><?php echo $this->data['accessLevel']['name'] ?? 'Listar'; ?></span>

            <span class="ms-auto">

            </span>
        </div>

        <div class="card-body">

            <?php // Inclui o arquivo que exibe mensagens de sucesso e erro
            include './app/adms/Views/partials/alerts.php';

            var_dump($this->data['accessLevelsPages']);

            var_dump($this->data['pages']);

            // Verifica se há páginas no array
            if ($this->data['pages'] ?? false) {
            ?>

                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Liberado</th>
                            <th scope="col">Página</th>
                            <th scope="col">Nome</th>
                            <th scope="col" class="d-none d-md-table-cell">Observação</th>
                            <th scope="col" class="d-none d-md-table-cell">Pública / Privada</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php
                        // Percorre o array de páginas
                        foreach ($this->data['pages'] as $page) {

                            // Extrai variáveis do array de página
                            extract($page); ?>
                            <tr>
                                <td>opção</td>
                                <td><?php echo $id; ?></td>
                                <td><?php echo $name; ?></td>
                                <td class="d-none d-md-table-cell"><?php echo $obs; ?></td>
                                <td class="d-none d-md-table-cell">
                                    <?php echo $public_page ? "<span class='badge text-bg-success'>Pública</span>" : "<span class='badge text-bg-danger'>Privada</span>";; ?>
                                </td>
                            </tr>

                        <?php } ?>

                    </tbody>
                </table>


            <?php
            } else { // Exibe mensagem se nenhuma página for encontrada
                echo "<div class='alert alert-danger' role='alert'>Nenhuma página encontrada!</div>";
            } ?>

        </div>

    </div>
</div>