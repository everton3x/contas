<?php
//echo '<pre>', print_r($_POST), '</pre>';

$parcelas = count($_POST['mes']);

foreach ($_POST['mes'] as $i => $null) {
    /*
     * Prepara o ambiente
     */
    $errors = [];
    
    /*
     * pega dados iniciais
     */
    
    $mes = $_POST['mes'][$i] ?? null;
    $nome = $_POST['nome'] ?? null;
    $descricao = ($_POST['descricao'] ?? 'Sem descrição')." parcela $i de $parcelas";
    $valor_inicial = $_POST['valor_inicial'][$i] ?? 0;
    $vencimento = $_POST['vencimento'][$i] ?? '';
    $gasto = $_POST['gasto'][$i] ?? false;
    $pago = $_POST['pago'][$i] ?? false;
    $mp = $_POST['mp'] ?? false;
    
    
    /*
     * Testa os falores recebidos
     */
    if (is_null($mes)) {
        $errors['mes'] = "Mês inválido para parcela $i!";
    } else {
        $mes = desformata_mes($mes);
    }

    if (is_null($nome)) {
        $errors['nome'] = "Despesa inválida para parcela $i!";
    }

    /*
     * Se houverem erros, retorna, se não, salva
     */
    if (count($errors) > 0) {
        $errors = new ArrayIterator($errors);
        require 'out/errors.php';
    } else {
        
        /*
         * previsao
         */
        $ds = new Despesa($db, null, $mes, $nome, $descricao, $valor_inicial, $vencimento);

        if ($ds->cod > 0) {
            $msg = new ArrayIterator(["Despesa salva com código $ds->cod ($i/$parcelas)!"]);
            require 'out/success.php';
        } else {
            $errors = new ArrayIterator(["Parcela $i/$parcelas: {$db->errorInfo()}"]);
            require 'out/errors.php';
        }
        
        /*
         * gasto
         */

        if($gasto){
            if(MeioPagamento::existe((int) $mp) === 1){
                $errors = new ArrayIterator(["Meio de pagamento $mp não encontrado: parcela $i/$parcelas"]);
                require 'out/errors.php';
            } else {
//                $data = formata_data($gasto);
                $data = $gasto;
                
                if ($ds->gastar($ds->cod, $mp, $data, $valor_inicial, $descricao)) {
                    $gasto_cod = $db->lastInsertId();
                    $msg = new ArrayIterator(["Gasto salvo com código $gasto_cod ($i/$parcelas)!"]);
                    require 'out/success.php';
                    
                    /*
                     * pagar
                     */
                    
                    if($pago){
//                        if($ds->pagar($gasto_cod, formata_data($pago))){
                        if($ds->pagar($gasto_cod, $pago)){
                            $msg = new ArrayIterator(["Pagamento salvo com código $gasto_cod ($i/$parcelas)!"]);
                            require 'out/success.php';
                        }else{
                            $errors = new ArrayIterator(["Parcela $i/$parcelas: {$db->errorInfo()}"]);
                            require 'out/errors.php';
                        }
                    }
                } else {
                    $errors = new ArrayIterator(["Parcela $i/$parcelas: {$db->errorInfo()}"]);
                    require 'out/errors.php';
                }
            }
        }
        
        
        
        
    }
}