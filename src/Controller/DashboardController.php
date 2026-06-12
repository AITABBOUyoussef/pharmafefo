<?php
namespace PharmaFEFO\Controller;

use PharmaFEFO\Config\Database;
use PharmaFEFO\Repository\BatchRepository;

class DashboardController {
    public function index() {
        $database = new Database();
        $db = $database->getConnection();
        $batchRepo = new BatchRepository($db);

        $rawLots = $batchRepo->getAllActiveLots();
        $lots = [];

        // Traitement des couleurs (Criticité)
        foreach ($rawLots as $lot) {
            $days = $lot['days_to_expire'];
            if ($days <= 30) {
                $lot['criticality_level'] = 'RED';
                $lot['criticality_label'] = 'Critique (< 1 mois)';
            } elseif ($days <= 90) {
                $lot['criticality_level'] = 'ORANGE';
                $lot['criticality_label'] = 'Attention (< 3 mois)';
            } else {
                $lot['criticality_level'] = 'GREEN';
                $lot['criticality_label'] = 'Bon';
            }
            $lots[] = $lot;
        }

        require_once '../templates/dashboard.php';
    }
}
?>