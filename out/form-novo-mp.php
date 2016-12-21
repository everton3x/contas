<form class="ui form" action="index.php?acao=salvar-mp" method="post">
    <h4 class="ui dividing header">Novo Meio de Pagamento</h4>
    
    <div class="required field">
        <label>Meio de Pagamento</label>
        <input type="text" name="mp" required="" autofocus="">
    </div>
    
    <div class="ui buttons">
        <button class="ui positive button" type="submit">Salvar</button>
        <div class="or" data-text="ou"></div>
        <button class="ui button" formaction="index.php" formmethod="get" formnovalidate="">Cancelar</button>
        
    </div>
</form>