<table class="ui selectable celled striped table">
    <thead>
        <tr>
            <th colspan="4" class="center aligned">Recebimentos</th>
        </tr>
        <tr>
            <th class="left aligned">Data</th>
            <th class="right aligned">Valor</th>
            <th class="left aligned">Descrição</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($recebimentos as $item){
            echo '<tr>';
            
            echo "<td>";
            echo formata_data($item['data']);
            echo "</td>";
            
            echo "<td>";
            echo formata_numero($item['valor']);
            echo "</td>";
            
            echo "<td>";
            echo $item['descricao'];
            echo "</td>";
            
            echo '</tr>';
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th class="left aligned" colspan="2">Total</th>
            <th class="left aligned"><?=$total_recebimentos;?></th>
        </tr>
    </tfoot>
</table>