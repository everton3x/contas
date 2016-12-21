<?php

class MeioPagamento {
    
    protected $db = null;
    
    protected $cod = null;
    protected $mp = null;
    
    public function __construct(PDO $db, int $cod = null, string $mp = null) {
        $this->db = $db;
        
        if(!is_null($cod)){
            //carrega dados
            $this->cod = $cod;
            $this->load();
        }else{
            //salva
            $this->novo($mp);
        }
    }
    
    protected function save(PDOStatement $statement) {
        $this->db->beginTransaction();
        $statement->execute();
        
        if($this->db->commit()){
            $this->cod = $this->db->lastInsertId();
            $this->load();
            return true;
        }else{
            throw new PDOException($this->db->errorInfo());
        }
    }
    
    protected function novo(string $mp){
        $statement = $this->db->prepare("INSERT INTO meios_pagamento(mp) VALUES(:mp)");
        $statement->bindParam(':mp', $mp, PDO::PARAM_STR);
        $this->save($statement);
        $this->cod = $this->db->lastInsertId();
        $this->load();
    }
    
    public function load() {
        if($this->cod == false && $this->cod === null){
            throw new InvalidArgumentException('Código não defindio para o meio de pagamento!');
        }
        
        $statement = $this->db->prepare("SELECT * FROM meios_pagamento WHERE cod = :cod");
        $statement->bindParam(':cod', $this->cod);
        $statement->execute();
        while($row = $statement->fetch()){
            $this->mp = $row['mp'];
        }
    }

    public function __get(string $name) {
        switch ($name){
            case 'cod':
                return $this->cod;
            case 'mp':
                return $this->mp;
            default :
                throw new InvalidArgumentException("Campo $name inválido!");
        }
    }
    
    public static function listar() : ArrayIterator {
        global $db;
        
        $statement = $db->prepare("SELECT * FROM meios_pagamento ORDER BY mp ASC");
        $statement->execute();
        
        return new ArrayIterator($statement->fetchAll(PDO::FETCH_ASSOC));
    }
    
    public static function existe(int $cod) : int {
        global $db;
        
        $s = $db->prepare("SELECT * FROM meios_pagamento WHERE cod = :cod");
        $s->bindParam(':cod', $cod, PDO::PARAM_INT);
        $s->execute();
        return (int) $s->rowCount();
    }
}