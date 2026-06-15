<?php
namespace PharmaFEFO\Config;

use PDO;
use PDOException;

class Database {
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            // Kanjebdo les infos mn l'environnement
            $host = $_ENV['DB_HOST'] ?? 'localhost';
            $db_name = $_ENV['DB_NAME'] ?? 'pharmafefo';
            $username = $_ENV['DB_USER'] ?? 'root';
            $password = $_ENV['DB_PASS'] ?? '';

            $this->conn = new PDO(
                "mysql:host=" . $host . ";dbname=" . $db_name . ";charset=utf8mb4",
                $username,
                $password
            );
            
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
        } catch(PDOException $exception) {
            // Gestion des erreurs selon l'environnement (Kima mtloub f l'brief)
            if (isset($_ENV['APP_ENV']) && $_ENV['APP_ENV'] === 'production') {
                echo "Erreur 500 : Problème de connexion au serveur.";
            } else {
                echo "Erreur de connexion : " . $exception->getMessage();
            }
        }

        return $this->conn;
    }
}
?>