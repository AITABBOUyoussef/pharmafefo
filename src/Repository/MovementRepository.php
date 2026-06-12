<?php
namespace PharmaFEFO\Repository;

class MovementRepository {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllMovements() {
        $query = "SELECT 
                    m.type, 
                    m.quantity, 
                    m.movement_date, 
                    m.note,
                    u.name AS user_name,
                    b.batch_number,
                    p.designation AS product_name
                  FROM stock_movements m
                  JOIN users u ON m.user_id = u.id
                  JOIN batches b ON m.batch_id = b.id
                  JOIN products p ON b.product_id = p.id
                  ORDER BY m.movement_date DESC";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
?>