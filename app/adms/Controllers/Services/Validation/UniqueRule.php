<?php

namespace App\adms\Controllers\Services\Validation;

use App\adms\Helpers\GenerateLog;
use App\adms\Models\Repository\UniqueValueRepository;
use Exception;
use Rakit\Validation\Rule;

class UniqueRule extends Rule
{
    // Mensagem de erro genéria (value = valor dentro do campo)
    protected $message = ":value já está em uso";

    // Parâmetros dinâmicos
    protected $fillableParams = ['table', 'column', 'except'];

    public function check($value): bool
    {
        
        try{// Usar o try catch para gerenciar exceção/erro

        // Verificar se os parâmetros necessários existem
        $this->requireParameters(['table', 'column']);

        // Recuperar os parâmetros
        $column = $this->parameter('column');
        $table = $this->parameter('table');
        $except = $this->parameter('except');

        if ($except and $except == $value) {
            return true;
        }
       
        // Instanciar o Repository para verificar se existe registro com o valor fornecido
        $validateUniqueValue = new UniqueValueRepository();
        return $validateUniqueValue->getRecord($table, $column, $value);
    }catch (Exception $e) { // Acessa o catch quando houver erro no try

        // Chamar o método para salvar o log
        GenerateLog::generateLog("error", "Usuário não cadastrado.", ['error' => $e->getMessage()]);

        return false;

    }
    }
}
