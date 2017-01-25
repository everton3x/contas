<form method="post" class="ui form">
    <div class="six wide fields">
    <div class="field">
        <!--<label>Mês</label>-->
        <input type="month" name="mes" required="" value="<?= $mes;?>">
    </div>
    
<!--    <div class="ui floating dropdown labeled search icon button" id="mp">
        <input type="hidden" name="mp" value="<?= $mp;?>">
        <i class="payment icon"></i>
        <span class="text">Selecione o meio de pagamento</span>
        <div class="menu">
            <div class="item" data-value=''>Todos</div>
            <?php
//            $lista = MeioPagamento::listar();
//
//            while ($lista->valid()) {
//                $item = $lista->current();
//                echo "<div class=\"item\" data-value='{$item['cod']}'>{$item['mp']}</div>";
//                $lista->next();
//            }
            ?>

        </div>
    </div>-->

    <div class="field">
            <!--<label>Meio de Pagamento</label>-->
            <select name="mp">
                <option value="">Todos</option>
            <?php
            $lista = MeioPagamento::listar();

            while ($lista->valid()) {
                $item = $lista->current();
//                echo "<div class=\"item\" data-value='{$item['cod']}' data-value='{$item['mp']}'>{$item['mp']}</div>";
                if($item['cod'] == $mp){
                    echo "<option selected value='{$item['cod']}'>{$item['mp']}</option>";
                }else{
                    echo "<option value='{$item['cod']}'>{$item['mp']}</option>";
                }
                $lista->next();
            }
            ?>
            </select>
        </div>
    

    <button type="submit" class="ui green icon button">
        <i class="search icon"></i>
    </button>
</div>
</form>

<script>
    $('#mp').dropdown({
        allowAdditions: false
    });
</script>