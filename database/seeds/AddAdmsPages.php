<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class AddAdmsPages extends AbstractSeed
{
    /**
     * Cadastra pagina na tabela `adms_pages` se ainda não existirem.
     *
     * Este método é executado para popular a tabela `adms_pages` com registros iniciais dos paginas.
     * Primeiro, verifica se já existe pagina na tabela com base no name. 
     * Se o pagina não existir, os dados são inseridos na tabela.
     * 
     * @return void
     */
    public function run(): void
    {

        // Variável para receber os dados a serem inseridos
        $data = [];

        // Variável para receber os dados que devem ser validados antes de cadastrar
        $pages = [
            ['name'=> 'Dashboard', 'controller' => 'Dashboard', 'controller_url' => 'dashboard', 'directory' => 'dashboard', 'obs' => 'Página inicial do administrativo.', 'public_page' => 0, 'page_status' => 1, 'adms_packages_page_id' => 1, 'adms_groups_page_id' => 1],

            ['name'=> 'Cadastrar Usuário', 'controller' => 'CreateUser', 'controller_url' => 'create-user', 'directory' => 'users', 'obs' => 'Página com o formulário cadastrar usuário.', 'public_page' => 0, 'page_status' => 1, 'adms_packages_page_id' => 1, 'adms_groups_page_id' => 2],
            ['name'=> 'Listar Usuários', 'controller' => 'ListUsers', 'controller_url' => 'list-users', 'directory' => 'users', 'obs' => 'Página para listar o usuários.', 'public_page' => 0, 'page_status' => 1, 'adms_packages_page_id' => 1, 'adms_groups_page_id' => 2],
            ['name'=> 'Visualizar Usuário', 'controller' => 'ViewUser', 'controller_url' => 'view-user', 'directory' => 'users', 'obs' => 'Página apresentar os detalhes do usuário.', 'public_page' => 0, 'page_status' => 1, 'adms_packages_page_id' => 1, 'adms_groups_page_id' => 2],
            ['name'=> 'Editar Usuário', 'controller' => 'UpdateUser', 'controller_url' => 'update-user', 'directory' => 'users', 'obs' => 'Página com o formulário editar usuário.', 'public_page' => 0, 'page_status' => 1, 'adms_packages_page_id' => 1, 'adms_groups_page_id' => 2],
            ['name'=> 'Editar Senha do Usuário', 'controller' => 'UpdatePasswordUser', 'controller_url' => 'update-password-user', 'directory' => 'users', 'obs' => 'Página com o formulário editar senha do usuário.', 'public_page' => 0, 'page_status' => 1, 'adms_packages_page_id' => 1, 'adms_groups_page_id' => 2],
            ['name'=> 'Apagar Usuário', 'controller' => 'DeleteUser', 'controller_url' => 'delete-user', 'directory' => 'users', 'obs' => 'Página para apagar o usuário do banco de dados.', 'public_page' => 0, 'page_status' => 1, 'adms_packages_page_id' => 1, 'adms_groups_page_id' => 2],

            ['name'=> 'Cadastrar Nível de Acesso', 'controller' => 'CreateAccessLevel', 'controller_url' => 'create-access-level', 'directory' => 'accessLevels', 'obs' => 'Página com o formulário cadastrar nível de acesso.', 'public_page' => 0, 'page_status' => 1, 'adms_packages_page_id' => 1, 'adms_groups_page_id' => 3],
            ['name'=> 'Listar Níveis de Acesso', 'controller' => 'ListAccessLevels', 'controller_url' => 'list-access-levels', 'directory' => 'accessLevels', 'obs' => 'Página para listar o níveis de acesso.', 'public_page' => 0, 'page_status' => 1, 'adms_packages_page_id' => 1, 'adms_groups_page_id' => 3],
            ['name'=> 'Visualizar Nível de Acesso', 'controller' => 'ViewAccessLevel', 'controller_url' => 'view-access-level', 'directory' => 'accessLevels', 'obs' => 'Página apresentar os detalhes do nível de acesso.', 'public_page' => 0, 'page_status' => 1, 'adms_packages_page_id' => 1, 'adms_groups_page_id' => 3],
            ['name'=> 'Editar Nível de Acesso', 'controller' => 'UpdateAccessLevel', 'controller_url' => 'update-access-level', 'directory' => 'accessLevels', 'obs' => 'Página com o formulário editar nível de acesso.', 'public_page' => 0, 'page_status' => 1, 'adms_packages_page_id' => 1, 'adms_groups_page_id' => 3],           
            ['name'=> 'Apagar Nível de Acesso', 'controller' => 'DeleteAccessLevel', 'controller_url' => 'delete-access-level', 'directory' => 'accessLevels', 'obs' => 'Página para apagar o nível de acesso do banco de dados.', 'public_page' => 0, 'page_status' => 1, 'adms_packages_page_id' => 1, 'adms_groups_page_id' => 3],

            ['name'=> 'Cadastrar Pacote', 'controller' => 'CreatePackage', 'controller_url' => 'create-package', 'directory' => 'packages', 'obs' => 'Página com o formulário cadastrar pacote.', 'public_page' => 0, 'page_status' => 1, 'adms_packages_page_id' => 1, 'adms_groups_page_id' => 4],
            ['name'=> 'Listar Pacotes', 'controller' => 'ListPackages', 'controller_url' => 'list-packages', 'directory' => 'packages', 'obs' => 'Página para listar o pacotes.', 'public_page' => 0, 'page_status' => 1, 'adms_packages_page_id' => 1, 'adms_groups_page_id' => 4],
            ['name'=> 'Visualizar Pacote', 'controller' => 'ViewPackage', 'controller_url' => 'view-package', 'directory' => 'packages', 'obs' => 'Página apresentar os detalhes do pacote.', 'public_page' => 0, 'page_status' => 1, 'adms_packages_page_id' => 1, 'adms_groups_page_id' => 4],
            ['name'=> 'Editar Pacote', 'controller' => 'UpdatePackage', 'controller_url' => 'update-package', 'directory' => 'packages', 'obs' => 'Página com o formulário editar pacote.', 'public_page' => 0, 'page_status' => 1, 'adms_packages_page_id' => 1, 'adms_groups_page_id' => 4],            
            ['name'=> 'Apagar Pacote', 'controller' => 'DeletePackage', 'controller_url' => 'delete-package', 'directory' => 'packages', 'obs' => 'Página para apagar o pacote do banco de dados.', 'public_page' => 0, 'page_status' => 1, 'adms_packages_page_id' => 1, 'adms_groups_page_id' => 4],

            ['name'=> 'Cadastrar Grupo de Página', 'controller' => 'CreateGroupPage', 'controller_url' => 'create-group-page', 'directory' => 'groupsPages', 'obs' => 'Página com o formulário cadastrar grupo de página.', 'public_page' => 0, 'page_status' => 1, 'adms_packages_page_id' => 1, 'adms_groups_page_id' => 5],
            ['name'=> 'Listar Grupos de Páginas', 'controller' => 'ListGroupsPages', 'controller_url' => 'list-groups-pages', 'directory' => 'groupsPages', 'obs' => 'Página para listar o grupos de páginas.', 'public_page' => 0, 'page_status' => 1, 'adms_packages_page_id' => 1, 'adms_groups_page_id' => 5],
            ['name'=> 'Visualizar Grupo de Página', 'controller' => 'ViewGroupPage', 'controller_url' => 'view-group-page', 'directory' => 'groupsPages', 'obs' => 'Página apresentar os detalhes do grupo de página.', 'public_page' => 0, 'page_status' => 1, 'adms_packages_page_id' => 1, 'adms_groups_page_id' => 5],
            ['name'=> 'Editar Grupo de Página', 'controller' => 'UpdateGroupPage', 'controller_url' => 'update-group-page', 'directory' => 'groupsPages', 'obs' => 'Página com o formulário editar grupo de página.', 'public_page' => 0, 'page_status' => 1, 'adms_packages_page_id' => 1, 'adms_groups_page_id' => 5],            
            ['name'=> 'Apagar Grupo de Página', 'controller' => 'DeleteGroupPage', 'controller_url' => 'delete-group-page', 'directory' => 'groupsPages', 'obs' => 'Página para apagar o grupo de página do banco de dados.', 'public_page' => 0, 'page_status' => 1, 'adms_packages_page_id' => 1, 'adms_groups_page_id' => 5],

            ['name'=> 'Cadastrar Página', 'controller' => 'CreatePage', 'controller_url' => 'create-page', 'directory' => 'pages', 'obs' => 'Página com o formulário cadastrar página.', 'public_page' => 0, 'page_status' => 1, 'adms_packages_page_id' => 1, 'adms_groups_page_id' => 6],
            ['name'=> 'Listar Páginas', 'controller' => 'ListPages', 'controller_url' => 'list-pages', 'directory' => 'pages', 'obs' => 'Página para listar o páginas.', 'public_page' => 0, 'page_status' => 1, 'adms_packages_page_id' => 1, 'adms_groups_page_id' => 6],
            ['name'=> 'Visualizar Página', 'controller' => 'ViewPage', 'controller_url' => 'view-group-page', 'directory' => 'pages', 'obs' => 'Página apresentar os detalhes do página.', 'public_page' => 0, 'page_status' => 1, 'adms_packages_page_id' => 1, 'adms_groups_page_id' => 6],
            ['name'=> 'Editar Página', 'controller' => 'UpdatePage', 'controller_url' => 'update-group-page', 'directory' => 'pages', 'obs' => 'Página com o formulário editar página.', 'public_page' => 0, 'page_status' => 1, 'adms_packages_page_id' => 1, 'adms_groups_page_id' => 6],            
            ['name'=> 'Apagar Página', 'controller' => 'DeletePage', 'controller_url' => 'delete-group-page', 'directory' => 'pages', 'obs' => 'Página para apagar o página do banco de dados.', 'public_page' => 0, 'page_status' => 1, 'adms_packages_page_id' => 1, 'adms_groups_page_id' => 6],

            ['name'=> 'Página de Login', 'controller' => 'Login', 'controller_url' => 'login', 'directory' => 'login', 'obs' => 'Página com o formulário de login.', 'public_page' => 1, 'page_status' => 1, 'adms_packages_page_id' => 1, 'adms_groups_page_id' => 7],
            ['name'=> 'Cadastrar Novo Usuário', 'controller' => 'NewUser', 'controller_url' => 'new-user', 'directory' => 'login', 'obs' => 'Página com o formulário novo usuário na página de login.', 'public_page' => 1, 'page_status' => 1, 'adms_packages_page_id' => 1, 'adms_groups_page_id' => 7],
            ['name'=> 'Recuperar Senha', 'controller' => 'ForgotPassword', 'controller_url' => 'forgot-password', 'directory' => 'login', 'obs' => 'Página com o formulário para recuperar a senha.', 'public_page' => 1, 'page_status' => 1, 'adms_packages_page_id' => 1, 'adms_groups_page_id' => 7],
            ['name'=> 'Cadastrar Nova Senha', 'controller' => 'ResetPassword', 'controller_url' => 'reset-password', 'directory' => 'login', 'obs' => 'Página com o formulário cadastrar nova senha no login.', 'public_page' => 1, 'page_status' => 1, 'adms_packages_page_id' => 1, 'adms_groups_page_id' => 7],
            ['name'=> 'Sair do Administrativo', 'controller' => 'Logout', 'controller_url' => 'logout', 'directory' => 'login', 'obs' => 'Deslogar do sistema administrativo.', 'public_page' => 1, 'page_status' => 1, 'adms_packages_page_id' => 1, 'adms_groups_page_id' => 7],
            
            ['name'=> 'Cadastrar Departamento', 'controller' => 'CreateDepartment', 'controller_url' => 'create-department', 'directory' => 'departments', 'obs' => 'Página com o formulário cadastrar Departamento.', 'public_page' => 0, 'page_status' => 1, 'adms_packages_page_id' => 1, 'adms_groups_page_id' => 8],
            ['name'=> 'Listar Departamentos', 'controller' => 'ListDepartments', 'controller_url' => 'list-departments', 'directory' => 'departments', 'obs' => 'Página para listar o Departamentos.', 'public_page' => 0, 'page_status' => 1, 'adms_packages_page_id' => 1, 'adms_groups_page_id' => 8],
            ['name'=> 'Visualizar Departamento', 'controller' => 'ViewDepartment', 'controller_url' => 'view-department', 'directory' => 'departments', 'obs' => 'Página apresentar os detalhes do Departamento.', 'public_page' => 0, 'page_status' => 1, 'adms_packages_page_id' => 1, 'adms_groups_page_id' => 8],
            ['name'=> 'Editar Departamento', 'controller' => 'UpdateDepartments', 'controller_url' => 'update-departments', 'directory' => 'departments', 'obs' => 'Página com o formulário editar Departamento.', 'public_page' => 0, 'page_status' => 1, 'adms_packages_page_id' => 1, 'adms_groups_page_id' => 8],           
            ['name'=> 'Apagar Departamento', 'controller' => 'DeleteDepartment', 'controller_url' => 'delete-department', 'directory' => 'departments', 'obs' => 'Página para apagar o Departamento do banco de dados.', 'public_page' => 0, 'page_status' => 1, 'adms_packages_page_id' => 1, 'adms_groups_page_id' => 8],

            ['name'=> 'Erro 403', 'controller' => 'Error403', 'controller_url' => 'logout', 'directory' => 'errors', 'obs' => 'Erro que deve apresentado quando não encontrar a página.', 'public_page' => 1, 'page_status' => 1, 'adms_packages_page_id' => 1, 'adms_groups_page_id' => 9],
        ];

        // Percorrer o array com dados que devem ser validados antes de cadastrar
        foreach ($pages as $page) {

            // Verifica se a página com o name especificado já existe
            $existingRecord = $this->query('SELECT id FROM adms_pages WHERE name=:name', ['name' => $page['name']])->fetch();

             // Se a página não existir, adiciona seus dados ao array $data
            if (!$existingRecord) {
                $data[] = [
                    'name' => $page['name'],
                    'controller' => $page['controller'],
                    'controller_url' => $page['controller_url'],
                    'directory' => $page['directory'],
                    'obs' => $page['obs'],
                    'public_page' => $page['public_page'], 
                    'page_status' => $page['page_status'],
                    'adms_packages_page_id' => $page['adms_packages_page_id'],
                    'adms_groups_page_id' => $page['adms_groups_page_id'],
                    'created_at' => date("Y-m-d H:i:s"),
                ];
            }
        }

        // Obtém a tabela 'adms_pages' para inserir os registros
        $adms_pages = $this->table('adms_pages');

        // Insere os registros na tabela
        $adms_pages->insert($data)->save();

    }
}
