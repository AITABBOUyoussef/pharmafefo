<?php
namespace PharmaFEFO\Controller;

use PharmaFEFO\Config\Database;
use PharmaFEFO\Repository\BatchRepository;

class DashboardController {
    
    public function index() {
        // 1. Connexion b la base de données
        $database = new Database();
        $db = $database->getConnection();

        // 2. N3yeto l Repository li fih les requêtes SQL
        $batchRepo = new BatchRepository($db);

        // 3. Njebdo les lots w n7esbo chkon li 9rab ytsala
        $lots = $batchRepo->getLotsWithCriticality();

        // 4. Nsifto les données l'Wajha (View). 
        // La variable $lots ghadi tkon disponible f dashboard.php
        require_once __DIR__ . '/../../templates/dashboard.php';
    }
}
?>