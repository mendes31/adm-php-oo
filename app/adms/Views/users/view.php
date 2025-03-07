<?php

use App\adms\Helpers\CSRFHelper;

// Gera o token CSRF para proteger o formulário de deleção
$csrf_token = CSRFHelper::generateCSRFToken('form_delete_user');
$csrf_token_update_access_level = CSRFHelper::generateCSRFToken('form_update_access_level');

?>

<div class="container-fluid px-4">
    <div class="mb-1 d-flex flex-column flex-sm-row gap-2">
        <h2 class="mt-3">Usuários</h2>

        <ol class="breadcrumb  mb-3 mt-0 mt-sm-3 ms-auto">
            <li class="breadcrumb-item"><a href="<?php echo $_ENV['URL_ADM']; ?>dashboard" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?php echo $_ENV['URL_ADM']; ?>list-users" class="text-decoration-none">Usuários</a></li>
            <li class="breadcrumb-item">Visualizar</li>
        </ol>
    </div>

    <div class="card mb-4 border-light shadow">
        <div class="card-header d-flex flex-column flex-sm-row gap-2">
            <span>
                Visulaizar
            </span>

            <span class="ms-sm-auto d-sm-flex flex-row">

                <?php
                if (in_array('ListUsers', $this->data['buttonPermission'])) {
                    echo "<a href='{$_ENV['URL_ADM']}list-users' class='btn btn-info btn-sm me-1 mb-1'><i class='fa-solid fa-list-ul'></i> Listar</a> ";
                }

                $id = ($this->data['user']['id'] ?? '');
                if (in_array('UpdateUser', $this->data['buttonPermission'])) {
                    echo "<a href='{$_ENV['URL_ADM']}update-user/$id' class='btn btn-warning btn-sm me-1 mb-1'><i class='fa-regular fa-pen-to-square'></i> Editar</a> ";
                }

                if (in_array('UpdatePasswordUser', $this->data['buttonPermission'])) {
                    echo "<a href='{$_ENV['URL_ADM']}update-password-user/$id' class='btn btn-warning btn-sm me-1 mb-1'><i class='fa-solid fa-key'></i> Editar Senha</a> ";
                }

                if (in_array('DeleteUser', $this->data['buttonPermission'])) {
                ?>
                    <!-- Formulário para deletar usuário -->
                    <form id="formDelete<?php echo ($this->data['user']['id'] ?? ''); ?>" action="<?php echo $_ENV['URL_ADM']; ?>delete-user" method="POST">

                        <!-- Campo oculto para o token CSRF -->
                        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">

                        <!-- Campo oculto para o ID do usuário -->
                        <input type="hidden" name="id" id="id" value="<?php echo ($this->data['user']['id'] ?? ''); ?>">

                        <!-- Botão para submeter o formulário -->
                        <button type="submit" class="btn btn-danger btn-sm me-1 mb-1" onclick="confirmDeletion(event, <?php echo ($this->data['user']['id'] ?? ''); ?>)"><i class="fa-regular fa-trash-can"></i> Apagar</button>

                    </form>
                <?php } ?>
                </form>

            </span>
        </div>


        <div class="card-body">
            <?php
            // Inclui o arquivo que exibe mensagens de sucesso e erro
            include './app/adms/Views/partials/alerts.php';

            // Verifica se há usuários no array
            if ($this->data['user'] ?? false) {

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

                    <dt class="col-sm-3">Departamento: </dt>
                    <dd class="col-sm-9"><?php echo $dep_name; ?></dd>

                    <dt class="col-sm-3">Usuário: </dt>
                    <dd class="col-sm-9"><?php echo $pos_name; ?></dd>

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

    <!-- <div class="card mb-4 border-light shadow">
        <div class="card-header d-flex flex-column flex-sm-row gap-2">
            <span>Departamento</span>

            <span class="ms-sm-auto d-sm-flex flex-row">


            </span>
        </div>


        <div class="card-body">
            <?php

            // Verifica se há niveis de acesso para o usuários no array
            if ($this->data['userDepartments'] ?? false) {

                echo "<dl class='row'>";
                echo "<dt class='col-sm-3'>Departamento: </dt>";
                echo "<dd class='col-sm-9'>";

                //Perceorre o array de usuários
                foreach ($this->data['userDepartments'] as $userDepartment) {
                    // Extrai variáveis do array de usuário
                    extract($userDepartment);
                    echo $name;
                }
                echo '</dd>';
                echo '</dl>';
            } else {
                // Acessa o ELSE quando o elemento não existir registros
                echo "<div class='alert alert-danger' role='alert'>Usuário não possui departamento vinculado.</div>";
            }        ?>
        </div>

    </div> -->

    <?php
    if (in_array('UpdateUserAccessLevels', $this->data['buttonPermission'])) { ?>


        <div class="card mb-4 border-light shadow">
            <div class="card-header d-flex flex-column flex-sm-row gap-2">
                <span>Permissões</span>

                <span class="ms-sm-auto d-sm-flex flex-row">


                </span>
            </div>


            <div class="card-body">
                <?php

                // // Verifica se há niveis de acesso para o usuários no array
                // if ($this->data['userAccessLevels'] ?? false) {

                //     echo "<dl class='row'>";
                //     echo "<dt class='col-sm-3'>Niveis de Acesso: </dt>";
                //     echo "<dd class='col-sm-9'>";

                //     //Perceorre o array de usuários
                //     foreach ($this->data['userAccessLevels'] as $userAccessLevel) {
                //         // Extrai variáveis do array de usuário
                //         extract($userAccessLevel);
                //         echo $name; 
                //     }
                //     echo '</dd>';
                //     echo '</dl>';
                // } else {
                //     // Acessa o ELSE quando o elemento não existir registros
                //     echo "<div class='alert alert-danger' role='alert'>Usuário não possui nivel de acesso.</div>";
                // }


                // Verifica se há niveis de acesso para o usuários no array

                if ($this->data['userAllAccessLevelsArray'] ?? false) { ?>

                    <dl class='row'>
                        <dt class='col-sm-3'>Niveis de Acesso: </dt>
                        <dd class='col-sm-9'></dd>
                    </dl>

                    <form action="<?php echo $_ENV['URL_ADM']; ?>update-user-access-levels" method="POST">

                        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token_update_access_level; ?>">

                        <input type="hidden" name="adms_user_id" value="<?php echo ($this->data['user']['id'] ?? ''); ?>">

                        <?php
                        //Perceorre o array de usuários
                        foreach ($this->data['userAllAccessLevelsArray'] as $userAllAccessLevelsArray) {
                            // Extrai variáveis do array de usuário
                            extract($userAllAccessLevelsArray);

                            // Verifica se o nível de acesso atual ($id) está no array de níveis de acesso do usuário
                            $userAccessLevels = $this->data['userAccessLevelsArray'] ? $this->data['userAccessLevelsArray'] : [];
                            $checked = in_array($id, $userAccessLevels) ? 'checked' : '';

                            echo "<div class='form-check form-switch'>";

                            echo "<input type='checkbox' name='userAccessLevelsArray[$id]' class='form-check-input' role='switch' id='userAccessLevelsArray$id' value='$id' $checked>";

                            echo "<label class='form-check-label' for='userAccessLevelsArray$id'>$name</label>";
                            echo "</div>";
                        } ?>

                        <div class="col-12">
                            <button type="submit" class="btn btn-warning btn-sm">Salvar</button>
                        </div>
                    </form>

                <?php
                    // var_dump($userAccessLevels);
                } else {
                    // Acessa o ELSE quando o elemento não existir registros
                    echo "<div class='alert alert-danger' role='alert'>Usuário não possui nivel de acesso.</div>";
                }
                ?>
            </div>

        </div>
    <?php } ?>

</div>