<?php

/*
 * datasource
 */

$lista = MeioPagamento::listar();

/*
 * output
 */

require 'out/form-novo-mp.php';
require 'out/tabela-mp.php';