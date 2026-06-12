<?php
// public/index.php

// 1. Chargement dyal les fichiers (En attendant Composer)
require_once '../config/database.php';
require_once '../src/Entity/Batch.php';
require_once '../src/Repository/BatchRepository.php';
require_once '../src/Controller/DashboardController.php';
require_once '../src/Controller/StockController.php'; // Zdna l'controller jdid

use PharmaFEFO\Controller\DashboardController;
use PharmaFEFO\Controller\StockController;

// 2. L'Routeur (Kanchofo chno bgha l'utilisateur)
// Ila makant hta action f l'URL, par défaut kanmchiw l'dashboard
$action = isset($_GET['action']) ? $_GET['action'] : 'dashboard';

switch ($action) {
    
    // Page 1 : L'Dashboard (Affichage des lots w les alertes)
    case 'dashboard':
        $controller = new DashboardController();
        $controller->index();
        break;

    // Page 2 : Afficher l'formulaire dyal l'Entrée de stock
    case 'add_batch':
        require_once '../templates/add_batch.php';
        break;

    // Action 3 : Sauvegarder les données li jaw mn l'formulaire
    case 'save_batch':
        $controller = new StockController();
        $controller->saveBatch();
        break;

    // Ila l'utilisateur dkhel chi action makaynach
    default:
        echo "<h1 style='color:red; text-align:center; margin-top:50px;'>Erreur 404 : Page non trouvée !</h1>";
        break;
}
?>