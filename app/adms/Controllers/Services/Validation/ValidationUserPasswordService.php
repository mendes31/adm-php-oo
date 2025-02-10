<?php


namespace App\adms\Controllers\Services\Validation;

use Rakit\Validation\Validator;

class ValidationUserPasswordService
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

        // Criar o validador com os dados e regras fornecidas
        $validation = $validator->make($data, [
            // 'password' => 'required|min:6|regex:/[A-Z]/|regex:/[^\w\s]/',
            // 'password' => 'required|regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[\W_]).{6,}$/',
            'password' => 'required|min:6|regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[\W_])/',            
            'confirm_password' => 'required|same:password',
        ]);

        // Definir as mensagens de erro personalizadas
        $validation->setMessages([
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