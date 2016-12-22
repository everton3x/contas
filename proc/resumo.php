<?php

try {
    /*
     * Identifica o mês
     */
    $mes = $_GET['mes'] ?? $_POST['mes'] ?? date('Ym');
    $mesf = formata_mes((int) $mes); //mês formatado
    $mes_anterior = mes_anterior($mes);
    $mes_seguinte = mes_seguinte($mes);
    
    require 'out/navbar-meses.php';

    /*
     * Monta tabela de receitas
     */
    $receitas = Receita::listarReceitas($mes);
    
    require 'out/resumo-receitas.php';
    
    /*
     * Monta tabela de despesa
     */
    $despesas = Despesa::listarDespesas($mes);
    
    require 'out/resumo-despesas.php';
    
    /*
     * Monta tabela de resultados
     */
    $saldo_mes_atual = Resultado::atual($db, $mes);
    $saldo_mes_anterior = Resultado::anterior($db, $mes);
    if($mes > date('Ym')){
        if($saldo_mes_anterior > 0){
            $saldo_mes_anterior = 0;
        }
    }
    $saldo_final = $saldo_mes_atual + $saldo_mes_anterior;
    
    $cor_mes = ($saldo_mes_atual < 0)? 'negative': 'positive';
    $cor_anterior = ($saldo_mes_anterior < 0)? 'negative': 'positive';
    $cor_final = ($saldo_final < 0)? 'negative': 'positive';
    
    require 'out/resumo-resultados.php';
    
    
} catch (Exception $ex) {
    throw $ex;
}
