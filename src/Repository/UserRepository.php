<?php
namespace PharmaFEFO\Repository;

class UserRepository {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function findByEmail($email) {
        $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
      
        return $stmt->fetch(\PDO::FETCH_ASSOC); 
    }
}
?>