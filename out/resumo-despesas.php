
<table class="ui selectable celled striped table">
    <thead>
        <tr>
            <th colspan="4" class="center aligned">Despesas</th>
        </tr>
        <tr>
            <th class="left aligned">Despesa</th>
            <th class="right aligned collapsing">Previsto</th>
            <th class="right aligned collapsing">Gasto</th>
            <th class="right aligned collapsing">Saldo</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total_previsto = 0;
        $total_executado = 0;
        $total_saldo = 0;
        
        while($despesas->valid()){
            $current = $despesas->current();
            
            //soma no total
            $total_previsto += $current->valor_atualizado;
            $total_executado += $current->valor_gasto;
            $total_saldo += $current->saldo_gastar;
            
            //formata
            $nome = $current->nome;
            $descricao = $current->descricao ?? 'Nenhuma descrição';
            $vencimento = formata_data($current->vencimento ?? '0000-00-00');
            $previsto = formata_numero($current->valor_atualizado ?? 0);
            $executado = formata_numero($current->valor_gasto ?? 0);
            $saldo = formata_numero($current->saldo_gastar ?? 0);
            
            $cor_previsto = ($current->valor_atualizado < 0)? 'negative' : 'positive';
            $cor_executado = ($current->valor_gasto < 0)? 'negative' : 'positive';
            $cor_saldo = ($current->saldo_gastar < 0)? 'negative' : 'positive';
            
            //imprime as linhas
            echo "<tr>";
            
            echo "<td class=\"left aligned\">";
            echo '<div class="ui accordion">';
            echo "<div class=\"title\">$nome</div>";
            echo '<div class="content">';
            echo "<p>$descricao</p>";
            echo "<p>Vence em $vencimento</p>";
            echo '<div class="ui icon buttons">';
            echo "<a class='ui green button' href='index.php?acao=listar-previsao-despesa&despesa={$current->cod}'><i class='hourglass full icon'></i>Previsão</a>";
            echo "<a class='ui red button' href='index.php?acao=listar-gasto-despesa&despesa={$current->cod}'><i class='signal icon'></i>Gasto</a>";
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo "</td>";
            
            echo "<td class=\"right aligned collapsing $cor_previsto\">";
            echo $previsto;
            echo "</td>";
            
            echo "<td class=\"right aligned collapsing $cor_executado\">";
            echo $executado;
            echo "</td>";
            
            echo "<td class=\"right aligned collapsing $cor_saldo\">";
            echo $saldo;
            echo "</td>";
            
            echo "</tr>";
            
            $despesas->next();
        }
        
        //cores dos totais
        $cor_total_previsto = ($total_previsto < 0)? 'negative' : 'positive';
        $cor_total_executado = ($total_executado < 0)? 'negative' : 'positive';
        $cor_total_saldo = ($total_saldo < 0)? 'negative' : 'positive';
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th class="left aligned">Total</th>
            <th class="right aligned collapsing <?=$cor_total_previsto;?>"><?php echo formata_numero($total_previsto);?></th>
            <th class="right aligned collapsing <?=$cor_total_executado;?>"><?php echo formata_numero($total_executado);?></th>
            <th class="right aligned collapsing <?=$cor_total_saldo;?>"><?php echo formata_numero($total_saldo);?></th>
        </tr>
    </tfoot>
</table>

<script>
//    inicializa acordion
$('.ui.accordion').accordion();

</script>