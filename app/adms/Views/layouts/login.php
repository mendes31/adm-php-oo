<!DOCTYPE html>
<html lang="<?php echo $_ENV['APP_LOCALE'];?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="shortcut icon" href="<?php echo $_ENV['URL_ADM']; ?>public/adms/image/icon/logo.ico">

    <link rel="stylesheet" href="<?php echo $_ENV['URL_ADM'] ?>public/adms/css/sbadmin.css">
    
    <link rel="stylesheet" href="<?php echo $_ENV['URL_ADM'] ?>public/adms/css/bootstrap.min.css">

    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <title>
        <?php
            echo $_ENV['APP_NAME'] . " - " . ($this->data['title_head'] ?? "");
        ?>
    </title>
</head>

<body>

<?php

// Inclui o conteúdo principal da página, que é especificado pela propriedade $this->view. Este arquivo é dinâmico e pode variar conforme a lógica do controlador ou o contexto da página.
include $this->view;

?>

<script src="<?php echo $_ENV['URL_ADM'] ?>public/adms/js/bootstrap.bundle.min"></script>

<script src="<?php echo $_ENV['URL_ADM'] ?>public/adms/js/sbadmin.js"></script>

</body>

</html>