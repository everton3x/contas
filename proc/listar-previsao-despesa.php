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

$alteracoes = $despesa->alteracoes();

$total_alteracoes = formata_numero($despesa->alteracoes);

/*
 * chamao output
 */
require 'out/form-nova-alteracao-despesa.php';

require 'out/tabela-alteracoes-despesa.php';
