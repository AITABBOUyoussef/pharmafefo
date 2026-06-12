<?php
require_once '../config/database.php';
require_once '../src/Entity/Batch.php';
require_once '../src/Repository/BatchRepository.php';
require_once '../src/Controller/DashboardController.php';
require_once '../src/Controller/StockController.php'; 

use PharmaFEFO\Controller\DashboardController;
use PharmaFEFO\Controller\StockController;

$action = isset($_GET['action']) ? $_GET['action'] : 'dashboard';

switch ($action) {
    
    case 'dashboard':
        $controller = new DashboardController();
        $controller->index();
        break;

        case 'add_batch':
        require_once '../templates/add_batch.php';
        break;

    case 'save_batch':
        $controller = new StockController();
        $controller->saveBatch();
        break;
       case 'exit_stock':
        $controller = new StockController();
        $controller->exitStock();
        break;

    default:
        echo "<h1 style='color:red; text-align:center; margin-top:50px;'>Erreur 404 : Page non trouvée !</h1>";
        break;
}
?>