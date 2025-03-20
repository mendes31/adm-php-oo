<?php

use App\adms\Helpers\CSRFHelper;

// Gera o token CSRF para proteger o formulário de deleção
$csrf_token = CSRFHelper::generateCSRFToken('form_delete_pay');

?>

<div class="container-fluid px-4">

    <div class="mb-1 hstack gap-2">
        <h2 class="mt-3">Contas à Pagar</h2>

        <ol class="breadcrumb mb-3 mt-3 ms-auto">
            <li class="breadcrumb-item">
                <a href="<?php echo $_ENV['URL_ADM']; ?>dashboard" class="text-decoration-none">Dashboard</a>
            </li>
            <li class="breadcrumb-item">Contas à Pagar</li>

        </ol>

    </div>

    <div class="card mb-4 border-light shadow">

        <div class="card-header hstack gap-2">
            <span>Listar</span>

            <span class="ms-auto">
            <?php
                if (in_array('CreatePay', $this->data['buttonPermission'])) {
                    echo "<a href='{$_ENV['URL_ADM']}create-pay' class='btn btn-success btn-sm'><i class='fa-regular fa-square-plus'></i> Cadastrar</a> ";
                }
                ?>
            </span>
        </div>

        <div class="card-body">

            <?php // Inclui o arquivo que exibe mensagens de sucesso e erro
            include './app/adms/Views/partials/alerts.php';

            // Verifica se há departamento no array
            if ($this->data['payments'] ?? false) {
            ?>

                <table class="table table-striped table-hover" id="tabela">
                    <thead>
                        <tr>
                            <th scope="col">Documento</th>
                            <th scope="col">Descrição</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Valor</th>
                            <th scope="col">Vencimento</th>
                            <th scope="col">Frequencia</th>
                            <th scope="col">Saída</th>
                            <th scope="col">Arquivo</th>
                            <th scope="col" class="text-center">Ações</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php
                        // Percorre o array de cargo
                        foreach ($this->data['payments'] as $pay) {

                            // Extrai variáveis do array de cargos
                            extract($pay); ?>
                            <tr>
                                <td><?php echo $num_doc; ?></td>                                
                                <td><?php echo $description; ?></td>
                                <td><?php echo $card_name; ?></td>
                                <td><?php echo $value; ?></td>
                                <td><?php echo $due_date; ?></td>
                                <td><?php echo $name_freq; ?></td>
                                <td><?php echo $bank_name; ?></td>
                                <td><?php echo $file; ?></td>
                                
                                <td class="text-center">

                                    <?php

                                    if (in_array('ViewPay', $this->data['buttonPermission'])) {
                                        echo "<a href='{$_ENV['URL_ADM']}view-pay/$id_pay' class='btn btn-primary btn-sm me-1 mb-1'><i class='fa-regular fa-eye'></i> Visualizar</a>";
                                    }

                                    if (in_array('UpdatePay', $this->data['buttonPermission'])) {
                                        echo "<a href='{$_ENV['URL_ADM']}update-pay/$id_pay' class='btn btn-warning btn-sm me-1 mb-1'><i class='fa-solid fa-pen-to-square'></i> Editar</a>";
                                    }

                                    if (in_array('DeletePay', $this->data['buttonPermission'])) {
                                    ?>

                                        <form id="formDelete<?php echo $id_pay; ?>" action="<?php echo $_ENV['URL_ADM']; ?>delete-pay" method="POST" class="d-inline">

                                            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">

                                            <input type="hidden" name="id" id="id" value="<?php echo $id_pay ?? ''; ?>">

                                            <input type="hidden" name="num_doc" id="num_doc" value="<?php echo $num_doc ?? ''; ?>">

                                            <input type="hidden" name="partner_id" id="partner_id" value="<?php echo $partner_id ?? ''; ?>">

                                            <button type="submit" class="btn btn-danger btn-sm me-1 mb-1" onclick="confirmDeletion(event, <?php echo $id_pay; ?>)"><i class="fa-regular fa-trash-can"></i> Apagar</button>

                                        </form>
                                    <?php } ?>

                                </td>
                            </tr>

                        <?php } ?>

                    </tbody>
                </table>


            <?php
                // Inclui o arquivo de paginação
                include_once './app/adms/Views/partials/pagination.php';
            } else { // Exibe mensagem se nenhuma conta for encontrado
                echo "<div class='alert alert-danger' role='alert'>Nenhuma Conta encontrada!</div>";
            } ?>

        </div>

    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#tabela').DataTable({
            "language": {
                "decimal": ",",
                "thousands": ".",
                "sProcessing": "Processando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "Nenhum registro encontrado",
                "sEmptyTable": "Nenhum dado disponível na tabela",
                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                "sInfoFiltered": "(filtrado de _MAX_ registros no total)",
                "sSearch": "Buscar:",
                "oPaginate": {
                    "sFirst": "Primeiro",
                    "sPrevious": "Anterior",
                    "sNext": "Próximo",
                    "sLast": "Último"
                },
                "oAria": {
                    "sSortAscending": ": Ordenar colunas de forma ascendente",
                    "sSortDescending": ": Ordenar colunas de forma descendente"
                }
            }
        });
    });
</script>