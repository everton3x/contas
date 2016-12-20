<table class="ui selectable celled striped table">
    <thead>
        <tr>
            <th colspan="4" class="center aligned">Alterações da Receita</th>
        </tr>
        <tr>
            <th class="left aligned">Data</th>
            <th class="right aligned">Valor</th>
            <th class="left aligned">Descrição</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($alteracoes as $item){
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
<!--    <tfoot>
        <tr>
            <th class="left aligned">Total</td>
            
        </tr>
    </tfoot>-->
</table>