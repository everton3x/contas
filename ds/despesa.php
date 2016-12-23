<?php

class Despesa {
    
    protected $db;
    
    protected $cod = 0;
    
    protected $mes;
    
    protected $nome;
    
    protected $descricao;
    
    protected $mp;
    
    protected $valor_inicial;
    
    protected $alteracoes;
    
    protected $valor_atualizado;
    
    protected $valor_gasto;
    
    protected $saldo_gastar;
    
    protected $vencimento;

    protected $valor_pago;

    protected $saldo_pagar;
    
    public function __construct(PDO $db, int $cod = null, int $mes = null, string $nome = null, string $descricao = null, float $valor = null, string $vencimento = null) {
        try{
            $this->db = $db;
        
        if(is_null($cod)){
            //cria uma nova despesa
            $this->save($this->insert($mes, $nome, $descricao, $valor, $vencimento));
            $this->cod = $this->db->lastInsertId();
            $this->load();
            
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
            
            $query = $this->db->query("SELECT * FROM despesas WHERE cod = {$this->cod}");
            
            if($query instanceof PDOStatement){
                foreach ($query as $row){
                    $this->mes = $row['mes'];
                    $this->nome = $row['nome'];
                    $this->descricao = $row['descricao'];
                    $this->valor_inicial = $row['valor_inicial'];
                    $this->alteracoes = $this->alteracoesTotal();
                    $this->valor_atualizado = $this->valor_inicial + $this->alteracoes;
                    $this->valor_gasto = $this->gastoTotal();
                    $this->saldo_gastar = $this->valor_atualizado - $this->valor_gasto;
                    $this->valor_pago = $this->pagoTotal();
                    $this->saldo_pagar = $this->valor_gasto - $this->valor_pago;
                    $this->vencimento = ($row['vencimento'])? $row['vencimento'] : '0000-00-00';
                }
            }else{
                throw new PDOException("Não foi possível retornar dados da despesa código {$this->cod}!");
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
                
            case 'valor_gasto':
                return $this->valor_gasto;
                
            case 'saldo_gastar':
                return $this->saldo_gastar;
            
            case 'valor_pago':
                return $this->valor_pago;
                
            case 'saldo_pagar':
                return $this->saldo_pagar;
                
                
            case 'vencimento':
                return $this->vencimento;
                
            case 'recebido':
                return $this->recebido;
                
            default :
                throw new OutOfBoundsException("Atributo $attr inválido!");
        }
    }
    
    public static function listarDespesas(int $mes) : ArrayIterator {
        try{
            global $db;
            
            $query = $db->query("SELECT * FROM despesas WHERE mes = $mes");
            
//            var_dump($query);
            
            $lista = [];
            
            foreach ($query as $row){
                $lista[$row['cod']] = new Despesa($db, $row['cod']);
            }
            
            return new ArrayIterator($lista);
            
            
        } catch (Exception $ex) {
            throw $ex;
        }
          
    }
    
    protected function insert(int $mes, string $nome, string $descricao, float $valor_inicial, string $vencimento) : PDOStatement {
//        $valor_inicial = round($valor_inicial, 2);
        $statement = $this->db->prepare("INSERT INTO despesas(mes, nome, descricao, valor_inicial, vencimento) VALUES(:mes, :nome, :descricao, :valor_inicial, :vencimento)");
        $statement->bindParam(':mes', $mes, PDO::PARAM_STR);
        $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
        $statement->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $statement->bindParam(':valor_inicial', $valor_inicial, PDO::PARAM_STR);
        $statement->bindParam(':vencimento', $vencimento, PDO::PARAM_STR);
        
        return $statement;
    }
    
    protected function save(PDOStatement $statement) {
        $this->db->beginTransaction();
        $statement->execute();
        
        if($this->db->commit()){
            if($this->cod = 0){
                $this->cod = $this->db->lastInsertId();
            }
            $this->load();
            return true;
        }else{
            throw new PDOException($this->db->errorInfo());
        }
    }
    
    protected function alteracoesTotal() : float {
        $statement = $this->db->prepare("SELECT SUM(valor) AS total FROM previsao_despesa WHERE despesa = :cod");
        $statement->bindParam(':cod', $this->cod);
        
        $statement->execute();
        
        return (float) $statement->fetchColumn();
        
    }
    
    public function gastoTotal() : float {
        $statement = $this->db->prepare("SELECT SUM(valor) AS total FROM gasto WHERE despesa = :cod");
        $statement->bindParam(':cod', $this->cod);
        
        $statement->execute();
        
        return (float) $statement->fetchColumn();
        
    }
    
    protected function pagoTotal() : float {
        $statement = $this->db->prepare("SELECT SUM(valor) AS total FROM gasto WHERE despesa = :cod AND pago != ''");
        $statement->bindParam(':cod', $this->cod);
//        echo $this->cod;
        $statement->execute();
//        echo $statement->rowCount();
        return (float) $statement->fetchColumn();
        
    }
    
    public function alteracoes() : ArrayIterator {
        $statement = $this->db->prepare("SELECT * FROM previsao_despesa WHERE despesa = :cod");
        $statement->bindParam(':cod', $this->cod);
        
        $query = $statement->execute();
        
        return new ArrayIterator($statement->fetchAll(PDO::FETCH_ASSOC));
    }
    
    public function gastos() : ArrayIterator {
        $statement = $this->db->prepare("SELECT * FROM gasto WHERE despesa = :cod");
        $statement->bindParam(':cod', $this->cod);
        
        $query = $statement->execute();
        
        return new ArrayIterator($statement->fetchAll(PDO::FETCH_ASSOC));
    }
    
    public function salvaAlteracao(int $despesa, string $data, float $valor, string $descricao) : bool {
        
        $statement = $this->db->prepare("INSERT INTO previsao_despesa(data, valor, descricao, despesa) VALUES(:data, :valor, :descricao, :despesa)");
        $statement->bindParam(':data', $data, PDO::PARAM_STR);
        $statement->bindParam(':valor', $valor);
        $statement->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $statement->bindParam(':despesa', $despesa, PDO::PARAM_INT);
        
        $this->save($statement);
        
        return true;
    }
    
    public function gastar(int $despesa, int $mp, string $data, float $valor, string $descricao) : bool {
        
        $statement = $this->db->prepare("INSERT INTO gasto(despesa, data, valor, descricao, mp) VALUES(:despesa, :data, :valor, :descricao, :mp)");
        $statement->bindParam(':data', $data, PDO::PARAM_STR);
        $statement->bindParam(':valor', $valor);
        $statement->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $statement->bindParam(':despesa', $despesa, PDO::PARAM_INT);
        $statement->bindParam(':mp', $mp, PDO::PARAM_INT);
        
        $this->save($statement);
        
        return true;
    }
    
    public function pagar(int $gasto, string $data) : bool {
        
        $statement = $this->db->prepare("UPDATE gasto SET pago = :pago WHERE cod = :gasto");
        $statement->bindParam(':pago', $data, PDO::PARAM_STR);
        $statement->bindParam(':gasto', $gasto, PDO::PARAM_INT);
        
        $this->save($statement);
        
        return true;
    }
    
    public static function despesas() : ArrayIterator {
        global $db;
        $statement = $db->prepare("SELECT nome, COUNT(cod) AS contagem FROM despesas GROUP BY nome ORDER BY nome ASC");
        $statement->execute();
        
        return new ArrayIterator($statement->fetchAll(PDO::FETCH_ASSOC));
    }
    
    public static function totaisPorMP(int $mp, int $mes) : array {
        global $db;
        $dados = [];
        
        /*
         * gasto
         */
        $s = $db->prepare("SELECT SUM(gasto.valor) as total FROM gasto, despesas WHERE gasto.despesa = despesas.cod AND despesas.mes = :mes AND mp = :mp");
        $s->bindParam(':mp', $mp, PDO::PARAM_INT);
        $s->bindParam(':mes', $mes, PDO::PARAM_INT);
        if($s->execute()){
            foreach ($s->fetchAll(PDO::FETCH_ASSOC) as $row){
                $dados['gasto'] = $row['total'];
            }
        }else{
            $dados['gasto'] = 0;
        }
        
        /*
         * pago
         */
        $s = $db->prepare("SELECT SUM(gasto.valor) as total FROM gasto, despesas WHERE gasto.despesa = despesas.cod AND despesas.mes = :mes AND mp = :mp AND (gasto.pago NOT LIKE '' OR gasto.pago IS NOT NULL)");
        $s->bindParam(':mp', $mp, PDO::PARAM_INT);
        $s->bindParam(':mes', $mes, PDO::PARAM_INT);
        if($s->execute()){
            foreach ($s->fetchAll(PDO::FETCH_ASSOC) as $row){
                $dados['pago'] = $row['total'];
            }
        }else{
            $dados['pago'] = 0;
        }
        
        return $dados;
    }
}