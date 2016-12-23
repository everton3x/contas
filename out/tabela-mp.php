
<hr>
<form method="post" class="ui form">
    <div class="ui action input">
        <input type="month" name="mes" required="" value="<?= formata_mes_para_input($mes);?>">
        <button type="submit" class="ui button">Ir</button>
    </div>
</form>

<table class="ui selectable celled striped table">
    <thead>
        <tr>
            <th class="center aligned" colspan="3">Meios de Pagamento</th>
        </tr>
        <tr>
            <th>Meio de Pagamento</th>
            <th>Valor Gasto</th>
            <th>Valor Pago</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total_gasto = 0;
        $total_pago = 0;
        foreach ($lista as $item){
            $valores = Despesa::totaisPorMP($item['cod'], $mes);
            $total_gasto += $valores['gasto'];
            $total_pago += $valores['pago'];
            echo '<tr>';
            
            echo "<td>";
            echo $item['mp'];
            echo "</td>";
            
            echo "<td>";
            echo formata_numero($valores['gasto']);
            echo "</td>";
            
            echo "<td>";
            echo formata_numero($valores['pago']);
            echo "</td>";
            
            echo '</tr>';
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th>Totais</th>
            <th><?= formata_numero($total_gasto);?></th>
            <th><?= formata_numero($total_pago);?></th>
        </tr>
    </tfoot>
    
</table>