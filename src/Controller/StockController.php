<?php
namespace PharmaFEFO\Controller;



use PharmaFEFO\Config\database;
use PharmaFEFO\Repository\BatchRepository;

class StockController {
    
   
 public function saveBatch() {
        
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $product_id = $_POST['product_id'];
            $batch_number = $_POST['batch_number'];
            $quantity = $_POST['quantity'];
            $expiration_date = $_POST['expiration_date'];

             if ($quantity <= 0) {
                echo "Erreur : La quantité khassha tkoun kber mn 0.";
                return;
            }

            $database = new Database();
            $db = $database->getConnection();
            $batchRepo = new BatchRepository($db);

            $result = $batchRepo->addBatch($product_id, $batch_number, $quantity, $expiration_date);

            if ($result) {
                
        header("Location: index.php?success=1");
                exit();
            } else {
                echo "Erreur f l'enregistrement f la base de données.";
            }
        }
    }

     public function exitStock() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $product_id = $_POST['product_id'];
            $quantity = $_POST['quantity'];

               if ($quantity <= 0) {
                header("Location: index.php?action=dashboard&error=qty_invalid");
                exit();
            }

            $database = new \PharmaFEFO\Config\Database();
            $db = $database->getConnection();
            $batchRepo = new \PharmaFEFO\Repository\BatchRepository($db);
           $result = $batchRepo->exitStockWithFEFO($product_id, $quantity);

             if ($result) {
                header("Location: index.php?action=dashboard&success=exit_ok");
            } else {
                header("Location: index.php?action=dashboard&error=stock_insuffisant");
            }
            exit();
        }
    }
}
?>