<form class="ui form" method="post" action="index.php?acao=salvar-despesa-parcelas">

    <h4 class="ui dividing header">Nova previsão de despesa</h4>

    <div class="ui floating dropdown labeled search icon button" id="despesa">
        <input type="hidden" name="nome" required="">
        <i class="cloud upload icon"></i>
        <span class="text">Selecione a despesa</span>
        <div class="menu">
            <?php
            $lista = Despesa::despesas();

            while ($lista->valid()) {
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

    <div class="required field">
        <label>Mês inicial</label>
        <input type="month" name="mes" required="">
    </div>

    <div class="required field">
        <label>Parcelas</label>
        <input type="number" name="parcelas" required="" step="1" min="1" value="0">
    </div>

    <div class="required field">
        <label>Valor total</label>
        <input type="number" name="total" required="" step="0.01">
    </div>

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