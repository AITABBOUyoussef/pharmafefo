<?php

require_once '../config/database.php';
require_once '../src/Entity/Batch.php';
require_once '../src/Repository/BatchRepository.php';
require_once '../src/Controller/DashboardController.php';

use PharmaFEFO\Controller\DashboardController;

// Simple Routeur
$controller = new DashboardController();
$controller->index();