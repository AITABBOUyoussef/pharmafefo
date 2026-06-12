<?php
namespace PharmaFEFO\Controller;

use PharmaFEFO\Config\Database;
use PharmaFEFO\Repository\MovementRepository;

class HistoryController {
    
    public function index() {
         $database = new Database();
        $db = $database->getConnection();
        
        $movementRepo = new MovementRepository($db);
        
        $movements = $movementRepo->getAllMovements();
        
        require_once '../templates/history.php';
    }
}
?>