<?php

$mes = $_POST['mes'] ?? date('Y-m');
$dados = Receita::analitico(desformata_mes($mes));

require 'out/tabela-receitas-analiticas.php';