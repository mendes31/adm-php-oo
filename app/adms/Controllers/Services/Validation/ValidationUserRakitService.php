<?php


namespace App\adms\Controllers\Services\Validation;

use Rakit\Validation\Validator;

class ValidationUserRakitService 
{
    /**
     * Validar os dados do formulário.
     *
     * @param array $data Dados do formulário
     * @return array Lista de erros
     */
    public function validate(array $data): array 
    {
        // Criar o array que deve receber as mensagens de erro 
        $errors = [];

        // Instanciar a classe validar formulário
        $validator = new Validator();

        $validator->addValidator('uniqueInColumns', new UniqueInColumnsRule());

        // Definir as regras de validação
        $rules = [
            'name'              => 'required',
            'email'             => 'required|email',
            // 'username'          => 'required|uniqueInColumns:adms_users,username',
            // 'password'          => 'required|min:6|regex:/[a-zA-Z]/|regex:/[0-9]/|regex:/[^\w\s]/',
            
        ];

        // Se estiver ausente o ID, então é uma criação (cadastrar)
        if(!isset($data['id'])){
            $rules['email'] = 'required|email|uniqueInColumns:adms_users,email;username';
            $rules['password'] = 'required|regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[\W_]).{6,}$/';
            $rules['confirm_password'] = 'required|same:password';
        } else {
            // Para edição, adicionar validação de ID e ignorar o próprio usuário na verificação de email e username
            $rules['id'] = 'required|integer';
            $rules['username'] = 'required|min:6|regex:/^\S*$/|uniqueInColumns:adms_users,email;username,' . $data['id'];
            $rules['email'] = 'required|email|uniqueInColumns:adms_users,email;username,' . $data['id'];
            
        }
        
         // Definir mensagens personalizadas
         $messages = [
            'id:required'                   => 'Dados inválidos.',
            'id:integer'                    => 'Dados inválidos.',
            
            'name:required'                 => 'O campo nome é obrigatório.',
            
            'email:required'                => 'O campo email é obrigatório.',
            'email:email'                   => 'O campo email deve ser um email válido.',
            'email:uniqueInColumns'         => 'O email já está cadastrado.',
            
            'username:required'             => 'O campo usuário é obrigatório.',
            'username:min'                  => 'O usuário deve conter no minimo 6 caracteres.',
            'username:regex'                => 'O usuário não pode conter espaços em branco.',
            'username:uniqueInColumns'      => 'O usuário já existe.',
            
            'password:required'             => 'O campo senha é obrigatório.',
            'password:required'             => 'O campo senha é obrigatório.',
            'password:min'                  => 'A senha deve ter no mínimo 6 caracteres.',
            'password:regex'                => 'A senha deve conter letra(s), numero(s) e caractere(s) especial.',
            'confirm_password:required'     => 'O campo confirmar senha é obrigatório.',
            'confirm_password:same'         => 'A confirmação da senha deve ser igual à senha.',
        ];

        // Criar o validador com os dados e regras fornecidas
        $validation = $validator->make($data, $rules);

        // Definir as mensagens de erro personalizadas
        $validation->setMessages($messages);


        // Validar os dados
        $validation->validate();

        // Retornar erros se houver
        if($validation->fails()){

            // Recuperar os erros
            $arrayErrors = $validation->errors();

            // Percorrer o arraqy de erros
            // firstOfAll - obter a primeira mensagem de erro para cada campo invalido.
            foreach($arrayErrors->firstOfAll() as $key => $message){
                $errors[$key] =  $message;
            }
        }

        return $errors;
    }
}