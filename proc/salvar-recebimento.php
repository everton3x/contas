<?php
//echo '<pre>', print_r($_POST), '</pre>'; exit();
/*
 * Pega input
 */

$data = $_POST['data'] ?? false;
$valor = $_POST['valor'] ?? false;
$descricao = $_POST['descricao'] ?? 'Nenhuma descrição';
$receita_cod = $_POST['receita'] ?? false;

/*
 * Testa input
 */

if($data === FALSE){
    throw new InvalidArgumentException("Data $data inválida!");
}

if($valor === FALSE){
    throw new InvalidArgumentException("Valor $valor inválido!");
}

if($receita_cod === FALSE){
    throw new InvalidArgumentException("Código da receita $receita_cod inválido!");
}

/*
 * salva
 */
$ds = new Receita($db, $receita_cod);

if($ds->salvaRecebimento($receita_cod, $data, $valor, $descricao)){
    $msg = new ArrayIterator(["Recebimento da receita $receita_cod salva com código {$db->lastInsertId()}"]);
    require 'out/success.php';
}