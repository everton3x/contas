<?php

/*
 * Pega input
 */

$data = $_POST['data'] ?? false;
$valor = $_POST['valor'] ?? false;
$descricao = $_POST['descricao'] ?? 'Nenhuma descrição';
$despesa_cod = $_POST['despesa'] ?? false;

/*
 * Testa input
 */

if($data === FALSE){
    throw new InvalidArgumentException("Data $data inválida!");
}

if($valor === FALSE){
    throw new InvalidArgumentException("Valor $valor inválido!");
}

if($despesa_cod === FALSE){
    throw new InvalidArgumentException("Código da despesa $despesa_cod inválido!");
}

/*
 * salva
 */
$ds = new Despesa($db, $despesa_cod);

if($ds->salvaAlteracao($despesa_cod, $data, $valor, $descricao)){
    $msg = new ArrayIterator(["Alteração da despesa $despesa_cod salva com código {$db->lastInsertId()}"]);
    require 'out/success.php';
}