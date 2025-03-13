<?php

use App\adms\Helpers\CSRFHelper;

?>
<div class="container-fluid px-4">

    <div class="mb-1 hstack gap-2">
        <h2 class="mt-3">Contas à Pagar</h2>

        <ol class="breadcrumb mb-3 mt-3 ms-auto">
            <li class="breadcrumb-item">
                <a href="<?php echo $_ENV['URL_ADM']; ?>dashboard" class="text-decoration-none">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?php echo $_ENV['URL_ADM']; ?>list-payments" class="text-decoration-none">Conta à pagar</a>
            </li>
            <li class="breadcrumb-item">Cadastrar</li>

        </ol>

    </div>

    <div class="card mb-4 border-light shadow">

        <div class="card-header hstack gap-2">
            <span>Cadastrar</span>

            <span class="ms-auto d-sm-flex flex-row">
                <?php
                if (in_array('ListPayments', $this->data['buttonPermission'])) {
                    echo "<a href='{$_ENV['URL_ADM']}list-payments' class='btn btn-info btn-sm me-1 mb-1'><i class='fa-solid fa-list'></i> Listar</a> ";
                }
                ?>
            </span>

        </div>

        <div class="card-body">

            <?php include './app/adms/Views/partials/alerts.php'; ?>

            <!-- Formulário para cadastrar uma nova Conta à Pagar -->
            <form action="" method="POST" class="row g-3">

                <input type="hidden" name="csrf_token" value="<?php echo CSRFHelper::generateCSRFToken('form_create_pay'); ?>">

                <div class="col-4">
                    <label for="num_doc" class="form-label">Nº Documento</label>
                    <input type="text" name="num_doc" class="form-control" id="num_doc" placeholder="Nº Documento" value="<?php echo $this->data['form']['num_doc'] ?? ''; ?>">
                </div>

                <div class="col-4">
                    <label for="partner_id" class="form-label">Fornecedor</label>
                    <input type="text" name="partner_id" class="form-control" id="partner_id" placeholder="Fornecedor" value="<?php echo $this->data['form']['partner_id'] ?? ''; ?>">
                </div>

                <div class="col-4">
                    <label for="value" class="form-label">Valor</label>
                    <input type="text" name="value" class="form-control" id="value" placeholder="Descrição da conta" value="<?php echo $this->data['form']['value'] ?? ''; ?>">
                </div>

                <div class="col-4">
                    <label for="due_date" class="form-label">Vencimento</label>
                    <input type="date" name="due_date" class="form-control" id="due_date" placeholder="Fornecedor" value="<?php echo $this->data['form']['due_date'] ?? ''; ?>">
                </div>

                <div class="col-4">
                    <label for="expected_date" class="form-label">Previsão Pagamento</label>
                    <input type="date" name="expected_date" class="form-control" id="expected_date" placeholder="Fornecedor" value="<?php echo $this->data['form']['expected_date'] ?? ''; ?>">
                </div>

                <div class="col-4">
                    <label for="frequency_id" class="form-label">Frequência</label>
                    <input type="text" name="frequency_id" class="form-control" id="frequency_id" placeholder="Frequencia" value="<?php echo $this->data['form']['frequency_id'] ?? ''; ?>">
                </div>

                <div class="col-4">
                    <label for="account_id" class="form-label">Plano de Contas</label>
                    <input type="text" name="account_id" class="form-control" id="account_id" placeholder="Frequencia" value="<?php echo $this->data['form']['account_id'] ?? ''; ?>">
                </div>

                <div class="col-4">
                    <label for="cost_center_id" class="form-label">Centro de Custo</label>
                    <input type="text" name="cost_center_id" class="form-control" id="cost_center_id" placeholder="Frequencia" value="<?php echo $this->data['form']['cost_center_id'] ?? ''; ?>">
                </div>

                <div class="col-4">
                    <label for="bank_id" class="form-label">Banco - Saida</label>
                    <input type="text" name="bank_id" class="form-control" id="bank_id" placeholder="Selecione o local da saída" value="<?php echo $this->data['form']['bank_id'] ?? ''; ?>">
                </div>

                <div class="col-4">
                    <label for="description" class="form-label">Descrição - Observações</label>
                    <input type="text" name="description" class="form-control" id="description" placeholder="Observações" value="<?php echo $this->data['form']['description'] ?? ''; ?>">
                </div>

                

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Foto</label>
                            <input type="file" name="file" onChange="carregarImg();" id="arquivo">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div id="divImg">
                            <img src="images/contas/sem-foto.png" width="100px" id="target">
                        </div>
                    </div>

                

                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-sm">Cadastrar</button>
                </div>

            </form>

        </div>
        <!-- <?php echo var_dump($this->data['form']); ?> -->
    </div>

</div>