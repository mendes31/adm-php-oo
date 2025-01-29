<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class AddAdmsUsers extends AbstractSeed
{
    /**
     * Cadastrar usuário no banco de dados
     * 
     */
    public function run(): void
    {
        // variável para receber os dados
        $data = [];

        // Verificar se o registro já existe no banco de dados
        $existingRecord = $this->query('SELECT id FROM adms_users WHERE username=:username', ['username' => 'manager'])->fetch();

        // Se o registro não existir, insere os dados na veriável $data para em seguida cadastrar na tabela
        if (!$existingRecord) {

            // Criar o array com os dados do usuário
            $data[] = [
                'name' => 'Manager',
                'email' => 'manager@tiaraju.com.br',
                'username' => 'manager',
                'password' => password_hash('admin25*', PASSWORD_DEFAULT),
                'created_at' => date("Y-m-d H:i:s"),
            ];
        }
        // Verificar se o registro já existe no banco de dados
        $existingRecord = $this->query('SELECT id FROM adms_users WHERE username=:username', ['username' => 'rafael.oliveira'])->fetch();

        // Se o registro não existir, insere os dados na veriável $data para em seguida cadastrar na tabela
        if (!$existingRecord) {

            // Criar o array com os dados do usuário
            $data[] = [
                'name' => 'Rafael Mendes de Oliveira',
                'email' => 'rafael.oliveira@tiaraju.com.br',
                'username' => 'rafael.oliveira',
                'password' => password_hash('admin25*', PASSWORD_DEFAULT),
                'created_at' => date("Y-m-d H:i:s"),
            ];
        }

                // Verificar se o registro já existe no banco de dados
       $existingRecord = $this->query('SELECT id FROM adms_users WHERE username=:username', ['username' => 'wladimir.souza'])->fetch();

       // Se o registro não existir, insere os dados na veriável $data para em seguida cadastrar na tabela
       if(!$existingRecord){

                // Criar o array com os dados do usuário
                $data[] = [
                    'name' => 'Wladimir Ribeiro de Souza',
                    'email' => 'wladimir.souza@tiaraju.com.br',
                    'username' => 'wladimir.souza',
                    'password' => password_hash('admin25*', PASSWORD_DEFAULT),
                    'created_at'=> date("Y-m-d H:i:s"),
                ];

       }
                // Verificar se o registro já existe no banco de dados
                $existingRecord = $this->query('SELECT id FROM adms_users WHERE username=:username', ['username' => 'marciane.meotti'])->fetch();

                // Se o registro não existir, insere os dados na veriável $data para em seguida cadastrar na tabela
                if(!$existingRecord){
         
                         // Criar o array com os dados do usuário
                         $data[] = [
                             'name' => 'Marciane Meotti',
                             'email' => 'marciane.meotti@tiaraju.com.br',
                             'username' => 'marciane.meotti',
                             'password' => password_hash('admin25*', PASSWORD_DEFAULT),
                             'created_at'=> date("Y-m-d H:i:s"),
                         ];
         
                }
         

        // Indicar em qual tabela deve salvar
        $adms_users = $this->table('adms_users');

        // Inserir os registros na tabela
        $adms_users->insert($data)->save();
    }
}
