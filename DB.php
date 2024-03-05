<?php 
include_once 'configment.php';

class DB {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    public $link;
    public $error;
    
    public function __construct() {
        $this->connectDB();
    }
    
    private function connectDB() {
        $this->link = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
        if ($this->link->connect_error) {
            die("Connection Fail: " . $this->link->connect_error);
        }
    }

    public function insert($query) {
        $insert_row = $this->link->query($query) or die($this->link->error.__LINE__);
        return $insert_row;
    }

    public function select($query) {
        $result = $this->link->query($query) or die($this->link->error.__LINE__);
        return $result;
    }
}
?>