

<table class="ui selectable celled striped table">
    <thead>
        <tr>
            <th colspan="4" class="center aligned">Receitas</th>
        </tr>
        <tr>
            <th class="left aligned">Receita</th>
            <th class="right aligned collapsing">Previsto</th>
            <th class="right aligned collapsing">Recebido</th>
            <th class="right aligned collapsing">Saldo</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total_previsto = 0;
        $total_executado = 0;
        $total_saldo = 0;
        
        while($receitas->valid()){
            $current = $receitas->current();
            
            //soma no total
            $total_previsto += $current->valor_atualizado;
            $total_executado += $current->valor_recebido;
            $total_saldo += $current->saldo;
            
            //formata
            $nome = $current->nome;
            $descricao = $current->descricao ?? 'Nenhuma descrição';
            $vencimento = formata_data($current->vencimento ?? '0000-00-00');
            $previsto = formata_numero($current->valor_atualizado ?? 0);
            $executado = formata_numero($current->valor_recebido ?? 0);
            $saldo = formata_numero($current->saldo ?? 0);
            
            $cor_previsto = ($current->valor_atualizado < 0)? 'negative' : 'positive';
            $cor_executado = ($current->valor_recebido < 0)? 'negative' : 'positive';
            $cor_saldo = ($current->saldo < 0)? 'negative' : 'positive';
            
            //imprime as linhas
            echo "<tr>";
            
            echo "<td class=\"left aligned\">";
            echo '<div class="ui accordion">';
            echo "<div class=\"title\">$nome</div>";
//            echo '<div class="title">';
//            echo '<div class="ui radio checkbox">';
//            echo "<input type='radio' name='item' value=receita_'{$current->cod}' form='resumo'>";
//            echo "<label>$nome</label>";
//            echo '</div>';
//            echo '</div>';
            echo '<div class="content">';
            echo "<p>$descricao</p>";
            echo "<p>Vence em $vencimento</p>";
            echo '<div class="ui icon buttons">';
            echo "<a class='ui green button' href='index.php?acao=listar-previsao-receita&receita={$current->cod}'><i class='hourglass full icon'></i>Previsão</a>";
            echo "<a class='ui red button' href='index.php?acao=listar-recebimento-receita&receita={$current->cod}'><i class='signal icon'></i>Recebimentos</a>";
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
            
            $receitas->next();
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