<?php
session_start(); // Dima hiya lowla

// Auto-chargement manuel (Bdlh b composer autoloader mn b3d)
require_once '../config/Database.php';
require_once '../src/Repository/UserRepository.php';
require_once '../src/Repository/BatchRepository.php';
require_once '../src/Controller/AuthController.php';
require_once '../src/Controller/DashboardController.php';
require_once '../src/Controller/StockController.php';

use PharmaFEFO\Controller\AuthController;
use PharmaFEFO\Controller\DashboardController;
use PharmaFEFO\Controller\StockController;

$action = isset($_GET['action']) ? $_GET['action'] : 'dashboard';

// Sécurité: Si pas de session et bgha ydkhl lchi blasa okhra
if (!isset($_SESSION['user_id']) && $action !== 'login' && $action !== 'login_process') {
    header("Location: index.php?action=login");
    exit();
}

switch ($action) {
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
        echo "404 - Page non trouvée";
        break;
}
?>