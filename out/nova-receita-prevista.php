<form class="ui form" action="index.php?acao=salvar-receita-prevista" method="post" id="previsao">
    <h4 class="ui dividing header">Nova previsão de receita</h4>
<!--    <div class="required field">
        <label>Mês</label>
        <input type="month" name="mes" required="" autofocus="" value="<?=date('Y-m');?>">
    </div>-->

    <div class="ui action input">
        <input type="number" name="parcelas" min="1" step="1" value="<?=$parcelas;?>" autofocus="">
        <button class="ui labeled icon button" type="submit" form="previsao" formaction="index.php?acao=nova-receita-prevista" formnovalidate="">
            <i class="cloud icon"></i>
            Parcelas
        </button>
    </div>
    
<div class="ui orange inverted segment">
<!--    <div class="required field">
        <label>Receita</label>
        <input type="text" name="nome" required="" autocomplete="on">
    </div>-->
<div class="ui floating dropdown labeled search icon button">
    <input type="hidden" name="nome" required="">
    <i class="cloud upload icon"></i>
    <span class="text">Selecione a receita</span>
    <div class="menu">
<!--        <div class="item">Arabic</div>
        <div class="item">Chinese</div>-->
        <?php
        $lista = Receita::receitas();
        
        while($lista->valid()){
            $item = $lista->current();
            echo "<div class=\"item\">{$item['nome']}</div>";
            $lista->next();
        }
        ?>
        
    </div>
</div>
    
    <div class="field">
        <label>Descrição</label>
        <input type="text" name="descricao">
    </div>
</div>    
<!--    <div class="field">
        <label>Valor</label>
        <input type="number" name="valor_inicial" step="0.01">
    </div>
    
    <div class="field">
        <label>Vencimento</label>
        <input type="date" name="vencimento">
    </div>
    
    <div class="field">
        <label>Recebido em</label>
        <input type="date" name="recebido">
    </div>-->

    <?php
    
    for($p = 1; $p <= $parcelas; $p++){
        $cor = (($p % 2) === 0)? 'blue' : 'teal';
        
        echo "<div class='ui $cor inverted segment'>";
        echo "<div class=\"required field\">
        <label>Mês ($p/$parcelas)</label>
        <input type=\"month\" name=\"mes[$p]\" required value=\"".date('Y-m')."\">
    </div>";
        
        echo "<div class=\"field\">
        <label>Valor ($p/$parcelas)</label>
        <input type=\"number\" name=\"valor_inicial[$p]\" step=\"0.01\">
    </div>";
        
        echo "<div class=\"field\">
        <label>Vencimento ($p/$parcelas)</label>
        <input type=\"date\" name=\"vencimento[$p]\">
    </div>";
        
        echo "<div class=\"field\">
        <label>Recebido em ($p/$parcelas)</label>
        <input type=\"date\" name=\"recebido[$p]\">
    </div>";
        echo '</div>';
    }
    ?>
    
    <div class="ui buttons">
        <button class="ui positive button" type="submit">Salvar</button>
        <div class="or" data-text="ou"></div>
        <button class="ui button" formaction="index.php" formmethod="get">Cancelar</button>
    </div>
</form>

<script>
    $('.ui.floating.dropdown.labeled.search.icon.button').dropdown({
        allowAdditions: true
    });
</script>