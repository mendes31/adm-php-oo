## Requisitos

* PHP 8.3 ou superior;
* MySQL 8.0 ou superior;
* Composer;

## Como rodar o projeto baixado

Instalar as dependências.
```
composer install
```


## Sequencia para criar o projeto
Criar o arquivo composer.json com a instrução básica.
```
composer init
```
Instalar a dependencia Monolog, biblioteca PHO que permite criar arquivo de log.
```
composer require monolog/monolog
```

## Como usar o GitHub
Baixar os arquivos do Git.
```
git clone --branch <branch_name> <repository_url> .
```

Definir as configurações do usuário.
```
git config --local user.name mendes31 Rafael Mendes
```
```
git config --local user.email raffaell_mendez@hotmail.com
```

Verificar a branch.
```
git branch 
```

Baixar as atualizações.
```
git pull
```

Adicionar todos os arquivos modificados no staging area - área de preparação.
```
git add .
```

commit representa um conjunto de alterações em um ponto específico da história do seu projeto, registra apenas as alterações adicionadas ao índice de preparação.
O comando -m permite que insira a mensagem de commit diretamente na linha de comando.
```
git commit -m "Descrição do commit"
```

Enviar os commits locais, para um repositório remoto.
```
git push <remote> <branch>
git push origin dev-master
```







