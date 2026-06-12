<?php
namespace PharmaFEFO\Controller;



use PharmaFEFO\Config\database;
use PharmaFEFO\Repository\BatchRepository;

class StockController {
    
    // Fonction li katched data mn l'formulaire w katsayviha
    public function saveBatch() {
        
        // 1. Kanchofou wach l'formulaire tsifet b tariqa s7i7a (POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // 2. Kanjm3ou les données li dkhel l'utilisateur f les khanat
            $product_id = $_POST['product_id'];
            $batch_number = $_POST['batch_number'];
            $quantity = $_POST['quantity'];
            $expiration_date = $_POST['expiration_date'];

            // 3. Kannt2akdo bli l'quantité mzyana (Machi saliba wla fiha zéro)
            if ($quantity <= 0) {
                echo "Erreur : La quantité khassha tkoun kber mn 0.";
                return;
            }

            // 4. Kantconnectaw b la base de données
            $database = new Database();
            $db = $database->getConnection();
            $batchRepo = new BatchRepository($db);

            // 5. Knsifto les données l l'Model (Repository) bach ydir INSERT f SQL
            // (Had l'methode addBatch ghanqaddoha f l'etape jaya)
            $result = $batchRepo->addBatch($product_id, $batch_number, $quantity, $expiration_date);

            if ($result) {
                // Ila kolchi daz bikhir, kanrej3o l'Dashboard
                header("Location: index.php?success=1");
                exit();
            } else {
                echo "Erreur f l'enregistrement f la base de données.";
            }
        }
    }
}
?>