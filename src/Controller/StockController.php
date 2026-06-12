<?php
namespace PharmaFEFO\Controller;

use PharmaFEFO\Config\Database;
use PharmaFEFO\Repository\BatchRepository;

class StockController {
    public function saveBatch() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $database = new Database();
            $db = $database->getConnection();
            $batchRepo = new BatchRepository($db);

            $result = $batchRepo->addBatch(
                $_POST['product_id'], 
                $_POST['batch_number'], 
                $_POST['quantity'], 
                $_POST['expiration_date'],
                $_SESSION['user_id'] // L'utilisateur connecté
            );

            header("Location: index.php?action=dashboard" . ($result ? "&success=entry" : "&error=entry"));
            exit();
        }
    }

    public function exitStock() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $database = new Database();
            $db = $database->getConnection();
            $batchRepo = new BatchRepository($db);

            $result = $batchRepo->exitStockWithFEFO(
                $_POST['product_id'], 
                $_POST['quantity'],
                $_SESSION['user_id'] // L'utilisateur connecté
            );

            header("Location: index.php?action=dashboard" . ($result ? "&success=exit" : "&error=insufficient_stock"));
            exit();
        }
    }
}
?>