<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-five" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">

                <?php
                if(in_array('Dashboard', $this->data['menuPermission'])){
                    $active = (($this->data['menu'] ?? false) and ($this->data['menu'] == 'dashboard')) ? 'active' : '';
                    echo "<a href='{$_ENV['URL_ADM']}dashboard' class='nav-link $active'>";
                    
                    echo "<div class='sb-nav-link-icon'><i class='fas fa-tachometer-alt'></i></div>Dashboard";
                    
                    echo "</a>";
                }
                if(in_array('ListUsers', $this->data['menuPermission'])){
                    $active = (($this->data['menu'] ?? false) and ($this->data['menu'] == 'list-users')) ? 'active' : '';
                    echo "<a href='{$_ENV['URL_ADM']}list-users' class='nav-link $active'>";
                    
                    echo "<div class='sb-nav-link-icon'><i class='fa-solid fa-users'></i></div>Usuários";
                    
                    echo "</a>";
                }

                if(in_array('ListDepartments', $this->data['menuPermission'])){
                    $active = (($this->data['menu'] ?? false) and ($this->data['menu'] == 'list-departments')) ? 'active' : '';
                    echo "<a href='{$_ENV['URL_ADM']}list-departments' class='nav-link $active'>";
                    
                    echo "<div class='sb-nav-link-icon'><i class='fa-solid fa-building-user'></i></div>Departamentos";
                    
                    echo "</a>";
                }

                if(in_array('ListPositions', $this->data['menuPermission'])){
                    $active = (($this->data['menu'] ?? false) and ($this->data['menu'] == 'list-positions')) ? 'active' : '';
                    echo "<a href='{$_ENV['URL_ADM']}list-positions' class='nav-link $active'>";
                    
                    echo "<div class='sb-nav-link-icon'><i class='fa-solid fa-briefcase'></i></div>Cargos";
                    
                    echo "</a>";
                }

                if(in_array('ListAccessLevels', $this->data['menuPermission'])){
                    $active = (($this->data['menu'] ?? false) and ($this->data['menu'] == 'list-access-levels')) ? 'active' : '';
                    echo "<a href='{$_ENV['URL_ADM']}list-access-levels' class='nav-link $active'>";
                    
                    echo "<div class='sb-nav-link-icon'><i class='fa-solid fa-network-wired'></i></div>Niveis de Acesso";
                    
                    echo "</a>";
                }

                if(in_array('ListPackages', $this->data['menuPermission'])){
                    $active = (($this->data['menu'] ?? false) and ($this->data['menu'] == 'list-packages')) ? 'active' : '';
                    echo "<a href='{$_ENV['URL_ADM']}list-packages' class='nav-link $active'>";
                    
                    echo "<div class='sb-nav-link-icon'><i class='fa-solid fa-cubes'></i></div>Pacotes";
                    
                    echo "</a>";
                }

                if(in_array('ListGroupsPages', $this->data['menuPermission'])){
                    $active = (($this->data['menu'] ?? false) and ($this->data['menu'] == 'list-groups-pages')) ? 'active' : '';
                    echo "<a href='{$_ENV['URL_ADM']}list-groups-pages' class='nav-link $active'>";
                    
                    echo "<div class='sb-nav-link-icon'><i class='fa-solid fa-layer-group'></i></div>Grupos";
                    
                    echo "</a>";
                }

                if(in_array('ListPages', $this->data['menuPermission'])){
                    $active = (($this->data['menu'] ?? false) and ($this->data['menu'] == 'list-pages')) ? 'active' : '';
                    echo "<a href='{$_ENV['URL_ADM']}list-pages' class='nav-link $active'>";
                    
                    echo "<div class='sb-nav-link-icon'><i class='fa-regular fa-file'></i></div>Páginas";
                    
                    echo "</a>";
                }
                ?>

                <!-- <a class="nav-link <?php echo (($this->data['menu'] ?? false) and ($this->data['menu'] == 'dashboard')) ? 'active' : '' ?>" href="<?php echo $_ENV['URL_ADM']; ?>dashboard">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a> -->

                <!-- <a class="nav-link <?php echo (($this->data['menu'] ?? false) and ($this->data['menu'] == 'list-users')) ? 'active' : '' ?>" href="<?php echo $_ENV['URL_ADM']; ?>list-users">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>
                    Usuários
                </a> -->

                <!-- <a class="nav-link <?php echo (($this->data['menu'] ?? false) and ($this->data['menu'] == 'list-departments')) ? 'active' : '' ?>" href="<?php echo $_ENV['URL_ADM']; ?>list-departments">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-building-user"></i></div>
                    Departamentos
                </a> -->

                <!-- <a class="nav-link <?php echo (($this->data['menu'] ?? false) and ($this->data['menu'] == 'list-positions')) ? 'active' : '' ?>" href="<?php echo $_ENV['URL_ADM']; ?>list-positions">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-briefcase"></i></div>
                    Cargos
                </a> -->

                <!-- <a class="nav-link <?php echo (($this->data['menu'] ?? false) and ($this->data['menu'] == 'list-access-levels')) ? 'active' : '' ?>" href="<?php echo $_ENV['URL_ADM']; ?>list-access-levels">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-network-wired"></i></div>
                    Niveis de Acesso
                </a> -->

                <!-- <a class="nav-link <?php echo (($this->data['menu'] ?? false) and ($this->data['menu'] == 'list-packages')) ? 'active' : '' ?>" href="<?php echo $_ENV['URL_ADM']; ?>list-packages">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-cubes"></i></i></div>
                    Pacotes
                </a> -->

                <!-- <a class="nav-link <?php echo (($this->data['menu'] ?? false) and ($this->data['menu'] == 'list-groups-pages')) ? 'active' : '' ?>" href="<?php echo $_ENV['URL_ADM']; ?>list-groups-pages">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-layer-group"></i></div>
                    Grupos
                </a> -->

                <!-- <a class="nav-link <?php echo (($this->data['menu'] ?? false) and ($this->data['menu'] == 'list-pages')) ? 'active' : '' ?>" href="<?php echo $_ENV['URL_ADM']; ?>list-pages">
                    <div class="sb-nav-link-icon"><i class="fa-regular fa-file"></i></div>
                    Páginas
                </a> -->

                <a class="nav-link" href="<?php echo $_ENV['URL_ADM']; ?>logout">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-arrow-right-from-bracket"></i></div>
                    Sair
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logado:</div>
            <?php echo ($_SESSION['user_name'] ?? ''); ?><br>
            <?php echo ($_SESSION['user_department'] ?? ''); ?><br>
            <?php echo ($_SESSION['user_position'] ?? ''); ?>
        </div>
    </nav>
</div>