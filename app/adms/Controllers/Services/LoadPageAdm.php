<?php

namespace App\adms\Controllers\Services;

use App\adms\Helpers\GenerateLog;

class LoadPageAdm
{
    /** @var string $urlController Recebe da URL o nome da controller */
    private string $urlController;

    /** @var string $urlParameter Recebe da URL o parametro */
    private string $urlParameter;

    /** @var string $classLoad Controller que deve ser carregada */
    private string $classLoad;

    /** @var array $listPgPublic Recebe a lista de paginas publicas */
    private array $listPgPublic = ["Login", "Error403"];

    /** @var array $listPgPrivate Recebe a lista de paginas privadas */
    private array $listPgPrivate = ["Dashboard", "ListUsers", "ViewUser", "CreateUser", "UpdateUser", "DeleteUser", "UpdatePasswordUser"];

    /** @var array $listDirectory Recebe a lista de diretórios com as controllers */
    private array $listDirectory = ["login", "dashboard", "users", "errors"];

    /** @var array $listPackages Recebe a lista de pacotes com as controllers */
    private array $listPackages = ["adms"];

    /**
     * Verificar se existe a página com o método checkPageExists
     * Verificar se existe a classe com o método checkControllersExists
     * @param string $urlController Recebe da URL o nome da controller
     * @param string $urlParameter Recebe da URL o parametro
     * 
     * @return void
     */
    public function loadPageAdm(string|null $urlController, string|null $urlParameter): void
    {
        $this->urlController = $urlController;
        $this->urlParameter = $urlParameter;

        // Verificar se existe a pagina
        if (!$this->checkPageExists()) {

            // Chamar o método para salvar log
            GenerateLog::generateLog("error", "Pagina não encontrada.", ['pagina' => $this->urlController, 'parametro' => $this->urlParameter]);

            die("Erro 002: Por favor tente novamente. Caso o problema persista, entre em contato com o adminstrador {$_ENV['EMAIL_ADM']}");
        }

        // Verificar s ea classe existe
        if (!$this->checkControllersExists()) {

            // Chamar o método para salvar log
            GenerateLog::generateLog("error", "Controller não encontrada.", ['pagina' => $this->urlController, 'parametro' => $this->urlParameter]);

            die("Erro 003: Por favor tente novamente. Caso o problema persista, entre em contato com o adminstrador {$_ENV['EMAIL_ADM']}");
        }
    }

    /**
     * Verificar se a pagina existe no array de paginas publicas ou privadas
     * 
     * @return boll
     */
    private function checkPageExists(): bool
    {

        // Verificar se existe a pagina no array de paginas publicas
        if (in_array($this->urlController, $this->listPgPublic)) {
            return true;
        }

        // Verificar se existe a pagina no array de paginas privadas
        if (in_array($this->urlController, $this->listPgPrivate)) {
            return true;
        }

        return false;
    }

    /**
     * Verificar se existe a controller
     * Chamar o método para verificar se existe o método da controller
     * 
     * @return bool
     */
    private function checkControllersExists(): bool
    {
        // Percorrer o arry de pacotes
        foreach ($this->listPackages as $package) {
            //var_dump($package);

            // Percorrer o array de diretórios
            foreach ($this->listDirectory as $directory) {
                //var_dump($directory);

                // Criar o caminho da controller/classe
                $this->classLoad = "\\App\\$package\\Controllers\\$directory\\" . $this->urlController;

                // Verificar se a classe existe
                if (class_exists($this->classLoad)) {

                    // var_dump($package, $directory);

                    // Chamar o método  para validar o método
                    $this->loadMetodo();
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Verificar se existe o método e carrega a pagina/controller 
     * 
     * @return void  
     */
    private function loadMetodo(): void
    {
        // Instanciar a classe da pagina que deve ser carregada
        $classLoad = new $this->classLoad();

        if (method_exists($classLoad, "index")) {
            
            
            // Chamar o método para salvar log
            GenerateLog::generateLog("info", "Pagina acessada.", ['pagina' => $this->urlController, 'parametro' => $this->urlParameter]);

            // Carregar o método
            $classLoad->{"index"}($this->urlParameter);
        } else {

            // Chamar o método para salvar log
            GenerateLog::generateLog("error", "Método não encontrado.", ['pagina' => $this->urlController, 'parametro' => $this->urlParameter]);

            die("Erro 004: Por favor tente novamente. Caso o problema persista, entre em contato com o adminstrador {$_ENV['EMAIL_ADM']}");
        }
    }
}
