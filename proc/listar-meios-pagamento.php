<?php

/*
 * datasource
 */

$lista = MeioPagamento::listar();

/*
 * input
 */

$mes = $_POST['mes'] ?? date('Ym');
$mes = desformata_mes($mes);
/*
 * output
 */

require 'out/form-novo-mp.php';
require 'out/tabela-mp.php';