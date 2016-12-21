<?php

/*
 * Input
 */

$mp = $_POST['mp'] ?? false;

/*
 * testa input
 */

if($mp === false){
    $errors = new ArrayIterator(['Nenhum meio de pagamento definido.']);
    require 'out/errors.php';
}else{
    //ds
    $ds = new MeioPagamento($db, null, $mp);
    
    $msg = new ArrayIterator(["Meio de pagamento salvo com o código {$ds->cod}!"]);
    require 'out/success.php';
}