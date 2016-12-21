<form class="ui form" action="index.php?acao=salvar-gasto" method="post">
    <h4 class="ui dividing header">Novo Gasto</h4>


    <div class="required field">
        <label>Data</label>
        <input type="date" name="data" required="" value="<?= date('Y-m-d'); ?>" autofocus="">
    </div>

    <div class="required field">
        <label>Valor</label>
        <input type="number" name="valor" required="" step="0.01">
    </div>

    <div class="ui floating dropdown labeled search icon button" id="mp">
        <input type="hidden" name="mp" required="">
        <i class="cloud upload icon"></i>
        <span class="text">Selecione o meio de pagamento</span>
        <div class="menu">
            <?php
            $lista = MeioPagamento::listar();

            while ($lista->valid()) {
                $item = $lista->current();
                echo "<div class=\"item\" data-value='{$item['cod']}' data-value='{$item['mp']}'>{$item['mp']}</div>";
                $lista->next();
            }
            ?>

        </div>
    </div> 

    <div class="field">
        <label>Descrição</label>
        <input type="text" name="descricao">
    </div>
    
    <div class="field">
        <label>Pago em</label>
        <input type="date" name="pago">
    </div>

    <div class="ui buttons">
        <button class="ui positive button" type="submit">Salvar</button>
        <div class="or" data-text="ou"></div>
        <button class="ui button" formaction="index.php" formmethod="get" formnovalidate="">Cancelar</button>

    </div>

    <input type="hidden" name="despesa" value="<?= $despesa_cod; ?>">
</form>

<script>
    $('#mp').dropdown({
        allowAdditions: false
    });
</script>