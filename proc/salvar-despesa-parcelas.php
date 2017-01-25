<?php

//echo '<pre>', print_r($_POST), '</pre>';
//exit();

$nome = $_POST['nome'] ?? false;
$descricao = $_POST['descricao'] ?? '';
$mes = $_POST['mes'] ?? false;
(int) $parcelas = $_POST['parcelas'] ?? false;
$total = $_POST['total'] ?? false;
$mes = desformata_mes($mes);
$mp = $_POST['mp'] ?? '';
$gastar = $_POST['gastar'] ?? '';

$errors = [];

if(!$nome){
    $errors[] = 'Nenhuma despesa informada!';
}

if($mes === 0){
    $errors[] = 'Nenhum mês informado!';
}

if($parcelas === 0){
    $errors[] = 'Nenhuma parcela informada!';
}

if($total === 0){
    $errors[] = 'Nenhum valor informado!';
}

if($gastar !== '' && $mp === ''){
    $errors[] = 'Você indicou gastar, mas não indicou um meio de pagamento!';
}

if(count($errors) > 0){
    $errors = new ArrayIterator($errors);
    require 'out/errors.php';
}else{
    unset($_POST);
    $valor = round((float) $total / $parcelas, 2);
    
    for($i = 1; $i <= $parcelas; $i++){
        $_POST['parcelas'] = $parcelas;
        $_POST['nome'] = $nome;
        $_POST['descricao'] = "$descricao ($i/$parcelas)";
        $_POST['mes'][$i] = $mes;
        $mes = mes_seguinte($mes);
        $_POST['valor_inicial'][$i] = $valor;
        $_POST['vencimento'][$i] = '';
        $_POST['gasto'][$i] = $gastar;
        $_POST['pago'][$i] = '';
        $_POST['mp'] = $mp;
//        echo '<pre>', print_r($_POST), '</pre><hr>';
        
    }
    require 'proc/salvar-despesa-prevista.php';
//    echo '<pre>', print_r($_POST), '</pre><hr>';
    
}

