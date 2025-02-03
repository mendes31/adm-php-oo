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

        $validator = new Validator();

        // Definir as regras de validação
        $validation = $validator->make($data, [
            'name'              => 'required',
            'email'             => 'required|email',
            'username'          => 'required',
            'password'          => 'required|min:6|regex:/[a-zA-Z]/|regex:/[0-9]/|regex:/[^\w\s]/',
            "confirm_password"  => 'required|same:password',

        ]);

        // Definir mensagens personalizadas
        $validation->setMessages([
            'name:required'                 => 'O campo nome é obrigatório.',
            'email:required'                => 'O campo email é obrigatório.',
            'email:email'                   => 'O campo emaildeve ser um email válido.',
            'username:required'             => 'O campo usuário é obrigatório.',
            'password:required'             => 'O campo senha é obrigatório.',
            'password:required'             => 'O campo senha é obrigatório.',
            'password:min'                  => 'A senha deve ter no mínimo 6 caracteres.',
            'password:regex'                => 'A senha deve conter letra(s), numero(s) e caractere(s) especial.',
            'confirm_password:required'     => 'O campo confirmar senha é obrigatório.',
            'confirm_password:same'         => 'A confirmação da senha deve ser igual à senha.',
        ]);

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