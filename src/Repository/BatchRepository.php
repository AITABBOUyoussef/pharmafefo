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
}
?>