<?php
namespace PharmaFEFO\Config;

use PDO;
use PDOException;

class Database {
   private $host = "sql113.byetcluster.com"; 
    private $db_name = "if0_42229521_pharmafefo"; 
    private $username = "if0_42229521";
    private $password = "2MlJEtB72MukDhf";  
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
             die("Erreur de connexion à la base de données. Veuillez réessayer plus tard.");
        }

        return $this->conn;
    }
}
?>