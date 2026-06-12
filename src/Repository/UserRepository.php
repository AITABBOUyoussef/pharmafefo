<?php
namespace PharmaFEFO\Repository;

class UserRepository {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Fonction katqelleb 3la l'utilisateur b l'email dyalo
    public function findByEmail($email) {
        $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        // Katred les données dyal l'utilisateur awla false ila malqatoch
        return $stmt->fetch(\PDO::FETCH_ASSOC); 
    }
}
?>