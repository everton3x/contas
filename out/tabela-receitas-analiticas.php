<form method="post" class="ui form">
    <div class="ui action input">
        <input type="month" name="mes" required="" value="<?= $mes;?>">
        <button type="submit" class="ui button">Ir</button>
    </div>
</form>

<table class="ui selectable celled striped table">
    <thead>
        <tr>
            <th class="center aligned" colspan="6">Receitas e Recebimentos</th>
        </tr>
        <tr>
            <th>Receitas</th>
            <th>Descrição</th>
            <th>Vencimento</th>
            <th>Previsto</th>
            <th>Recebido</th>
            <th>Saldo</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total_previsto = 0;
        $total_recebido = 0;
        
        foreach ($dados as $linha){
            $o = new Receita($db, $linha['cod']);
            $total_previsto += $o->valor_atualizado;
            $total_recebido += $o->valor_recebido;
            $vencimento = formata_data($o->vencimento);
            $previsto = formata_numero($o->valor_atualizado);
            $data = date('Y-m-d');
            $saldo = $o->valor_atualizado - $o->valor_recebido;
            $recebido = ($o->valor_recebido > 0)? formata_numero($o->valor_recebido) : "<div class='ui action input'><input type='number' name='valor[{$o->cod}]' step='0.01' form='salvar'><button type='submit' class='ui green button' form='salvar'>Salvar</button></div><input type='hidden' name='data[{$o->cod}]' value='$data' form='salvar'><input type='hidden' name='descricao[{$o->cod}]' value='{$o->descricao}' form='salvar'><input type='hidden' name='receita[{$o->cod}]' value='{$o->cod}' form='salvar'>";
            
            $saldof = formata_numero($saldo);
            echo '<tr>';
            echo "<td>{$o->nome} <a href='index.php?acao=listar-recebimento-receita&receita={$o->cod}'><i class='fitted olive external square link icon'></i></a></td>";
            echo "<td>{$o->descricao}</td>";
            echo "<td>$vencimento</td>";
            echo "<td>$previsto</td>";
            echo "<td>$recebido</td>";
            echo "<td>$saldof</td>";
            echo '</tr>';
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="3">Totais</th>
            <th><?= formata_numero($total_previsto);?></th>
            <th><?= formata_numero($total_recebido);?></th>
            <th><?= formata_numero($total_previsto - $total_recebido);?></th>
        </tr>
    </tfoot>
    
</table>
<form id="salvar" method="post" action="index.php?acao=salvar-lote-recebimento"></form>