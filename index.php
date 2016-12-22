<?php
require 'init.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

        <title>Contas 2.0</title>

        <link rel="stylesheet" href="vendor/semantic/semantic.css">

        <script type="text/javascript" src="vendor/jquery/jquery-3.1.1.min.js"></script>
        <script type="text/javascript" src="vendor/semantic/semantic.min.js"></script>
    </head>
    <body>
        <!--sidebar-->
        <div class="ui visible top horizontal inverted sidebar labeled icon fixed menu">
            <a class="item" href="index.php">
                <i class="home icon"></i>
                Resumo
            </a>
            <a class="item" href="index.php?acao=nova-receita-prevista">
                <i class="cloud upload icon"></i>
                Receita
            </a>
            <a class="item" href="index.php?acao=nova-despesa-prevista">
                <i class="cloud download icon"></i>
                Despesa
            </a>

<!--            <a class="item" href="index.php?acao=listar-meios-pagamento">
                <i class="payment icon"></i>
                Meios
            </a>-->
            <a class="item" id="submenu-btn" href="index.php?acao=extras">
                <i class="options icon"></i>
                Mais
            </a>

        </div>
       
        <br>
        <br>
        <div class="pusher">
            <p></p>
            <div class="ui container">

                <?php
                try {
                    $processor = $_GET['acao'] ?? $_POST['acao'] ?? 'resumo';

//            throw new Exception('disparado pelo usuário');
//            strpos();

                    require "proc/$processor.php";
                } catch (Exception $ex) {
                    $errors = new ArrayIterator([
                        "{$ex->getMessage()} em {$ex->getFile()}:{$ex->getLine()}",
                        "{$ex->getTraceAsString()}"
                    ]);

                    require 'out/errors.php';
                }
                ?>
            </div>
        </div>
                <br>
                <br>

    </body> 
</html>
