<?php

/*
 * input
 */
$mes = $_POST['mes'] ?? date('Ym');
$base = desformata_mes($mes);

$meses[$base]['receita'] = Receita::receitaTotalPrevista($base);
$meses[$base]['despesa'] = Despesa::despesaTotalPrevista($base);
$meses[$base]['resultado_mes'] = Resultado::atual($db, $base);
$meses[$base]['resultado_anterior'] = Resultado::anterior($db, $base);
$meses[$base]['resultado_final'] = $meses[$base]['resultado_mes'] + $meses[$base]['resultado_anterior'];

for($i = 0; $i < 11; $i++){
    $seguinte = mes_seguinte($base);
    $meses[$seguinte]['receita'] = Receita::receitaTotalPrevista($seguinte);
    $meses[$seguinte]['despesa'] = Despesa::despesaTotalPrevista($seguinte);
    $meses[$seguinte]['resultado_mes'] = Resultado::atual($db, $seguinte);
    $meses[$seguinte]['resultado_anterior'] = Resultado::anterior($db, $seguinte);
    $meses[$seguinte]['resultado_final'] = $meses[$seguinte]['resultado_mes'] + $meses[$seguinte]['resultado_anterior'];
    $base = $seguinte;
}

//echo '<pre>', print_r($meses), '</pre>';
//exit();



/*
 * output
 */
require 'out/tabela-meses-resultados.php';