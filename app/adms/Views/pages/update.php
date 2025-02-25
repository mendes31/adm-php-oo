<?php

use App\adms\Helpers\CSRFHelper;

?>

<div class="container-fluid px-4">

    <div class="mb-1 d-flex flex-column flex-sm-row gap-2">
        <h2 class="mt-3">Página</h2>

        <ol class="breadcrumb mb-3 mt-0 mt-sm-3 ms-auto">
            <li class="breadcrumb-item">
                <a href="<?php echo $_ENV['URL_ADM']; ?>dashboard" class="text-decoration-none">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?php echo $_ENV['URL_ADM']; ?>list-pages" class="text-decoration-none">Páginas</a>
            </li>
            <li class="breadcrumb-item">Editar</li>

        </ol>

    </div>

    <div class="card mb-4 border-light shadow">

        <div class="card-header hstack gap-2">

            <span>Editar</span>

            <span class="ms-auto d-sm-flex flex-row">
                <a href="<?php echo $_ENV['URL_ADM']; ?>list-pages" class="btn btn-info btn-sm me-1 mb-1"><i class="fa-solid fa-list"></i> Listar</a>

                <a href="<?php echo $_ENV['URL_ADM'] . 'view-page/' . ($this->data['form']['id'] ?? ''); ?>" class="btn btn-primary btn-sm me-1 mb-1"><i class="fa-regular fa-eye"></i> Visualizar</a>

            </span>

        </div>

        <div class="card-body">

            <?php include './app/adms/Views/partials/alerts.php'; ?>

            <form action="" method="POST" class="row g-3">

                <input type="hidden" name="csrf_token" value="<?php echo CSRFHelper::generateCSRFToken('form_update_page'); ?>">

                <input type="hidden" name="id" id="id" value="<?php echo $this->data['form']['id'] ?? ''; ?>">

                <div class="col-12">
                    <label for="name" class="form-label">Nome</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Nome da página" value="<?php echo $this->data['form']['name'] ?? ''; ?>">
                </div>

                <div class="col-md-6 col-sm-12">
                    <label for="controller" class="form-label">Controller</label>
                    <input type="text" name="controller" class="form-control" id="controller" placeholder="Nome do método ou controller" value="<?php echo $this->data['form']['controller'] ?? ''; ?>">
                </div>

                <div class="col-md-6 col-sm-12">
                    <label for="controller_url" class="form-label">URL</label>
                    <input type="text" name="controller_url" class="form-control" id="controller_url" placeholder="Nome do método ou controller na URL" value="<?php echo $this->data['form']['controller_url'] ?? ''; ?>">
                </div>

                <div class="col-12">
                    <label for="directory" class="form-label">Diretório</label>
                    <input type="text" name="directory" class="form-control" id="directory" placeholder="Nome do diretório da controller" value="<?php echo $this->data['form']['directory'] ?? ''; ?>">
                </div>

                <div class="col-12">
                    <label for="obs" class="form-label">Observação</label>
                    <textarea name="obs" class="form-control" id="obs" placeholder="Observação da página" rows="3"><?php echo $this->data['form']['obs'] ?? ''; ?></textarea>
                </div>

                <div class="col-md-6 col-sm-12">
                    <label for="page_status" class="form-label">Status</label>
                    <input type="text" name="page_status" class="form-control" id="page_status" placeholder="Página ativa 1 e página inativa 0" value="<?php echo $this->data['form']['page_status'] ?? ''; ?>">
                </div>

                <div class="col-md-6 col-sm-12">
                    <label for="public_page" class="form-label">Pública</label>
                    <input type="text" name="public_page" class="form-control" id="public_page" placeholder="Página publica 1 e página privada 0" value="<?php echo $this->data['form']['public_page'] ?? ''; ?>">
                </div>

                <div class="col-md-6 col-sm-12">
                    <label for="adms_packages_page_id" class="form-label">Pacote</label>
                    <input type="text" name="adms_packages_page_id" class="form-control" id="adms_packages_page_id" placeholder="Pacote que está a página" value="<?php echo $this->data['form']['adms_packages_page_id'] ?? ''; ?>">
                </div>

                <div class="col-md-6 col-sm-12">
                    <label for="adms_groups_page_id" class="form-label">Grupo</label>
                    <input type="text" name="adms_groups_page_id" class="form-control" id="adms_groups_page_id" placeholder="Grupo que a página pertence" value="<?php echo $this->data['form']['adms_groups_page_id'] ?? ''; ?>">
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-warning btn-sm">Salvar</button>
                </div>

            </form>

        </div>
    </div>

</div>