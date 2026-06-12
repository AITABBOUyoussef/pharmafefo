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
    /**
     * Ajoute un nouveau lot et enregistre le mouvement de stock
     */
    public function addBatch($product_id, $batch_number, $quantity, $expiration_date) {
        try {
            // 1. Kanbdaw la transaction (kima chre7na: ya kolchi ydoz ya walo)
            $this->conn->beginTransaction();

            // 2. Requête 1 : Nzidou l'Lot jdid f la table 'batches'
            $queryBatch = "INSERT INTO batches (product_id, batch_number, expiration_date, qty_received, qty_available, status) 
                           VALUES (:product_id, :batch_number, :expiration_date, :quantity, :quantity, 'ACTIVE')";
            
            $stmtBatch = $this->conn->prepare($queryBatch);
            
            // Kan-associer les variables m3a les paramètres dyal la requête (Sécurité contre SQL Injection)
            $stmtBatch->bindParam(':product_id', $product_id);
            $stmtBatch->bindParam(':batch_number', $batch_number);
            $stmtBatch->bindParam(':expiration_date', $expiration_date);
            $stmtBatch->bindParam(':quantity', $quantity); // qty_received
            
            $stmtBatch->execute();

            // Kanjebdo l'ID dyal l'Lot li yalah tzad bach nkhdmo bih f l'historique
            $newBatchId = $this->conn->lastInsertId();

            // 3. Requête 2 : Nqiyydou had l'entrée f l'historique 'stock_movements'
            // NB: Derna user_id = 1 ghir f l'exemple 7it mazal masawbnach système de Login
            $queryMovement = "INSERT INTO stock_movements (batch_id, user_id, type, quantity, note) 
                              VALUES (:batch_id, 1, 'ENTRY', :quantity, 'Réception de nouveau lot')";
            
            $stmtMovement = $this->conn->prepare($queryMovement);
            $stmtMovement->bindParam(':batch_id', $newBatchId);
            $stmtMovement->bindParam(':quantity', $quantity);
            
            $stmtMovement->execute();

            // 4. Ila kolchi daz bikhir, kan-validiw (Sauvegarder)
            $this->conn->commit();
            
            return true;

        } catch (\PDOException $e) {
            // 5. Ila w9e3at chi erreur, kan-annuliw kolchi bach tb9a la base de données nqiya
            $this->conn->rollBack();
            
            // Tqder tbiyen l'erreur l'developer awla tsjjelha f fichier log
            echo "Erreur d'insertion : " . $e->getMessage();
            return false;
        }
    }
}
?>