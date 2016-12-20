<div class="ui icon positive message">
    <i class="thumbs outline up icon"></i>
    <div class="content">
        <div class="header">
            Tarefa concluída com sucesso!
        </div>
        <ul class="list">
            <?php
            while ($msg->valid()) {
                echo "<li>{$msg->current()}</li>";
                $msg->next();
            }
            ?>
        </ul>
    </div>

</div>