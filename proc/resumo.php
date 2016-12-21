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
    
    
} catch (Exception $ex) {
    throw $ex;
}
