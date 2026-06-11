<?php
namespace PharmaFEFO\Config;

use PDO;
use PDOException;

class Database {
    private $host = "localhost";
    private $db_name = "pharmafefo";
    private $username = "root";
    private $password = "";    
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
             $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4",
                $this->username,
                $this->password
            );
            
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
             $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
        } catch(PDOException $exception) {
            echo "Erreur de connexion à la base de données : " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>