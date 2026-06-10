<?php
namespace PharmaFEFO\Config;

use PDO;
use PDOException;

class Database {
    private $host = "localhost";
    private $db_name = "pharmafefo";
    private $username = "root"; // par défaut f XAMPP
    private $password = "";     // par défaut khawi f XAMPP
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            // Création dyal l'instance PDO
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4",
                $this->username,
                $this->password
            );
            
            // Configuration dyal les erreurs bach ybano mzyan (Exception)
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Retourner les résultats sous forme de tableau associatif par défaut
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
        } catch(PDOException $exception) {
            echo "Erreur de connexion à la base de données : " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>