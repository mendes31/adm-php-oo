<?php

namespace App\adms\Controllers\pay;

use App\adms\Models\Repository\PaymentsRepository;

class GetPaymentsStatus
{
    public function index(): void
    {
        header('Content-Type: application/json');

        $repo = new PaymentsRepository();
        $dados = $repo->getPaymentsStatus(); // Esse é o novo método leve que criamos

        echo json_encode($dados);
    }
}
