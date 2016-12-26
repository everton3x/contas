<?php
//echo '<pre>', print_r($_POST), '<pre>'; exit();
$datas = $_POST['data'] ??  false;
$valores = $_POST['valor'] ??  false;
$descricoes = $_POST['descricao'] ??  'Salvamento em lotes.';
$receitas = $_POST['receita'] ??  false;
$contagem = 0;

foreach ($receitas as $cod => $receita){
    $_POST['data'] = $datas[$cod];
    $_POST['valor'] = $valores[$cod];
    $_POST['descricao'] = $descricoes[$cod];
    $_POST['receita'] = $receitas[$cod];
    
    if($_POST['data'] != ''){
        require 'proc/salvar-recebimento.php';
        $contagem++;
    }
}

$msg = new ArrayIterator(["Foram salvos $contagem recebimentos."]);
    require 'out/success.php';