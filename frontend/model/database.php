<?php
class Database{
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "duan";
    private $conn;

    public static $instance;
    public static function getInstance(){
        if(!self::$instance){
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function __construct(){
        try{
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->database", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            error_log("Connection failed: " . $e->getMessage()); // Log lỗi kết nối
            echo "Connection failed: ".$e->getMessage();
        }
    }

    // Dùng cho câu lệnh SQL dạng INSERT, UPDATE hoặc DELETE
    public function execute($sql,$param = []){
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($param);
    }
    //Dùng cho câu lệnh SELECT
    public function getAll($sql){
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getOne($sql){
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Hàm public để lấy kết nối PDO
    public function getConnection() {
        return $this->conn;
    }
}
?>
