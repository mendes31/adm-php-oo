<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-five" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">

                <!-- Dashboard -->
                <?php if (in_array('Dashboard', $this->data['menuPermission'])): ?>
                    <a href="<?= $_ENV['URL_ADM'] ?>dashboard" class="nav-link <?= ($this->data['menu'] ?? false) == 'dashboard' ? 'active' : '' ?>">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div> Dashboard
                    </a>
                <?php endif; ?>

                <!-- Admininstracao -->
                <?php
                $submenuAdmininstracao = in_array($this->data['menu'], ['list-groups-pages', 'list-packages', 'list-pages']) ? 'show' : '';
                ?>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseAdmininstracao" aria-expanded="<?= $submenuAdmininstracao ? 'true' : 'false' ?>">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-gear"></i></div> Admininstracao
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?= $submenuAdmininstracao ?>" id="collapseAdmininstracao">
                    <nav class="sb-sidenav-menu-nested nav">

                        <?php if (in_array('ListGroupsPages', $this->data['menuPermission'])): ?>
                            <a href="<?= $_ENV['URL_ADM'] ?>list-groups-pages" class="nav-link <?= ($this->data['menu'] ?? false) == 'list-groups-pages' ? 'active' : '' ?>">Grupos de Páginas</a>
                        <?php endif; ?>

                        <?php if (in_array('ListPackages', $this->data['menuPermission'])): ?>
                            <a href="<?= $_ENV['URL_ADM'] ?>list-packages" class="nav-link <?= ($this->data['menu'] ?? false) == 'list-packages' ? 'active' : '' ?>">Pacotes</a>
                        <?php endif; ?>

                        <?php if (in_array('ListPages', $this->data['menuPermission'])): ?>
                            <a href="<?= $_ENV['URL_ADM'] ?>list-pages" class="nav-link <?= ($this->data['menu'] ?? false) == 'list-pages' ? 'active' : '' ?>">Páginas</a>
                        <?php endif; ?>

                    </nav>
                </div>

                <!-- Cadastro -->
                <?php
                $submenuCadastro = in_array($this->data['menu'], ['list-users', 'list-departments', 'list-positions', 'list-cost-centers', 'list-access-levels']) ? 'show' : '';
                ?>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseCadastro" aria-expanded="<?= $submenuCadastro ? 'true' : 'false' ?>">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-folder-plus"></i></div> Cadastro
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?= $submenuCadastro ?>" id="collapseCadastro">
                    <nav class="sb-sidenav-menu-nested nav">

                        <?php if (in_array('ListPositions', $this->data['menuPermission'])): ?>
                            <a href="<?= $_ENV['URL_ADM'] ?>list-positions" class="nav-link <?= ($this->data['menu'] ?? false) == 'list-positions' ? 'active' : '' ?>">Cargos</a>
                        <?php endif; ?>

                        <?php if (in_array('ListCostCenters', $this->data['menuPermission'])): ?>
                            <a href="<?= $_ENV['URL_ADM'] ?>list-cost-centers" class="nav-link <?= ($this->data['menu'] ?? false) == 'list-cost-centers' ? 'active' : '' ?>">Centros de Custo</a>
                        <?php endif; ?>

                        <?php if (in_array('ListDepartments', $this->data['menuPermission'])): ?>
                            <a href="<?= $_ENV['URL_ADM'] ?>list-departments" class="nav-link <?= ($this->data['menu'] ?? false) == 'list-departments' ? 'active' : '' ?>">Departamentos</a>
                        <?php endif; ?>

                        <?php if (in_array('ListAccessLevels', $this->data['menuPermission'])): ?>
                            <a href="<?= $_ENV['URL_ADM'] ?>list-access-levels" class="nav-link <?= ($this->data['menu'] ?? false) == 'list-access-levels' ? 'active' : '' ?>">Níveis de Acesso</a>
                        <?php endif; ?>

                        <?php if (in_array('ListUsers', $this->data['menuPermission'])): ?>
                            <a href="<?= $_ENV['URL_ADM'] ?>list-users" class="nav-link <?= ($this->data['menu'] ?? false) == 'list-users' ? 'active' : '' ?>">Usuários</a>
                        <?php endif; ?>
                    </nav>
                </div>

                <!-- Financeiro -->
                <?php
                $submenuFinanceiro = in_array($this->data['menu'], ['list-banks', 'list-frequencies', 'list-payments', 'list-accounts-plan', 'list-receive', 'list-balance',  'financial-report']) ? 'show' : '';
                ?>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseFinanceiro" aria-expanded="<?= $submenuFinanceiro ? 'true' : 'false' ?>">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-coins"></i></div> Financeiro
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?= $submenuFinanceiro ?>" id="collapseFinanceiro">
                    <nav class="sb-sidenav-menu-nested nav">

                        <?php if (in_array('ListBanks', $this->data['menuPermission'])): ?>
                            <a href="<?= $_ENV['URL_ADM'] ?>list-banks" class="nav-link <?= ($this->data['menu'] ?? false) == 'list-banks' ? 'active' : '' ?>">Bancos</a>
                        <?php endif; ?>

                        <?php if (in_array('ListFrequencies', $this->data['menuPermission'])): ?>
                            <a href="<?= $_ENV['URL_ADM'] ?>list-frequencies" class="nav-link <?= ($this->data['menu'] ?? false) == 'list-frequencies' ? 'active' : '' ?>">Frequências</a>
                        <?php endif; ?>


                        <?php if (in_array('ListPayments', $this->data['menuPermission'])): ?>
                            <a href="<?= $_ENV['URL_ADM'] ?>list-payments" class="nav-link <?= ($this->data['menu'] ?? false) == 'list-payments' ? 'active' : '' ?>">Pagar</a>
                        <?php endif; ?>

                        <?php if (in_array('ListAccountsPlan', $this->data['menuPermission'])): ?>
                            <a href="<?= $_ENV['URL_ADM'] ?>list-accounts-plan" class="nav-link <?= ($this->data['menu'] ?? false) == 'list-accounts-plan' ? 'active' : '' ?>">Plano de Contas</a>
                        <?php endif; ?>

                        <?php if (in_array('ListReceive', $this->data['menuPermission'])): ?>
                            <a href="<?= $_ENV['URL_ADM'] ?>list-receive" class="nav-link <?= ($this->data['menu'] ?? false) == 'list-receive' ? 'active' : '' ?>">Receber</a>
                        <?php endif; ?>

                        <?php if (in_array('ListBalance', $this->data['menuPermission'])): ?>
                            <a href="<?= $_ENV['URL_ADM'] ?>list-balance" class="nav-link <?= ($this->data['menu'] ?? false) == 'list-balance' ? 'active' : '' ?>">Rel Extrato Caixa</a>
                        <?php endif; ?>

                        <?php if (in_array('FinancialReport', $this->data['menuPermission'])): ?>
                            <a href="<?= $_ENV['URL_ADM'] ?>financial-report" class="nav-link <?= ($this->data['menu'] ?? false) == 'financial-report' ? 'active' : '' ?>">Relatório Fianceiro</a>
                        <?php endif; ?>

                    </nav>
                </div>


               <!-- Parceiros de Negócio -->
                <?php
                $submenuParceiros = in_array($this->data['menu'], ['list-customers', 'list-suppliers']) ? 'show' : '';
                ?>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseParceiros" aria-expanded="<?= $submenuParceiros ? 'true' : 'false' ?>">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-handshake-simple"></i></div> Parceiros
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?= $submenuParceiros ?>" id="collapseParceiros">
                    <nav class="sb-sidenav-menu-nested nav">

                        <?php if (in_array('ListCustomers', $this->data['menuPermission'])): ?>
                            <a href="<?= $_ENV['URL_ADM'] ?>list-customers" class="nav-link <?= ($this->data['menu'] ?? false) == 'list-customers' ? 'active' : '' ?>">Clientes</a>
                        <?php endif; ?>

                        <?php if (in_array('ListSuppliers', $this->data['menuPermission'])): ?>
                            <a href="<?= $_ENV['URL_ADM'] ?>list-suppliers" class="nav-link <?= ($this->data['menu'] ?? false) == 'list-suppliers' ? 'active' : '' ?>">Fornecedores</a>
                        <?php endif; ?>
                    </nav>
                </div>

               
                <!-- Logout -->
                <a href="<?= $_ENV['URL_ADM'] ?>logout" class="nav-link">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-arrow-right-from-bracket"></i></div> Sair
                </a>
            </div>
        </div>

        <!-- Rodapé com Informações do Usuário -->
        <div class="sb-sidenav-footer">
            <div class="small">Logado como:</div>
            <?= $_SESSION['user_name'] ?? '' ?><br>
            <?= $_SESSION['user_department'] ?? '' ?><br>
            <?= $_SESSION['user_position'] ?? '' ?>
        </div>
    </nav>
</div>