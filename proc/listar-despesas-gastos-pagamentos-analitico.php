<?php

/*
 * input
 */
$mes = $_POST['mes'] ?? date('Y-m');


/*
 * datasource
 */
$dados = Despesa::listarAnalitico(desformata_mes($mes));

//echo '<pre>', print_r($dados), '<pre>'; exit();

/*
 * output
 */

require 'out/tabela-despesas-analitica.php';