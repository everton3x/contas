<?php

//echo '<pre>', print_r($_POST), '<pre>';
//exit();

$pagos = $_POST['pagos'] ?? false;

if($pagos){
    foreach ($pagos as $cod => $data){
        if(strlen($data) === 10){
            $_POST['data'][$cod] = $data;
            $_POST['despesa'] = $cod;
        }
    }
    
    require 'proc/salvar-pagamento.php';
}else{
    $errors = new ArrayIterator(['Nenhum pagamento recebido!']);
    require 'out/errors.php';
}