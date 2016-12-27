<form method="post" class="ui form">
    <div class="ui action input">
        <input type="month" name="mes" required="" value="<?= $mes;?>">
        <button type="submit" class="ui button">Ir</button>
    </div>
</form>

<table class="ui selectable celled striped table">
    <thead>
        <tr>
            <th class="center aligned" colspan="13">Resultados Mensais</th>
        </tr>
        <tr>
            <th>Totais</th>
            
            <?php
            foreach ($meses as $cod => $dados){
                $mesf = formata_mes($cod);
                echo "<th>$mesf</th>";
            }
            ?>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Receita</td>
            <?php
            foreach ($meses as $cod => $dados){
                $valor = $dados['receita'];
                $valorf = formata_numero($valor);
                $cor = ($valor < 0)? 'negative' : 'positive';

                echo "<td class='$cor'>$valorf</td>";
            }
            ?>
            
        </tr>
        <tr>
            <td>Despesa</td>
            <?php
            foreach ($meses as $cod => $dados){
                $valor = $dados['despesa'];
                $valorf = formata_numero($valor);
                $cor = ($valor < 0)? 'negative' : 'positive';

                echo "<td class='$cor'>$valorf</td>";
            }
            ?>
            
        </tr>
        <tr>
            <td>Mês</td>
            <?php
            foreach ($meses as $cod => $dados){
                $valor = $dados['resultado_mes'];
                $valorf = formata_numero($valor);
                $cor = ($valor < 0)? 'negative' : 'positive';

                echo "<td class='$cor'>$valorf</td>";
            }
            ?>
            
        </tr>
        <tr>
            <td>Anterior</td>
            <?php
            foreach ($meses as $cod => $dados){
                $valor = $dados['resultado_anterior'];
                $valorf = formata_numero($valor);
                $cor = ($valor < 0)? 'negative' : 'positive';

                echo "<td class='$cor'>$valorf</td>";
            }
            ?>
            
        </tr>
        <tr>
            <td>Final</td>
            <?php
            foreach ($meses as $cod => $dados){
                $valor = $dados['resultado_final'];
                $valorf = formata_numero($valor);
                $cor = ($valor < 0)? 'negative' : 'positive';

                echo "<td class='$cor'>$valorf</td>";
            }
            ?>
            
        </tr>
    </tbody>
</table>