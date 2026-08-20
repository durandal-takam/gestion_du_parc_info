<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../models/Portail.php';

if (!estConnecte()) {
    rediriger(BASE_URL . '/views/auth/login.php');
}

$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'index':
        $affectations = Portail::mesAffectations($pdo, $_SESSION['user']['ID_USER']);
        $tickets      = Portail::mesTickets($pdo, $_SESSION['user']['ID_USER']);
        $maintenances = Portail::mesMaintenances($pdo, $_SESSION['user']['ID_USER']);
        require VIEWS_PATH . 'portail/index.php';
        break;
}