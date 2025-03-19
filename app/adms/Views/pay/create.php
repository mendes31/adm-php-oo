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

                <!-- <div class="col-4">
                    <label for="partner_id" class="form-label">Fornecedor</label>
                    <input type="text" name="partner_id" class="form-control" id="partner_id" placeholder="Fornecedor" value="<?php echo $this->data['form']['partner_id'] ?? ''; ?>">
                </div> -->

                <div class="col-md-4">
                    <label for="partner_id" class="form-label">Fornecedor</label>
                    <select name="partner_id" class="form-select" id="partner_id">
                        <option value="" selected>Selecione</option>
                        <?php
                        // Verificar se existe fornecedor
                        if ($this->data['listSuppliers'] ?? false) {
                            // percorrer o array de fornecedor
                            foreach ($this->data['listSuppliers'] as $listSupplier) {
                                // Extrari as variáveis do array
                                extract($listSupplier);
                                // Verificar se deve manter selecionado a opção
                                $selected = isset($this->data['form']['id']) && $this->data['form']['id'] == $id ? 'selected' : '';
                                echo "<option value='$id' $selected >$card_name</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="col-4">
                    <label for="value" class="form-label">Valor</label>
                    <input type="text" name="value" class="form-control" id="value" placeholder="Valor" value="<?php echo $this->data['form']['value'] ?? ''; ?>">
                </div>

                <div class="col-3">
                    <label for="due_date" class="form-label">Vencimento</label>
                    <input type="date" name="due_date" class="form-control" id="due_date" placeholder="Fornecedor" value="<?php echo $this->data['form']['due_date'] ?? ''; ?>">
                </div>

                <div class="col-3">
                    <label for="expected_date" class="form-label">Previsão Pagamento</label>
                    <input type="date" name="expected_date" class="form-control" id="expected_date" placeholder="Fornecedor" value="<?php echo $this->data['form']['expected_date'] ?? ''; ?>">
                </div>

                <!-- <div class="col-4">
                    <label for="frequency_id" class="form-label">Frequência</label>
                    <input type="text" name="frequency_id" class="form-control" id="frequency_id" placeholder="Frequencia" value="<?php echo $this->data['form']['frequency_id'] ?? ''; ?>">
                </div> -->

                <div class="col-md-3">
                    <label for="frequency_id" class="form-label">Frequência</label>
                    <select name="frequency_id" class="form-select" id="frequency_id">
                        <option value="" selected>Selecione</option>
                        <?php
                        // Verificar se existe frequencias
                        if ($this->data['listFrequencies'] ?? false) {
                            // percorrer o array de frequencias
                            foreach ($this->data['listFrequencies'] as $listFrequency) {
                                // Extrari as variáveis do array
                                extract($listFrequency);
                                // Verificar se deve manter selecionado a opção
                                $selected = isset($this->data['form']['id']) && $this->data['form']['id'] == $id ? 'selected' : '';
                                echo "<option value='$id' $selected >$name</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="col-3">
                    <label for="pay_method_id" class="form-label">Forma de Pagamento</label>
                    <input type="text" name="pay_method_id" class="form-control" id="pay_method_id" placeholder="Forma de Pagamento" value="<?php echo $this->data['form']['pay_method_id'] ?? ''; ?>">
                </div>


                <!-- <div class="col-4">
                    <label for="account_id" class="form-label">Plano de Contas</label>
                    <input type="text" name="account_id" class="form-control" id="account_id" placeholder="Frequencia" value="<?php echo $this->data['form']['account_id'] ?? ''; ?>">
                </div> -->

                <div class="col-md-4">
                    <label for="account_id" class="form-label">Plano de Contas</label>
                    <select name="account_id" class="form-select" id="account_id">
                        <option value="" selected>Selecione</option>
                        <?php
                        // Verificar se existe plano de contas
                        if ($this->data['listAccountsPlan'] ?? false) {
                            // percorrer o array de plano de contas
                            foreach ($this->data['listAccountsPlan'] as $listAccountPlan) {
                                // Extrari as variáveis do array
                                extract($listAccountPlan);
                                // Verificar se deve manter selecionado a opção
                                $selected = isset($this->data['form']['id']) && $this->data['form']['id'] == $id ? 'selected' : '';
                                echo "<option value='$id' $selected >$name</option>";
                            }
                        }
                        ?>
                    </select>
                </div>


                <!-- <div class="col-4">
                    <label for="cost_center_id" class="form-label">Centro de Custo</label>
                    <input type="text" name="cost_center_id" class="form-control" id="cost_center_id" placeholder="Frequencia" value="<?php echo $this->data['form']['cost_center_id'] ?? ''; ?>">
                </div> -->

                <div class="col-md-4">
                    <label for="cost_center_id" class="form-label">Centro de Custo</label>
                    <select name="cost_center_id" class="form-select" id="cost_center_id">
                        <option value="" selected>Selecione</option>
                        <?php
                        // Verificar se existe centros de custo
                        if ($this->data['listCostCenters'] ?? false) {
                            // percorrer o array de centros de custo
                            foreach ($this->data['listCostCenters'] as $listCostCenter) {
                                // Extrari as variáveis do array
                                extract($listCostCenter);
                                // Verificar se deve manter selecionado a opção
                                $selected = isset($this->data['form']['id']) && $this->data['form']['id'] == $id ? 'selected' : '';
                                echo "<option value='$id' $selected >$name</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <!-- <div class="col-4">
                    <label for="bank_id" class="form-label">Banco - Saida</label>
                    <input type="text" name="bank_id" class="form-control" id="bank_id" placeholder="Selecione o local da saída" value="<?php echo $this->data['form']['bank_id'] ?? ''; ?>">
                </div> -->

                <div class="col-md-4">
                    <label for="bank_id" class="form-label">Banco Saída</label>
                    <select name="bank_id" class="form-select" id="bank_id">
                        <option value="" selected>Selecione</option>
                        <?php
                        // Verificar se existe banco
                        if ($this->data['listBanks'] ?? false) {
                            // percorrer o array de banco
                            foreach ($this->data['listBanks'] as $listBank) {
                                // Extrari as variáveis do array
                                extract($listBank);
                                // Verificar se deve manter selecionado a opção
                                $selected = isset($this->data['form']['id']) && $this->data['form']['id'] == $id ? 'selected' : '';
                                echo "<option value='$id' $selected >$bank_name</option>";
                            }
                        }
                        ?>
                    </select>
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
                        <img src="<?php echo $_ENV['URL_ADM'] ?>public/adms/image/contas/sem-foto.png" width="100px" id="target">
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


<script type="text/javascript">
    //script para atualizar imagem do arquivo
    function carregarImg() {
        var target = document.getElementById('target');
        var file = document.querySelector("#arquivo").files[0];

        var arquivo = file['name'];
        resultado = arquivo.split(".", 2);

        // <?php echo $_ENV['URL_ADM'] ?>public/adms/image/contas/sem-foto.png

        if (resultado[1] === 'pdf') {
            $('#target').attr('src', "<?php echo $_ENV['URL_ADM'] ?>public/adms/image/contas/pdf.png");
            return;
        }

        if (resultado[1] === 'rar' || resultado[1] === 'zip') {
            $('#target').attr('src', "<?php echo $_ENV['URL_ADM'] ?>public/adms/image/contas/rar.png");
            return;
        }

        if (resultado[1] === 'doc' || resultado[1] === 'docx' || resultado[1] === 'txt') {
            $('#target').attr('src', "<?php echo $_ENV['URL_ADM'] ?>public/adms/image/contas/word.png");
            return;
        }

        if (resultado[1] === 'xlsx' || resultado[1] === 'xlsm' || resultado[1] === 'xls') {
            $('#target').attr('src', "<?php echo $_ENV['URL_ADM'] ?>public/adms/image/contas/excel.png");
            return;
        }

        if (resultado[1] === 'xml') {
            $('#target').attr('src', "<?php echo $_ENV['URL_ADM'] ?>public/adms/image/contas/xml.png");
            return;
        }

        var reader = new FileReader();

        reader.onloadend = function() {
            target.src = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);

        } else {
            target.src = "";
        }
    }
</script>