<?php
// DIMA session_start() hiya lowla f l'application
session_start();

require_once '../config/database.php';
require_once '../src/Entity/Batch.php';
require_once '../src/Repository/BatchRepository.php';
require_once '../src/Repository/UserRepository.php'; // Zdnaha
require_once '../src/Controller/DashboardController.php';
require_once '../src/Controller/StockController.php';
require_once '../src/Controller/AuthController.php'; // Zdnaha

use PharmaFEFO\Controller\DashboardController;
use PharmaFEFO\Controller\StockController;
use PharmaFEFO\Controller\AuthController;

// Ila l'utilisateur makanch mconnecté, kanbzzou 3lih ymchi l'page 'login'
$action = isset($_GET['action']) ? $_GET['action'] : 'dashboard';

// Sécurité Globale: Ila bgha ydkhl l'chi page w ma3ndoch session, ysifto l login
if (!isset($_SESSION['user_id']) && $action !== 'login' && $action !== 'login_process') {
    header("Location: index.php?action=login");
    exit();
}

switch ($action) {
    
    // Pages dyal l'Authentification
    case 'login':
        require_once '../templates/login.php';
        break;

    case 'login_process':
        $controller = new AuthController();
        $controller->loginProcess();
        break;

    case 'logout':
        $controller = new AuthController();
        $controller->logout();
        break;

    // Pages dyal l'Application (Dashboard, Stock...)
    case 'dashboard':
        $controller = new DashboardController();
        $controller->index();
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