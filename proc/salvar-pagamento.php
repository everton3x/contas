<?php
//echo '<pre>', print_r($_POST), '</pre>';
/*
 * Pega input
 */

$datas = $_POST['data'] ?? false;
$despesa = $_POST['despesa'] ?? false;

/*
 * Testa input
 */

if ($datas === FALSE) {
    throw new InvalidArgumentException("Datas inválidas!");
}

if ($despesa === FALSE) {
    throw new InvalidArgumentException("Código da despesa não recebido!");
}

$ds = new Despesa($db, $despesa);

foreach($datas as $gasto => $data){
    if(strlen($data) !== 10){
//        echo "Sem data $gasto: $data<br>";
        continue;
    }
//    echo "Salvar $gasto: $data<br>";
    if ($ds->pagar($gasto, $data)) {
        $msg = new ArrayIterator(["Pagamento da despesa $despesa com gasto $gasto com código {$db->lastInsertId()}"]);
        require 'out/success.php';
    }
}