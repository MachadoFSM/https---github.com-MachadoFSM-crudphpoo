<?php

namespace App\Db;

use \PDO;
use \PDOException;

class Database{

    /*
    Host de conexão com o banco de dados
    @var string
    */
    const HOST = 'localhost:3309';

    /*
    Nome do banco de dados
    @var string
    */ 
    const NAME = 'wdev_vagas';

    /*
    Usuário do banco
    @var string
    */
    const USER = 'felipe';

    /*
    Senha de acesso ao banco de dados
    @var string
    */
    const PASS = '123qwe';

    /*
    Nome da tabela a ser manipulada
    @var string
    */
    private $table;

    /*
    Instancia de conexão com o banco de dados
    @var PDO
    */
    private $connection;

    /*
    Define a tabela e instancia a conexão
    */
    public function __construct($table = null){
        $this->table = $table;
        $this->setConnection();
    }

    /*
    Método responsável por criar uma conexão com o banco de dados
    */
    private function setConnection(){
        try{
            $this->connection = new PDO('mysql:host=' . self::HOST . ';dbname=' . self::NAME,self::USER,self::PASS);
            //configuração para o PDO criar uma exceção caso algo de errado
            $this->connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            //OBS: corrigir essa messagem para retornar em um arquivo de logs
            die('ERROR: ' . $e->getMessage());
        }
    }

    /*
    Método responsável por executar queries dentro do banco de dados
    @param string $query
    @param array $params
    @return PDOtatement
    */
    public function execute($query,$params = []){
        try{
            $statement = $this->connection->prepare($query);
            $statement->execute($params);
            return $statement;
        }catch(PDOException $e){
            //OBS: corrigir essa messagem para retornar em um arquivo de logs
            die('ERROR: ' . $e->getMessage());
        }
    }

    /*
    Método responsável por inserir dados no banco
    @param array $values [ field => value ]
    @return ID inserido
    */
    public function insert($values){
        //Dados da query
        $fields = array_keys($values);
        $binds  = array_pad([],count($fields),'?');

        //Monta a query
        $query = 'INSERT INTO '.$this->table.' ('.implode(',',$fields).') VALUES ('.implode(',',$binds).')';

        //Executa o insert
        $this->execute($query,array_values($values));
        //Retorna o ID inserido
        return $this->connection->lastInsertId();
    }

    /*
    Método de consulta no banco
    @param string $where
    @param string $order
    @param string $limit
    @return PDOStatement
    */
    public function select($where = null, $order = null, $limit = null, $fields = '*'){
      //Dados da query
      $where = strlen($where) ? 'WHERE '.$where : '';
      $order = strlen($order) ? 'ORDER BY '.$order : '';
      $limit = strlen($limit) ? 'LIMIT '.$limit : '';
      
      //Monta query
      $query = 'SELECT '.$fields.' FROM '.$this->table.' '.$where.' '.$order.' '.$limit;

      //Executa a query
      return $this->execute($query);
    }
}