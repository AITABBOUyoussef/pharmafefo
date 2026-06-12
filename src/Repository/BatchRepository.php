<?php
namespace PharmaFEFO\Repository;

use PDO;

class BatchRepository {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

   
    public function getLotsWithCriticality() {
        $query = "
            SELECT 
                b.id,
                b.batch_number, 
                b.expiration_date, 
                b.qty_available,
                p.designation AS product_name,
                DATEDIFF(b.expiration_date, CURDATE()) AS days_to_expire
            FROM batches b 
            
            JOIN products p ON b.product_id = p.id
            WHERE b.status = 'ACTIVE'
            ORDER BY days_to_expire ASC
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $lots = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($lots as &$lot) {
            $days = (int)$lot['days_to_expire'];
            
            if ($days <= 30) {
                $lot['criticality_level'] = 'RED';
                $lot['criticality_label'] = 'Rouge (< 30 jours)';
            } elseif ($days <= 90) {
                $lot['criticality_level'] = 'ORANGE';
                $lot['criticality_label'] = 'Orange (< 90 jours)';
            } else {
                $lot['criticality_level'] = 'GREEN';
                $lot['criticality_label'] = 'Vert (> 6 mois)';
            }
        }

        return $lots;
    }
    
    public function addBatch($product_id, $batch_number, $quantity, $expiration_date) {
        try {
            $this->conn->beginTransaction();

            $queryBatch = "INSERT INTO batches (product_id, batch_number, expiration_date, qty_received, qty_available, status) 
                           VALUES (:product_id, :batch_number, :expiration_date, :quantity, :quantity, 'ACTIVE')";
            
            $stmtBatch = $this->conn->prepare($queryBatch);
            
             $stmtBatch->bindParam(':product_id', $product_id);
            $stmtBatch->bindParam(':batch_number', $batch_number);
            $stmtBatch->bindParam(':expiration_date', $expiration_date);
            $stmtBatch->bindParam(':quantity', $quantity);
            
            $stmtBatch->execute();

             $newBatchId = $this->conn->lastInsertId();

            $queryMovement = "INSERT INTO stock_movements (batch_id, user_id, type, quantity, note) 
                              VALUES (:batch_id, 1, 'ENTRY', :quantity, 'Réception de nouveau lot')";
            
            $stmtMovement = $this->conn->prepare($queryMovement);
            $stmtMovement->bindParam(':batch_id', $newBatchId);
            $stmtMovement->bindParam(':quantity', $quantity);
            
            $stmtMovement->execute();

            $this->conn->commit();
            
            return true;

        } catch (\PDOException $e) {
            $this->conn->rollBack();
            
            echo "Erreur d'insertion : " . $e->getMessage();
            return false;
        }
    }

 
    public function exitStockWithFEFO($product_id, $quantity_requested) {
        try {
            $this->conn->beginTransaction();

            $query = "SELECT id, qty_available 
                      FROM batches 
                      WHERE product_id = :pid AND qty_available > 0 AND status = 'ACTIVE' 
                      ORDER BY expiration_date ASC 
                      FOR UPDATE";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':pid', $product_id);
            $stmt->execute();
            $lots = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            $remaining_qty = $quantity_requested; 

             foreach ($lots as $lot) {
                if ($remaining_qty <= 0) {
                    break;
                }

                $qty_taken = 0; 

                if ($lot['qty_available'] <= $remaining_qty) {
                     $qty_taken = $lot['qty_available'];
                    $remaining_qty -= $qty_taken;
                    
                    $updateStmt = $this->conn->prepare("UPDATE batches SET qty_available = 0, status = 'EMPTY' WHERE id = :id");
                    $updateStmt->bindParam(':id', $lot['id']);
                    $updateStmt->execute();

                } else {
                    $qty_taken = $remaining_qty;
                    $remaining_qty = 0; // Salina jmi3
                    
                    $updateStmt = $this->conn->prepare("UPDATE batches SET qty_available = qty_available - :qty WHERE id = :id");
                    $updateStmt->bindParam(':qty', $qty_taken);
                    $updateStmt->bindParam(':id', $lot['id']);
                    $updateStmt->execute();
                }

                 $movStmt = $this->conn->prepare("INSERT INTO stock_movements (batch_id, user_id, type, quantity, note) 
                                                 VALUES (:batch_id, 1, 'EXIT', :qty, 'Sortie automatique FEFO')");
                $movStmt->bindParam(':batch_id', $lot['id']);
                $movStmt->bindParam(':qty', $qty_taken);
                $movStmt->execute();
            }

            if ($remaining_qty > 0) {
                $this->conn->rollBack(); 
                return false;
            }

             $this->conn->commit();
            return true;

        } catch (\PDOException $e) {
            $this->conn->rollBack();
            return false;
        }
    }
}
?>