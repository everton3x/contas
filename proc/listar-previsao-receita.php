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

$alteracoes = $receita->alteracoes();

$total_alteracoes = $receita->alteracoes;

/*
 * chamao output
 */
require 'out/form-nova-alteracao-receita.php';

require 'out/tabela-alteracoes-receita.php';
