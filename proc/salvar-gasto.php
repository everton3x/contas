<?php

/*
 * Pega input
 */

$data = $_POST['data'] ?? false;
$valor = $_POST['valor'] ?? false;
$descricao = $_POST['descricao'] ?? 'Nenhuma descrição';
$despesa_cod = $_POST['despesa'] ?? false;
$mp = $_POST['mp'] ?? false;
$pago = $_POST['pago'] ?? false;

/*
 * Testa input
 */

if ($data === FALSE) {
    throw new InvalidArgumentException("Data $data inválida!");
}

if ($valor === FALSE) {
    throw new InvalidArgumentException("Valor $valor inválido!");
}

if ($despesa_cod === FALSE) {
    throw new InvalidArgumentException("Código da despesa $despesa_cod inválido!");
}

if (MeioPagamento::existe($mp)) {
    throw new InvalidArgumentException("Meio de pagamento $mp não existe!");
}

/*
 * salva
 */
$ds = new Despesa($db, $despesa_cod);

if ($ds->gastar($despesa_cod, $mp, $data, $valor, $descricao)) {
    $msg = new ArrayIterator(["Gasto da despesa $despesa_cod salvo com código {$db->lastInsertId()}"]);
    $gasto_cod = $db->lastInsertId();
    require 'out/success.php';
}

/*
 * paga
 */

if ($pago) {
    if ($ds->pagar($gasto_cod, $data)) {
        $msg = new ArrayIterator(["Pagamento da despesa $despesa_cod com gasto $gasto_cod com código {$db->lastInsertId()}"]);
        require 'out/success.php';
    }
}