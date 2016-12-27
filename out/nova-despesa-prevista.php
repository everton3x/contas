<form class="ui form" action="index.php?acao=salvar-despesa-prevista" method="post" id="previsao">
    <h4 class="ui dividing header">Nova previsão de despesa</h4>

    <div class="ui action input" style="min-width: 0px; width: 100px;">
        <input type="number" name="parcelas" min="1" step="1" value="<?= $parcelas; ?>" autofocus="">
        <button class="ui labeled icon button" type="submit" form="previsao" formaction="index.php?acao=nova-despesa-prevista" formnovalidate="">
            <i class="cloud icon"></i>
            Parcelas
        </button>
    </div>

    <div class="ui orange inverted segment">

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


        <?php
        for ($p = 1; $p <= $parcelas; $p++) {
            $cor = (($p % 2) === 0) ? 'blue' : 'teal';

            echo "<div class='ui $cor inverted segment'>";
            echo "<div class=\"required field\">
        <label>Mês ($p/$parcelas)</label>
        <input type=\"month\" name=\"mes[$p]\" required value=\"" . date('Y-m') . "\">
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
        <label>Gasto em ($p/$parcelas)</label>
        <input type=\"date\" name=\"gasto[$p]\">
    </div>";

            echo "<div class=\"field\">
        <label>Pago em ($p/$parcelas)</label>
        <input type=\"date\" name=\"pago[$p]\">
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
    $('#despesa').dropdown({
        allowAdditions: true
    });

    $('#mp').dropdown({
        allowAdditions: false
    });
</script>