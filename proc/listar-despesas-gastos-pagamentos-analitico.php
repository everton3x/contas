<?php
//echo '<pre>', print_r($_POST), '</pre>';
//exit();
/*
 * input
 */
$mes = $_POST['mes'] ?? date('Y-m');
$mp = $_POST['mp'] ?? false;
if($mp){
    $mp = ($mp === '')? NULL : (int) $mp;
}else{
    $mp = null;
}

/*
 * datasource
 */
$dados = Despesa::listarAnalitico(desformata_mes($mes), $mp);

//echo '<pre>', print_r($dados), '<pre>'; exit();

/*
 * output
 */

require 'out/form-filtro-despesas-analitica.php';
require 'out/tabela-despesas-analitica.php';