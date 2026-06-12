<?php
session_start(); 

require_once '../config/Database.php';
require_once '../src/Repository/UserRepository.php';
require_once '../src/Repository/BatchRepository.php';
require_once '../src/Repository/ProductRepository.php';
require_once '../src/Controller/AuthController.php';
require_once '../src/Controller/DashboardController.php';
require_once '../src/Controller/StockController.php';
require_once '../src/Repository/MovementRepository.php';
require_once '../src/Controller/HistoryController.php';


use PharmaFEFO\Controller\HistoryController;
use PharmaFEFO\Controller\AuthController;
use PharmaFEFO\Controller\DashboardController;
use PharmaFEFO\Controller\StockController;

$action = isset($_GET['action']) ? $_GET['action'] : 'dashboard';

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
     
    case 'history':
        $controller = new HistoryController();
        $controller->index();
        break;
    default:
        echo "404 - Page non trouvée";
        break;
}
?>