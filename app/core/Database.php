<?php

class Database{
    public $dbh;
    public $stmt;

    // localhost
    // private $db_host = 'localhost';
    // private $db_name = 'db_tgadget';
    // private $db_user = 'root';
    // private $db_pass = '';
    private $db_host = 'containers-us-west-37.railway.app';
    private $db_name = 'railway';
    private $db_user = 'root';
    private $db_pass = 'zaVeco3YvfCZbKeEP7zy';
    private $db_port = '7003';

    public function __construct()
    {
        $dsn = "mysql:host=$this->db_host;port=$this->db_port;dbname=$this->db_name";
        
        $option = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES latin1 COLLATE latin1_general_ci"
        ];

        try{
            $this->dbh = new PDO($dsn,$this->db_user,$this->db_pass,$option);
        }
        catch(PDOException $e){
            header('Content-Type: application/json');
            http_response_code(500);
            $response = [
                "status"  => 500,
                "message" => $e->getMessage(),
            ];

            echo json_encode($response);
            die;
        }
    }

    public function query($query){
        $this->stmt = $this->dbh->prepare($query);
    }

    public function bind($param,$value,$type = null){
        if(is_null($type)){
            switch(true){
                case is_int($value) :
                    $type = PDO::PARAM_INT;
                break;
                case is_bool($value) :
                    $type = PDO::PARAM_BOOL;
                break;
                case is_null($value) : 
                    $type = PDO::PARAM_NULL;
                break;
                default : 
                    $type = PDO::PARAM_STR;
                break;                    
            }
        }
        
        $this->stmt->bindValue($param,$value,$type);
    }

    public function execute(){
        return $this->stmt->execute();
    }
    
    public function multiResult(){
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function singleResult(){
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function rowCount(){
        return $this->stmt->rowCount();
    }
}

?>