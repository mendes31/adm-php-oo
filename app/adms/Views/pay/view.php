<?php

use App\adms\Helpers\CSRFHelper;

// Gera o token CSRF para proteger o formulário de deleção
$csrf_token = CSRFHelper::generateCSRFToken('form_delete_pay');

?>

<div class="container-fluid px-4">

    <div class="mb-1 d-flex flex-column flex-sm-row gap-2">
        <h2 class="mt-3">Conta</h2>

        <ol class="breadcrumb mb-3 mt-0 mt-sm-3 ms-auto">
            <li class="breadcrumb-item">
                <a href="<?php echo $_ENV['URL_ADM']; ?>dashboard" class="text-decoration-none">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?php echo $_ENV['URL_ADM']; ?>list-payments" class="text-decoration-none">Contas</a>
            </li>
            <li class="breadcrumb-item">Visualizar</li>

        </ol>

    </div>

    <div class="card mb-4 border-light shadow">

        <div class="card-header d-flex flex-column flex-sm-row gap-2">
            <span>Visualizar</span>

            <span class="ms-sm-auto d-sm-flex flex-row">
                <?php
                if (in_array('ListPayments', $this->data['buttonPermission'])) {
                    echo "<a href='{$_ENV['URL_ADM']}list-payments' class='btn btn-info btn-sm me-1 mb-1'><i class='fa-solid fa-list'></i> Listar</a> ";
                }

                $id = ($this->data['pay']['id_pay'] ?? '');

                if (in_array('UpdatePay', $this->data['buttonPermission'])) {
                    echo "<a href='{$_ENV['URL_ADM']}update-pay/$id' class='btn btn-warning btn-sm me-1 mb-1'><i class='fa-solid fa-pen-to-square'></i> Editar</a>";
                }
                if (in_array('DeletePay', $this->data['buttonPermission'])) {
                ?>

                    <!-- Formulário para deletar nível de acesso -->
                    <form id="formDelete<?php echo ($this->data['pay']['id_pay'] ?? ''); ?>" action="<?php echo $_ENV['URL_ADM']; ?>delete-pay" method="POST">

                        <!-- Campo oculto para o token CSRF -->
                        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">

                        <!-- Campo oculto para o ID da conta -->
                        <input type="hidden" name="id" id="id" value="<?php echo ($this->data['pay']['id_pay'] ?? ''); ?>">
                        <!-- Campo oculto para o num_doc da conta -->
                        <input type="hidden" name="num_doc" id="num_doc" value="<?php echo ($this->data['pay']['num_doc'] ?? ''); ?>">

                        <!-- Botão para submeter o formulário -->
                        <button type="submit" class="btn btn-danger btn-sm me-1 mb-1" onclick="confirmDeletion(event, <?php echo ($this->data['pay']['id_pay'] ?? ''); ?>)"><i class="fa-regular fa-trash-can"></i> Deletar</button>

                    </form>
                <?php } ?>
                </form>
            </span>
        </div>

        <div class="card-body">

            <?php // Inclui o arquivo que exibe mensagens de sucesso e erro
            include './app/adms/Views/partials/alerts.php';

            // Verifica se há usuários no array
            if (isset($this->data['pay'])) {

                // Extrai variáveis do array $this->data['pay'] para fácil acesso
                extract($this->data['pay']);
            ?>

            <?php
            // Verifica se há usuários no array
            if (isset($this->data['movementValues'])) {

                // Extrai variáveis do array $this->data['pay'] para fácil acesso
                extract($this->data['movementValues']);

                // Calcula a soma dos valores pagos
                $totalPago = 0;
                if (!empty($this->data['movementValues'])) {
                    foreach ($this->data['movementValues'] as $movementValue) {
                        $totalPago += $movementValue['movement_value'];
                    }
                }

                if($discount_value > 0){
                    $saldoPagar = $original_value - ($amount_paid + $discount_value);
                } else {
                    $saldoPagar = $original_value - $amount_paid;
                }
                
                if ($saldoPagar < 0) {
                    $saldoPagar = 0;
                }
            ?>

                    <dl class="row">

                        <!-- <td><?php echo $file; ?></td> -->

                        <dt class="col-sm-3">ID: </dt>
                        <dd class="col-sm-9"><?php echo $id_pay; ?></dd>

                        <!-- <dt class="col-sm-3">Data: </dt>
                        <dd class="col-sm-9"><?php echo date("d-m-Y", strtotime($doc_date)); ?></dd> -->

                        <dt class="col-sm-3">Nº Doc: </dt>
                        <dd class="col-sm-9"><?php echo $num_doc; ?></dd>

                        <dt class="col-sm-3">Descrição: </dt>
                        <dd class="col-sm-9"><?php echo $description; ?></dd>

                        <dt class="col-sm-3">Fornecedor: </dt>
                        <dd class="col-sm-9"><?php echo $card_name; ?></dd>

                        <dt class="col-sm-3">Valor Original: </dt>
                        <dd class="col-sm-9"><?php echo 'R$ ' . number_format($original_value ?? 0, 2, ',', '.'); ?></dd>

                        <dt class="col-sm-3">Valor Pago: </dt>
                        <dd class="col-sm-9"><?php echo 'R$ ' . number_format($amount_paid ?? 0, 2, ',', '.'); ?></dd>

                        <dt class="col-sm-3">Valor à Pagar: </dt>
                        <dd class="col-sm-9"><?php echo 'R$ ' . number_format($saldoPagar, 2, ',', '.'); ?></dd>

                        <dt class="col-sm-3">Vencimento: </dt>
                        <dd class="col-sm-9"><?php echo date("d-m-Y", strtotime($due_date)); ?></dd>

                        <dt class="col-sm-3">Previsão Pgto: </dt>
                        <dd class="col-sm-9"><?php echo !empty($expected_date) ? date("d-m-Y", strtotime($expected_date)) : 'N/A'; ?></dd>

                        <dt class="col-sm-3">Frequência: </dt>
                        <dd class="col-sm-9"><?php echo $name_freq; ?></dd>

                        <dt class="col-sm-3">Centro de Custo: </dt>
                        <dd class="col-sm-9"><?php echo $name_cc; ?></dd>

                        <dt class="col-sm-3">Plano de Contas: </dt>
                        <dd class="col-sm-9"><?php echo $name_aap; ?></dd>

                        <!-- <dt class="col-sm-3">Forma Pgto: </dt>
                        <dd class="col-sm-9"><?php echo $name_apm; ?></dd> -->

                        <!-- <dt class="col-sm-3">Saída: </dt>
                        <dd class="col-sm-9"><?php echo $bank_name; ?></dd> -->

                        <dt class="col-sm-3">Usuário Lançamento: </dt>
                        <dd class="col-sm-9"><?php echo $name_user; ?></dd>

                        <!-- <dt class="col-sm-3">Usuário Pagamento: </dt>
                        <dd class="col-sm-9"><?php echo $user_pay; ?></dd> -->

                        <dt class="col-sm-3">Pago: </dt>
                        <dd class="col-sm-9"><?php echo (!empty($paid) && $paid != 0) ? "Sim" : "Não"; ?></dd>

                        <!-- <dt class="col-sm-3">Data Pgto: </dt>
                        <dd class="col-sm-9"><?php echo !empty($pay_date) ? date("d/m/Y H:i:s", strtotime($pay_date)) : "Data não informada"; ?></dd> -->

                        <dt class="col-sm-3">Cadastrado: </dt>
                        <dd class="col-sm-9"><?php echo ($created_at ? date('d/m/Y H:i:s', strtotime($created_at)) : ""); ?></dd>

                        <dt class="col-sm-3">Editado: </dt>
                        <dd class="col-sm-9"><?php echo ($updated_at ? date('d/m/Y H:i:s', strtotime($updated_at)) : ""); ?></dd>
                    </dl>
                <?php } ?>
        </div>



        <div class="card-body">
            <div class="card mb-4 border-light shadow">
                <div class="card-header d-flex flex-column flex-sm-row gap-2">
                    <span>Pagamentos Realizados</span>

                    <span class="ms-sm-auto d-sm-flex flex-row">



                        <span class="ms-auto">
                            <?php

                            // Exibe a soma formatada
                            echo "<span class='badge bg-primary ms-3'>Total Pago: R$ " . number_format($totalPago, 2, ',', '.') . "</span>";
                            ?>
                        </span>
                </div>


                <table class="table table-striped table-hover" id="tabela">
                    <thead>
                        <tr>
                            <th scope="col">Data PGTO</th>
                            <th scope="col">Nº Doc</th>
                            <th scope="col">Valor Pago</th>
                            <th scope="col" class="d-none d-md-table-cell">Forma PGTO</th>
                            <th scope="col" class="d-none d-md-table-cell">Local de Saída</th>
                            <th scope="col" class="d-none d-md-table-cell">Usuário PGTO</th>
                            <th scope="col" class="d-none d-md-table-cell">Tipo</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php
                        // Percorre o array de pagamentos
                        foreach ($this->data['movementValues'] as $movementValues) {
                            extract($movementValues); ?>

                            <tr>
                                <td><?php echo date("d-m-Y H:i:s", strtotime($created_at)); ?></td>
                                <td><?php echo $id_mov; ?></td>
                                <td><?php echo 'R$ ' . number_format($movement_value, 2, ',', '.'); ?></td>
                                <td class="d-none d-md-table-cell"><?php echo $name_method; ?></td>
                                <td class="d-none d-md-table-cell"><?php echo $name_bank; ?></td>
                                <td class="d-none d-md-table-cell"><?php echo $name_user; ?></td>
                                <td class="d-none d-md-table-cell"><?php echo $type; ?></td>
                            </tr>

                        <?php } ?>

                    </tbody>
                </table>

            <?php
                // Inclui o arquivo de paginação
                include_once './app/adms/Views/partials/pagination.php';
            } else {
                echo "<div class='alert alert-danger' role='alert'>Nenhuma Conta encontrada!</div>";
            } ?>

            </div>
        </div>
    </div>

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
            },
            "columnDefs": [{
                "className": "text-start",
                "targets": "_all"
            }]
        });
    });
</script>

<!-- <script>
    window.addEventListener('beforeunload', function () {
        navigator.sendBeacon("<?php echo $_ENV['URL_ADM']; ?>clear-busy-pay/<?php echo $this->data['pay']['id_pay']; ?>");
    });
</script> -->
