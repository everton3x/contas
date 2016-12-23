<?php

class Resultado {
    public static function anterior(PDO $db, int $mes) : float {
        /*
         * soma recebimentos
         */
        $recebimentos = 0;
        $r = $db->prepare("SELECT cod FROM receitas WHERE mes < :mes");
        $r->bindParam(':mes', $mes);
        $r->execute();
        foreach ($r->fetchAll(PDO::FETCH_ASSOC) as $row){
            $o = new Receita($db, $row['cod']);
//            $recebimentos += $o->recebimentosTotal();
            $recebimentos += $o->valor_atualizado;
        }
        
        /*
         * soma gastos
         */
        $gastos = 0;
        $g = $db->prepare("SELECT cod FROM despesas WHERE mes < :mes");
        $g->bindParam(':mes', $mes);
        $g->execute();
        foreach ($g->fetchAll(PDO::FETCH_ASSOC) as $row){
            $o = new Despesa($db, $row['cod']);
//            $gastos += $o->gastoTotal();
            $gastos += $o->valor_atualizado;
        }
        
        return (float) ((float) $recebimentos - (float) $gastos);
    }
    
    public static function atual(PDO $db, int $mes) : float {
        /*
         * soma recebimentos
         */
        $recebimentos = 0;
        $r = $db->prepare("SELECT cod FROM receitas WHERE mes = :mes");
        $r->bindParam(':mes', $mes);
        $r->execute();
        foreach ($r->fetchAll(PDO::FETCH_ASSOC) as $row){
            $o = new Receita($db, $row['cod']);
            $recebimentos += $o->valor_atualizado;
        }
        
        /*
         * soma gastos
         */
        $gastos = 0;
        $g = $db->prepare("SELECT cod FROM despesas WHERE mes = :mes");
        $g->bindParam(':mes', $mes);
        $g->execute();
        foreach ($g->fetchAll(PDO::FETCH_ASSOC) as $row){
            $o = new Despesa($db, $row['cod']);
            $gastos += $o->valor_atualizado;
        }
        
        return (float) ((float) $recebimentos - (float) $gastos);
    }
}