<?php  
include_once 'DB.php';

class Comment {
    private $db;
    private $name;
    private $comment;
    private $status;
    private $camera;
    private $date;
    private $type;
    private $table = "tbl_comments";

    public function __construct(){
        $this->db = new DB();
    }

    public function setData($name, $comment, $status, $camera, $date, $type){
        $this->name = $name;
        $this->comment = $comment;
        $this->status = $status;
        $this->camera = $camera;
        $this->date = $date;
        $this->type = $type;
    }

    public function create() {
        $query = "INSERT INTO $this->table (name, comment, status, camera, date, type, comment_time) VALUES ('$this->name', '$this->comment', '$this->status','$this->camera','$this->date','$this->type', NOW())";
        return $this->db->insert($query);
    }

    public function index() {
        $query = "SELECT * FROM $this->table ORDER BY id DESC";
        return $this->db->select($query);
    }

    public function dateFormat($date) {
        return date('M j, h:i:s a', strtotime($date));
    }
}
?>