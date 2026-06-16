<?php
session_start(); 

// 1. Charger l'environnement
require_once '../config/environment.php';
\PharmaFEFO\Config\Environment::load(__DIR__ . '/../.env');

require_once '../config/Database.php';
require_once '../src/Repository/UserRepository.php';
require_once '../src/Repository/BatchRepository.php';
require_once '../src/Repository/ProductRepository.php';
require_once '../src/Repository/MovementRepository.php';

// Les Web Controllers (HTML)
require_once '../src/Controller/Web/AuthController.php';
require_once '../src/Controller/Web/DashboardController.php';
require_once '../src/Controller/Web/StockController.php';
require_once '../src/Controller/Web/HistoryController.php';

// ZEDNA L'API CONTROLLER HNA
require_once '../src/Controller/Api/ApiStockController.php';

use PharmaFEFO\Controller\Web\HistoryController;
use PharmaFEFO\Controller\Web\AuthController;
use PharmaFEFO\Controller\Web\DashboardController;
use PharmaFEFO\Controller\Web\StockController;

// ZEDNA L'USE DYAL API HNA
use PharmaFEFO\Controller\Api\ApiStockController;

$action = isset($_GET['action']) ? $_GET['action'] : 'dashboard';

// Sécurité
if (!isset($_SESSION['user_id']) && $action !== 'login' && $action !== 'login_process') {
    header("Location: index.php?action=login");
    exit();
}

switch ($action) {
    // --- ROUTES WEB (HTML) ---
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
    case 'save_batch': // Hada lqdim, tqder tkhelih wla tms7o mn b3d
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

    // --- ROUTES API (JSON) HADO LI TZADOU ---
    // case 'api_add_batch':
    //     $controller = new ApiStockController();
    //     $controller->addBatch();
    //     break;

    default:
        echo "404 - Page non trouvée";
        break;
}
?>