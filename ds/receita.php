<?php

class Receita {
    
    protected $db;
    
    protected $cod;
    
    protected $mes;
    
    protected $nome;
    
    protected $descricao;
    
    protected $valor_inicial;
    
    protected $alteracoes;
    
    protected $valor_atualizado;
    
    protected $valor_recebido;
    
    protected $saldo;
    
    protected $vencimento;

    protected $recebido;
    
    public function __construct(PDO $db, int $cod = null, int $mes = null, string $nome = null, string $descricao = null, float $valor = null, string $vencimento = null/*, string $recebido = null*/) {
        try{
            $this->db = $db;
        
        if(is_null($cod)){
            //cria uma nova receita
            $this->save($this->insert($mes, $nome, $descricao, $valor, $vencimento));
            
//            //salva recebimento
//            if(!is_null($recebido) || $recebido !== false){
//                $this->salvaRecebimento($this->cod, $recebido, $this->valor_inicial, "Recebimento automatizado!");
//            }
        }else{
            $this->cod = $cod;
            $this->load();
        }
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    protected function load(){
        try{
            
            $query = $this->db->query("SELECT * FROM receitas WHERE cod = {$this->cod}");
            
            if($query instanceof PDOStatement){
                foreach ($query as $row){
                    $this->mes = $row['mes'];
                    $this->nome = $row['nome'];
                    $this->descricao = $row['descricao'];
                    $this->valor_inicial = $row['valor_inicial'];
                    $this->alteracoes = $this->alteracoesTotal();
                    $this->valor_atualizado = $this->valor_inicial + $this->alteracoes;
                    $this->valor_recebido = $this->recebimentostotal();
                    $this->saldo = $this->valor_atualizado - $this->valor_recebido;
                    $this->vencimento = ($row['vencimento'])? $row['vencimento'] : '0000-00-00';
                }
            }else{
                throw new PDOException("Não foi possível retornar dados da receita código {$this->cod}!");
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    public function __get(string $attr) {
        switch ($attr){
            case 'cod':
                return $this->cod;
                
            case 'mes':
                return $this->mes;
                
            case 'nome':
                return $this->nome;
                
            case 'descricao':
                return $this->descricao;
                
            case 'valor_inicial':
                return $this->valor_inicial;
                
            case 'alteracoes':
                return $this->alteracoes;
                
            case 'valor_atualizado':
                return $this->valor_atualizado;
                
            case 'valor_recebido':
                return $this->valor_recebido;
                
            case 'saldo':
                return $this->saldo;
                
                
            case 'vencimento':
                return $this->vencimento;
                
            case 'recebido':
                return $this->recebido;
                
            default :
                throw new OutOfBoundsException("Atributo $attr inválido!");
        }
    }
    
    public static function listarReceitas(int $mes) : ArrayIterator {
        try{
            global $db;
            
            $query = $db->query("SELECT * FROM receitas WHERE mes = $mes");
            
//            var_dump($query);
            
            $lista = [];
            
            foreach ($query as $row){
                $lista[$row['cod']] = new Receita($db, $row['cod']);
            }
            
            return new ArrayIterator($lista);
            
            
        } catch (Exception $ex) {
            throw $ex;
        }
          
    }
    
//    protected function insert(int $mes, string $receita, string $descricao, float $valor_inicial, string $vencimento, string $recebido) : PDOStatement {
    protected function insert(int $mes, string $receita, string $descricao, float $valor_inicial, string $vencimento) : PDOStatement {
        $statement = $this->db->prepare("INSERT INTO receitas(mes, nome, descricao, valor_inicial, vencimento) VALUES(:mes, :nome, :descricao, :valor_inicial, :vencimento)");
        $statement->bindParam(':mes', $mes, PDO::PARAM_STR);
        $statement->bindParam(':nome', $receita, PDO::PARAM_STR);
        $statement->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $statement->bindParam(':valor_inicial', $valor_inicial, PDO::PARAM_STR);
        $statement->bindParam(':vencimento', $vencimento, PDO::PARAM_STR);
        
        return $statement;
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
    
    protected function alteracoesTotal() : float {
        $statement = $this->db->prepare("SELECT SUM(valor) AS total FROM previsao_receita WHERE receita = :cod");
        $statement->bindParam(':cod', $this->cod);
        
        $statement->execute();
        
        return (float) $statement->fetchColumn();
        
    }
    
    public function recebimentosTotal() : float {
        $statement = $this->db->prepare("SELECT SUM(valor) AS total FROM recebimentos WHERE receita = :cod");
        $statement->bindParam(':cod', $this->cod);
        
        $statement->execute();
        
        return (float) $statement->fetchColumn();
        
    }
    
    public function alteracoes() : ArrayIterator {
        $statement = $this->db->prepare("SELECT * FROM previsao_receita WHERE receita = :cod");
        $statement->bindParam(':cod', $this->cod);
        
        $query = $statement->execute();
        
        return new ArrayIterator($statement->fetchAll(PDO::FETCH_ASSOC));
    }
    
    public function recebimentos() : ArrayIterator {
        $statement = $this->db->prepare("SELECT * FROM recebimentos WHERE receita = :cod");
        $statement->bindParam(':cod', $this->cod);
        
        $query = $statement->execute();
        
        return new ArrayIterator($statement->fetchAll(PDO::FETCH_ASSOC));
    }
    
    public function salvaAlteracao(int $receita, string $data, float $valor, string $descricao) : bool {
        
        $statement = $this->db->prepare("INSERT INTO previsao_receita(data, valor, descricao, receita) VALUES(:data, :valor, :descricao, :receita)");
        $statement->bindParam(':data', $data, PDO::PARAM_STR);
        $statement->bindParam(':valor', $valor);
        $statement->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $statement->bindParam(':receita', $receita, PDO::PARAM_INT);
        
        $this->save($statement);
        
        return true;
    }
    
    public function salvaRecebimento(int $receita, string $data, float $valor, string $descricao) : bool {
        
        $statement = $this->db->prepare("INSERT INTO recebimentos(data, valor, descricao, receita) VALUES(:data, :valor, :descricao, :receita)");
        $statement->bindParam(':data', $data, PDO::PARAM_STR);
        $statement->bindParam(':valor', $valor);
        $statement->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $statement->bindParam(':receita', $receita, PDO::PARAM_INT);
        
        $this->save($statement);
        
        return true;
    }
    
    public static function receitas() : ArrayIterator {
        global $db;
        $statement = $db->prepare("SELECT nome, COUNT(cod) AS contagem FROM receitas GROUP BY nome ORDER BY nome ASC");
        $statement->execute();
        
        return new ArrayIterator($statement->fetchAll(PDO::FETCH_ASSOC));
    }
    
    public static function analitico(int $mes) : ArrayIterator {
        global $db;
        
        $dados = [];
        
        /*
         * receitas
         */
        $s = $db->prepare("SELECT * FROM receitas WHERE mes = :mes");
        $s->bindParam(':mes', $mes);
        if($s->execute()){
//            foreach($s->fetchAll(PDO::FETCH_ASSOC) as $row){
//                
//            }
            $dados = $s->fetchAll(PDO::FETCH_ASSOC);
        }
        
        
        return new ArrayIterator($dados);
    }
    
    public static function receitaTotalPrevista(int $mes) : float {
        global $db;
        
        $p = $db->prepare("SELECT SUM(valor_inicial) as total FROM receitas WHERE mes = :mes");
        $p->bindParam(':mes', $mes);
        $p->execute();
        $previsto = $p->fetchColumn(0);
        
        $a = $db->prepare("SELECT SUM(previsao_receita.valor) as total FROM previsao_receita, receitas WHERE receitas.mes = :mes AND previsao_receita.receita = receitas.cod");
        $a->bindParam(':mes', $mes);
        $a->execute();
        $alteracoes = $p->fetchColumn(0);
        
        return (float) $previsto + $alteracoes;
    }
}