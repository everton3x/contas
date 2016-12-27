<table class="ui selectable celled striped table">
    <thead>
        <tr>
            <th class="center aligned" colspan="6">Despesas, Gastos e Pagamentos</th>
        </tr>
        <tr>
            <th>Despesa</th>
            <th>Meio de Pagamento</th>
            <th>Descrição</th>
            <th>Vencimento</th>
            <th>Gasto</th>
            <th>Pago</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total_gasto = 0;
        $total_pago = 0;
        
        foreach ($dados as $i => $linha){
            $o = new Despesa($db, $linha['despesa']);
            $despesa = $linha['despesa'];
            $total_gasto += $linha['valor'];
            if($linha['pago']){
                $total_pago += $linha['valor'];
            }
            $gasto = $linha['gasto'];
            $nome = $linha['nome'];
            $descricao = $linha['descricao'];
            $vencimento = ($linha['vencimento'])? formata_data($linha['vencimento']) : '';
            $mp = $linha['mp'];
//            $valor = (!is_null($linha['valor']))? formata_numero($linha['valor']) : "<div class='ui input'><input type='date' name='gastos[$despesa]' form='salvar'></div>";
            $valor = formata_numero($linha['valor']);
            $pago = (!is_null($linha['pago']))? formata_data($linha['pago']) : "<div class='ui action input'><input type='date' name='pagos[$gasto]' form='salvar'><button class='ui green icon button' type='submit' form='salvar'><i class='save icon'></i></button></div>";
            echo '<tr>';
            
            
            echo "<td>$despesa $nome</td>";
            
            echo '<td>';
            echo $mp;
            echo '</td>';
            
            echo "<td>$descricao</td>";
            echo "<td>$vencimento</td>";
            echo "<td>$valor</td>";
            echo "<td>$pago</td>";
            
            echo '</tr>';
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="4">Totais</th>
            <th><?= formata_numero($total_gasto);?></th>
            <th><?= formata_numero($total_pago);?></th>
        </tr>
    </tfoot>
    
</table>

<form id="salvar" action="index.php?acao=salvar-lote-despesas" method="post"></form>

<script>
    $('.ui.floating.dropdown.labeled.search.icon.button').dropdown({
        allowAdditions: false
    });
</script>