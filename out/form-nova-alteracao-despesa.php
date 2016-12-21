<form class="ui form" action="index.php?acao=salvar-alteracao-despesa" method="post">
    <h4 class="ui dividing header">Nova previsão de despesa</h4>
    
    <div class="required field">
        <label>Data</label>
        <input type="date" name="data" required="" readonly="" value="<?=date('Y-m-d');?>">
    </div>
    
    <div class="required field">
        <label>Valor</label>
        <input type="number" name="valor" required="" step="0.01" autofocus="">
    </div>
    
    <div class="field">
        <label>Descrição</label>
        <input type="text" name="descricao">
    </div>
    
    <div class="ui buttons">
        <button class="ui positive button" type="submit">Salvar</button>
        <div class="or" data-text="ou"></div>
        <button class="ui button" formaction="index.php" formmethod="get" formnovalidate="">Cancelar</button>
        
    </div>
    
    <input type="hidden" name="despesa" value="<?=$despesa_cod;?>">
</form>