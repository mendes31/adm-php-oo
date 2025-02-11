<?php

echo "Bem vindo " .($_SESSION['user_name'] ?? ''). "<br>";

echo "<a href='{$_ENV['URL_ADM']}logout'>Sair</a>";