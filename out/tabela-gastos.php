<form class="ui form" action="index.php?acao=salvar-pagamento" method="post">
    <table class="ui selectable celled striped table">
        <thead>
            <tr>
                <th colspan="4" class="center aligned">Gastos</th>
            </tr>
            <tr>
                <th class="left aligned">Data</th>
                <th class="right aligned">Gasto</th>
                <th class="left aligned">Descrição</th>
                <th class="left aligned">Pago em</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($gastos as $item) {
                echo '<tr>';

                echo "<td>";
            echo formata_data($item['data']);
//                echo $item['data'];
                echo "</td>";

                echo "<td>";
                echo formata_numero($item['valor']);
                echo "</td>";

                echo "<td>";
                echo $item['descricao'];
                echo "</td>";

                echo "<td>";
                echo ($item['pago']) ? formata_data($item['pago']) : "<div class='ui action input' style='min-width: 0px; width: 160px;'><input type='date' name='data[{$item['cod']}]'><button class='positive ui button' type='submit'>Salvar</button></div>";
                echo "</td>";

                echo '</tr>';
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th class="left aligned">Total</th>
                <th class="left aligned"><?= $total_gasto; ?></th>
                <th class="left aligned"></th>
                <th class="left aligned"><?= $total_pago; ?></th>
            </tr>
        </tfoot>
    </table>
    <input type="hidden" name="despesa" value="<?=$despesa_cod;?>">
</form>