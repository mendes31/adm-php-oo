<?php

namespace App\adms\Controllers\pay;

use App\adms\Models\Repository\PayRepository;

class ClearBusyPay
{
    public function index(int $id): void
    {

        
        if (!(int) $id) {
            $_SESSION['error'] = "ID inválido para limpar bloqueio!";
            header("Location: {$_ENV['URL_ADM']}list-payments");
            return;
        }

        $payRepo = new PayRepository();
        $payRepo->clearBusy((int) $id);

        $_SESSION['success'] = "Bloqueio liberado com sucesso.";
        header("Location: {$_ENV['URL_ADM']}list-payments"); // ou volte pra listagem
    }
}
