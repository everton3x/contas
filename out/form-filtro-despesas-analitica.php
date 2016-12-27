<form method="post" class="ui form">
    <div class="ui input">
        <input type="month" name="mes" required="" value="<?= $mes;?>">
    </div>
    
    <div class="ui floating dropdown labeled search icon button" id="mp">
        <input type="hidden" name="mp" value="<?= $mp;?>">
        <i class="payment icon"></i>
        <span class="text">Selecione o meio de pagamento</span>
        <div class="menu">
            <div class="item" data-value=''>Todos</div>
            <?php
            $lista = MeioPagamento::listar();

            while ($lista->valid()) {
                $item = $lista->current();
                echo "<div class=\"item\" data-value='{$item['cod']}'>{$item['mp']}</div>";
                $lista->next();
            }
            ?>

        </div>
    </div>
    <button type="submit" class="ui green icon button">
        <i class="search icon"></i>
    </button>
</form>

<script>
    $('#mp').dropdown({
        allowAdditions: false
    });
</script>