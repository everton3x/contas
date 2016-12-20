<div class="ui icon error message">
    <i class="warning sign icon"></i>
    <div class="content">
        <div class="header">
            Erros detectados!
        </div>
        <ul class="list">
            <?php
            while ($errors->valid()) {
                echo "<li>{$errors->current()}</li>";
                $errors->next();
            }
            ?>
        </ul>
    </div>

</div>