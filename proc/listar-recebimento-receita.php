<?php

/*
 * Testa input
 */
$receita_cod = $_GET['receita'] ?? false;

if($receita_cod === false){
    throw new InvalidArgumentException('Código da receita não recebido!');
}

/*
 * Busca dados da previsão
 */

$receita = new Receita($db, $receita_cod);

$recebimentos = $receita->recebimentos();

$total_recebimentos = formata_numero($receita->valor_recebido);

/*
 * chamao output
 */
require 'out/form-novo-recebimento.php';

require 'out/tabela-recebimentos.php';
