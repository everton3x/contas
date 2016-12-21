<?php

/*
 * Testa input
 */
$despesa_cod = $_GET['despesa'] ?? false;

if($despesa_cod === false){
    throw new InvalidArgumentException('Código da despesa não recebido!');
}

/*
 * Busca dados da previsão
 */

$despesa = new Despesa($db, $despesa_cod);

$gastos = $despesa->gastos();

$total_gasto = formata_numero($despesa->valor_gasto);

$total_pago = formata_numero($despesa->valor_pago);

/*
 * chamao output
 */
require 'out/form-novo-gasto.php';

require 'out/tabela-gastos.php';
