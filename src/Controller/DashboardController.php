<?php
namespace PharmaFEFO\Controller;

use PharmaFEFO\Config\Database;
use PharmaFEFO\Repository\BatchRepository;

class DashboardController {
    
    public function index() {
        $database = new Database();
        $db = $database->getConnection();

        $batchRepo = new BatchRepository($db);

        $lots = $batchRepo->getLotsWithCriticality();

        require_once __DIR__ . '/../../templates/dashboard.php';
    }
}
?>